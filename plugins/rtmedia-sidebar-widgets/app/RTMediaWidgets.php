<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RTMediaWidgets
 *
 * @author sanket
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RTMediaWidgets {

	public function __construct() {
		$this->load_translation();

		include( RTMEDIA_WIDGETS_PATH . 'app/main/controllers/template/rtm-widget-functions.php' );

		if ( ! ( defined( 'DOING_AJAX' ) && DOING_AJAX && 'imgedit-preview' == $_REQUEST['action'] ) ) {
			//to register widget
			add_action( 'widgets_init', array( &$this, 'rtmedia_widgets' ) );
		}

		// add_action ( 'wp_enqueue_scripts', array( &$this,'rtmedia_widgets_sidebar_widget_stylesheet' ));
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts_styles' ), 999 );
	}

	/**
	 * Loads language translation
	 */
	function load_translation() {
		load_plugin_textdomain( 'rtmedia', false, basename( RTMEDIA_WIDGETS_PATH ) . '/languages/' );
	}

	/**
	 * Register widgets
	 */
	function rtmedia_widgets() {
		register_widget( 'RTMediaUploaderWidget' );
		register_widget( 'RTMediaGalleryWidget' );
	}

	/**
	 * Loads styles and scripts
	 * @global type $rtmedia
	 */
	function enqueue_scripts_styles() {
		// Dont enqueue main.css if default styles is checked false in rtmedia settings
		global $rtmedia;

		if ( ! ( isset( $rtmedia->options ) && isset( $rtmedia->options['styles_enabled'] ) && $rtmedia->options['styles_enabled'] == 0 ) ) {
			wp_register_style( 'rtmedia-widgets-popular-photos-css', trailingslashit( RTMEDIA_WIDGETS_URL ) . 'app/assets/css/rtmedia-widgets-popular-photos-widget.css' );
			wp_enqueue_style( 'rtmedia-widgets-popular-photos-css' );
		}

		wp_enqueue_script( 'rtmedia-widgets-main', RTMEDIA_WIDGETS_URL . 'app/assets/js/main.js', array( 'jquery' ), RTMEDIA_WIDGETS_VERSION, true );
	}

}
