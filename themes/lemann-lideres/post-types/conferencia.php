<?php
add_action( 'init', function() {

	$labels = [
		'name'               => 'Conferência',
		'singular_name'      => 'Conferência',
		'add_new'            => 'Adicionar nova',
		'add_new_item'       => 'Nova conferência',
		'edit_item'          => 'Editar conferência',
		'new_item'           => 'Nova conferência',
		'all_items'          => 'Conferências',
		'view_item'          => 'Ver conferência',
		'search_items'       => 'Procurar conferência',
		'not_found'          => 'Nenhuma conferência encontrada',
		'not_found_in_trash' => 'Nenhuma conferência encontrada na lixeira',
		'parent_item_colon'  => '',
		'menu_name'          => 'Conferências',
	];

	$args = [
		'labels'              => $labels,
		'public'              => true,
		'exclude_from_search' => false,
		'public_queryable'    => true,
		'show_ui'             => true,
		'query_var'           => true,
		'rewrite'             => true,
		'hierarchical'        => false,
		'supports'            => [ 'title' ],
		'menu_icon'           => 'dashicons-calendar',
		'has_archive'         => false,
	];

	register_post_type( 'conferencia', $args );
}, 0 );
