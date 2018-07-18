<?php
if(!defined('WPINC'))
{
	exit ('Please do not access our files directly.');
}
	

function buddypress_members_role_based_login_setting()
{
	global $wp_roles;
?>

<div style='margin:10px 5px;'>
<div style='float:left;margin-right:10px;'>
<img src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/buddypress-members-only-pro/images/new.png' style='width:30px;height:30px;'>
</div> 
<div style='padding-top:5px; font-size:22px;'>Members Only Login Redirect / Logout Redirect Based on User Roles:</div>
</div>
<div style='clear:both'></div>
<?php 
	$tomas_roles_all_array =  $wp_roles->roles;

	foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array )
	{

		$tomas_roles_single_name = $tomas_roles_single_key;
	
		$bpmemonlyredirecttypeafterlogin = 'bpmemonlyredirecttypeafterlogin_'. $tomas_roles_single_name;
	
		$bpmemonlyredirecturlafterlogin = 'bpmemonlyredirecturlafterlogin_'. $tomas_roles_single_name;
	
		$bpmemonlyredirecttypeafterlogout = 'bpmemonlyredirecttypeafterlogout_'. $tomas_roles_single_name;
	
		$bpmemonlyredirecturlafterlogout = 'bpmemonlyredirecturlafterlogout_'. $tomas_roles_single_name;
		
		$bpmemonlyredirectbppagesafterlogin = 'bpmemonlyredirectbppagesafterlogin_'. $tomas_roles_single_name;
		
		$bpmemonlyredirectbppagesafterlogout = 'bpmemonlyredirectbppagesafterlogout_'. $tomas_roles_single_name;
		
		if ((isset($_POST[$bpmemonlyredirecttypeafterlogin])) && (!(empty($bpmemonlyredirecttypeafterlogin))))
		{
			check_admin_referer( 'bpmosubmitnewnonce' );
			if ($_POST[$bpmemonlyredirecttypeafterlogin] == 'certain')
			{
				if (isset($_POST[$bpmemonlyredirecturlafterlogin]))
				{
					if (!(empty($_POST[$bpmemonlyredirecturlafterlogin])))
					{
						update_option($bpmemonlyredirecturlafterlogin, esc_url($_POST[$bpmemonlyredirecturlafterlogin])); 
						
						update_option($bpmemonlyredirecttypeafterlogin, $_POST[$bpmemonlyredirecttypeafterlogin]);
						$bpmoMessageString =  __( 'Your changes of  "Redirect URL After Login" has been saved.', 'bp-members-only' );
						buddypress_members_only_pro_message($bpmoMessageString);
					}
					else
					{
						$bpmoMessageString =  __( 'You must enter the URL for "Redirect URL After Login"', 'bp-members-only' );
						buddypress_members_only_pro_message($bpmoMessageString);
					}
				}
				else
				{
					$bpmoMessageString =  __( 'You must enter the URL for "Redirect URL After Login"', 'bp-members-only' );
					buddypress_members_only_pro_message($bpmoMessageString);
				}
			}
			elseif ($_POST[$bpmemonlyredirecttypeafterlogin] == 'bppages')
			{
				if (isset($_POST[$bpmemonlyredirectbppagesafterlogin]))
				{
					if (!(empty($_POST[$bpmemonlyredirectbppagesafterlogin])))
					{
						update_option($bpmemonlyredirectbppagesafterlogin, $_POST[$bpmemonlyredirectbppagesafterlogin]);
						update_option($bpmemonlyredirecttypeafterlogin, $_POST[$bpmemonlyredirecttypeafterlogin]);
						$bpmoMessageString =  __( 'Your changes of  "Redirect URL to BuddyPress Pages After Login" has been saved.', 'bp-members-only' );
						buddypress_members_only_pro_message($bpmoMessageString);
					}
				}
			}
			else
			{
				update_option($bpmemonlyredirecttypeafterlogin, $_POST[$bpmemonlyredirecttypeafterlogin]);
				$bpmoMessageString =  __( 'Your changes of  "Redirect URL After Login" has been saved.', 'bp-members-only' );
				buddypress_members_only_pro_message($bpmoMessageString);
			}
		}
	
		if ((isset($_POST[$bpmemonlyredirecttypeafterlogout])) && (!(empty($bpmemonlyredirecttypeafterlogout))))
		{
			check_admin_referer( 'bpmosubmitnewnonce' );
			if ($_POST[$bpmemonlyredirecttypeafterlogout] == 'certain')
			{
				if (isset($_POST[$bpmemonlyredirecturlafterlogout]))
				{
					if (!(empty($_POST[$bpmemonlyredirecturlafterlogout])))
					{
						update_option($bpmemonlyredirecturlafterlogout, esc_url($_POST[$bpmemonlyredirecturlafterlogout]));
						update_option($bpmemonlyredirecttypeafterlogout, $_POST[$bpmemonlyredirecttypeafterlogout]);
						$bpmoMessageString =  __( 'Your changes of  "Redirect URL After Logout" has been saved.', 'bp-members-only' );
						buddypress_members_only_pro_message($bpmoMessageString);
					}
					else
					{
						$bpmoMessageString =  __( 'You must enter the URL for "Redirect URL After Logout"', 'bp-members-only' );
						buddypress_members_only_pro_message($bpmoMessageString);
					}
				}
				else
				{
					$bpmoMessageString =  __( 'You must enter the URL  for "Redirect URL After Logout"', 'bp-members-only' );
					buddypress_members_only_pro_message($bpmoMessageString);
				}
			}
			elseif ($_POST[$bpmemonlyredirecttypeafterlogout] == 'bppages')
			{
				if (isset($_POST[$bpmemonlyredirectbppagesafterlogout]))
				{
					if (!(empty($_POST[$bpmemonlyredirectbppagesafterlogout])))
					{
						update_option($bpmemonlyredirectbppagesafterlogout, $_POST[$bpmemonlyredirectbppagesafterlogout]);
						update_option($bpmemonlyredirecttypeafterlogout, $_POST[$bpmemonlyredirecttypeafterlogout]);
						$bpmoMessageString =  __( 'Your changes of  "Redirect URL to BuddyPress Pages After Logout" has been saved.', 'bp-members-only' );
						buddypress_members_only_pro_message($bpmoMessageString);
					}
				}
			}			
			else
			{
				update_option($bpmemonlyredirecttypeafterlogout, $_POST[$bpmemonlyredirecttypeafterlogout]);
				$bpmoMessageString =  __( 'Your changes of "Redirect URL After Logout" has been saved.', 'bp-members-only' );
				buddypress_members_only_pro_message($bpmoMessageString);
			}
		}
	}	
	

	foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array )
	{

		$tomas_roles_single_name = $tomas_roles_single_key;
		
		$bpmemonlyredirecttypeafterlogin = 'bpmemonlyredirecttypeafterlogin_'. $tomas_roles_single_name;
		
		$bpmemonlyredirecturlafterlogin = 'bpmemonlyredirecturlafterlogin_'. $tomas_roles_single_name;
		
		$bpmemonlyredirecttypeafterlogout = 'bpmemonlyredirecttypeafterlogout_'. $tomas_roles_single_name;
		
		$bpmemonlyredirecturlafterlogout = 'bpmemonlyredirecturlafterlogout_'. $tomas_roles_single_name;
		
		$bpmemonlyredirectbppagesafterlogin = 'bpmemonlyredirectbppagesafterlogin_'. $tomas_roles_single_name;
		
		$bpmemonlyredirectbppagesafterlogout = 'bpmemonlyredirectbppagesafterlogout_'. $tomas_roles_single_name;
		
		$bpmemonlyredirecttypeafterloginoption = get_option($bpmemonlyredirecttypeafterlogin);
		$bpmemonlyredirecturlafterloginoption = get_option($bpmemonlyredirecturlafterlogin);
		$bpmemonlyredirecttypeafterlogoutoption = get_option($bpmemonlyredirecttypeafterlogout);
		$bpmemonlyredirecturlafterlogoutoption = get_option($bpmemonlyredirecturlafterlogout);
		$bpmemonlyredirectbppagesafterloginoption = get_option($bpmemonlyredirectbppagesafterlogin);
		$bpmemonlyredirectbppagesafterlogoutoption = get_option($bpmemonlyredirectbppagesafterlogout);
?>
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='hndle' style='padding: 20px; !important'>
									<span>
									<?php 
											echo  __( 'User Role: ', 'bp-members-only' );
											echo $tomas_roles_single_name;
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:10px;'>
										<form id="bpmoform" name="bpmoform" action="" method="POST">
										<table id="bpmotable" width="100%">
										<tr valign="top">
										<th scope="row"  width="30%" style="padding: 20px; text-align:left;">
										<?php 
											echo  __( 'Redirect  URL After Login:', 'bp-members-only' );
										?>
										</th>
										
										<td width="70%" style="padding: 20px;">
										<input type="radio"  id="<?php echo $bpmemonlyredirecttypeafterlogin; ?>" name="<?php echo $bpmemonlyredirecttypeafterlogin; ?>" value="default"  <?php checked( 'default', $bpmemonlyredirecttypeafterloginoption ); ?> /> 
										<label for="<?php echo $bpmemonlyredirecttypeafterlogin; ?>">Default</label>
										<?php 
										echo '<span style="color:#888 !important; margin-left:6px;"><i>';
										echo  __( '(we do nothing, just follow wordpress default behavior)', 'bp-members-only' );
										echo '</i></span>';
										?>
										<p>
										<input type="radio"  id="<?php echo $bpmemonlyredirecttypeafterlogin; ?>" name="<?php echo $bpmemonlyredirecttypeafterlogin; ?>" value="referer" <?php checked( 'referer', $bpmemonlyredirecttypeafterloginoption ); ?> /> 
										<label for="<?php echo $bpmemonlyredirecttypeafterlogin; ?>">Referer</label>
										<?php 
										echo '<span style="color:#888 !important; margin-left:6px;"><i>';
										echo  __( '(after logged in, user will be redirect to the same page before login)', 'bp-members-only' );
										echo '</i></span>';
										?>
										</p>
										<p>
										<input type="radio"  id="<?php echo $bpmemonlyredirecttypeafterlogin; ?>" name="<?php echo $bpmemonlyredirecttypeafterlogin; ?>" value="bppages" <?php checked( 'bppages', $bpmemonlyredirecttypeafterloginoption ); ?> />
										<select name="<?php echo $bpmemonlyredirectbppagesafterlogin; ?>" id="<?php echo $bpmemonlyredirectbppagesafterlogin; ?>">
											<option value="bpuseractivity" <?php selected( $bpmemonlyredirectbppagesafterloginoption, 'bpuseractivity' ); ?>><?php echo 'BuddyPress Personal Profile Activity Page' ?></option>
											<option value="bpmembers" <?php selected( $bpmemonlyredirectbppagesafterloginoption, 'bpmembers' ); ?>><?php echo 'BuddyPress Members Page' ?></option>
											<option value="bpfriends" <?php selected( $bpmemonlyredirectbppagesafterloginoption, 'bpfriends' ); ?>><?php echo 'BuddyPress Personal Friends Page' ?></option>
											<option value="bpmessages" <?php selected( $bpmemonlyredirectbppagesafterloginoption, 'bpmessages' ); ?>><?php echo 'BuddyPress Personal Messages Page' ?></option>
											<option value="bpnotifications" <?php selected( $bpmemonlyredirectbppagesafterloginoption, 'bpnotifications' ); ?>><?php echo 'BuddyPress Personal Notifications Page' ?></option>
											<option value="bpsettings" <?php selected( $bpmemonlyredirectbppagesafterloginoption, 'bpsettings' ); ?>><?php echo 'BuddyPress Personal Settings Page' ?></option>
											<option value="bpprofile" <?php selected( $bpmemonlyredirectbppagesafterloginoption, 'bpprofile' ); ?>><?php echo 'BuddyPress Personal Profile Page' ?></option>
											<option value="bpfavorites" <?php selected( $bpmemonlyredirectbppagesafterloginoption, 'bpfavorites' ); ?>><?php echo 'BuddyPress Personal Favorites Page' ?></option>
											<option value="bpmentions" <?php selected( $bpmemonlyredirectbppagesafterloginoption, 'bpmentions' ); ?>><?php echo 'BuddyPress Personal Mentions Page' ?></option>
											<option value="bpsiteactivity" <?php selected( $bpmemonlyredirectbppagesafterloginoption, 'bpsiteactivity' ); ?>><?php echo 'BuddyPress Site Wide Activity Page' ?></option>
											<option value="bpgroups" <?php selected( $bpmemonlyredirectbppagesafterloginoption, 'bpgroups' ); ?>><?php echo 'BuddyPress Groups Page' ?></option>
										</select>
										</p>
										<p>
										<input type="radio"  id="<?php echo $bpmemonlyredirecttypeafterlogin; ?>" name="<?php echo $bpmemonlyredirecttypeafterlogin; ?>" value="certain"  <?php checked( 'certain', $bpmemonlyredirecttypeafterloginoption ); ?>  /> 
										<label for="<?php echo $bpmemonlyredirecttypeafterlogin; ?>">Redirect to Certain URL</label>
										<?php 
										echo '<span style="color:#888 !important; margin-left:6px;"><i>';
										echo  __( '(redirect to the certain page which you enter below)', 'bp-members-only' );
										echo '</i></span>';
										?>
										</p>
																				
										<p>
										<input type="text" id="bpmemonlyredirecturlafterlogin" name="bpmemonlyredirecturlafterlogin_<?php echo $tomas_roles_single_name; ?>"  style="width:500px;" size="70" value="<?php  echo $bpmemonlyredirecturlafterloginoption; ?>">
										</p>
										</td>
										</tr>


										<tr valign="top">
										<th scope="row"  width="30%" style="padding: 20px; text-align:left;">										
										<?php 
											echo  __( 'Redirect  URL After Logout:', 'bp-members-only' );
										?>
										</th>
										
										<td width="70%" style="padding: 20px;">
										<input type="radio"  id="<?php echo $bpmemonlyredirecttypeafterlogout; ?>" name="<?php echo $bpmemonlyredirecttypeafterlogout; ?>" value="default"  <?php checked( 'default', $bpmemonlyredirecttypeafterlogoutoption ); ?> /> 
										<label for="<?php echo $bpmemonlyredirecttypeafterlogout; ?>">Default</label>
										<?php 
										echo '<span style="color:#888 !important; margin-left:6px;"><i>';
										echo  __( '(we do nothing, just follow wordpress default behavior)', 'bp-members-only' );
										echo '</i></span>';
										?>
										<p>
										<input type="radio"  id="<?php echo $bpmemonlyredirecttypeafterlogout; ?>" name="<?php echo $bpmemonlyredirecttypeafterlogout; ?>" value="referer"  <?php checked( 'referer', $bpmemonlyredirecttypeafterlogoutoption ); ?> /> 
										<label for="<?php echo $bpmemonlyredirecttypeafterlogout; ?>">Referer</label>
										<?php 
										echo '<span style="color:#888 !important; margin-left:6px;"><i>';
										echo  __( '(after logged in, user will be redirect to the same page before login)', 'bp-members-only' );
										echo '</i></span>';
										?>
										</p>
										
										<p>
										<input type="radio"  id="<?php echo $bpmemonlyredirecttypeafterlogout; ?>" name="<?php echo $bpmemonlyredirecttypeafterlogout; ?>" value="bppages" <?php checked( 'bppages', $bpmemonlyredirecttypeafterlogoutoption ); ?> />
										<select name="<?php echo $bpmemonlyredirectbppagesafterlogout; ?>" id="<?php echo $bpmemonlyredirectbppagesafterlogout; ?>">
											<option value="bpuseractivity" <?php selected( $bpmemonlyredirectbppagesafterlogoutoption, 'bpuseractivity' ); ?>><?php echo 'BuddyPress Personal Profile Activity Page' ?></option>
											<option value="bpmembers" <?php selected( $bpmemonlyredirectbppagesafterlogoutoption, 'bpmembers' ); ?>><?php echo 'BuddyPress Members Page' ?></option>
											<option value="bpfriends" <?php selected( $bpmemonlyredirectbppagesafterlogoutoption, 'bpfriends' ); ?>><?php echo 'BuddyPress Personal Friends Page' ?></option>
											<?php
											/*
											<option value="bpmessages" <?php selected( $bpmemonlyredirectbppagesafterlogoutoption, 'bpmessages' ); ?>><?php echo 'BuddyPress Personal Messages Page' ?></option>
											<option value="bpnotifications" <?php selected( $bpmemonlyredirectbppagesafterlogoutoption, 'bpnotifications' ); ?>><?php echo 'BuddyPress Personal Notifications Page' ?></option>
											<option value="bpsettings" <?php selected( $bpmemonlyredirectbppagesafterlogoutoption, 'bpsettings' ); ?>><?php echo 'BuddyPress Personal Settings Page' ?></option>
											*/
											?>
											<option value="bpprofile" <?php selected( $bpmemonlyredirectbppagesafterlogoutoption, 'bpprofile' ); ?>><?php echo 'BuddyPress Personal Profile Page' ?></option>
											<option value="bpfavorites" <?php selected( $bpmemonlyredirectbppagesafterlogoutoption, 'bpfavorites' ); ?>><?php echo 'BuddyPress Personal Favorites Page' ?></option>
											<option value="bpmentions" <?php selected( $bpmemonlyredirectbppagesafterlogoutoption, 'bpmentions' ); ?>><?php echo 'BuddyPress Personal Mentions Page' ?></option>
											<option value="bpsiteactivity" <?php selected( $bpmemonlyredirectbppagesafterlogoutoption, 'bpsiteactivity' ); ?>><?php echo 'BuddyPress Site Wide Activity Page' ?></option>
											<option value="bpgroups" <?php selected( $bpmemonlyredirectbppagesafterlogoutoption, 'bpgroups' ); ?>><?php echo 'BuddyPress Groups Page' ?></option>
										</select>
										</p>
										<p>
										<?php 
										echo '<span style="color:#888 !important; margin-left:6px;"><i>';
										echo  __( '(Please ensure in <a href="http://localhost/wp-admin/admin.php?page=bpmembercomponentonly">"Components Setting"</a> page, Guest users have permission of logout redirect page)', 'bp-members-only' );
										echo '</i></span>';
										?>										
										</p>
										
										<p>
										<input type="radio"  id="<?php echo $bpmemonlyredirecttypeafterlogout; ?>" name="<?php echo $bpmemonlyredirecttypeafterlogout; ?>" value="certain"  <?php checked( 'certain', $bpmemonlyredirecttypeafterlogoutoption ); ?> /> 
										<label for="<?php echo $bpmemonlyredirecttypeafterlogout; ?>">Redirect to Certain URL</label>
										<?php 
										echo '<span style="color:#888 !important; margin-left:6px;"><i>';
										echo  __( '(redirect to the certain page which you enter below)', 'bp-members-only' );
										echo '</i></span>';
										?>
										</p>
																				
										<p>
										<input type="text" id="bpmemonlyredirecturlafterlogout" name="bpmemonlyredirecturlafterlogout_<?php echo $tomas_roles_single_name; ?>"  style="width:500px;" size="70" value="<?php  echo $bpmemonlyredirecturlafterlogoutoption; ?>">
										</p>
										</td>
										</tr>

										</table>
										<br />
										<?php
											wp_nonce_field('bpmosubmitnewnonce');
										?>
										<input type="submit" id="bpmosubmitnew" name="bpmosubmitnew" value=" Submit " style="margin:1px 20px;">
										</form>
										
										<br />
									</div>
								</div>
							</div>
						</div>
					</div>
		    	</div>
			</div> <!--   dashboard-widgets-wrap -->
		</div> <!--  wrap -->
<?php 
	}
