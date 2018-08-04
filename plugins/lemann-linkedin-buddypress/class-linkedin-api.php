<?php
/**
 * Classe que se conecta com a API do LinkedIn.
 *
 * @package Lemann
 */

defined( 'ABSPATH' ) || exit;

class LinkedIn_Api {

	private $client_key = '78z3c438k987wd';

	private $secret_key = '97AVZ7fM4vdi8BPr';

	public function __construct() {
		add_action( 'init', array( $this, 'add_rewrite_tag_n_rule' ) );
		add_action( 'wp', array( $this, 'handle_linkedin_callback' ) );
	}

	public function add_rewrite_tag_n_rule() {
		add_rewrite_tag( '%linkedin_callback%', '([^&]+)' );
		add_rewrite_rule(
			'^linkedin_callback/?',
			'index.php?linkedin_callback=1',
			'top'
		);
	}

	public function handle_linkedin_callback() {
		if ( get_query_var( 'linkedin_callback' ) ) {
			if ( isset( $_GET['state'] ) && wp_verify_nonce( $_GET['state'], 'linkedin-auth-request' ) ) {
				$user_id = get_current_user_id();

				if ( ! empty( $_GET['code'] ) ) {
					$response = wp_remote_post(
						'https://www.linkedin.com/oauth/v2/accessToken',
						[
							'headers' => [
								'Content-Type' => 'application/x-www-form-urlencoded',
							],
							'body'    => [
								'grant_type'    => 'authorization_code',
								'code'          => $_GET['code'],
								'redirect_uri'  => home_url( 'linkedin_callback' ),
								'client_id'     => $this->client_key,
								'client_secret' => $this->secret_key,
							],
						]
					);
					if ( is_wp_error( $response ) ) {
						$error_message = $response->get_error_message();
					} else {
						$response_body = json_decode( $response['body'] );

						if ( ! empty( $response_body->access_token ) ) {
							update_user_meta( $user_id, 'lemann_linkedin_bp_token', $response_body->access_token );
						}
					}
				}

				$redirect = get_user_meta( $user_id, 'lemann_linkedin_bp_redirect', true );
				if ( ! empty( $redirect ) ) {
					delete_user_meta( $user_id, 'lemann_linkedin_bp_redirect' );
				} else {
					$redirect = home_url( '/' );
				}
				wp_redirect( $redirect );
				exit;
			}
		}
	}

	public function get_auth_url() {
		$query_string = [
			'response_type' => 'code',
			'client_id'     => $this->client_key,
			'redirect_uri'  => home_url( 'linkedin_callback' ),
			'state'         => wp_create_nonce( 'linkedin-auth-request' ),
		];
		return 'https://www.linkedin.com/oauth/v2/authorization?' . http_build_query( $query_string );
	}

	public function get_field( $field ) {
		$user_id    = get_current_user_id();
		$auth_token = get_user_meta( $user_id, 'lemann_linkedin_bp_token', true );

		$response = wp_remote_get(
			'https://api.linkedin.com/v1/people/~:(' . $field . ')?format=json',
			[
				'headers' => [
					'Authorization' => 'Bearer ' . $auth_token,
				],
			]
		);

		if ( ! is_wp_error( $response ) ) {
			$field_data = json_decode( $response['body'], true );
			switch ( $field ) {
				case 'positions':
					$return    = '';
					$positions = $field_data['positions'];
					foreach ( $positions['values'] as $position ) {
						$return .= $position['title'] . ' em ' . $position['company']['name'] . '<br>';
						if ( ! empty( $position['summary'] ) ) {
							$return .= $position['summary'];
						}
					}
					break;

				default:
					$return = ( ! empty( $field_data ) ) ? $field_data : 'EMPTY_FIELD';
					break;
			}
			return $return;
		}
		return false;
	}
}
