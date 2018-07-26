<?php

/*
Plugin Name: Events Schedule WP Plugin
Plugin URI: http://demo.curlythemes.com/timetable-wordpress-plugin/
Description: Easy management for weekly schedules with Timetable WP Plugin.
Version: 2.5.3
Author: Curly Themes
Author URI: http://demo.curlythemes.com
Text Domain: WeeklyClass
Domain Path: /lang
*/

define( 'WCS_FILE', __FILE__ );
define( 'WCS_PREFIX', '_wcs' );
define( 'WCS_PATH', untrailingslashit( plugin_dir_path( WCS_FILE ) ) );
define( 'WCS_WOO', in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ? true : false );
define( 'WCS_GMT_OFFSET', current_time('timestamp') - time() );
define( 'WCS_VERSION', '2.5.3' );

$wcs_taxonomies_object = array();
$wcs_has_shortcode = false;
$wcs_page_dependencies = array();
$wcs_apps = array();

register_activation_hook( __FILE__, array( 'WeeklyClassCrons', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'WeeklyClassCrons', 'plugin_deactivation' ) );

add_action( 'plugins_loaded', 'wcs_load_domain' );

function wcs_load_domain(){
  load_plugin_textdomain( 'WeeklyClass', false, basename( dirname( __FILE__ ) ) . '/lang/' );
}
function wcs_get_template_part( $slug, $name = '' ) {

    $template = '';

    if ( $name ) {
        $template = locate_template( array( "{$slug}-{$name}.php", apply_filters( 'wcs_template_path', 'wcs_templates/' ) . "{$slug}-{$name}.php" ) );
    }

    if ( ! $template && $name && file_exists( WCS_PATH . "/templates/{$slug}-{$name}.php" ) ) {
        $template = WCS_PATH . "/templates/{$slug}-{$name}.php";
    }

    if ( ! $template ) {
        $template = locate_template( array( "{$slug}.php", apply_filters( 'wcs_template_path', 'wcs_templates/' ) . "{$slug}.php" ) );
    }

    if ( ! $template && file_exists( WCS_PATH . "/templates/{$slug}.php" ) ) {
	    $template = WCS_PATH . "/templates/{$slug}.php";
    }

    $template = apply_filters( 'wcs_get_template_part', $template, $slug, $name );

    if ( $template ) {
        return $template;
    }
}

function wcs_get_settings(){
  $settings = apply_filters( 'weekly_class_settings', array() );

  foreach( $settings as $key => $s ){
    $value = get_option( $key, $s['value'] );
    $settings[$key] = apply_filters( "weekly_class_setting_{$key}", isset( $s['callback'] ) ? $s['callback']( $value ) : esc_attr( $value ) );
  }
  return $settings;
}



require_once('assets/defaults/views.php');
require_once('assets/defaults/admin/array.meta-options.php' );
require_once('assets/defaults/admin/array.settings.php' );
require_once('classes/class.wcs.php');

require_once('classes/class.settings.php');


if( is_admin() ){
  require_once('classes/class.bookings.php');
  require_once('classes/class.metaboxes.php');
  require_once('classes/class.ips.php');
  require_once('classes/class.meta-options.php');
  require_once('classes/class.builder.php');
} else {
  require_once('classes/class.shortcodes.php');
  require_once('classes/class.single.php');
}
require_once('classes/class.api.php');
require_once('classes/class.widget.php');
require_once('api/ical.new.php');
require_once('api/api.wp.settings.php');

if( WCS_WOO ) require_once('api/api.wp.bookings.php');

require_once('classes/class.crons.php');
require_once('classes/class.event.class.php');
require_once('classes/class.classes.php');

require_once('classes/class.vc.php');
