<?php
if (! defined ( 'WPINC' )) {
	exit ( 'Please do not access our files directly.' );
}
function buddypress_members_component_setting() {
	global $wpdb, $wp_roles;
	$tomas_roles_all_array = $wp_roles->roles;
	if (isset ( $_POST ['bpcomponentsubmit'] )) {
		check_admin_referer ( 'bpcomponentsubmitnonce' );
		if (isset ( $_POST ['bpstandardcomponent'] )) {
			$m_bpstandardcomponent = $_POST ['bpstandardcomponent'];
			update_option ( 'bpstandardcomponent', $m_bpstandardcomponent );
		} else {
			delete_option ( 'bpstandardcomponent' );
		}
		
		if (isset ( $_POST ['bpopenedcustomizedcomponent'] )) {
			$bpopenedcustomizedcomponent = trim ( $_POST ['bpopenedcustomizedcomponent'] );
			if (strlen ( $bpopenedcustomizedcomponent ) == 0) {
				delete_option ( 'bpopenedcustomizedcomponent' );
			} else {
				$bpopenedcustomizedcomponent = sanitize_textarea_field ( $bpopenedcustomizedcomponent ); 
				update_option ( 'bpopenedcustomizedcomponent', $bpopenedcustomizedcomponent );
			}
			$bpmoMessageString = __ ( 'Your changes has been saved.', 'bp-members-only' );
			buddypress_members_only_pro_message ( $bpmoMessageString );
		}
	}
	
	foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array ) {
		$bp_component_role_id = $tomas_roles_single_key;
		
		$bp_component_role_id = str_replace ( ' ', '-', $tomas_roles_single_key );
		
		$rolebasedstandardcomponent = 'bpstandardcomponent_' . $bp_component_role_id;
		$rolebasedcustomizedcomponent = 'bpopenedcustomizedcomponent_' . $bp_component_role_id;
		
		$rolebasedstandardcomponentoption = get_option ( $rolebasedstandardcomponent );
		$rolebasedcustomizedcomponentoption = get_option ( $rolebasedcustomizedcomponent );
		
		if (isset ( $_POST ['bpcomponentsubmit_' . $bp_component_role_id] )) {
			
			if ((isset ( $_POST [$rolebasedstandardcomponent] )) && (! (empty ( $rolebasedstandardcomponent )))) {
				update_option ( $rolebasedstandardcomponent, $_POST [$rolebasedstandardcomponent] );
			} else {
				delete_option ( $rolebasedstandardcomponent );
			}
			
			if ((isset ( $_POST [$rolebasedcustomizedcomponent] )) && (! (empty ( $rolebasedcustomizedcomponent )))) {
				update_option ( $rolebasedcustomizedcomponent, sanitize_textarea_field ( $_POST [$rolebasedcustomizedcomponent] ) );
			} else {
				delete_option ( $rolebasedcustomizedcomponent );
			}
			$bpmoMessageString = __ ( 'Your changes has been saved.', 'bp-members-only' );
			buddypress_members_only_pro_message ( $bpmoMessageString );
		}
	}
	
	$m_bpstandardcomponent = get_option ( 'bpstandardcomponent' );
	
	echo "<br />";
	
	$setting_panel_head = 'Buddypress Members Only Components Setting:';
	buddypress_members_get_setting_panel_head ( $setting_panel_head );
	
	$saved_register_page_url = get_option ( 'bpmoregisterpageurl' );
	
	$bp_component_default_role = array ();
	$bp_component_default_role = 'default';
	buddypress_members_setting_panel ( $bp_component_default_role );
	
	foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array ) {
		buddypress_members_setting_panel ( $tomas_roles_single_key );
	}
}
function buddypress_members_setting_panel($bp_component_role) {
	global $wpdb, $wp_roles;
	
	$m_bpstandardcomponent = get_option ( 'bpstandardcomponent' );
	
	if (empty ( $bp_component_role )) {
		$bp_component_role = array ();
		$bp_component_role = 'default';
	}
	
	$bp_component_role_id = str_replace ( ' ', '-', $bp_component_role );
	
	$rolebasedstandardcomponent = 'bpstandardcomponent_' . $bp_component_role_id;
	$rolebasedcustomizedcomponent = 'bpopenedcustomizedcomponent_' . $bp_component_role_id;
	
	$rolebasedstandardcomponentoption = get_option ( $rolebasedstandardcomponent );
	$rolebasedcustomizedcomponentoption = get_option ( $rolebasedcustomizedcomponent );
	?>
<div class="wrap">
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
			<div id="post-body">
				<div id="dashboard-widgets-main-content">
					<div class="postbox-container" style="width: 90%;">
						<div
							class="postbox bp-members-pro-componet-each-role-bar close-bar"
							data-user-role="<?php echo $bp_component_role_id ?>">
							<span>+</span>
							<h3 class='hndle'
								style='padding: 10px; ! important; border-bottom: 0px solid #eee !important;'>
	<?php
	if ('default' == $bp_component_role_id) {
		$tomas_roles_single_name = 'default';
		$eachrolestandardcompentname = 'bpstandardcomponent[]';
		$eachrolecustomizedcompentname = 'bpopenedcustomizedcomponent';
		$bpopenedcustomizedcomponentarray = get_option ( 'bpopenedcustomizedcomponent' );
		
		$m_bpstandardcomponent = get_option ( 'bpstandardcomponent' );
		$rolebasedstandardcomponentsubmit = 'bpcomponentsubmit';
		echo __ ( 'Restricts These BP Components to -- ' . '<strong>' . __ ( 'Non Members / Guest Users' ) . '</strong>', 'bp-members-only' );
	} else {
		$tomas_roles_single_name = $bp_component_role;
		$tomas_roles_single_checked_name = str_replace ( ' ', '-', $bp_component_role );
		
		$eachrolestandardcompentname = 'bpstandardcomponent_' . $tomas_roles_single_checked_name . '[]';
		$eachrolecustomizedcompentname = 'bpopenedcustomizedcomponent_' . $tomas_roles_single_checked_name;
		$bpopenedcustomizedcomponentarray = get_option ( $eachrolecustomizedcompentname );
		
		$m_bpstandardcomponent = get_option ( 'bpstandardcomponent_' . $tomas_roles_single_checked_name );
		$rolebasedstandardcomponentsubmit = 'bpcomponentsubmit_' . $bp_component_role_id;
		echo __ ( 'Restricts These BP Components to Logged in/Registered Members Only -- User Role: ' . '<strong>' . $tomas_roles_single_name . '</strong>', 'bp-members-only' );
	}
	?>
									</h3>

						</div>
						<div class="inside bp-component-setting postbox"
							style='padding-left: 10px; border-top: 1px solid #eee;'
							id=<?php echo $bp_component_role_id ?>>
							<form id="bpmoform" name="bpmoform" action="" method="POST">
								<table id="bpmotable" width="100%">
									<tr>
										<td width="30%" style="padding: 30px 20px 20px 20px;"
											valign="top">
											<?php
	echo __ ( 'Opened BP Standard Components:', 'bp-members-only' );
	?>
											</td>
										<td width="70%" style="padding: 20px;">
											<p>
											<?php
	if ((! (empty ( $m_bpstandardcomponent ))) && (is_array ( $m_bpstandardcomponent )) && (count ( $m_bpstandardcomponent ) > 0) && (in_array ( 'activity', $m_bpstandardcomponent ))) {
		echo '<input type="checkbox" id="bpstandardcomponentactivity" name="' . $eachrolestandardcompentname . '"  style="" value="activity"  checked="checked"> Buddypress Activity Component';
	} else {
		echo '<input type="checkbox" id="bpstandardcomponentactivity" name="' . $eachrolestandardcompentname . '"  style="" value="activity" > Buddypress Activity Component';
	}
	?>
											</p>
											<p>
											<?php
	if ((! (empty ( $m_bpstandardcomponent ))) && (is_array ( $m_bpstandardcomponent )) && (count ( $m_bpstandardcomponent ) > 0) && (in_array ( 'members', $m_bpstandardcomponent ))) {
		echo '<input type="checkbox" id="bpstandardcomponentmembers" name="' . $eachrolestandardcompentname . '"  style="" value="members"   checked="checked"> Buddypress Members Component';
	} else {
		echo '<input type="checkbox" id="bpstandardcomponentmembers" name="' . $eachrolestandardcompentname . '"  style="" value="members" > Buddypress Members Component';
	}
	?>
											</p>
											<p>
											 <?php
	if ((! (empty ( $m_bpstandardcomponent ))) && (is_array ( $m_bpstandardcomponent )) && (count ( $m_bpstandardcomponent ) > 0) && (in_array ( 'forums', $m_bpstandardcomponent ))) {
		echo '<input type="checkbox" id="bpstandardcomponentforums" name="' . $eachrolestandardcompentname . '"  style="" value="forums"   checked="checked"> Buddypress Forums Component';
	} else {
		echo '<input type="checkbox" id="bpstandardcomponentforums" name="' . $eachrolestandardcompentname . '"  style="" value="forums" > Buddypress Forums Component';
	}
	?>										 
											</p>
											<p>
											 <?php
	if ((! (empty ( $m_bpstandardcomponent ))) && (is_array ( $m_bpstandardcomponent )) && (count ( $m_bpstandardcomponent ) > 0) && (in_array ( 'friends', $m_bpstandardcomponent ))) {
		echo '<input type="checkbox" id="bpstandardcomponentfriends" name="' . $eachrolestandardcompentname . '"  style="" value="friends" checked="checked"> Buddypress Friends Component';
	} else {
		echo '<input type="checkbox" id="bpstandardcomponentfriends" name="' . $eachrolestandardcompentname . '"  style="" value="friends" > Buddypress Friends Component';
	}
	?>
											</p>
											<p>
											 <?php
	if ((! (empty ( $m_bpstandardcomponent ))) && (is_array ( $m_bpstandardcomponent )) && (count ( $m_bpstandardcomponent ) > 0) && (in_array ( 'groups', $m_bpstandardcomponent ))) {
		echo '<input type="checkbox" id="bpstandardcomponentgroups" name="' . $eachrolestandardcompentname . '"  style="" value="groups"  checked="checked"> Buddypress Groups Component';
	} else {
		echo '<input type="checkbox" id="bpstandardcomponentgroups" name="' . $eachrolestandardcompentname . '"  style="" value="groups" > Buddypress Groups Component';
	}
	?>
											</p>
											<p>
											 <?php
	if ((! (empty ( $m_bpstandardcomponent ))) && (is_array ( $m_bpstandardcomponent )) && (count ( $m_bpstandardcomponent ) > 0) && (in_array ( 'messages', $m_bpstandardcomponent ))) {
		echo '<input type="checkbox" id="bpstandardcomponentmessages" name="' . $eachrolestandardcompentname . '"  style="" value="messages"  checked="checked"> Buddypress Messages Component';
	} else {
		echo '<input type="checkbox" id="bpstandardcomponentmessages" name="' . $eachrolestandardcompentname . '"  style="" value="messages" > Buddypress Messages Component';
	}
	?>
											</p>
											<p>
											 <?php
	if ((! (empty ( $m_bpstandardcomponent ))) && (is_array ( $m_bpstandardcomponent )) && (count ( $m_bpstandardcomponent ) > 0) && (in_array ( 'notifications', $m_bpstandardcomponent ))) {
		echo '<input type="checkbox" id="bpstandardcomponentnotifications" name="' . $eachrolestandardcompentname . '"  style="" value="notifications"  checked="checked"> Buddypress Notifications Component';
	} else {
		echo '<input type="checkbox" id="bpstandardcomponentnotifications" name="' . $eachrolestandardcompentname . '"  style="" value="notifications" > Buddypress Notifications Component';
	}
	?>
											
											
											<p>
											 <?php
	if ((! (empty ( $m_bpstandardcomponent ))) && (is_array ( $m_bpstandardcomponent )) && (count ( $m_bpstandardcomponent ) > 0) && (in_array ( 'settings', $m_bpstandardcomponent ))) {
		echo '<input type="checkbox" id="bpstandardcomponentsettings" name="' . $eachrolestandardcompentname . '"  style="" value="settings" checked="checked"> Buddypress Settings  Component';
	} else {
		echo '<input type="checkbox" id="bpstandardcomponentsettings" name="' . $eachrolestandardcompentname . '"  style="" value="settings" > Buddypress Settings  Component';
	}
	?>
											</p>
											<p>
											 <?php
	if ((! (empty ( $m_bpstandardcomponent ))) && (is_array ( $m_bpstandardcomponent )) && (count ( $m_bpstandardcomponent ) > 0) && (in_array ( 'profile', $m_bpstandardcomponent ))) {
		echo '<input type="checkbox" id="bpstandardcomponentprofile" name="' . $eachrolestandardcompentname . '"  style="" value="profile" checked="checked"> Buddypress Profile  Component';
	} else {
		echo '<input type="checkbox" id="bpstandardcomponentprofile" name="' . $eachrolestandardcompentname . '"  style="" value="profile" > Buddypress Profile  Component';
	}
	?>
											</p>
											<p>
											<?php
	if ((! (empty ( $m_bpstandardcomponent ))) && (is_array ( $m_bpstandardcomponent )) && (count ( $m_bpstandardcomponent ) > 0) && (in_array ( 'blogs', $m_bpstandardcomponent ))) {
		echo '<input type="checkbox" id="bpstandardcomponentblogs" name="' . $eachrolestandardcompentname . '"  style="" value="blogs"   checked="checked"> Buddypress Blogs Component';
	} else {
		echo '<input type="checkbox" id="bpstandardcomponentblogs" name="' . $eachrolestandardcompentname . '"  style="" value="blogs" > Buddypress Blogs Component';
	}
	?>
											</p>
											<p>
												<font color="Gray"><i>
											<?php echo  __( 'Checked component  will opened to ', 'bp-members-only' ); ?>
											<?php
	if ($tomas_roles_single_name == 'default') {
		$tomas_roles_single_name = 'guest';
	}
	echo $tomas_roles_single_name;
	?>
											</i>
											
											</p>
										</td>
									</tr>

									<tr style="margin-top: 30px;">
										<td width="30%" style="padding: 20px;" valign="top">
											<?php
	echo __ ( 'Opened Customized Components:', 'bp-members-only' );
	?>
											</td>
										<td width="70%" style="padding: 20px;"><textarea
												name="<?php echo $eachrolecustomizedcompentname; ?>"
												id="bpopenedcustomizedcomponent" cols="70" rows="10"
												style="width: 500px;"><?php echo $bpopenedcustomizedcomponentarray; ?></textarea>
											<p>
												<font color="Gray"><i><?php echo  __( 'Enter one component name per line please.', 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( 'Enter component name please, for example, for buddypress family component, please enter "family"', 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( 'If you do not know components name of your plugin, please contact the plugin author, if you hire me to do it or design a Component, I can do it quickly for you', 'bp-members-only' ); ?></i>
											
											</p>
										</td>
									</tr>
								</table>
								<br />
											<?php
	wp_nonce_field ( 'bpcomponentsubmitnonce' );
	?>
											<input type="submit" id="bpcomponentsubmit"
									name="<?php echo $rolebasedstandardcomponentsubmit; ?>"
									value=" Submit " style="margin: 1px 20px;">
							</form>
							<br />
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div style="clear: both"></div>
<?php
}