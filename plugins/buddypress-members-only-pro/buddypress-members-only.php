<?php
/*
Plugin Name: BuddyPress Members only Pro
Description: Only registered users can view your site, non members can only see a login/home page with no registration options
Version: 3.5.2
Author: Tomas Zhu
Author URI: http://membersonly.top
Plugin URI: http://membersonly.top
Text Domain: bp-members-only

Copyright 2012 - 2018  Tomas Zhu  (email : expert2wordpress@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
if (!defined('ABSPATH'))
{
	exit;
}

$bpmoinitsetup = get_option ( 'bpmoinitsetup' );
if (empty($bpmoinitsetup))
{
	require_once("rules/bpmoinit.php");
}

$bpmocurrentversion = get_option ( 'bpmocurrentversion' );
$bpmocurrentversion = str_replace ( '.', '', $bpmocurrentversion );
if ((empty ( $bpmocurrentversion )) || ($bpmocurrentversion < 254)) 
{
	
}
else
{
	define('BPMO_VERSION', '3.5.2');
	update_option ( 'bpmocurrentversion', BPMO_VERSION);
}

require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('buddypress-members-only/buddypress-members-only.php'))
{
	deactivate_plugins(('buddypress-members-only/buddypress-members-only.php'));
}

define('BPMOPRO_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('BPMOPRO_ADDONS_PATH', plugin_dir_path(__FILE__).'addons'.'/');


ob_start();
require_once("bpmoupgrade.php");
require_once("functions.php");
require_once("customizedurlsettings.php");
require_once("componentsettings.php");
require_once("oneclickreset.php");
require_once("frontendannouncementload.php");
require_once("rssrestrictssetting.php");
require_once('rules/customizedopenedurl.php');
require_once('rules/customizedclosedurl.php');
require_once('rules/restricthomepage.php');
require_once(BPMOPRO_ADDONS_PATH."addons.php");
//require_once("update.php");
//require_once("miscellaneous.php");


add_action('admin_menu', 'bp_members_only_pro_option_menu');

/**** localization ****/
add_action('plugins_loaded','bp_members_only_pro_load_textdomain');
function buddypress_members_only_componet_admin_css() {
	wp_enqueue_style ( 'buddypress_members_only_componet_admin_css', plugin_dir_url ( __FILE__ ) . 'asset/css/admin.min.css' );
	wp_enqueue_script ( 'buddypress_members_only_componet_admin_js', plugin_dir_url ( __FILE__ ) . 'asset/js/admin.min.js', array (
			'jquery' 
	) );
}
add_action ( 'admin_head', 'buddypress_members_only_componet_admin_css' );
function bp_members_only_pro_load_textdomain() {
	load_plugin_textdomain ( 'bp-members-only', false, dirname ( plugin_basename ( __FILE__ ) ) . '/languages/' );
}
function bp_members_only_pro_option_menu() {
	add_menu_page ( __ ( 'Buddypress Members Only', 'bp-members-only' ), __ ( 'BP Members Only', 'bp-members-only' ), 'manage_options', 'bpmemberonly', 'buddypress_members_only_pro_setting' );
	add_submenu_page ( 'bpmemberonly', __ ( 'BP Members Only', 'bp-members-only' ), __ ( 'BP Members Only', 'bp-members-only' ), 'manage_options', 'bpmemberonly', 'buddypress_members_only_pro_setting' );
	add_submenu_page ( 'bpmemberonly', __ ( 'BP Members Only', 'bp-members-only' ), __ ( 'BP Components', 'bp-members-only' ), 'manage_options', 'bpmembercomponentonly', 'buddypress_members_component_setting' );
	add_submenu_page ( 'bpmemberonly', __ ( 'BP Members Only', 'bp-members-only' ), __ ( 'Optional Settings', 'bp-members-only' ), 'manage_options', 'bpmemberoptionalsettings', 'buddypress_members_optional_setting' );
	add_submenu_page ( 'bpmemberonly', __ ( 'BP Members Only', 'bp-members-only' ), __ ( 'Redirect Settings', 'bp-members-only' ), 'manage_options', 'bpmemberrolebasedsettings', 'buddypress_members_role_based_login_setting' );
	add_submenu_page ( 'bpmemberonly', __ ( 'BP Members Only', 'bp-members-only' ), __ ( 'RSS Restricts', 'bp-members-only' ), 'manage_options', 'bpmemberrssrestricts', 'buddypress_members_rss_restricts_setting' );
	add_submenu_page ( 'bpmemberonly', __ ( 'BP Members Only', 'bp-members-only' ), __ ( 'Customized URL Restricts', 'bp-members-only' ), 'manage_options', 'bpmembercustomizedurlrestricts', 'buddypress_member_customized_url_restricts_setting' );
	add_submenu_page ( 'bpmemberonly', __ ( 'BP Members Only', 'bp-members-only' ), __ ( 'One Click Reset', 'bp-members-only' ), 'manage_options', 'bpmemberoneclickreset', 'buddypress_one_click_reset_setting' );
	add_submenu_page ( 'bpmemberonly', __ ( 'BP Members Only', 'bp-members-only' ), __ ( 'Announcements', 'Announcement' ), 'manage_options', 'bpmemberannouncementsitefrontend', 'buddypress_members_announcement_settings' );
	add_submenu_page ( 'bpmemberonly', __ ( "BP Members Only", "bp-members-only" ), __ ( "Addons", "Addons"), "manage_options", "bpmemberonlyproaddonmanager","buddypress_members_only_pro_addon_manager");
	// add_submenu_page('bpmemberonly', __('BP Members Only','bp-members-only'), __('Miscellaneous','Announcement'), 'manage_options', 'buddypressmembersmiscellaneous', 'buddypress_members_miscellaneous');
}


