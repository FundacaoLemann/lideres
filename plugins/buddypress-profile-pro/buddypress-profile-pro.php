<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.wbcomdesigns.com
 * @since             1.0.0
 * @package           Buddypress_Profile_Pro
 *
 * @wordpress-plugin
 * Plugin Name:       BuddyPress Profile Pro
 * Plugin URI:        https://wbcomdesigns.com/downloads/buddypress-profile-pro/
 * Description:       This plugin provides interface to create extended fields and repeater groups for buddypress.
 * Version:           1.0.2
 * Author:            wbcomdesigns
 * Author URI:        https://wbcomdesigns.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       buddypress-profile-pro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define Plugin Constants
define( 'WBBPP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WBBPP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
if ( ! defined( 'BP_ENABLE_MULTIBLOG' ) ) {
	define( 'BP_ENABLE_MULTIBLOG', false );
}

require plugin_dir_path( __FILE__ ) . 'buddypress-profile-pro-config.php';
register_activation_hook( __FILE__, 'activate_buddypress_profile_pro' );
register_deactivation_hook( __FILE__, 'deactivate_buddypress_profile_pro' );

function activate_buddypress_profile_pro( $networkwide ) {
	global $wpdb;

	$wbbpp_settings_one = array();
	$wbbpp_settings_one = wbbpp_profile_initial_fields_configratn();

	if ( function_exists( 'is_multisite' ) && is_multisite() ) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ( ! is_plugin_active_for_network( 'buddypress/bp-loader.php' ) ) {
			add_action( 'network_admin_notices', '' );
		}
			// Get all blog ids
		$blogs = $wpdb->get_results(
			"
            SELECT blog_id
            FROM {$wpdb->blogs}
            WHERE site_id = '{$wpdb->siteid}'
            AND archived = '0'
            AND spam = '0'
            AND deleted = '0'
            "
		);
		foreach ( $blogs as $blog ) {
			if ( ! defined( 'BP_ROOT_BLOG' ) ) {
				define( 'BP_ROOT_BLOG', $blog->blog_id );
			}
			run_buddypress_profile_pro();
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wbbpp_plugin_links' );
			wbbpp_update_blog( $blog->blog_id );
		}
	} else {
		run_buddypress_profile_pro();
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wbbpp_plugin_links' );
		wbbpp_update_blog();
	}
}

// This function does the actual work
function wbbpp_update_blog( $blog_id = null ) {
	if ( $blog_id ) {
		switch_to_blog( $blog_id );
	}
	$wbbpp_settings_one = array();
	$wbbpp_settings_one = wbbpp_profile_initial_fields_configratn();
	$wbbpp_settings     = get_option( 'wbbpp_profile_fields_settings' );
	if ( empty( $wbbpp_settings ) ) {
		update_option( 'wbbpp_profile_fields_settings', $wbbpp_settings_one );
	}
	$wbbpp_initial_grps      = array();
	$wbbpp_initial_grps      = wbbpp_profile_initial_groups_configratn();
	$wbbpp_profile_groups_settings = get_option( 'wbbpp_profile_groups_settings' );
	if ( empty( $wbbpp_profile_groups_settings ) ) {
		update_option( 'wbbpp_profile_groups_settings', $wbbpp_initial_grps );
	}
	if ( $blog_id ) {
		restore_current_blog();
	}
}

function deactivate_buddypress_profile_pro( $networkwide ) {
	if ( function_exists( 'is_multisite' ) && is_multisite() ) {
	}
}

/**
 * Plugin notice - activate buddypress - multisite
 */
function wbbpp_network_plugin_admin_notice() {
	$wbbpp_plugin = 'BuddyPress Profile Pro';
	$bp_plugin   = 'BuddyPress';

	echo '<div class="error"><p>'
	. sprintf( __( '%1$s is ineffective as it requires %2$s to be installed and active.', 'buddypress-profile-pro' ), '<strong>' . $wbbpp_plugin . '</strong>', '<strong>' . $bp_plugin . '</strong>' )
	. '</p></div>';
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-buddypress-profile-pro.php';

require plugin_dir_path( __FILE__ ) . 'edd-license/edd-plugin-license.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_buddypress_profile_pro() {
	$plugin = new Buddypress_Profile_Pro();
	$plugin->run();
}

add_action( 'plugins_loaded', 'wbbpp_plugin_init' );

/**
 * Function to check buddypress is active to enable disable plugin functionality.
 */
function wbbpp_plugin_init() {
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
		require_once ABSPATH . '/wp-admin/includes/plugin.php';
	}
	if ( ! is_plugin_active_for_network( 'buddypress/bp-loader.php' ) && ! in_array( 'buddypress/bp-loader.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		add_action( 'admin_notices', 'wbbpp_plugin_admin_notice' );
	} else {
		run_buddypress_profile_pro();
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wbbpp_plugin_links' );
	}
}

/**
 * Function to show admin notice when BuddyPress is deactivate.
 */
function wbbpp_plugin_admin_notice() {
	$wbbpp_plugin = 'BuddyPress Profile Pro';
	$bp_plugin   = 'BuddyPress';

	echo '<div class="error"><p>'
	. sprintf( __( '%1$s is ineffective as it requires %2$s to be installed and active.', 'buddypress-profile-pro' ), '<strong>' . $wbbpp_plugin . '</strong>', '<strong>' . $bp_plugin . '</strong>' )
	. '</p></div>';
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}

/**
 * Function to add plugin links.
 *
 * @param      string $links
 * @return     string    $links
 */
function wbbpp_plugin_links( $links ) {
	$wbbpp_links = array(
		'<a href="' . admin_url( 'admin.php?page=buddypress_profile_pro' ) . '">' . __( 'Settings', 'buddypress-profile-pro' ) . '</a>',
		'<a href="https://wbcomdesigns.com/contact/" target="_blank">' . __( 'Support', 'buddypress-profile-pro' ) . '</a>',
	);
	return array_merge( $links, $wbbpp_links );
}


add_action( 'wpmu_new_blog', 'wbbpp_new_blog', 10, 6 );

function wbbpp_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
	global $wpdb;

	if ( is_plugin_active_for_network( 'buddypress/bp-loader.php' ) ) {
		$old_blog = $wpdb->blogid;
		switch_to_blog( $old_blog );
	}
}

function br_debug( $p ) {
	echo '<pre>';
	print_r( $p );
	echo '</pre>';
}
