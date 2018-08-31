<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Profile default fields configuration array.
 */
function wbbpp_profile_initial_fields_configratn() {

	$bprm_settings_one = array(
		'bprm_grp_edu'         => array(
			'bprms_inst'       => array(
				'field_tile' => 'Institute',
				'field_type' => array(
					'type' => 'textbox',
				),
				'field_grp'  => 'bprm_grp_edu',
				'display'    => 'yes',
			),
			'bprms_inst_place' => array(
				'field_tile' => 'Place',
				'field_type' => array(
					'type' => 'place_autocomplete',
				),
				'field_grp'  => 'bprm_grp_edu',
				'display'    => 'yes',
			),
			'bprms_degree'     => array(
				'field_tile' => 'Degree/Program',
				'field_type' => array(
					'type' => 'textbox',
				),
				'field_grp'  => 'bprm_grp_edu',
				'display'    => 'yes',
			),
			'bprms_start'      => array(
				'field_tile' => 'From Year',
				'field_type' => array(
					'type' => 'year_dropdown',
				),
				'field_grp'  => 'bprm_grp_edu',
				'display'    => 'yes',
			),
			'bprms_yoc'        => array(
				'field_tile' => 'To Year',
				'field_type' => array(
					'type' => 'year_dropdown',
				),
				'field_grp'  => 'bprm_grp_edu',
				'display'    => 'yes',
			),
			'bprms_curschol'   => array(
				'field_tile' => 'I currently attend this school.',
				'field_type' => array(
					'type'    => 'checkbox',
					'options' => array(
						'0' => 'yes',
					),

				),
				'field_grp'  => 'bprm_grp_edu',
				'display'    => 'yes',
			),
		),
		'bprm_grp_prof_exprnc' => array(
			'bprms_empoy'      => array(
				'field_tile' => 'Employer',
				'field_type' => array(
					'type' => 'textbox',
				),
				'field_grp'  => 'bprm_grp_prof_exprnc',
				'display'    => 'yes',
			),
			'bprms_work_place' => array(
				'field_tile' => 'Place',
				'field_type' => array(
					'type' => 'place_autocomplete',
				),
				'field_grp'  => 'bprm_grp_prof_exprnc',
				'display'    => 'yes',
			),
			'bprms_poswork'    => array(
				'field_tile' => 'Work Description',
				'field_type' => array(
					'type' => 'textarea',
				),
				'field_grp'  => 'bprm_grp_prof_exprnc',
				'display'    => 'yes',
			),
			'bprms_pos'        => array(
				'field_tile' => 'Position',
				'field_type' => array(
					'type' => 'textbox',
				),
				'field_grp'  => 'bprm_grp_prof_exprnc',
				'display'    => 'yes',
			),
			'bprms_posfrom'    => array(
				'field_tile' => 'From Year',
				'field_type' => array(
					'type' => 'year_dropdown',
				),
				'field_grp'  => 'bprm_grp_prof_exprnc',
				'display'    => 'yes',
			),
			'bprms_posto'      => array(
				'field_tile' => 'To Year',
				'field_type' => array(
					'type' => 'year_dropdown',
				),
				'field_grp'  => 'bprm_grp_prof_exprnc',
				'display'    => 'yes',
			),
			'bprm_curcomp'     => array(
				'field_tile' => 'I currently work here.',
				'field_type' => array(
					'type'    => 'checkbox',
					'options' => array(
						'0' => 'yes',
					),

				),
				'field_grp'  => 'bprm_grp_prof_exprnc',
				'display'    => 'yes',
			),
		),
		'bprm_contact_details' => array(
			'bprms_name'  => array(
				'field_tile' => 'City',
				'field_type' => array(
					'type' => 'place_autocomplete',
				),
				'field_grp'  => 'bprm_contact_details',
				'display'    => 'yes',
				'required'   => 'yes',
			),
			'bprms_links'  => array(
				'field_tile' => 'Links',
				'field_type' => array(
					'type' => 'url',
				),
				'field_grp'  => 'bprm_contact_details',
				'display'    => 'yes',
				'required'   => 'yes',
			),
			'bprms_phone'   => array(
				'field_tile' => 'Phone Number',
				'field_type' => array(
					'type' => 'textbox',
				),
				'field_grp'  => 'bprm_contact_details',
				'display'    => 'yes',
				'repeater'   => 'yes',
			),
			'bprms_email'   => array(
				'field_tile' => 'Public Email',
				'field_type' => array(
					'type' => 'email',
				),
				'field_grp'  => 'bprm_contact_details',
				'display'    => 'yes',
				'repeater'   => 'yes',
			),
			
		),
	);

	return $bprm_settings_one;
}

/**
 * Profile default groups array.
 */
function wbbpp_profile_initial_groups_configratn() {

	$grp_args = array(
		'bprm_grp_edu'         => array(
			'g_name' => __( 'Education', 'buddypress-profile-pro' ),
			'g_desc' => __( 'This group contains fields which will appear in Education section.', 'buddypress-profile-pro' ),
			'g_key'  => 'bprm_grp_edu',
			'g_area' => 'bprm_content',
			'profile_display' => 'yes',
			'resume_display'  => 'no',
			'repeater'		  => 'yes'
		),
		'bprm_grp_prof_exprnc' => array(
			'g_name' => __( 'Professional Experience', 'buddypress-profile-pro' ),
			'g_desc' => __( 'This group contains fields which will appear in Professional Experience section.', 'buddypress-profile-pro' ),
			'g_key'  => 'bprm_grp_prof_exprnc',
			'g_area' => 'bprm_content',
			'profile_display' => 'yes',
			'resume_display'  => 'no',
			'repeater'		  => 'yes'
		),
		'bprm_contact_details' => array(
			'g_name' => __( 'Contact Details', 'buddypress-profile-pro' ),
			'g_desc' => __( 'This group contains fields which will appear in Personal Information section.', 'buddypress-profile-pro' ),
			'g_key'  => 'bprm_contact_details',
			'g_area' => 'bprm_sidebar',
			'profile_display' => 'yes',
			'resume_display'  => 'no',
			'repeater'		  => 'no'
		),
	);

	return $grp_args;
}
