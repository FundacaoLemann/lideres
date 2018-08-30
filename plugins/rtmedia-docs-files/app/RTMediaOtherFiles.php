<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RTMediaOtherFiles
 *
 * @author sanket
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RTMediaOtherFiles {
	/*
     * Constructor
     */

	public function __construct() {

		$this->load_translation();

		include( RTMEDIA_OTHER_FILES_PATH . 'app/main/controllers/template/rtm-other-files-functions.php' );

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts_styles' ), 999 );
		add_action( 'init', array( $this, 'rtmedia_other_files_do_upgrade' ) );
		add_filter( 'rtmedia_media_type_support', array( $this, 'rtmedia_media_type_support_callback' ), 10, 1 );

		// Set template for tabular view while adding new media.
		add_filter( 'rtmedia_backbone_template_filter', array( $this, 'rtmedia_other_files_backbone_template_filter' ) );

		// Set backbone array while uploading docs.
		add_filter( 'rtmedia_media_array_backbone', array( $this, 'rtmedia_other_files_backbone_array' ), 99 );

		new RTMediaOtherFilesAdmin();
	}

	/**
	 * Calculate media size in MB
	 *
	 * @param  Object $media_array Object of media.
	 * @return Object              Converted size into MBs.
	 */
	public function rtmedia_other_files_backbone_array( $media_array ) {

		if ( property_exists( $media_array, 'file_size' ) ) {

			// Convert into MB.
			$media_size = round( $media_array->file_size / ( 1024 * 1024 ), 2 );

			// Set into object.
			$media_array->file_size = $media_size;
		}

		if ( property_exists( $media_array, 'post_date_gmt' ) ) {

			$media_array->post_date_gmt = date( 'd-m-Y', strtotime( $media_array->post_date_gmt ) );

		}

		return $media_array;
	}

	/**
	 * Set template for table view.
	 *
	 * @param  string $template_name Name of template.
	 * @return String                Template name for table view.
	 */
	function rtmedia_other_files_backbone_template_filter( $template_name ) {

		global $rtmedia_query, $rtmedia;

		// Set only for documents tab for table view.
		if ( isset( $rtmedia_query->media_query['media_type'] )
			&& ( 'document' === $rtmedia_query->media_query['media_type'] || 'other' === $rtmedia_query->media_query['media_type'] )
			&& isset( $rtmedia->options['general_enable_document_other_table_view'] )
			&& '0' !== $rtmedia->options['general_enable_document_other_table_view'] ) {

			// Template for tabular view.
			return 'document-list-item';
		}

		return $template_name;
	}

	public function rtmedia_media_type_support_callback( $media_type ) {
		$media_type[] = 'document';
		$media_type[] = 'other';
		return $media_type;
	}

	/*
     * Load translation
     */

	public function load_translation() {
		load_plugin_textdomain( 'rtmedia', false, basename( RTMEDIA_OTHER_FILES_PATH ) . '/languages/' );
	}

	/*
     * Enqueue scripts and styles
     */

	public function enqueue_scripts_styles() {
		global $rtmedia;

		$suffix = ( function_exists( 'rtm_get_script_style_suffix' ) ) ? rtm_get_script_style_suffix() : '.min';

		if ( !( isset( $rtmedia->options ) && isset( $rtmedia->options['styles_enabled'] ) && $rtmedia->options['styles_enabled'] == 0 ) ) {
			wp_enqueue_style( 'rtmedia-other-files-main', RTMEDIA_OTHER_FILES_URL . 'app/assets/css/rtm-docs' . $suffix . '.css', '', RTMEDIA_OTHER_FILES_VERSION );
		}

		$rtmedia_other_files_main_js = array(
			'rtmedia_file_not_allowed_singular' => __( 'Following file is not allowed and can\'t be attached', 'rtmedia' ),
			'rtmedia_file_not_allowed_plural' => __( 'Following files are not allowed and can\'t be attached', 'rtmedia' ),
			'rtmedia_file_not_deleted' => __( 'Something went wrong while deleting the media. Please try again', 'rtmedia' ),
			'rtmedia_file_no_doc_msg' => __( 'Oops !! There\'s no media found for the request !!', 'rtmedia' ),
		);
		wp_enqueue_script( 'rtmedia-other-files-main', RTMEDIA_OTHER_FILES_URL . 'app/assets/js/rtm-docs' . $suffix . '.js', array( 'jquery' ), RTMEDIA_OTHER_FILES_VERSION, true );
		wp_localize_script( 'rtmedia-other-files-main', 'rtmedia_other_files_main_js', apply_filters('rtm_other_file_js_strings', $rtmedia_other_files_main_js ) );

		// Do not apply mesonary view to tabular view.
		if ( ( rtmedia_other_files_is_document_tab() || rtm_is_other_tab() )
			&& rtm_is_document_table_view_enabled() ) {

			wp_localize_script( 'rtmedia-main', 'rtmedia_masonry_layout', 'false' );

		}
	}

	/*
     * Upgrade rtMedia other files type
     */

	public function rtmedia_other_files_do_upgrade() {
		if ( class_exists( 'RTDBUpdate' ) ) {
			$update = new RTDBUpdate( false, RTMEDIA_OTHER_FILES_PATH . 'index.php', false, true );

			if ( ! defined( 'RTMEDIA_OTHER_FILES_VERSION' ) ) {
				define( 'RTMEDIA_OTHER_FILES_VERSION', $update->db_version );
			}

			if ( $update->check_upgrade() ) {
				add_action( 'rt_db_upgrade', array( $this, 'rtm_db_upgrade_migrate_download_media_btn_settings' ) );

				$update->do_upgrade();

				remove_action( 'rt_db_upgrade', array( $this, 'rtm_db_upgrade_migrate_download_media_btn_settings' ) );
			}
		}
	}

	/*
     * migrate download button settings for media types
     */

	public function rtm_db_upgrade_migrate_download_media_btn_settings() {
		if ( ! rtmedia_get_site_option( 'rtmedia-migrate-download-btn-settings' ) ) {
			global $rtmedia;

			if ( isset( $rtmedia ) && isset( $rtmedia->options ) ) {
				$options = $rtmedia->options;

				if ( isset( $options['general_enableDownloads'] ) ) {
					$val = $options['general_enableDownloads'];

					$options['allowedTypes_document_download'] = $val;
					$options['allowedTypes_other_download'] = $val;

					unset( $options['general_enableDownloads'] );

					rtmedia_update_site_option( 'rtmedia-options', $options );

					$rtmedia->options = $options;
				}
			}
		}

		rtmedia_get_site_option( 'rtmedia-migrate-download-btn-settings', 'true' );
	}

}
