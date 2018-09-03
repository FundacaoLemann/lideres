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

/**
 * Altera texto da "ação" da atividade, caso tenha sido publicação
 * no grupo Timeline.
 */
add_filter( 'bp_get_activity_action', function( $data, $act, $r ) {
    if ( 'groups' == $act->component && ghostpool_option( 'lemann_timeline_group' ) == $act->item_id ) {
        return sprintf(
            __( '%s publicou uma atualização na Timeline', 'lemann-lideres' ),
            bp_core_get_userlink( $act->user_id )
        );
    }
    return $data;
}, 10, 3 );

/**
 * Força o usuário a fazer parte do grupo da Timeline a cada login.
 * O próprio BuddyPress cuida da verificação de redundância.
 */
add_action( 'wp_login', function( $user_login, $user ) {
    groups_join_group( ghostpool_option( 'lemann_timeline_group' ), $user->ID );
}, 10, 2 );
