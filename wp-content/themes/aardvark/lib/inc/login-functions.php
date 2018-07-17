<?php

global $wpdb;

/**
 * Add login link
 *
 */	
 if ( ! function_exists( 'ghostpool_login_link' ) ) {
	function ghostpool_login_link() {
		if ( has_filter( 'ghostpool_login_link' ) ) {
			return apply_filters( 'ghostpool_login_link', '' );
		} elseif ( ghostpool_option( 'login_register_popup_redirect' ) == 'enabled' ) {
			return '#login';
		} else {
			return wp_login_url( apply_filters( 'the_permalink', get_permalink() ) );
		}
	}
}
		
/**
 * Restrict front/backend end access
 *
 */	
if ( ! function_exists( 'ghostpool_login_register_page_redirects' ) ) {
	function ghostpool_login_register_page_redirects() {

		$login_page_id = ghostpool_option( 'login_register_page_redirect' );
		$member_page_id = ghostpool_option( 'members_homepage' );

		// Member homepage
		if ( is_user_logged_in() && is_front_page() && ! empty( $member_page_id ) && $member_page_id != 0 && ! is_page( $member_page_id ) ) {
		
			wp_safe_redirect( get_permalink( $member_page_id ) );
			exit;
		
		// Redirect to specific page if not logged in	
		} elseif ( ! empty( $login_page_id ) && $login_page_id != 0 && ! is_admin() ) {
			
			if ( ! is_user_logged_in() ) {
			
				$excluded_pages = $login_page_id;
				if ( is_array( ghostpool_option( 'login_register_page_redirect_exclusion' ) ) ) {
					$excluded_pages = array_merge( array( $login_page_id ), ghostpool_option( 'login_register_page_redirect_exclusion' ) );
				}
								
				if ( ! is_page( $excluded_pages ) && ( function_exists( 'bp_is_active' ) && ! bp_is_register_page() && ! bp_is_activation_page() ) ) {
					
					wp_safe_redirect( get_permalink( $login_page_id ) );
					exit;
					
				}
				
			} elseif ( is_user_logged_in() && is_page( $login_page_id ) ) {
				
				wp_safe_redirect( home_url( '/' ) );	
				exit;
					
			}
			
		}
		
	}
}
add_action( 'template_redirect', 'ghostpool_login_register_page_redirects' );

/**
 * Redirect wp-login.php to login/register popup window or specific page
 *
 */
if ( ! function_exists( 'ghostpool_login_redirect' ) ) {
	function ghostpool_login_redirect() {
		if ( ! is_user_logged_in() ) {			
			global $pagenow;			
			$page_id = ghostpool_option( 'login_register_page_backend_redirect' );
			if ( 'wp-login.php' == $pagenow && ( ghostpool_option( 'login_register_popup_backend_redirect' ) == 'enabled' OR ( ! empty( $page_id ) && $page_id != 0 ) ) ) {
				if ( ghostpool_option( 'login_register_popup_backend_redirect' ) == 'enabled' ) {
					$login_url = home_url( '#login/' );
					$register_url = home_url( '#register/' );
					$lost_password_url = home_url( '#lost-password/' );
				} elseif ( ! empty( $page_id ) && $page_id != 0 ) {
					$login_url = get_permalink( $page_id ) . '#login/';
					$register_url = get_permalink( $page_id ) . '#register/';
					$lost_password_url = get_permalink( $page_id ) . '#lost-password/';
				}
				if ( isset( $_GET['action'] ) && $_GET['action'] == 'register' ) {
					wp_redirect( esc_url( $register_url ) ); // Open registration modal window
					exit;
				} elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'lostpassword' ) {
					wp_redirect( esc_url( $lost_password_url ) ); // Open lost password modal window
					exit;
				} elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'bpnoaccess' ) {
					wp_redirect( esc_url( $login_url ) ); // If there are specific actions open login modal window
					exit;
				} elseif ( ! isset( $_POST['wp-submit'] ) && ! isset( $_GET['checkemail'] ) && ! isset( $_GET['action'] ) && ! isset( $_GET['reauth'] ) && ! isset( $_GET['interim-login'] ) && isset( $_GET['loggedout'] ) ) {
					wp_redirect( esc_url( $login_url ) ); // If there are no actions open login modal window
					exit;
				} else {
					return;
				}
			}
		}
	}
}
add_action( 'init', 'ghostpool_login_redirect' );

/**
 * Set user ID to 0 for logged out users do to WooCommerce conflict
 *
 */
