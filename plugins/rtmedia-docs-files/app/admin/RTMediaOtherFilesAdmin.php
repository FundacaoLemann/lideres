<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RTMediaOtherFilesAdmin
 *
 * @author sanket
 */
class RTMediaOtherFilesAdmin {
	/*
     * Constructor
     */

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( &$this, 'rtmedia_other_files_admin_script' ) );
		add_filter( 'rtmedia_general_content_default_values', array( $this, 'rtmedia_general_content_add_default_value' ), 11, 1 );
		add_filter( 'rtmedia_display_content_add_itmes', array( $this, 'rtmedia_general_content_single_view_options' ), 10, 2 );
		add_filter( 'rtmedia_display_content_groups', array( $this, 'rtmedia_other_files_display_content_groups' ), 10, 1 );
	}

	/**
	 * Loads scripts and styles for admin dashboard
	 */
	public function rtmedia_other_files_admin_script() {
		$suffix = ( function_exists( 'rtm_get_script_style_suffix' ) ) ? rtm_get_script_style_suffix() : '.min';

		wp_enqueue_script( 'rtmedia-other-files-admin', RTMEDIA_OTHER_FILES_URL . 'app/assets/admin/js/admin' . $suffix . '.js', array( 'jquery' ), RTMEDIA_OTHER_FILES_VERSION, true );
		wp_enqueue_style( 'rtmedia-other-files-admin', RTMEDIA_OTHER_FILES_URL . 'app/assets/admin/css/admin' . $suffix . '.css', '', RTMEDIA_OTHER_FILES_VERSION );
		wp_localize_script( 'rtmedia-other-files-admin', 'rtmedia_empty_extension_msg', __( 'Please provide some extensions for the Other file type.', 'rtmedia' ) );
		wp_localize_script( 'rtmedia-other-files-admin', 'rtmedia_invalid_extension_msg', __( 'Please provide extensions seperated by commas. Ex: ', 'rtmedia' ) . 'extn1,extn2,extn3' );
	}

	/*
     * Adding default values for plugin settings
     */

	public function rtmedia_general_content_add_default_value( $defaults ) {
		$defaults['allowedTypes_document_enabled'] = 0;
		$defaults['allowedTypes_document_featured'] = 0;
		$defaults['general_enable_document_other_table_view'] = 0;
		$defaults['allowedTypes_document_download'] = 0;
		$defaults['general_enable_google_docs'] = 1;
		$defaults['allowedTypes_other_enabled'] = 0;
		$defaults['allowedTypes_other_featured'] = 0;
		$defaults['rtmedia_other_file_extensions'] = '';
		$defaults['allowedTypes_other_download'] = 0;

		global $rtmedia;

		if ( isset( $rtmedia->options['rtmedia_other_file_extensions'] ) && $rtmedia->options['rtmedia_other_file_extensions'] != '' ) {
			$defaults['rtmedia_other_file_extensions'] = $rtmedia->options['rtmedia_other_file_extensions'];
		}

		return $defaults;
	}

	/**
	 * setup docs single view option under rtMedia setting
	 * @param type $render_options
	 * @param type $options
	 * @return $render_options
	 */
	public function rtmedia_general_content_single_view_options( $render_options, $options ) {
		$render_options['general_enable_document_other_table_view'] = array(
			'title' => __( 'Display documents and other files in table style (only for Document and Others tab)', 'rtmedia' ),
			'callback' => array( 'RTMediaFormHandler', 'checkbox' ),
			'args' => array(
				'key' => 'general_enable_document_other_table_view',
				'value' => $options['general_enable_document_other_table_view'],
				'desc' => __( 'In Document and Others tab, all files can be displayed in tabular format.', 'rtmedia' ),
			),
		);
		$render_options['general_enable_google_docs'] = array(
			'title' => __( 'Enable Google Docs for documents and files.', 'rtmedia' ),
			'callback' => array( 'RTMediaFormHandler', 'checkbox' ),
			'args' => array(
				'key' => 'general_enable_google_docs',
				'value' => $options['general_enable_google_docs'],
				'desc' => __( 'In lightbox media view, display the docs, pdf, excel and other office documents in Google Docs. ', 'rtmedia' ),
			),
		);

		return $render_options;
	}

	/**
	 * provides group name for docs single view docs option
	 * @param array $general_group
	 * @return string
	 */
	public function rtmedia_other_files_display_content_groups( $general_group ) {
		$general_group[20] = 'Miscellaneous';

		return $general_group;
	}

}
