<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {

	$labels = [
		'name'               => 'Jornadas',
		'singular_name'      => 'Jornada',
		'add_new'            => 'Adicionar nova',
		'add_new_item'       => 'Nova jornada',
		'edit_item'          => 'Editar jornada',
		'new_item'           => 'Nova jornada',
		'all_items'          => 'Jornadas',
		'view_item'          => 'Ver jornada',
		'search_items'       => 'Procurar jornada',
		'not_found'          => 'Nenhuma jornada encontrada',
		'not_found_in_trash' => 'Nenhuma jornada encontrada na lixeira',
		'parent_item_colon'  => '',
		'menu_name'          => 'Jornadas',
	];

	$args = [
		'labels'              => $labels,
		'public'              => true,
		'show_in_rest'		  => true,
		'exclude_from_search' => false,
		'public_queryable'    => true,
		'show_ui'             => true,
		'query_var'           => true,
		'rewrite'             => true,
		'hierarchical'        => false,
		'supports'            => [
			'title',
			'editor',
			'comments',
			'author',
			'excerpt',
			'thumbnail',
		],
		'menu_icon'           => 'dashicons-businessman',
		'has_archive'         => false,
	];

	register_post_type( 'jornada', $args );
}, 0 );