?>
		<div style="clear:both"></div>
		<br />
<?php 
}


function tomas_login_redirect($redirect_to, $requested_redirect_to, $user)
{
	global  $wp_roles,$user_ID;
	
	$tomas_roles_all_array =  $wp_roles->roles;
	
	if (empty($user))
	{
		$user = wp_get_current_user();
	}

	if (empty($user->roles))
	{
		return $redirect_to;
	}
		

	foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array )
	{

		$tomas_roles_single_name = $tomas_roles_single_key;
		

		$tomas_roles_single_name_low = $tomas_roles_single_name;
		
		if (in_array($tomas_roles_single_name_low, $user->roles))
		{

		}
		else
		{
			continue;
		} 
		
		$bpmemonlyredirecttypeafterlogin = 'bpmemonlyredirecttypeafterlogin_'. $tomas_roles_single_name;
	
		$bpmemonlyredirecturlafterlogin = 'bpmemonlyredirecturlafterlogin_'. $tomas_roles_single_name;
	
		$bpmemonlyredirecttypeafterlogout = 'bpmemonlyredirecttypeafterlogout_'. $tomas_roles_single_name;
	
		$bpmemonlyredirecturlafterlogout = 'bpmemonlyredirecturlafterlogout_'. $tomas_roles_single_name;
	
		$bpmemonlyredirectbppagesafterlogin = 'bpmemonlyredirectbppagesafterlogin_'. $tomas_roles_single_name;
		
		$bpmemonlyredirecttypeafterloginoption = get_option($bpmemonlyredirecttypeafterlogin);
		$bpmemonlyredirecturlafterloginoption = get_option($bpmemonlyredirecturlafterlogin);
		$bpmemonlyredirecttypeafterlogoutoption = get_option($bpmemonlyredirecttypeafterlogout);
		$bpmemonlyredirecturlafterlogoutoption = get_option($bpmemonlyredirecturlafterlogout);
		$bpmemonlyredirectbppagesafterloginoption = get_option($bpmemonlyredirectbppagesafterlogin);

		if ($bpmemonlyredirecttypeafterloginoption == 'default')
		{
			$redirect_target_url = $redirect_to;
			return $redirect_target_url;
		}

		if ($bpmemonlyredirecttypeafterloginoption == 'referer')
		{
			$referer =  $_SERVER['HTTP_REFERER'];
			$referer_array = parse_url($referer);
			$referer_path = $referer_array['path'];
			if( $_SERVER['REQUEST_URI'] != $referer_path )
			{
				$redirect_target_url = $_SERVER['HTTP_REFERER'];
			}
			else
			{
				$redirect_target_url = get_option('siteurl');
			}
			return $redirect_target_url;
		}

		if ($bpmemonlyredirecttypeafterloginoption == 'certain')
		{
			$redirect_target_url = $bpmemonlyredirecturlafterloginoption;
			wp_safe_redirect($redirect_target_url);
			die;			
			return $redirect_target_url;
		}

		if ($bpmemonlyredirecttypeafterloginoption == 'bppages')
		{
			$is_buddypress_plugin_activated = in_array( 'buddypress/bp-loader.php', (array) get_option( 'active_plugins', array() ) );
			
			if (true == $is_buddypress_plugin_activated )
			{
				$redirect_target_url_to_bppages = $bpmemonlyredirectbppagesafterloginoption;
				
				if ($redirect_target_url_to_bppages == 'bpuseractivity') {
					$redirect_target_url = bp_core_get_user_domain ( $user->ID );
				}
				
				if ($redirect_target_url_to_bppages == 'bpmembers') {
					$bpmembersslug = bp_get_members_root_slug ();
					$redirect_target_url = home_url ( $bpmembersslug );
				}
				
				if ($redirect_target_url_to_bppages == 'bpgroups') {
					$redirect_target_url = bp_get_groups_root_slug ();
				}
				
				if ($redirect_target_url_to_bppages == 'bpfriends') {
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . bp_get_activity_slug () . '/' . bp_get_friends_slug ();
				}
				
				if ($redirect_target_url_to_bppages == 'bpmessages') {
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . '/' . bp_get_messages_slug ();
				}
				
				if ($redirect_target_url_to_bppages == 'bpnotifications') {
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . '/' . bp_get_notifications_slug ();
				}
				
				if ($redirect_target_url_to_bppages == 'bpsettings') {
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . '/' . bp_get_settings_slug ();
				}
				
				if ($redirect_target_url_to_bppages == 'bpprofile') {
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . '/' . bp_get_profile_slug ();
				}
				
				if ($redirect_target_url_to_bppages == 'bpfavorites') {
					
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . bp_get_activity_slug () . '/favorites/';
				}
				
				if ($redirect_target_url_to_bppages == 'bpmentions') {
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . bp_get_activity_slug () . '/mentions/';
				}
				
				if ($redirect_target_url_to_bppages == 'bpsiteactivity') {
					$redirect_target_url = bp_get_root_domain () . '/' . bp_get_activity_root_slug ();
				}
				
				wp_safe_redirect ( $redirect_target_url );
				die ();
				return $redirect_target_url;
			}
			else
			{
				return $redirect_to;
			}
		}
	}
	return $redirect_to;
}