if ( ! function_exists( 'ghostpool_wc_nonce_fix' ) ) {
	function ghostpool_wc_nonce_fix( $uid = 0, $action = '' ) {
		if ( $action == 'ghostpool_login_page_action' OR $action == 'ghostpool_login_popup_action' OR $action == 'ghostpool_register_page_action' OR $action == 'ghostpool_register_popup_action' OR $action == 'ghostpool_lost_password_page_action' OR $action == 'ghostpool_lost_password_popup_action' ) {
			return 0;
		} else {	
			return $uid;
		}
	}
}
add_filter( 'nonce_user_logged_out', 'ghostpool_wc_nonce_fix', 100, 2 );

/**
 * Get captcha data
 *
 */
if ( ! function_exists( 'ghostpool_captcha' ) ) {
	function ghostpool_captcha() {	
		if ( function_exists( 'ghostpool_custom_captcha' ) ) {
			$captcha = ghostpool_custom_captcha();
		} elseif ( function_exists( 'gglcptch_check' ) ) {
			$captcha = gglcptch_check();
			if ( $captcha['reason'] == 'ERROR_NO_KEYS' ) {
				$captcha = '';
			}
		} elseif ( has_filter( 'hctpc_verify' ) ) {
			$captcha = apply_filters( 'hctpc_verify', true );
			if ( true === $captcha ) { 
				$captcha = array();
				$captcha['reason'] = ''; 
			} else { 
				$captcha = array();
				$captcha['reason'] = esc_html__( 'Incorrect captcha.', 'aardvark' ); 
			}
		} elseif ( has_filter( 'cptch_verify' ) ) {
			$captcha = apply_filters( 'cptch_verify', true );
			if ( true === $captcha ) { 
				$captcha = array();
				$captcha['reason'] = ''; 
			} else { 
				$captcha = array();
				$captcha['reason'] = esc_html__( 'Incorrect captcha.', 'aardvark' );
			}			
		} else {
			$captcha = '';
		}
		return $captcha;
	}	
}

/**
 * Send login data
 *
 */
if ( isset( $_POST['action'] ) && $_POST['action'] == 'ghostpool_login' ) {

	if ( isset( $_REQUEST['ghostpool_login_page_nonce'] ) && ! wp_verify_nonce( $_REQUEST['ghostpool_login_page_nonce'], 'ghostpool_login_page_action' ) ) {
		exit;
	} elseif ( isset( $_REQUEST['ghostpool_login_popup_nonce'] ) && ! wp_verify_nonce( $_REQUEST['ghostpool_login_popup_nonce'], 'ghostpool_login_popup_action' ) ) {
		exit;
	} 
	
	$username = esc_sql( $_REQUEST['log'] );
	if ( function_exists( 'remove_placeholder_escape' ) ) {
		$password = $wpdb->remove_placeholder_escape( esc_sql( $_REQUEST['pwd'] ) );
	} else {
		$password = esc_sql( $_REQUEST['pwd'] );
	}
	if ( isset( $_REQUEST['rememberme'] ) ) {
		$remember = true; 
	} else {
		$remember = false;
	}
	
	// Captcha
	$captcha = ghostpool_captcha();		
			
	$login_data = array();
				
	// Get user data from username
	$user_data = get_user_by( 'login', $username );
	
	// If username does not exist, look for email login instead
	if ( empty( $user_data ) ) { 
		$user_data = get_user_by( 'email', $username ); 
	}
	
	if ( ( $captcha && $captcha['reason'] == '' ) OR $captcha == '' ) {
		$login_data['user_login'] = $username;
		$login_data['user_password'] = $password;
		$login_data['remember'] = $remember;
		if ( ! empty( $user_data ) ) { 
			if ( function_exists( 'bp_is_active' ) && BP_Signup::check_user_status( $user_data->ID ) ) {
				$login_data['user_login'] = '';
				$login_data['user_password'] = '';
			}
		}
		$user_verify = wp_signon( $login_data, false ); 
	}
	
	// Validate fields
	if ( $captcha && $captcha['reason'] != '' ) {
		echo "<div class='gp-error'>" . esc_html__( 'Incorrect captcha.', 'aardvark' ) . "</div>";	
		exit;
	} elseif ( empty( $user_data ) && is_wp_error( $user_verify ) ) {
		echo "<div class='gp-error'>" . esc_html__( 'Invalid username and password.', 'aardvark' ) . "</div>";
		exit;
	} elseif ( ! empty( $user_data ) && is_wp_error( $user_verify ) ) {
		echo "<div class='gp-error'>" . esc_html__( 'Invalid password.', 'aardvark' ) . "</div>";
		exit;   
	} else {
		$login_redirect_page_id = ghostpool_option( 'login_redirect' );		
		echo '<script data-cfasync="false" type="text/javascript">';
			if ( has_filter( 'ghostpool_login_redirect' ) ) {		
				echo apply_filters( 'ghostpool_login_redirect', '', $user_data );
			} elseif ( ! empty( $login_redirect_page_id ) && $login_redirect_page_id != 0 ) {		
				echo 'window.location.replace("' . get_permalink( $login_redirect_page_id ) . '");';
			} else {	
				echo 'window.location.reload();';
			}
		echo '</script>';	
		exit;
	}

}

