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
			'label' => __( 'Outros (especifique)', 'lemann-lideres' ),
			'type'  => 'text',
		],
		'experiencia'        => [
			'label'    => __( 'Experiência profissional', 'lemann-lideres' ),
			'type'     => 'select',
			'required' => false,
			'options'  => [
				'Pequena (até 2 anos)'         => 'Pequena (até 2 anos)',
				'Média (3 a 5 anos)'           => 'Média (3 a 5 anos)',
				'Longa (6 a 9 anos)'           => 'Longa (6 a 9 anos)',
				'Experiente (mais de 10 anos)' => 'Experiente (mais de 10 anos)',
			],
		],
		'experiencia_gestao' => [
			'label'    => __( 'Experiência em gestão de pessoas', 'lemann-lideres' ),
			'type'     => 'select',
			'required' => false,
			'options'  => [
				'Pequena (até 2 anos)'         => 'Pequena (até 2 anos)',
				'Média (3 a 5 anos)'           => 'Média (3 a 5 anos)',
				'Longa (6 a 9 anos)'           => 'Longa (6 a 9 anos)',
				'Experiente (mais de 10 anos)' => 'Experiente (mais de 10 anos)',
			],
		],
		'faixa_salarial'     => [
			'label'    => __( 'Faixa salarial', 'lemann-lideres' ),
			'type'     => 'select',
			'required' => false,
			'options'  => [
				'Menos de 5 mil reais'    => 'Menos de 5 mil reais',
				'Entre 5 e 7 mil reais'   => 'Entre 5 e 7 mil reais',
				'Entre 7 e 10 mil reais'  => 'Entre 7 e 10 mil reais',
				'Entre 10 e 15 mil reais' => 'Entre 10 e 15 mil reais',
				'Mais que 20 mil reais'   => 'Mais que 20 mil reais',
			],
		],
		'localizacao_geo'    => [
			'label'    => __( 'Disponibilidade de localização geográfica', 'lemann-lideres' ),
			'type'     => 'multiselect',
			'required' => true,
			'options'  => [
				'Nacional'        => 'Nacional',
				'Estado atual'    => 'Estado atual',
				'Município atual' => 'Município atual',
				'Não presencial'  => 'Não presencial',
			],
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
