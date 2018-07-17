<?php

/**
 * Load scripts
 *
 */
function ghostpool_post_edit_scripts() {
	wp_enqueue_script( 'ghostpool-post-edit', get_template_directory_uri(). '/lib/scripts/jquery.post-edit.js', array( 'jquery' ) );
	wp_enqueue_script( 'plupload' );
	wp_localize_script( 'ghostpool-post-edit', 'ghostpool_post_edit_ajax', array( 
		'ajaxurl' => admin_url( 'admin-ajax.php' ), 
		'nonce' => wp_create_nonce( 'ghostpool_post_edit_action' ),
	));
}
add_action( 'wp_enqueue_scripts', 'ghostpool_post_edit_scripts' );

/**
 * Upload post edit image
 *
 */
if ( ! function_exists( 'ghostpool_insert_attachment' ) ) {	
	function ghostpool_insert_attachment( $file_handler, $post_id ) {
		if ( $_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK )
			return false;		
		require_once( ABSPATH . 'wp-admin' . '/includes/image.php' );
		require_once( ABSPATH . 'wp-admin' . '/includes/file.php' );
		require_once( ABSPATH . 'wp-admin' . '/includes/media.php' );	
		$allowed_file_types = array( 'jpg' =>'image/jpg', 'jpeg' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png' );
    	$overrides = array( 'test_form' => false, 'mimes' => $allowed_file_types );
		$attach_id = media_handle_upload( $file_handler, $post_id, array(), $overrides );
		if ( ! is_wp_error( $attach_id ) ) {
			if ( ! add_post_meta( $post_id, '_thumbnail_id', $attach_id, true ) ) {
				update_post_meta( $post_id, '_thumbnail_id', $attach_id );
			}
			return $attach_id;
		}
	}
}

/**
 * PHP form validation
 *
 */
if ( ! function_exists( 'ghostpool_post_edit' ) ) {
	function ghostpool_post_edit() {
	
		if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'ghostpool_post_edit_action' ) ) {

			$has_error = '';

			$post_edit = array();
			$post_edit = get_post( $_POST['post_id'] );

			// Check all required fields are filled in
			if ( isset( $_POST['title'] ) && empty( $_POST['title'] ) ) {
				$has_error = true;
			} elseif ( ! isset( $_POST['title'] ) ) {
				$_POST['title'] = 'No title';
			}

			if ( isset( $_POST['name'] ) && empty( $_POST['name'] ) && ! is_user_logged_in() ) {
				$has_error = true;
			} elseif ( ! isset( $_POST['name'] ) ) {
				$_POST['name'] = '';
			}

			if ( isset( $_POST['email'] ) && empty( $_POST['email'] ) && ! is_email( $_POST['email'] ) && ! is_user_logged_in() ) {
				$has_error = true;
			} elseif ( ! isset( $_POST['email'] ) ) {
				$_POST['email'] = '';
			}

			if ( isset( $_POST['cats'] ) && empty( $_POST['cats'] ) ) {
				$has_error = true;
			} elseif ( ! isset( $_POST['cats'] ) ) {
				$_POST['cats'] = '';
			}

			if ( isset( $_POST['formats'] ) && empty( $_POST['formats'] ) ) {
				$_POST['formats'] = '0';
			} elseif ( ! isset( $_POST['formats'] ) ) {
				$_POST['formats'] = '0';	
			}	
							
			if ( isset( $_POST['content'] ) && empty( $_POST['content'] ) ) {
				$has_error = true;
			} elseif ( ! isset( $_POST['content'] ) ) {
				$_POST['content'] = '';
			}

			if ( isset( $_POST['tags'] ) && empty( $_POST['tags'] ) ) {
				$has_error = true;
			} elseif ( ! isset( $_POST['tags'] ) ) {
				$_POST['tags'] = '';
			}
	
			if ( $_POST['toc'] == '1' && empty( $_POST['toc'] ) ) {
				$has_error = true;
			}

			// If all required fields are valid submit form	
			if ( $has_error == false ) {

				// Edit post
				$post_edit->post_title = stripslashes( $_POST['title'] );
				$post_edit->post_content = stripslashes( $_POST['content'] );
				$post_edit->post_category = array( $_POST['cats'] );
				$post_edit->post_format = $_POST['formats'];
				$post_edit->tags_input = explode( ',', $_POST['tags'] );

				$post_id = wp_update_post( $post_edit );
				wp_set_post_terms( $post_id, $post_edit->post_format, 'post_format' );
				wp_set_post_terms( $post_id, $post_edit->post_category, 'category' );

				// Upload featured image
				if ( ! empty( $_FILES ) ) {
					if ( $_FILES['error'] == 0 ) {
						foreach ( $_FILES as $file => $array ) {
							$uploaded_files = ghostpool_insert_attachment( $file, $post_id );
						}
					}	
				}
											
				// Notify admin of post via email
				if ( ghostpool_option( 'post_editing' ) == 'pending' && ghostpool_option( 'post_edit_email_notification' ) == 'enabled' ) {
					$to = get_option( 'admin_email' );
					do_action( 'wpml_switch_language_for_email', $to ); // Switch language context…
					$subject = esc_html__( 'Post Edit', 'aardvark' );
					$message = esc_html__( 'A post was edited on ', 'aardvark' ) . get_bloginfo( 'name' ) . "\r\n\r\n";
					$message .= esc_html__( 'Title: ', 'aardvark' ) . stripslashes( $_POST['title'] ) . "\r\n\r\n";
					$message .= esc_html__( 'You can view this post at ', 'aardvark' ) . esc_url( get_permalink( $post_id ) );
					$headers = '';
					if ( function_exists( 'ghostpool_wp_mail' ) ) { 
						ghostpool_wp_mail( $to, $subject, $message, $headers );				
					}
					do_action( 'wpml_restore_language_from_email' ); // Switch language back	 
				}
			
				echo json_encode( array( 'status' => 'success' ) );

			} else {
			
				echo json_encode( array( 'status' => 'error' ) );
				
			}
			
			exit();

		}
		
	}
}	
add_action( 'wp_ajax_ghostpool_post_edit_action', 'ghostpool_post_edit' );
add_action( 'wp_ajax_nopriv_ghostpool_post_edit_action', 'ghostpool_post_edit' ); 

?>