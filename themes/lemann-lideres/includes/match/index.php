<?php
defined( 'ABSPATH' ) || exit;

define('LEMANN_FIELD_ABERTO_PARA_VAGAS', 648);

/**
 * Índice: ID do campo no WP Job Manager,
 * Valor: ID do campo no BuddyPress.
 */
define( 'LEMANN_VAGAS_DE_PARA', [
	'setor_atuacao'      => 677,
	'area_atuacao'       => 654,
	// 'disponibilidade'    => 1526,
	'graduacao'          => 693,
	'experiencia'        => 694,
	'experiencia_gestao' => 699,
	'faixa_salarial'     => 815,
	'localizacao_geo'    => 710,
] );

/**
 * User meta key usada para guardar os matches com as vagas.
 */
define( 'LEMANN_MATCHES_META_KEY', 'job_listings_matches' );

/**
 * Mínimo necessário para enviar um e-mail para o usuário.
 */
define( 'LEMANN_MATCH_MINIMO_EMAIL', 70 );

/**
 * ID do campo com o e-mail de contato para Vagas/Carreira.
 * Se o campo estiver vazio usa o e-mail do usuário no WP.
 */
define( 'LEMANN_MATCH_BP_CAMPO_EMAIL', 1501 );

function _match_log($message, $breakline = false){
    $message = $breakline ? "\n\n{$message}" : " {$message}";
    if(class_exists('WP_CLI')){
        echo $message;
    }
}

/**
 * Define a porcentagem de correspondência entre uma vaga e um usuário.
 *
 * @param int  $post_id ID da vaga.
 * @param int  $user_id ID do usuário.
 */
function lemann_match( $post_id, $user_id ) {
	set_time_limit( 5 );

	$possible_matches = 0;
	$real_matches     = 0;

	foreach ( LEMANN_VAGAS_DE_PARA as $wpjm_id => $bp_id ) {
		$job_listing_data = get_post_meta( $post_id, "_{$wpjm_id}", true );

		if ( 'graduacao' == $wpjm_id ) {
			$user_data = BP_XProfile_ProfileData::get_value_byid( $bp_id, $user_id );
			$user_data = Lemann_Field_Graduacao::unserialize( $user_data );
		} else {
			$user_data = xprofile_get_field_data( $bp_id, $user_id );
        }

        // var_Dump([$job_listing_data, $user_data]);

		switch ( $wpjm_id ) {
			// Campos de vaga multivalorados.
			case 'setor_atuacao':
			case 'area_atuacao':
            case 'localizacao_geo':
                $possible_matches++;
                $first_match = true;

                $job_listing_data = array_map(function ($item) { return strtolower($item); }, (array) $job_listing_data);
                $user_data = array_map(function ($item) { return strtolower($item); }, (array) $user_data);

				foreach ( $job_listing_data as $possible_value ) {
                    $possible_matches += .3;
					if ( $user_data && in_array( $possible_value, $user_data ) ) {
                        if($first_match){
                            $real_matches++;
                            $first_match = false;
                        }
                        $real_matches += .3;
                        // _match_log("\t[match $wpjm_id ($possible_value)]", true);
					}
				}
				break;

			case 'graduacao':
				$possible_matches++;
				if ( $user_data && is_array( $user_data ) && ! empty( $user_data[0] ) ) {
					foreach ( $user_data as $graduacao ) {
						if ( strtolower($graduacao['nivel']) == strtolower($job_listing_data) ) {
                            $real_matches++;
                            // _match_log("\t[match $wpjm_id ({$graduacao['nivel']})]", true);
							break;
						}
					}
				}
				break;

			default:
				$possible_matches++;
				if ( $user_data &&  strtolower($job_listing_data) == strtolower($user_data) ) {
                    $real_matches++;
                    // _match_log("\t[match $wpjm_id ($user_data)]", true);
				} 
				break;
		}
	}

    $match = ( $real_matches / $possible_matches ) * 100;

	$matches    = (array) get_user_meta( $user_id, LEMANN_MATCHES_META_KEY, true );
    $email_sent = ( isset( $matches[ $post_id ] ) ) ? $matches[ $post_id ]['email_sent'] : false;
    
    $aberto_para_vagas = BP_XProfile_ProfileData::get_value_byid( LEMANN_FIELD_ABERTO_PARA_VAGAS, $user_id );
    _match_log(" [[$aberto_para_vagas está aberto para vagas]]");
    if ($aberto_para_vagas == 'Sim' && $match >= LEMANN_MATCH_MINIMO_EMAIL && ! $email_sent) {
        _match_log('MATCH!!!!');

        $user_email = xprofile_get_field_data( LEMANN_MATCH_BP_CAMPO_EMAIL, $user_id );
        if ( ! is_email( $user_email ) ) {
            $user       = get_user_by( 'id', $user_id );
            $user_email = $user->user_email;
        }

        // @todo comentar esta linha depois de testar e publicar em prod
        $user_email = @$_ENV['MATCH_EMAIL_TO'];

        if($user_email){
            /*
             * Pega o template e resolve as variáveis através do Mustache.
             *
             * @see https://github.com/bobthecow/mustache.php
             */
            require_once 'class-lemann-mustache.php';
            $lemann_mustache  = Lemann_Mustache::get_instance();
            $message_template = file_get_contents( get_stylesheet_directory() . '/includes/match/template-email.php' );
            $job              = get_post( $post_id );
            $message_vars     = [
                'match'        => round( $match ),
                'company_logo' => get_the_company_logo( $post_id, 'full' ),
                'company_name' => get_post_meta( $post_id, '_company_name', true ),
                'job_title'    => get_the_title( $post_id ),
                'location'     => get_post_meta( $post_id, '_job_location', true ),
                'description'  => $job->post_content,
                'job_url'      => get_the_permalink( $post_id ),
            ];
            $message_body     = $lemann_mustache->parse( $message_template, $message_vars );

            wp_mail(
                $user_email,
                __( 'Nova vaga no Portal de Líderes da Fundação Lemann', 'lemann-lideres' ),
                $message_body,
                [ 'Content-Type: text/html; charset=UTF-8' ]
            );

            _match_log('[email sent]');

            $email_sent = true;
        }

    }

	$matches[ $post_id ] = [
		'match'      => $match,
		'date'       => date_i18n( 'c' ),
		'email_sent' => $email_sent,
	];
	update_user_meta( $user_id, LEMANN_MATCHES_META_KEY, $matches );

    return $match;
}


