<?php
defined( 'ABSPATH' ) || exit;

function lemann_wjm_custom_fields() {
	return [
		'responsavel_nome'   => [
			'label'    => __( 'Responsável pela postagem (nome completo)', 'lemann-lideres' ),
			'type'     => 'text',
			'required' => true,
		],
		'responsavel_email'  => [
			'label'     => __( 'Contato do responsável (e-mail)', 'lemann-lideres' ),
			'type'      => 'email',
			'required'  => true,
			'sanitizer' => 'email',
		],
		'setor_atuacao'      => [
			'label'    => __( 'Setor de atuação', 'lemann-lideres' ),
			'type'     => 'multiselect',
			'required' => true,
			'options'  => [
				'Setor Público'          => 'Setor Público',
				'Terceiro Setor'         => 'Terceiro Setor',
				'Setor Privado'          => 'Setor Privado',
				'Organismo Multilateral' => 'Organismo Multilateral',
				'Outros'                 => 'Outros',
			],
		],
		'setor_atuacao_outros'   => [
			'label' => __( 'Outro setor de atuação', 'lemann-lideres' ),
			'type'  => 'text',
		],
		'area_atuacao'       => [
			'label'    => __( 'Área de atuação', 'lemann-lideres' ),
			'type'     => 'multiselect',
			'required' => true,
			'options'  => [
				'Educação'                  => 'Educação',
				'Saúde'                     => 'Saúde',
				'Gestão Pública'            => 'Gestão Pública',
				'Direitos Humanos'          => 'Direitos Humanos',
				'Ciência'                   => 'Ciência',
				'Segurança Pública'         => 'Segurança Pública',
				'Empreendedorismo'          => 'Empreendedorismo',
				'Democracia e Política'     => 'Democracia e Política',
				'Sustentabilidade'          => 'Sustentabilidade',
				'Desenvolvimento Econômico' => 'Desenvolvimento Econômico',
				'Outros'                    => 'Outros',
			],
		],
		'area_atuacao_outros'   => [
			'label' => __( 'Outra área de atuação', 'lemann-lideres' ),
			'type'  => 'text',
		],
		'disponibilidade'    => [
			'label'    => __( 'Disponibilidade de início', 'lemann-lideres' ),
			'type'     => 'select',
			'required' => true,
			'options'  => [
				'Imediato'              => 'Imediato',
				'Curto prazo (2 meses)' => 'Curto prazo (2 meses)',
				'Longo prazo (6 meses)' => 'Longo prazo (6 meses)',
			],
		],
		'graduacao'          => [
			'label'    => __( 'Nível de Graduação', 'lemann-lideres' ),
			'type'     => 'select',
			'required' => true,
			'options'  => [
				'Graduação'     => 'Graduação',
				'Pós-graduação' => 'Pós-graduação',
				'Mestrado'      => 'Mestrado',
				'Doutorado'     => 'Doutorado',
				'Pós-Doutorado' => 'Pós-Doutorado',
				'Outros'        => 'Outros',
			],
		],
		'graduacao_outros'   => [
			'label' => __( 'Outro nível de graduação', 'lemann-lideres' ),
			'type'  => 'text',
		],
		'experiencia'        => [
			'label'    => __( 'Experiência profissional', 'lemann-lideres' ),
			'type'     => 'select',
			'required' => false,
			'options'  => [
				'Nenhuma experiência'           => 'Nenhuma experiência',
				'até 2 anos'          => 'até 2 anos',
				'3 a 5 anos'            => '3 a 5 anos',
				'6 a 9 anos'            => '6 a 9 anos',
				'mais de 10 anos'  => 'mais de 10 anos',
			],
		],
		'experiencia_gestao' => [
			'label'    => __( 'Experiência em gestão de pessoas', 'lemann-lideres' ),
			'type'     => 'select',
			'required' => false,
			'options'  => [
				'Nenhuma experiência'           => 'Nenhuma experiência',
				'até 2 anos'          => 'até 2 anos',
				'3 a 5 anos'            => '3 a 5 anos',
				'6 a 9 anos'            => '6 a 9 anos',
				'mais de 10 anos' 	 => 'mais de 10 anos',
			],
		],
		'faixa_salarial'     => [
			'label'    => __( 'Faixa salarial (mensal)', 'lemann-lideres' ),
			'type'     => 'select',
			'required' => false,
			'options'  => [
				'NA'                      => 'NA',
				'Menos de 5 mil reais'    => 'Menos de 5 mil reais',
				'Entre 5 a 7 mil reais'   => 'Entre 5 a 7 mil reais',
				'Entre 7 e 10 mil reais'  => 'Entre 7 e 10 mil reais',
				'Entre 10 e 15 mil reais' => 'Entre 10 e 15 mil reais',
				'Mais que 20 mil reais'   => 'Mais que 20 mil reais',
			],
		],
		'localizacao_geo' => [
			'label'    => __('Posição de trabalho', 'lemann-lideres'),
			'type'     => 'select',
			'required' => true,
			'options'  => [
				'Nacional (país em que reside)' => 'Nacional (país em que reside)',
				'Estado Atual em que reside'	=> 'Estado Atual em que reside',
                'Municipio Atual em que reside' => 'Municipio Atual em que reside',
                'Não presencial'                => 'Não presencial'
			],
		],
		'localizacao_pais' => [
			'label'    => __( 'País', 'lemann-lideres' ),
			'type'     => 'text',
		],
		'localizacao_estado' => [
			'label'    => __( 'Estado', 'lemann-lideres' ),
			'type'     => 'text',
		],
		'localizacao_cidade' => [
			'label'    => __( 'Cidade', 'lemann-lideres' ),
			'type'     => 'text',
		],
		'prazo_inscricao' => [
			'label'	   => __('Prazo para inscrição', 'lemann-lideres'),
			'type' 	   => 'date',
			'required' => true,
		],
		'anexo' => [
			'label' => __('Inclua um anexo para complementar a descrição da vaga', 'lemann-lideres'),
			'type'  => 'file',
		],
	];
}

