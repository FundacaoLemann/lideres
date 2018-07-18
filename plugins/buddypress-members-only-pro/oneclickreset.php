<?php
if (!defined('ABSPATH'))
{
	exit;
}

function buddypress_one_click_reset_setting()
{
	global $wpdb, $wp_roles;
	
	if (isset ( $_POST ['bponeclickresetsubmit'] )) {
		
		check_admin_referer ( 'bponeclickresetnonce' );
		if (isset ( $_POST ['bponeclickresetcheckbox'] )) {
			delete_option ( 'bprestrictsbuddypresssection' );
			delete_option ( 'bpenablepagelevelprotect' );
			delete_option ( 'bpmoregisterpageurl' );
			delete_option ( 'saved_open_page_url' );
			delete_option ( 'bpstandardcomponent' );
			delete_option ( 'bpopenedcustomizedcomponent' );
			delete_option ( 'contentFrontendAnnouncement' );
			delete_option ( 'bpenableannouncement' );
			delete_option ( 'bprssrestrictscontent' );
			delete_option ( 'bpenablerssrestricts' );
			delete_option ( 'bpopenedcustomizedurls' );
			delete_option ( 'bpclosedcustomizedurls' );
			delete_option ( 'bprestricthomepage' );
			
			$tomas_roles_all_array = $wp_roles->roles;
			
			$sql = "SELECT ID, post_title, post_content FROM $wpdb->posts WHERE post_status='publish' ";
			$results = $wpdb->get_results ( $sql );
			
			if ((! (empty ( $results ))) && (is_array ( $results )) && (count ( $results ) > 0)) {
				$m_single = array ();
				foreach ( $results as $single ) {
					$m_single_id = $single->ID;
					delete_post_meta ( $m_single_id, 'bp_members_only_access_to_this_page' );
				}
			}
			
			foreach ( $tomas_roles_all_array as $tomas_roles_single_array ) {
				$tomas_roles_single_name = $tomas_roles_single_array ['name'];
				$tomas_roles_single_name_low = strtolower ( $tomas_roles_single_name );
				$bpmemonlyredirecttypeafterlogin = 'bpmemonlyredirecttypeafterlogin_' . $tomas_roles_single_name;
				$bpmemonlyredirecturlafterlogin = 'bpmemonlyredirecturlafterlogin_' . $tomas_roles_single_name;
				$bpmemonlyredirecttypeafterlogout = 'bpmemonlyredirecttypeafterlogout_' . $tomas_roles_single_name;
				$bpmemonlyredirecturlafterlogout = 'bpmemonlyredirecturlafterlogout_' . $tomas_roles_single_name;
				$bpmemonlyredirectbppagesafterlogin = 'bpmemonlyredirectbppagesafterlogin_' . $tomas_roles_single_name;
				$bpmemonlyredirectbppagesafterlogout = 'bpmemonlyredirectbppagesafterlogout_'. $tomas_roles_single_name;
				
				delete_option ( $bpmemonlyredirecttypeafterlogin );
				delete_option ( $bpmemonlyredirecturlafterlogin );
				delete_option ( $bpmemonlyredirecttypeafterlogout );
				delete_option ( $bpmemonlyredirecturlafterlogout );
				delete_option ( $bpmemonlyredirectbppagesafterlogin );
				delete_option ( $bpmemonlyredirectbppagesafterlogout );
				
				$bp_component_role_id = $tomas_roles_single_array ['name'];
				$bp_component_role_id = str_replace ( ' ', '-', $tomas_roles_single_array ['name'] );
				$rolebasedcustomizedcomponent = 'bpopenedcustomizedcomponent_' . $bp_component_role_id;
				delete_option ( $rolebasedcustomizedcomponent );
				
				$rolebasedstandardcomponent = 'bpstandardcomponent_' . $bp_component_role_id;
				delete_option ( $rolebasedstandardcomponent );
				
				$rolebasedcustomizedcomponent = 'bpopenedcustomizedurls_' . $bp_component_role_id;
				delete_option ( $rolebasedcustomizedcomponent );
				
				$rolebasedcustomizedclosedurlsettings = 'bpclosedcustomizedurls_' . $bp_component_role_id;				
				delete_option ( $rolebasedcustomizedclosedurlsettings );
			}
			
			$bpmoMessageString = __ ( 'All settings in members only pro has been deleted.', 'bp-members-only' );
			buddypress_members_only_pro_message ( $bpmoMessageString );
		} else {
			$bpmoMessageString = __ ( "Sorry, please checked 'Yes, I will reset all option in buddypress members only' option to reset all options", 'bp-members-only' );
			buddypress_members_only_pro_message ( $bpmoMessageString );
		}
	}
	echo "<br />";
	?>

<div style='margin: 10px 5px;'>
	<div style='float: left; margin-right: 10px;'>
		<img
			src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/buddypress-members-only-pro/images/new.png'
			style='width: 30px; height: 30px;'>
	</div>
	<div style='padding-top: 5px; font-size: 22px;'>Buddypress Members Only
		One Click Reset:</div>
</div>
<div style='clear: both'></div>
<div class="wrap">
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
			<div id="post-body">
				<div id="dashboard-widgets-main-content">
					<div class="postbox-container" style="width: 90%;">
						<div class="postbox">
							<h3 class='hndle' style='padding: 20px; !important'>
								<span>
									<?php
	echo __ ( 'One Click Reset Panel:', 'bp-members-only' );
	?>
									</span>
							</h3>

							<div class="inside" style='padding-left: 10px;'>
								<form id="bpmoform" name="bpmoform" action="" method="POST">
									<table id="bpmotable" width="100%">

										<tr style="margin-top: 30px;">
											<td width="30%" style="padding: 20px;" valign="top">
										<?php
	echo __ ( 'One Click Reset:', 'bp-members-only' );
	?>
										</td>
											<td width="70%" style="padding: 20px;">
										<?php
	echo '<input type="checkbox" id="bponeclickresetcheckbox" name="bponeclickresetcheckbox"  style="" value="yes"  checked="checked"> Yes, I will reset all option in buddypress members only';
	?>
										<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# If you checked this option, and click submit button, ', 'bp-members-only' );
	echo __ ( ' all current settings and information saved on buddypress members only pro will be deleted.', 'bp-members-only' );
	?>
										</i>
												
												</p>
											</td>
										</tr>
									</table>
									<br />
										<?php
	wp_nonce_field ( 'bponeclickresetnonce' );
	?>
										<input type="submit" id="bponeclickresetsubmit"
										name="bponeclickresetsubmit" value=" Submit "
										style="margin: 1px 20px;">
								</form>

								<br />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div style="clear: both"></div>
<br />
<?php
}
?>