/**
* Ao atualizar o job define a flag que faz o match ser executado
 */
add_action( 'save_post_job_listing', function( $post_id, $post, $update ) {
	if ( $update ) {
        update_post_meta($post_id, 'awaiting-match', 1);
	}
}, 10, 3 );

/**
 * Ao atualizar o perfil define a flag que faz o match ser executado
 */
add_action( 'xprofile_updated_profile', function( $user_id ) {
	update_user_meta($user_id, 'awaiting-match', 1);
} );


/**
 * Executa o match nos jobs e usuários que tiveram modidicações
 *
 */
function lemann_do_matches(){
    if(!@$_ENV['MATCH_ENABLED']){
        _match_log('MATCH IS DISABLED', true);
        return;
    }

    /**
     * @var wpdb;
     */
    global $wpdb;

    $meta_key = 'awaiting-match';

    $awaiting_jobs = $wpdb->get_col("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '$meta_key'");
    $awaiting_users = $wpdb->get_col("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '$meta_key'");

    $users = get_users( [
        'role__in' => [ 'lider', 'administrator' ],
        'fields'   => 'ID',
    ] );

    $jobs = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_type = 'job_listing' AND post_status = 'publish'");

    $processed = [];

    foreach($awaiting_jobs as $job_id){
        foreach($users as $user_id){
            $processed_key = "{$job_id}:{$user_id}";
            if(!@$processed[$processed_key]){
                _match_log("MATCHING JOB $job_id WITH USER $user_id", true);
                $match = lemann_match($job_id, $user_id);
                _match_log(number_format($match,1) . '%');

                delete_post_meta($job_id, $meta_key);
            }
            $processed[$processed_key] = true;
        }
    }

    foreach($awaiting_users as $user_id){
        foreach($jobs as $job_id){
            $processed_key = "{$job_id}:{$user_id}";
            if(!@$processed[$processed_key]){
                _match_log("MATCHING JOB $job_id WITH USER $user_id", true);
                $match = lemann_match($job_id, $user_id);
                _match_log(number_format($match,1) . '%');

                delete_user_meta($user_id, $meta_key);
            }
            $processed[$processed_key] = true;
        }
    }

    _match_log("MATCH FINISHED\n", true);
}

if(class_exists('WP_CLI')){
    WP_CLI::add_command( 'do-matches', 'lemann_do_matches');
}

if(isset($_GET['lemann-action']) && $_GET['lemann-action'] == 'do-matches'){
    do_action('init', function(){
        lemann_do_matches();
    });
}