add_filter( 'submit_job_form_fields', function( $fields ) {
	$custom_fields = lemann_wjm_custom_fields();
	foreach ( $custom_fields as $key => $field ) {
		$field['priority']     = 2;
		$fields['job'][ $key ] = $field;
	}

	unset( $fields['company']['company_tagline'] );
	unset( $fields['company']['company_video'] );
	unset( $fields['company']['company_twitter'] );

	return $fields;
} );

add_filter( 'job_manager_job_listing_data_fields', function( $fields ) {
	$custom_fields = lemann_wjm_custom_fields();

	$i = 0;
	foreach ( $custom_fields as $key => $field ) {
		$field['priority']    = 20 + $i++;
		$field['type']        = ( 'email' != $field['type'] ) ? $field['type'] : 'text';
		$fields[ '_' . $key ] = $field;
	}

	unset( $fields['_company_tagline'] );
	unset( $fields['_company_video'] );
	unset( $fields['_company_twitter'] );

	return $fields;
} );


add_filter( 'script_loader_src', function ( $src, $handle ) {
	if ( 'chosen' == $handle ) {
		$src = get_stylesheet_directory_uri() . '/assets/js/jquery-chosen/chosen.jquery.min.js';
	}
	return $src;
}, 10, 2 );

/**
 * Preenche o campo de localização padrão do WP Job Manager
 * com os campos personalizados de país, estado e cidade.
 */
add_action( 'init', function() {
	if ( isset( $_POST['job_location'] ) && isset( $_POST['localizacao_pais'] ) ) {
		$_POST['job_location'] = $_POST['localizacao_pais'];
		if ( ! empty( $_POST['localizacao_estado'] ) ) {
			$_POST['job_location'] .= ' - ' . $_POST['localizacao_estado'];
			if ( ! empty( $_POST['localizacao_cidade'] ) ) {
				$_POST['job_location'] .= ' - ' . $_POST['localizacao_cidade'];
			}
		}
	}
} );
/**
 * Altera o parâmetro de ordenação na query das vagas para
 * passar a usar o valor de match entre o usuário e as vagas.
 */
add_filter( 'job_manager_get_listings_args', function( $args ) {
    global $wpdb;

    $ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_type = 'job_listing' AND post_status = 'publish' ORDER BY ID DESC");
    
    $matches = get_user_meta( get_current_user_id(), LEMANN_MATCHES_META_KEY, true );
	$matches = wp_list_sort( $matches, 'match', 'DESC', true );
    $matches = array_keys( $matches );
    
    foreach($ids as $id){
        if(!in_array($id, $matches)){
            $matches[] = $id;
        }
    }

	$args['post__in'] = $matches;
	$args['orderby']  = 'post__in';
	$args['order']    = 'ASC';

	return $args;
} );

/**
 * Passa o parâmetro `post__in` para a query (ele é eliminado por padrão).
 */
add_filter( 'job_manager_get_listings', function( $query_args, $args ) {
	if ( isset( $args['post__in'] ) ) {
		$query_args['post__in'] = $args['post__in'];
	}
	return $query_args;
}, 10, 2 );