function buddypress_members_only_pro_addon_manager()
{
	require_once(BPMOPRO_ADDONS_PATH."addonspanel.php");
}

function buddypress_members_optional_setting() {
	global $wpdb;
	
	if (isset ( $_POST ['bpoptionsettinspanelsubmit'] )) {
		
		check_admin_referer ( 'bpoptionsettinspanelsubmitnonce' );
		if (isset ( $_POST ['bprestrictsbuddypresssection'] )) {
			$m_bprestrictsbuddypresssection = $_POST ['bprestrictsbuddypresssection'];
			update_option ( 'bprestrictsbuddypresssection', $m_bprestrictsbuddypresssection );
		} else {
			delete_option ( 'bprestrictsbuddypresssection' );
		}
		
		if (isset ( $_POST ['bpenablepagelevelprotect'] )) {
			$m_bpenablepagelevelprotect = $_POST ['bpenablepagelevelprotect'];
			update_option ( 'bpenablepagelevelprotect', $m_bpenablepagelevelprotect );
		} else {
			delete_option ( 'bpenablepagelevelprotect' );
		}
		
		
		if (isset ( $_POST ['bprestricthomepage'] )) {
			$m_bprestricthomepage = $_POST ['bprestricthomepage'];
			update_option ( 'bprestricthomepage', $m_bprestricthomepage );
		} else {
			delete_option ( 'bprestricthomepage' );
		}
		
		
		$bpmoMessageString = __ ( 'Your changes has been saved.', 'bp-members-only' );
		buddypress_members_only_pro_message ( $bpmoMessageString );
	}
	echo "<br />";
	?>

<div style='margin: 10px 5px;'>
	<div style='float: left; margin-right: 10px;'>
		<img
			src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/buddypress-members-only-pro/images/new.png'
			style='width: 30px; height: 30px;'>
	</div>
	<div style='padding-top: 5px; font-size: 22px;'>Buddypress Members Only Optional Settings:</div>
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
	echo __ ( 'Optional Settings Panel :', 'bp-members-only' );
	?>
									</span>
							</h3>

							<div class="inside" style='padding-left: 10px;'>
								<form id="bpmoform" name="bpmoform" action="" method="POST">
									<table id="bpmotable" width="100%">

										<tr style="margin-top: 30px;">
											<td width="30%" style="padding: 20px;" valign="top">
										<?php
	echo __ ( 'Enable Page Level Protect:', 'bp-members-only' );
	?>
										</td>
											<td width="70%" style="padding: 20px;">
										<?php
	$bpenablepagelevelprotect = get_option ( 'bpenablepagelevelprotect' );
	if (! (empty ( $bpenablepagelevelprotect ))) {
	} else {
		$bpenablepagelevelprotect = '';
	}
	?>
										<?php
	if (! (empty ( $bpenablepagelevelprotect ))) {
		echo '<input type="checkbox" id="bpenablepagelevelprotect" name="bpenablepagelevelprotect"  style="" value="yes"  checked="checked"> Enable Page Level Protect Settings ';
	} else {
		echo '<input type="checkbox" id="bpenablepagelevelprotect" name="bpenablepagelevelprotect"  style="" value="yes" > Enable Page Level Protect Settings ';
	}
	?>
										
										<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# If you enabled this option,  in ', 'bp-members-only' );
	echo "<a style='color:#4e8c9e;' href='" . get_option ( 'siteurl' ) . "/wp-admin/post-new.php' target='_blank'>page / post  editor</a>";
	echo __ ( ', you will find "Members only for this page?" meta box at the right top of the wordpress standard editor.', 'bp-members-only in ' );
	?>
										</i>
												
												</p>
												<p>
													<font color="Gray"><i><?php echo  __( '# If you checked "Allow everyone to access the page" checkbox in meta box, the post will be opened to all guest users', 'bp-members-only' ); ?></i>
												
												</p>
												<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# By this way, you do not need enter page URLs to ', 'bp-members-only' );
	echo "<a  style='color:#4e8c9e;' href='" . get_option ( 'siteurl' ) . "/wp-admin/admin.php?page=bpmemberonly' target='_blank'>Opened Pages Panel</a>";
	echo __ ( ' always.', 'bp-members-only' );
	
	?></i>
												</p>
												<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# please note, "Closed Customized URLs" option in ', 'bp-members-only' );
	echo "<a  style='color:#4e8c9e;' href='" . get_option ( 'siteurl' ) . "/wp-admin/admin.php?page=bpmembercustomizedurlrestricts' target='_blank'>Customized URL Setting Panel</a>";
	echo __ ( ', have higher priority than "Enable Page Level Protect" option', 'bp-members-only' );
	?></i>
												</p>												
											</td>
										</tr>


										<tr>
											<td width="30%" style="padding: 30px 20px 20px 20px;"
												valign="top">
										<?php
	echo __ ( 'Only Protect My  Buddypress Pages:', 'bp-members-only' );
	?>
										</td>
											<td width="70%" style="padding: 20px;">
												<p>
										<?php
	$bprestrictsbuddypresssection = get_option ( 'bprestrictsbuddypresssection' );
	if (! (empty ( $bprestrictsbuddypresssection ))) {
		echo '<input type="checkbox" id="bprestrictsbuddypresssection" name="bprestrictsbuddypresssection"  style="" value="yes"  checked="checked"> All Other Sections On Your Site Will be Opened to Guest ';
	} else {
		echo '<input type="checkbox" id="bprestrictsbuddypresssection" name="bprestrictsbuddypresssection"  style="" value="yes" > All Other Sections On Your Site Will be Opened to Guest ';
	}
	?>
										</p>
												<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# If you disabled this option, our plugin will protect all of your wordpress posts to non-member users, only home page / login / register / lost password page will be opened to guest.', 'bp-members-only' );
	?></i>
												
												</p>										
												<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# If you enabled this option, "opened Page URLs" setting in ', 'bp-members-only' );
	echo "<a  style='color:#4e8c9e;' href='" . get_option ( 'siteurl' ) . "/wp-admin/admin.php?page=bpmemberonly' target='_blank'>Opened Pages Panel</a>";
	echo __ ( ' will be ignored', 'bp-members-only' );
	?></i>
												
												</p>
												<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# All buddypress pages will be protected yet, All settings in ', 'bp-members-only' );
	echo "<a  style='color:#4e8c9e;' href='" . get_option ( 'siteurl' ) . "/wp-admin/admin.php?page=bpmembercomponentonly' target='_blank'>Buddypress Members Only Components Setting Panel</a>";
	echo __ ( '  will still works', 'bp-members-only' );
	?>
										
										</i>
												
												</p>
												<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# If you enabled this option, "Enable Page Level Protect" option in ', 'bp-members-only' );
	echo "<a  style='color:#4e8c9e;' href='" . get_option ( 'siteurl' ) . "/wp-admin/admin.php?page=bpmemberoptionalsettings' target='_blank'>Optional Settings Panel</a>";
	echo __ ( ' will be ignored', 'bp-members-only' );
	?></i>
												</p>
												<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# If you enabled this option, you can still restrict pages via "Closed Customized URLs" option in ', 'bp-members-only' );
	echo "<a  style='color:#4e8c9e;' href='" . get_option ( 'siteurl' ) . "/wp-admin/admin.php?page=bpmembercustomizedurlrestricts' target='_blank'>Customized URL Setting Panel</a>";
	echo __ ( ', it will still works', 'bp-members-only' );
	?></i>
												</p>
											</td>
										</tr>
										<tr style="margin-top: 30px;">
											<td width="30%" style="padding: 20px;" valign="top">
										<?php
	echo __ ( 'Also Restrict Home Page:', 'bp-members-only' );
	?>
										</td>
											<td width="70%" style="padding: 20px;">
										<?php
	$bprestricthomepage = get_option ( 'bprestricthomepage' );
	if (! (empty ( $bprestricthomepage ))) {
	} else {
		$bprestricthomepage = '';
	}
	?>
										<?php
	if (! (empty ( $bprestricthomepage ))) {
		echo '<input type="checkbox" id="bprestricthomepage" name="bprestricthomepage"  style="" value="yes"  checked="checked"> Restrict Home Page of the Site ';
	} else {
		echo '<input type="checkbox" id="bprestricthomepage" name="bprestricthomepage"  style="" value="yes" > Restrict Home Page of the Site ';
	}
	?>
										
										<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# In general we will open homepage to guest, if you enabled this option,  the homepage will be restricted to guest too, when guest try to open your home page, they will be redirected to register page or redirect page which you setting at ', 'bp-members-only' );
	echo "<a style='color:#4e8c9e;' href='" . get_option ( 'siteurl' ) . "/wp-admin/admin.php?page=bpmemberonly' target='_blank'>Opened Pages Panel</a>";
	?>
										</i>
												</p>
											</td>
										</tr>
										
									</table>
									<br />
										<?php
	wp_nonce_field ( 'bpoptionsettinspanelsubmitnonce' );
	?>
										<input type="submit" id="bpoptionsettinspanelsubmit"
										name="bpoptionsettinspanelsubmit" value=" Submit "
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
function buddypress_members_only_pro_setting() {
	global $wpdb;
	
	$m_bpmoregisterpageurl = get_option ( 'bpmoregisterpageurl' );
	
	if (isset ( $_POST ['bpmosubmitnew'] )) {
		wp_nonce_field ( 'bpmosubmitnewnonce' );
		if (isset ( $_POST ['bpmoregisterpageurl'] )) {
			$m_bpmoregisterpageurl = esc_url ( $_POST ['bpmoregisterpageurl'] );
		} else {
		}
		
		update_option ( 'bpmoregisterpageurl', $m_bpmoregisterpageurl );
		if (isset ( $_POST ['bpopenedpageurl'] )) {
			$bpopenedpageurl = trim ( $_POST ['bpopenedpageurl'] );
			
			if (strlen ( $bpopenedpageurl ) == 0) {
				
				delete_option ( 'saved_open_page_url' );
			} else {
				$bpopenedpageurl = sanitize_textarea_field ( $bpopenedpageurl );
				
				update_option ( 'saved_open_page_url', $bpopenedpageurl );
			}
		}
		
		$bpmoMessageString = __ ( 'Your changes has been saved.', 'bp-members-only' );
		buddypress_members_only_pro_message ( $bpmoMessageString );
	}
	echo "<br />";
	
	$saved_register_page_url = get_option ( 'bpmoregisterpageurl' );
	?>

<div style='margin: 10px 5px;'>
	<div style='float: left; margin-right: 10px;'>
		<img
			src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/buddypress-members-only-pro/images/new.png'
			style='width: 30px; height: 30px;'>
	</div>
	<div style='padding-top: 5px; font-size: 22px;'>Buddypress Members Only
		Setting:</div>
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
	echo __ ( 'Opened Pages Panel:', 'bp-members-only' );
	?>
									</span>
							</h3>

							<div class="inside" style='padding-left: 10px;'>
								<form id="bpmoform" name="bpmoform" action="" method="POST">
									<table id="bpmotable" width="100%">
										<tr>
											<td width="30%" style="padding: 20px;">
										<?php
	echo __ ( 'Register Page URL:', 'bp-members-only' );
	echo '<div style="color:#888 !important;"><i>';
	echo __ ( '(or redirect url)', 'bp-members-only' );
	echo '</i></div>';
	?>
										</td>
											<td width="70%" style="padding: 20px;"><input type="text"
												id="bpmoregisterpageurl" name="bpmoregisterpageurl"
												style="width: 500px;" size="70"
												value="<?php  echo $saved_register_page_url; ?>"></td>
										</tr>

										<tr style="margin-top: 30px;">
											<td width="30%" style="padding: 20px;" valign="top">
										<?php
	echo __ ( 'Opened Page URLs:', 'bp-members-only' );
	?>
										</td>
											<td width="70%" style="padding: 20px;">
										<?php
	$urlsarray = get_option ( 'saved_open_page_url' );
	?>
										<textarea name="bpopenedpageurl" id="bpopenedpageurl"
													cols="70" rows="10" style="width: 500px;"><?php echo $urlsarray; ?></textarea>
												<p>
													<font color="Gray"><i><?php echo  __( 'Enter one URL per line please.', 'bp-members-only' ); ?></i>
												
												</p>
												<p>
													<font color="Gray"><i><?php echo  __( 'These pages will opened for guest and guest will not be directed to register page.', 'bp-members-only' ); ?></i>
												
												</p>
											</td>
										</tr>
									</table>
									<br />
										<?php
	wp_nonce_field ( 'bpmosubmitnewnonce' );
	?>
										<input type="submit" id="bpmosubmitnew" name="bpmosubmitnew"
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
</div>
<div style="clear: both"></div>
<br />
<?php
}
function buddypress_members_only_pro_message($p_message) {
	echo "<div id='message' class='updated fade' style='line-height: 30px;margin-left: 0px;margin-top:10px; margin-bottom:10px;'>";
	
	echo $p_message;
	
	echo "</div>";
}
function buddypress_members_only_update_notify($p_message, $version) {
	echo "<div id='message' class='updated fade' style='position: relative; line-height: 60px;margin-left: 0px;margin-top:10px; margin-bottom:10px;'>";
	?>
<a class="notice-dismiss bp-members-only-update-dismiss"
	href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'bpmo-hide-notice', $version ), 'bpmo_hide_notices_nonce', 'bpmo_notice_nonce' ) ); ?>"><?php echo __( 'Dismiss', 'bp-members-only' ); ?></a>
