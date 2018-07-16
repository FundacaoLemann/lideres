<?php

/**
* Load theme framework
*
*/
require_once( get_template_directory() . '/lib/framework/ghostpool-framework.php' );
 
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own ghostpool_theme_setup() function to override in a child theme.
 *
 */
if ( ! function_exists( 'ghostpool_theme_setup' ) ) {
	function ghostpool_theme_setup() {

		// Localisation
		load_theme_textdomain( 'aardvark', trailingslashit( WP_LANG_DIR ) . 'themes/' );
		load_theme_textdomain( 'aardvark', get_stylesheet_directory() . '/languages' );
		load_theme_textdomain( 'aardvark', get_template_directory() . '/languages' );

		// Background customizer
		add_theme_support( 'custom-background' );

		// This theme styles the visual editor with editor-style.css to match the theme style
		add_editor_style( 'lib/css/editor-style.css' );

		// Add default posts and comments RSS feed links to <head>
		add_theme_support( 'automatic-feed-links' );
		
		// Post formats
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

		// Title support
		add_theme_support( 'title-tag' );
		
		// Indicate widget sidebars can use selective refresh in the Customizer
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		// WooCommerce support
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );		
		
		// Sensei support	
		add_theme_support( 'sensei' );
		
		// BuddyPress legacy support
		add_theme_support( 'buddypress-use-legacy' );
	
		// Register navigation menus
		register_nav_menus( array(
			'gp-main-header-primary-nav' => esc_html__( 'Main Header Primary Navigation', 'aardvark' ),
			'gp-mobile-primary-nav' => esc_html__( 'Mobile Primary Navigation', 'aardvark' ),
			'gp-main-header-secondary-nav' => esc_html__( 'Main Header Secondary Navigation', 'aardvark' ),
			'gp-top-header-left-nav' => esc_html__( 'Top Header Left Navigation', 'aardvark' ),
			'gp-top-header-right-nav' => esc_html__( 'Top Header Right Navigation', 'aardvark' ),
			'gp-profile-nav' => esc_html__( 'Profile Navigation', 'aardvark' ),
			'gp-mobile-profile-nav' => esc_html__( 'Mobile Profile Navigation', 'aardvark' ),
			'gp-footer-nav' => esc_html__( 'Footer Navigation', 'aardvark' ),
			'gp-side-menu-nav' => esc_html__( 'Side Menu Navigation', 'aardvark' ),
		) );

		// Disable LayerSlider activation features
		if ( function_exists( 'layerslider_set_as_theme' ) ) {
			layerslider_set_as_theme();
		}
		
	}
}
add_action( 'after_setup_theme', 'ghostpool_theme_setup' );
				
// Load Sensei functions
if ( function_exists( 'is_sensei' ) ) {
	require_once( get_template_directory() . '/lib/inc/sensei-functions.php' );
}
		
/**
* Load theme functions
*
*/
if ( ! function_exists( 'ghostpool_load_theme_functions' ) ) {
	function ghostpool_load_theme_functions() {

		// Theme setup
		require_once( get_template_directory() . '/lib/framework/theme-setup/init.php' );

		// Sidebars
		require_once( get_template_directory() . '/lib/framework/custom-sidebars/custom-sidebars.php' );
	
		// Category options
		require_once( get_template_directory() . '/lib/framework/category-config.php' );

		// Init variables
		require_once( get_template_directory() . '/lib/inc/init-variables.php' );

		// Load plugin defaults
		require_once( get_template_directory() . '/lib/inc/plugin-defaults.php' );
	
		// Load pagination functions
		require_once( get_template_directory() . '/lib/inc/pagination-functions.php' );
				
		// Load query functions
		require_once( get_template_directory() . '/lib/inc/query-functions.php' );
		
		// Load filter functions		
		require_once( get_template_directory() . '/lib/inc/filter-functions.php' );
						
		// Load custom menu walker
		require_once( get_template_directory() . '/lib/menus/custom-menu-walker.php' );

		// Load custom menu fields
		require_once( get_template_directory() . '/lib/menus/menu-item-custom-fields.php' );
				
		// Load page header functions
		require_once( get_template_directory() . '/lib/inc/page-header.php' );
		
		// Load video header functionss
		require_once( get_template_directory() . '/lib/inc/video-header.php' );
			
		// Load page title functions
		require_once( get_template_directory() . '/lib/inc/page-titles.php' );

		// Load loop functions
		require_once( get_template_directory() . '/lib/inc/loop-functions.php' );

		// Load post submission/edit functions
		require_once( get_template_directory() . '/lib/inc/post-submission-functions.php' );
		require_once( get_template_directory() . '/lib/inc/post-edit-functions.php' );
			
		// Load login functions
		require_once( get_template_directory() . '/lib/inc/login-functions.php' );
						
		// Load BuddyPress functions
		if ( function_exists( 'bp_is_active' ) ) {
			require_once( get_template_directory() . '/lib/inc/buddypress-functions.php' );
		}

		// Load bbPress functions
		if ( function_exists( 'is_bbpress' ) ) {
			require_once( get_template_directory() . '/lib/inc/bbpress-functions.php' );
		}
		
		// Load Woocommerce functions
		if ( function_exists( 'is_woocommerce' ) ) {
			require_once( get_template_directory() . '/lib/inc/woocommerce-functions.php' );
		}
		
		// Load Paid Membership Pro functions
		require_once( get_template_directory() . '/lib/inc/membership-functions.php' );
											
	}
}
add_action( 'after_setup_theme', 'ghostpool_load_theme_functions' );
				