/**
 * Send registration data
 *
 */
if ( isset( $_POST['action'] ) && $_POST['action'] == 'ghostpool_register' && get_option( 'users_can_register' ) ) {
	
	if ( isset( $_REQUEST['ghostpool_register_page_nonce'] ) && ! wp_verify_nonce( $_REQUEST['ghostpool_register_page_nonce'], 'ghostpool_register_page_action' ) ) {
		exit;
	} elseif ( isset( $_REQUEST['ghostpool_register_popup_nonce'] ) && ! wp_verify_nonce( $_REQUEST['ghostpool_register_popup_nonce'], 'ghostpool_register_popup_action' ) ) {
		exit;
	} 
	
	$info = array();
	$info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user( $_POST['user_login'] );
	$info['user_pass'] = sanitize_text_field( $_POST['user_pass'] );
	$info['user_email'] = sanitize_email( $_POST['user_email'] );
	
	// Captcha
	$captcha = ghostpool_captcha();
			
	// Validate fields
	if ( $captcha && $captcha['reason'] != '' ) {
		$user_register = '';
		echo "<div class='gp-error'>" . esc_html__( 'Incorrect captcha.', 'aardvark' ) . "</div>";
		exit;
	} elseif ( $_POST['user_pass'] !== $_POST['user_confirm_pass'] ) {
		$user_register = '';
		echo "<div class='gp-error'>" . esc_html__( 'Your passwords do not match.', 'aardvark' ) . "</div>";
		exit;				
	} else {
		$user_register = wp_insert_user( $info );
	}
	
	if ( is_wp_error( $user_register ) ) {	
		$error = $user_register->get_error_codes();
		if ( in_array( 'empty_user_login', $error ) ) {
			echo "<div class='gp-error'>" . $user_register->get_error_message( 'empty_user_login' ) . "</div>";	
			exit;
		} elseif ( in_array( 'existing_user_login', $error ) ) {
			echo "<div class='gp-error'>" . esc_html__( 'This username is already registered.', 'aardvark' ) . "</div>";	
			exit;
		} elseif ( in_array( 'existing_user_email', $error ) ) {
			echo "<div class='gp-error'>" . esc_html__( 'This email address is already registered.', 'aardvark' ) . "</div>";	
			exit; 
		}
	} else {
		wp_new_user_notification( $user_register, null, 'both' );
		echo "<div class='gp-success'>" . esc_html__( 'An email has been sent with your details.', 'aardvark' ) . "</div>";	
		exit; 
	}

}

/**
 * Send lost password data
 *
 */