<?php
	echo '<p>';
	echo $p_message;
	echo '</p>';
	echo "</div>";
}
function buddypress_only__pro_for_members() {
	global $wp_roles, $user_ID;
	
	$tomas_roles_all_array = $wp_roles->roles;
	
	$guestHavePermission = restrictHomePageToGuestHavePermisssion();

	if ($guestHavePermission)
	{
		return;
	}
	
	$current_page_id = get_the_ID ();
	
	$bpenablepagelevelprotect = get_option ( 'bpenablepagelevelprotect' );
	
	if (function_exists ( 'bp_is_register_page' ) && function_exists ( 'bp_is_activation_page' )) {
		if (bp_is_register_page () || bp_is_activation_page ()) {
			return;
		}
	}
	
	$current_url = $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
	$current_url = str_ireplace ( 'http://', '', $current_url );
	$current_url = str_ireplace ( 'https://', '', $current_url );
	$current_url = str_ireplace ( 'ws://', '', $current_url );
	$current_url = str_ireplace ( 'www.', '', $current_url );

	$saved_register_page_url = get_option ( 'bpmoregisterpageurl' );
	
	$saved_register_page_url = str_ireplace ( 'http://', '', $saved_register_page_url );
	$saved_register_page_url = str_ireplace ( 'https://', '', $saved_register_page_url );
	$saved_register_page_url = str_ireplace ( 'ws://', '', $saved_register_page_url );
	$saved_register_page_url = str_ireplace ( 'www.', '', $saved_register_page_url );
	
	
	$bprulesclosedcustomizedurls = false;
	$bprulesclosedcustomizedurls = fncbpclosedcustomizedurls($current_url);
	if ($bprulesclosedcustomizedurls == false)
	{
		buddypress_only_pro_no_access_redirect($saved_register_page_url);
	}	
	
	if (! (empty ( $bpenablepagelevelprotect ))) {
		$get_post_meta_value_for_this_page = get_post_meta ( $current_page_id, 'bp_members_only_access_to_this_page', true );
		if (strtolower ( $get_post_meta_value_for_this_page ) == 'yes') {
			return;
		}
	}
	

	$bprestrictsbuddypresssection = get_option ( 'bprestrictsbuddypresssection' );
	$m_bpstandardcomponent = get_option ( 'bpstandardcomponent' );
	if (function_exists ( 'bp_current_component' )) {
		$is_bp_current_component = bp_current_component ();
	} else {
		$is_bp_current_component = '';
	}
	$bp_in_componet_have_access = false;
	$bpopenedcustomizedcomponent = get_option ( 'bpopenedcustomizedcomponent' );
	
	$bpopenedcustomizedurls = get_option ( 'bpopenedcustomizedurls' ); 
	
	if (is_user_logged_in () == false) {
		if (! (empty ( $bpopenedcustomizedcomponent ))) {
			$bpopenedcustomizedcomponentarray = explode ( "\n", trim ( $bpopenedcustomizedcomponent ) );
			
			if ((is_array ( $bpopenedcustomizedcomponentarray )) && (count ( $bpopenedcustomizedcomponentarray ) > 0)) {
				foreach ( $bpopenedcustomizedcomponentarray as $bpopenedcustomizedcomponentsingle ) {
					if ((strtolower ( trim ( $is_bp_current_component ) )) == (strtolower ( trim ( $bpopenedcustomizedcomponentsingle ) ))) {
						return;
					}
				}
			}
		}
	} else {
		$user = wp_get_current_user ();
		if (empty ( $user->roles )) {
			if (! (empty ( $bpopenedcustomizedcomponent ))) {
				$bpopenedcustomizedcomponentarray = explode ( "\n", trim ( $bpopenedcustomizedcomponent ) );
				
				if ((is_array ( $bpopenedcustomizedcomponentarray )) && (count ( $bpopenedcustomizedcomponentarray ) > 0)) {
					foreach ( $bpopenedcustomizedcomponentarray as $bpopenedcustomizedcomponentsingle ) {
						if ((strtolower ( trim ( $is_bp_current_component ) )) == (strtolower ( trim ( $bpopenedcustomizedcomponentsingle ) ))) {
							return;
						}
					}
				}
			}
		} else {
			foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array ) {
				$bp_component_role_id = $tomas_roles_single_key;

				if (in_array ( $bp_component_role_id , $user->roles ))
				{
					
				} 
				else 
				{
					continue;
				}
				$bp_component_role_id = str_replace ( ' ', '-', $tomas_roles_single_key );
				
				$rolebasedcustomizedcomponent = 'bpopenedcustomizedcomponent_' . $bp_component_role_id;
				$rolebasedcustomizedcomponentoption_ori = get_option ( $rolebasedcustomizedcomponent );
				
				if (! (empty ( $rolebasedcustomizedcomponentoption_ori ))) {
					$rolebasedcustomizedcomponentoption = explode ( "\n", trim ( $rolebasedcustomizedcomponentoption_ori ) );
					foreach ( $rolebasedcustomizedcomponentoption as $rolebasedcustomizedcomponentoption_single ) {
						if (strtolower ( trim ( $rolebasedcustomizedcomponentoption_single ) ) == strtolower ( trim ( $is_bp_current_component ) )) {
							return;
						}
					}
				} else {
					continue;
				}
			}
		}
	}

	if (is_user_logged_in () == false) {
		if ((! (empty ( $m_bpstandardcomponent ))) && (is_array ( $m_bpstandardcomponent )) && (count ( $m_bpstandardcomponent ) > 0) && (in_array ( $is_bp_current_component, $m_bpstandardcomponent ))) {
			return;
		}
	} else {
		$user = wp_get_current_user ();
		if (empty ( $user->roles )) {
			if ((! (empty ( $m_bpstandardcomponent ))) && (is_array ( $m_bpstandardcomponent )) && (count ( $m_bpstandardcomponent ) > 0) && (in_array ( $is_bp_current_component, $m_bpstandardcomponent ))) {
				return;
			}
		} else {
			foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array ) {
				$bp_component_role_id = $tomas_roles_single_key;
 
				if (in_array ( $bp_component_role_id , $user->roles ))
				{
					
				} 
				else 
				{
					continue;
				}
				$bp_component_role_id = str_replace ( ' ', '-', $tomas_roles_single_key );
				
				$rolebasedstandardcomponent = 'bpstandardcomponent_' . $bp_component_role_id;
				
				$rolebasedstandardcomponentoption = get_option ( $rolebasedstandardcomponent );
				if (! (empty ( $rolebasedstandardcomponentoption ))) {
					foreach ( $rolebasedstandardcomponentoption as $rolebasedstandardcomponentoption_single ) {
						if ($rolebasedstandardcomponentoption_single == $is_bp_current_component) {
							return;
						}
					}
				} else {
					
					continue;
				}
			}
		}
	}
	
	if (! (empty ( $bprestrictsbuddypresssection ))) {
		if (empty ( $is_bp_current_component )) {
			return;
		}
	}

	if (stripos ( $saved_register_page_url, $current_url ) === false) 
	{

	} 
	else {
		if (is_front_page ())
		{
			$guestHavePermission = restrictHomePageToGuestHavePermisssion();
			if ($guestHavePermission)
			{
				return;
			}
		}
		else 
		{
			return;
		}
	}
	
	$saved_open_page_option = get_option ( 'saved_open_page_url' );
	
	$saved_open_page_url = explode ( "\n", trim ( $saved_open_page_option ) );
	
	if ((is_array ( $saved_open_page_url )) && (count ( $saved_open_page_url ) > 0)) {
		$root_domain = get_option ( 'siteurl' );
		foreach ( $saved_open_page_url as $saved_open_page_url_single ) {
			$saved_open_page_url_single = trim ( $saved_open_page_url_single );
			if (pro_reserved_url ( $saved_open_page_url_single ) == true) {
				continue;
			}
			
			$saved_open_page_url_single = pro_pure_url ( $saved_open_page_url_single );
			
			if (stripos ( $current_url, $saved_open_page_url_single ) === false) {
			} else {
				return;
			}
		}
	}
	
	$bprulesopenedcustomizedurls = false;
	$bprulesopenedcustomizedurls = fncbpopenedcustomizedurls($current_url);
	if ($bprulesopenedcustomizedurls == true)
	{
		return;
	}

	if (is_user_logged_in () == false) {
		if (empty ( $saved_register_page_url )) {
			$current_url = $_SERVER ['REQUEST_URI'];
			$redirect_url = wp_login_url ();
			header ( 'Location: ' . $redirect_url );
			die ();
		} else {
			$saved_register_page_url = 'http://' . $saved_register_page_url;
			header ( 'Location: ' . $saved_register_page_url );
			die ();
		}
	} else {
		if (($bp_in_componet_have_access == false) && (! (empty ( $is_bp_current_component )))) {
			if (empty ( $saved_register_page_url )) {
				$current_url = $_SERVER ['REQUEST_URI'];
				$redirect_url = wp_login_url ();
				header ( 'Location: ' . $redirect_url );
				die ();
			} else {
				$saved_register_page_url = 'http://' . $saved_register_page_url;
				header ( 'Location: ' . $saved_register_page_url );
				die ();
			}
		}
	}
}

