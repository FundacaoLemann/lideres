<?php
/**
 * Plugin Name: LinkedIn Login
 * Version: 1.0
 * License: GPL2
 */

// Do not allow direct file access
defined('ABSPATH') or die("No script kiddies please!");

// Define plugin path
define( 'PKLI_PATH', plugin_dir_path( __FILE__ ) );
define( 'PKLI_URL', plugin_dir_url(__FILE__));

// Require New Settings Page
require_once (PKLI_PATH.'/includes/lib/class-pkli-settings.php');

// Require PkliLogin class
require_once (PKLI_PATH.'/includes/lib/PkliLogin.php');

// Require Pkli_Mods class
require_once (PKLI_PATH.'/includes/lib/class-pkli-mods.php');

// Create new objects to register actions
$linkedin = new PkliLogin();
$linkedin_mods = new Pkli_Mods();
new PKLI_Settings();
    
    
/*
  * this function loads our translation files
  */
 function pkli_login_load_translation_files() {
  load_plugin_textdomain('linkedin-login', false, 'linkedin-login/languages');
 }    

//add action to load language files
 add_action('plugins_loaded', 'pkli_login_load_translation_files');
