<?php
defined( 'ABSPATH' ) || exit;

/**
 * Índice: ID do campo no WP Job Manager,
 * Valor: ID do campo no BuddyPress.
 */
define( 'LEMANN_VAGAS_DE_PARA', [
	'setor_atuacao'      => 1502,
	'area_atuacao'       => 1513,
	'disponibilidade'    => 1526,
	'graduacao'          => 1497,
	'experiencia'        => 1531,
	'experiencia_gestao' => 1536,
	'faixa_salarial'     => 1542,
	'localizacao_geo'    => 1548,
] );

define( 'LEMANN_MATCHES_META_KEY', 'job_listings_matches' );

define( 'LEMANN_MATCH_MINIMO_EMAIL', 70 );

/**
 * Define a porcentagem de correspondência entre uma vaga e um usuário.
 *
 * @param int  $post_id ID da vaga.
 * @param int  $user_id ID do usuário.
 * @param bool $send_email Se deve ou não enviar um e-mail para o usuário.
 */
function lemann_match( $post_id, $user_id, $send_email = false ) {
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

		switch ( $wpjm_id ) {
			// Campos de vaga multivalorados.
			case 'setor_atuacao':
			case 'area_atuacao':
			case 'localizacao_geo':
				foreach ( (array) $job_listing_data as $possible_value ) {
					$possible_matches++;
					if ( in_array( $possible_value, (array) $user_data ) ) {
						$real_matches++;
					}
				}
				break;

			case 'graduacao':
				$possible_matches++;
				if ( is_array( $user_data ) && ! empty( $user_data[0] ) ) {
					foreach ( $user_data as $graduacao ) {
						if ( $graduacao['nivel'] == $job_listing_data ) {
							$real_matches++;
							break;
						}
					}
				}
				break;

			default:
				$possible_matches++;
				if ( $job_listing_data == $user_data ) {
					$real_matches++;
				}
				break;
		}
	}

	$match = ( $real_matches / $possible_matches ) * 100;

	// To Do: Tirar esse teste com o ID do usuário.
	if ( 1 == $user_id ) {
		if ( $send_email && $match >= LEMANN_MATCH_MINIMO_EMAIL ) {
			$user = get_user_by( 'id', $user_id );
			wp_mail(
				$user->user_email,
				__( 'Nova vaga no Portal de Líderes da Fundação Lemann', 'lemann-lideres' ),
				sprintf(
					__(
						'<p>Temos uma nova vaga no Portal de Líderes da Fundação Lemann:</p>' .
						'<p><strong>%1$s</strong> na %2$s</p>' .
						'<p>Acesse: <a href="%3$s">%3$s</a></p>',
						'lemann-lideres'
					),
					get_the_title( $post_id ),
					get_the_company_name( $post_id ),
					get_the_permalink( $post_id )
				),
				[ 'Content-Type: text/html; charset=UTF-8' ]
			);
		}
	}

	$matches = (array) get_user_meta( $user_id, LEMANN_MATCHES_META_KEY, true );
	$matches[ $post_id ] = [
		'match' => $match,
		'date'  => date_i18n( 'c' ),
	];
	update_user_meta( $user_id, LEMANN_MATCHES_META_KEY, $matches );
}

/**
 * Ao salvar uma vaga, se ela estiver publicada
 * faz a correspondência com todos os usuários líderes.
 */
add_action( 'save_post_job_listing', function( $post_id ) {
	if ( 'publish' == get_post_status( $post_id ) ) {
		$users = get_users( [
			'role__in' => [ 'lider', 'administrator' ],
			'fields'   => 'ID',
		] );
		foreach ( $users as $user_id ) {
			lemann_match( $post_id, $user_id, true );
		}
	}
} );

/**
 * Ao atualizar o perfil, faz a correspondência com todas as vagas.
 */
add_action( 'xprofile_updated_profile', function( $user_id ) {
	$job_listings = get_posts( [
		'post_type'   => 'job_listing',
		'numberposts' => -1,
	] );
	foreach ( $job_listings as $job_listing ) {
		lemann_match( $job_listing->ID, $user_id );
	}
} );
