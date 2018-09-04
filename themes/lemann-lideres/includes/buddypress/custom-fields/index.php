<?php
defined( 'ABSPATH' ) || exit;

// Campo usado para graduação.
require 'class-lemann-field-graduacao.php';

add_filter( 'bp_xprofile_get_field_types', function( $types ) {
	return array_merge( $types, [
		'graduacao' => 'Lemann_Field_Graduacao',
	] );
} );

add_filter( 'xprofile_data_value_before_save', function( $field_value, $field_id = 0, $reserialize = true, $data_obj = null ) {
	$field_type = BP_XProfile_Field::get_type( $data_obj->field_id );
	if ( 'graduacao' == $field_type ) {
		remove_filter( 'xprofile_data_value_before_save', 'xprofile_sanitize_data_value_before_save', 1 );
	} else {
		add_filter( 'xprofile_data_value_before_save', 'xprofile_sanitize_data_value_before_save', 1, 4 );
	}

	return $field_value;
}, 0, 4 );
