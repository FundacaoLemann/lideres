<?php 

// Theme version number
define( 'AARDVARK_THEME_VERSION', '2.1' );

// Load database updates
require_once( get_template_directory() . '/lib/framework/database-updates.php' );

// Load metaboxes
require_once( get_template_directory() . '/lib/framework/metaboxes-config.php' );

// Remove Redux ads
require_once( get_template_directory() . '/lib/framework/extensions/ad_remove/extension_ad_remove.php' );

// Load Redux theme options framework
require_once( get_template_directory() . '/lib/framework/redux/framework.php' );

// Load theme options
require_once( get_template_directory() . '/lib/framework/theme-config.php' );

// Load options function
if ( ! function_exists( 'ghostpool_option' ) ) {
	function ghostpool_option( $opt_1, $opt_2 = false, $opt_3 = false, $opt_4 = false ) {
		global $ghostpool_aardvark;
		if ( $opt_4 != false ) {
			return $opt_4;
		} else {		
			if ( $opt_2 ) {
				if ( isset( $ghostpool_aardvark[$opt_1][$opt_2] ) ) {
					return $ghostpool_aardvark[$opt_1][$opt_2];
				}
			} else {
				if ( isset( $ghostpool_aardvark[$opt_1] ) ) {
					return $ghostpool_aardvark[$opt_1];
				}
			}
		}	
	}
}

// Load WPBakery page builder functions
if ( function_exists( 'vc_set_as_theme' ) ) {
	require_once( get_template_directory() . '/lib/framework/page-builder/page-builder-functions.php' );
}

/**
 * Load Redux styles and scripts
 *
 */
if ( ! function_exists( 'ghostpool_redux_enqueue' ) ) {
	function ghostpool_redux_enqueue() {

		wp_enqueue_style( 'custom-redux-theme-options', get_template_directory_uri() . '/lib/framework/css/redux-theme-options.css', array( 'redux-admin-css' ), time(), 'all' );
	
		wp_enqueue_style( 'custom-redux-metaboxes', get_template_directory_uri() . '/lib/framework/css/redux-metaboxes.css', array( 'redux-admin-css', 'redux-extension-metaboxes-css' ), time(), 'all' );

		// Deregister script so select2 is not loaded on WooCommerce product pages
		wp_deregister_script( 'redux-select2-sortable-js' );  
		if ( get_post_type() != 'product' && get_post_type() != 'course' && get_post_type() != 'lesson' ) {
			wp_register_script( 'redux-select2-sortable-js', get_template_directory_uri() . '/lib/framework/redux/assets/js/vendor/redux.select2.sortable.min.js', array( 'jquery' ), '', true );
		}  
				
	}
}
add_action( 'redux/page/ghostpool_aardvark/enqueue', 'ghostpool_redux_enqueue' );

/**
 * Add custom sidebar field
 *
 */
if ( ! function_exists( 'ghostpool_redux_data_sidebars' ) ) {
	function ghostpool_redux_data_sidebars() {		         
		global $wp_registered_sidebars;		
		$data = array();
		foreach ( $wp_registered_sidebars as $key => $value ) {
			$data[ $key ] = $value['name'];
		}
		return $data;
	}
}	
add_filter( 'redux/options/ghostpool_aardvark/data/custom_sidebars', 'ghostpool_redux_data_sidebars' );

/**
 * Add custom sidebar field with default option
 *
 */
if ( ! function_exists( 'ghostpool_redux_data_sidebars_default' ) ) {
	function ghostpool_redux_data_sidebars_default() {		         
		global $wp_registered_sidebars;
		$data = array();
		$data['default'] = esc_html__( 'Default', 'aardvark' );		
		foreach ( $wp_registered_sidebars as $key => $value ) {
			$data[ $key ] = $value['name'];
		}
		return $data;
	}
}	
add_filter( 'redux/options/ghostpool_aardvark/data/custom_sidebars_default', 'ghostpool_redux_data_sidebars_default' );

/**
 * Add custom image size data field
 *
 */
if ( ! function_exists( 'ghostpool_redux_data_image_sizes' ) ) {
	function ghostpool_redux_data_image_sizes() {
		global $_wp_additional_image_sizes;
		$output = array();
		$sizes = array();
		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				);
			}
			$name = $_size . ' (' . $sizes[ $_size ]['width'] . ' x ' . $sizes[ $_size ]['height'] . ')';
			$output[ $_size ] = $name;
		}
		return array_merge( array( 'default' => esc_html__( 'Default', 'aardvark' ) ), $output );
	}
}	
add_filter( 'redux/options/ghostpool_aardvark/data/custom_image_size', 'ghostpool_redux_data_image_sizes' );


/**
 * Change import option description text
 *
 */	 
if ( ! function_exists( 'ghostpool_import_file_description' ) ) {
	function ghostpool_import_file_description() {
		return esc_html__( 'Copy and paste the code from the back up file and click Save Changes to restore your sites options from a backup.', 'aardvark' );
	}
}
add_filter( 'redux-import-file-description', 'ghostpool_import_file_description' );

/**
 * Change import option description text
 *
 */	 
if ( ! function_exists( 'ghostpool_import_url_description' ) ) {
	function ghostpool_import_url_description() {
		return esc_html__( 'Input the export URL below and click Save Changes to to restore your sites options from a backup.', 'aardvark' );
	}
}
add_filter( 'redux-import-link-description', 'ghostpool_import_url_description' );


