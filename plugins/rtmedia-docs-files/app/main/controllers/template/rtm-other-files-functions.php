<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if ( ! function_exists( 'rtmedia_other_files_is_document_tab' ) ) {

	/**
	 * check if document tab or not
	 * @return boolean
	 */
	function rtmedia_other_files_is_document_tab() {
		global $rtmedia_interaction;

		if ( isset( $rtmedia_interaction->context->type ) && in_array( $rtmedia_interaction->context->type, array( 'profile', 'group' ) ) && isset( $rtmedia_interaction->routes['media']->query_vars[0] ) && $rtmedia_interaction->routes['media']->query_vars[0] == 'document' ) {
			return true;
		}

		return false;
	}

}


remove_filter( 'rtmedia_template_filter', 'rtmedia_document_gallery_template', 12, 1 );
add_filter( 'rtmedia_template_filter', 'rtm_document_gallery_template', 12, 1 );
if ( ! function_exists( 'rtm_document_gallery_template' ) ) {

	/**
	 * change the selected 'madia-gallery" template with 'document-list' template if option enabled in rtMedia Settings
	 * @param  $template
	 * @return template
	 */
	function rtm_document_gallery_template( $template ) {
		if ( rtmedia_other_files_is_document_tab() && rtm_is_document_table_view_enabled() ) {
			$template = 'document-list';
		}

		return $template;
	}

}

remove_filter( 'rtmedia_template_filter', 'rtmedia_other_gallery_template', 12, 1 );
add_filter( 'rtmedia_template_filter', 'rtm_other_gallery_template', 12, 1 );
if ( ! function_exists( 'rtm_other_gallery_template' ) ) {

	/**
	 * change the selected 'media-gallery" template with 'document-list' template if option enabled in rtMedia Settings
	 * @param string $template
	 * @return template name
	 */
	function rtm_other_gallery_template( $template ) {
		if ( rtm_is_other_tab() && rtm_is_document_table_view_enabled() ) {
			$template = 'document-list';
		}

		return $template;
	}

}

add_action( 'rtmedia_set_query', 'rtm_docs_other_add_limit_query_filter' );

function rtm_docs_other_add_limit_query_filter(){
	add_filter( 'rtmedia-model-limit-query', 'rtm_remove_limit_for_document_list', 12, 3 );
}

if ( ! function_exists( 'rtm_remove_limit_for_document_list' ) ) {

	/**
	 * add filter to change the LIMIT in rtMedia Query to get all the available document media
	 * @param string $limit no of media to be display
	 * @param type $offser
	 * @param type $per_page
	 * @return limit for media if no docs type else empty string
	 */
	function rtm_remove_limit_for_document_list( $limit, $offser, $per_page ) {
		if ( rtmedia_other_files_is_document_tab() && rtm_is_document_table_view_enabled() ) {
			$limit = '';
		}

		return $limit;
	}

}

remove_filter( 'rtmedia_action_query_in_populate_media', 'rtmedia_set_per_page_media_document_list', 99, 2 );
add_filter( 'rtmedia_action_query_in_populate_media', 'rtm_set_per_page_media_document_list', 99, 2 );
if ( ! function_exists( 'rtm_set_per_page_media_document_list' ) ) {

	/**
	 * add filter to change the Per page media limit in rtMedia Query to get all the available document media
	 * @param type $action_query
	 * @param type $total_count
	 * @return type
	 */
	function rtm_set_per_page_media_document_list( $action_query, $total_count ) {
		if ( rtmedia_other_files_is_document_tab() && rtm_is_document_table_view_enabled() ) {
			$action_query->per_page_media = $total_count;
		}

		return $action_query;
	}

}


remove_action( 'bp_before_member_header', 'remove_query_limit_filter' );
add_action( 'rtmedia_query_construct', 'rtm_docs_remove_query_limit_filter' );

