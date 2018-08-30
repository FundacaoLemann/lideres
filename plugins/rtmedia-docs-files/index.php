<?php
/*
 * Plugin Name: rtMedia Docs and Other files
 * Plugin URI: https://rtmedia.io/products/rtmedia-docs-files/
 * Description: This plugin provides Documents and Other file types uploading support with rtMedia.
 * Version: 1.3.2
 * Text Domain: rtmedia
 * Author: rtCamp
 * Author URI: http://rtcamp.com/?utm_source=dashboard&utm_medium=plugin&utm_campaign=rtmedia-docs-files
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 *  The server file system path to the plugin directory
 */
if ( ! defined( 'RTMEDIA_OTHER_FILES_PATH' ) ) {
	define( 'RTMEDIA_OTHER_FILES_PATH', plugin_dir_path( __FILE__ ) );
}

/**
 * The url to the plugin directory
 */
if ( ! defined( 'RTMEDIA_OTHER_FILES_URL' ) ) {
	define( 'RTMEDIA_OTHER_FILES_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * The base name of the plugin directory
 */
if ( ! defined( 'RTMEDIA_OTHER_FILES_BASE_NAME' ) ) {
	define( 'RTMEDIA_OTHER_FILES_BASE_NAME', plugin_basename( __FILE__ ) );
}

/**
 * The version of the plugin
 */
if ( ! defined( 'RTMEDIA_OTHER_FILES_VERSION' ) ) {
	/**
	 * The version of the plugin
	 */
	define( 'RTMEDIA_OTHER_FILES_VERSION', '1.3.2' );
}

// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
if ( ! defined( 'EDD_RTMEDIA_OTHER_FILES_STORE_URL' ) ) {
	// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
	define( 'EDD_RTMEDIA_OTHER_FILES_STORE_URL', 'https://rtmedia.io/' );
}

// the name of your product. This should match the download name in EDD exactly
if ( ! defined( 'EDD_RTMEDIA_OTHER_FILES_ITEM_NAME' ) ) {
	define( 'EDD_RTMEDIA_OTHER_FILES_ITEM_NAME', 'rtMedia Docs and Other files' );
}

// define RTMEDIA_DEBUG to true in wp-config.php to debug updates
if ( defined( 'RTMEDIA_DEBUG' ) && RTMEDIA_DEBUG === true ) {
	set_site_transient( 'update_plugins', null );
}

/**
 * Auto Loader Function
 *
 * Autoloads classes on instantiation. Used by spl_autoload_register.
 *
 * @param string $class_name The name of the class to autoload
 */
function rtmedia_docs_and_other_files_autoloader( $class_name ) {
	$rtlibpath = array(
		'app/' . $class_name . '.php',
		'app/admin/' . $class_name . '.php',
		'app/main/controllers/media/' . $class_name . '.php',
	);

	foreach ( $rtlibpath as $path ) {
		$path = RTMEDIA_OTHER_FILES_PATH . $path;

		if ( file_exists( $path ) ) {
			include $path;

			break;
		}
	}
}

/**
 * Check for Pro activation and genrate admin notice else load plugin classes
 *
 * @param type $class_construct
 *
 * @return boolean
 */
function rtmedia_docs_and_other_files_loader( $class_construct ) {
	/*
	 * do not construct classes or load files if rtMedia Pro is activated
	 * as it might break some functionality
	 */
	if ( defined( 'RTMEDIA_PRO_PATH' ) ) {
		add_action( 'admin_notices', 'rtmedia_docs_and_other_files_pro_active_notice' );

		return $class_construct;
	}

	$class_construct['OtherFiles']       = false;
	$class_construct['DocSupport']       = false;
	$class_construct['OtherTypeSupport'] = false;

	return $class_construct;
}

/*
 * Admin error notice and deactive plugin
 */
function rtmedia_docs_and_other_files_pro_active_notice() {
	?>
	<div class="error">
		<p>
			<strong>rtMedia Docs and Other files</strong> plugin cannot be activated with rtMedia Pro. Please <strong><a
					href="https://rtcamp.com/blog/rtmedia-pro-splitting-major-change" target="_blank">read
					this</a></strong> for more details. You may <strong><a href="https://rtcamp.com/premium-support/"
			                                                               target="_blank">contact support for help</a></strong>.
		</p>
	</div>
	<?php
	// automatic deactivate plugin if rtMedia Pro is active and current user can deactivate plugin.
	if ( current_user_can( 'activate_plugins' ) ) {
		deactivate_plugins( RTMEDIA_OTHER_FILES_BASE_NAME );
	}
}

/**
 * Register the autoloader function into spl_autoload
 */
spl_autoload_register( 'rtmedia_docs_and_other_files_autoloader' );

add_filter( 'rtmedia_class_construct', 'rtmedia_docs_and_other_files_loader' );

/*
 * EDD License
 */
include_once( RTMEDIA_OTHER_FILES_PATH . 'lib/rt-edd-license/RTEDDLicense.php' );

$rtmedia_docs_files_details = array(
	'rt_product_id'                  => 'rtmedia_other_files',
	'rt_product_name'                => 'rtMedia Docs and Other files',
	'rt_product_href'                => 'rtmedia-docs-files',
	'rt_license_key'                 => 'edd_rtmedia_other_files_license_key',
	'rt_license_status'              => 'edd_rtmedia_other_files_license_status',
	'rt_nonce_field_name'            => 'edd_rtmedia_other_files_nonce',
	'rt_license_activate_btn_name'   => 'edd_rtmedia_other_files_license_activate',
	'rt_license_deactivate_btn_name' => 'edd_rtmedia_other_files_license_deactivate',
	'rt_product_path'                => RTMEDIA_OTHER_FILES_PATH,
	'rt_product_store_url'           => EDD_RTMEDIA_OTHER_FILES_STORE_URL,
	'rt_product_base_name'           => RTMEDIA_OTHER_FILES_BASE_NAME,
	'rt_product_version'             => RTMEDIA_OTHER_FILES_VERSION,
	'rt_item_name'                   => EDD_RTMEDIA_OTHER_FILES_ITEM_NAME,
	'rt_license_hook'                => 'rtmedia_license_tabs',
	'rt_product_text_domain'         => 'rtmedia',
);

new RTEDDLicense_rtmedia_other_files( $rtmedia_docs_files_details );

/*
 * One click install/activate rtMedia.
 */
include_once( RTMEDIA_OTHER_FILES_PATH . 'lib/plugin-installer/RTMPluginInstaller.php' );

global $rtm_plugin_installer;

if ( empty( $rtm_plugin_installer ) ) {
	$rtm_plugin_installer = new RTMPluginInstaller();
}

/**
 * Add Docs link to plugins area.
 *
 * @param array  $links Links array in which we would prepend our link.
 * @param string $file Current plugin basename.
 *
 * @return array Processed links.
 */
function rtmedia_docs_and_other_files_action_links( $links, $file ) {
	// Return normal links if not plugin.
	if ( plugin_basename( __FILE__ ) !== $file ) {
		return $links;
	}

	// Add a few links to the existing links array.
	return array_merge( $links, array(
		'docs'     => '<a target="_blank" href="' . esc_url( 'https://rtmedia.io/docs/addons/docs-and-other-files/' ) . '">' . esc_html__( 'Docs', 'rtmedia' ) . '</a>',
	) );
}
add_filter( 'plugin_action_links', 'rtmedia_docs_and_other_files_action_links', 11, 2 );
add_filter( 'network_admin_plugin_action_links', 'rtmedia_docs_and_other_files_action_links', 11, 2 );