function tomas_login_form_redirect() 
{
	global $redirect_to,$wp_roles,$user,$user_ID;

		get_currentuserinfo();

	
		if (!isset($user->id))
		{
			return $redirect_to;
		}
		$tomas_roles_all_array =  $wp_roles->roles;
	

		foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array )
		{

			$tomas_roles_single_name = $tomas_roles_single_key;

			$tomas_roles_single_name_low = $tomas_roles_single_name;
	
			if (in_array($tomas_roles_single_name_low, $user->roles))
			{
	
			}
			else
			{
				continue;
			}
	
			$bpmemonlyredirecttypeafterlogin = 'bpmemonlyredirecttypeafterlogin_'. $tomas_roles_single_name;
	
			$bpmemonlyredirecturlafterlogin = 'bpmemonlyredirecturlafterlogin_'. $tomas_roles_single_name;
	
			$bpmemonlyredirecttypeafterlogout = 'bpmemonlyredirecttypeafterlogout_'. $tomas_roles_single_name;
	
			$bpmemonlyredirecturlafterlogout = 'bpmemonlyredirecturlafterlogout_'. $tomas_roles_single_name;
	
			$bpmemonlyredirecttypeafterloginoption = get_option($bpmemonlyredirecttypeafterlogin);
			$bpmemonlyredirecturlafterloginoption = get_option($bpmemonlyredirecturlafterlogin);
			$bpmemonlyredirecttypeafterlogoutoption = get_option($bpmemonlyredirecttypeafterlogout);
			$bpmemonlyredirecturlafterlogoutoption = get_option($bpmemonlyredirecturlafterlogout);
	
			if ($bpmemonlyredirecttypeafterloginoption == 'default')
			{
				$redirect_target_url = $redirect_to;
				return $redirect_target_url;
			}
	
			if ($bpmemonlyredirecttypeafterloginoption == 'referer')
			{
				$referer =  $_SERVER['HTTP_REFERER'];
				$referer_array = parse_url($referer);
				$referer_path = $referer_array['path'];
				if( $_SERVER['REQUEST_URI'] != $referer_path )
				{
					$redirect_target_url = $_SERVER['HTTP_REFERER'];
				}
				else
				{
					$redirect_target_url = get_option('siteurl');
				}
				$redirect_to = $redirect_target_url ;
				return $redirect_target_url;
			}
	
			if ($bpmemonlyredirecttypeafterloginoption == 'certain')
			{
					
				$redirect_target_url = $bpmemonlyredirecturlafterloginoption;
				$redirect_to = $redirect_target_url ;
				return $redirect_target_url;
			}
		}
}


