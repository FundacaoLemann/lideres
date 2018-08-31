<?php
/**
 *
 * This template is used for group settings at admin end.
 *
 */

// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ){
	exit;
}
if ( is_multisite() && is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
	$bprm_grp_stngs = get_site_option( 'wbbpp_profile_groups_settings' );
} else {
	$bprm_grp_stngs = get_option( 'wbbpp_profile_groups_settings' );
}
$bprm_group_area = bprm_groups_display_area();
?>
<div class="bprm-gen-settings-wrap">
	<div class="bprm-gen-settings-container">
		<div class="bprm-group-field-container">
			<h3><?php esc_html_e('BuddyPress Profile Groups','buddypress-profile-pro'); ?></h3>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'wbbpp_profile_groups_settings_section' );
				  	do_settings_sections( 'wbbpp_profile_groups_settings_section' );
				?>
				<div class="bprm-group-tabs">
					<?php
						if( !empty( $bprm_grp_stngs ) && is_array( $bprm_grp_stngs ) ) {
							foreach ( $bprm_grp_stngs as $grp_key => $group_info ) { ?>
								<div class="bprm-group-tab-link-container">
									<div class="bprm-gp-tabs-link"><span class="brpm_grp_name"><?php echo esc_attr($group_info['g_name']); ?></span>
										<span class="bprm-group-actions">
										<a href="javascript:void(0)" class="bprm-remove-group-zone"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
										<a href="javascript:void(0)" class="bprm-show-group-zone"><i class="fa fa-cog" aria-hidden="true"></i></a>
									</span>
									</div>

									<div class="bprm-group-tabs-content <?php echo esc_attr($grp_key); ?>">
										<div class="bprm-groups-zone">
											<table class="form-table">
												<tr>
													<th scope="row"><label><?php esc_html_e('Group Title','buddypress-profile-pro'); ?></label>
													</th>
													<td>
														<input type="text" class="bprm-group-title-text" name="wbbpp_profile_groups_settings[<?php echo esc_attr($grp_key); ?>][g_name]" value="<?php echo ($group_info['g_name'])?$group_info['g_name']:'' ?>">
													</td>
												</tr>
												<tr>
													<th scope="row"><label><?php esc_html_e('Group Description','buddypress-profile-pro'); ?></label>
													</th>
													<td>
														<textarea name="wbbpp_profile_groups_settings[<?php echo esc_attr($grp_key); ?>][g_desc]"><?php echo ($group_info['g_desc'])?$group_info['g_desc']:'' ?></textarea>
													</td>
												</tr>
												<tr style="display: none;">
													<th scope="row"><label><?php esc_html_e('Group Key','buddypress-profile-pro'); ?></label>
													</th>
													<td>
														<input type="text" name="wbbpp_profile_groups_settings[<?php echo esc_attr($grp_key); ?>][g_key]" value="<?php echo ($group_info['g_key'])?$group_info['g_key']:'' ?>">
													</td>
												</tr>
												<tr class="wbbpp-group-display-area-tr">
													<th scope="row"><label><?php esc_html_e('Group Display Area','buddypress-profile-pro'); ?></label>
													</th>
													<td>
														<select name="wbbpp_profile_groups_settings[<?php echo esc_attr($grp_key); ?>][g_area]">
															<?php foreach ($bprm_group_area as $area => $area_text) { ?>
															<option value="<?php echo esc_attr($area); ?>" <?php selected($group_info['g_area'],$area) ?>><?php echo esc_attr($area_text); ?></option>
															<?php } ?>
														</select>
													</td>
												</tr>
												<tr>
													<th scope="row"><label><?php esc_html_e('Display Group at BuddyPress Profile','buddypress-profile-pro'); ?></label>
													</th>
													<td>
														<input type="checkbox" name="wbbpp_profile_groups_settings[<?php echo esc_attr($grp_key); ?>][profile_display]" value="yes" <?php if(isset($group_info['profile_display'])) checked($group_info['profile_display'],'yes') ?>>
													</td>
												</tr>
												<tr class="wbbpp-resume-display-tr">
													<th scope="row"><label><?php esc_html_e('Display Group at Resume','buddypress-profile-pro'); ?></label>
													</th>
													<td>
														<input type="checkbox" name="wbbpp_profile_groups_settings[<?php echo esc_attr($grp_key); ?>][resume_display]" value="yes" <?php if(isset($group_info['resume_display'])) checked($group_info['resume_display'],'yes') ?>>
													</td>
												</tr>
												<tr class="tr-repeater-group">
													<th scope="row"><label><?php esc_html_e('Repeater','buddypress-profile-pro'); ?></label>
													</th>
													<td>
														<input type="checkbox" name="wbbpp_profile_groups_settings[<?php echo esc_attr($grp_key); ?>][repeater]" value="yes" <?php if(isset($group_info['repeater'])) checked($group_info['repeater'],'yes') ?>>
													</td>
												</tr>
											</table>
										</div>
									</div>
								</div>
					<?php
							}// end foreach of group args
						} //end if condition check for empty group array and bprm settings array
					?>
				</div>
				<?php submit_button(); ?>
			</form>
		</div>
		<div class="bprm-add-new-field-container">
			<h3><?php esc_html_e('Add New Group','buddypress-profile-pro'); ?></h3>
			<p><?php esc_html_e('You can add new group to your extended fileds such as Sports Experience, Certifications, or anything else with below form.','buddypress-profile-pro'); ?></p>
			<div class="bprm-add-new-form-container">
				<form id="bprm-add-new-group-form" method="post" action="">
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row"><label><?php esc_html_e('Group Title','buddypress-profile-pro'); ?></label></th>
								<td>
									<input name="bprm_gp_title" type="text" id="bprm_gp_title" value="" class="bprm-new-form-input">
									<i class="fa fa-question-circle"></i>
									<span class="bprm-description"><?php esc_html_e('Enter title for this group.','buddypress-profile-pro'); ?></span>
									<span class="bprm_gp_error"><?php esc_html_e('Please enter group title.','buddypress-profile-pro'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"><label><?php esc_html_e('Group Description','buddypress-profile-pro'); ?></label></th>
								<td>
									<textarea name="bprm_gp_desc" id="bprm_gp_desc" class="bprm-new-form-input"></textarea>
									<i class="fa fa-question-circle"></i>
									<span class="bprm-description"><?php esc_html_e('Enter group description.','buddypress-profile-pro'); ?></span>
									<span class="bprm_gp_error"><?php esc_html_e('Please enter group description.','buddypress-profile-pro'); ?></span>
								</td>
							</tr>
							<tr class="wbbpp-group-display-area-tr">
								<th scope="row"><label><?php esc_html_e('Group Display Area','buddypress-profile-pro'); ?></label>
								</th>
								<td>
									<select name="bprm_gp_display_area">
										<?php foreach ($bprm_group_area as $area => $area_text) { ?>
										<option value="<?php echo esc_attr($area); ?>"><?php echo esc_attr($area_text); ?></option>
										<?php } ?>
									</select>
									<i class="fa fa-question-circle"></i>
									<span class="bprm-description"><?php esc_html_e('Enter group description.','buddypress-profile-pro'); ?></span>
									<span class="bprm_gp_error"><?php esc_html_e('Please select group display area in resume.','buddypress-profile-pro'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"><label><?php esc_html_e('Display Group at BuddyPress Profile','buddypress-profile-pro'); ?></label></th>
								<td>
									<input name="bprm_gp_profile_display" type="checkbox" id="bprm_gp_profile_display" value="yes" class="bprm-new-form-input" checked="checked">
									<i class="fa fa-question-circle"></i><span class="bprm-description"><?php esc_html_e('Check this option if you want to make this group available at BuddyPress pprofile view.','buddypress-profile-pro'); ?></span>
								</td>
							</tr>
							<tr valign="top" class="wbbpp-resume-display-tr">
								<th scope="row"><label><?php esc_html_e('Display Group at Resume','buddypress-profile-pro'); ?></label></th>
								<td>
									<input name="bprm_gp_resume_display" type="checkbox" id="bprm_gp_resume_display" value="yes" class="bprm-new-form-input" checked="checked">
									<i class="fa fa-question-circle"></i><span class="bprm-description"><?php esc_html_e('Check this option if you want to make this group available in Resume.','buddypress-profile-pro'); ?></span>
								</td>
							</tr>
							<tr class="tr-repeater-group">
								<th scope="row"><label><?php esc_html_e('Repeater','buddypress-profile-pro'); ?></label>
								</th>
								<td>
									<input type="checkbox" name="bprm_gp_repeater" value="yes" checked="checked">
									<i class="fa fa-question-circle"></i><span class="bprm-description"><?php esc_html_e('Check this option if you want to make this group as repeater group.','buddypress-profile-pro'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<a href="javascript:void(0)" class="bprm-settings-field-btn wbbpp_save_new_group "><?php esc_html_e('Add','buddypress-profile-pro'); ?></a>
									<a href="#" class="bprm-settings-field-btn bprm-cancel-new-group-link"><?php esc_html_e('Cancel','buddypress-profile-pro'); ?></a>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
		<div class="clear">
		</div>
	</div>
</div>