function buddypress_only_pro_no_access_redirect($saved_register_page_url)
{
	if (empty ( $saved_register_page_url )) {
		$current_url = $_SERVER ['REQUEST_URI'];
		$redirect_url = wp_login_url ();
		header ( 'Location: ' . $redirect_url );
		die ();
	} else {
		$saved_register_page_url = 'http://' . $saved_register_page_url;
		header ( 'Location: ' . $saved_register_page_url );
		die ();
	}	
}

function pro_pure_url($current_url) {
	if (empty ( $current_url ))
		return false;
	$current_url_array = parse_url ( $current_url );
	
	$current_url = str_ireplace ( 'http://', '', $current_url );
	$current_url = str_ireplace ( 'https://', '', $current_url );
	$current_url = str_ireplace ( 'ws://', '', $current_url );
	
	$current_url = str_ireplace ( 'www.', '', $current_url );
	$current_url = trim ( $current_url );

	return $current_url;
}
function pro_reserved_url($url) {
	$home_page = get_option ( 'siteurl' );
	$home_page = pro_pure_url ( $home_page );
	$url = pro_pure_url ( $url );
	if ($home_page == $url) {
		return true;
	} else {
		return false;
	}
}

if (function_exists ( 'bp_is_register_page' ) && function_exists ( 'bp_is_activation_page' )) {
	add_action ( 'wp', 'buddypress_only__pro_for_members' );
} else {
	add_action ( 'wp_head', 'buddypress_only__pro_for_members' );
}