function tomas_logout_redirect($redirect_to, $requested_redirect_to, $user)
{
	global  $wp_roles,$user_ID;


	get_currentuserinfo();

	if (!isset($user->id))
	{
		return $redirect_to;
	}

	get_currentuserinfo();

	$tomas_roles_all_array =  $wp_roles->roles;


	foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array )
	{

		$tomas_roles_single_name = $tomas_roles_single_key;
		

		$tomas_roles_single_name_low = $tomas_roles_single_name;

		if (in_array($tomas_roles_single_name_low, $user->roles))
		{

		}
		else
		{
			continue;
		}

		$bpmemonlyredirecttypeafterlogin = 'bpmemonlyredirecttypeafterlogin_'. $tomas_roles_single_name;

		$bpmemonlyredirecturlafterlogin = 'bpmemonlyredirecturlafterlogin_'. $tomas_roles_single_name;

		$bpmemonlyredirecttypeafterlogout = 'bpmemonlyredirecttypeafterlogout_'. $tomas_roles_single_name;

		$bpmemonlyredirecturlafterlogout = 'bpmemonlyredirecturlafterlogout_'. $tomas_roles_single_name;

		$bpmemonlyredirectbppagesafterlogout = 'bpmemonlyredirectbppagesafterlogout_'. $tomas_roles_single_name;

		
		$bpmemonlyredirecttypeafterloginoption = get_option($bpmemonlyredirecttypeafterlogin);
		$bpmemonlyredirecturlafterloginoption = get_option($bpmemonlyredirecturlafterlogin);
		$bpmemonlyredirecttypeafterlogoutoption = get_option($bpmemonlyredirecttypeafterlogout);
		$bpmemonlyredirecturlafterlogoutoption = get_option($bpmemonlyredirecturlafterlogout);
		$bpmemonlyredirectbppagesafterlogoutoption = get_option($bpmemonlyredirectbppagesafterlogout);
		
		
		
		if ($bpmemonlyredirecttypeafterlogoutoption == 'default')
		{
			$redirect_target_url = $redirect_to;
			return $redirect_target_url;
		}

		if ($bpmemonlyredirecttypeafterlogoutoption == 'referer')
		{
			$referer =  $_SERVER['HTTP_REFERER'];
			$referer_array = parse_url($referer);
			$referer_path = $referer_array['path'];
			if( $_SERVER['REQUEST_URI'] != $referer_path )
			{
				$redirect_target_url = $_SERVER['HTTP_REFERER'];
			}
			else
			{
				$redirect_target_url = get_option('siteurl');
			}
			return $redirect_target_url; 
		}

		if ($bpmemonlyredirecttypeafterlogoutoption == 'certain')
		{
			$redirect_target_url = $bpmemonlyredirecturlafterlogoutoption;
			return $redirect_target_url;
		}
		
		
		if ($bpmemonlyredirecttypeafterlogoutoption == 'bppages')
		{
			$is_buddypress_plugin_activated = in_array( 'buddypress/bp-loader.php', (array) get_option( 'active_plugins', array() ) );
				
			if (true == $is_buddypress_plugin_activated )
			{
				$redirect_target_url_to_bppages = $bpmemonlyredirectbppagesafterlogoutoption;
				
				if ($redirect_target_url_to_bppages == 'bpuseractivity') {
					$redirect_target_url = bp_core_get_user_domain ( $user->ID );
				}
				
				if ($redirect_target_url_to_bppages == 'bpmembers') {
					$bpmembersslug = bp_get_members_root_slug ();
					$redirect_target_url = home_url ( $bpmembersslug );
				}
				
				if ($redirect_target_url_to_bppages == 'bpgroups') {
					$redirect_target_url = bp_get_groups_root_slug ();
				}
				
				if ($redirect_target_url_to_bppages == 'bpfriends') {
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . bp_get_activity_slug () . '/' . bp_get_friends_slug ();
				}
				
				if ($redirect_target_url_to_bppages == 'bpmessages') {
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . '/' . bp_get_messages_slug ();
				}
				
				if ($redirect_target_url_to_bppages == 'bpnotifications') {
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . '/' . bp_get_notifications_slug ();
				}
				
				if ($redirect_target_url_to_bppages == 'bpsettings') {
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . '/' . bp_get_settings_slug ();
				}
				
				if ($redirect_target_url_to_bppages == 'bpprofile') {
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . '/' . bp_get_profile_slug ();
				}
				
				if ($redirect_target_url_to_bppages == 'bpfavorites') {
					
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . bp_get_activity_slug () . '/favorites/';
				}
				
				if ($redirect_target_url_to_bppages == 'bpmentions') {
					$redirect_target_url = tomas_bpmo_get_user_domain ( $user ) . bp_get_activity_slug () . '/mentions/';
				}
				
				if ($redirect_target_url_to_bppages == 'bpsiteactivity') {
					$redirect_target_url = bp_get_root_domain () . '/' . bp_get_activity_root_slug ();
				}
				
				wp_safe_redirect ( $redirect_target_url );
				die ();
				return $redirect_target_url;
			}
			else
			{
				return $redirect_to;				
			}
		}
		
	}
	return $redirect_to;
}


