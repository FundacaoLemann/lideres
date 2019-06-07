<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {

	$labels = [
		'name'               => 'Oportunidades',
		'singular_name'      => 'Oportunidade',
		'add_new'            => 'Adicionar nova',
		'add_new_item'       => 'Nova oportunidade',
		'edit_item'          => 'Editar oportunidade',
		'new_item'           => 'Nova oportunidade',
		'all_items'          => 'Oportunidades',
		'view_item'          => 'Ver oportunidade',
		'search_items'       => 'Procurar oportunidade',
		'not_found'          => 'Nenhuma oportunidade encontrada',
		'not_found_in_trash' => 'Nenhuma oportunidade encontrada na lixeira',
		'parent_item_colon'  => '',
		'menu_name'          => 'Oportunidades',
	];

	$args = [
		'labels'              => $labels,
		'public'              => true,
		'exclude_from_search' => false,
		'public_queryable'    => true,
		'show_ui'             => true,
		'show_in_rest'		  => true,
		'query_var'           => true,
		'rewrite'             => true,
		'hierarchical'        => false,
		'supports'            => [
			'title',
			'editor',
			'author',
			'excerpt',
			'thumbnail',
		],
		'menu_icon'           => 'dashicons-megaphone',
		'has_archive'         => false,
		'capability_type'     => ['oportunidade', 'oportunidades'],
		'map_meta_cap'        => true,
	];

	register_post_type( 'oportunidade', $args );
}, 0 );
