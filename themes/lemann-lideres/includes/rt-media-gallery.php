<?php
/**
 * Arquivos que alteram o funcionamento do widget do RT Media,
 * para que a galeria só exiba fotos publicadas em grupos.
 */

add_action( 'rtmedia_before_gallery_widget_content', 'lemann_rtmedia_widget_add_filters' );
add_action( 'rtmedia_after_gallery_widget_content', 'lemann_rtmedia_widget_remove_filters' );
function lemann_rtmedia_widget_add_filters() {
    add_filter( 'rtmedia-model-where-query', 'lemann_rtmedia_model_where_query' );
    add_filter( 'rtmedia-model-join-query', 'lemann_rtmedia_model_join_query', 10, 2 );
}
function lemann_rtmedia_widget_remove_filters() {
    remove_filter( 'rtmedia-model-where-query', 'lemann_rtmedia_model_where_query' );
    remove_filter( 'rtmedia-model-join-query', 'lemann_rtmedia_model_join_query', 10, 2 );
}

function lemann_rtmedia_model_where_query( $where ) {
    $where .= " AND bpact.component = 'groups' ";
    return $where;
}

function lemann_rtmedia_model_join_query( $join, $table_name ) {
    $activity_table_name = bp_core_get_table_prefix() . 'bp_activity';
    $join .= " LEFT JOIN {$activity_table_name} as bpact ON {$table_name}.activity_id = bpact.id ";
    return $join;
}