//add_action( 'login_form' , 'tomas_login_form_redirect' );
add_filter( 'login_redirect',  'tomas_login_redirect', 10, 3 );
add_filter( 'bp_login_redirect',  'tomas_login_redirect', 1, 3 );
add_filter( 'logout_redirect', 'tomas_logout_redirect', 10, 3 );


function tomas_bpmo_get_user_domain($user)
{
	$is_buddypress_plugin_activated = in_array( 'buddypress/bp-loader.php', (array) get_option( 'active_plugins', array() ) );
	
	if (true == $is_buddypress_plugin_activated )
	{
		$username = bp_core_get_username ( $user->ID );
		
		if (bp_is_username_compatibility_mode ()) {
			$username = rawurlencode ( $username );
		}
		
		$after_domain = bp_core_enable_root_profiles () ? $username : bp_get_members_root_slug () . '/' . $username;
		$domain = trailingslashit ( bp_get_root_domain () . '/' . $after_domain );
	}
	else
	{
		$domain = get_option('siteurl');
	}
	
	return $domain;
}

function buddypress_members_get_setting_panel_head($title)
{
	?>
	<div style='margin:10px 5px;'>
		<div style='float:left;margin-right:10px;'>
			<img src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/buddypress-members-only-pro/images/new.png' style='width:30px;height:30px;'>
		</div>
		<div style='padding-top:5px; font-size:22px;'><?php echo $title; ?></div>
	</div>
	
	<div style='clear:both'></div>
<?php 
}

function buddypress_user_type_filter($userinput)
{
	$userinput = rtrim(strtolower($userinput),'/');
	return $userinput;
		
}

?>