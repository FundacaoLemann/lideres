<?php
defined( 'ABSPATH' ) || exit;

/**
 * Adiciona o campo `Grupo da Timeline` na página BuddyPress -> General, nas opções do Tema.
 */
add_filter( 'redux/options/ghostpool_aardvark/section/bp_general_options', function ( $section ) {
    $groups_list = groups_get_groups( array(
        'orderby'  => 'ASC',
        'order'    => 'name',
        'per_page' => 9999,
    ) );
    array_unshift( $section['fields'], [
        'id'      => 'lemann_timeline_group',
        'title'   => esc_html__( 'Grupo da Timeline', 'lemann-lideres' ),
        'type'    => 'select',
        'options' => wp_list_pluck( $groups_list['groups'], 'name', 'id' ),
    ] );
    return $section;
} );

/**
 * Não exibe o grupo Timeline nas listas de grupos fora do Painel.
 */
add_filter( 'bp_before_has_groups_parse_args', function ( $r ) {
    if ( ! is_admin() ) {
        $r['exclude'] = ghostpool_option( 'lemann_timeline_group' );
    }
    return $r;
} );
