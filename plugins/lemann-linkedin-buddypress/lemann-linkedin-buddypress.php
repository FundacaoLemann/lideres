<?php
/**
 * Plugin Name: Lemann: LinkedIn para BuddyPress
 * Description: Permite que usuários completem campos com informações do LinkedIn
 * Version: 1.0
 * Author: Hacklab
 * Author URI: http://hacklab.com.br/
 * Text Domain: lemann-linkedin-buddypress
 * Domain Path: /languages
 *
 * @package Lemann
 */

defined( 'ABSPATH' ) || exit;

define( 'LEMANN_LINKEDIN_BP_FILE', __FILE__ );
define( 'LEMANN_LINKEDIN_BP_DIR', __DIR__ );

require_once LEMANN_LINKEDIN_BP_DIR . '/class-lemann-linkedin-bp.php';

add_action( 'plugins_loaded', array( 'Lemann_Linkedin_Bp', 'get_instance' ) );