$bpenablepagelevelprotect = get_option ( 'bpenablepagelevelprotect' );
if (! (empty ( $bpenablepagelevelprotect ))) {
	add_action ( 'add_meta_boxes', 'add_bp_members_only_control_meta_box' );
	add_action ( 'save_post', 'save_wp_members_only_control_meta_box', 10, 3 );
}
function bp_members_only_control_meta_box() {
	$current_page_id = get_the_ID ();
	$get_post_meta_value_for_this_page = get_post_meta ( $current_page_id, 'bp_members_only_access_to_this_page', true );
	global $wpdb;
	
	?>
<table cellspacing="2" cellpadding="5" style="width: 100%;"
	class="form-table">
	<tbody>
		<tr class="form-field">
			<td><input name="bp_members_only_access_to_this_page" type="checkbox"
				value="yes"
				<?php  if(esc_attr( $get_post_meta_value_for_this_page ) == 'yes' ) {echo 'checked="checked"';} ?>><label><?php _e('Allow everyone to access the page', 'admin-tools') ?></label>
			</td>
		</tr>
	</tbody>
</table>
<?php
}
function add_bp_members_only_control_meta_box() {
	add_meta_box ( "bp_members_only_control_meta_box_id", __ ( 'Members only for this page?', 'bp-members-only' ), 'bp_members_only_control_meta_box', null, "side", "high", null );
}
function save_wp_members_only_control_meta_box($post_id, $post, $update) {
	$current_page_id = get_the_ID ();
	$meta_box_checkbox_value = '';
	
	if (isset ( $_POST ['bp_members_only_access_to_this_page'] ) != "") {
		$meta_box_checkbox_value = $_POST ['bp_members_only_access_to_this_page'];
		$get_post_meta_value_for_this_page = get_post_meta ( $current_page_id, 'bp_members_only_access_to_this_page', true );
	}
	
	if (isset ( $_POST ['bp_members_only_access_to_this_page'] ) != "") {
		update_post_meta ( $current_page_id, 'bp_members_only_access_to_this_page', $meta_box_checkbox_value );
	} else {
		update_post_meta ( $current_page_id, 'bp_members_only_access_to_this_page', '' );
	}
}
function buddypress_members_announcement_settings() {
	global $wpdb;
	
	$m_contentFrontendAnnouncement = get_option ( 'contentFrontendAnnouncement' );
	
	if (isset ( $_POST ['announcementsubmitnew'] )) {
		check_admin_referer ( 'tomas_announcement_setting_nonce' );
		if (isset ( $_POST ['contentFrontendAnnouncement'] )) {
			$m_contentFrontendAnnouncement = $_POST ['contentFrontendAnnouncement'];
		}
		
		if (isset ( $_POST ['bpenableannouncement'] )) {
			$bpenableannouncement = $_POST ['bpenableannouncement'];
			update_option ( 'bpenableannouncement', $bpenableannouncement );
		} else {
			delete_option ( 'bpenableannouncement' );
		}
		
		update_option ( 'contentFrontendAnnouncement', $m_contentFrontendAnnouncement );
		$announcementMessageString = __ ( 'Your changes has been saved.', 'wordpress-announcements' );
		buddypress_members_only_pro_message ( $announcementMessageString );
	}
	echo "<br />";
	
	$saved_register_page_url = get_option ( 'contentFrontendAnnouncement' );
	?>

<div style='margin: 10px 5px;'>
	<div style='float: left; margin-right: 10px;'>

		<img src='<?php echo plugins_url('images/new.png', __FILE__);  ?>'
			style='width: 30px; height: 30px;'>

	</div>
	<div style='padding-top: 5px; font-size: 22px;'>Buddypress Members Only
		Announcement Settings:</div>
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
	echo __ ( 'Frontend Announcement Panel:', 'wordpress-announcements' );
	?>
											</span>
							</h3>

							<div class="inside" style='padding-left: 10px;'>
								<form id="tomas_webFrontendAnnouncementForm"
									name="tomas_webFrontendAnnouncementForm" action=""
									method="POST">
											<?php
	wp_nonce_field ( 'tomas_announcement_setting_nonce' );
	?>
											<table id="tomas_announcement_table" width="100%">

										<tr style="margin-top: 30px;">
											<td width="30%" style="padding: 20px;" valign="top">
										<?php
	echo __ ( 'Enable Announcement On Register Page:', 'bp-members-only' );
	?>
										</td>
											<td width="70%" style="padding: 20px;">
										<?php
	$bpenableannouncement = get_option ( 'bpenableannouncement' );
	if (! (empty ( $bpenableannouncement ))) {
	} else {
		$bpenableannouncement = '';
	}
	?>
										<?php
	if (! (empty ( $bpenableannouncement ))) {
		echo '<input type="checkbox" id="bpenablerssrestricts" name="bpenableannouncement"  style="" value="yes"  checked="checked"> Enable Announcement on Register Page URL ';
	} else {
		echo '<input type="checkbox" id="bpenablerssrestricts" name="bpenableannouncement"  style="" value="yes" > Enable Announcement on Register Page URL ';
	}
	?>
										<p>
													<font color="Gray"><i>
										<?php
	echo __ ( '# If you enabled this option,  ', 'bp-members-only' );
	echo __ ( ' we will show announcement at top of register page. ', 'bp-members-only' );
	?>
										</i>
												
												</p>
												<p>
													<font color="Gray"><i>
										<?php
	echo __ ( ' # Register Page URL can be setting at ', 'bp-members-only' );
	echo "<a style='color:#4e8c9e;' href='" . get_option ( 'siteurl' ) . "/wp-admin/admin.php?page=bpmemberonly' target='_blank'>here</a>";
	?>
										</i>
												
												</p>
											</td>
										</tr>

										<tr style="margin-top: 30px;">
											<td width="30%" style="padding: 20px;" valign="top">
											<?php
	echo __ ( 'Announcement Content:', 'wordpress-announcements' );
	?>
											</td>
											<td width="70%" style="padding: 20px;">
											<?php
	$urlsarray = get_option ( 'contentFrontendAnnouncement' );
	$urlsarray = stripslashes ( $urlsarray );
	wp_editor ( $urlsarray, 'contentFrontendAnnouncement' );
	?>
											
											
											<p>
													<font color="Gray"><i><?php echo  __( 'Announcement will show at the top of register page', 'wordpress-announcements' ); ?></i>
												</p>
											</td>
										</tr>
									</table>
									<br /> <input type="submit" id="announcementsubmitnew"
										name="announcementsubmitnew" value=" Submit "
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
function buddypress_members_rss_restricts() {
	$bpenablerssrestricts = get_option ( 'bpenablerssrestricts' );
	
	if (strtolower ( $bpenablerssrestricts ) == 'yes') {
		$bprssrestrictscontent = get_option ( 'bprssrestrictscontent' );
		$bprssrestrictscontent = stripslashes ( $bprssrestrictscontent );
		echo $bprssrestrictscontent;
		wp_die ( '' );
	} else {
		return;
	}
}
function buddypress_members_only_remote_request($url) {
	if (empty ( $url )) {
		return false;
	}
	$request = wp_safe_remote_request ( $url );
	
	if (is_wp_error ( $request )) {
		return false;
	} else {
		$notifyresult = $request ['body'];
		if ($request ['response'] ['code'] == 200) {
			return $notifyresult;
		} else {
			return false;
		}
	}
	return false;
}
function buddypress_members_only_check_notify() {
	$bpmopro_last_check_notify_time = get_option ( 'bpmopro_last_check_notify_time' );
	if (empty($bpmopro_last_check_notify_time))
	{
		$bpmopro_last_check_notify_time = 0;
	}
	$bbplrp_current_time = time();
	if (($bpmopro_last_check_notify_time >0) && (($bbplrp_current_time - $bpmopro_last_check_notify_time) < 1800))
	{
		return;
	}
	else
	{
		update_option ( 'bpmopro_last_check_notify_time',$bbplrp_current_time );
	}
	
	$update_version_json = buddypress_members_only_remote_request ( 'https://notify.membersonly.top/membersonlyupdate.json' );
	$update_version_json =  sanitize_text_field($update_version_json);
	
	$bpmo_have_new_version = get_option ( 'bpmo_have_new_version_' . $update_version_json );
	if ($bpmo_have_new_version == 'dismiss') {
		return;
	}
	
	if (! (empty ( $update_version_json ))) {
		$update_version = str_replace ( '.', '', $update_version_json );
		$bpmocurrentversion = get_option ( 'bpmocurrentversion' );
		$bpmocurrentversion = str_replace ( '.', '', $bpmocurrentversion );
		if ((empty ( $bpmocurrentversion )) || ($bpmocurrentversion < $update_version)) {
			$bpmoMessageString = __ ( "Buddypress Members Only Pro new version $update_version_json has been released, please <a href='https://membersonly.top'>login</a> to download new version.", 'bp-members-only' );
			update_option ( 'bpmo_have_new_version_' . $update_version_json, $bpmoMessageString );
		}
	}
	
	$bpmo_have_new_version = get_option ( 'bpmo_have_new_version_' . $update_version_json );
	if ((! (empty ( $bpmo_have_new_version ))) && ($bpmo_have_new_version != 'dismiss') && (!(empty($bpmoMessageString)))) {
		buddypress_members_only_update_notify ( $bpmoMessageString, $update_version_json );
	}
}
function bpmo_hide_notices() {
	if (isset ( $_GET ['bpmo-hide-notice'] ) && isset ( $_GET ['bpmo_notice_nonce'] )) {
		if (! wp_verify_nonce ( $_GET ['bpmo_notice_nonce'], 'bpmo_hide_notices_nonce' )) {
			wp_die ( __ ( 'Action failed. Please refresh the page and retry.', 'bp-members-only' ) );
		}
		
		if (! current_user_can ( 'manage_options' )) {
			wp_die ( __ ( 'Cheatin&#8217; huh?', 'bp-members-only' ) );
		}
		
		$hide_notice = sanitize_text_field ( $_GET ['bpmo-hide-notice'] );
		update_option ( 'bpmo_have_new_version_' . $_GET ['bpmo-hide-notice'], 'dismiss' );
	}
}


add_action ( 'do_feed', 'buddypress_members_rss_restricts', 1 );
add_action ( 'do_feed_rdf', 'buddypress_members_rss_restricts', 1 );
add_action ( 'do_feed_rss', 'buddypress_members_rss_restricts', 1 );
add_action ( 'do_feed_rss2', 'buddypress_members_rss_restricts', 1 );
add_action ( 'do_feed_atom', 'buddypress_members_rss_restricts', 1 );
add_action ( 'do_feed_rss2_comments', 'buddypress_members_rss_restricts', 1 );
add_action( 'do_feed_atom_comments', 'buddypress_members_rss_restricts', 1 );
add_action( 'bbp_feed', 'buddypress_members_rss_restricts', 1 );
add_action('admin_head', 'buddypress_members_only_check_notify',10);
add_action('init', 'bpmo_hide_notices');