if ( ! function_exists( 'rtm_docs_remove_query_limit_filter' ) ) {

	/**
	 * remove filter of limit applied above
	 */
	function rtm_docs_remove_query_limit_filter() {
		if ( rtmedia_other_files_is_document_tab() && rtm_is_document_table_view_enabled() ) {
			remove_filter( 'rtmedia-model-limit-query', 'rtm_remove_limit_for_document_list', 12, 3 );
		}
	}

}

if ( ! function_exists( 'rtm_is_document_table_view_enabled' ) ) {

	/**
	 * Checks if table view is enabled for media in document tab
	 * @global type $rtmedia
	 * @return boolean
	 */
	function rtm_is_document_table_view_enabled() {
		global $rtmedia;

		if ( isset( $rtmedia->options['general_enable_document_other_table_view'] ) && $rtmedia->options['general_enable_document_other_table_view'] != '0' ) {
			return true;
		}

		return false;
	}

}

if ( ! function_exists( 'is_rtmedia_upload_document_enabled' ) ) {

	/**
	 *  Checks if Document support is enabled from rtmedia settings
	 * @global type $rtmedia
	 * @return boolean
	 */
	function is_rtmedia_upload_document_enabled() {
		global $rtmedia;

		if ( isset( $rtmedia->options['allowedTypes_document_enabled'] ) && $rtmedia->options['allowedTypes_document_enabled'] != '0' ) {
			return true;
		}

		return false;
	}

}

if ( ! function_exists( 'rtm_is_rtmedia_document' ) ) {

	/**
	 * Check if the current media is a document
	 * @global type $rtmedia_query
	 * @return boolean
	 */
	function rtm_is_rtmedia_document() {
		global $rtmedia_query;

		if ( $rtmedia_query->media_query['media_type'] == 'document' ) {
			return true;
		} else {
			return false;
		}
	}

}

remove_filter( 'rtmedia_set_media_type_filter', 'rtmedia_pro_set_media_type', 10, 2 );
add_filter( 'rtmedia_set_media_type_filter', 'rtmedia_other_files_set_media_type', 10, 2 );
if ( ! function_exists( 'rtmedia_other_files_set_media_type' ) ) {

	function rtmedia_other_files_set_media_type( $media_type, $file_object ) {
		if ( isset( $file_object ) &&  '' != $file_object ) {
			$is_document = is_rtm_document_extension( $file_object );

			if ( $is_document ) {
				return 'document';
			} else {
				return 'other';
			}
		}

		return $media_type;
	}

}

if ( ! function_exists( 'is_rtm_document_extension' ) ) {

	/**
	 * checks if the extension of the file belongs to the document media type
	 * @global type $document_extensions
	 * @param type $file_object
	 * @return boolean true if extansion valid else false
	 */
	function is_rtm_document_extension( $file_object ) {
		if ( isset( $file_object[0]['file'] ) &&  '' != $file_object[0]['file'] && is_rtmedia_upload_document_enabled() ) {
			$extn = pathinfo( $file_object[0]['file'] );
			$extn = $extn['extension'];

			global $document_extensions;

			if ( isset( $document_extensions ) && in_array( $extn, $document_extensions ) ) {
				return true;
			}
		}

		return false;
	}

}

if ( ! function_exists( 'rtm_is_other_tab' ) ) {

	/**
	 * check if document media tab or not
	 * @global type $rtmedia_interaction
	 * @return boolean
	 */
	function rtm_is_other_tab() {
		global $rtmedia_interaction;

		if ( isset( $rtmedia_interaction->context->type ) && in_array( $rtmedia_interaction->context->type, array( 'profile', 'group' ) ) && isset( $rtmedia_interaction->routes['media']->query_vars[0] ) && $rtmedia_interaction->routes['media']->query_vars[0] == 'other' ) {
			return true;
		}

		return false;
	}

}