/**
 * Registered image sizes
 *
 */
if ( ! function_exists( 'ghostpool_image_sizes' ) ) {
	function ghostpool_image_sizes() {				
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'gp_small_image', 75, 75, true );
		add_image_size( 'gp_list_image', 250, 135, true );
		add_image_size( 'gp_square_image', 300, 300, true );
		add_image_size( 'gp_featured_image', 864, 467, true );
		add_image_size( 'gp_column_image', 727, 393, true );
		add_image_size( 'gp_related_image', 414, 224, true );
		add_image_size( 'gp_featured_box_small_image', 330, 240, true );	
		add_image_size( 'gp_featured_box_large_image', 600, 480, true );	
		add_image_size( 'gp_featured_box_full_image', 1260, 480, true );		
	}
}
add_action( 'after_setup_theme', 'ghostpool_image_sizes' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 */
function ghostpool_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ghostpool_sidebar_content_width', 1140 );
}
add_action( 'after_setup_theme', 'ghostpool_content_width', 0 );

		
/**
 * Enqueues scripts and styles.
 *
 */	
if ( ! function_exists( 'ghostpool_scripts' ) ) {

	function ghostpool_scripts() {
	
		global $wp_query;

		wp_enqueue_style( 'ghostpool-style', get_stylesheet_uri() );
		
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/lib/fonts/font-awesome/css/font-awesome.min.css' );
				
		if ( ghostpool_option( 'lightbox' ) != 'disabled' ) {
			wp_enqueue_style( 'featherlight', get_template_directory_uri() . '/lib/scripts/featherlight/featherlight.min.css' );
			wp_enqueue_style( 'featherlight-gallery', get_template_directory_uri() . '/lib/scripts/featherlight/featherlight.gallery.min.css' );
		}
			
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { 
			wp_enqueue_script( 'comment-reply' );
		}
					
		wp_enqueue_script( 'imagesloaded' );
		
		wp_register_script( 'particles-js', get_template_directory_uri() . '/lib/scripts/particles.min.js', false, '', true );

		wp_enqueue_script( 'placeholder', get_template_directory_uri() . '/lib/scripts/placeholders.min.js', false, '', true );
									
		if ( ghostpool_option( 'lightbox' ) != 'disabled' ) {
			wp_enqueue_script( 'featherlight', get_template_directory_uri() . '/lib/scripts/featherlight/featherlight.min.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'featherlight-gallery', get_template_directory_uri() . '/lib/scripts/featherlight/featherlight.gallery.min.js', array( 'jquery' ), '', true );
		}
			
		if ( ghostpool_option( 'back_to_top' ) != 'gp-no-back-to-top' ) { 
			wp_enqueue_script( 'jquery-totop', get_template_directory_uri() . '/lib/scripts/jquery.ui.totop.min.js', array( 'jquery' ), '', true );
		}	

		wp_enqueue_script( 'jquery-flexslider', get_template_directory_uri() . '/lib/scripts/jquery.flexslider-min.js', array( 'jquery' ), '', true );
		
		wp_enqueue_script( 'isotope', get_template_directory_uri() . '/lib/scripts/isotope.pkgd.min.js', false, '', true );

		wp_enqueue_script( 'lazyload', get_template_directory_uri() . '/lib/scripts/jquery.lazyload.min.js', array( 'jquery' ), '', true );
		
		wp_enqueue_script( 'jquery-infinitescroll', get_template_directory_uri() . '/lib/scripts/jquery.infinitescroll.min.js', array( 'jquery' ), '', true );
				
		wp_enqueue_script( 'ghostpool-custom', get_template_directory_uri() . '/lib/scripts/custom.js', array( 'jquery' ), '', true );
		
		if ( is_ssl() ) {
			$url = esc_url( 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		} else { 
			$url = esc_url( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		}
			
		wp_localize_script( 'ghostpool-custom', 'ghostpool_script', array(
			'lightbox' 					   => ghostpool_option( 'lightbox' ),
			'url'	   					   => $url,
			'login_redirect_url'	   	   => get_permalink( ghostpool_option( 'login_redirect' ) ),
			'max_num_pages' 			   => $wp_query->max_num_pages,
			'get_template_directory_uri'   => get_template_directory_uri(),
			'bp_item_tabs_nav_text'		   => esc_html__( 'Navigation', 'aardvark' ),
			'hide_move_primary_menu_links' => ghostpool_option( 'hide_move_primary_menu_links' ),
			'scroll_to_fixed_header'       => preg_replace('/\D/', '', ghostpool_option( 'scroll_to_fixed_header', 'height' ) ),
		) );
						
	}
}
add_action( 'wp_enqueue_scripts', 'ghostpool_scripts' );

/**
 * Enqueues admin scripts and styles.
 *
 */	
if ( ! function_exists( 'ghostpool_admin_scripts' ) ) {
	function ghostpool_admin_scripts() {
		wp_enqueue_style( 'ghostpool-admin', get_template_directory_uri() . '/lib/framework/css/general-admin.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'ghostpool_admin_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 */
if ( ! function_exists( 'ghostpool_body_classes' ) ) {
	function ghostpool_body_classes( $classes ) {
		
		$classes[] = 'gp-theme';
		$classes[] = ghostpool_option( 'theme_layout' );
		$classes[] = isset( $GLOBALS['ghostpool_layout'] ) ? $GLOBALS['ghostpool_layout'] : '';		
		$classes[] = isset( $GLOBALS['ghostpool_page_header'] ) ? $GLOBALS['ghostpool_page_header'] : '';	
		$classes[] = ghostpool_option( 'sidebar_display' );
		$classes[] = ghostpool_option( 'back_to_top' );
		$bp_header_layout = ghostpool_option( 'bp_header_layout' ) != 'default' ? ghostpool_option( 'bp_header_layout' ) : ghostpool_option( 'header_layout' );
		if ( function_exists( 'bp_is_active' ) && bp_is_activity_component() ) {
			$classes[] =  ghostpool_option( 'bp_activity_header_layout' ) != 'default' ? ghostpool_option( 'bp_activity_header_layout' ) : $bp_header_layout;
		} elseif ( function_exists( 'bp_is_active' ) && bp_is_members_component() ) {
			$classes[] =  ghostpool_option( 'bp_members_header_layout' ) != 'default' ? ghostpool_option( 'bp_members_header_layout' ) : $bp_header_layout;
		} elseif ( function_exists( 'bp_is_active' ) && bp_is_groups_component() ) {
			$classes[] = ghostpool_option( 'bp_groups_header_layout' ) != 'default' ? ghostpool_option( 'bp_groups_header_layout' ) : $bp_header_layout;
		} elseif ( function_exists( 'bp_is_active' ) && bp_is_register_page() ) {
			$classes[] = ghostpool_option( 'bp_register_header_layout' ) != 'default' ? ghostpool_option( 'bp_register_header_layout' ) : $bp_header_layout;	
		} else {
			$classes[] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header_layout', true ) && redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header_layout', true ) != 'default' ? get_post_meta( get_the_ID(), 'page_header_layout', true ) : ghostpool_option( 'header_layout' );
		}
		$classes[] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header_display' ) && redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header_display' ) != 'default' ? redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header_display' ) : ghostpool_option( 'header_display' );
		$classes[] = ghostpool_option( 'header_width' );
		$classes[] = ghostpool_option( 'fixed_header' );
		$classes[] = ghostpool_option( 'top_header' );
		$classes[] = ghostpool_option( 'cart_button' );
		$classes[] = ghostpool_option( 'search_button' );
		$classes[] = ghostpool_option( 'profile_button' );
		
		if ( is_page_template( 'homepage-template.php' ) ) {
			$classes[] = 'gp-homepage';
		}
		
		if ( defined( 'TSS_VERSION' ) ) {	
			$classes[] = 'gp-sticky-sidebars';	
		}	
		
		return $classes;
		
	}
}
add_filter( 'body_class', 'ghostpool_body_classes' );
		
/**
 * Content added to header
 *
 */	
if ( ! function_exists( 'ghostpool_wp_header' ) ) {

	function ghostpool_wp_header() {

		// Title fallback for versions earlier than WordPress 4.1
		if ( ! function_exists( '_wp_render_title_tag' ) && ! function_exists( 'ghostpool_render_title' ) ) {
			function ghostpool_render_title() { ?>
				<title><?php wp_title( '|', true, 'right' ); ?></title>
			<?php }
		}

		// Initial variables - variables loaded only once at the top of the page
		ghostpool_init_variables();

		// Load custom CSS
		require_once( get_template_directory() . '/lib/inc/custom-css.php' );
			
		// Add custom JavaScript code
		if ( ghostpool_option( 'js_code' ) ) {
			if ( strpos( ghostpool_option( 'js_code' ), '<script ' ) !== false ) { 
				echo ghostpool_option( 'js_code' ); 
			} else {
				$js_code = str_replace( array( '<script>', '</script>' ), '', ghostpool_option( 'js_code' ) );
				echo '<script>' . $js_code . '</script>';
			}    
		}
						
	}
	
}
add_action( 'wp_head', 'ghostpool_wp_header', 151 );
	
/**
 * Navigation user meta
 *
 */	
if ( ! function_exists( 'ghostpool_nav_user_meta' ) ) {
	function ghostpool_nav_user_meta( $user_id = NULL ) {
	
		// So this can be used without hooking into user_register
		if ( ! $user_id ) {
			$user_id = get_current_user_id(); 
		}

		// Set the default properties if it has not been set yet
		if ( ! get_user_meta( $user_id, 'managenav-menuscolumnshidden', true) ) {
			$meta_value = array( 'link-target', 'xfn', 'description' );
			update_user_meta( $user_id, 'managenav-menuscolumnshidden', $meta_value );
		}
	
	}	
}
add_action( 'admin_init', 'ghostpool_nav_user_meta' );

/**
 * Insert schema meta data
 *
 */	
if ( ! function_exists( 'ghostpool_meta_data' ) ) {
	function ghostpool_meta_data( $post_id ) {
	
		global $post;

		// Get title
		if ( ghostpool_option( 'custom_title' ) ) { 
			$title = esc_attr( ghostpool_option( 'custom_title' ) );
		} else {
			$title = get_the_title( $post_id );
		}
		
		// Get featured image dimensions
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'gp_featured_image' );

		// Meta data
		return '<meta itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemscope content="' . esc_url( get_permalink( $post_id ) ) . '">
		<meta itemprop="headline" content="' . esc_attr( $title ) . '">			
		<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
			<meta itemprop="url" content="' . esc_url( wp_get_attachment_url( get_post_thumbnail_id( $post_id ) ) ) . '">
			<meta itemprop="width" content="' . absint( $image[1] ) . '">	
			<meta itemprop="height" content="' . absint( $image[2] ) . '">		
		</div>
		<meta itemprop="author" content="' . get_the_author_meta( 'display_name', $post->post_author ) . '">			
		<meta itemprop="datePublished" content="' . get_the_time( 'Y-m-d' ) . '">
		<meta itemprop="dateModified" content="' . get_the_modified_date( 'Y-m-d' ) . '">
		<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
			<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
				<meta itemprop="url" content="' . esc_url( ghostpool_option( 'desktop_logo', 'url' ) ) . '">
				<meta itemprop="width" content="' . absint( ghostpool_option( 'desktop_logo_dimensions', 'width' ) ) . '">
				<meta itemprop="height" content="' . absint( ghostpool_option( 'desktop_logo_dimensions', 'height' ) ) . '">
			</div>
			<meta itemprop="name" content="' . get_bloginfo( 'name' ) . '">
		</div>';

	}
}

/**
 * Insert breadcrumbs
 *
 */	
if ( ! function_exists( 'ghostpool_breadcrumbs' ) ) {
	function ghostpool_breadcrumbs() {
		if ( function_exists( 'yoast_breadcrumb' ) && ! is_front_page() ) { 
			$breadcrumbs = yoast_breadcrumb( '<div id="gp-breadcrumbs" class="gp-active">', '</div>' );
		} else {
			$breadcrumbs = '';
		}
		return $breadcrumbs;
	}
}

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 */

// Contact details widget
require_once( get_template_directory() . '/lib/widgets/contact-details.php' );
 
// Login/register form widget
require_once( get_template_directory() . '/lib/widgets/login-register-form.php' );

// Recent comments widget
require_once( get_template_directory() . '/lib/widgets/recent-comments.php' );

// Posts widget
require_once( get_template_directory() . '/lib/widgets/posts.php' );

// Popular posts widget
require_once( get_template_directory() . '/lib/widgets/popular-posts.php' );

// Showcase posts widget
require_once( get_template_directory() . '/lib/widgets/showcase-posts.php' );

if ( ! function_exists( 'ghostpool_widgets_init' ) ) {
	function ghostpool_widgets_init() {

		register_sidebar( array( 
			'name'          => esc_html__( 'Right Sidebar', 'aardvark' ),
			'id'            => 'gp-right-sidebar',
			'description'   => esc_html__( 'Displayed on posts, pages and post categories.', 'aardvark' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array( 
			'name'          => esc_html__( 'Left Sidebar', 'aardvark' ),
			'id'            => 'gp-left-sidebar',
			'description'   => esc_html__( 'Displayed on posts, pages and post categories.', 'aardvark' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) ); 

		register_sidebar( array(
			'name'          => esc_html__( 'Side Menu', 'aardvark' ),
			'id'            => 'gp-side-menu',
			'description'   => esc_html__( 'Displayed in the side menu.', 'aardvark' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );
			
		register_sidebar( array(
			'name'          => esc_html__( 'Footer 1', 'aardvark' ),
			'id'            => 'gp-footer-1',
			'description'   => esc_html__( 'Displayed as the first column in the footer.', 'aardvark' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );        

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 2', 'aardvark' ),
			'id'            => 'gp-footer-2',
			'description'   => esc_html__( 'Displayed as the second column in the footer.', 'aardvark' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );        
	
		register_sidebar( array(
			'name'          => esc_html__( 'Footer 3', 'aardvark' ),
			'id'            => 'gp-footer-3',
			'description'   => esc_html__( 'Displayed as the third column in the footer.', 'aardvark' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );        
	
		register_sidebar( array(
			'name'          => esc_html__( 'Footer 4', 'aardvark' ),
			'id'            => 'gp-footer-4',
			'description'   => esc_html__( 'Displayed as the fourth column in the footer.', 'aardvark' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );      

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 5', 'aardvark' ),
			'id'            => 'gp-footer-5',
			'description'   => esc_html__( 'Displayed as the fifth column in the footer.', 'aardvark' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) ); 
			
	}
}
add_action( 'widgets_init', 'ghostpool_widgets_init' );

/**
 * Header advertisement
 *
 */	
function ghostpool_add_header_advertisement() {
	if ( function_exists( 'the_ad_placement' ) ) { the_ad_placement( 'header' ); }
}
add_action( 'ghostpool_begin_content_wrapper', 'ghostpool_add_header_advertisement' );

/**
 * Footer advertisement
 *
 */	
function ghostpool_add_footer_advertisement() {
	if ( function_exists( 'the_ad_placement' ) ) { the_ad_placement( 'footer' ); }
}
add_action( 'ghostpool_end_content_wrapper', 'ghostpool_add_footer_advertisement' );

/**
 * Get author name
 *
 */	
if ( ! function_exists( 'ghostpool_author_name' ) ) {
	function ghostpool_author_name( $post_id = '', $author_link = true ) {
		global $post;
		if ( get_post_meta( $post_id, '_post_submission_username', true ) ) {	
			return get_post_meta( $post_id, '_post_submission_username', true );
		} elseif ( $author_link == true ) {
			return apply_filters( 'ghostpool_author_url', '<a href="' . esc_url( get_author_posts_url( $post->post_author ) ) . '">' . get_the_author_meta( 'display_name', $post->post_author ) . '</a>', $post );
		} else {
			return get_the_author_meta( 'display_name', $post->post_author );
		}
	}
}

/**
 * Change password protect text
 *
 */	
if ( ! function_exists( 'ghostpool_password_form' ) ) {
	function ghostpool_password_form() {
		global $post;
		$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
		$o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
		<p>' . esc_html__( 'To view this protected post, enter the password below:', 'aardvark' ) . '</p>
		<label for="' . $label . '"><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" /></label> <input type="submit" class="pwsubmit" name="Submit" value="' .  esc_attr__( 'Submit', 'aardvark' ) . '" />
		</form>
		';
		return $o;
	}
}
add_filter( 'the_password_form', 'ghostpool_password_form' );

/**
 * Redirect empty search to search page
 *
 */	
if ( ! function_exists( 'ghostpool_empty_search' ) ) {
	function ghostpool_empty_search( $query ) {
		global $wp_query;
		if ( isset( $_GET['s'] ) && ( $_GET['s'] == '' ) ) {
			$wp_query->set( 's', ' ' );
			$wp_query->is_search = true;
		}
		return $query;
	}
}
add_action( 'pre_get_posts', 'ghostpool_empty_search' );

/**
 * Add lightbox class to image links
 *
 */
if ( ! function_exists( 'ghostpool_lightbox_image_link' ) ) {
	function ghostpool_lightbox_image_link( $content ) {
		if ( ghostpool_option( 'lightbox' ) != 'disabled' ) {
			if ( ghostpool_option( 'lightbox' ) == 'group_images' ) {
				$lightbox = ' data-lightbox="gallery" ';
			} else {
				$lightbox = ' data-featherlight="image" ';
			}
			$pattern = "/<a(.*?)href=('|\")(.*?).(jpg|jpeg|png|gif|bmp|ico)('|\")(.*?)>/i";
			preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER );
			foreach ( $matches as $val ) {
				$pattern = '<a' . $val[1] . 'href=' . $val[2] . $val[3] . '.' . $val[4] . $val[5] . $val[6] . '>';
				$replacement = '<a' . $val[1] . 'href=' . $val[2] . $val[3] . '.' . $val[4] . $val[5] . $lightbox . $val[6] . '>';
				$content = str_replace( $pattern, $replacement, $content );			
			}
			return $content;
		} else {
			return $content;
		}
	}	
}
add_filter( 'the_content', 'ghostpool_lightbox_image_link' );	
add_filter( 'wp_get_attachment_link', 'ghostpool_lightbox_image_link' );
add_filter( 'bbp_get_reply_content', 'ghostpool_lightbox_image_link' );

/**
 * Advanced ads background support
 *
 */
if ( ! function_exists( 'ghostpool_background_ad_selector' ) ) {
	function ghostpool_background_ad_selector() {
		return '#gp-page-wrapper';
	}
}
add_filter( 'advanced-ads-pro-background-selector', 'ghostpool_background_ad_selector' );

/**
 * TGM Plugin Activation class
 *
 */
if ( version_compare( phpversion(), '5.2.4', '>=' ) ) {
	require_once( get_template_directory() . '/lib/inc/class-tgm-plugin-activation.php' );
}

if ( ! function_exists( 'ghostpool_register_required_plugins' ) ) {
	
	function ghostpool_register_required_plugins() {

		$plugins = array(

			array(
				'name'               => esc_html__( 'Aardvark Plugin', 'aardvark' ),
				'slug'               => 'aardvark-plugin',
				'source'             => get_template_directory() . '/lib/plugins/aardvark-plugin.zip',
				'required'           => true,
				'version'            => '1.6.0.1',
			),

			array(
				'name'               => esc_html__( 'WPBakery Page Builder', 'aardvark' ),
				'slug'               => 'js_composer',
				'source'             => get_template_directory() . '/lib/plugins/js_composer.zip',
				'required'           => true,
				'version'            => '5.5.2',
			),

			array(
				'name'               => esc_html__( 'Responsive for WPBakery Page Builder', 'aardvark' ),
				'slug'               => 'vc_responsive_design',
				'source'             => get_template_directory() . '/lib/plugins/vc_responsive_design.zip',
				'required'           => true,
				'version'            => '2.3.5.1',
			),

			array(
				'name'               => esc_html__( 'LayerSlider WP', 'aardvark' ),
				'slug'               => 'LayerSlider',
				'source'             => get_template_directory() . '/lib/plugins/LayerSlider.zip',
				'required'           => false,
				'version'            => '6.7.6',
				'force_deactivation'    => true,
			),
						
			array(
				'name'   		     => esc_html__( 'Theia Sticky Sidebar', 'aardvark' ),
				'slug'   		     => 'theia-sticky-sidebar',
				'source'   		     => get_template_directory() . '/lib/plugins/theia-sticky-sidebar.zip',
				'required'   		 => false,
				'version'   		 => '1.8.0',
			),
			
			array(
				'name'      		=> esc_html__( 'Paid Membership Pro', 'aardvark' ),
				'slug'      		=> 'paid-memberships-pro',
				'required' 			=> false,
			),
			
			array(
				'name'      		=> esc_html__( 'Paid Membership Pro - BuddyPress Add On', 'aardvark' ),
				'slug'      		=> 'pmpro-buddypress',
				'required' 			=> false,
			),
			
			array(
				'name'   		     => esc_html__( 'BuddyPress', 'aardvark' ),
				'slug'   		     => 'buddypress',
				'required'   		 => false,
			),
			
			array(
				'name'      		=> esc_html__( 'BuddyPress Xprofile Custom Fields Type', 'aardvark' ),
				'slug'      		=> 'buddypress-xprofile-custom-fields-type',
				'source'   		     => get_template_directory() . '/lib/plugins/buddypress-xprofile-custom-fields-type.zip',
				'required' 			=> false,
				'version'   		 => '2.6.4',
			),

			array(
				'name'   		     => esc_html__( 'BP Profile Search', 'aardvark' ),
				'slug'   		     => 'bp-profile-search',
				'required'   		 => false,
			),
			
			array(
				'name'      		=> esc_html__( 'rtMedia', 'aardvark' ),
				'slug'      		=> 'buddypress-media',
				'required' 			=> false,
			),
			
			array(
				'name'   		     => esc_html__( 'bbPress', 'aardvark' ),
				'slug'   		     => 'bbpress',
				'required'   		 => false,
			),
												
			array(
				'name'   		     => esc_html__( 'WooCommerce', 'aardvark' ),
				'slug'   		     => 'woocommerce',
				'required'   		 => false,
			),
			
			array(
				'name'   		     => esc_html__( 'Google Captcha', 'aardvark' ),
				'slug'   		     => 'google-captcha',
				'required'   		 => false,
			),
			
			array(
				'name'   		     => esc_html__( 'Advanced Ads', 'aardvark' ),
				'slug'   		     => 'advanced-ads',
				'required'   		 => false,
			),
			
			array(
				'name'      		=> esc_html__( 'WordPress Popular Posts', 'aardvark' ),
				'slug'      		=> 'wordpress-popular-posts',
				'required' 			=> false,
			),
						
			array(
				'name'      		=> esc_html__( 'Yoast SEO', 'aardvark' ),
				'slug'      		=> 'wordpress-seo',
				'required' 			=> false,
				'is_callable'		=> 'wpseo_init',
			),

			array(
				'name'      		=> esc_html__( 'WP Live Chat Support', 'aardvark' ),
				'slug'      		=> 'wp-live-chat-support',
				'required' 			=> false,
			),

			array(
				'name'      		=> esc_html__( 'Events Manager', 'aardvark' ),
				'slug'      		=> 'events-manager',
				'required' 			=> false,
			),
																														
		);

		$config = array(
			'id'           => 'aardvark',
			'default_path' => '',
			'menu'         => 'tgmpa-install-plugins',
			'has_notices'  => true,                 
			'dismissable'  => true,                  
			'dismiss_msg'  => '',
			'is_automatic' => true,
			'message'      => '',
		);
 
		tgmpa( $plugins, $config );

	}
	
}
add_action( 'tgmpa_register', 'ghostpool_register_required_plugins' );
	
?>