/**
 * Check for theme updates
 *
 */	 
if ( ! function_exists( 'ghostpool_themes_update' ) ) {
	function ghostpool_themes_update( $updates ) {
		if ( isset( $updates->checked ) ) {
			if ( ! class_exists( 'Pixelentity_Themes_Updater' ) ) {
				require_once( get_template_directory() . '/lib/framework/themes-updater/class-pixelentity-themes-updater.php' );
			}
			$username = ghostpool_option( 'tf_username' ) ? trim( ghostpool_option( 'tf_username' ) ) : null;
			$apikey   = ghostpool_option( 'tf_apikey' ) ? trim( ghostpool_option( 'tf_apikey' ) ) : null;

			$updater = new Pixelentity_Themes_Updater( $username, $apikey );
			$updates = $updater->check( $updates );
		}
		return $updates;
	}
}
add_filter( 'pre_set_site_transient_update_themes', 'ghostpool_themes_update' );

/**
 * Try to write a file using WP File system API
 *
 * @param string $file_path
 * @param string $contents
 * @param int $mode
 *
 * @return bool
 */
if ( ! function_exists( 'ghostpool_fs_put_contents' ) ) {
	function ghostpool_fs_put_contents( $file_path, $contents, $mode = '' ) {

		global $kleo_config;

		/* Frontend or customizer fallback */
		if ( ! function_exists( 'get_filesystem_method' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		if ( $mode == '' ) {
			if ( defined( 'FS_CHMOD_FILE' ) ) {
				$mode = FS_CHMOD_FILE;
			} else {
				$mode = 0644;
			}
		}

		$context                      = $kleo_config['custom_style_path'];
		$allow_relaxed_file_ownership = true;

		if ( function_exists( 'get_filesystem_method' ) && get_filesystem_method( array(), $context, $allow_relaxed_file_ownership ) === 'direct' ) {
			/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
			$creds = request_filesystem_credentials( site_url() . '/wp-admin/', '', false, $context, null, $allow_relaxed_file_ownership );

			/* initialize the API */
			if ( ! WP_Filesystem( $creds, $context, $allow_relaxed_file_ownership ) ) {
				/* any problems and we exit */
				return false;
			}

			global $wp_filesystem;
			/* do our file manipulations below */

			$wp_filesystem->put_contents( $file_path, $contents, $mode );

			return true;

		} else {
			return false;
		}
	}
}

/**
 * Try to get a file content using WP File system API
 *
 * @param $file_path
 *
 * @return bool
 */
if ( ! function_exists( 'ghostpool_fs_get_contents' ) ) {
	function ghostpool_fs_get_contents( $file_path ) {

		global $kleo_config;

		/* Frontend or customizer fallback */
		if ( ! function_exists( 'get_filesystem_method' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$context                      = $kleo_config['custom_style_path'];
		$allow_relaxed_file_ownership = true;

		if ( function_exists( 'get_filesystem_method' ) && get_filesystem_method( array(), $context, $allow_relaxed_file_ownership ) === 'direct' ) {
			/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
			$creds = request_filesystem_credentials( site_url() . '/wp-admin/', '', false, $context, null, $allow_relaxed_file_ownership );

			/* initialize the API */
			if ( ! WP_Filesystem( $creds, $context, $allow_relaxed_file_ownership ) ) {
				/* any problems and we exit */
				return false;
			}

			global $wp_filesystem;

			/* do our file manipulations below */

			return $wp_filesystem->get_contents( $file_path );

		} else {
			return false;
		}
	}
}

/**
 * Add additional Responsive Page Builder device sizes
 *
 */	
if ( ! function_exists( 'ghostpool_bbvcedo_devices_default' ) ) {
	function ghostpool_bbvcedo_devices_default() {
		return array(
			'x_large_css' => array(
				'label' => 'Default devices',
				'mediafeature' => '',
				'breakpoint' => '',
				'icon' => 'class_icon',
				'class_icon' => 'dashicons dashicons-desktop',
				'image_icon' => '',
				'order' => 1,
			),
			'large_css' => array(
				'label' => 'Large devices',
				'mediafeature' => 'max-width',
				'breakpoint' => '1199',
				'icon' => 'class_icon',
				'class_icon' => 'dashicons dashicons-laptop',
				'image_icon' => '',
				'order' => 2,
			),
			'medium_css' => array(
				'label' => 'Medium devices',
				'mediafeature' => 'max-width',
				'breakpoint' => '991',
				'icon' => 'class_icon',
				'class_icon' => 'dashicons dashicons-tablet',
				'image_icon' => '',
				'order' => 3,
			),
			'small_css' => array(
				'label' => 'Small devices',
				'mediafeature' => 'max-width',
				'breakpoint' => '767',
				'icon' => 'class_icon',
				'class_icon' => 'dashicons dashicons-image-rotate-right',
				'image_icon' => '',
				'order' => 4,
			),
			'x_small_css' => array(
				'label' => 'Extra Small devices',
				'mediafeature' => 'max-width',
				'breakpoint' => '479',
				'icon' => 'class_icon',
				'class_icon' => 'dashicons dashicons-smartphone',
				'image_icon' => '',
				'order' => 5,
			),
		);
	}
}
add_filter( 'bbvcedo_devices_default', 'ghostpool_bbvcedo_devices_default' );		
			
?>