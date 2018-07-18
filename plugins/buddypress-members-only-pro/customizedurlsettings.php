<?php
if (! defined ( 'WPINC' )) {
	exit ( 'Please do not access our files directly.' );
}
function buddypress_member_customized_url_restricts_setting() {
	global $wpdb, $wp_roles;
	
	$tomas_roles_all_array = $wp_roles->roles;
	if (isset ( $_POST ['bpcustomizedurlsubmit'] )) {
		check_admin_referer ( 'customizedurlsubmitnonce' );
		if (isset ( $_POST ['bpopenedcustomizedurls'] )) {
			$bpopenedcustomizedurls = trim ( $_POST ['bpopenedcustomizedurls'] );
			if (strlen ( $bpopenedcustomizedurls ) == 0) {
				delete_option ( 'bpopenedcustomizedurls' );
			} else {
				update_option ( 'bpopenedcustomizedurls', sanitize_textarea_field ( $bpopenedcustomizedurls ) );
			}
			$bpmoMessageString = __ ( 'Your changes has been saved.', 'bp-members-only' );
			buddypress_members_only_pro_message ( $bpmoMessageString );
		}
	}

	if (isset ( $_POST ['bpcustomizedurlsubmit'] )) {
		check_admin_referer ( 'customizedurlsubmitnonce' );
		if (isset ( $_POST ['bpclosedcustomizedurls'] )) {
			$bpclosedcustomizedurls = trim ( $_POST ['bpclosedcustomizedurls'] );
			if (strlen ( $bpclosedcustomizedurls ) == 0) {
				delete_option ( 'bpclosedcustomizedurls' );
			} else {
				update_option ( 'bpclosedcustomizedurls', sanitize_textarea_field ( $bpclosedcustomizedurls ) );
			}
			$bpmoMessageString = __ ( 'Your changes has been saved.', 'bp-members-only' );
			buddypress_members_only_pro_message ( $bpmoMessageString );
		}
	}

	foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array ) {
		
		$bp_component_role_id = $tomas_roles_single_key;
		$bp_component_role_id = str_replace ( ' ', '-', $tomas_roles_single_key );
		
		$rolebasedcustomizedcomponent = 'bpopenedcustomizedurls_' . $bp_component_role_id;
		
		$rolebasedcustomizedcomponentoption = get_option ( $rolebasedcustomizedcomponent );
		
		if (isset ( $_POST ['bpcustomizedurlsubmit_' . $bp_component_role_id] )) {
			
			if ((isset ( $_POST [$rolebasedcustomizedcomponent] )) && (! (empty ( $rolebasedcustomizedcomponent )))) {
				update_option ( $rolebasedcustomizedcomponent, sanitize_textarea_field ( $_POST [$rolebasedcustomizedcomponent] ) );
			} else {
				delete_option ( $rolebasedcustomizedcomponent );
			}
			$bpmoMessageString = __ ( 'Your changes has been saved.', 'bp-members-only' );
			buddypress_members_only_pro_message ( $bpmoMessageString );
		}
		
		$rolebasedclosedcustomizedcomponent = 'bpclosedcustomizedurls_' . $bp_component_role_id;
		$rolebasedclosedcustomizedcomponentoption = get_option ( $rolebasedclosedcustomizedcomponent );		
		if (isset ( $_POST ['bpclosedcustomizedurls_' . $bp_component_role_id] )) {
			if ((isset ( $_POST [$rolebasedclosedcustomizedcomponent] )) && (! (empty ( $rolebasedclosedcustomizedcomponent )))) {
				update_option ( $rolebasedclosedcustomizedcomponent, sanitize_textarea_field ( $_POST [$rolebasedclosedcustomizedcomponent] ) );
			} else {
				delete_option ( $rolebasedclosedcustomizedcomponent );
			}
			$bpmoMessageString = __ ( 'Your changes has been saved.', 'bp-members-only' );
			buddypress_members_only_pro_message ( $bpmoMessageString );
		}		
	}
	
	echo "<br />";
	
	$setting_panel_head = 'Buddypress Members Only Customized URL Setting:';
	buddypress_members_get_setting_panel_head ( $setting_panel_head );
	
	$saved_register_page_url = get_option ( 'bpmoregisterpageurl' );
	
	$bp_component_default_role = array ();
	$bp_component_default_role = 'default';
	buddypress_members_customized_url_protect_setting_panel ( $bp_component_default_role );
	
	foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array ) {
		buddypress_members_customized_url_protect_setting_panel ( $tomas_roles_single_key );
	}
}
function buddypress_members_customized_url_protect_setting_panel($bp_component_role) {
	global $wpdb, $wp_roles;
	
	$m_bpstandardcomponent = get_option ( 'bpstandardcomponent' );
	
	if (empty ( $bp_component_role )) {
		$bp_component_role = array ();
		$bp_component_role = 'default';
	}
	
	$bp_component_role_id = str_replace ( ' ', '-', $bp_component_role );
	
	$rolebasedstandardcomponent = 'bpstandardcomponent_' . $bp_component_role_id;
	$rolebasedcustomizedcomponent = 'bpopenedcustomizedurls_' . $bp_component_role_id;
	
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
		$eachrolecustomizedcompentname = 'bpopenedcustomizedurls';
		$bpopenedcustomizedurlsarray = get_option ( 'bpopenedcustomizedurls' );

		$eachrolecustomizedclosedurls = 'bpclosedcustomizedurls';
		$bpclosedcustomizedurlsarray = get_option ( $eachrolecustomizedclosedurls );

		$m_bpstandardcomponent = get_option ( 'bpstandardcomponent' );
		$rolebasedstandardcomponentsubmit = 'bpcustomizedurlsubmit';
		echo __ ( 'Open These Customized URL to -- ' . '<strong>' . __ ( 'Non Members / Guest Users' ) . '</strong>', 'bp-members-only' );
	} else {
		$tomas_roles_single_name = $bp_component_role;
		$tomas_roles_single_checked_name = str_replace ( ' ', '-', $bp_component_role );
		
		$eachrolestandardcompentname = 'bpstandardcomponent_' . $tomas_roles_single_checked_name . '[]';
		$eachrolecustomizedcompentname = 'bpopenedcustomizedurls_' . $tomas_roles_single_checked_name;
		$bpopenedcustomizedurlsarray = get_option ( $eachrolecustomizedcompentname );
		
		$eachrolecustomizedclosedurls	= 'bpclosedcustomizedurls_' . $tomas_roles_single_checked_name;
		
		$bpclosedcustomizedurlsarray = get_option ( $eachrolecustomizedclosedurls );
		
		$m_bpstandardcomponent = get_option ( 'bpstandardcomponent_' . $tomas_roles_single_checked_name );
		$rolebasedstandardcomponentsubmit = 'bpcustomizedurlsubmit_' . $bp_component_role_id;
		echo __ ( 'Open These Customized URL to Logged in/Registered Members Only -- User Role: ' . '<strong>' . $tomas_roles_single_name . '</strong>', 'bp-members-only' );
	}
	?>
									</h3>

						</div>
						<div class="inside bp-component-setting postbox"
							style='padding-left: 10px; border-top: 1px solid #eee;'
							id=<?php echo $bp_component_role_id ?>>
							<form id="bpmoform" name="bpmoform" action="" method="POST">
								<table id="bpmotable" width="100%">
									<tr style="margin-top: 30px;">
										<td width="30%" style="padding: 20px;" valign="top">
											<?php
												echo __ ( 'Opened Customized URLs:', 'bp-members-only' );
										?>
										</td>
										
										<td width="70%" style="padding: 20px;">
										<textarea name="<?php echo $eachrolecustomizedcompentname; ?>"id="bpopenedcustomizedurls" cols="70" rows="10"	style="width: 500px;"><?php echo $bpopenedcustomizedurlsarray; ?></textarea>
										</td>
										</tr>
										
										<tr style="margin-top: 30px;">
										<td width="30%" style="padding: 20px;" valign="top">
											<?php
												echo __ ( 'Closed Customized URLs:', 'bp-members-only' );
										?>
										</td>
										
										<td width="70%" style="padding: 20px;">
										<textarea name="<?php echo $eachrolecustomizedclosedurls; ?>"id="bpclosedcustomizedurls" cols="70" rows="10"	style="width: 500px;"><?php echo $bpclosedcustomizedurlsarray; ?></textarea>
										</td>
										</tr>
																				
										<tr>
										<td width="30%" style="padding: 20px;" valign="top">
											<?php
										echo __ ( 'Please Note:', 'bp-members-only' );
										?>									
										</td>
										<td width="70%" style="padding: 20px;">
											<div>
												<font color="Gray"><i><?php echo  __( 'Enter one URL per line please.', 'bp-members-only' ); ?></i>
											
											</div>
											<p>
												<font color="Gray"><i><?php echo  __( 'You may use the following placeholders in the customized URLs at below.', 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><code>%username%</code> <code>%sitename%</code></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( 'You can enter URLs like this:', 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( '# For example: https://yourdomain.com/members/%username%/forums/.', 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( '# For example: %sitename%/family/%username%/.', 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( "we will replace <code>%sitename%</code> with your site url, site url is come from wordpress 'siteurl' field which stored in wordpress option table, in general it looks like: 'http://yourdomain.com/'.", 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( "we will replace <code>%username%</code> with logged in users' login name, for examle -- 'admin' ", 'bp-members-only' ); ?></i>
											
											</p>
											<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# please note, "Closed Customized URLs" option in ', 'bp-members-only' );
	echo "<a  style='color:#4e8c9e;' href='" . get_option ( 'siteurl' ) . "/wp-admin/admin.php?page=bpmembercustomizedurlrestricts' target='_blank'>Customized URL Setting Panel</a>";
	echo __ ( ', have higher priority than "Opened Customized URLs" option', 'bp-members-only' );
	?></i>
											</p>
											<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# please note, "Closed Customized URLs" option in ', 'bp-members-only' );
	echo "<a  style='color:#4e8c9e;' href='" . get_option ( 'siteurl' ) . "/wp-admin/admin.php?page=bpmembercustomizedurlrestricts' target='_blank'>Customized URL Setting Panel</a>";
	echo __ ( ', have higher priority than "Components Setting" option ', 'bp-members-only' );
	echo "at <a  style='color:#4e8c9e;' href='" . get_option ( 'siteurl' ) . "/wp-admin/admin.php?page=bpmembercomponentonly' target='_blank'>Customized URL Setting Panel</a>";
	?></i>
											</p>
											</td>
									</tr>
								</table>
								<br />
											<?php
	wp_nonce_field ( 'customizedurlsubmitnonce' );
	?>
											<input type="submit" id="bpcustomizedurlsubmit"
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

/** close these url to users */
function buddypress_members_closed_url_protect_setting_panel($bp_component_role) {
	global $wpdb, $wp_roles;

	$m_bpstandardcomponent = get_option ( 'bpstandardcomponent' );

	if (empty ( $bp_component_role )) {
		$bp_component_role = array ();
		$bp_component_role = 'default';
	}

	$bp_component_role_id = str_replace ( ' ', '-', $bp_component_role );

	$rolebasedstandardcomponent = 'bpstandardcomponent_' . $bp_component_role_id;
	$rolebasedcustomizedcomponent = 'bpopenedcustomizedurls_' . $bp_component_role_id;

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
		$eachrolecustomizedcompentname = 'bpopenedcustomizedurls';
		$bpopenedcustomizedurlsarray = get_option ( 'bpopenedcustomizedurls' );
		
		$m_bpstandardcomponent = get_option ( 'bpstandardcomponent' );
		$rolebasedstandardcomponentsubmit = 'bpcustomizedurlsubmit';
		echo __ ( 'Open These Customized URL to -- ' . '<strong>' . __ ( 'Non Members / Guest Users' ) . '</strong>', 'bp-members-only' );
	} else {
		$tomas_roles_single_name = $bp_component_role;
		$tomas_roles_single_checked_name = str_replace ( ' ', '-', $bp_component_role );
		
		$eachrolestandardcompentname = 'bpstandardcomponent_' . $tomas_roles_single_checked_name . '[]';
		$eachrolecustomizedcompentname = 'bpopenedcustomizedurls_' . $tomas_roles_single_checked_name;
		$bpopenedcustomizedurlsarray = get_option ( $eachrolecustomizedcompentname );
		
		$m_bpstandardcomponent = get_option ( 'bpstandardcomponent_' . $tomas_roles_single_checked_name );
		$rolebasedstandardcomponentsubmit = 'bpcustomizedurlsubmit_' . $bp_component_role_id;
		echo __ ( 'Open These Customized URL to Logged in/Registered Members Only -- User Role: ' . '<strong>' . $tomas_roles_single_name . '</strong>', 'bp-members-only' );
	}
	?>
									</h3>

						</div>
						<div class="inside bp-component-setting postbox"
							style='padding-left: 10px; border-top: 1px solid #eee;'
							id=<?php echo $bp_component_role_id ?>>
							<form id="bpmoform" name="bpmoform" action="" method="POST">
								<table id="bpmotable" width="100%">
									<tr style="margin-top: 30px;">
										<td width="30%" style="padding: 20px;" valign="top">
											<?php
	echo __ ( 'Opened Customized URLs:', 'bp-members-only' );
	?>
											</td>
										<td width="70%" style="padding: 20px;"><textarea
												name="<?php echo $eachrolecustomizedcompentname; ?>"
												id="bpopenedcustomizedurls" cols="70" rows="10"
												style="width: 500px;"><?php echo $bpopenedcustomizedurlsarray; ?></textarea>
											<p>
												<font color="Gray"><i><?php echo  __( 'Enter one URL per line please.', 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( 'You may use the following placeholders in the customized URLs at below.', 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><code>%username%</code> <code>%sitename%</code></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( 'You can enter URLs like this:', 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( '# For example: https://yourdomain.com/members/%username%/forums/.', 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( '# For example: %sitename%/family/%username%/.', 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( "we will replace <code>%sitename%</code> with your site url, site url is come from wordpress 'siteurl' field which stored in wordpress option table, in general it looks like: 'http://yourdomain.com/'.", 'bp-members-only' ); ?></i>
											
											</p>
											<p>
												<font color="Gray"><i><?php echo  __( "we will replace <code>%username%</code> with logged in users' login name, for examle -- 'admin' ", 'bp-members-only' ); ?></i>
											
											</p></td>
									</tr>
								</table>
								<br />
											<?php
	wp_nonce_field ( 'customizedurlsubmitnonce' );
	?>
											<input type="submit" id="bpcustomizedurlsubmit"
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


