<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GhostPool_Importer {

	private static $instance;
	private static $pages_data = array();
	public $error = '';
	public $messages = array();
	public $session = '';
	public $data_imported = false;
	public $posts_imported = array();
	public $processes = 0;
	public $done_processes = 0;
	public $progress_pid = null;

	/**
	* Constructor
	*
	*/	
	function __construct() {

		add_action( 'admin_init', array( $this, 'do_import' ), 12 );

		$this->add_initial_demo_sets();

		add_action( 'admin_enqueue_scripts', array( $this, 'import_assets' ) );

		add_action( 'wp_ajax_ghostpool_single_import' , array( $this, 'do_ajax' ) );
		add_action( 'wp_ajax_ghostpool_set_as_home' , array( $this, 'set_as_homepage' ) );

		if ( isset( $_GET['ghostpool_single_import'] ) && $_GET['ghostpool_single_import'] ) {
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				add_filter( 'wp_redirect', function () {
					return false;
				});
			}
		}
				
	}

	function add_initial_demo_sets() {

		$image_path = get_template_directory_uri() . '/lib/framework/importer/images/';
			
		$pages_data = array();

		$pages_data['home-landing-page'] = array(
			'name'       => esc_html__( 'Land Page', 'aardvark' ),
			'slug'       => 'home-landing-page',
			'img'        => $image_path . 'demo-importer-landing-page.jpg',
			'page'       => 'landing-page/pages',
			'options'    => 'landing-page/options',
			'extra' => array(
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'landing-page/menus',
					'checked' => true,
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'primary-menu',
						'gp-main-header-secondary-nav' => 'secondary-menu',
						'gp-footer-nav' => 'primary-menu',
					),
				),
			),
			'layerslider' => 'landing-page/layerslider',
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
				'LayerSlider',
			),
			'link' => 'https://aardvark.ghostpool.com',
		);
		
		$pages_data['home-original'] = array(
			'name'       => esc_html__( 'Original', 'aardvark' ),
			'slug'       => 'home-original',
			'img'        => $image_path . 'demo-importer-original.jpg',
			'page'       => 'original/pages',
			'options'    => 'original/options',			
			'details' => esc_html__( 'Activate BuddyPress and WooCommerce BEFORE importing this demo so all the data is imported.', 'aardvark' ),
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'posts',
					'checked' => true,
				),
				array(
					'id' => 'products',
					'name' => esc_html__( 'Import Products', 'aardvark' ),
					'data' => 'original/products',
				),
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'original/menus',
					'checked' => true,
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'primary-menu',
						'gp-main-header-secondary-nav' => 'secondary-menu',
						'gp-profile-nav' => 'profile-menu',
						'gp-mobile-profile-nav' => 'profile-menu',
						'gp-footer-nav' => 'footer-menu',
					),
				),			
			),
			'buddypress' => true,
			'import_levels' => true,
			'widgets' => 'original/widgets',
			'widgets_sidebars' => 'original/sidebars',
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
				'wordpress-popular-posts',
				'paid-memberships-pro',
				'buddypress',
				'bbpress',
				'woocommerce',
			),
			'link' => 'https://aardvark.ghostpool.com/original',
		);

		$pages_data['home-dating'] = array(
			'name'       => esc_html__( 'Dating', 'aardvark' ),
			'slug'       => 'home-dating',
			'img'        => $image_path . 'demo-importer-dating.jpg',
			'page'       => 'dating/pages',
			'options'    => 'dating/options',
			'details' => esc_html__( 'Activate BuddyPress and BP Profile Search BEFORE importing this demo so all the data is imported.', 'aardvark' ),
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'posts',
					'checked' => false,
				),
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'dating/menus',
					'checked' => true,					
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'primary-menu',
						'gp-main-header-secondary-nav' => 'secondary-menu',
						'gp-profile-nav' => 'profile-menu',
						'gp-mobile-profile-nav' => 'profile-menu',
						'gp-footer-nav' => 'footer-menu',
					),
				),
			),
			'buddypress' => true,
			'widgets' => 'dating/widgets',
			'bp_fields' => array(	
				array(
					'field_group_id' => '1',
					'name' => 'I Am',
					'desc' => '',
					'can_delete' => 1,
					'is_required' => false,
					'type' => 'selectbox',
					'mode' => '',
					'options' => array(
						'A woman',
						'A man',
					),
				),
				array(
					'field_group_id' => '1',
					'name' => 'Seeking',
					'desc' => '',
					'can_delete' => 1,
					'is_required' => false,
					'type' => 'selectbox',
					'mode' => '',
					'options' => array(
						'A man',
						'A woman',
					),
				),
				array(
					'field_group_id' => '1',
					'name' => 'Age',
					'desc' => '',
					'can_delete' => 1,
					'is_required' => true,
					'type' => 'datebox',
					'mode' => 'age_range',
					'value' => '',
				),
				array(
					'field_group_id' => '1',
					'name' => 'Looking For',
					'desc' => '',
					'can_delete' => 1,
					'is_required' => true,
					'type' => 'selectbox',
					'mode' => '',
					'options' => array(
						'Relationship',
						'Friendship',
						'Fun',
					),
				),
			),
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
				'buddypress',
				'bbpress',
				'bp-profile-search',
				'buddypress-xprofile-custom-fields-type',
			),
			'link' => 'https://aardvark.ghostpool.com/dating',
		);

		$pages_data['home-hosting'] = array(
			'name'       => esc_html__( 'Hosting', 'aardvark' ),
			'slug'       => 'home-hosting',
			'img'        => $image_path . 'demo-importer-hosting.jpg',
			'page'       => 'hosting/pages',
			'options'    => 'hosting/options',
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'posts',
					'checked' => false,
				),
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'hosting/menus',
					'checked' => true,					
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'primary-menu',
						'gp-top-header-left-nav' => 'top-header-left-menu',
						'gp-top-header-right-nav' => 'top-header-right-menu',
						'gp-footer-nav' => 'footer-menu',
					),
				),
			),
			'widgets' => 'hosting/widgets',
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
			),
			'link' => 'https://aardvark.ghostpool.com/hosting',
		);

		$pages_data['home-members-directory'] = array(
			'name'       => esc_html__( 'Members Directory', 'aardvark' ),
			'slug'       => 'home-members-directory',
			'img'        => $image_path . 'demo-importer-members-directory.jpg',
			'page'       => 'members-directory/pages',
			'options'    => 'members-directory/options',
			'details' => esc_html__( 'Activate BuddyPress and BP Profile Search BEFORE importing this demo so all the data is imported.', 'aardvark' ),
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'posts',
					'checked' => false,
				),
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'members-directory/menus',					
					'locations' => array(
						'gp-profile-nav' => 'profile-menu',
						'gp-mobile-profile-nav' => 'profile-menu',
						'gp-footer-nav' => 'footer-menu',
					),
					'checked' => true,
				),
			),
			'buddypress' => true,
			'widgets' => 'members-directory/widgets',
			'bp_fields' => array(	
				array(
					'field_group_id' => '1',
					'name' => 'Skills',
					'desc' => '',
					'can_delete' => 1,
					'is_required' => false,
					'type' => 'selectbox',
					'mode' => '',
					'options' => array(
						'Graphic Design',
						'JavaScript',
						'PHP',
						'SEO',
					),
				),
				array(
					'field_group_id' => '1',
					'name' => 'Country',
					'desc' => '',
					'can_delete' => 1,
					'is_required' => false,
					'type' => 'selectbox',
					'mode' => '',
					'options' => array(
						'Australia',
						'Canada',
						'France',
						'Germany',
						'India',
						'Spain',
						'UK',
						'USA',
					),
				),
				array(
					'field_group_id' => '1',
					'name' => 'Price Rate',
					'desc' => 'Price per hour ($)',
					'can_delete' => 1,
					'is_required' => true,
					'type' => 'textbox',
					'mode' => 'age_range',
					'value' => '',
				),
			),
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
				'buddypress',
				'bp-profile-search',
				'buddypress-xprofile-custom-fields-type',
			),
			'link' => 'https://aardvark.ghostpool.com/members-directory',
		);

		$pages_data['home-courses'] = array(
			'name'       => esc_html__( 'Courses', 'aardvark' ),
			'slug'       => 'home-courses',
			'img'        => $image_path . 'demo-importer-courses.jpg',
			'page'       => 'courses/pages',
			'options'    => 'courses/options',
			'details' => esc_html__( 'Purchase and activate Sensei, WooCommerce and BuddyPress BEFORE importing this demo so all the data is imported.', 'aardvark' ),
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'posts',
					'checked' => false,
				),
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'courses/menus',
					'checked' => true,					
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'primary-menu',
						'gp-main-header-secondary-nav' => 'secondary-menu',
						'gp-profile-nav' => 'profile-menu',
						'gp-mobile-profile-nav' => 'profile-menu',
						'gp-footer-nav' => 'footer-menu',
					),
				),								
				array(
					'id' => 'sensei',
					'name' => esc_html__( 'Import Sensei Data', 'aardvark' ),
					'data' => 'sensei',
					'checked' => true,
				),				
			),
			'buddypress' => true,
			'widgets' => 'courses/widgets',
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
				'buddypress',
				'woocommerce',
			),
			'link' => 'https://aardvark.ghostpool.com/courses',
		);

		$pages_data['home-community'] = array(
			'name'       => esc_html__( 'Community', 'aardvark' ),
			'slug'       => 'home-community',
			'img'        => $image_path . 'demo-importer-community.jpg',
			'page'       => 'community/pages',
			'options'    => 'community/options',			
			'details' => esc_html__( 'Activate BuddyPress BEFORE importing this demo so all the data is imported.', 'aardvark' ),
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'community/posts',
					'checked' => true,
				),
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'community/menus',
					'checked' => true,					
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'primary-menu',
						'gp-main-header-secondary-nav' => 'secondary-menu',
						'gp-profile-nav' => 'profile-menu',
						'gp-mobile-profile-nav' => 'profile-menu',
						'gp-footer-nav' => 'footer-menu',
					),
				),				
			),
			'buddypress' => true,
			'widgets' => 'community/widgets',
			'widgets_sidebars' => 'community/sidebars',
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
				'buddypress',
				'bbpress',
				'buddypress-media',
			),
			'link' => 'https://aardvark.ghostpool.com/community',
		);

		$pages_data['home-full-page'] = array(
			'name'       => esc_html__( 'Full Page', 'aardvark' ),
			'slug'       => 'home-full-page',
			'img'        => $image_path . 'demo-importer-full-page.jpg',
			'page'       => 'full-page/pages',
			'options'    => 'full-page/options',
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'posts',
					'checked' => false,
				),
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'full-page/menus',
					'checked' => true,					
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'primary-menu',
						'gp-footer-nav' => 'footer-menu',
					),
				),				
			),
			'widgets' => 'full-page/widgets',
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
			),
			'link' => 'https://aardvark.ghostpool.com/full-page',
		);

		$pages_data['home-news'] = array(
			'name'       => esc_html__( 'News', 'aardvark' ),
			'slug'       => 'home-news',
			'img'        => $image_path . 'demo-importer-news.jpg',
			'page'       => 'news/pages',
			'options'    => 'news/options',
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'news/posts',
					'checked' => true,
				),
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'news/menus',
					'checked' => true,
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'primary-menu',
						'gp-main-header-secondary-nav' => 'secondary-menu',
						'gp-footer-nav' => 'footer-menu',
					),
				),				
			),
			'widgets' => 'news/widgets',
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
			),
			'link' => 'https://aardvark.ghostpool.com/news',
		);

		$pages_data['home-video-full-page'] = array(
			'name'       => esc_html__( 'Video Full Page', 'aardvark' ),
			'slug'       => 'home-video-full-page',
			'img'        => $image_path . 'demo-importer-video-full-page.jpg',
			'page'       => 'video-full-page/pages',
			'options'    => 'video-full-page/options',			
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'posts',
					'checked' => false,
				),
			),	
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
			),
			'link' => 'https://aardvark.ghostpool.com/video-full-page',
		);

		$pages_data['home-store'] = array(
			'name'       => esc_html__( 'Store', 'aardvark' ),
			'slug'       => 'home-store',
			'img'        => $image_path . 'demo-importer-store.jpg',
			'page'       => 'store/pages',
			'options'    => 'store/options',
			'details' => esc_html__( 'Activate WooCommerce BEFORE importing this demo so all the data is imported.', 'aardvark' ),
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'posts',
					'checked' => false,
				),	
				array(
					'id' => 'products',
					'name' => esc_html__( 'Import Products', 'aardvark' ),
					'data' => 'store/products',
					'checked' => true,
				),	
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'store/menus',
					'checked' => true,
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'primary-menu',
						'gp-main-header-secondary-nav' => 'secondary-menu',
						'gp-top-header-left-nav' => 'top-header-left-menu',
						'gp-top-header-right-nav' => 'top-header-right-menu',
						'gp-footer-nav' => 'footer-menu',
					),
				),				
			),
			'layerslider' => 'store/layerslider',
			'widgets' => 'store/widgets',
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
				'woocommerce',
				'LayerSlider',
			),
			'link' => 'https://aardvark.ghostpool.com/store',
		);

		$pages_data['home-social'] = array(
			'name'       => esc_html__( 'Social', 'aardvark' ),
			'slug'       => 'home-social',
			'img'        => $image_path . 'demo-importer-social.jpg',
			'page'       => 'social/pages',
			'options'    => 'social/options',			
			'details' => esc_html__( 'Activate BuddyPress BEFORE importing this demo so all the data is imported.', 'aardvark' ),
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'posts',
					'checked' => false,
				),
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'social/menus',
					'checked' => true,					
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'primary-menu',
						'gp-main-header-secondary-nav' => 'secondary-menu',
						'gp-top-header-left-nav' => 'top-header-left-menu',
						'gp-top-header-right-nav' => 'top-header-right-menu',
						'gp-profile-nav' => 'profile-menu',
						'gp-mobile-profile-nav' => 'profile-menu',
						'gp-footer-nav' => 'primary-menu',
					),
				),				
			),
			'buddypress' => true,
			'layerslider' => 'social/layerslider',
			'widgets' => 'social/widgets',
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
				'buddypress',
				'bbpress',
				'buddypress-media',
				'LayerSlider',
			),
			'link' => 'https://aardvark.ghostpool.com/social',
		);

		$pages_data['home-network'] = array(
			'name'       => esc_html__( 'Network', 'aardvark' ),
			'slug'       => 'home-network',
			'img'        => $image_path . 'demo-importer-network.jpg',
			'page'       => 'network/pages',
			'options'    => 'network/options',			
			'details' => esc_html__( 'Activate BuddyPress and Events Manager BEFORE importing this demo so all the data is imported.', 'aardvark' ),
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'posts',
					'checked' => false,
				),
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'network/menus',
					'checked' => true,					
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'primary-menu',
						'gp-profile-nav' => 'profile-menu',
						'gp-mobile-profile-nav' => 'profile-menu',
						'gp-footer-nav' => 'primary-menu',
						'gp-side-menu-nav' => 'side-menu',
					),
				),				
			),
			'buddypress' => true,
			'widgets' => 'network/widgets',
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
				'buddypress',
				'bbpress',
				'buddypress-media',
				'events-manager',
			),
			'link' => 'https://aardvark.ghostpool.com/network',
		);

		$pages_data['home-elearn'] = array(
			'name'       => esc_html__( 'eLearn', 'aardvark' ),
			'slug'       => 'home-elearn',
			'img'        => $image_path . 'demo-importer-elearn.jpg',
			'page'       => 'elearn/pages',
			'options'    => 'elearn/options',
			'details' => esc_html__( 'Purchase and activate Sensei, WooCommerce and BuddyPress BEFORE importing this demo so all the data is imported.', 'aardvark' ),
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'posts',
					'checked' => false,
				),
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'elearn/menus',
					'checked' => true,					
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'mobile-menu',
						'gp-top-header-left-nav' => 'top-header-left-menu',
						'gp-top-header-right-nav' => 'top-header-right-menu',
					),
				),
				array(
					'id' => 'sensei',
					'name' => esc_html__( 'Import Sensei Data', 'aardvark' ),
					'data' => 'sensei',
					'checked' => true,
				),		
			),
			'buddypress' => true,
			'widgets' => 'elearn/widgets',
			'layerslider' => 'elearn/layerslider',
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
				'buddypress',
				'woocommerce',
			),
			'link' => 'https://aardvark.ghostpool.com/elearn',
		);

		$pages_data['home-trial'] = array(
			'name'       => esc_html__( 'Trial', 'aardvark' ),
			'slug'       => 'home-trial',
			'img'        => $image_path . 'demo-importer-trial.jpg',
			'page'       => 'trial/pages',
			'options'    => 'trial/options',
			'details' => esc_html__( 'Activate BuddyPress BEFORE importing this demo so all the data is imported.', 'aardvark' ),
			'extra' => array(
				array(
					'id' => 'posts',
					'name' => esc_html__( 'Import Posts', 'aardvark' ),
					'data' => 'trial/posts',
					'checked' => true,
				),
				array(
					'id' => 'menus',
					'name' => esc_html__( 'Import Menus', 'aardvark' ),
					'data' => 'trial/menus',
					'checked' => true,					
					'locations' => array(
						'gp-main-header-primary-nav' => 'primary-menu',
						'gp-mobile-primary-nav' => 'mobile-menu',
					),
				),	
			),
			'buddypress' => true,
			'import_levels' => true,
			'widgets' => 'trial/widgets',
			'plugins'    => array( 
				'aardvark-plugin',
				'js_composer',
				'vc_responsive_design',
				'paid-memberships-pro',
				'pmpro-buddypress',
				'buddypress',
			),
			'link' => 'https://aardvark.ghostpool.com/trial',
		);
																										
		self::add_demo_sets( $pages_data );
	}

	/**
	* Add multiple demo sets
	*
	*/
	static function add_demo_sets( $data ) {
		self::$pages_data = self::$pages_data + $data;
	}
	
	public static function getInstance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	* Add a demo set
	*	
	*/
	static function add_demo_set( $slug, $data ) {
		self::$pages_data[ $slug ] = $data;
	}

	/**
	* Enqueue style and scripts
	*
	*/
	public function import_assets() {
		if ( isset( $_GET['page'] ) && 'aardvark-setup' == $_GET['page'] ) {
			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_style( 'ghostpool-importer-css', get_template_directory_uri() . '/lib/framework/importer/assets/importer.css', array(), AARDVARK_THEME_VERSION );
			wp_enqueue_script( 'ghostpool-importer-js', get_template_directory_uri() . '/lib/framework/importer/assets/importer.js', array( 'jquery', 'jquery-ui-tooltip' ), AARDVARK_THEME_VERSION, true );
		}
	}

	/**
	* Set as homepage
	*
	*/	
	public function set_as_homepage() {
		
		if ( session_id() ) {
			session_write_close();
		}
		
		check_ajax_referer( 'import_nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array(
				'message' => esc_html__( 'We&apos;re sorry, something went wrong.', 'aardvark' ),
			) );
			exit;
		}

		if ( isset( $_POST['pid'] ) ) {
			$post_id = $_POST['pid'];
			if ( get_post_status( $post_id ) == 'publish' ) {
				if ( 'page' == get_post_type( $post_id ) ) {
					update_option( 'page_on_front', $post_id );
					update_option( 'show_on_front', 'page' );
					wp_send_json_success( array(
						'message' => esc_html__( 'Successfully set as homepage.', 'aardvark' ),
					) );
					exit;
				}
			}
		}
		wp_send_json_success( array(
			'message' => esc_html__( 'An error occurred setting this page as your homepage.', 'aardvark' ),
		) );
		exit;

	}

	/**
	* Ajax
	*
	*/
	function do_ajax() {
		if ( session_id() ) {
			session_write_close();
		}

		check_ajax_referer( 'import_nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array(
				'message' => $this->set_error_message( esc_html__( 'We&apos;re sorry, the demo failed to import.', 'aardvark' ) ),
			) );
			exit;
		}

		if ( ! isset( $_POST['options'] ) ) {
			wp_send_json_error( array(
				'message' => $this->set_error_message( esc_html__( 'Something went wrong. Please try again.', 'aardvark' ) ),
			) );
			exit;
		}

		$data = array();

		parse_str( $_POST['options'], $data );

		if ( ! isset( $data['import_demo'] ) ) {
			wp_send_json_error( array(
				'message' => $this->set_error_message( esc_html__( 'Something went wrong with the data sent. Please try again.', 'aardvark' ) ),
			) );
			exit;
		}

		$demo_sets   = self::get_demo_sets();
		$current_set = $data['import_demo'];

		if ( ! array_key_exists( $current_set, $demo_sets ) ) {
			wp_send_json_error( array(
				'message' => $this->set_error_message( esc_html__( 'Something went wrong with the data sent. Please try again.', 'aardvark' ) ),
			) );
			exit;
		}

		$set_data = $demo_sets[ $current_set ];
		$progress_pid = intval( $_POST['pid'] );

		/* If we are checking progress */
		if ( isset( $_POST['check_progress'] ) ) {
			$progress = $this->get_progress( $progress_pid );
			if ( $progress ) {
				wp_send_json_success( array(
					'message' => $progress['text'],
					'progress' => $progress['progress'],
				) );
			}
			exit;
		}

		$response = $this->process_import( array(
			'set_data' => $set_data,
			'pid' => $progress_pid,
			'data' => $data,
		) );

		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array(
				'message' => $this->set_error_message(
					esc_html__( 'There was an error in the import process. Try importing again.', 'aardvark' ) .
					'<br>' . $response->get_error_message()
				),
				'debug'   => implode( ',', $this->messages ),
			) );
			exit;
		}

		$response['debug'] = implode( ',', $this->messages );
		$response['message'] = $this->set_success_message( $response['message'] );

		wp_send_json_success( $response );

	}

	private function set_error_message( $msg ) {
		return $msg;
	}

	/**
	* Retrieve the demo sets
	*	
	*/
	static function get_demo_sets() {
		return self::$pages_data;
	}

	public function get_progress( $pid ) {
		$data = get_transient( 'ghostpool_import_' . floatval( $pid ) );
		return $data;
	}
	
	/**
	* Process all the import steps
	*
	* @param array $options
	*
	* @return array|WP_Error
	*/
	public function process_import( $options ) {

		$imported = false;
		$content_imported = false;

		$set_data = $options['set_data'];
		$progress_pid = $options['pid'];
		$this->progress_pid = $progress_pid;
		$data = $options['data'];

		// Importer classes
		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true );
		}

		if ( ! class_exists( 'WP_Importer' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		}

		if ( ! class_exists( 'WP_Import' ) ) {
			require_once get_template_directory() . '/lib/framework/importer/wordpress-importer.php';
		}

		if ( ! class_exists( 'WP_Importer' ) || ! class_exists( 'WP_Import' ) ) {
			return new WP_Error( '__k__',  esc_html__( 'Something went wrong. Please try again.', 'aardvark' ) );
		}

		$this->processes = count( $data ) + 1;
		$this->done_processes = 0;

		// Activate required plugins
		if ( isset( $data['activate_plugins'] ) ) {
		
			$this->processes += count( $set_data['plugins'] ) - 1;

			$this->set_progress( $progress_pid, array(
				'text'     => esc_html__( 'Activating any required plugins...', 'aardvark' ),
				'plugins' =>  isset( $set_data['plugins'] ) && ! empty( $set_data['plugins'] ) ? $set_data['plugins'] : array(),
			) );

			$this->activate_plugins( $set_data );
			$this->done_processes ++;
		}

		// Post type requirements
		$this->set_progress( $progress_pid, array(
			'text' => esc_html__( 'Performing extra import checks...', 'aardvark' ),
		) );
		//$this->post_type_check( $set_data );
		$this->done_processes ++;

		// Import pages xml
		if ( isset( $data['import_page'] ) && isset( $set_data['page'] ) ) {

			$this->set_progress( $progress_pid, array(
				'text' => esc_html__( 'Importing Pages...', 'aardvark' ),
			) );

			$imported = true;
			$content_imported = true;

			if ( is_array( $data['import_page'] ) ) {
				$the_page = $data['import_page'][0];
			} else {
				$the_page = $data['import_page'];
			}
			$the_page = ucwords( str_replace( array( '-', '_' ), ' ', $the_page ) );

			$file_path = $set_data['page'] . '.xml';
			$this->import_content( $file_path, true );
			
			$this->save_main_imported_pages();
			
			$this->messages[] = sprintf( esc_html__( 'Installed page: %s', 'aardvark' ), $the_page );
			$this->done_processes ++;
		}

		// Import widgets
		if ( isset( $data['import_widgets'] ) && isset( $set_data['widgets'] ) ) {

			$imported = true;
			
			$this->set_progress( $progress_pid, array(
				'text' => esc_html__( 'Importing Widgets...', 'aardvark' ),
			) );

			$widget_path = $set_data['widgets'];

			// Import sidebars
			if ( isset( $set_data['widgets_sidebars'] ) && $set_data['widgets_sidebars'] ) {
				$sidebar_path = $set_data['widgets_sidebars'];
				$file_path = get_template_directory() . '/lib/framework/importer/demo-files/' . $sidebar_path . '.txt';
				if ( file_exists( $file_path ) ) {
					$this->import_sidebars( get_template_directory_uri() . '/lib/framework/importer/demo-files/' . $sidebar_path . '.txt' );
				}			
			}

			// Import widgets
			$file_path = get_template_directory() . '/lib/framework/importer/demo-files/' . $widget_path . '.txt';
			if ( file_exists( $file_path ) ) {
				$file_data = ghostpool_fs_get_contents( $file_path );
				if ( $file_data ) {
					$this->import_widget_data( $file_data );
					$this->messages[] = esc_html__( 'Imported Widgets!', 'aardvark' );
				}
			}
			$this->done_processes ++;
		}

		// Check options
		if ( isset( $data['import_options'] ) && isset( $set_data['options'] ) ) {

			$imported = true;

			$this->set_progress( $progress_pid, array(
				'text' => esc_html__( 'Importing Theme Options...', 'aardvark' ),
			) );

			$this->import_options( $set_data['options'] );

			$this->messages[] = esc_html__( 'Imported Theme Options!', 'aardvark' );
			$this->done_processes ++;
		}

		// Check LayerSlider
		if ( isset( $data['import_layerslider'] ) && isset( $set_data['layerslider'] ) ) {

			$imported = true;

			$this->set_progress( $progress_pid, array(
				'text' => esc_html__( 'Importing LayerSlider...', 'aardvark' ),
			) );
			
			$sliders = (array) $set_data['layerslider'];
			if ( ! empty( $sliders ) ) {
				foreach ( $sliders as $slider ) {					
					$file = get_template_directory() . '/lib/framework/importer/demo-files/' . $slider . '.zip';
					$this->import_layerslider( $file );
					$this->messages[] = esc_html__( 'Imported LayerSliders!', 'aardvark' );
				}
			}
			$this->done_processes ++;
		}

		// Check BuddyPress data
		if ( isset( $data['import_buddypress'] ) && isset( $set_data['buddypress'] ) ) {

			if ( ! function_exists( 'bp_is_active' ) ) {
				return;
			}
		
			$imported = true;

			$this->set_progress( $progress_pid, array(
				'text' => esc_html__( 'Importing BuddyPress Data...', 'aardvark' ),
			) );
			
			$this->import_buddypress_data();
			
			$this->messages[] = esc_html__( 'Imported BuddyPress Data!', 'aardvark' );
			$this->done_processes ++;
		}

		// Check BuddyPress profile fields
		if ( isset( $data['import_bp_fields'] ) && isset( $set_data['bp_fields'] ) ) {

			if ( ! function_exists( 'bp_is_active' ) || ! bp_is_active( 'xprofile' ) ) {
				return;
			}
			
			$imported = true;

			$this->set_progress( $progress_pid, array(
				'text' => esc_html__( 'Importing BuddyPress Profile Fields...', 'aardvark' ),
			) );

			$this->import_bp_fields( $set_data['bp_fields'] );
			$this->messages[] = esc_html__( 'Imported BuddyPress Profile Fields!', 'aardvark' );
			$this->done_processes ++;
		}

		// Check membership levels
		if ( isset( $data['import_levels'] ) && isset( $set_data['import_levels'] ) ) {

			if ( ! defined( 'PMPRO_VERSION' ) ) {
				return;
			}
		
			$imported = true;

			$this->set_progress( $progress_pid, array(
				'text' => esc_html__( 'Importing Membership Levels...', 'aardvark' ),
			) );
			
			$this->import_pmp_membership_levels();
			
			$this->messages[] = esc_html__( 'Imported Membership Levels!', 'aardvark' );
			$this->done_processes ++;
		}
							
		// Check extras
		if ( isset( $set_data['extra'] ) && is_array( $set_data['extra'] ) ) {

			foreach ( $set_data['extra'] as $extra ) {
				
				if ( ! isset( $data[ 'import_' . $extra['id'] ] ) || ! isset( $extra['id'] ) ) {
					continue;
				}
				
				$imported = true;
				
				if ( 'menus' != $extra['id'] ) {
					$content_imported = true;
				}
				
				$this->set_progress( $progress_pid, array(
					'text' => esc_html__( 'Importing', 'aardvark' ) . ' ' . ucfirst( $extra['id'] ) . '...',
				) );

				$ok_to_import = true;

				if ( $ok_to_import ) {
					$file_path = $extra['data'] . '.xml';
					$this->import_content( $file_path, true );
					$this->messages[] = sprintf( esc_html__( '%s complete', 'aardvark' ), $extra['name'] );
				}
				
				if ( 'menus' == $extra['id'] ) {
					$this->import_menu_location( $extra['locations'] );
				}
								
				$this->done_processes ++;
			}
		}

		// Import content
		if ( $content_imported ) {
			$this->processes ++;
			$this->post_process_posts( $set_data );
			$this->done_processes ++;
		}

		$success_message = '<h4 class="gp-import-success">' . esc_html__( 'Your import was successful!', 'aardvark' ) . '</h4>';

		$posts_summary = '';
		if ( ! empty( $this->posts_imported ) ) {
			$this->posts_imported = array_reverse( $this->posts_imported, true );
			foreach ( $this->posts_imported as $pid => $item ) {
				
				$posts_summary .= '<p>' . get_the_title( $pid ) . '</p>';
				
				$posts_summary .= '<a href="#" class="gp-set-as-home button button-primary" title="' . esc_html__( 'Set as Homepage', 'aardvark' ) . '" data-pid="' . $pid . '">' . esc_html__( 'Set as Homepage', 'aardvark' ) . '</a>';
				
				$posts_summary .= '<a href="' . get_permalink( $pid ) . '" class="button" title="' . esc_html__( 'View Page', 'aardvark' ) . ' "target="_blank">' . esc_html__( 'View Page', 'aardvark' ) . '</a>';
				
				$posts_summary .= '<a href="' . get_admin_url( null, 'post.php?post=' . $pid . '&action=edit' ) . '" class="button" title="' . esc_html__( 'Edit Page', 'aardvark' ) . '" target="_blank">' . esc_html__( 'Edit Page', 'aardvark' ) . '</a>';
				
			}
		} else {
			if ( isset( $data['import_page'] ) ) {
				$success_message = esc_html__( 'This demo page already exists. Please check the trash!', 'aardvark' );
			}
		}

		if ( $posts_summary ) {
			$success_message .= '<div class="gp-import-summary">' . $posts_summary . '</div>';
		}

		if ( ! $imported ) {
			$this->error .= esc_html__( 'You have not selected any content to be imported.', 'aardvark' );
		}

		//sleep( 30 ); exit( 'I slept a bit. Sorry master!!!' );

		if ( '' == $this->error ) {
			return  array(
				'message' => $success_message,
			);
		} else {
			return new WP_Error( '__k__', $this->error );
		}
	}

	/**
	* Show progress
	*
	*/
	public function set_progress( $pid, $data ) {
		if ( $pid ) {
			if ( ! isset( $data['progress'] ) ) {
				if ( 0 == $this->done_processes ) {
					$data['progress'] = 1;
				} else {
					$data['progress'] = floor( $this->done_processes / $this->processes * 100 );
				}
			}
			set_transient( 'ghostpool_import_' . floatval( $pid ), $data, 60 * 60 );
		}
	}
	
	/**
	* Activate plugins
	*
	*/	
	public function activate_plugins( $set_data ) {
		if ( isset( $set_data['plugins'] ) && ! empty( $set_data['plugins'] ) ) {
			foreach ( $set_data['plugins'] as $plugin ) {
				if ( ! class_exists( 'GhostPool_Addons_Manager' ) ) {
					require_once( get_template_directory() . '/lib/framework/theme-setup/theme-addons.php' );
				}
				$msg = '';
				$plugin_nice_name = ucfirst( str_replace( array( '_','-' ), ' ', $plugin ) );

				$this->set_progress( $this->progress_pid, array(
					'text' => sprintf( esc_html__( 'Installing plugin: %s', 'aardvark' ), $plugin_nice_name ),
					'plugins' => $set_data['plugins'],
				) );

				if ( ! GhostPool_Addons_Manager()->is_plugin_installed( $plugin ) ) {
					$install = GhostPool_Addons_Manager()->do_plugin_install( $plugin, false );
					if ( isset( $install['error'] ) ) {
						$this->error .= '<br>' . $plugin_nice_name . ': ' . $install['error'];
					}
					$msg = sprintf( esc_html__( 'Installed plugin %s', 'aardvark' ), $plugin_nice_name );
					$this->messages[] = $msg;
				}

				if ( ! GhostPool_Addons_Manager()->is_plugin_active( $plugin ) ) {
					$activate = GhostPool_Addons_Manager()->do_plugin_activate( $plugin, false );
					if ( isset( $activate['error'] ) ) {
						$this->error .= '<br>' . $plugin_nice_name . ': ' .  $activate['error'];
					}
					$msg = sprintf( esc_html__( 'Activated plugin %s', 'aardvark' ), $plugin_nice_name );
					$this->messages[] = $msg;
				}
				
				if ( $msg ) {
					$this->set_progress( $this->progress_pid, array(
						'text' => $msg,
						'plugins' => $set_data['plugins'],
					) );
				}
				
				// Update permalink structure if set to plain
				if ( ! get_option( 'permalink_structure' ) ) {
					update_option( 'permalink_structure', '/%category%/%postname%/' );
				}
	
				$this->done_processes ++;
				
			}
		}
	}

	/**
	* Import content
	*
	*/
	function import_content( $file = '', $force_attachments = false ) {
		$import = new WP_Import();
		$xml    = get_template_directory() . '/lib/framework/importer/demo-files/' . $file;
		//print_r($xml);

		if ( true == $force_attachments ) {
			$import->fetch_attachments = true;
		} else {
			$import->fetch_attachments = ( $_POST && array_key_exists( 'attachments', $_POST ) && $_POST['attachments'] ) ? true : false;
		}

		ob_start();
		$import->import( $xml );
		ob_end_clean();
	}

	/**
	* Import sidebars
	*
	*/	
	 function import_sidebars( $path ) {
		$sidebars_file_data = wp_remote_get( $path );
		if ( ! is_wp_error( $sidebars_file_data ) ) {
			$sidebars_data = unserialize( wp_remote_retrieve_body( $sidebars_file_data ) );
			$old_sidebars  = get_option( 'ghostpool_sidebars' );
			if ( ! empty( $old_sidebars ) ) {
				$sidebars_data = array_merge( $sidebars_data, $old_sidebars );
			}
			update_option( 'ghostpool_sidebars', $sidebars_data );
		}
	}

	/**
	* Parse JSON import file
	* @param $json_data
	* http://wordpress.org/plugins/widget-settings-importexport/
	*/
	function import_widget_data( $json_data ) {

		$json_data    = json_decode( $json_data, true );
		$sidebar_data = $json_data[0];
		$widget_data  = $json_data[1];

		// Prepare widgets table
		$widgets = array();
		foreach ( $widget_data as $k_w => $widget_type ) {
			if ( $k_w ) {
				$widgets[ $k_w ] = array();
				foreach ( $widget_type as $k_wt => $widget ) {
					if ( is_int( $k_wt ) ) {
						$widgets[ $k_w ][ $k_wt ] = 1;
					}
				}
			}
		}

		// Sidebars
		foreach ( $sidebar_data as $title => $sidebar ) {
			$count = count( $sidebar );
			for ( $i = 0; $i < $count; $i ++ ) {
				$widget               = array();
				$widget['type']       = trim( substr( $sidebar[ $i ], 0, strrpos( $sidebar[ $i ], '-' ) ) );
				$widget['type-index'] = trim( substr( $sidebar[ $i ], strrpos( $sidebar[ $i ], '-' ) + 1 ) );
				if ( ! isset( $widgets[ $widget['type'] ][ $widget['type-index'] ] ) ) {
					unset( $sidebar_data[ $title ][ $i ] );
				}
			}
			$sidebar_data[ $title ] = array_values( $sidebar_data[ $title ] );
		}

		// Widgets
		foreach ( $widgets as $widget_title => $widget_value ) {
			foreach ( $widget_value as $widget_key => $widget_value ) {
				$widgets[ $widget_title ][ $widget_key ] = $widget_data[ $widget_title ][ $widget_key ];
			}
		}

		$sidebar_data = array( array_filter( $sidebar_data ), $widgets );
		$this->parse_import_data( $sidebar_data );
	}

	/**
	* Import Widgets
	* @param $json_data
	* http://wordpress.org/plugins/widget-settings-importexport/
	*/
	function parse_import_data( $import_array ) {
		$sidebars_data = $import_array[0];
		$widget_data   = $import_array[1];

		$current_sidebars = get_option( 'sidebars_widgets' );
		$new_widgets      = array();

		foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

			$current_sidebars[ $import_sidebar ] = array();

			foreach ( $import_widgets as $import_widget ) :
				//if the sidebar exists
				if ( isset( $current_sidebars[ $import_sidebar ] ) ) :

					$title               = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
					$index               = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
					$current_widget_data = get_option( 'widget_' . $title );
					$new_widget_name     = self::get_new_widget_name( $title, $index );
					$new_index           = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );
					if ( ! empty( $new_widgets[ $title ] ) && is_array( $new_widgets[ $title ] ) ) {
						while ( array_key_exists( $new_index, $new_widgets[ $title ] ) ) {
							$new_index ++;
						}
					}
					if (! $current_widget_data ) {
						$current_widget_data = array();
					}
					$current_sidebars[ $import_sidebar ][] = $title . '-' . $new_index;
					if ( array_key_exists( $title, $new_widgets ) ) {
						$new_widgets[ $title ][ $new_index ] = $widget_data[ $title ][ $index ];
						$multiwidget                         = $new_widgets[ $title ]['_multiwidget'];
						unset( $new_widgets[ $title ]['_multiwidget'] );
						$new_widgets[ $title ]['_multiwidget'] = $multiwidget;
					} else {
						$current_widget_data[ $new_index ] = $widget_data[ $title ][ $index ];
						$current_multiwidget               = isset( $current_widget_data['_multiwidget'] ) ? $current_widget_data['_multiwidget'] : '';
						$new_multiwidget                   = isset( $widget_data[ $title ]['_multiwidget'] ) ? $widget_data[ $title ]['_multiwidget'] : false;
						$multiwidget                       = ( $current_multiwidget != $new_multiwidget ) ? $current_multiwidget : 1;
						unset( $current_widget_data['_multiwidget'] );
						$current_widget_data['_multiwidget'] = $multiwidget;
						$new_widgets[ $title ]               = $current_widget_data;
					}
				endif;
			endforeach;
		endforeach;
		if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
			update_option( 'sidebars_widgets', $current_sidebars );
			foreach ( $new_widgets as $title => $content ) {
				$content = apply_filters( 'widget_data_import', $content, $title );
				update_option( 'widget_' . $title, $content );
			}

			return true;
		}

		return false;
	}

	/**
	* Get new widget name
	* http://wordpress.org/plugins/widget-settings-importexport/
	*
	*/
	function get_new_widget_name( $widget_name, $widget_index ) {
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array();
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( ! empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index ++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;

		return $new_widget_name;
	}

	/**
	* Import theme options
	* @param string $file
	*
	*/
	function import_options( $file = '' ) {
		
		if ( '' == $file ) {
			return;
		}

		$file_path 	= get_template_directory() . '/lib/framework/importer/demo-files/' . $file . '.txt';
		$file_data 	= ghostpool_fs_get_contents( $file_path );
		$options = get_option( 'ghostpool_aardvark' );
		
		if ( $file_data ) {
			if ( $data = json_decode( $file_data, true ) ) {

				if ( $file == 'landing-page/options' ) {
					$directory = '';
				} else {
					$directory = trailingslashit( substr( $file, 0, strpos( $file, '/' ) ) );
				}	
				$demo_template_directory = 'https://aardvark.ghostpool.com/' . $directory . 'wp-content/themes/aardvark/';
								
				foreach ( $data as $k => $v ) {

					// Replace demo URLs with current site URLs
					if ( isset( $v['url'] ) && strpos( $v['url'], $demo_template_directory ) !== false ) {
						$v['url'] = str_replace( $demo_template_directory, trailingslashit( get_template_directory_uri() ), $v['url'] );
					}
				
					$options[ $k ] = $v;
					
				}
				$options['stime'] = time();
				update_option( 'ghostpool_aardvark', $options );

			}
		}

	}
		
	/**
	* Import LayerSlider
	*
	*
	*/
	public function import_layerslider( $file ) {
		if ( defined( 'LS_ROOT_PATH' ) ) {
			include( LS_ROOT_PATH . '/classes/class.ls.importutil.php' );
			$import = new LS_ImportUtil( $file );
		}
	}

	/**
	*  Import BuddyPress data
	*
	*/
	public function import_buddypress_data() {
		
		require_once( get_template_directory() . '/lib/framework/importer/demo-files/buddypress-data/helpers.php' );
			
		include_once( get_template_directory() . '/lib/framework/importer/demo-files/buddypress-data/process.php' );

		// Import users
		if ( ! bpdd_is_imported( 'users', 'users' ) ) {
			$users             = bpdd_import_users();
			bpdd_update_import( 'users', 'users' );
		}

		if ( ! bpdd_is_imported( 'users', 'xprofile' ) ) {
			$profile             = bpdd_import_users_profile();
			bpdd_update_import( 'users', 'xprofile' );
		}

		if ( ! bpdd_is_imported( 'users', 'friends' ) ) {
			$friends             = bpdd_import_users_friends();
			bpdd_update_import( 'users', 'friends' );
		}

		if ( ! bpdd_is_imported( 'users', 'messages' ) ) {
			$messages             = bpdd_import_users_messages();
			bpdd_update_import( 'users', 'messages' );
		}

		if ( ! bpdd_is_imported( 'users', 'activity' ) ) {
			$activity             = bpdd_import_users_activity();
			bpdd_update_import( 'users', 'activity' );
		}

		// Import groups
		if ( ! bpdd_is_imported( 'groups', 'groups' ) ) {
			$groups             = bpdd_import_groups();
			bpdd_update_import( 'groups', 'groups' );
		}
		if ( ! bpdd_is_imported( 'groups', 'members' ) ) {
			$g_members             = bpdd_import_groups_members();
			bpdd_update_import( 'groups', 'members' );
		}

		//if ( isset( $_POST['bpdd']['import-forums'] ) && ! bpdd_is_imported( 'groups', 'forums' ) ) {
		//	$forums             = bpdd_import_groups_forums( $groups );
		//	$imported['forums'] = sprintf( esc_html__( '%s groups forum topics', 'bp-default-data' ), number_format_i18n( count( $forums ) ) );
		//  bpdd_update_import( 'groups', 'forums' );
		//}

		if ( ! bpdd_is_imported( 'groups', 'activity' ) ) {
			$g_activity             = bpdd_import_groups_activity();
			bpdd_update_import( 'groups', 'activity' );
		}
					
	}
	
	/**
	* Import BP profile search fields
	*
	*/		
	public function import_bp_fields( $bp_fields, $extra_replace = true ) {
		
		if ( ! function_exists( 'bp_is_active' ) || ! bp_is_active( 'xprofile' ) ) {
			return;
		}

		$imported_ids = array();
		$existing_ids = array();
		$i = 0;
		foreach ( $bp_fields as $field ) {

			$i++;
			if ( ! $existing_ids[] = xprofile_get_field_id_from_name( $field['name'] ) ) {
				$id = xprofile_insert_field(
					array(
						'field_group_id' => 1,
						'name'           => $field['name'],
						'can_delete'     => $field['can_delete'],
						'field_order'    => $i,
						'is_required'    => $field['is_required'],
						'type'           => $field['type'],
					)
				);
				$imported_ids[] = $id;
				$imported_labels[] = $field['name'];
				$imported_descs[] = $field['desc'];
				$imported_modes[] = $field['mode'];

				if ( $id && isset( $field['options'] ) && ! empty( $field['options'] ) ) {
					$j = 0;
					foreach ( $field['options'] as $option ) {
						$j++;
						xprofile_insert_field( array(
							'field_group_id' => 1,
							'parent_id'      => $id,
							'type'           => $field['type'],
							'name'           => $option,
							'option_order'   => $j,
						) );
					}
				}
			}
		}

		if ( $extra_replace ) {
			$this->replace_bps_data( $imported_ids, $imported_labels, $imported_descs, $imported_modes, 'Member Search' );
		}

	}

	/**
	* Create BP profile search form with new field IDs
	*
	*/		
	public function replace_bps_data( $imported_ids, $imported_labels, $imported_descs, $imported_modes, $page_title ) {
		if ( ! empty( $imported_ids ) ) {

			$field_code = array();
			foreach ( $imported_ids as $imported_id ) {
				$field_code[] = 'field_' . $imported_id;
			}
			
			$bp_pages = get_option( 'bp-pages' );
			$member_page_id = (int) $bp_pages['members'];
			
			$args  = array(
				'post_type'   => 'bps_form',
				'title'       => $page_title,
			);
			$query = new WP_Query( $args );
			$posts = $query->posts;

			if ( ! empty( $posts ) && is_array( $posts ) ) {
				foreach ( $posts as $post ) {
				
					$form = get_post_meta( $post->ID, 'bps_options', true );
					if ( $form['header'] == 'Member Search' ) {
						return;
					}	

					$new_option_value = array(
						'field_code' => $field_code,
						'field_label' => $imported_labels,
						'field_desc' => $imported_descs,
						'field_mode' => $imported_modes,
						'directory' => 'Yes',
						'template' => 'members/bps-form-sample-2',
						'header' => esc_html__( 'Member Search', 'aardvark' ),
						'toggle' => 'Disabled',
						'button' => '',
						'method' => 'POST',
						'action' => $member_page_id,
					);
					
					delete_post_meta( $post->ID, 'bps_options' );
					update_post_meta( $post->ID, 'bps_options', $new_option_value );
					update_post_meta( $post->ID, '_ghostpool_imported', '1' );
					
					break;
					
				}
			}

			wp_reset_postdata();
		}
	}

	/**
	* Import PMP membership levels
	*/		
	public function import_pmp_membership_levels() {
	
		global $wpdb;
	
		$current_levels = pmpro_getAllLevels( false, true );
			
		if ( ! $current_levels ) {		
		
			$levels = array( 
				array( 
					'id' => '1',
					'name' => 'Basic',
					'description' => 'Basic level access.',
					'confirmation' => '',
					'initial_payment' => '0.00',
					'billing_amount' => '10.00',
					'cycle_number' => '1',
					'cycle_period' => 'Month',
					'billing_limit' => '0',
					'trial_amount' => '0.00',
					'trial_limit' => '1',
					'expiration_number' => '0',
					'expiration_period' => '',
					'allow_signups' => 1,
				),			
				array( 
					'id' => '2',
					'name' => 'Standard',
					'description' => 'Standard level access.',
					'confirmation' => '',
					'initial_payment' => '0.00',
					'billing_amount' => '35.00',
					'cycle_number' => '1',
					'cycle_period' => 'Month',
					'billing_limit' => '0',
					'trial_amount' => '0.00',
					'trial_limit' => '0',
					'expiration_number' => '0',
					'expiration_period' => '',
					'allow_signups' => 1,
				),			
				array( 
					'id' => '3',
					'name' => 'Pro',
					'description' => 'Pro level access.',
					'confirmation' => '',
					'initial_payment' => '0.00',
					'billing_amount' => '100.00',
					'cycle_number' => '1',
					'cycle_period' => 'Month',
					'billing_limit' => '0',
					'trial_amount' => '0.00',
					'trial_limit' => '0',
					'expiration_number' => '0',
					'expiration_period' => '',
					'allow_signups' => 1,
				),
			);
					
			if ( ! empty( $levels ) ) {

				foreach( $levels as $level ) {

					$wpdb->insert( $wpdb->pmpro_membership_levels, 
						array( 
							'id' => $level['id'],	
							'name' => $level['name'],
							'description' => $level['description'],
							'confirmation' => $level['confirmation'],
							'initial_payment' => $level['initial_payment'],
							'billing_amount' => $level['billing_amount'],
							'cycle_number' => $level['cycle_number'],
							'cycle_period' => $level['cycle_period'],
							'billing_limit' => $level['billing_limit'],
							'trial_amount' => $level['trial_amount'],
							'trial_limit' => $level['trial_limit'],
							'expiration_number' => $level['expiration_number'],
							'expiration_period' => $level['expiration_period'],
							'allow_signups' => $level['allow_signups'],
						),
						array(
							'%d',		//id
							'%s',		//name
							'%s',		//description
							'%s',		//confirmation
							'%f',		//initial_payment
							'%f',		//billing_amount
							'%d',		//cycle_number
							'%s',		//cycle_period
							'%d',		//billing_limit
							'%f',		//trial_amount
							'%d',		//trial_limit
							'%d',		//expiration_number
							'%s',		//expiration_period
							'%d',		//allow_signups
						)
					);
			
				}		
			}	
			
		}
	}
			
	private function get_imported_posts() {
		$args  = array(
			'post_type'  => array( 'post', 'page' ),
			'meta_query' => array(
				array(
					'key'   => 'ghostpool_import',
					'value' => '1',
				),
				array(
					'key'     => '_ghostpool_imported',
					'compare' => 'NOT EXISTS',
				),
			),
		);
		$query = new WP_Query( $args );

		return $query->posts;
	}
	
	private function save_main_imported_pages() {
		$posts = $this->get_imported_posts();
		foreach ( $posts as $post ) {

			// Save the imported page
			if ( 'page' == get_post_type( $post->ID ) ) {
				$this->posts_imported[ $post->ID ] = $post;
			}
		}
	}
		
	private function post_process_posts( $set_data ) {

		// Set default plugin pages
		$this->set_default_plugin_pages();
					
		$posts = $this->get_imported_posts();

		foreach ( $posts as $post ) {

			do_action( 'ghostpool_import_before_process', $post, $this );
			
			// Update Page Builder row bgs
			$this->update_row_bgs( $post );

			do_action( 'ghostpool_import_after_process', $post, $this );

			add_post_meta( $post->ID, '_ghostpool_imported', 1 );

		}
		wp_reset_postdata();

		$this->delete_import_data();

	}

	/**
	* Update WPBakery Page Builder row background urls
	*
	*/
	public function update_row_bgs( $post ) {
		global $wpdb;
		
		// Get old URLs from post meta
		if ( preg_match_all( '/background-image.*?url\((.*?)\)/mi', get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true ), $matches ) ) {
			foreach ( $matches[0] as $match ) {
				$old_urls[] = $match;
			}
		}	
		
		// Get new background URLs from post content
		if ( preg_match_all( '/background-image.*?url\((.*?)\)/mi', $post->post_content, $matches ) ) {
			foreach ( $matches[0] as $match ) {
				$new_urls[] = $match;
			}
		}	
		
		// Combine old and new URLs into a single array
		$urls = array_combine( $old_urls, $new_urls ); 
		
		// Replace old URLs with new URLs
		foreach ( $urls as $old_url => $new_url ) {
			$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = REPLACE( meta_value, %s, %s )", $old_url, $new_url ) );
		}
			
	}

	/**
	* Set default plugin pages
	*
	*/
	public function set_default_plugin_pages() {
		
		// Set WooCommerce pages
		$wc_shop_page = get_page_by_title( 'Shop' );
		if ( ! empty( $wc_shop_page ) && get_option( 'woocommerce_shop_page_id' ) == '' ) {
			update_option( 'woocommerce_shop_page_id', $wc_shop_page->ID );
		}	
		$wc_cart_page = get_page_by_title( 'Cart' );
		if ( ! empty( $wc_cart_page ) && get_option( 'woocommerce_cart_page_id' ) == '' ) {
			update_option( 'woocommerce_cart_page_id', $wc_cart_page->ID );
		}
		$wc_checkout_page = get_page_by_title( 'Checkout' );
		if ( ! empty( $wc_checkout_page ) && get_option( 'woocommerce_checkout_page_id' ) == '' ) {
			update_option( 'woocommerce_checkout_page_id', $wc_checkout_page->ID );
		}
		$wc_account_page = get_page_by_title( 'My account' );
		if ( ! empty( $wc_account_page ) && get_option( 'woocommerce_myaccount_page_id' ) == '' ) {
			update_option( 'woocommerce_myaccount_page_id', $wc_account_page->ID );
		}
			
		// Set Sensei pages		
		$sensei_courses_page = get_page_by_title( 'Courses' );
		if ( ! empty( $sensei_courses_page ) && get_option( 'woothemes-sensei_courses_page_id' ) == 0 ) {
			update_option( 'woothemes-sensei_courses_page_id', $sensei_courses_page->ID );
		}	
		$sensei_my_courses_page = get_page_by_title( 'My Courses' );
		if ( ! empty( $sensei_my_courses_page ) && get_option( 'woothemes-sensei_user_dashboard_page_id' ) == 0 ) {	
			update_option( 'woothemes-sensei_user_dashboard_page_id', $sensei_my_courses_page->ID );
		}
		
		// Set Paid Membership Pro pages
		$pmp_account_page = get_page_by_title( 'Membership Account' );
		if ( ! empty( $pmp_account_page ) && get_option( 'pmpro_account_page_id' ) == '' ) {	
			update_option( 'pmpro_account_page_id', $pmp_account_page->ID );
			
		}
		$pmp_billing_page = get_page_by_title( 'Membership Billing' );
		if ( ! empty( $pmp_billing_page ) && get_option( 'pmpro_billing_page_id' ) == '' ) {	
			update_option( 'pmpro_billing_page_id', $pmp_billing_page->ID );
			
		}
		$pmp_cancel_page = get_page_by_title( 'Membership Cancel' );
		if ( ! empty( $pmp_cancel_page ) && get_option( 'pmpro_cancel_page_id' ) == '' ) {	
			update_option( 'pmpro_cancel_page_id', $pmp_cancel_page->ID );
			
		}		
		$pmp_checkout_page = get_page_by_title( 'Membership Checkout' );
		if ( ! empty( $pmp_checkout_page ) && get_option( 'pmpro_checkout_page_id' ) == '' ) {	
			update_option( 'pmpro_checkout_page_id', $pmp_checkout_page->ID );
			
		}	
		$pmp_confirmation_page = get_page_by_title( 'Membership Confirmation' );
		if ( ! empty( $pmp_confirmation_page ) && get_option( 'pmpro_confirmation_page_id' ) == '' ) {	
			update_option( 'pmpro_confirmation_page_id', $pmp_confirmation_page->ID );
			
		}	
		$pmp_invoice_page = get_page_by_title( 'Membership Invoice' );
		if ( ! empty( $pmp_invoice_page ) && get_option( 'pmpro_invoice_page_id' ) == '' ) {	
			update_option( 'pmpro_invoice_page_id', $pmp_invoice_page->ID );
			
		}	
		$pmp_levels_page = get_page_by_title( 'Membership Levels' );
		if ( ! empty( $pmp_levels_page ) && get_option( 'pmpro_levels_page_id' ) == '' ) {	
			update_option( 'pmpro_levels_page_id', $pmp_levels_page->ID );
			
		}		
				
	}
				
	public function get_post_by_slug( $slug ) {
		global $wpdb;
		return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s", $slug ) );
	}
	
	/**
	* Delete post meta required by import logic
	*
	*/
	function delete_import_data() {
		delete_post_meta_by_key( 'ghostpool_import' );
	}
		
	private function set_success_message( $msg ) {
		return $msg;
	}

	// Eeturn the difference in length between two strings
	function cmpr_strlen( $a, $b ) {
		return strlen( $b ) - strlen( $a );
	}

	public function do_import() {
		if ( array_key_exists( 'ghostpool_import_nonce', $_POST ) ) {

			if ( wp_verify_nonce( $_POST['ghostpool_import_nonce'], 'import_nonce' ) ) {

				if ( isset( $_POST['import_demo'] ) ) {

					$demo_sets   = self::get_demo_sets();
					$current_set = $_POST['import_demo'];
					$set_data = $demo_sets[ $current_set ];

					if ( ! array_key_exists( $current_set, $demo_sets ) ) {
						$this->error .= esc_html__( 'Something went wrong with the data sent. Please try again.', 'aardvark' );
					}

					$data = array();
					foreach ( $_POST as $k => $v ) {
						if ( is_array( $v ) && in_array( $current_set, $v ) ) {
							$data[ $k ][] = $current_set;
						}
					}

					$response = $this->process_import( array(
						'set_data' => $set_data,
						'pid' => false,
						'data' => $data,
					) );

					if ( is_wp_error( $response ) ) {
						$this->error .= $response->get_error_message();
					} else {
						$this->data_imported = true;
					}
					
				} else {

					// Importer classes
					if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
						define( 'WP_LOAD_IMPORTERS', true );
					}

					if ( ! class_exists( 'WP_Importer' ) ) {
						require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
					}

					if ( ! class_exists( 'WP_Import' ) ) {
						require_once get_template_directory() . '/lib/framework/importer/wordpress-importer.php';
					}

					if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {
						switch ( $_POST['import'] ) {
						}
					}
					$this->data_imported = true;
				}
			}
		}
	}

	/**
	* Import menu locations
	*
	* @param array $locations Menu locations and names
	*/
	function import_menu_location( $data = array() ) {

		$menus = wp_get_nav_menus();

		foreach ( $data as $key => $val ) {
			foreach ( $menus as $menu ) {
				if ( $menu->slug == $val ) {
					$data[ $key ] = absint( $menu->term_id );
				}
			}
		}
		set_theme_mod( 'nav_menu_locations', $data );
	}

	public function show_message() {
		if ( $this->error ) {
			echo '<div class="error settings-error">';
			echo '<p><strong>' . $this->error . '</strong></p>';
			echo '</div>';
		} elseif ( $this->data_imported ) {
			echo '<div class="updated settings-error">';
			echo '<p><strong>' . esc_html__( 'Import successful. Have fun!', 'aardvark' ) . '</strong></p>';
			echo '</div>';
		}
	}

	public function generate_boxes_html() { ?>
		
		<div class="theme-browser">
		
			<div class="themes">

				<?php
			
				$demo_sets = self::get_demo_sets();

				foreach ( $demo_sets as $k => $v ) : ?>

					<div class="theme" <?php if ( isset( $v['slug'] ) ) { echo 'data-slug="' . $v['slug'] . '"'; } ?>>
	
						<?php if ( isset( $v['slug'] ) && $this->get_post_by_slug( $v['slug'] ) ) : ?>
							<div class="gp-imported-label"></div>
						<?php endif; ?>
						
						<div class="theme-screenshot">
							<img src="<?php echo esc_attr( $v['img'] ); ?>">
						</div>
						
						<div class="theme-id-container">
							
							<div class="gp-demo-left">	
							
								<h2 class="theme-name"><?php echo esc_attr( $v['name'] ); ?></h2> 
								
								<div class="gp-demo-checkboxes">
									
									<?php if ( isset( $v['page'] ) ) : ?>
										<label><input type="checkbox" name="import_page[]" checked value="<?php echo esc_attr( $k ); ?>" class="check-page"> <?php esc_html_e( 'Import Pages' , 'aardvark' ); ?></label>
									<?php endif; ?>

									<?php if ( isset( $v['extra'] ) && ! empty( $v['extra'] ) ) : ?>
										<?php foreach ( $v['extra'] as $extra ) : ?>
											<?php
											if ( $extra['id'] == 'sensei' && ! function_exists( 'is_sensei' ) ) {
												$checked = ' disabled';
											} elseif ( isset( $extra['checked'] ) && $extra['checked'] ) {
												$checked = ' checked="checked"';
											} else {
												$checked = '';
											}
											?>
											<label>
												<input type="checkbox" name="import_<?php echo esc_attr( $extra['id'] );?>[]" value="<?php echo esc_attr( $k ); ?>" class="check-page"<?php echo esc_attr( $checked ); ?>> <?php if ( $extra['id'] == 'sensei' && ! function_exists( 'is_sensei' ) ) { ?><s><?php } ?><?php echo esc_attr( $extra['name'] ); ?><?php if ( $extra['id'] == 'sensei' && ! function_exists( 'is_sensei' ) ) { ?></s><?php } ?>
											</label>
										<?php endforeach; ?>
									<?php endif; ?>

									<?php if ( isset( $v['widgets'] ) ) : ?>
										<label><input type="checkbox" name="import_widgets[]" checked value="<?php echo esc_attr( $k ); ?>"> <?php esc_html_e( 'Import Widgets' , 'aardvark' ); ?></label>
									<?php endif; ?>

									<?php if ( isset( $v['bp_fields'] ) ) : ?>
										<label><input type="checkbox" name="import_bp_fields[]" value="<?php echo esc_attr( $k ); ?>"<?php if ( ! function_exists( 'bp_is_active' ) OR ! bp_is_active( 'xprofile' ) ) { ?> disabled<?php } else { ?> checked<?php } ?>><?php if ( ! function_exists( 'bp_is_active' ) OR ! bp_is_active( 'xprofile' ) ) { ?><s><?php } ?><?php esc_html_e( 'Import BuddyPress Profile Fields' , 'aardvark' ); ?><?php if ( ! function_exists( 'bp_is_active' ) OR ! bp_is_active( 'xprofile' ) ) { ?></s><?php } ?></label>
									<?php endif; ?>

									<?php if ( isset( $v['layerslider'] ) ) : ?>
										<label><input type="checkbox" name="import_layerslider[]" checked value="<?php echo esc_attr( $k ); ?>"> <?php esc_html_e( 'Import LayerSlider' , 'aardvark' ); ?></label>
									<?php endif; ?>

									<?php if ( isset( $v['import_levels'] ) ) : ?>
										<label><input type="checkbox" name="import_levels[]" value="<?php echo esc_attr( $k ); ?>"<?php if ( ! defined( 'PMPRO_VERSION' ) ) { ?> disabled<?php } else { ?> checked<?php } ?>><?php if ( ! defined( 'PMPRO_VERSION' ) ) { ?><s><?php } ?> <?php esc_html_e( 'Import Membership Levels' , 'aardvark' ); ?><?php if ( ! defined( 'PMPRO_VERSION' ) ) { ?></s><?php } ?></label>
									<?php endif; ?>
									
									<?php if ( isset( $v['buddypress'] ) ) : ?>
										<label><input type="checkbox" name="import_buddypress[]" value="<?php echo esc_attr( $k ); ?>"<?php if ( ! function_exists( 'bp_is_active' ) ) { ?> disabled<?php } else { ?> checked<?php } ?>><?php if ( ! function_exists( 'bp_is_active' ) ) { ?><s><?php } ?> <?php esc_html_e( 'Import BuddyPress Data' , 'aardvark' ); ?><?php if ( ! function_exists( 'bp_is_active' ) ) { ?></s><?php } ?></label>
									<?php endif; ?>
									
									<?php if ( isset( $v['options'] ) ) : ?>
										<label>
											<input type="checkbox" name="import_options[]" checked value="<?php echo esc_attr( $v['options'] ); ?>"> <?php esc_html_e( 'Import Theme Options' , 'aardvark' ); ?>
											<?php 
											$extra_options_data = esc_html__( 'This will change some of your theme options. Make sure to export them first.', 'aardvark' );
											echo ' <span class="dashicons dashicons-editor-help tooltip-me" title="' . $extra_options_data . '"></span>';
											?>
										</label>	
									<?php endif; ?>

									<?php if ( isset( $v['plugins'] ) && ! empty( $v['plugins'] ) ) : ?>
										<label>
											<input type="checkbox" name="activate_plugins[]" checked value="<?php echo esc_attr( $k ); ?>">
											<?php
											echo esc_html__( 'Activate Required Plugins', 'aardvark' );
											$extra_plugin_data = str_replace( '-', ' ', implode( ', ', $v['plugins'] ) );
											$extra_plugin_data = ucwords( str_replace( '_', ' ', $extra_plugin_data ) );
											echo ' <span class="dashicons dashicons-editor-help tooltip-me" title="' . $extra_plugin_data . '"></span>';
											?>
										</label>
									<?php endif; ?>
									
									<?php
									
									$extra_data = isset( $v['details'] ) ? $v['details'] : '';
									if ( '' != $extra_data ) : ?>
										<span class="gp-demo-details"><?php echo esc_attr( $extra_data ); ?></span>
									<?php endif; ?>
									
									<small><?php esc_html_e( 'It is recommended to leave all default options checked to reproduce this demo.', 'aardvark' ); ?></small>
								
								</div>
							
							</div>

							<button type="submit" name="import_demo" value="<?php echo esc_attr( $k ); ?>" class="button button-primary gp-import-button"><?php esc_html_e( 'Import', 'aardvark' ); ?></button>
												
							<a href="<?php echo esc_attr( $v['link'] ); ?>" class="button gp-preview-button" target="_blank"><?php esc_html_e( 'Preview' , 'aardvark' ); ?></a>
							
						</div>
						
					</div>

				<?php endforeach; ?>
			
			</div>

		</div>
		
		<?php
	}
				
}

GhostPool_Importer::getInstance();