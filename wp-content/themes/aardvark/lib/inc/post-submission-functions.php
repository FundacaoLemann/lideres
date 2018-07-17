<?php 

/**
 * Load scripts
 *
 */
function ghostpool_post_submission_scripts() {
	wp_enqueue_script( 'ghostpool-post-submission', get_template_directory_uri(). '/lib/scripts/jquery.post-submission.js', array( 'jquery' ) );
	wp_enqueue_script( 'plupload' );
	wp_localize_script( 'ghostpool-post-submission', 'ghostpool_post_submission_ajax', array( 
		'ajaxurl' => admin_url( 'admin-ajax.php' ), 
		'nonce' => wp_create_nonce( 'ghostpool_post_submission_action' ),
	));
}
add_action( 'wp_enqueue_scripts', 'ghostpool_post_submission_scripts' );

/**
 * Upload post submission image
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
if ( ! function_exists( 'ghostpool_post_submission' ) ) {
	function ghostpool_post_submission() {
	
		if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'ghostpool_post_submission_action' ) ) {

			$has_error = '';
					
			// Check all required fields are filled in
			if ( isset( $_POST['title'] ) && empty( $_POST['title'] ) ) {
				$has_error = true;
			} elseif ( ! isset( $_POST['title'] ) ) {
				$_POST['title'] = esc_html__( 'No title', 'aardvark' );
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
	
				// Create post
				$new_post = array(
					'post_type'     => 'post',
					'post_status'   => $_POST['submit_status'],
					'post_title'    => $_POST['title'],
					'post_content'  => $_POST['content'],
					'post_category' => array( $_POST['cats'] ),
					'tags_input'    => explode( ',', $_POST['tags'] ),
				);
				
				$new_post_id = intval( wp_insert_post( $new_post ) );
				wp_set_post_terms( $new_post_id, $_POST['formats'], 'post_format' );

				// Add name field
				if ( isset( $_POST['name'] ) && ! is_user_logged_in() ) {
					update_post_meta( $new_post_id, 'ghostpool_post_submission_username', $_POST['name'] );	
				}

				// Add email field
				if ( is_user_logged_in() ) {			
					$author_id = intval( get_post_field( 'post_author', $new_post_id ) );
					$_POST['email'] = get_the_author_meta( 'user_email', $author_id );
				}	
				if ( isset( $_POST['email'] ) ) {
					update_post_meta( $new_post_id, 'ghostpool_post_submission_email', $_POST['email'] );	
				}
								
				// Add custom field to indicate post submission			
				if ( isset( $_POST['form_id'] ) ) {
					update_post_meta( $new_post_id, 'ghostpool_post_submission_form_id', sanitize_html_class( $_POST['form_id'] ) );	
				}	

				// Upload featured image
				if ( ! empty( $_FILES ) ) {
					if ( $_FILES['error'] == 0 ) {
						foreach ( $_FILES as $file => $array ) {
							$uploaded_files = ghostpool_insert_attachment( $file, $new_post_id );
						}
					}	
				}
									
				// Notify admin of post via email
				if ( $_POST['submit_status'] == 'pending' && $_POST['email_notification'] == 'enabled' ) {
					if ( $_POST['name'] != '' ) {
						$author = $_POST['name'];
					} else {
						$author_id = intval( get_post_field( 'post_author', $new_post_id ) );
						$author = get_the_author_meta( 'display_name', $author_id );
					}
					$to = ( isset( $_POST['email_address'] ) && $_POST['email_address'] != '' ) ? sanitize_email( $_POST['email_address'] ) : sanitize_email( get_option( 'admin_email' ) );
					do_action( 'wpml_switch_language_for_email', $to ); // Switch language context…
					$subject = isset( $_POST['subject'] ) ? $_POST['subject'] : esc_html__( 'Post Submission', 'aardvark' );
					$message = esc_html__( 'A post was submitted on ', 'aardvark' ) . get_bloginfo( 'name' ) . "\r\n\r\n";
					$message .= esc_html__( 'Title: ', 'aardvark' ) . sanitize_text_field( $_POST['title'] ) . "\n";
					$message .= esc_html__( 'Author: ', 'aardvark' ) . esc_attr( $author ) . " (" . sanitize_email( $_POST['email'] ) . ")\r\n\r\n";
					$message .= esc_html__( 'You can view this post at ', 'aardvark' ) . esc_url( get_permalink( $new_post_id ) );
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
add_action( 'wp_ajax_ghostpool_post_submission_action', 'ghostpool_post_submission' );
add_action( 'wp_ajax_nopriv_ghostpool_post_submission_action', 'ghostpool_post_submission' );

?>