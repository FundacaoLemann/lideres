<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( bp_current_component( 'members' ) ) {
	$user_id = bp_displayed_user_id();
} else {
	$user_id = get_current_user_id();
}
$bprm_rs_data = array();
$bprm_rs_data = get_user_meta( $user_id, 'wbbpp_userdata', true );
if ( is_multisite() && is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
	$wbbpp_profile_fields_settings = get_site_option( 'wbbpp_profile_fields_settings' );
} else {
	$wbbpp_profile_fields_settings = get_option( 'wbbpp_profile_fields_settings' );
}
if ( is_array( $wbbpp_profile_fields_settings ) ) {
	foreach ( $wbbpp_profile_fields_settings as $key => $value ) {
		unset( $wbbpp_profile_fields_settings[ $key ]['bprm_identifier'] );
	}
}

$sidebar_content = '';
$main_content    = '';
if ( is_multisite() && is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
	$grp_args = get_site_option( 'wbbpp_profile_groups_settings' );
} else {
	$grp_args = get_option( 'wbbpp_profile_groups_settings' );
}
//$grp_args = bprm_existing_resume_groups();

if ( ! empty( $grp_args ) && is_array( $grp_args ) && ! empty( $bprm_rs_data ) && is_array( $bprm_rs_data ) ) {
	foreach ( $grp_args as $group_index => $group_info ) {

		if(isset($group_info['profile_display'])){

		$field_info_html = '';

		$group_title = '';

		if ( isset( $wbbpp_profile_fields_settings[ $group_index ] ) ) {

			$resume_backend_fields = $wbbpp_profile_fields_settings[ $group_index ];

			if ( isset( $bprm_rs_data[ $group_index ] ) ) {

				$group_title = "<h2 class='bprm-group-title " . $group_index . "'>" . $group_info['g_name'] . '</h2>';

				$resume_user_data_array = $bprm_rs_data[ $group_index ];

				foreach ( $resume_user_data_array as $resume_user_data ) {
					foreach ( $resume_user_data as $key => $value_to_render ) {
						$field_name = $key;
						if ( ! empty( $value_to_render ) ) {
							if ( isset( $resume_backend_fields[ $key ] ) ) {

								$field_info = $resume_backend_fields[ $key ];

								if ( isset( $field_info['display'] ) ) {

									$field_info_html .= "<div class='resume-fields-data-wrap'><h4 class='field-title " . $key . "'>" . $field_info['field_tile'] . '</h4>';

									$field_info_html .= bprm_render_field_type_html_for_resume( $field_info['field_type']['type'], $value_to_render, $field_name ) . '</div>';

									if ( $group_index == 'bprm_grp_others' ) {

										$section_title = '';
										if ( isset( $field_info['section_title'] ) ) {
											$section_title = $field_info['section_title'];
										}

										$section_icon = '';
										if ( isset( $field_info['section_icon'] ) ) {
											$section_icon = $field_info['section_icon'];
										}

										$group_title = "<h2 class='bprm-group-title " . $group_index . "'><i class='" . $section_icon . "'></i>" . $section_title . '</h2>';

										if ( $field_info['appr_sec'] == 'bprm_sidebar_area' ) {
											$sidebar_content .= $group_title . $field_info_html;
										} elseif ( $field_info['appr_sec'] == 'bprm_content_area' ) {
											$main_content .= $group_title . $field_info_html;
										} else {

										}
										$field_info_html = '';
									}
								}
							}
						}
					}
				}
			} //end condition check for isset $wbbpp_profile_fields_settings[$group_index]
		} // end condition check for isset $bprm_rs_data[$group_index]

		if ( $group_index == 'bprm_grp_others' ) {
			continue;
		}

		if ( $group_info['g_area'] == 'bprm_sidebar' ) {
			$sidebar_content .= $group_title . $field_info_html;
		} elseif ( $group_info['g_area'] == 'bprm_content' ) {
			$main_content .= $group_title . $field_info_html;
		} else {

		}

		} //end check conndition profile display
	}

?>
<div class="bprm-resume-wrapper">
	<div id="bprm-mobile-view-sidebar" class="sidebar-wrapper">
		<div class="bprm-user-image-wrapper">
			<?php
			if ( bp_current_component() ) {
					bp_displayed_user_avatar( 'type=thumb&width=100&height=100' );
			} else {
				echo bp_core_fetch_avatar(
					array(
						'item_id' => get_current_user_id(), // id of user for desired avatar
						'type'    => 'full',
						'html'    => true,
						'height'  => '100',
						'width'   => '100',
					)
				);
			}
			?>
		</div>
		<div class="bprm-sidebar-content">
		<?php echo $sidebar_content; ?>
		</div>
	</div>
	<div class="main-wrapper">
		<?php echo $main_content; ?>
	</div>
	<div class="sidebar-wrapper" id="bprm-sidebar-wrapper">
		<div class="bprm-user-image-wrapper">
			<?php
			if ( bp_current_component() ) {
					bp_displayed_user_avatar( 'type=thumb&width=100&height=100' );
			} else {
				echo bp_core_fetch_avatar(
					array(
						'item_id' => get_current_user_id(), // id of user for desired avatar
						'type'    => 'full',
						'html'    => true,
						'height'  => '100',
						'width'   => '100',
					)
				);
			}
			?>
		</div>
		<div class="bprm-sidebar-content">
		<?php echo $sidebar_content; ?>
		</div>
	</div>
</div>
<?php
} else {
?>
<div class="empty-resume-message">
<?php _e( 'Please build up your resume first.', 'buddypress-profile-pro' ); ?>
</div>
<?php
}
