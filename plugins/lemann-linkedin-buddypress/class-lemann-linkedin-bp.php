<?php
/**
 * Arquivo com a classe principal do plugin
 *
 * @package Lemann
 */

defined( 'ABSPATH' ) || exit;

/**
 * Classe principal do plugin
 */
class Lemann_Linkedin_Bp {
	/**
	 * A instância (única) da classe.
	 *
	 * @var object
	 */
	protected static $instance = null;

	private $linkedin_api = null;

	/**
	 * Construtor. Executado apenas uma vez (singleton).
	 */
	private function __construct() {
		require 'class-linkedin-api.php';
		$this->linkedin_api = new LinkedIn_Api();

		add_action( 'bp_custom_profile_edit_fields_pre_visibility', array( $this, 'add_linkedin_button' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_lemann_linkedin_bp', array( $this, 'ajax_handler' ) );
	}

	public function enqueue_scripts() {
		if ( bp_is_user_profile() ) {
			wp_enqueue_script( 'lemann-linkedin-bp', plugins_url( 'assets/js/scripts.js', LEMANN_LINKEDIN_BP_FILE ), [ 'jquery' ], null, true );
			wp_localize_script( 'lemann-linkedin-bp', 'lemann_linkedin_bp', [
				'ajax_url'   => admin_url( 'admin-ajax.php' ),
				'ajax_nonce' => wp_create_nonce( 'lemann-linkedin-bp' ),
			] );
		}
	}

	public function ajax_handler() {
		check_ajax_referer( 'lemann-linkedin-bp', 'nonce' );

		$user_id = get_current_user_id();

		$user_auth_token = get_user_meta( $user_id, 'lemann_linkedin_bp_token', true );

		if ( ! empty( $user_auth_token ) ) {
			$field = $this->linkedin_api->get_field( 'summary' );
			if ( $field ) {
				echo json_encode( [
					'status'  => 'success',
					'message' => $field,
				] );
				wp_die();
			}
		}

		update_user_meta( $user_id, 'lemann_linkedin_bp_redirect', $_POST['url'] );
		echo json_encode( [
			'status'  => 'need_auth',
			'message' => $this->linkedin_api->get_auth_url(),
		] );
		wp_die();
	}

	public function add_linkedin_button() {
		global $field;
		?>
		<button type="button" class="linkedin-bp__button">Importar do LinkedIn</button>
		<?php
	}

	/**
	 * SINGLETON. Retorna a instância da classe.
	 *
	 * @return object a instância (única) da classe.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}
