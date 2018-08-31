<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Buddypress_Profile_Pro
 * @subpackage Buddypress_Profile_Pro/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Buddypress_Profile_Pro
 * @subpackage Buddypress_Profile_Pro/public
 * @author     wbcomdesigns <admin@wbcomdesigns.com>
 */
class Buddypress_Profile_Pro_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		global $wp_styles;
		$srcs = array_map( 'basename', (array) wp_list_pluck( $wp_styles->registered, 'src' ) );

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Buddypress_Profile_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Buddypress_Profile_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/buddypress-profile-pro-public.css', array(), '1.0.4', 'all' );
		wp_enqueue_style( 'jquery-ui-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), $this->version, 'all' );

		if ( in_array( 'font-awesome.css', $srcs ) || in_array( 'font-awesome.min.css', $srcs ) ) {
			/* echo 'font-awesome.css registered'; */
		} else {
			wp_enqueue_style( 'wbbpp-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array(), $this->version, 'all' );
		}

		wp_enqueue_style( 'resume-selectize-css', plugin_dir_url( __FILE__ ) . 'css/selectize.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Buddypress_Profile_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Buddypress_Profile_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$curr_url = $_SERVER['REQUEST_URI'];

		global $post;

		$contain_profile_shortcode = false;

		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'wbbpp_show_profile' ) ) {
			$contain_profile_shortcode = true;
		}

		if ( strpos( $curr_url, 'profile/extended-fields') || 
			strpos( $curr_url, 'admin/profile' ) || $contain_profile_shortcode ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/buddypress-profile-pro-public.js', array( 'jquery' ), '1.0.2', false );

		wp_enqueue_script( 'jquery-ui-datepicker' );

		if ( is_multisite() && is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
			$wbbpp_general_settings = get_site_option( 'wbbpp_general_settings' );
		} else {
			$wbbpp_general_settings = get_option( 'wbbpp_general_settings' );
		}

		if ( $wbbpp_general_settings ) {
			if ( isset( $wbbpp_general_settings['place_api'] ) && ! empty( $wbbpp_general_settings['place_api'] ) ) {
				$wbbpp_api_key = $wbbpp_general_settings['place_api'];
				wp_enqueue_script( $this->plugin_name . 'google-places-api', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=' . $wbbpp_api_key, array( 'jquery' ), $this->version, false );
			}
		}

		wp_enqueue_script( 'wbbpp_profile_selectize', plugin_dir_url( __FILE__ ) . 'js/selectize.min.js', array( 'jquery' ), '1.0.0', false );
	}
}

	/**
	 *
	 * Function to add extended profile menu tab at BuddyPress profile page.
	 */
	public function wbbpp_add_extended_profile_menu() {

		global $bp;
		if ( bp_is_my_profile() ) {
			bp_core_new_subnav_item( array(
				'name' => __( 'Extended Fields', 'buddypress-profile-pro' ),
				'slug' => 'extended-fields',
				'parent_url' => trailingslashit( bp_loggedin_user_domain() . 'profile' ),
				'parent_slug' => 'profile',
				'screen_function' => array( $this, 'wbbpp_show_add_extended_profile_screen' ),
				'position' => 20
			)
		);
		}
	}

	function wbbpp_show_add_extended_profile_screen() {
		add_action( 'bp_template_content', array( $this, 'wbbpp_add_extended_profile_screen_content' ) );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	function wbbpp_add_extended_profile_screen_content() {
		if ( $theme_template = locate_template( 'buddypress-profile-pro/wbbpp-add-profile.php' ) ) {
			include $theme_template;
		} else {
			include 'buddypress-template/wbbpp-add-profile.php';
		}
	}

	function bprm_show_saved_resume_screen() {
		add_action( 'bp_template_title', array( $this, 'bprm_saved_resume_show_title' ) );
		add_action( 'bp_template_content', array( $this, 'bprm_saved_resume_show_content' ) );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	function bprm_saved_resume_show_title() {
		_e( 'Resume', 'buddypress-profile-pro' );
	}

	function bprm_saved_resume_show_content() {
		if ( $theme_templates = locate_template( 'buddypress-profile-pro/wbbpp-show-profile.php' ) ) {
			include $theme_templates;
		} else {
			include 'buddypress-template/wbbpp-show-profile.php';
		}
	}

	public function wbbpp_show_profile_shortcode() {
		if ( $theme_templates = locate_template( 'buddypress-profile-pro/wbbpp-show-profile.php' ) ) {
			include $theme_templates;
		} else {
			include 'buddypress-template/wbbpp-show-profile.php';
		}
	}

	public function wbbpp_bp_profile_field_item(){
		if ( $theme_templates = locate_template( 'buddypress-profile-pro/wbbpp-profile-loop-userdata.php' ) ) {
			include $theme_templates;
		} else {
			include 'buddypress-template/wbbpp-profile-loop-userdata.php';
		}
		
	}

	/**
	 * Function to hide admin roles from members directory.
	 *
	 * @since    1.0.0
	 * @param    string   $qs Current query string.
	 * @param    string   $object Current template component.
	 * @return   string   $qs Current query string.
	 */
	public function wbbpp_alter_bp_ajax_query_search( $qs=false, $object=false ) {
		
		$args = wp_parse_args($qs);
		global $wbbpp;
		if ( $object != 'members' || empty( $args['search_terms'] ) ) {
			return $qs;
		}

		$core_users = bp_core_get_users();
		$include_users = array();
		if ( is_array( $core_users ) && !empty( $core_users['users'] ) ){
			foreach ( $core_users['users'] as $key => $user ) {
				
				$profile_pro_data = get_user_meta( $user->ID, 'wbbpp_userdata', true );
				
				if( is_array( $profile_pro_data ) ){

					$profile_json_data = json_encode( $profile_pro_data );
					$wbbpp = stripos( $profile_json_data , $args['search_terms'] );
					if (stripos( $profile_json_data , $args['search_terms'] ) !== FALSE) {
						$include_users[] = $user->ID;
					}
				}
			}
		}

  		$included_user = implode( ',', $include_users );
  		if( $included_user ){
  			unset($args['search_terms']);
  			if(!empty($args['include'])){
  				$args['include'] = $args['include'].','.$included_user;
  			}else{
  				$args['include'] = $included_user;
  			}
  		}
  		$qs = build_query($args);
	    return $qs;
	}

	/**
	 * Function to add fields visibility settings at buddypres profile  visibility settings.
	 *
	 * @since    1.0.0
	 */
	public function wbbpp_add_fields_visibility_settings() {

		$visib_mode = wbbpp_get_admin_fields_visibility_mode();

		if( !$visib_mode ){
			return;
		}

		$user_id = bp_displayed_user_id();
		
		$wbbpp_visibility = get_user_meta( $user_id, 'wbbpp_visibility', true );
		$wbbpp_profile_fields_settings = get_option( 'wbbpp_profile_fields_settings' );
		
		$grp_args = get_option( 'wbbpp_profile_groups_settings' );
		if ( ! empty( $wbbpp_profile_fields_settings ) ) {
			?><table class="profile-settings"><?php
			foreach ( $wbbpp_profile_fields_settings as $grp_key => $fields ) {

				if( isset($grp_args[ $grp_key ]['profile_display']) ){
					$grp_name = $grp_args[ $grp_key ]['g_name'];
					?>
					<thead>
						<tr>
							<th class="title field-group-name"><?php echo $grp_name; ?></th>
							<th class="title"><?php _e( 'Visibility', 'buddypress-profile-pro' ); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach ( $fields as $field_name => $field_detail ) {
						if ( isset( $field_detail['display'] ) ) {
							$visibility = ( isset( $wbbpp_visibility[$field_name] ) )?$wbbpp_visibility[$field_name]:'';
							?>
							<tr class="field_name">
								<td class="field-name"><?php echo $field_detail['field_tile']; ?></td>
								<td class="field-visibility">
									<select name="wbbpp_visibility[<?php echo $field_name ?>]">
									<?php foreach ( bp_xprofile_get_visibility_levels() as $level ) : ?>
											<option value="<?php echo esc_attr( $level['id'] ); ?>" <?php selected( $level['id'], $visibility ); ?>><?php echo esc_html( $level['label'] ); ?></option>
									<?php endforeach; ?>
									</select>
								</td>
							</tr>
							<?php
						}
					}
					?></tbody><?php
				}
			}
			?></table><?php
		}
	}

	/**
	 * Function to save fields visibility levels.
	 *
	 * @since    1.0.0
	 */
	public function wbbpp_save_fields_visibility() {

		$user_id = bp_displayed_user_id();
		
		if(isset($_POST['xprofile-settings-submit']) && isset($_POST['wbbpp_visibility']) ){
			$_wbbpp_visibility = $_POST['wbbpp_visibility'];
			update_user_meta( $user_id, 'wbbpp_visibility', $_wbbpp_visibility );
		}
	}
}