remove_filter( 'rtmedia_located_template', 'rtmedia_locate_document_gallery_template', 10, 4 );
add_filter( 'rtmedia_located_template', 'rtm_locate_document_gallery_template', 10, 4 );
if ( ! function_exists( 'rtm_locate_document_gallery_template' ) ) {

	/**
	 * gives the document-list tamplate url or path
	 */
	function rtm_locate_document_gallery_template( $located, $url, $ogpath, $template_name ) {
		if ( isset( $template_name ) && 'document-list.php' == $template_name ) {
			if ( $url ) {
				$located = trailingslashit( RTMEDIA_OTHER_FILES_URL ) . $ogpath . $template_name;
			} else {
				$located = trailingslashit( RTMEDIA_OTHER_FILES_PATH ) . $ogpath . $template_name;
			}
		}

		return $located;
	}

}

add_filter( 'rtmedia_located_template', 'rtm_locate_document_gallery_item_template', 99, 4 );
if ( ! function_exists( 'rtm_locate_document_gallery_item_template' ) ) {

	/**
	 * gives the document-list-item tamplate url or path.
	 */
	function rtm_locate_document_gallery_item_template( $located, $url, $ogpath, $template_name ) {

		if ( isset( $template_name ) && 'document-list-item.php' === $template_name ) {

			// Set template.
			if ( ! empty( $url ) ) {

				$located = trailingslashit( RTMEDIA_OTHER_FILES_URL ) . $ogpath . $template_name;

			} else {

				$located = trailingslashit( RTMEDIA_OTHER_FILES_PATH ) . $ogpath . $template_name;

			}
		}

		return $located;

	}
}

if ( ! function_exists( 'rtm_other_files_document_other_files_list_date' ) ) {

	/**
	 * Change the document files list upload date format.
	 *
	 * @global type $rtmedia_media
	 * @param type $rtmedia_id ID of media to change date.
	 * @return type
	 */
	function rtm_other_files_document_other_files_list_date( $rtmedia_id = false ) {

		global $rtmedia_backbone;

		if ( isset( $rtmedia_backbone['backbone'] ) && $rtmedia_backbone['backbone'] ) {
			echo '<%= post_date_gmt %>';
		} else {
			if ( ! empty( $rtmedia_id ) && ! $rtmedia_id ) {
				global $rtmedia_media;

				$rtmedia_id = $rtmedia_media->id;
			}

			$media     = get_post( rtmedia_media_id( $rtmedia_id ) );
			$date_time = '';

			if ( isset( $media->post_date_gmt ) && $media->post_date_gmt != '' ) {
				$date_time = date( 'd-m-Y', strtotime( $media->post_date_gmt ) );
			}

			return apply_filters( 'rtmedia_other_files_document_other_files_list_date_filter', $date_time );
		}
	}
}

if ( ! function_exists( 'is_rtmedia_upload_other_enabled' ) ) {

	/**
	 * Checks if Document support is enabled from rtmedia settings
	 * @global type $rtmedia
	 * @return boolean true if enable else false
	 */
	function is_rtmedia_upload_other_enabled() {
		global $rtmedia;

		if ( isset( $rtmedia->options['allowedTypes_other_enabled'] ) && $rtmedia->options['allowedTypes_other_enabled'] != '0' ) {
			return true;
		}

		return false;
	}

}

if ( ! function_exists( 'is_rtm_other_file_type' ) ) {

	/**
	 * Check if the current media is a document
	 * @global type $rtmedia_query
	 * @return boolean true if document type else false
	 */
	function is_rtm_other_file_type() {
		global $rtmedia_query;

		if ( $rtmedia_query->media_query['media_type'] == 'other' ) {
			return true;
		} else {
			return false;
		}
	}

}
// handles ajax request to delete other type media
add_action( 'wp_ajax_rtmedia_docs_other_file_delete_user_media', 'rtmedia_docs_other_file_delete_user_media' );

/**
 * Delete the other type media.
 */
