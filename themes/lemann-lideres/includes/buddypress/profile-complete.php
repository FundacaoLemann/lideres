<?php
defined( 'ABSPATH' ) || exit;

/**
 * Verifica se o usuário ainda tem campos obrigatórios não preenchidos.
 *
 * @return int|null
 */
function lemann_check_required_fields() {
	global $wpdb;

	$user_id = get_current_user_id();

	$bp_prefix       = $wpdb->prefix;
	$xprofile_fields = $wpdb->get_var( "SELECT group_id FROM {$bp_prefix}bp_xprofile_fields WHERE parent_id = 0 AND is_required = 1 AND id NOT IN (SELECT field_id FROM {$bp_prefix}bp_xprofile_data WHERE user_id = {$user_id} AND `value` IS NOT NULL AND `value` != '') LIMIT 1" );

	return $xprofile_fields;
}


/**
 * Verifica se o usuário ainda tem algum campo não preenchido.
 *
 * @return int|null
 */
function lemann_check_all_fields() {
	global $wpdb;

	$user_id = get_current_user_id();

	$bp_prefix       = $wpdb->prefix;
	$xprofile_fields = $wpdb->get_var( "SELECT group_id FROM {$bp_prefix}bp_xprofile_fields WHERE parent_id = 0 AND id NOT IN (SELECT field_id FROM {$bp_prefix}bp_xprofile_data WHERE user_id = {$user_id} AND `value` IS NOT NULL AND `value` != '') LIMIT 1" );

	return $xprofile_fields;
}
