<?php
// approve version 1.0
if (!defined('ABSPATH'))
{
	exit;
}

$bpmoproApproveUserVersion = get_option('bpmoproApproveUserVersion');
if (empty($bpmoproApproveUserVersion))
{
	$bpmoproApproveUserVersion = '1.0';
	update_option('bpmoproApproveUserVersion',$bpmoproApproveUserVersion);
}

$enableBPMOPROAddonapproveuser = get_option("enableBPMOPROAddonapproveuser");

if($enableBPMOPROAddonapproveuser <> 'YES')
{
	return false;
}


function bpmoproIsAdmin($userID)
{
	$is_admin = user_can($userID, 'delete_users');
	if ($is_admin == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function bpmoproApproveUserAuthenticateUser( $user ) 
{
	if ($user->ID == 1)
	{
		return $user;
	}
	
	$is_admin = false;
	$is_admin = bpmoproIsAdmin($user->ID);
	
	if ($is_admin)
	{
		return $user;
	}
	
	$currentUserHasApproved = get_user_meta( $user->ID, 'bpmoproApproveUserStatus', true );
	if ('approved' <> $currentUserHasApproved)
	{
		$bpmoproApproveUserAuthenticateUserErrorMessage  = '<b>Sorry</b>, please wait site administrator approve your account manually, thanks';
		return new WP_Error( 'bpmopro_approve_user_error', $bpmoproApproveUserAuthenticateUserErrorMessage );
		
	}

	return $user;
}

add_filter('wp_authenticate_user', 'bpmoproApproveUserAuthenticateUser');


function bpmoproApproveUserAction( $userID )
{
	if ($userID == 1)
	{
		return $user;
	}

	update_user_meta( $userID, 'bpmoproApproveUserStatus', 'approved' );
	return true;
}


function bpmoproUnApproveUserAction( $userID )
{
	if ($userID == 1)
	{
		return $user;
	}

	update_user_meta( $userID, 'bpmoproApproveUserStatus', 'unapprove' );
	return true;
}


function bpmoproApproveUserStatusProfileDisplay($profileuser)
{
	if ( ! current_user_can( 'edit_user', $profileuser->ID ) )
		return;
?>	
			<table class="bpmppro-approve-table">
				<tbody>
					<tr>
						<th style='padding: 20px 10px 20px 0; font-weight: 600;  line-height: 1.3;font-size: 14px;  color: #23282d; margin:0px; width: 200px; text-align:left;'><label for="bpmppro-approve-selector"><?php echo __( 'Approve User', 'bp-members-only' ); ?></label></th>
						<td>
	
							<?php 
								$currentUserHasApproved = get_user_meta( $profileuser->ID, 'bpmoproApproveUserStatus', true );
								if (empty($currentUserHasApproved))
								{
									$currentUserHasApproved = 'unapprove';
								}
							?>
							<select name="bpmppro-approve-selector" id="bpmppro-approve-selector">
									<option value="approved" <?php selected($currentUserHasApproved,'approved'); ?>><?php echo __( 'Approve this user login my site', 'bp-members-only' ); ?></option>
									<option value="unapprove" <?php selected($currentUserHasApproved,'unapprove'); ?>><?php echo __( 'Unapprove this user login my site', 'bp-members-only' ); ?></option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<?php	
}
add_action( 'edit_user_profile', 'bpmoproApproveUserStatusProfileDisplay' );


function bpmoproApproveUserSaveStatusProfile($user_id)
{
	if (isset($_POST['bpmppro-approve-selector']))
	{
		update_user_meta( $user_id, 'bpmoproApproveUserStatus', $_POST['bpmppro-approve-selector'] );
	}
}

add_action('edit_user_profile_update', 'bpmoproApproveUserSaveStatusProfile');
add_action('personal_options_update', 'bpmoproApproveUserSaveStatusProfile');
add_action('user_register', 'bpmoproApproveUserSaveStatusProfile');


function bpmoproApproveUserStatusUserLists( $actions, $user_object ) 
{
	$is_admin = bpmoproIsAdmin($user_object->ID);
	$get_current_user_id = get_current_user_id(); 
	
	if ( ($is_admin == false) && ($user_object->ID <> 1) && (current_user_can('edit_user',$user_object->ID)) && ($get_current_user_id <> $user_object->ID)) 
	{
		$bpmoproApproveUserStatus = get_user_meta( $user_object->ID, 'bpmoproApproveUserStatus', true );
		
		if (empty($bpmoproApproveUserStatus))
		{
			$bpmoproApproveUserStatus = 'unapprove';
		}
		
		if (!(empty($bpmoproApproveUserStatus)))
		{
			$bpmoproApproveUserStatusLabel = '';
			if (strtolower($bpmoproApproveUserStatus) == 'unapprove')
			{
				$bpmoproApproveUserStatusLabel = 'Unapproved';
			}
			
			if (strtolower($bpmoproApproveUserStatus) == 'approved')
			{
				$bpmoproApproveUserStatusLabel = 'Approved';
			}				
		}

		
		$bpmoproapproveAction = "<span class='$bpmoproApproveUserStatus'>";
		$bpmoproApproveUserStatus = ucfirst($bpmoproApproveUserStatus);
		$bpmoproApproveActionURL = get_option('siteurl').'/wp-admin/user-edit.php?user_id='.$user_object->ID;
		$bpmoproapproveAction .= "<a href='$bpmoproApproveActionURL'>". $bpmoproApproveUserStatusLabel.'</a>';
		$bpmoproapproveAction .= "</span>";
		$actions['bpmoproapprove'] = $bpmoproapproveAction;
	}


	return $actions;
}

add_filter( 'user_row_actions', 'bpmoproApproveUserStatusUserLists', 10, 2 );

function bpmoproApproveAdminCss()
{
	wp_enqueue_style('bpmoproApproveAdminCss', plugin_dir_url( __FILE__ ) .'/bpmopro_approve/bpmopro_approve.css');
}
add_action('admin_head', 'bpmoproApproveAdminCss');


function bpmoproApproveJSUserrLists() {
	?>
	<script type="text/javascript">
		jQuery( document ).ready( function($) {
			$( '.row-actions .unapprove' ).each( function() {
				$( this ).closest( 'tr' ).addClass( 'unapproveduser' );
			});
		});
	</script>
	<?php
}

add_action( 'admin_footer', 'bpmoproApproveJSUserrLists' );


function buddypress_members_only_pro_approve_user_manager()
{
	global $wpdb, $wp_roles;
	
	if (isset ( $_POST ['bponeclickresetsubmit'] )) {
		
		check_admin_referer ( 'bpmoproapproveusersnonce' );
		if (isset ( $_POST ['bpmoproapprovealluserscheckbox'] )) 
		{
			$existedusers = get_users();
			if ((!(empty($existedusers))) && (is_array($existedusers)) && (count($existedusers) >0))
			{
				foreach ($existedusers as $approcinguser)
				{
					$approcingUserStatus = $approcinguser->data->user_status;
					if ($approcingUserStatus == 2)
					{
						continue;
					}
					else 
					{
						bpmoproApproveUserAction($approcinguser->data->ID);
					}
					
					
				}
			}
			
			$bpmoMessageString = __ ( 'All users has been settings as approved users now', 'bp-members-only' );
			buddypress_members_only_pro_message ( $bpmoMessageString );
		} else {
			$bpmoMessageString = __ ( "Sorry, please checked 'Yes, I will approve all existed users as approved users' option to approve all users", 'bp-members-only' );
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
	<div style='padding-top: 5px; font-size: 22px;'>Buddypress Members Only Approve User Addon Settings:</div>
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
	echo __ ( 'Approve User Panel:', 'bp-members-only' );
	?>
									</span>
							</h3>

							<div class="inside" style='padding-left: 10px;'>
								<form id="bpmoform" name="bpmoform" action="" method="POST">
									<table id="bpmotable" width="100%">

										<tr style="margin-top: 30px;">
											<td width="30%" style="padding: 20px;" valign="top">
										<?php
	echo __ ( 'Approve All Users:', 'bp-members-only' );
	?>
										</td>
											<td width="70%" style="padding: 20px;">
										<?php
	echo '<input type="checkbox" id="bpmoproapprovealluserscheckbox" name="bpmoproapprovealluserscheckbox"  style="" value="yes"  checked="checked"> Yes, I will approve all existed users as approved users';
	?>
										<p>
													<font color="Gray"><i>
										<?php
	echo '<p>';
	echo __ ( '# If you checked this option, all current existed users will setting as approved users.', 'bp-members-only' );
	echo '</p>';
	echo '<p>';
	echo __ ( '# After enabled approve user addon, all registered users need approved by site administrator manually', 'bp-members-only' );
	echo '</p>';
	echo '<p>';	
	echo __ ( '# When Unapproved user try to login your site, they will get notice "Sorry, please wait site administrator approve your account manually, thanks" and login will failed', 'bp-members-only' );
	echo '</p>';
	echo '<p>';	
	echo __ ( '# Super administrator (user ID = 1) and users who have admin user role will never be settings as unapproved user, they can always login your site', 'bp-members-only' );
	echo '</p>';
	echo '<p>';	
	echo __ ( '# When you enabled approve user addon at first time, all other users will be look as unapproved user, you can approve all existed users in here by one click', 'bp-members-only' );
	echo '</p>';
	echo '<p>';
	echo __ ( '# You can find users approved status at wordpress standard <a href="' . get_option('siteurl') .'/wp-admin/users.php' . '">users list page</a>, Unapproved users will be mark as red background', 'bp-members-only' );
	echo '</p>';
	echo '<p>';	
	echo __ ( '# If you move your mouse on users name at <a href="' . get_option('siteurl') .'/wp-admin/users.php' . '">users list page</a>, you will find Approve and Unapprove links, just click links, you will be redirect edit user panel, at the bottom of the edit user panel, you wil lfind Approve User option, and you can approve or unapprove that user manually', 'bp-members-only' );
	echo '</p>';
	?>
										</i>
												
												</p>
											</td>
										</tr>
									</table>
									<br />
										<?php
	wp_nonce_field ( 'bpmoproapproveusersnonce' );
	?>
	<input type="submit" id="bponeclickresetsubmit" name="bponeclickresetsubmit" value=" Submit " style="margin: 1px 20px;">
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

function bp_members_only_pro_approve_user_addon_menu()
{
	add_submenu_page ( 'bpmemberonly', __ ( "BP Members Only", "bp-members-only" ), __ ( "Approve User", "Approve User"), "manage_options", "buddypress_membersonlyproapproveuser","buddypress_members_only_pro_approve_user_manager");
}

add_action('admin_menu', 'bp_members_only_pro_approve_user_addon_menu',12);