if ( isset( $_POST['action'] ) && $_POST['action'] == 'ghostpool_lost_password' ) {

	if ( isset( $_REQUEST['ghostpool_lost_password_page_nonce'] ) && ! wp_verify_nonce( $_REQUEST['ghostpool_lost_password_page_nonce'], 'ghostpool_lost_password_page_action' ) ) {
		exit;
	} elseif ( isset( $_REQUEST['ghostpool_lost_password_popup_nonce'] ) && ! wp_verify_nonce( $_REQUEST['ghostpool_lost_password_popup_nonce'], 'ghostpool_lost_password_popup_action' ) ) {
		exit;
	} 
	
	// Determine whether URL uses ? or &
	function ghostpool_validate_url() {
		global $post;
		$page_url = esc_url( home_url( '/' ) );
		$urlget = strpos( $page_url, '?' );
		if ( $urlget === false ) {
			$concate = "?";
		} else {
			$concate = "&";
		}
		return $page_url . $concate;
	}

	$user_input = esc_sql( trim( $_POST['user_login'] ) );

	if ( strpos( $user_input, '@' ) ) {
		$user_data = get_user_by( 'email', $user_input );
		if ( empty( $user_data ) ) {
			echo "<div class='gp-error'>" . esc_html__( 'Invalid email address.', 'aardvark' ) . "</div>";
			exit;
		}
	} else {
		$user_data = get_user_by( 'login', $user_input );
		if ( empty( $user_data ) ) {
			echo "<div class='gp-error'>" . esc_html__( 'Invalid username.', 'aardvark' )."</div>";
			exit;
		}
	}

	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	// Generate reset key
	$key = $wpdb->get_var( $wpdb->prepare( "SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login ) );
	if ( empty( $key ) ) {
		$key = wp_generate_password( 20, false );
		$wpdb->update( $wpdb->users, array( 'user_activation_key' => $key ), array( 'user_login' => $user_login ) );	
	}

	// Send reset pasword email to the user
	$message = esc_html__( 'Someone requested that the password be reset for the following account:', 'aardvark' ) . "\r\n\r\n";
	$message .= get_option( 'siteurl' ) . "\r\n\r\n";
	$message .= sprintf( esc_html__( 'Username: %s', 'aardvark' ), $user_login ) . "\r\n\r\n";
	$message .= esc_html__( 'If this was a mistake, just ignore this email and nothing will happen.', 'aardvark' ) . "\r\n\r\n";
	$message .= esc_html__( 'To reset your password, visit the following address:', 'aardvark' ) . "\r\n\r\n";
	$message .= ghostpool_validate_url() . "action=reset_pwd&key=$key&login=" . rawurlencode( $user_login ) . "\r\n\r\n";
	$message .= esc_html__( 'You will receive another email with your new password.', 'aardvark' ) . "\r\n"; 
	$message = apply_filters( 'ghostpool_retrieve_password_message', $message, $key, $user_login, $user_data );

	// Email sent or not sent notice	
	if ( $message && function_exists( 'ghostpool_wp_mail' ) && ! ghostpool_wp_mail( $user_email, esc_html__( 'Password reset request', 'aardvark' ), $message ) ) {
		echo "<div class='gp-error'>" . esc_html__( 'Email failed to send for some unknown reason.', 'aardvark' ) . "</div>";
		exit;
	} else {
		echo "<div class='gp-success'>" . esc_html__( 'We have just sent you an email with instructions to reset your password.', 'aardvark' ) . "</div>";
		exit;
	}

}

/**
 * Redirect to success page when password has been changed 
 *
 */
if ( isset( $_GET['key'] ) && isset( $_GET['action'] ) && $_GET['action'] == 'reset_pwd' ) {

	$reset_key = $_GET['key'];
	$user_login = $_GET['login'];
	$user_data = $wpdb->get_row( $wpdb->prepare( "SELECT ID, user_login, user_email FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $reset_key, $user_login ) );

	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	if ( ! empty( $reset_key ) && ! empty( $user_data ) ) {
	
		$new_password = wp_generate_password( 7, false );
		wp_set_password( $new_password, $user_data->ID );
		$message = esc_html__( 'Your new password for the account at:', 'aardvark' ) . "\r\n\r\n";
		$message .= get_option( 'siteurl' ) . "\r\n\r\n";
		$message .= sprintf( esc_html__( 'Username: %s', 'aardvark' ), $user_login ) . "\r\n\r\n";
		$message .= sprintf( esc_html__( 'Password: %s', 'aardvark' ), $new_password ) . "\r\n\r\n";
	
		if ( $message && function_exists( 'ghostpool_wp_mail' ) && ! ghostpool_wp_mail( $user_email, esc_html__( 'Your new password', 'aardvark' ), $message ) ) {
			echo "<div class='gp-error'>" . esc_html__( 'Email failed to send for some unknown reason.', 'aardvark' ) . "</div>";
			exit;
		} else {
			$redirect_to = apply_filters( 'ghostpool_reset_success_redirect', home_url( '/' ) . '?action=reset_success' );
			wp_safe_redirect( $redirect_to );
			exit;
		}
		
	} else {
	
		exit( 'Not a valid key.' );
		
	}
	
}

/**
 * Add reset password success message to home page 
 *
 */
if ( isset( $_GET['action'] ) && $_GET['action'] == 'reset_success' ) {
	if ( ! function_exists( 'ghostpool_reset_password_success' ) ) {
		function ghostpool_reset_password_success() {
			echo '<div id="gp-reset-message"><p>' . esc_html__( "You will receive an email with your new password.", "aardvark" ) . '<span id="gp-close-reset-message"></span></p></div>';
		}
	}
	add_action( 'wp_footer', 'ghostpool_reset_password_success' );
}

?>