function rtmedia_docs_other_file_delete_user_media() {

	// Get media id from ajax request.
	$media_id = filter_input( INPUT_POST, 'media_id', FILTER_SANITIZE_STRING );

	if ( ! empty( $media_id ) ) {
		$media_id = intval( $media_id );
	} else {
		$media_id = 0;
	}

	// If media is not found, then throw error.
	if ( 0 === $media_id ) {
		wp_send_json_error( esc_html__( 'Invalid media.', 'rtmedia' ) );
	}

	// Validate ajax by nounce.
	if ( ! isset( $_POST['delete_nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['delete_nonce'] ) ), 'rtm_other_file_delete_nonce' . $media_id ) ) {
		wp_send_json_error( esc_html__( 'Sorry, your nonce did not verify.', 'rtmedia' ) );
	}

	// Check for valid post data.
	if ( isset( $_POST['action'] )
		 && ( 'rtmedia_docs_other_file_delete_user_media' == $_POST['action'] )
		 && isset( $media_id )
		 && ( '' != $media_id )
		 && is_user_logged_in() ) {

		$media = new RTMediaMedia();
		$model = new RTMediaModel();

		$if_group = ( isset( $_POST['rtm_group_id'] ) )
					? intval( $_POST['rtm_group_id'] ) : 0;

		// Check if the media to be delete exists and the current user is the media_author.
		$curr_media = $model->get( array(
			'id'           => $media_id,
			'media_author' => get_current_user_id(),
		) );

		// Check if user is group admin ir not.
		$if_group_admin = ( $if_group )
							? ( function_exists( 'bp_group_is_admin' ) )
								? bp_group_is_admin() : false
							: false;

		/**
		 * Check if user can delete the media or not.
		 * If user is the uploader of media, then allow to delete.
		 * For deleting media from group, check if loggedin user is
		 * admin of the group or not.
		 * If the loggedin user is admin of the group, then allow user to delete.
		 */
		$is_allow_delete = $curr_media ? $curr_media : $if_group_admin;

		// Delete media if allowed.
		if ( $is_allow_delete ) {

				do_action( 'rtm_before_delete_docs_other_file', $media_id );
				// Delete the media if media is found.
				$delete = $media->delete( $media_id );
				do_action( 'rtm_after_delete_docs_other_file', $media_id );
				wp_die( '1' );
		}
	} // End if().

	// Return 0 if valid data is not received.
	wp_die( '0' );
}





remove_filter( 'rtmedia_mycred_add_points', 'rtmedia_mycred_add_points_for_view_document', 10 );
add_filter( 'rtmedia_mycred_add_points', 'rtmedia_mycred_add_points_for_view_document', 10, 1 );
if( ! function_exists( 'rtmedia_mycred_add_points_for_view_document' ) ) {
	function rtmedia_mycred_add_points_for_view_document( $rtmedia_key ) {
		global $rtmedia;

		if ( is_array( $rtmedia_key ) && function_exists( 'is_rtmedia_upload_document_enabled' ) && function_exists( 'rtmedia_mycred_custom_points_shorting' ) ) {
			if ( is_rtmedia_upload_document_enabled() ) {
				$rtmedia_key['after_document_view'] = array( 'action' => 'rtmedia_after_view_media' );
			}

			$rtmedia_document = array(
				'after_upload_document'	=> array( 'action' => 'rtmedia_after_add_document' ),
			);

			$rtmedia_key = rtmedia_mycred_custom_points_shorting( $rtmedia_key, 'after_upload_video', $rtmedia_document );
		}
		return $rtmedia_key;
	}
}

/**
 * Add html in rtMedia sidebar Widget to add support type for Docs and other media type.
 *
 * @since 1.3.2 require 'rtmedia-sidebar-widgets' addon version 1.3.6
 *
 * @param  array $value Contain the value for there particular key.
 * @param  array $instance Contain the class of the Sidebar widget.
 */
function rtmedia_sidebar_widget_media_type_allow_callback( $value, $instance ) {
	$allowdocument = isset( $value['allow_document'] ) ? (bool) $value['allow_document'] : false;
	$allowother = isset( $value['allow_other'] ) ? (bool) $value['allow_other'] : false;
	?>
	<p>
		<input role="checkbox" type="checkbox" name="<?php echo esc_attr( $instance->get_field_name( 'allow_document' ) ); ?>" id="<?php echo esc_attr( $instance->get_field_id( 'allow_document' ) ); ?>" <?php checked( $allowdocument ); ?> />
		<label for="<?php echo esc_attr( $instance->get_field_id( 'allow_document' ) ); ?>"><?php echo esc_html( 'Show Document', 'rtmedia' ); ?></label>
	</p>
	<p>
		<input role="checkbox" type="checkbox" name="<?php echo esc_attr( $instance->get_field_name( 'allow_other' ) ); ?>" id="<?php echo esc_attr( $instance->get_field_id( 'allow_other' ) ); ?>" <?php checked( $allowother ); ?> />
		<label for="<?php echo esc_attr( $instance->get_field_id( 'allow_other' ) ); ?>"><?php echo esc_html( 'Show Other Media Types', 'rtmedia' ); ?></label>
	</p>
	<?php
}
add_action( 'rtmedia_sidebar_widget_media_type_allow', 'rtmedia_sidebar_widget_media_type_allow_callback', 10, 2 );

/**
 * Run when rtMedia sidebar widget setting is being saved.
 *
 * @since 1.3.2 require 'rtmedia-sidebar-widgets' addon version 1.3.6
 *
 * @param  array $instance Contain the value widget instance value.
 * @param  array $new_instance Contain the value widget new instance value.
 *
 * @return  array $instance Contain the value of extra media type. 1 if allow or 0 is not allow.
 */
function rtmedia_sidebar_widget_setting_save_callback( $instance, $new_instance ) {
	$instance['allow_document'] = ! empty( $new_instance['allow_document'] ) ? 1 : 0;
	$instance['allow_other'] = ! empty( $new_instance['allow_other'] ) ? 1 : 0;
	return $instance;
}
add_filter( 'rtmedia_sidebar_widget_setting_save', 'rtmedia_sidebar_widget_setting_save_callback', 10, 2 );

/**
 * Run when rtMedia sidebar widget setting is being saved.
 *
 * @since 1.3.2 require 'rtmedia-sidebar-widgets' addon version 1.3.6
 *
 * @param  array $allow Contain the value widget instance value.
 * @param  array $instance Contain the value widget new instance value.
 *
 * @return  array $allow Contain the value of Media tab that are allow.
 */
function rtm_gallery_widget_allow_type_callback( $allow, $instance ) {
	if ( isset( $instance['allow_document'] ) && true === (bool) $instance['allow_document'] ) {
		$allow[] = 'document';
	}

	if ( isset( $instance['allow_other'] ) && true === (bool) $instance['allow_other'] ) {
		$allow[] = 'other';
	}
	return $allow;
}
add_filter( 'rtm_gallery_widget_allow_media_type', 'rtm_gallery_widget_allow_type_callback', 10, 2 );

/**
 * Run when rtMedia sidebar widget Tab is being Display.
 *
 * @since 1.3.2 require 'rtmedia-sidebar-widgets' addon version 1.3.6
 *
 * @param  array $strings Media tab name.
 *
 * @return array $strings Media tab name.
 */
function rtmedia_sidebar_widget_media_tab_name_callback( $strings ) {
	$strings['document'] = __( 'Documents', 'rtmedia' );
	$strings['other'] = __( 'Others', 'rtmedia' );
	return $strings;
}
add_filter( 'rtmedia_sidebar_widget_media_tab_name', 'rtmedia_sidebar_widget_media_tab_name_callback' );
