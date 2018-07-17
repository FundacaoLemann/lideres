<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "ghostpool_aardvark";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'Theme Options', 'aardvark' ),
        'page_title'           => esc_html__( 'Theme Options', 'aardvark' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => 'AIzaSyDipV4M7FL2ylBHtJ5OvW1CSBWTyKKrP6E',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => apply_filters( 'ghostpool_redux_admin_bar', false ),
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-admin-generic',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => 'aardvark',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

	// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
	$args['share_icons'][] = array(
		'url'   => 'http://twitter.com/ghostpool',
		'title' => esc_html__( 'Follow us on Twitter', 'aardvark' ),
		'icon'  => 'el el-icon-twitter'
	);

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     *
     * ---> START SECTIONS
     *
     */
     
	Redux::setSection( $opt_name, array(
		'id' => 'general_options',
		'title' => esc_html__( 'General', 'aardvark' ),
		'desc' => esc_html__( 'General theme options.', 'aardvark' ),
		'icon' => 'el-icon-cogs',
		'fields' => array(
		
			array(  
				'id' => 'theme_layout',
				'title' => esc_html__( 'Theme Layout', 'aardvark' ),
				'type' => 'button_set',
				'options'   => array(
					'gp-wide-layout' => esc_html__( 'Wide', 'aardvark' ),
					'gp-boxed-layout' => esc_html__( 'Boxed', 'aardvark' ),
				), 
				'default'   => 'gp-wide-layout',
				'required' => array( 'header_layout', '!=', 'gp-header-side-menu' ),					
			),

			array(  
				'id' => 'sidebar_display',
				'title' => esc_html__( 'Sidebar Display', 'aardvark' ),
				'type' => 'radio',
				'options' => array(
					'gp-sidebar-all' => esc_html__( 'Show on all devices', 'aardvark' ),
					'gp-sidebar-desktop' => esc_html__( 'Only show on desktop devices', 'aardvark' )
				),
				'default' => 'gp-sidebar-desktop',
			),

			array(  
				'id' => 'page_loader',
				'title' => esc_html__( 'Page Loader', 'aardvark' ),
				'desc' => esc_html__( 'Display a loading icon until the page has loaded all content.', 'aardvark' ),
				'type' => 'button_set',
				'options'   => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				), 'default'   => 'enabled'						
			),
			
			array(  
				'id' => 'back_to_top',
				'title' => esc_html__( 'Back To Top Button', 'aardvark' ),
				'type' => 'radio',
				'options' => array(
					'gp-back-to-top-all' => esc_html__( 'Show on all devices', 'aardvark' ),
					'gp-back-to-top-desktop' => esc_html__( 'Only show on desktop devices', 'aardvark' ),
					'gp-no-back-to-top' => esc_html__( 'Disabled', 'aardvark' )
				),
				'default' => 'gp-back-to-top-desktop',
			),
			 
			array(  
				'id' => 'ajax',
				'title' => esc_html__( 'Ajax', 'aardvark' ),
				'desc' => esc_html__( 'Load and filter content dynamically using ajax.', 'aardvark' ),
				'type' => 'button_set',
				'options'   => array(
					'gp-ajax-loop' => esc_html__( 'Enabled', 'aardvark' ),
					'gp-standard-loop' => esc_html__( 'Disabled', 'aardvark' ),
				), 'default'   => 'gp-ajax-loop'						
			),

			array(
				'id'        => 'lightbox',
				'type'      => 'radio',
				'title'     => esc_html__( 'Lightbox', 'aardvark' ),
				'subtitle' => esc_html__( 'Make sure the images open the media file and not the attachment page.', 'aardvark' ),'options'   => array(
					'group_images' => esc_html__( 'All images on page show as gallery within lightbox window', 'aardvark' ),
					'separate_images' => esc_html__( 'Images are not grouped', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'group_images',
			),
				
			array( 
				'id' => 'js_code',
				'type' => 'ace_editor',
				'title' => esc_html__( 'JS Code', 'aardvark' ),
				'subtitle' => esc_html__( 'Paste your JS code here.', 'aardvark' ),
				'desc' => esc_html__( 'Scripts that need to be embedded into the theme (e.g. Google Analytics).', 'aardvark' ),
				'mode' => 'javascript',
				'theme' => 'chrome',
				'default' => '',				
			 ),
							
		),
	
	) );

	
	Redux::setSection( $opt_name, array(
		'id' => 'membership_options',
		'title' => esc_html__( 'Membership', 'aardvark' ),
		'desc' => esc_html__( 'Options for the membership.', 'aardvark' ),
		'icon' => 'el-icon-user',
		'fields' => array(
					
			array(  
				'id' => 'login_register_popup_redirect',
				'title' => esc_html__( 'Login/Register Popup Window', 'aardvark' ),
				'subtitle' => esc_html__( 'Add "#login", "#register" and "#lost-password" to the end of your URL e.g. http://domain.com/#login', 'aardvark' ),
				'desc' => esc_html__( 'Show the login/register popup window.', 'aardvark' ),
				'type' => 'button_set',
				'options'   => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				), 
				'default'   => 'enabled'						
			),

			array(  
				'id' => 'login_redirect',
				'title' => esc_html__( 'Login Redirect', 'aardvark' ),
				'desc' => esc_html__( 'Redirect the user to this page after logging in, leave empty to redirect to the page they logged in from.', 'aardvark' ),
				'type' => 'select',
				'data' => 'pages',
			),
			
			array(  
				'id' => 'login_register_popup_backend_redirect',
				'title' => esc_html__( 'Backend Login/Register Popup Window', 'aardvark' ),
				'desc' => esc_html__( 'Redirect to the homepage and show the login/register popup window before users can access the backend.', 'aardvark' ),
				'type' => 'button_set',
				'options'   => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				), 
				'default'   => 'enabled',				
			),	
			
			array(  
				'id' => 'login_register_page_redirect',
				'title' => esc_html__( 'Restrict Frontend Access', 'aardvark' ),
				'desc' => esc_html__( 'Redirect non logged in users to this page before they can access the site (e.g. login page).', 'aardvark' ),
				'type' => 'select',
				'data' => 'pages',
			),

			array(  
				'id' => 'login_register_page_redirect_exclusion',
				'title' => esc_html__( 'Frontend Redirect Exclusion', 'aardvark' ),
				'desc' => esc_html__( 'Exclude specific pages from the frontend redirection.', 'aardvark' ),
				'type' => 'select',
				'multi' => true,
				'data' => 'pages',
			),
					
			array(  
				'id' => 'login_register_page_backend_redirect',
				'title' => esc_html__( 'Restrict Backend Access', 'aardvark' ),
				'desc' => esc_html__( 'Redirect non logged in users to this page before they can access the backend (e.g. login page). ', 'aardvark' ),
				'type' => 'select',
				'data' => 'pages',
				'required' => array( 'login_register_popup_backend_redirect', '=', 'disabled' ),
			),

			array(  
				'id' => 'members_homepage',
				'title' => esc_html__( 'Members Homepage', 'aardvark' ),
				'desc' => esc_html__( 'The homepage members see.', 'aardvark' ),
				'subtitle' => esc_html__( 'To set the homepage for non logged in users click', 'aardvark' ) . ' <a href="' . admin_url( 'options-reading.php' ) .'" target="_blank">' . esc_html__( 'here', 'aardvark' ) . '</a> and ' . esc_html__( 'install the Paid Memberships Pro plugin to set the homepage for different membership levels.', 'aardvark' ),
				'type' => 'select',
				'data'    => 'pages',
			),

			array(  
				'id' => 'registration_gdpr',
				'title' => esc_html__( 'Registration Privacy Policy Checkbox (GDPR)', 'aardvark' ),
				'desc' => esc_html__( 'Add a privacy policy checkbox to the theme\'s registration form (this does not add a checkbox to the BuddyPress or Paid Membership Pro registration pages).', 'aardvark' ),
				'type' => 'button_set',
				'options'   => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				), 
				'default'   => 'disabled',
			),
			
			array(  
				'id' => 'registration_gdpr_text',
				'title' => esc_html__( 'Registration Privacy Policy Text', 'aardvark' ),
				'desc' => esc_html__( 'Add your own privacy policy text next to the checkbox.', 'aardvark' ),
				'subtitle' => esc_html__( 'To add a link within your text use HTML tags e.g. "This is my text and this is a <a href="http://domain.com/privacy-policy">link</a>."', 'aardvark' ),
				'type' => 'textarea',
				'required' => array( 'registration_gdpr', '=', 'enabled' ),
			),
							
		),
	
	) );
						
	Redux::setSection( $opt_name, array(
		'id' => 'header_options',
		'title' => esc_html__( 'Header', 'aardvark' ),
		'desc' => esc_html__( 'Options for the header.', 'aardvark' ),
		'icon' => 'el-icon-website',
		'fields' => array(								 

			array( 
				'id' => 'header_layout',
				'title' => esc_html__( 'Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array( 
					'gp-header-logo-left-1' => array( 'title' => esc_html__( 'Header 1', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-1.jpg' ),
					'gp-header-logo-left-2' => array( 'title' => esc_html__( 'Header 2', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-2.jpg' ),
					'gp-header-logo-right-1' => array( 'title' => esc_html__( 'Header 3', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-right-1.jpg' ),
					'gp-header-nav-bottom-1' => array( 'title' => esc_html__( 'Header 4', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-1.jpg' ),
					'gp-header-nav-bottom-2' => array( 'title' => esc_html__( 'Header 5', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-2.jpg' ),
					'gp-header-nav-bottom-3' => array( 'title' => esc_html__( 'Header 6', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-3.jpg' ),
					'gp-header-side-menu' => array( 'title' => esc_html__( 'Header 7', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/side-menu.jpg' ),
				),
				'default' => 'gp-header-logo-left-1',
			),		

			array(  
				'id' => 'header_search_bar',
				'title' => esc_html__( 'Search Bar', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'disabled',
				//'required' => array( 'header_layout', '=', array( 'gp-header-nav-bottom-1', 'gp-header-nav-bottom-2', 'gp-header-nav-bottom-3' ) ),
			),
			
			array( 
				'id' => 'header_display',
				'title' => esc_html__( 'Header Display', 'aardvark' ),
				'type' => 'button_set',
				'options' => array( 
					'gp-header-above-content' => esc_html__( 'Above Content', 'aardvark' ),
					'gp-header-over-content' => esc_html__( 'Over Content', 'aardvark' ),
					'gp-header-disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'gp-header-above-content',
			),
											 
			array(  
				'id' => 'fixed_header',
				'title' => esc_html__( 'Fixed Header', 'aardvark' ),
				'type' => 'radio',
				'options' => array(
					'gp-fixed-header-all' => esc_html__( 'Show on all devices', 'aardvark' ),
					'gp-fixed-header-desktop' => esc_html__( 'Only show on desktop devices', 'aardvark' ),
					'gp-relative-header' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'gp-fixed-header-all',
			),

			array(
				'id' => 'scroll_to_fixed_header',
				'title' => esc_html__( 'Scroll To Fixed Header', 'aardvark' ),
				'desc' => esc_html__( 'The amount of pixels to scroll before fixing the header.', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'mode' => false,
				'default'       => array(
					'height'    => '200px',
				)
			),
						
			array( 
				'id' => 'header_width',
				'title' => esc_html__( 'Width', 'aardvark' ),
				'type' => 'button_set',
				'options' => array( 'gp-header-wide' => esc_html__( 'Wide', 'aardvark' ),
					'gp-header-boxed' => esc_html__( 'Boxed', 'aardvark' ),
				),
				'default' => 'gp-header-boxed',
				'required' => array( 
					array( 'theme_layout', '=', 'gp-wide-layout' ),
					array( 'header_layout', '!=', 'gp-header-side-menu' ),	
				),
			),
						
			array(
				'id' => 'desktop_header_height',
				'title' => esc_html__( 'Desktop Header Height', 'aardvark' ),
				'desc' => esc_html__( 'The height of the header on larger devices.', 'aardvark' ),
				'output' => '.gp-header-logo-left-1 #gp-standard-header .gp-logo, .gp-header-logo-left-2 #gp-standard-header .gp-logo, .gp-header-logo-right-1 #gp-standard-header .gp-logo, .gp-header-side-menu #gp-standard-header, .gp-nav-column, #gp-standard-header #gp-header-row-1',
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'mode' => false,
				'default'       => array(
					'height'    => '90px',
				)
			),
				
			array(
				'id' => 'desktop_header_nav_height',
				'title' => esc_html__( 'Desktop Navigation Height', 'aardvark' ),
				'desc' => esc_html__( 'The height of the navigation below the logo on larger devices.', 'aardvark' ),
				'output' => '#gp-standard-header #gp-header-row-2',
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'mode' => false,
				'default'           => array(
					'height'    => '60px',
				),
				//'required' => array( 'header_layout', '=', array( 'gp-header-nav-bottom-1', 'gp-header-nav-bottom-2', 'gp-header-nav-bottom-3' ) ),
			),
			
			array(
				'id' => 'desktop_scrolling_header_height',
				'title' => esc_html__( 'Desktop Scrolling Header Height', 'aardvark' ),
				'desc' => esc_html__( 'The height of the header on larger devices when scrolling.', 'aardvark' ),
				'output' => '.gp-header-logo-left-1.gp-scrolling #gp-standard-header .gp-logo,.gp-header-logo-left-2.gp-scrolling #gp-standard-header .gp-logo,.gp-header-logo-right-1.gp-scrolling #gp-standard-header .gp-logo,.gp-scrolling .gp-nav-column,.gp-scrolling #gp-standard-header #gp-header-row-1',
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'mode' => false,
				'default'           => array(
					'height'    => '90px',
				),
				'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
			),
	
			array(
				'id' => 'side_menu_header_height',
				'title' => esc_html__( 'Side Menu Header Height', 'aardvark' ),
				'desc' => esc_html__( 'The height of the header in the side menu.', 'aardvark' ),
				'output' => '.gp-header-side-menu #gp-side-menu-logo',
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'mode' => false,
				'default'       => array(
					'height'    => '90px',
				),
				//array( 'header_layout', '=', 'gp-header-side-menu' ),
			),			

			array(
				'id' => 'desktop_scrolling_header_nav_height',
				'title' => esc_html__( 'Desktop Scrolling Navigation Height', 'aardvark' ),
				'desc' => esc_html__( 'The height of the navigation below the logo on larger devices when scrolling.', 'aardvark' ),
				'output' => '.gp-scrolling #gp-standard-header #gp-header-row-2',
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'mode' => false,
				'default'           => array(
					'height'    => '60px',
				),
				//'required' => array( 'header_layout', '=', array( 'gp-header-nav-bottom-1', 'gp-header-nav-bottom-2', 'gp-header-nav-bottom-3' ) ),
			),
						
			array(
				'id' => 'mobile_header_height',
				'title' => esc_html__( 'Mobile Header Height', 'aardvark' ),
				'desc' => esc_html__( 'The height of the header on mobile and smaller tablet devices.', 'aardvark' ),
				'output' => '#gp-mobile-header > .gp-container',
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'mode' => false,
				'default'           => array(
					'height'    => '90px',
				)
			),
			
			$fields = array(
			   'id' => 'logo_section_begin',
			   'type' => 'section',
			   'title' => esc_html__( 'Logo', 'aardvark' ),
				'subtitle' => esc_html__( 'The logo displayed in the header.', 'aardvark' ),
			   'indent' => true,
		   ),
						
							
				array( 
				'id' => 'logo',
					'title' => esc_html__( 'Standard Logo', 'aardvark' ),						
					'type' => 'media',
					'default'  => array(
						'url' => get_template_directory_uri() . '/lib/images/original/logo.png',
					),
				 ),
							
				array( 
				'id' => 'logo_retina',
					'title' => esc_html__( 'Retina Logo', 'aardvark' ),						
					'type' => 'media',
					'default'  => array(
						'url' => get_template_directory_uri() . '/lib/images/original/logo-retina.png',
					),
				 ),
			 array(
					'id' => 'logo_dimensions',
					'type' => 'dimensions',
					'units' => 'px',
					'title' => esc_html__( 'Dimensions', 'aardvark' ),
					'desc' => esc_html__( 'The width and height of the standard logo.', 'aardvark' ),
					'default'           => array(
						'width'     => '117',
						'height'    => '24',
					),
				),
			
			array(
				'id'     => 'logo_section_end',
				'type'   => 'section',
				'indent' => false,
			),

			$fields = array(
			   'id' => 'logo_scrolling_section_begin',
			   'type' => 'section',
			   'title' => esc_html__( 'Scrolling Logo', 'aardvark' ),
				'subtitle' => esc_html__( 'Use a different logo when scrolling.', 'aardvark' ),
			   'indent' => true,
				'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
		   ),
		   array( 
				'id' => 'logo_scrolling',
					'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
					'title' => esc_html__( 'Standard Logo', 'aardvark' ),			
					'type' => 'media',
					'default'  => array(
						'url' => '',
					),
				 ),

				array( 
				'id' => 'logo_scrolling_retina',
					'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
					'title' => esc_html__( 'Retina Logo', 'aardvark' ),			
					'type' => 'media',
					'default'  => array(
						'url' => '',
					),
				 ),
			 array(
					'id' => 'logo_scrolling_dimensions',
					'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
					'type' => 'dimensions',
					'units' => 'px',
					'title' => esc_html__( 'Dimensions', 'aardvark' ),
					'desc' => esc_html__( 'The width and height of the standard logo.', 'aardvark' ),
					'default'           => array(
						'width'     => '', 		'height'    => '',
					)
				),
			
			array(
				'id'     => 'logo_scrolling_section_end',
				'type'   => 'section',
				'indent' => false,
				'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
			),

			$fields = array(
			   'id' => 'logo_overlay_section',
			   'type' => 'section',
			   'title' => esc_html__( 'Overlay Logo', 'aardvark' ),
				'subtitle' => esc_html__( 'Use a different logo when the header is overlaying content.', 'aardvark' ),
			   'indent' => true,
		   ),
		   array( 
				'id' => 'logo_overlay',
					'title' => esc_html__( 'Standard Logo', 'aardvark' ),			
					'type' => 'media',
					'default'  => array(
						'url' => '',
					),
				 ),
			 array( 
				'id' => 'logo_overlay_retina',
					'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
					'title' => esc_html__( 'Retina Logo', 'aardvark' ),			
					'type' => 'media',
					'default'  => array(
						'url' => '',
					),
				 ),
			 array(
					'id' => 'logo_overlay_dimensions',
					'type' => 'dimensions',
					'units' => 'px',
					'title' => esc_html__( 'Dimensions', 'aardvark' ),
					'desc' => esc_html__( 'The width and height of the standard logo.', 'aardvark' ),
					'default'           => array(
						'width'     => '', 		'height'    => '',
					)
				),
			
			array(
				'id'     => 'logo_overlay_section_end',
				'type'   => 'section',
				'indent' => false,
			),

			$fields = array(
			   'id' => 'mobile_logo_section_begin',
			   'type' => 'section',
			   'title' => esc_html__( 'Mobile Logo', 'aardvark' ),
				'subtitle' => esc_html__( 'Use a different logo on smaller devices.', 'aardvark' ),
			   'indent' => true,
		   ),
		   						
				array( 
				'id' => 'mobile_logo',
					'title' => esc_html__( 'Standard Logo', 'aardvark' ),						
					'type' => 'media',
					'default'  => array(
						'url' => '',
					),
				 ),
			
				array( 
				'id' => 'mobile_logo_retina',
					'title' => esc_html__( 'Retina Logo', 'aardvark' ),						
					'type' => 'media',
					'default'  => array(
						'url' => '',
					),
				 ),

				array(
					'id' => 'mobile_logo_dimensions',
					'type' => 'dimensions',
					'units' => 'px',
					'title' => esc_html__( 'Dimensions', 'aardvark' ),
					'desc' => esc_html__( 'The width and height of the standard logo.', 'aardvark' ),
					'default'           => array(
						'width'     => '', 		'height'    => '',
					)
				),
			
			array(
				'id'     => 'mobile_logo_section_end',
				'type'   => 'section',
				'indent' => false,
			),
			
			$fields = array(
			   'id' => 'mobile_logo_scrolling_section_begin',
			   'type' => 'section',
			   'title' => esc_html__( 'Mobile Scrolling Logo', 'aardvark' ),
				'subtitle' => esc_html__( 'Use a different logo when scrolling on smaller devices.', 'aardvark' ),
			   'indent' => true,
				'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
		   ),
		   array( 
				'id' => 'mobile_logo_scrolling',
					'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
					'title' => esc_html__( 'Standard Logo', 'aardvark' ),			
					'type' => 'media',
					'default'  => array(
						'url' => '',
					),
				 ),

				array( 
				'id' => 'mobile_logo_scrolling_retina',
					'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
					'title' => esc_html__( 'Retina Logo', 'aardvark' ),			
					'type' => 'media',
					'default'  => array(
						'url' => '',
					),
				 ),
			 array(
					'id' => 'mobile_logo_scrolling_dimensions',
					'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
					'type' => 'dimensions',
					'units' => 'px',
					'title' => esc_html__( 'Dimensions', 'aardvark' ),
					'desc' => esc_html__( 'The width and height of the standard logo.', 'aardvark' ),
					'default'           => array(
						'width'     => '', 		'height'    => '',
					)
				),
			
			array(
				'id'     => 'mobile_logo_scrolling_section_end',
				'type'   => 'section',
				'indent' => false,
				'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
			),

			$fields = array(
			   'id' => 'mobile_logo_overlay_section_begin',
			   'type' => 'section',
			   'title' => esc_html__( 'Mobile Overlay Logo', 'aardvark' ),
				'subtitle' => esc_html__( 'Use a different logo when the header is overlaying content on smaller devices.', 'aardvark' ),
			   'indent' => true,
		   ),
		   						
				array( 
				'id' => 'mobile_logo_overlay',
					'title' => esc_html__( 'Standard Logo', 'aardvark' ),						
					'type' => 'media',
					'default'  => array(
						'url' => '',
					),
				 ),
			
				array( 
				'id' => 'mobile_logo_overlay_retina',
					'title' => esc_html__( 'Retina Logo', 'aardvark' ),						
					'type' => 'media',
					'default'  => array(
						'url' => '',
					),
				 ),

				array(
					'id' => 'mobile_logo_overlay_dimensions',
					'type' => 'dimensions',
					'units' => 'px',
					'title' => esc_html__( 'Dimensions', 'aardvark' ),
					'desc' => esc_html__( 'The width and height of the standard logo.', 'aardvark' ),
					'default'       => array(
						'width'     => '', 		'height'    => '',
					)
				),
			
			array(
				'id'     => 'mobile_logo_overlay_section_end',
				'type'   => 'section',
				'indent' => false,
			),
						
			array( 
				'id' => 'text_logo',
				'title' => esc_html__( 'Text Logo', 'aardvark' ),
				'subtitle' => esc_html__( 'Adding a text logo will remove any image logos.', 'aardvark' ),				
				'type' => 'text',
				'default'  => '',
			),

			array(  
				'id' => 'cart_button',
				'title' => esc_html__( 'Cart Button', 'aardvark' ),
				'type' => 'radio',
				'options' => array(
					'gp-cart-button-all' => esc_html__( 'Show on all devices', 'aardvark' ),
					'gp-cart-button-desktop' => esc_html__( 'Only show on desktop devices', 'aardvark' ),
					'gp-cart-button-mobile' => esc_html__( 'Only show on mobile devices', 'aardvark' ),
					'gp-cart-button-disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'gp-cart-button-all',
			),
			
			array(  
				'id' => 'search_button',
				'title' => esc_html__( 'Search Button', 'aardvark' ),
				'type' => 'radio',
				'options' => array(
					'gp-search-button-all' => esc_html__( 'Show on all devices', 'aardvark' ),
					'gp-search-button-desktop' => esc_html__( 'Only show on desktop devices', 'aardvark' ),
					'gp-search-button-mobile' => esc_html__( 'Only show on mobile devices', 'aardvark' ),
					'gp-search-button-disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'gp-search-button-all',
			),
												 
			array(  
				'id' => 'profile_button',
				'title' => esc_html__( 'Profile Button', 'aardvark' ),
				'type' => 'radio',
				'options' => array(
					'gp-profile-button-all' => esc_html__( 'Show on all devices', 'aardvark' ),
					'gp-profile-button-desktop' => esc_html__( 'Only show on desktop devices', 'aardvark' ),
					'gp-profile-button-mobile' => esc_html__( 'Only show on mobile devices', 'aardvark' ),
					'gp-profile-button-disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'gp-profile-button-all',
			),	
			
			array(  
				'id' => 'top_header',
				'title' => esc_html__( 'Top Header', 'aardvark' ),
				'type' => 'radio',
				'desc' => esc_html__( 'Shown above the main header.', 'aardvark' ),	
				'options' => array(
					'gp-top-header-all' => esc_html__( 'Show on all devices', 'aardvark' ),
					'gp-top-header-desktop' => esc_html__( 'Only show on desktop devices', 'aardvark' ),
					'gp-top-header-mobile' => esc_html__( 'Only show on mobile devices', 'aardvark' ),
					'gp-top-header-disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'gp-top-header-disabled',
			),			

			array( 
				'id' => 'hide_move_primary_menu_links',
				'title' => esc_html__( 'Hide/Move Primary Navigation Menu Links', 'aardvark' ),
				'desc' => esc_html__( 'If you have too many menu links in the primary navigation area, automatically hide and move them to a dropdown menu.', 'aardvark' ),	
				'type' => 'button_set',
				'options' => array( 
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'enabled',
			),
																											
		),
			
	) );
	

	Redux::setSection( $opt_name, array(
		'id' => 'footer_options',
		'title' => esc_html__( 'Footer', 'aardvark' ),
		'desc' => esc_html__( 'Options for the footer.', 'aardvark' ),
		'icon' => 'el-icon-photo',
		'fields' => array(
		
			array( 
				'id' => 'footer_display',
				'title' => esc_html__( 'Footer Display', 'aardvark' ),
				'type' => 'button_set',
				'options' => array( 
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'enabled',
			),

			array( 
				'id' => 'footer_width',
				'required' => array( 'theme_layout', '=', 'gp-wide-layout' ),
				'title' => esc_html__( 'Width', 'aardvark' ),
				'type' => 'button_set',
				'options' => array( 'gp-footer-wide' => esc_html__( 'Wide', 'aardvark' ),
					'gp-footer-boxed' => esc_html__( 'Boxed', 'aardvark' ),
				),
				'default' => 'gp-footer-boxed',
			),
			
			$fields = array(
			   'id' => 'footer_image_section_begin',
			   'type' => 'section',
			   'title' => esc_html__( 'Footer Image', 'aardvark' ),
			   'indent' => true,
		   ),
					   			
				array( 
				'id' => 'footer_image',
					'title' => esc_html__( 'Standard Image', 'aardvark' ),						
					'type' => 'media',
					'default'  => array(
						'url' => get_template_directory_uri() . '/lib/images/original/logo.png',
					),
				 ),

				array( 
				'id' => 'footer_image_retina',
					'title' => esc_html__( 'Retina Image', 'aardvark' ),						
					'type' => 'media',
					'default'  => array(
						'url' => get_template_directory_uri() . '/lib/images/original/logo-retina.png',
					),
				 ),
						
				array(
					'id' => 'footer_image_dimensions',
					'type' => 'dimensions',
					'units' => 'px',
					'title' => esc_html__( 'Dimensions', 'aardvark' ),
					'default' => array(
						'width'     => 117, 		
						'height'    => 24,				
					),
				),
									
				array(
					'id' => 'footer_image_spacing',
					'type' => 'spacing',
					'output' => array( '#gp-footer-image img' ),
					'mode' => 'margin',
					'units' => 'px',
					'title' => esc_html__( 'Spacing', 'aardvark' ),
					'default'       => array(
						'margin-top'    => '0', 		
						'margin-right'  => '0', 		
						'margin-bottom' => '0', 		
						'margin-left'   => '0',
					)
				),

			
			array(
				'id'     => 'footer_image_section_end',
				'type'   => 'section',
				'indent' => false,
			),

			array( 
				'id' => 'copyright_display',
				'title' => esc_html__( 'Copyright Display', 'aardvark' ),
				'type' => 'button_set',
				'options' => array( 
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'enabled',
			),
															
			array( 
				'id' => 'copyright_text',
				'title' => esc_html__( 'Copyright Text', 'aardvark' ),
				'type' => 'textarea',
				'required' => array( 'copyright_display', 'equals', 'enabled' ),
			),

			array(  
				'id' => 'footer_widgets_display',
				'title' => esc_html__( 'Footer Widgets Display', 'aardvark' ),
				'type' => 'radio',
				'options' => array(
					'gp-footer-widgets-all' => esc_html__( 'Show on all devices', 'aardvark' ),
					'gp-footer-widgets-desktop' => esc_html__( 'Only show on desktop devices', 'aardvark' )
				),
				'default' => 'gp-footer-widgets-desktop',
			),
							
		),
		
	) );
		

	Redux::setSection( $opt_name, array(
		'id' => 'post_options',
		'title' => esc_html__( 'Posts', 'aardvark' ),
		'desc' => esc_html__( 'Global options for all posts (some options can be overridden on individual posts).', 'aardvark' ),
		'icon' => 'el-icon-pencil',
		'fields' => array(
			
			array( 
				'id' => 'post_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),
			
			array( 
				'id' => 'post_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'default'       => array(
					'height' => '320px',
				)		
			),
														
			array( 
				'id' => 'post_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),					
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-right-sidebar',
			),
			
			array(
				'id'      => 'post_left_sidebar',
				'type'    => 'select',
				'required' => array( 'post_layout', 'equals', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'post_right_sidebar',
				'type'    => 'select',
				'required' => array( 'post_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),

			array(  
				'id' => 'post_image',
				'title' => esc_html__( 'Featured Image', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'enabled',
			),
										
			array(
				'id'        => 'post_meta',
				'type'      => 'checkbox',
				'title'     => esc_html__( 'Post Meta', 'aardvark' ),
				'options'   => array(
					'author' => esc_html__( 'Author Name', 'aardvark' ),
					'date' => esc_html__( 'Post Date', 'aardvark' ),
					'comment_count' => esc_html__( 'Comment Count', 'aardvark' ),
					'views' => esc_html__( 'Views', 'aardvark' ),
					'likes' => esc_html__( 'Likes', 'aardvark' ),
					'cats' => esc_html__( 'Categories', 'aardvark' ),
					'tags' => esc_html__( 'Post Tags', 'aardvark' ),
					'share_icons' => esc_html__( 'Share Icons', 'aardvark' ),
					'post_nav' => esc_html__( 'Post Navigation', 'aardvark' ),
				),
				'default'   => array(
					'author' => '1',
					'date' => '1',
					'comment_count' => '1',
					'views' => '1',
					'likes' => '1',
					'cats' => '0',
					'tags' => '1',
					'post_nav' => '1',
					'share_icons' => '1',
				)
			),

			array(  
				'id' => 'post_voting',
				'title' => esc_html__( 'Vote Up/Down', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'enabled',
			),
			
			array(
				'id'        => 'post_voting_title',
				'type'      => 'text',
				'required'  => array( 'post_voting', '=', 'enabled' ),
				'title'     => esc_html__( 'Vote Up/Down Title', 'aardvark' ),
				'default'   => esc_html__( 'Have your say!', 'aardvark' ),
			),
																   
			array(  
				'id' => 'post_author_info',
				'title' => esc_html__( 'Author Info Panel', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'enabled',
			),

			array(  
				'id' => 'post_related_items',
				'title' => esc_html__( 'Related Items', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'enabled',
			),
						
		),			
	) );
	

	Redux::setSection( $opt_name, array(
		'id' => 'post_category_options',
		'title' => esc_html__( 'Post Categories', 'aardvark' ),
		'desc' => esc_html__( 'Global options for all post categories (some options can be overridden on individual post categories or by using the Blog page template).', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-folder-open',
		'fields' => array(	

			array( 
				'id' => 'cat_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array( 
				'id' => 'cat_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'default'       => array(
					'height' => '320px',
				)		
			 ),
			 										
			array( 
				'id' => 'cat_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-right-sidebar',
			),
			
			array(
				'id'      => 'cat_left_sidebar',
				'type'    => 'select',
				'required' => array( 'cat_layout', '=', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'cat_right_sidebar',
				'type'    => 'select',
				'required' => array( 'cat_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),
			
			array( 
				'id' => 'cat_format',
				'title' => esc_html__( 'Format', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-posts-list' => esc_html__( 'List', 'aardvark' ),
					'gp-posts-large' => esc_html__( 'Large', 'aardvark' ),
					'gp-posts-columns-2' => esc_html__( '2 Columns', 'aardvark' ),
					'gp-posts-columns-3' => esc_html__( '3 Columns', 'aardvark' ),
					'gp-posts-columns-4' => esc_html__( '4 Columns', 'aardvark' ),
					'gp-posts-masonry' => esc_html__( 'Masonry', 'aardvark' ),
				),
				'default' => 'gp-posts-list',
			),
						
			array( 
				'id' => 'cat_style',
				'title' => esc_html__( 'Style', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-style-classic' => esc_html__( 'Classic', 'aardvark' ),
					'gp-style-modern' => esc_html__( 'Modern', 'aardvark' ),
				),
				'default' => 'gp-style-classic',
			),						
						
			array( 
				'id' => 'cat_alignment',
				'title' => esc_html__( 'Content Alignment', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-align-left' => esc_html__( 'Left Aligned', 'aardvark' ),
					'gp-align-center' => esc_html__( 'Center Aligned', 'aardvark' ),
				),
				'default' => 'gp-align-left',
			),
			
			array(  
				'id' => 'cat_orderby',
				'title' => esc_html__( 'Order By', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'newest' => esc_html__( 'Newest', 'aardvark' ),
					'oldest' => esc_html__( 'Oldest', 'aardvark' ),
					'title_az' => esc_html__( 'Title (A-Z)', 'aardvark' ),
					'title_za' => esc_html__( 'Title (Z-A)', 'aardvark' ),
					'comment_count' => esc_html__( 'Most Comments', 'aardvark' ),
					'views' => esc_html__( 'Most Views', 'aardvark' ),
					'likes' => esc_html__( 'Most Likes', 'aardvark' ),
					'menu_order' => esc_html__( 'Menu Order', 'aardvark' ),
					'rand' => esc_html__( 'Random', 'aardvark' ),
				),
				'default' => 'newest',
			),
			
			array(
				'id'       => 'cat_per_page',
				'type'     => 'spinner',
				'title'    => esc_html__( 'Items Per Page', 'aardvark' ),
				'min' => 1,
				'max' => 999999,
				'default' => 9,
			),
			
			array(
				'id'       => 'cat_image_size',
				'title'    => esc_html__( 'Image Size', 'aardvark' ),
				'type'     => 'select',
				'data' => 'custom_image_size',
				'desc' => esc_html__( 'Choose from one of the default image sizes or you can register your own image size as explained', 'aardvark' ) . ' <a href="' . esc_url( 'https://ghostpool.ticksy.com/article/10923' ) . '" target="_blank">'. esc_html__( 'here', 'aardvark' ) . '</a>.',
				'default' => 'default',
			),
							
			array( 
				'id' => 'cat_content_display',
				'title' => esc_html__( 'Content Display', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'excerpt' => esc_html__( 'Excerpt', 'aardvark' ),
					'full_content' => esc_html__( 'Full Content', 'aardvark' ),
				),
				'default' => 'excerpt',
			),
		
			array( 
				'id' => 'cat_excerpt_length',
				'title' => esc_html__( 'Excerpt Length', 'aardvark' ),
				'required'  => array( 'cat_content_display', '=', 'excerpt' ),
				'type' => 'spinner',
				'desc' => esc_html__( 'The number of characters in excerpts.', 'aardvark' ),
				'min' => 0,
				'max' => 999999,
				'default' => '200',
			),

			array(
				'id'        => 'cat_meta',
				'type'      => 'checkbox',
				'title'     => esc_html__( 'Post Meta', 'aardvark' ),
				'options'   => array(
					'author' => esc_html__( 'Author Name', 'aardvark' ),
					'date' => esc_html__( 'Post Date', 'aardvark' ),
					'comment_count' => esc_html__( 'Comment Count', 'aardvark' ),
					'views' => esc_html__( 'Views', 'aardvark' ),
					'likes' => esc_html__( 'Likes', 'aardvark' ),
					'cats' => esc_html__( 'Categories', 'aardvark' ),
					'tags' => esc_html__( 'Post Tags', 'aardvark' ),
				),
				'default'   => array(
					'author' => '1',
					'date' => '1', 'comment_count' => '1',
					'views' => '0',
					'likes' => '0',
					'cats' => '0',
					'tags' => '0',
				)
			),
							
			array(
				'id'        => 'cat_filters',
				'type'      => 'checkbox',
				'title'     => esc_html__( 'Filters (Sorting)', 'aardvark' ),
				'options'   => array(
					'date' => esc_html__( 'Date', 'aardvark' ),
					'title' => esc_html__( 'Title', 'aardvark' ),
					'comment_count' => esc_html__( 'Comment Count', 'aardvark' ),
					'views' => esc_html__( 'Views', 'aardvark' ),
					'likes' => esc_html__( 'Likes', 'aardvark' ),
				),
				'default'   => array(
					'date' => '0',
					'title' => '0',
					'comment_count' => '0',
					'views' => '0',
					'likes' => '0',
				),
			),
										  
			array(  
				'id' => 'cat_read_more_link',
				'title' => esc_html__( 'Read More Link', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'disabled',
			),

			array(  
				'id' => 'cat_pagination',
				'title' => esc_html__( 'Pagination', 'aardvark' ),
				'type' => 'select',
				'desc' => esc_html__( 'Filters disabled if using load more button.', 'aardvark' ),
				'options' => array(
					'load-more' => esc_html__( 'Load More Button', 'aardvark' ),
					'page-numbers' => esc_html__( 'Page Numbers', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'page-numbers',
			),
			
		),						   
	) );


	Redux::setSection( $opt_name, array(
		'id' => 'search_results_options',
		'title' => esc_html__( 'Search Results', 'aardvark' ),
		'desc' => esc_html__( 'Global options for search results.', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-search',
		'fields' => array(	

			array( 
				'id' => 'search_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array(
				'id' => 'search_page_header_bg', 
				'title' => esc_html__( 'Page Header Background', 'aardvark' ),
				'type'      => 'media',			
				'required' => array( 'search_page_header', '!=', 'gp-standard-page-header' ),
				'default' => '',
			),
			
			array( 
				'id' => 'search_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'required' => array( 'search_page_header', '!=', 'gp-standard-page-header' ),
				'width' => false,
				'default'       => array(
					'height' => '320px', )		
			 ),
			 															
			array( 
				'id' => 'search_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-right-sidebar',
			),
			
			array(
				'id'      => 'search_left_sidebar',
				'type'    => 'select',
				'required' => array( 'search_layout', '=', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'search_right_sidebar',
				'type'    => 'select',
				'required' => array( 'search_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),
			
			array( 
				'id' => 'search_format',
				'title' => esc_html__( 'Format', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-posts-list' => esc_html__( 'List', 'aardvark' ),
					'gp-posts-large' => esc_html__( 'Large', 'aardvark' ),
					'gp-posts-columns-2' => esc_html__( '2 Columns', 'aardvark' ),
					'gp-posts-columns-3' => esc_html__( '3 Columns', 'aardvark' ),
					'gp-posts-columns-4' => esc_html__( '4 Columns', 'aardvark' ),
					'gp-posts-masonry' => esc_html__( 'Masonry', 'aardvark' ),
				),
				'default' => 'gp-posts-columns-2',
			),
						
			array( 
				'id' => 'search_style',
				'title' => esc_html__( 'Style', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-style-classic' => esc_html__( 'Classic', 'aardvark' ),
					'gp-style-modern' => esc_html__( 'Modern', 'aardvark' ),
				),
				'default' => 'gp-style-classic',
			),						
						
			array( 
				'id' => 'search_alignment',
				'title' => esc_html__( 'Content Alignment', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-align-left' => esc_html__( 'Left Aligned', 'aardvark' ),
					'gp-align-center' => esc_html__( 'Center Aligned', 'aardvark' ),
				),
				'default' => 'gp-align-left',
			),

			array(  
				'id' => 'search_post_types',
				'title' => esc_html__( 'Post Types', 'aardvark' ),
				'type' => 'select',
				'multi' => true,
				'data' => 'post_type',
				'default' => 'post',
			),
			
			array(  
				'id' => 'search_orderby',
				'title' => esc_html__( 'Order By', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'newest' => esc_html__( 'Newest', 'aardvark' ),
					'oldest' => esc_html__( 'Oldest', 'aardvark' ),
					'title_az' => esc_html__( 'Title (A-Z)', 'aardvark' ),
					'title_za' => esc_html__( 'Title (Z-A)', 'aardvark' ),
					'comment_count' => esc_html__( 'Most Comments', 'aardvark' ),
					'views' => esc_html__( 'Most Views', 'aardvark' ),
					'likes' => esc_html__( 'Most Likes', 'aardvark' ),
					'menu_order' => esc_html__( 'Menu Order', 'aardvark' ),
					'rand' => esc_html__( 'Random', 'aardvark' ),
					'relevance' => esc_html__( 'Relevance', 'aardvark' ),
				),
				'default' => 'relevance',
			),
			
			array(
				'id'       => 'search_per_page',
				'type'     => 'spinner',
				'title'    => esc_html__( 'Items Per Page', 'aardvark' ),
				'min' => 1,
				'max' => 999999,
				'default' => 8,
			),
			
			array(
				'id'       => 'search_image_size',
				'title'    => esc_html__( 'Image Size', 'aardvark' ),
				'type'     => 'select',
				'data' => 'custom_image_size',
				'desc' => esc_html__( 'Choose from one of the default image sizes or you can register your own image size as explained', 'aardvark' ) . ' <a href="' . esc_url( 'https://ghostpool.ticksy.com/article/10923' ) . '" target="_blank">'. esc_html__( 'here', 'aardvark' ) . '</a>.',
				'default' => 'default',
			),
	
			array( 
				'id' => 'search_content_display',
				'title' => esc_html__( 'Content Display', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'excerpt' => esc_html__( 'Excerpt', 'aardvark' ),
					'full_content' => esc_html__( 'Full Content', 'aardvark' ),
				),
				'default' => 'excerpt',
			),
		
			array( 
				'id' => 'search_excerpt_length',
				'title' => esc_html__( 'Excerpt Length', 'aardvark' ),
				'required'  => array( 'search_content_display', '=', 'excerpt' ),
				'type' => 'spinner',
				'desc' => esc_html__( 'The number of characters in excerpts.', 'aardvark' ),
				'min' => 0,
				'max' => 999999,
				'default' => '0',
			),

			array(
				'id'        => 'search_meta',
				'type'      => 'checkbox',
				'title'     => esc_html__( 'Post Meta', 'aardvark' ),'options'   => array(
					'author' => esc_html__( 'Author Name', 'aardvark' ),
					'date' => esc_html__( 'Post Date', 'aardvark' ),
					'comment_count' => esc_html__( 'Comment Count', 'aardvark' ),
					'views' => esc_html__( 'Views', 'aardvark' ),
					'likes' => esc_html__( 'Likes', 'aardvark' ),
					'cats' => esc_html__( 'Categories', 'aardvark' ),
					'tags' => esc_html__( 'Post Tags', 'aardvark' ),
				),
				'default'   => array(
					'author' => '1',
					'date' => '1', 'comment_count' => '1',
					'views' => '0',
					'likes' => '0',
					'cats' => '0',
					'tags' => '0',
				)
			),
						
			array(
				'id'        => 'search_filters',
				'type'      => 'checkbox',
				'title'     => esc_html__( 'Filters (Sorting)', 'aardvark' ),
				'options'   => array(
					'relevance' => esc_html__( 'Relevance', 'aardvark' ),
					'date' => esc_html__( 'Date', 'aardvark' ),
					'title' => esc_html__( 'Title', 'aardvark' ),
					'comment_count' => esc_html__( 'Comment Count', 'aardvark' ),
					'views' => esc_html__( 'Views', 'aardvark' ),
					'likes' => esc_html__( 'Likes', 'aardvark' ),
				),
				'default'   => array(
					'relevance' => '0',
					'date' => '0',
					'title' => '0',
					'comment_count' => '0',
					'views' => '0',
					'likes' => '0',
				)
			),
													   
			array(  
				'id' => 'search_read_more_link',
				'title' => esc_html__( 'Read More Link', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'disabled',
			),
			
			array(  
				'id' => 'search_pagination',
				'title' => esc_html__( 'Pagination', 'aardvark' ),
				'type' => 'select',
				'desc' => esc_html__( 'Filters disabled if using load more button.', 'aardvark' ),
				'options' => array(
					'load-more' => esc_html__( 'Load More Button', 'aardvark' ),
					'page-numbers' => esc_html__( 'Page Numbers', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'page-numbers',
			),
			
		),						   
	) );
		

	Redux::setSection( $opt_name, array(
		'id' => 'author_posts_options',
		'title' => esc_html__( 'Author Posts', 'aardvark' ),
		'desc' => esc_html__( 'Global options for author posts.', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-search',
		'fields' => array(	

			array( 
				'id' => 'author_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array(
				'id' => 'author_page_header_bg', 
				'title' => esc_html__( 'Page Header Background', 'aardvark' ),
				'type'      => 'media',			
				'required' => array( 'author_page_header', '!=', 'gp-standard-page-header' ),
				'default' => '',
			),
			
			array( 
				'id' => 'author_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'required' => array( 'author_page_header', '!=', 'gp-standard-page-header' ),
				'width' => false,
				'default'       => array(
					'height' => '320px',
				)		
			 ),
			 															
			array( 
				'id' => 'author_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-right-sidebar',
			),
			
			array(
				'id'      => 'author_left_sidebar',
				'type'    => 'select',
				'required' => array( 'author_layout', '=', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'author_right_sidebar',
				'type'    => 'select',
				'required' => array( 'author_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),
			
			array( 
				'id' => 'author_format',
				'title' => esc_html__( 'Format', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-posts-list' => esc_html__( 'List', 'aardvark' ),
					'gp-posts-large' => esc_html__( 'Large', 'aardvark' ),
					'gp-posts-columns-2' => esc_html__( '2 Columns', 'aardvark' ),
					'gp-posts-columns-3' => esc_html__( '3 Columns', 'aardvark' ),
					'gp-posts-columns-4' => esc_html__( '4 Columns', 'aardvark' ),
					'gp-posts-masonry' => esc_html__( 'Masonry', 'aardvark' ),
				),
				'default' => 'gp-posts-list',
			),
		
			array( 
				'id' => 'author_style',
				'title' => esc_html__( 'Style', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-style-classic' => esc_html__( 'Classic', 'aardvark' ),
					'gp-style-modern' => esc_html__( 'Modern', 'aardvark' ),
				),
				'default' => 'gp-style-classic',
			),						
						
			array( 
				'id' => 'author_alignment',
				'title' => esc_html__( 'Content Alignment', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-align-left' => esc_html__( 'Left Aligned', 'aardvark' ),
					'gp-align-center' => esc_html__( 'Center Aligned', 'aardvark' ),
				),
				'default' => 'gp-align-left',
			),
			
			array(  
				'id' => 'author_post_types',
				'title' => esc_html__( 'Post Types', 'aardvark' ),
				'type' => 'select',
				'multi' => true,
				'data' => 'post_type',
				'default' => 'post',
			),
			
			array(  
				'id' => 'author_orderby',
				'title' => esc_html__( 'Order By', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'newest' => esc_html__( 'Newest', 'aardvark' ),
					'oldest' => esc_html__( 'Oldest', 'aardvark' ),
					'title_az' => esc_html__( 'Title (A-Z)', 'aardvark' ),
					'title_za' => esc_html__( 'Title (Z-A)', 'aardvark' ),
					'comment_count' => esc_html__( 'Most Comments', 'aardvark' ),
					'views' => esc_html__( 'Most Views', 'aardvark' ),
					'likes' => esc_html__( 'Most Likes', 'aardvark' ),
					'menu_order' => esc_html__( 'Menu Order', 'aardvark' ),
					'rand' => esc_html__( 'Random', 'aardvark' ),
					'relevance' => esc_html__( 'Relevance', 'aardvark' ),
				),
				'default' => 'newest',
			),
			
			array(
				'id'       => 'author_per_page',
				'type'     => 'spinner',
				'title'    => esc_html__( 'Items Per Page', 'aardvark' ),
				'min' => 1,
				'max' => 999999,
				'default' => 8,
			),
			
			array(
				'id'       => 'author_image_size',
				'title'    => esc_html__( 'Image Size', 'aardvark' ),
				'type'     => 'select',
				'data' => 'custom_image_size',
				'desc' => esc_html__( 'Choose from one of the default image sizes or you can register your own image size as explained', 'aardvark' ) . ' <a href="' . esc_url( 'https://ghostpool.ticksy.com/article/10923' ) . '" target="_blank">'. esc_html__( 'here', 'aardvark' ) . '</a>.',
				'default' => 'default',
			),
	
			array( 
				'id' => 'author_content_display',
				'title' => esc_html__( 'Content Display', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'excerpt' => esc_html__( 'Excerpt', 'aardvark' ),
					'full_content' => esc_html__( 'Full Content', 'aardvark' ),
				),
				'default' => 'excerpt',
			),
		
			array( 
				'id' => 'author_excerpt_length',
				'title' => esc_html__( 'Excerpt Length', 'aardvark' ),
				'required'  => array( 'author_content_display', '=', 'excerpt' ),
				'type' => 'spinner',
				'desc' => esc_html__( 'The number of characters in excerpts.', 'aardvark' ),
				'min' => 0,
				'max' => 999999,
				'default' => '0',
			),

			array(
				'id'        => 'author_meta',
				'type'      => 'checkbox',
				'title'     => esc_html__( 'Post Meta', 'aardvark' ),'options'   => array(
					'author' => esc_html__( 'Author Name', 'aardvark' ),
					'date' => esc_html__( 'Post Date', 'aardvark' ),
					'comment_count' => esc_html__( 'Comment Count', 'aardvark' ),
					'views' => esc_html__( 'Views', 'aardvark' ),
					'likes' => esc_html__( 'Likes', 'aardvark' ),
					'cats' => esc_html__( 'Categories', 'aardvark' ),
					'tags' => esc_html__( 'Post Tags', 'aardvark' ),
				),
				'default'   => array(
					'author' => '1',
					'date' => '1', 'comment_count' => '1',
					'views' => '0',
					'likes' => '0',
					'cats' => '0',
					'tags' => '0',
				)
			),
						
			array(
				'id'        => 'author_filters',
				'type'      => 'checkbox',
				'title'     => esc_html__( 'Filters (Sorting)', 'aardvark' ),
				'options'   => array(
					'date' => esc_html__( 'Date', 'aardvark' ),
					'title' => esc_html__( 'Title', 'aardvark' ),
					'comment_count' => esc_html__( 'Comment Count', 'aardvark' ),
					'views' => esc_html__( 'Views', 'aardvark' ),
					'likes' => esc_html__( 'Likes', 'aardvark' ),
				),
				'default'   => array(
					'date' => '0',
					'title' => '0',
					'comment_count' => '0',
					'views' => '0',
					'likes' => '0',
				)
			),
													   
			array(  
				'id' => 'author_read_more_link',
				'title' => esc_html__( 'Read More Link', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'disabled',
			),
			
			array(  
				'id' => 'author_pagination',
				'title' => esc_html__( 'Pagination', 'aardvark' ),
				'type' => 'select',
				'desc' => esc_html__( 'Filters disabled if using load more button.', 'aardvark' ),
				'options' => array(
					'load-more' => esc_html__( 'Load More Button', 'aardvark' ),
					'page-numbers' => esc_html__( 'Page Numbers', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'page-numbers',
			),
			
		),						   
	) );
	
											
	Redux::setSection( $opt_name, array(
		'id' => 'page_options',
		'title' => esc_html__( 'Pages', 'aardvark' ),
		'desc' => esc_html__( 'Global options for all pages (some options can be overridden on individual pages).', 'aardvark' ),
		'icon' => 'el-icon-file',
		'fields' => array(

			array( 
				'id' => 'page_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),
			
			array( 
				'id' => 'page_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'default'       => array(
					'height' => '320px',
				)		
			),
													
			array( 
				'id' => 'page_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),					
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-right-sidebar',
			),

			array(
				'id'      => 'page_left_sidebar',
				'type'    => 'select',
				'required' => array( 'page_layout', '=', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'page_right_sidebar',
				'type'    => 'select',
				'required' => array( 'page_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),

			array(  
				'id' => 'page_image',
				'title' => esc_html__( 'Featured Image', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'enabled',
			),
						
			array(  
				'id' => 'page_voting',
				'title' => esc_html__( 'Vote Up/Down', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'disabled',
			),
			
			array(
				'id'        => 'page_voting_title',
				'type'      => 'text',
				'required'  => array( 'page_voting', '=', 'enabled' ),
				'title'     => esc_html__( 'Vote Up/Down Title', 'aardvark' ),
				'default'   => esc_html__( 'Have your say!', 'aardvark' ),
			),
			
			array(  
				'id' => 'page_author_info',
				'title' => esc_html__( 'Author Info Panel', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'disabled',
			),

		),
	) );
	
	Redux::setSection( $opt_name, array(
		'id' => 'post_submission_options',
		'title' => esc_html__( 'Post Submission', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-envelope',
		'fields' => array(
		
			array( 
				'id' => 'post_submission_page',
				'title' => esc_html__( 'Post Submission List', 'aardvark' ),
				'desc' => esc_html__( 'The page used to display all user submitted posts.', 'aardvark' ),
				'type' => 'select',
				'multi' => false,
				'data' => 'page',
				'default' => '',
			),

			array( 
				'id' => 'post_editing',
				'title' => esc_html__( 'Editing Posts', 'aardvark' ),
				'type' => 'radio',
				'options' => array(
					'publish' => esc_html__( 'Once a user edits a post it is approved automatically', 'aardvark' ),
					'pending' => esc_html__( 'Once a user edits a post it needs to be approved again', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'publish',
			),

			array( 
				'id' => 'post_edit_email_notification',
				'required' => array( 'post_editing', '=', 'pending' ),
				'title' => esc_html__( 'Email Notification', 'aardvark' ),
				'type' => 'radio',
				'desc' => esc_html__( 'Choose to receive an email notification when a user edits a post.', 'aardvark' ),
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'enabled',
			),
						
			array( 
				'id' => 'post_deleting',
				'title' => esc_html__( 'Deleting Posts', 'aardvark' ),
				'type' => 'button_set',
				'desc' => esc_html__( 'Choose whether users can delete posts.', 'aardvark' ),
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'enabled',
			),

		),
	) );
									
	Redux::setSection( $opt_name, array(
		'id' => 'buddypress_options',
		'title' => esc_html__( 'BuddyPress', 'aardvark' ),
		'desc' => esc_html__( 'Global options for all BuddyPress pages (some options can be overridden on individual pages).', 'aardvark' ),
		'icon' => 'el-icon-user',
		'fields' => array(),
	) );	

	Redux::setSection( $opt_name, array(
		'id' => 'bp_general_options',
		'title' => esc_html__( 'General', 'aardvark' ),
		'desc' => esc_html__( 'Global options for all BuddyPress pages (some options can be overridden for different BuddyPress sections below).', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-user',
		'fields' => array(

			array( 
				'id' => 'bp_header_layout',
				'title' => esc_html__( 'Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array( 
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.jpg' ),
					'gp-header-logo-left-1' => array( 'title' => esc_html__( 'Header 1', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-1.jpg' ),
					'gp-header-logo-left-2' => array( 'title' => esc_html__( 'Header 2', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-2.jpg' ),
					'gp-header-logo-right-1' => array( 'title' => esc_html__( 'Header 3', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-right-1.jpg' ),
					'gp-header-nav-bottom-1' => array( 'title' => esc_html__( 'Header 4', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-1.jpg' ),
					'gp-header-nav-bottom-2' => array( 'title' => esc_html__( 'Header 5', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-2.jpg' ),
					'gp-header-nav-bottom-3' => array( 'title' => esc_html__( 'Header 6', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-3.jpg' ),
					'gp-header-side-menu' => array( 'title' => esc_html__( 'Header 7', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/side-menu.jpg' ),
				),
				'default' => 'default',
			),

			array( 
				'id' => 'bp_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array(
				'id' => 'bp_page_header_bg', 
				'title' => esc_html__( 'Page Header Background', 'aardvark' ),
				'type'      => 'media',			
				'required' => array( 'bp_page_header', '!=', 'gp-standard-page-header' ),
				'default' => '',
			),

			array( 
				'id' => 'bp_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'default'       => array(
					'height' => '320px',
				)		
			),
		
			array( 
				'id' => 'bp_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),					
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-right-sidebar',
			),

			array(
				'id'      => 'bp_left_sidebar',
				'type'    => 'select',
				'required' => array( 'bp_layout', '=', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'bp_right_sidebar',
				'type'    => 'select',
				'required' => array( 'bp_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),
	
		),
	) );

	Redux::setSection( $opt_name, array(
		'id' => 'bp_activity_options',
		'title' => esc_html__( 'Activity Page', 'aardvark' ),
		'desc' => esc_html__( 'Global options for the BuddyPress activity page.', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-user',
		'fields' => array(

			array( 
				'id' => 'bp_activity_header_layout',
				'title' => esc_html__( 'Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array( 
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.jpg' ),
					'gp-header-logo-left-1' => array( 'title' => esc_html__( 'Header 1', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-1.jpg' ),
					'gp-header-logo-left-2' => array( 'title' => esc_html__( 'Header 2', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-2.jpg' ),
					'gp-header-logo-right-1' => array( 'title' => esc_html__( 'Header 3', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-right-1.jpg' ),
					'gp-header-nav-bottom-1' => array( 'title' => esc_html__( 'Header 4', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-1.jpg' ),
					'gp-header-nav-bottom-2' => array( 'title' => esc_html__( 'Header 5', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-2.jpg' ),
					'gp-header-nav-bottom-3' => array( 'title' => esc_html__( 'Header 6', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-3.jpg' ),
					'gp-header-side-menu' => array( 'title' => esc_html__( 'Header 7', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/side-menu.jpg' ),
				),
				'default' => 'default',
			),
			
			array( 
				'id' => 'bp_activity_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'aardvark' ),
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array(
				'id' => 'bp_activity_page_header_bg', 
				'title' => esc_html__( 'Page Header Background', 'aardvark' ),
				'type'      => 'media',			
				'default' => '',
			),

			array( 
				'id' => 'bp_activity_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'default'       => array(
					'height' => '',
				)		
			),
										
			array( 
				'id' => 'bp_activity_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.png' ),
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'default',
			),

			array(
				'id'       => 'bp_activity_left_sidebar',
				'type'     => 'select',
				'title'    => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'     => 'custom_sidebars_default',
				'default'  => 'default',
			),

			array(
				'id'       => 'bp_activity_right_sidebar',
				'type'     => 'select',
				'title'    => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'     => 'custom_sidebars_default',
				'default'  => 'default',
			),

		),
	) );

	Redux::setSection( $opt_name, array(
		'id' => 'bp_members_options',
		'title' => esc_html__( 'Members Page', 'aardvark' ),
		'desc' => esc_html__( 'Global options for the BuddyPress members page.', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-user',
		'fields' => array(

			array( 
				'id' => 'bp_members_header_layout',
				'title' => esc_html__( 'Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array( 
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.jpg' ),
					'gp-header-logo-left-1' => array( 'title' => esc_html__( 'Header 1', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-1.jpg' ),
					'gp-header-logo-left-2' => array( 'title' => esc_html__( 'Header 2', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-2.jpg' ),
					'gp-header-logo-right-1' => array( 'title' => esc_html__( 'Header 3', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-right-1.jpg' ),
					'gp-header-nav-bottom-1' => array( 'title' => esc_html__( 'Header 4', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-1.jpg' ),
					'gp-header-nav-bottom-2' => array( 'title' => esc_html__( 'Header 5', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-2.jpg' ),
					'gp-header-nav-bottom-3' => array( 'title' => esc_html__( 'Header 6', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-3.jpg' ),
					'gp-header-side-menu' => array( 'title' => esc_html__( 'Header 7', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/side-menu.jpg' ),
				),
				'default' => 'default',
			),
			
			array( 
				'id' => 'bp_members_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'aardvark' ),
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array(
				'id' => 'bp_members_page_header_bg', 
				'title' => esc_html__( 'Page Header Background', 'aardvark' ),
				'type'      => 'media',			
				'default' => '',
			),

			array( 
				'id' => 'bp_members_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'default'       => array(
					'height' => '',
				)		
			),
																	
			array( 
				'id' => 'bp_members_layout',
				'title' => esc_html__( 'Directory Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.png' ),
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-no-sidebar',
			),

			array( 
				'id' => 'bp_profile_layout',
				'title' => esc_html__( 'Profile Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.png' ),
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'default',
			),
			
			array(
				'id'      => 'bp_members_left_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'     => 'custom_sidebars_default',
				'default'  => 'default',
			),

			array(
				'id'      => 'bp_members_right_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'     => 'custom_sidebars_default',
				'default'  => 'default',
			),

		),
	) );

	Redux::setSection( $opt_name, array(
		'id' => 'bp_groups_options',
		'title' => esc_html__( 'Groups Page', 'aardvark' ),
		'desc' => esc_html__( 'Global options for the BuddyPress group page.', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-user',
		'fields' => array(

			array( 
				'id' => 'bp_groups_header_layout',
				'title' => esc_html__( 'Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array( 
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.jpg' ),
					'gp-header-logo-left-1' => array( 'title' => esc_html__( 'Header 1', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-1.jpg' ),
					'gp-header-logo-left-2' => array( 'title' => esc_html__( 'Header 2', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-2.jpg' ),
					'gp-header-logo-right-1' => array( 'title' => esc_html__( 'Header 3', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-right-1.jpg' ),
					'gp-header-nav-bottom-1' => array( 'title' => esc_html__( 'Header 4', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-1.jpg' ),
					'gp-header-nav-bottom-2' => array( 'title' => esc_html__( 'Header 5', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-2.jpg' ),
					'gp-header-nav-bottom-3' => array( 'title' => esc_html__( 'Header 6', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-3.jpg' ),
					'gp-header-side-menu' => array( 'title' => esc_html__( 'Header 7', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/side-menu.jpg' ),
				),
				'default' => 'default',
			),
					
			array( 
				'id' => 'bp_groups_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'aardvark' ),
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array(
				'id' => 'bp_groups_page_header_bg', 
				'title' => esc_html__( 'Page Header Background', 'aardvark' ),
				'type'      => 'media',			
				'default' => '',
			),

			array( 
				'id' => 'bp_groups_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'default'       => array(
					'height' => '',
				)		
			),
										
			array( 
				'id' => 'bp_groups_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.png' ),
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-no-sidebar',
			),

			array(
				'id'      => 'bp_groups_left_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'     => 'custom_sidebars_default',
				'default'  => 'default',
			),

			array(
				'id'      => 'bp_groups_right_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'     => 'custom_sidebars_default',
				'default'  => 'default',
			),

		),
	) );

	Redux::setSection( $opt_name, array(
		'id' => 'bp_register_options',
		'title' => esc_html__( 'Registration Page', 'aardvark' ),
		'desc' => esc_html__( 'Global options for the BuddyPress registration page.', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-user',
		'fields' => array(

			array( 
				'id' => 'bp_register_header_layout',
				'title' => esc_html__( 'Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array( 
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.jpg' ),
					'gp-header-logo-left-1' => array( 'title' => esc_html__( 'Header 1', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-1.jpg' ),
					'gp-header-logo-left-2' => array( 'title' => esc_html__( 'Header 2', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-2.jpg' ),
					'gp-header-logo-right-1' => array( 'title' => esc_html__( 'Header 3', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-right-1.jpg' ),
					'gp-header-nav-bottom-1' => array( 'title' => esc_html__( 'Header 4', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-1.jpg' ),
					'gp-header-nav-bottom-2' => array( 'title' => esc_html__( 'Header 5', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-2.jpg' ),
					'gp-header-nav-bottom-3' => array( 'title' => esc_html__( 'Header 6', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-3.jpg' ),
					'gp-header-side-menu' => array( 'title' => esc_html__( 'Header 7', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/side-menu.jpg' ),
				),
				'default' => 'default',
			),
			
			array( 
				'id' => 'bp_register_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'aardvark' ),
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array(
				'id' => 'bp_register_page_header_bg', 
				'title' => esc_html__( 'Page Header Background', 'aardvark' ),
				'type'      => 'media',			
				'default' => '',
			),

			array( 
				'id' => 'bp_register_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'default'       => array(
					'height' => '',
				)		
			),
										
			array( 
				'id' => 'bp_register_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.png' ),
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-no-sidebar',
			),

			array(
				'id'      => 'bp_register_left_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'     => 'custom_sidebars_default',
				'default'  => 'default',
			),

			array(
				'id'      => 'bp_register_right_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'     => 'custom_sidebars_default',
				'default'  => 'default',
			),

		)
	) );
		
	
	Redux::setSection( $opt_name, array(
		'id' => 'bbpress_options',
		'title' => esc_html__( 'bbPress', 'aardvark' ),
		'desc' => esc_html__( 'Global options for all bbPress pages (some options can be overridden on individual forums and topics).', 'aardvark' ),
		'icon' => 'el-icon-comment-alt',
		'fields' => array(

			array( 
				'id' => 'bbpress_header_layout',
				'title' => esc_html__( 'Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array( 
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.jpg' ),
					'gp-header-logo-left-1' => array( 'title' => esc_html__( 'Header 1', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-1.jpg' ),
					'gp-header-logo-left-2' => array( 'title' => esc_html__( 'Header 2', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-2.jpg' ),
					'gp-header-logo-right-1' => array( 'title' => esc_html__( 'Header 3', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-right-1.jpg' ),
					'gp-header-nav-bottom-1' => array( 'title' => esc_html__( 'Header 4', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-1.jpg' ),
					'gp-header-nav-bottom-2' => array( 'title' => esc_html__( 'Header 5', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-2.jpg' ),
					'gp-header-nav-bottom-3' => array( 'title' => esc_html__( 'Header 6', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-3.jpg' ),
					'gp-header-side-menu' => array( 'title' => esc_html__( 'Header 7', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/side-menu.jpg' ),
				),
				'default' => 'default',
			),
						
			array( 
				'id' => 'bbpress_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array(
				'id' => 'bbpress_page_header_bg', 
				'title' => esc_html__( 'Page Header Background', 'aardvark' ),
				'type'      => 'media',			
				'required' => array( 'bbpress_page_header', '!=', 'gp-standard-page-header' ),
				'default' => '',
			),

			array( 
				'id' => 'bbpress_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'required' => array( 'bbpress_page_header', '!=', 'gp-standard-page-header' ),
				'width' => false,
				'default'       => array(
					'height' => '320px',
				)		
			),
						
			array(						
				'id' => 'bbpress_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),					
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-no-sidebar',
			),
			
			array(
				'id'      => 'bbpress_left_sidebar',
				'type'    => 'select',
				'required' => array( 'bbpress_layout', '=', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'bbpress_right_sidebar',
				'type'    => 'select',
				'required' => array( 'bbpress_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),

		),	
	
	) );
	

	Redux::setSection( $opt_name, array(
		'id' => 'wc_options',
		'title' => esc_html__( 'WooCommerce', 'aardvark' ),
		'desc' => esc_html__( 'Global options for all WooCommerce pages (some options can be overridden on individual product pages).', 'aardvark' ),
		'icon' => 'el-icon-shopping-cart',
		'fields' => array(),
	) );

	Redux::setSection( $opt_name, array(
		'id' => 'wc_shop_options',
		'title' => esc_html__( 'Shop Page', 'aardvark' ),
		'desc' => esc_html__( 'Global options for the main WooCommerce shop page.', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-shopping-cart',
		'fields' => array(	

			array( 
				'id' => 'wc_shop_page_header',
				'title' => esc_html__( 'Shop Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array(
				'id' => 'wc_shop_page_header_bg', 
				'title' => esc_html__( 'Page Header Background', 'aardvark' ),
				'type'      => 'media',			
				'required' => array( 'wc_shop_page_header', '!=', 'gp-standard-page-header' ),
				'default' => '',
			),
			
			array( 
				'id' => 'wc_shop_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'required' => array( 'wc_shop_page_header', '!=', 'gp-standard-page-header' ),
				'width' => false,
				'default'       => array(
					'height' => '320px',
				)		
			 ),
											
			array( 
				'id' => 'wc_shop_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-left-sidebar',
			),
	
			array(
				'id'      => 'wc_shop_left_sidebar',
				'type'    => 'select',
				'required' => array( 'wc_shop_layout', '=', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'wc_shop_right_sidebar',
				'type'    => 'select',
				'required' => array( 'wc_shop_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),

			array(
				'id'       => 'wc_shop_per_page',
				'type'     => 'spinner',
				'title'    => esc_html__( 'Items Per Page', 'aardvark' ),
				'min' => 1,
				'max' => 999999,
				'default' => 12,
			),

			array(  
				'id' => 'wc_products_per_row',
				'title' => esc_html__( 'Products Per Row', 'aardvark' ),
				'type' => 'spinner',
				'default'   => '3',				
			),
			
			array(  
				'id' => 'wc_secondary_hover_image',
				'title' => esc_html__( 'Secondary Hover Image', 'aardvark' ),
				'desc' => esc_html__( 'Show the secondary gallery image when hovering over the primary image on product category pages.', 'aardvark' ),
				'type' => 'button_set',
				'options'   => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				), 'default'   => 'enabled'						
			),
									
		),
	) );	

	Redux::setSection( $opt_name, array(
		'id' => 'wc_product_cat_options',
		'title' => esc_html__( 'Product Categories/Tags', 'aardvark' ),
		'desc' => esc_html__( 'Global options for all product categories and tags (some options can be overridden on individual product categories and tags).', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-shopping-cart',
		'fields' => array(	

			array( 
				'id' => 'wc_product_cat_page_header',
				'title' => esc_html__( 'Shop Page Header', 'aardvark' ),
				'type' => 'select',
				'desc' => esc_html__( 'The shop page header on the page.', 'aardvark' ),
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array( 
				'id' => 'wc_product_cat_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'required' => array( 'wc_product_cat_page_header', '!=', 'gp-standard-page-header' ),
				'width' => false,
				'default'       => array(
					'height' => '320px',
				)		
			 ),
											
			array( 
				'id' => 'wc_product_cat_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-left-sidebar',
			),
	
			array(
				'id'      => 'wc_product_cat_left_sidebar',
				'type'    => 'select',
				'required' => array( 'wc_product_cat_layout', '=', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'wc_product_cat_right_sidebar',
				'type'    => 'select',
				'required' => array( 'wc_product_cat_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),

			array(
				'id'       => 'wc_product_cat_per_page',
				'type'     => 'spinner',
				'title'    => esc_html__( 'Items Per Page', 'aardvark' ),
				'min' => 1,
				'max' => 999999,
				'default' => 12,
			),

		),			
	) );

	Redux::setSection( $opt_name, array(
		'id' => 'wc_product_options',
		'title' => esc_html__( 'Product Pages', 'aardvark' ),
		'desc' => esc_html__( 'Global options for all product pages (some options can be overridden on individual product pages).', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-shopping-cart',
		'fields' => array(	

			array( 
				'id' => 'wc_product_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array( 
				'id' => 'wc_product_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'required' => array( 'wc_product_page_header', '!=', 'gp-standard-page-header' ),
				'width' => false,
				'default'       => array(
					'height' => '320px',
				)		
			 ),
										
			array( 
				'id' => 'wc_product_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-no-sidebar',
			),

			array(
				'id'      => 'wc_product_left_sidebar',
				'type'    => 'select',
				'required' => array( 'wc_product_layout', '=', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'wc_product_right_sidebar',
				'type'    => 'select',
				'required' => array( 'wc_product_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),
		
		),
	) );


	Redux::setSection( $opt_name, array(
		'id' => 'sensei_options',
		'title' => esc_html__( 'Sensei', 'aardvark' ),
		'desc' => esc_html__( 'Global options for all Sensei pages.', 'aardvark' ),
		'icon' => 'el-icon-question',
		'fields' => array(),
	) );

	Redux::setSection( $opt_name, array(
		'id' => 'courses_options',
		'title' => esc_html__( 'Courses Archive', 'aardvark' ),
		'desc' => esc_html__( 'Global options for the main courses archive page.', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-question',
		'fields' => array(	

			array( 
				'id' => 'courses_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array(
				'id' => 'courses_page_header_bg', 
				'title' => esc_html__( 'Page Header Background', 'aardvark' ),
				'type'      => 'media',			
				'required' => array( 'courses_page_header', '!=', 'gp-standard-page-header' ),
				'default' => '',
			),
			
			array( 
				'id' => 'courses_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'required' => array( 'courses_page_header', '!=', 'gp-standard-page-header' ),
				'width' => false,
				'default'       => array(
					'height' => '320px',
				)		
			 ),
											
			array( 
				'id' => 'courses_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-right-sidebar',
			),
	
			array(
				'id'      => 'courses_left_sidebar',
				'type'    => 'select',
				'required' => array( 'courses_layout', '=', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'courses_right_sidebar',
				'type'    => 'select',
				'required' => array( 'courses_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),
			
			array( 
				'id' => 'courses_format',
				'title' => esc_html__( 'Format', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-posts-list' => esc_html__( 'List', 'aardvark' ),
					'gp-posts-large' => esc_html__( 'Large', 'aardvark' ),
					'gp-posts-columns-2' => esc_html__( '2 Columns', 'aardvark' ),
					'gp-posts-columns-3' => esc_html__( '3 Columns', 'aardvark' ),
					'gp-posts-columns-4' => esc_html__( '4 Columns', 'aardvark' ),
					'gp-posts-masonry' => esc_html__( 'Masonry', 'aardvark' ),
				),
				'default' => 'gp-posts-list',
			),
						
			array( 
				'id' => 'courses_style',
				'title' => esc_html__( 'Style', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-style-classic' => esc_html__( 'Classic', 'aardvark' ),
					'gp-style-modern' => esc_html__( 'Modern', 'aardvark' ),
				),
				'default' => 'gp-style-classic',
			),						
						
			array( 
				'id' => 'courses_alignment',
				'title' => esc_html__( 'Content Alignment', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-align-left' => esc_html__( 'Left Aligned', 'aardvark' ),
					'gp-align-center' => esc_html__( 'Center Aligned', 'aardvark' ),
				),
				'default' => 'gp-align-left',
			),
						
		),
	) );	

	Redux::setSection( $opt_name, array(
		'id' => 'course_options',
		'title' => esc_html__( 'Course Pages', 'aardvark' ),
		'desc' => esc_html__( 'Global options for all course pages.', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-question',
		'fields' => array(	

			array( 
				'id' => 'course_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array( 
				'id' => 'course_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'required' => array( 'course_page_header', '!=', 'gp-standard-page-header' ),
				'width' => false,
				'default'       => array(
					'height' => '320px',
				)		
			 ),
										
			array( 
				'id' => 'course_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-right-sidebar',
			),

			array(
				'id'      => 'course_left_sidebar',
				'type'    => 'select',
				'required' => array( 'course_layout', '=', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'course_right_sidebar',
				'type'    => 'select',
				'required' => array( 'course_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),
		
		),
	) );

	Redux::setSection( $opt_name, array(
		'id' => 'lesson_options',
		'title' => esc_html__( 'Lesson Pages', 'aardvark' ),
		'desc' => esc_html__( 'Global options for all lesson pages.', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-question',
		'fields' => array(	

			array( 
				'id' => 'lesson_page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'gp-standard-page-header',
			),

			array( 
				'id' => 'lesson_page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'required' => array( 'lesson_page_header', '!=', 'gp-standard-page-header' ),
				'width' => false,
				'default'       => array(
					'height' => '320px',
				)		
			 ),
										
			array( 
				'id' => 'lesson_layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array(
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'gp-right-sidebar',
			),

			array(
				'id'      => 'lesson_left_sidebar',
				'type'    => 'select',
				'required' => array( 'lesson_layout', '=', array( 'gp-left-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-left-sidebar',
			),

			array(
				'id'      => 'lesson_right_sidebar',
				'type'    => 'select',
				'required' => array( 'lesson_layout', '=', array( 'gp-right-sidebar', 'gp-both-sidebars' ) ),
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars',
				'default' => 'gp-right-sidebar',
			),
		
		),
	) );
		

	Redux::setSection( $opt_name, array(
		'id' => 'styling_options',
		'title'     => esc_html__( 'Styling', 'aardvark' ),
		'icon' => 'el-icon-brush',
		'fields'    => array(

			array(
				'id'        => 'custom_css',
				'type'      => 'ace_editor',
				'title'     => esc_html__( 'CSS Code', 'aardvark' ),
				'subtitle'  => esc_html__( 'Add your CSS code here - this CSS will not be lost if you update the theme.', 'aardvark' ),
				'mode'      => 'css',
				'theme'     => 'monokai',
				'options'   => array( 'minLines' => 50 ),
				'default' => '',
			),
			
		),
	) );
				
	Redux::setSection( $opt_name, array(
		'id' => 'styling-general',
		'title'     => esc_html__( 'General', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-cogs',
		'fields'    => array(
						
			array(
				'id'        => 'primary_color',
				'type'      => 'color_gradient',
				'title'     => esc_html__( 'Primary Color', 'aardvark' ),
				'desc'  => esc_html__( 'The primary color used for various elements throughout the theme.', 'aardvark' ),
				'transparent' => false,
				'default' => array(
					'from' => '#00a0e3',
					'to' => '#39c8df',
				),
			),
				
			array(
				'id'        => 'page_bg',
				'type'      => 'background',
				'title'     => esc_html__( 'Page Background', 'aardvark' ),
				'output'    => array( 'body', '.gp-wide-layout .gp-divider-title' ),
				'preview' => false,
				'transparent' => false,
				'default'   => array(
					'background-color' => '#fff',
				),
			),
			
			array(
				'id'        => 'content_wrapper_bg',
				'required' => array( 'theme_layout', '=', 'gp-boxed-layout' ),
				'type'      => 'background',
				'title'     => esc_html__( 'Content Wrapper Background', 'aardvark' ),
				'output'    => array( '.gp-boxed-layout #gp-content-wrapper', '.gp-boxed-layout #gp-content', '.gp-boxed-layout .gp-divider-title' ),
				'preview' => false,
				'default'   => array(
					'background-color' => '#fff',
				),
			),
			
			array(
				'id' => 'content_wrapper_sizing_begin',
				'type' => 'section',
				'title' => esc_html__( 'Content Wrapper Padding', 'aardvark' ),
				'indent' => true,
		   ),

			 	array(
					'id' => 'desktop_content_wrapper_padding',
					'type' => 'spacing',
					'units' => 'px',
					'title' => esc_html__( 'Desktop', 'aardvark' ),
					'mode' => 'padding',
					'left' => false,
					'right' => false,
					'default' => array(
						'padding-top'     => '40px',
						'padding-bottom'     => '40px',
					),
				),

			 	array(
					'id' => 'mobile_content_wrapper_padding',
					'type' => 'spacing',
					'units' => 'px',
					'title' => esc_html__( 'Mobile', 'aardvark' ),
					'mode' => 'padding',
					'left' => false,
					'right' => false,
					'default' => array(
						'padding-top'     => '30px',
						'padding-bottom'     => '30px',
					),
				),
				
			array(
				'id'     => 'content_wrapper_sizing_end',
				'type'   => 'section',
				'indent' => false,
			),
			
			array(
				'id'        => 'content_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Content Background', 'aardvark' ),
				'output'    => array( 'background' => 'body:not(.page-template-homepage-template) #gp-content, .gp-wide-layout .gp-divider-title, .gp-boxed-layout .gp-divider-title' ),
				'default'   => '',
			),
									
			array(
				'id' => 'content_sidebar_sizing_begin',
				'type' => 'section',
				'title' => esc_html__( 'Content/Sidebar Widths', 'aardvark' ),
				'subtitle'  => esc_html__( 'All widths should total 100%, excluding content padding.', 'aardvark' ),
				'indent' => true,
		   ),

			 	array(
					'id' => 'content_width',
					'type' => 'dimensions',
					'units' => '%',
					'title' => esc_html__( 'Content Width', 'aardvark' ),
					'output' => array( '#gp-content' ),
					'height' => false,
					'mode' => false,
					'default'           => array(
						'width'     => '72%',
					),
				),

			 	array(
					'id' => 'content_padding',
					'type' => 'spacing',
					'units' => 'px',
					'title' => esc_html__( 'Content Padding', 'aardvark' ),
					'output' => array( 'body:not(.page-template-homepage-template) #gp-content' ),
					'mode' => 'padding',
					'default' => array(
						'padding-top'     => '0',
						'padding-right'     => '0',
						'padding-bottom'     => '0',
						'padding-left'     => '0',
					),
				),

			 	array(
					'id' => 'sidebar_gap',
					'type' => 'dimensions',
					'units' => '%',
					'title' => esc_html__( 'Gap Width', 'aardvark' ),
					'height' => false,
					'mode' => false,
					'default'           => array(
						'width'     => '3%',
					),
				),
				
			 	array(
					'id' => 'sidebar_width',
					'type' => 'dimensions',
					'units' => '%',
					'title' => esc_html__( 'Sidebar Width', 'aardvark' ),
					'output' => array( '.gp-sidebar' ),
					'height' => false,
					'mode' => false,
					'default'           => array(
						'width'     => '25%',
					),
				),
			
			array(
				'id'     => 'content_sidebar_sizing_end',
				'type'   => 'section',
				'indent' => false,
			),
			
			array(
				'id'        => 'text_logo_typography',
				'required' => array( 'text_logo', '!=', '' ),
				'type'      => 'typography',
				'title'     => esc_html__( 'Text Logo Typography', 'aardvark' ),
				'output'    => array( '.gp-text-logo' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '30px',
					'line-height' => '30px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '500',
					'subsets'     => 'latin',
					'color'       => '#232323',
					'letter-spacing' => '-1.5px',
					'text-transform' => 'none',
				),
			),
									
			array(
				'id'        => 'general_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'General Typography', 'aardvark' ),
				'output'    => array( 'body' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '14px',
					'line-height' => '28px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'color'       => '#777',
					'letter-spacing' => '0px',
					'text-transform' => 'none',
				),
			),
																															
			array(
				'id'        => 'general_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'General Link Colors', 'aardvark' ),
				'output'    => array( 'a','.gp-course-details-wrapper .sensei-results-links a' ),
				'default'   => array(
					'regular'  => '#39c8df',
					'hover'    => '#00a0e3',
					'active'   => false,
				),
			),
			
			array(
				'id'        => 'h1_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'H1 Typography', 'aardvark' ),
				'output'    => array( 'h1' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '32px',
					'line-height' => '40px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '-1px',
					'color' 	  => '#232323',
					'text-transform' => 'none',
				),
			),

			array(
				'id'        => 'h2_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'H2 Typography', 'aardvark' ),
				'output'    => array( 'h2' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '24px',
					'line-height' => '32px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '-1px',
					'color' 	  => '#232323',
					'text-transform' => 'none',
				),
			),

			array(
				'id'        => 'h3_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'H3 Typography', 'aardvark' ),
				'output'    => array( 'h3' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '19px',
					'line-height' => '27px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '500',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#232323',
					'text-transform' => 'none',
				),
			),

			array(
				'id'        => 'h4_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'H4 Typography', 'aardvark' ),
				'output'    => array( 'h4' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'letter-spacing' => true,
				'text-transform' => true,
				'letter-spacing' => true,				
				'default'   => array(
					'font-size'   => '16px',
					'line-height' => '24px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#232323',
					'text-transform' => 'none',
				),
			),

			array(
				'id'        => 'h5_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'H5 Typography', 'aardvark' ),
				'output'    => array( 'h5' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '13px',
					'line-height' => '21px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#232323',
					'text-transform' => 'none',
				),
			),

			array(
				'id'        => 'h6_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'H6 Typography', 'aardvark' ),
				'output'    => array( 'h6' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '12px',
					'line-height' => '16px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#232323',
					'text-transform' => 'none',
				),
			),
			
			array(
				'id'        => 'divider_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Divider Color', 'aardvark' ),
				'desc'  => esc_html__( 'Divider color used throughout the theme.', 'aardvark' ),
				'output' => array( 'background-color' => 'hr',
					'border-color' => 'th, td, .gp-sidebar, #gp-new-search, .gp-divider-title-bg, 	#gp-share-icons, #gp-share-icons a, #gp-author-info-wrapper, .comment_container, .widget li, .gp-posts-masonry .gp-loop-content, .gp-recent-comments ul li, .gp-posts-list .gp-post-item, .gp-posts-large .gp-post-item, .gp-small-posts .gp-post-item, .gp-login-or-left-line, .gp-login-or-right-line, .gp-stats-list .gp-stats-col, .gp-theme #buddypress div.item-list-tabs, .gp-theme #buddypress .main-navs, .gp-theme .widget.buddypress #friends-list li, .gp-theme .widget.buddypress #groups-list li, .gp-theme .widget.buddypress #members-list li, .gp-theme .widget .gp-bps-form, .course-results-lessons .course h2, .gp-loop-meta .sensei-course-meta > span, .gp-loop-meta .lesson-meta > span, .gp-loop-meta .sensei-free-lessons, .gp-theme .quiz ol#sensei-quiz-list > li, .learner-profile #my-courses.ui-tabs .ui-tabs-nav, .learner-profile #learner-info .type-course, .gp-course-wrapper, .gp-course-stat, .gp-course-details-wrapper .sensei-results-links a, .gp-course-wrapper .contact-teacher, .woocommerce div.product .woocommerce-tabs ul.tabs::before, .woocommerce-MyAccount-navigation li, #pmpro_account .pmpro_box, .gp-archive-wrapper .gp-filter-menus,.gp-theme #buddypress .bps_filters,.gp-theme #buddypress .gp-bps-wrapper',
				),
				'default'   => '#e6e6e6',
			),
																																						
		),
	) );
	
	Redux::setSection( $opt_name, array(
		'id' => 'styling-top-header',
		'title'     => esc_html__( 'Top Header', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields'    => array(                                          

			array(
				'id'        => 'top_header_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Top Header Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '#gp-top-header' ),
				'default'    => '#f8f8f8',
			),

			array(
				'id'        => 'top_header_border',
				'type'      => 'border',
				'title'     => esc_html__( 'Top Header Border', 'aardvark' ),
				'output'    => array( '#gp-top-header' ),
				'all' => false,
				'top' => false,
				'left' => false,
				'right' => false,
				'bottom' => true,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-bottom' => '1px',
					'border-style' => 'solid',
				),
			),
			
			array(
				'id'        => 'top_header_nav_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Top Header Navigation Typography', 'aardvark' ),
				'output'    => array( '#gp-top-header .menu > .menu-item' ),
				'text-align' => false,
				'font-style' => false,
				'text-transform' => true,
				'font-backup' => true,
				'letter-spacing' => true,
				'color' => false,
				'default'   => array(
					'font-size'     => '12px',
					'line-height'     => '16px',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'text-transform' => 'none',
					'letter-spacing' => '0px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
				),
			),
						
			array(
				'id'        => 'top_header_nav_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Top Header Navigation Link Colors', 'aardvark' ),
				'output'    => array( '#gp-top-header .menu > .menu-item > a' ),
				'default'   => array(
					'regular'   => '#777',
					'hover'     => '#232323',
					'active' 	=> false,
				),
			),
		
		),
	) );
	
	Redux::setSection( $opt_name, array(
		'id' => 'styling-main-header',
		'title'     => esc_html__( 'Main Header', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields'    => array(    										
			array(
				'id'        => 'main_header_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Main Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '.gp-header-above-content.gp-header-logo-left-1 #gp-standard-header, .gp-header-above-content.gp-header-logo-left-2 #gp-standard-header, .gp-header-above-content.gp-header-logo-right-1 #gp-standard-header, .gp-header-above-content.gp-header-side-menu #gp-standard-header, .gp-header-above-content.gp-header-nav-bottom-1 #gp-header-row-1, .gp-header-above-content.gp-header-nav-bottom-2 #gp-header-row-1,	 .gp-header-above-content.gp-header-nav-bottom-3 #gp-header-row-1' ),
				'default'   => '#fff',
			),
			
			array(
				'id'        => 'main_header_nav_border',
				'title'     => esc_html__( 'Navigation Top Border', 'aardvark' ),
				'type'      => 'border',
				'output'    => array( '#gp-standard-header #gp-header-row-2' ),	
				'all' => false,
				'bottom' => false,
				'left' => false,
				'right' => false,
				'top' => true,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-top' => '1px',
					'border-style' => 'solid',
				),
			),		

			array(
				'id'        => 'main_header_nav_link_divider',
				'type'      => 'border',
				'title'     => esc_html__( 'Navigation Link Divider', 'aardvark' ),
				'output'    => array( '.gp-header-nav-bottom-1 #gp-standard-header #gp-main-header-primary-nav > ul > li:after', '.gp-header-nav-bottom-2 #gp-standard-header #gp-main-header-primary-nav > ul > li:after' ),	
				'all' => false,
				'bottom' => false,
				'left' => false,
				'right' => true,
				'top' => false,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-right' => '1px',
					'border-style' => 'solid',
				),
			),
						
			array(
				'id'        => 'main_header_nav_bg',
				'title'     => esc_html__( 'Navigation Background Color', 'aardvark' ),
				'type'      => 'color',
				'output'    => array( 'background-color' => '.gp-header-above-content.gp-header-nav-bottom-1 #gp-standard-header #gp-header-row-2, .gp-header-above-content.gp-header-nav-bottom-2 #gp-standard-header #gp-header-row-2, .gp-header-above-content.gp-header-nav-bottom-3 #gp-standard-header #gp-header-row-2' ),
				'default'   => '#fff',
			),

			array(
				'id'        => 'main_header_border',
				'type'      => 'border',
				'title'     => esc_html__( 'Bottom Border', 'aardvark' ),
				'output'    => array( '.gp-header-above-content #gp-standard-header' ),	
				'all' => false,
				'top' => false,
				'left' => false,
				'right' => false,
				'bottom' => true,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-bottom' => '1px',
					'border-style' => 'solid',
				),
			),

			array(
				'id'        => 'main_header_over_content_bg',
				'type'      => 'color_rgba',
				'title'     => esc_html__( 'Over Content Main Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '.gp-header-over-content.gp-header-logo-left-1 #gp-standard-header, .gp-header-over-content.gp-header-logo-left-2 #gp-standard-header, .gp-header-over-content.gp-header-logo-right-1 #gp-standard-header, .gp-header-over-content.gp-header-side-menu #gp-standard-header, .gp-header-over-content.gp-header-nav-bottom-1 #gp-header-row-1, .gp-header-over-content.gp-header-nav-bottom-2 #gp-header-row-1,	 .gp-header-over-content.gp-header-nav-bottom-3 #gp-header-row-1' ),
				'default'   => array(
					'color' => 'transparent',
					'alpha' => '0',
				),
			),

			array(
				'id'        => 'main_header_over_content_nav_border',
				'title'     => esc_html__( 'Over Content Navigation Top Border', 'aardvark' ),
				'type'      => 'border',
				'output'    => array( '.gp-header-over-content #gp-standard-header #gp-header-row-2' ),	
				'all' => false,
				'bottom' => false,
				'left' => false,
				'right' => false,
				'top' => true,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-top' => '0',
					'border-style' => 'solid',
				),
			),		

			array(
				'id'        => 'main_header_over_content_nav_link_divider',
				'type'      => 'border',
				'title'     => esc_html__( 'Over Content Navigation Link Divider', 'aardvark' ),
				'output'    => array( '.gp-header-over-content.gp-header-nav-bottom-1 #gp-standard-header #gp-main-header-primary-nav > ul > li:after', '.gp-header-over-content.gp-header-nav-bottom-2 #gp-standard-header #gp-main-header-primary-nav > ul > li:after' ),	
				'all' => false,
				'bottom' => false,
				'left' => false,
				'right' => true,
				'top' => false,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-right' => '1px',
					'border-style' => 'solid',
				),
			),
						
			array(
				'id'        => 'main_header_over_content_nav_bg',
				'title'     => esc_html__( 'Over Content Navigation Background Color', 'aardvark' ),
				'type'      => 'color_rgba',
				'output'    => array( 'background-color' => '.gp-header-over-content.gp-header-nav-bottom-1 #gp-standard-header #gp-header-row-2, .gp-header-over-content.gp-header-nav-bottom-2 #gp-standard-header #gp-header-row-2, .gp-header-over-content.gp-header-nav-bottom-3 #gp-standard-header #gp-header-row-2' ),
				'default'   => array(
					'color' => 'transparent',
					'alpha' => '0',
				),
			),

			array(
				'id'        => 'main_header_over_content_border',
				'type'      => 'border',
				'title'     => esc_html__( 'Over Content Bottom Border', 'aardvark' ),
				'output'    => array( '.gp-header-over-content #gp-standard-header' ),	
				'all' => false,
				'top' => false,
				'left' => false,
				'right' => false,
				'bottom' => true,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-bottom' => '0',
					'border-style' => 'solid',
				),
			),
										
			array(
				'id'        => 'main_header_scrolling_bg',
				'type'      => 'color_rgba',
				'title'     => esc_html__( 'Scrolling Main Background Color', 'aardvark' ),
				'output' => array( 'background-color' => '.gp-header-logo-left-1.gp-scrolling #gp-standard-header,.gp-header-logo-left-2.gp-scrolling #gp-standard-header,.gp-header-logo-right-1.gp-scrolling #gp-standard-header,.gp-header-nav-bottom-1.gp-scrolling #gp-header-row-1,.gp-header-nav-bottom-2.gp-scrolling #gp-header-row-1,	.gp-header-nav-bottom-3.gp-scrolling #gp-header-row-1' ),
				'default'   => array(
					'color' => '#fff',
					'alpha' => '0.9',
				),
				'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
			),

			array(
				'id'        => 'main_header_scrolling_nav_border',
				'type'      => 'border',
				'title'     => esc_html__( 'Scrolling Navigation Top Border', 'aardvark' ),
				//'required' => array( 'header_layout', '=', array( 'gp-header-nav-bottom-1', 'gp-header-nav-bottom-2', 'gp-header-nav-bottom-3' ) ),	
				'output'    => array( '.gp-scrolling #gp-header-row-2' ),	
				'all' => false,
				'bottom' => false,
				'left' => false,
				'right' => false,
				'top' => true,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-top' => '1px',
					'border-style' => 'solid',
				),
				'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
			),

			array(
				'id'        => 'main_header_scrolling_nav_link_divider',
				'type'      => 'border',
				'title'     => esc_html__( 'Scrolling Navigation Link Divider', 'aardvark' ),
				//'required' => array( 'header_layout', '=', array( 'gp-header-nav-bottom-1', 'gp-header-nav-bottom-2' ) ),	
				'output'    => array( '.gp-header-nav-bottom-1.gp-scrolling #gp-main-header-primary-nav > ul > li:after', '.gp-header-nav-bottom-2.gp-scrolling #gp-main-header-primary-nav > ul > li:after' ),	
				'all' => false,
				'bottom' => false,
				'left' => false,
				'right' => true,
				'top' => false,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-right' => '1px',
					'border-style' => 'solid',
				),
				'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
			),
						
			array(
				'id'        => 'main_header_scrolling_nav_bg',
				'title'     => esc_html__( 'Scrolling Navigation Background Color', 'aardvark' ),
				'type'      => 'color_rgba',
				//'required' => array( 'header_layout', '=', array( 'gp-header-nav-bottom-1', 'gp-header-nav-bottom-2', 'gp-header-nav-bottom-3' ) ),	
				'output'    => array( 'background-color' => '.gp-header-nav-bottom-1.gp-scrolling #gp-standard-header #gp-header-row-2, .gp-header-nav-bottom-2.gp-scrolling #gp-standard-header #gp-header-row-2, .gp-header-nav-bottom-3.gp-scrolling #gp-standard-header #gp-header-row-2' ),
				'default'   => array(
					'color' => '#fff',
					'alpha' => '0.9',
				),
				'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
			),
						
			array(
				'id'        => 'main_header_scrolling_border',
				'type'      => 'border',
				'title'     => esc_html__( 'Scrolling Bottom Border', 'aardvark' ),
				'output'    => array( '.gp-scrolling #gp-standard-header' ),	
				'all' => false,
				'top' => false,
				'left' => false,
				'right' => false,
				'bottom' => true,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-bottom' => '1px',
					'border-style' => 'solid',
				),
				'required' => array( 'fixed_header', '!=', 'gp-relative-header' ),
			),
							
			array(
				'id'        => 'main_header_primary_nav_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Main Header Primary Navigation Typography', 'aardvark' ),
				'output'    => array( '#gp-standard-header .menu > .menu-item' ),
				'text-align' => false,
				'font-style' => false,
				'text-transform' => true,
				'font-backup' => true,
				'letter-spacing' => true,
				'color' => false,
				'default'   => array(
					'font-size'     => '14px',
					'line-height'     => '18px',
					'font-weight' => '500',
					'subsets'     => 'latin',
					'text-transform' => 'none',
					'letter-spacing' => '0px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
				),
			),
			
			array(
				'id'        => 'main_header_primary_nav_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Primary Navigation Link Colors', 'aardvark' ),
				'output'    => array( '#gp-standard-header .menu > .menu-item > a, #gp-standard-header .menu > .menu-item .gp-more-menu-items-icon' ),
				'default'   => array(
					'regular'   => '#232323',
					'hover'     => '#39c8df',
					'active' 	=> false,
				),
			),

			array(
				'id'        => 'main_header_primary_nav_link_bottom_border',
				'type'      => 'border',
				'title'     => esc_html__( 'Primary Navigation Link Bottom Border', 'aardvark' ),
				'output'    => array( '#gp-main-header-primary-nav .menu > .current-menu-item > a:before', '#gp-main-header-primary-nav .menu > .menu-item > a:hover:before' ),	
				'all' => false,
				'top' => false,
				'left' => false,
				'right' => false,
				'bottom' => true,
				'default'   => array(
					'border-color' => '#39c8df',
					'border-bottom' => '0',
					'border-style' => 'solid',
				),
			),			

			array(
				'id'        => 'main_header_secondary_nav_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Secondary Navigation Typography', 'aardvark' ),
				'output'    => array( '#gp-main-header-secondary-nav > .menu > .menu-item' ),
				'text-align' => false,
				'font-style' => false,
				'text-transform' => true,
				'font-backup' => true,
				'letter-spacing' => true,
				'color' => false,
				'default'   => array(
					'font-size'     => '14px',
					'line-height'     => '18px',
					'font-weight' => '500',
					'subsets'     => 'latin',
					'text-transform' => 'none',
					'letter-spacing' => '0px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
				),
			),
			
			array(
				'id'        => 'main_header_secondary_nav_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Secondary Navigation Link Colors', 'aardvark' ),
				'output'    => array( '#gp-main-header-secondary-nav > .menu > .menu-item > a, #gp-main-header-secondary-nav .menu > .menu-item .gp-more-menu-items-icon' ),
				'default'   => array(
					'regular'   => '#39c8df',
					'hover'     => '#232323',
					'active' 	=> false,
				),
			),

			array(
				'id'        => 'main_header_secondary_nav_bg',
				'type'      => 'color_rgba',
				'title'     => esc_html__( 'Secondary Navigation Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '#gp-main-header-secondary-nav > .menu > .menu-item > a',
				),
				'default'   => array(
					'color' => 'transparent',
					'alpha' => '0',
				),
			),

			array(
				'id'        => 'main_header_secondary_nav_bg_hover',
				'type'      => 'color_rgba',
				'title'     => esc_html__( 'Secondary Navigation Background Hover Color', 'aardvark' ),
				'output'    => array( 'background-color' => '#gp-main-header-secondary-nav > .menu > .menu-item > a:hover',
				),
				'default'   => array(
					'color' => 'transparent',
					'alpha' => '0',
				),
			),
			
			array(
				'id'        => 'main_header_secondary_nav_border',
				'type'      => 'border',
				'title'     => esc_html__( 'Secondary Navigation Border Color', 'aardvark' ),
				'output'    => array( '#gp-main-header-secondary-nav > .menu > .menu-item > a' ),
				'default'   => array(
					'border-color' => '#39c8df',
					'border-width' => '2px',
					'border-style' => 'solid',
				),
			),

			array(
				'id'        => 'main_header_secondary_nav_border_hover',
				'type'      => 'border',
				'title'     => esc_html__( 'Secondary Navigation Border Hover Color', 'aardvark' ),
				'output'    => array( '#gp-main-header-secondary-nav > .menu > .menu-item > a:hover' ),
				'default'   => array(
					'border-color' => '#232323',
					'border-width' => '2px',
					'border-style' => 'solid',
				),
			),

			array(
				'id'        => 'main_header_search_bar',
				'type'      => 'border',
				'title'     => esc_html__( 'Search Bar Border', 'aardvark' ),
				//'required' => array( 'header_layout', '=', array( 'gp-header-nav-bottom-1', 'gp-header-nav-bottom-2', 'gp-header-nav-bottom-3' ) ),	
				'output'    => array( '#gp-standard-header .gp-search-bar' ),	
				'all' => true,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border' => '2px',
					'border-style' => 'solid',
				),
			),
						
			array(
				'id'        => 'header_buttons_size',
				'type'      => 'typography',
				'title'     => esc_html__( 'Search/Cart/Profile Button Size', 'aardvark' ),
				'text-align' => false,
				'font-family' => false,
				'font-style' => false,
				'font-weight' => false,
				'subsets' => false,
				'line-height' => false,
				'color' => false,
				'default'   => array(
					'font-size'     => '14px',
				),
			),
			
			array(
				'id'        => 'header_buttons_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Search/Cart/Profile Button Colors', 'aardvark' ),
				'default'   => array(
					'regular'   => '#232323',
					'hover'     => '#39c8df',
					'active' 	=> false,
				),
			),
						
			array(
				'id'        => 'nav_counter_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Notifications Counter Background Color', 'aardvark' ),
				'output'    => array( 'background' => '#gp-standard-header .menu > .menu-item .gp-notification-counter' ),                        
				'default' => '#39c8df',
			),

			array(
				'id'        => 'nav_counter_text_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Notifications Text Color', 'aardvark' ),
				'transparent' => false,
				'output'    => array( 'color' => '#gp-standard-header .menu > .menu-item .gp-notification-counter, #gp-standard-header .menu > .menu-item .gp-notification-counter:hover' ),                        
				'default' => '#fff',
			),

								
			array(
				'id'        => 'dropdown_menu_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Dropdown Menu Background color', 'aardvark' ),
				'transparent' => false,
				'output'    => array( 'background-color' => '.gp-nav .sub-menu, .gp-search-box .searchform',
				),
				'default' => '#fff',
			),

			array(
				'id'        => 'dropdown_menu_border',
				'type'      => 'color',
				'title'     => esc_html__( 'Dropdown Menu Border Color', 'aardvark' ),
				'output'    => array( 'border-color' => '.gp-nav .sub-menu, .gp-menu-tabs, .gp-nav .gp-menu-tabs .menu-item, .gp-nav span.gp-menu-header, .gp-search-box .searchform, .gp-profile-tab, .gp-notifications-tab' ),
				'default'   => '#e6e6e6',
			),

			array(
				'id'        => 'dropdown_menu_nav_header_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Dropdown Menu Header Color', 'aardvark' ),
				'transparent' => false,
				'output'    => array(
					'color' => 'span.gp-menu-header',
				),
				'default' => '#39c8df',
			),
						
			array(
				'id'        => 'dropdown_menu_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Dropodown Menu Link Colors', 'aardvark' ),
				'output'    => array(  	'#gp-top-header .sub-menu .menu-item a',
					'#gp-standard-header .sub-menu .menu-item a',
				),
				'default'   => array(
					'regular'   => '#232323',
					'hover'     => '#39c8df',
					'active' 	=> false,
				),
			),
		
		),
	) );
	
	Redux::setSection( $opt_name, array(
		'id' => 'styling-mobile-header',
		'title'     => esc_html__( 'Mobile Header', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields'    => array(   

			array(
				'id'        => 'mobile_header_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '.gp-header-above-content #gp-mobile-header' ),
				'default'   => '#fff',
			),

			array(
				'id'        => 'mobile_header_over_content_bg',
				'type'      => 'color_rgba',
				'title'     => esc_html__( 'Over Content Background Color', 'aardvark' ),
				'output' => array( 'background-color' => '.gp-header-over-content #gp-mobile-header' ),
				'default'   => array(
					'color' => 'transparent',
					'alpha' => '0',
				),
			),
						
			array(
				'id'        => 'mobile_header_scrolling_bg',
				'type'      => 'color_rgba',
				'title'     => esc_html__( 'Scrolling Background Color', 'aardvark' ),
				'output' => array( 'background-color' => '.gp-scrolling #gp-mobile-header' ),
				'default'   => array(
					'color' => '#fff',
					'alpha' => '0.9',
				),
			),
			
			array(
				'id'        => 'mobile_header_border',
				'type'      => 'border',
				'title'     => esc_html__( 'Bottom Border', 'aardvark' ),
				'output'    => array( '.gp-header-above-content #gp-mobile-header', '.gp-header-over-content.gp-scrolling #gp-mobile-header' ),	
				'all' => false,
				'top' => false,
				'left' => false,
				'right' => false,
				'bottom' => true,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-bottom' => '1px',
					'border-style' => 'solid',
				),
			),
			
			array(
				'id'        => 'mobile_header_buttons_size',
				'type'      => 'typography',
				'title'     => esc_html__( 'Search/Cart/Profile Button Size', 'aardvark' ),
				'text-align' => false,
				'font-family' => false,
				'font-style' => false,
				'font-weight' => false,
				'subsets' => false,
				'line-height' => false,
				'color' => false,
				'default'   => array(
					'font-size'     => '18px',
				),
			),
			
			array(
				'id'        => 'mobile_header_buttons_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Search/Cart/Profile Button Colors', 'aardvark' ),
				'default'   => array(
					'regular'   => '#232323',
					'hover'     => '#39c8df',
					'active' 	=> false,
				),
			),
						
			array(
				'id'        => 'mobile_nav_counter_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Notifications Counter Background Color', 'aardvark' ),
				'output'    => array( 'background' => '#gp-mobile-header .gp-nav.menu .gp-notification-counter' ),                        'default' => '#39c8df',
			),

			array(
				'id'        => 'mobile_nav_counter_text_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Notifications Text Color', 'aardvark' ),
				'transparent' => false,
				'output'    => array( 'color' => '#gp-mobile-header .gp-nav.menu .gp-notification-counter' ),                        'default' => '#fff',
			),
								
			array(
				'id'        => 'open_mobile_nav_button_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Open Mobile Navigation Button Color', 'aardvark' ),
				'transparent' => false,
				'output'    => array( 'background-color' => '.gp-nav-button-icon, .gp-nav-button-icon:before, .gp-nav-button-icon:after',
				),
				'default' => '#232323',
			),
			
			array(
				'id'        => 'close_mobile_nav_button_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Close Mobile Navigation Button Color', 'aardvark' ),
				'transparent' => false,
				'output'    => array( 'color' => '#gp-close-mobile-nav-button',
				),
				'default' => '#fff',
			),

			array(
				'id'        => 'mobile_nav_border',
				'type'      => 'color',
				'title'     => esc_html__( 'Mobile Navigation Border Color', 'aardvark' ),
				'transparent' => false,
				'output'    => array( 'border-color' => '#gp-mobile-primary-nav .gp-profile-tab, #gp-mobile-profile-nav .gp-notifications-tab',
				),
				'default' => '#e6e6e6',
			),
						
			array(
				'id'        => 'mobile_nav_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Mobile Navigation Background Color', 'aardvark' ),
				'transparent' => false,
				'output'    => array( 'background-color' => '#gp-mobile-primary-nav, #gp-mobile-profile-nav',
				),
				'default' => '#fff',
			),
			
			array(
				'id'        => 'mobile_nav_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Mobile Navigation Typography', 'aardvark' ),
				'output'    => array( '#gp-mobile-primary-nav .menu-item, #gp-mobile-profile-nav .menu-item' ),
				'text-align' => false,
				'font-style' => false,
				'text-transform' => true,
				'font-backup' => true,
				'letter-spacing' => true,
				'color' => false,
				'default'   => array(
					'font-size'     => '16px',
					'line-height'     => '20px',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'text-transform' => 'none',
					'letter-spacing' => '0px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
				),
			),
			
			array(
				'id'        => 'mobile_nav_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Mobile Navigation Link Colors', 'aardvark' ),
				'output'    => array( '#gp-mobile-primary-nav .menu-item a', '#gp-mobile-profile-nav .menu-item a', '.gp-mobile-dropdown-icon' ),
				'default'   => array(
					'regular'   => '#232323',
					'hover'     => '#39c8df',
					'active' 	=> false,
				),
			),
		
			array(
				'id'        => 'mobile_nav_sub_menu_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Mobile Navigation Sub Menu Link Colors', 'aardvark' ),
				'output'    => array( '#gp-mobile-primary-nav .sub-menu .menu-item a', '#gp-mobile-profile-nav .sub-menu .menu-item a', '.sub-menu .gp-mobile-dropdown-icon' ),
				'default'   => array(
					'regular'   => '#232323',
					'hover'     => '#39c8df',
					'active' 	=> false,
				),
			),
						
		)
	) );
	
	Redux::setSection( $opt_name, array(
		'id' => 'styling-side-menu',
		'title'     => esc_html__( 'Side Menu', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields'    => array(   

			array(
				'id'        => 'side_menu_header_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Header Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '#gp-side-menu-logo' ),
				'default'   => '#39c8df',
			),
					
			array(
				'id'        => 'side_menu_header_border',
				'type'      => 'border',
				'title'     => esc_html__( 'Header Bottom Border', 'aardvark' ),
				'output'    => array( '#gp-side-menu-logo' ),	
				'all' => false,
				'top' => false,
				'left' => false,
				'right' => false,
				'bottom' => true,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-bottom' => '0',
					'border-style' => 'solid',
				),
			),
			
			array(
				'id'        => 'side_menu_nav_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Navigation Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '#gp-side-menu-nav' ),
				'default'   => '#f1f1f1',
			),
			
			array(
				'id'        => 'side_menu_content_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Content Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '#gp-side-menu-wrapper' ),
				'default'   => '#fff',
			),

			array(
				'id'        => 'side_menu_divider_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Divider Color', 'aardvark' ),
				'desc'  => esc_html__( 'Divider color used thorughout the theme.', 'aardvark' ),
				'output' => array( 'background-color' => 'hr',
					'border-color' => '#gp-side-menu-content th, #gp-side-menu-content td, #gp-side-menu-content .widget li, #gp-side-menu-content .gp-recent-comments ul li, #gp-side-menu-content .gp-posts-list .gp-post-item, #gp-side-menu-content .gp-login-or-left-line, #gp-side-menu-content .gp-login-or-right-line, .gp-theme #gp-side-menu-content .widget.buddypress #friends-list li, .gp-theme #gp-side-menu-content .widget.buddypress #groups-list li, .gp-theme #gp-side-menu-content .widget.buddypress #members-list li, .gp-theme #gp-side-menu-content .widget .gp-bps-form, #gp-side-menu-content .gp-stats-list .gp-stats-col',
				),
				'default'   => '#e6e6e6',
			),
						
			array(
				'id'        => 'side_menu_nav_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Side Menu Navigation Typography', 'aardvark' ),
				'output'    => array( '#gp-side-menu-nav .menu-item' ),
				'text-align' => false,
				'font-style' => false,
				'text-transform' => true,
				'font-backup' => true,
				'letter-spacing' => true,
				'color' => false,
				'default'   => array(
					'font-size'     => '16px',
					'line-height'     => '24px',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'text-transform' => 'none',
					'letter-spacing' => '0px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
				),
			),
			
			array(
				'id'        => 'side_menu_nav_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Side Menu Navigation Link Colors', 'aardvark' ),
				'output'    => array( '#gp-side-menu-nav .menu-item a', '#gp-side-menu-nav .menu-item .gp-mobile-dropdown-icon' ),
				'default'   => array(
					'regular'   => '#232323',
					'hover'     => '#39c8df',
					'active' 	=> false,
				),
			),
		
			array(
				'id'        => 'side_menu_nav_sub_menu_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Side Menu Navigation Sub Menu Link Colors', 'aardvark' ),
				'output'    => array( '#gp-side-menu-nav .sub-menu .menu-item a', '#gp-side-menu-nav .sub-menu .menu-item .gp-mobile-dropdown-icon' ),
				'default'   => array(
					'regular'   => '#232323',
					'hover'     => '#39c8df',
					'active' 	=> false,
				),
			),
			
			array(
				'id'        => 'side_menu_widget_title_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Side Menu Widget Title Typography', 'aardvark' ),
				'output'    => array( '#gp-side-menu-content .widgettitle', '#gp-side-menu-content .widgettitle a' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '19px',
					'line-height' => '19px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#232323',
					'text-transform' => 'none',
				),
			),

			array(
				'id'        => 'side_menu_widget_text_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Side Menu Widget Text Typography', 'aardvark' ),
				'output'    => array( '#gp-side-menu-content .widget' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '16px',
					'line-height' => '20px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#999',
					'text-transform' => 'none',
				),
			),
			
			array(
				'id'        => 'side_menu_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Side Menu Widget Link Colors', 'aardvark' ),
				'output'    => array( '#gp-side-menu-content .widget a' ),
				'default'   => array(
					'regular' => '#39c8df',
					'hover'   => '#00a0e3',
					'active'  => false,
				),
			),

			array(
				'id'        => 'side_menu_toggle_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Toggle Button Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '#gp-side-menu-toggle, #gp-open-side-menu-button' ),
				'default'   => '#39c8df',
			),

			array(
				'id'        => 'side_menu_toggle_text_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Toggle Button Text Color', 'aardvark' ),
				'output'    => array( 'color' => '#gp-side-menu-toggle, #gp-open-side-menu-button' ),
				'transparent' => false,
				'default'   => '#fff',
			),
									
		)
	) );
	
	Redux::setSection( $opt_name, array(
		'id' => 'styling-page-header',
		'title'     => esc_html__( 'Page Header', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-file',
		'fields'    => array(
					    
			array(
				'id'        => 'page_title_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Page Title Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '#gp-page-title' ),        'default'   => '#f8f8f8',
			),
			
			array(
				'id'        => 'page_title_border',
				'type'      => 'border',
				'title'     => esc_html__( 'Page Title Border', 'aardvark' ),
				'output'    => array( '#gp-page-title' ),
				'all' => false,
				'top' => false,
				'left' => false,
				'right' => false,
				'bottom' => true,
				'default'   => array(
					'border-color' => '#e6e6e6',
					'border-bottom' => '1px',
					'border-style' => 'solid',
				),
			),
								                                    
			array(
				'id'        => 'page_title_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Page Title Typography', 'aardvark' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '30px',
					'line-height' => '34px',
					'color' 	  => '#232323',                           	'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '-1px',
					'text-transform' => 'none',
				),
			),
			
			array(
				'id'        => 'mobile_page_title_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Mobile Page Title Typography', 'aardvark' ),
				'google'    => true,
				'text-align' => false,
				'letter-spacing' => true,
				'font-family' => false,
				'font-weight' => false,
				'font-style' => false,
				'color' => false,
				'default'   => array(
					'font-size'   => '24px',
					'line-height' => '28px',
					'letter-spacing' => '-1px',
				),
			),
			
			array(
				'id'        => 'page_subtitle_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Subtitle Typography', 'aardvark' ),
				'output'    => array( '#gp-page-title-subtitle' ),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '16px',
					'line-height' => '22px',
					'color' 	  => '#999',                           	'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'text-transform' => 'none',
				),
			),
						
		)
			
	) );
	
	Redux::setSection( $opt_name, array(
		'id' => 'styling-posts',
		'title'     => esc_html__( 'Posts', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-pencil',
		'fields'    => array(      

			array(
				'id'        => 'post_meta_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Post Meta Typography', 'aardvark' ),
				'output'    => array( '.gp-entry-meta', '.gp-entry-meta a', '.gp-entry-tags', '.gp-entry-tags a', '#gp-breadcrumbs' ),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '13px',
					'line-height' => '13px',
					'color' => '#b1b1b1',                           	'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
				),
			),

			array(
				'id'        => 'post_sub_header_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Sub Header Typography', 'aardvark' ),
				'desc'  => esc_html__( 'Used for the related posts section, comments section etc.', 'aardvark' ),
				'output'    => array( '.gp-divider-title', '#comments h3', '.woocommerce div.product .woocommerce-tabs .panel h2', '.woocommerce .comment-reply-title' ),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '19px',
					'line-height' => '19px',
					'color' 	  => '#232323',                           	'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '-0.25px',
				),
			),
												
			array(
				'id'        => 'author_info_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Author Info Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '#gp-author-info' ),
				'default'   => '#fff',
			),
												
			array(
				'id'        => 'author_info_border',
				'type'      => 'color',
				'title'     => esc_html__( 'Author Info Border Color', 'aardvark' ),
				'output'    => array( 'border-color' => '#gp-author-info' ),
				'default'   => '#e6e6e6',
			),
						
			array(
				'id'        => 'author_info_text_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Author Info Text Color', 'aardvark' ),
				'transparent' => false,
				'output'    => array( '#gp-author-info' ),
				'default' => '#777',
			),	
					
			array(
				'id'        => 'author_info_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Author Info Link Colors', 'aardvark' ),
				'output'    => array( '#gp-author-info a' ),
				'default'   => array(
					'regular'     => '#39c8df',
					'hover'       => '#00a0e3',
					'active'      => false,
				),
			),

			array(
				'id'        => 'vote_border',
				'type'      => 'color',
				'title'     => esc_html__( 'Vote Button Border Color', 'aardvark' ),
				'output'    => array( 'border-color' => '.gp-voting-up, .gp-voting-down' ),
				'default'   => '#e6e6e6',
			),
						
			array(
				'id'        => 'vote_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Vote Button Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '.gp-voting-up, .gp-voting-down' ),
				'default'   => '#fff',
			),

			array(
				'id'        => 'vote_bg_hover',
				'type'      => 'color',
				'title'     => esc_html__( 'Vote Button Background Hover Color', 'aardvark' ),
				'output'    => array( 'background-color' => '.gp-voting-up:hover, .gp-voting-down:hover' ),
				'default'   => '#f1f1f1',
			),

			array(
				'id'        => 'vote_text_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Vote Button Text Color', 'aardvark' ),
				'transparent' => false,
				'output'    => array( '.gp-voting-up, .gp-voting-down' ),
				'default' => '#777',
			),

			array(
				'id'        => 'post_navigation_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Post Navigation Link Colors', 'aardvark' ),
				'output'    => array( '#gp-post-navigation a' ),
				'default'   => array(
					'regular'     => '#232323',
					'hover'       => '#39c8df',
					'active'      => false,
				),
			),
			
			array(
				'id'        => 'blockquote_border',
				'type'      => 'color',
				'title'     => esc_html__( 'Blockquote Border Color', 'aardvark' ),
				'output'    => array( 'border-color' => 'blockquote' ),
				'default'   => '#39c8df',
			),
						
			array(
				'id'        => 'blockquote_text_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Blockquote Text Color', 'aardvark' ),
				'transparent' => false,
				'output'    => array( 'blockquote', 'blockquote a' ),
				'default' => '#232323',
			),
																											
		)

	) );
								  
	Redux::setSection( $opt_name, array(
		'id' => 'styling-categories',
		'title'     => esc_html__( 'Categories', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-folder-open',
		'fields'    => array(

			array(
				'id'        => 'cat_list_title_classic_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'List Title Typography (Classic)', 'aardvark' ),
				'output'    => array( '.gp-loop-title' ),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(                           	'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-size'   => '16px',
					'line-height' => '20px',
					'font-weight' => '500',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'text-transform' => 'none',
					'color' => '#232323',
				),
			),
			
			array(
				'id'        => 'cat_list_title_modern_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'List Title Typography (Modern)', 'aardvark' ),
				'output'    => array( '.gp-style-modern .gp-loop-title' ),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,                        
				'font-family' => false,
				'font-backup' => false,
				'subsets'     => false,
				'text-transform' => false,
				'font-weight' => false,
				'font-style' => false,
				'letter-spacing' => false,
				'color' => false,
				'default'   => array(   	'font-size'   => '20px',
					'line-height' => '24px',
				),
			),

			array(
				'id'        => 'cat_large_title_classic_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Large Title Typography (Classic)', 'aardvark' ),
				'output'    => array( '.gp-posts-large .gp-loop-title' ),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(                           	'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-size'   => '26px',
					'line-height' => '30px',
					'font-weight' => '500',
					'subsets'     => 'latin',
					'letter-spacing' => '-0.5px',
					'text-transform' => 'none',
					'color' => '#232323',
				),
			),

			array(
				'id'        => 'cat_large_title_modern_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Large Title Typography (Modern)', 'aardvark' ),
				'output'    => array( '.gp-posts-large.gp-modern-style .gp-loop-title' ),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,                        
				'font-family' => false,
				'font-backup' => false,
				'subsets'     => false,
				'text-transform' => false,
				'font-weight' => false,
				'font-style' => false,
				'letter-spacing' => false,
				'color' => false,
				'default'   => array(    	'font-size'   => '30px',
					'line-height' => '34px',
				),
			),

			array(
				'id'        => 'cat_columns_masonry_title_classic_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Columns/Masonry Title Typography (Classic)', 'aardvark' ),
				'output'    => array( '[class*="gp-posts-columns-"] .gp-loop-title', '.gp-posts-masonry .gp-loop-title', '.gp-large-post .gp-loop-title' ),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(                           	'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-size'   => '16px',
					'line-height' => '20px',
					'font-weight' => '500',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'text-transform' => 'none',
					'color' => '#232323',
				),
			),
			
			array(
				'id'        => 'cat_columns_masonry_title_modern_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Columns/Masonry Title Typography (Modern)', 'aardvark' ),
				'output'    => array( '[class*="gp-posts-columns-"].gp-style-modern .gp-loop-title', '.gp-posts-masonry.gp-style-modern .gp-loop-title', '.gp-style-modern .gp-large-post .gp-loop-title' ),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,                        
				'font-family' => false,
				'font-backup' => false,
				'subsets'     => false,
				'text-transform' => false,
				'font-weight' => false,
				'font-style' => false,
				'letter-spacing' => false,
				'color' => false,
				'default'   => array( 'font-size'   => '20px',
					'line-height' => '24px',
				),
			),
							
			array(
				'id'        => 'cat_post_title_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Post Title Link Colors', 'aardvark' ),
				'output'    => array( '.gp-loop-title a' ),
				'default'   => array(
					'regular'       => '#232323',
					'hover'       => '#777',
					'active'       => false,
				),
			),

			array(
				'id'        => 'cat_post_text_classic_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Post Text Typography (Classic)', 'aardvark' ),
				'output'    => array( '.gp-loop-text' ),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(                           	'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-size'   => '14px',
					'line-height' => '24px',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'text-transform' => 'none',
					'color' => '#777',
				),
			),

			array(
				'id'        => 'cat_post_text_modern_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Post Text Typography (Modern)', 'aardvark' ),
				'output'    => array( '.gp-style-modern .gp-loop-text' ),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,                        
				'font-family' => false,
				'font-backup' => false,
				'subsets'     => false,
				'text-transform' => false,
				'font-weight' => false,
				'font-style' => false,
				'letter-spacing' => false,
				'color' => false,
				'default'   => array(                           	'font-size'   => '16px',
					'line-height' => '26px',
				),
			),

			array(
				'id'        => 'cat_meta_classic_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Post Meta Typography (Classic)', 'aardvark' ),
				'output' => array(
					'.gp-loop-meta', '.gp-loop-meta a', '.gp-loop-tags a', '.widget .gp-loop-meta', '.widget .gp-loop-meta a', '.widget .gp-loop-tag a', '.gp-footer-widget .widget .gp-loop-meta', '.gp-footer-widget .widget .gp-loop-meta a', '.gp-footer-widget .widget .gp-loop-tag a', '.gp-comment-meta time', '.comment-reply-link', '#cancel-comment-reply-link', '.gp-loop-meta .sensei-course-meta > span', '.gp-loop-meta .lesson-meta > span', '.gp-loop-meta .sensei-free-lessons', '.gp-loop-meta .sensei-free-lessons a', '.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta'
				),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '13px',
					'line-height' => '16px',
					'color' 	  => '#b1b1b1',                           	
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
				),
			),
			
			array(
				'id'        => 'cat_meta_modern_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Post Meta Typography (Modern)', 'aardvark' ),
				'output' => array( '.gp-style-modern .gp-loop-meta', '.gp-style-modern .gp-loop-meta a', '.gp-style-modern .gp-loop-tags a', ),
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,                        
				'font-family' => false,
				'font-backup' => false,
				'subsets'     => false,
				'text-transform' => false,
				'font-weight' => false,
				'font-style' => false,
				'letter-spacing' => false,
				'color' => false,
				'default'   => array(
					'font-size'   => '14px',
					'line-height' => '17px',
				),
			),	
																
		),
	
	) );      
	Redux::setSection( $opt_name, array(
		'id' => 'styling-sidebar-widgets',
		'title'     => esc_html__( 'Sidebar Widgets', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-cog',
		'fields'    => array(

			array(
				'id'        => 'widget_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Widget Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '.gp-sidebar .widget' ),
				'default'   => '',
			),
			
			array(
				'id' => 'widget_padding',
				'type' => 'spacing',
				'units' => 'px',
				'title' => esc_html__( 'Widget Padding', 'aardvark' ),
				'output' => array( '.gp-sidebar .widget' ),
				'mode' => 'padding',
				'default' => array(
					'padding-top'     => '0',
					'padding-right'     => '0',
					'padding-bottom'     => '0',
					'padding-left'     => '0',
				),
			),
		
			array(
				'id' => 'widget_spacing',
				'type' => 'spacing',
				'units' => 'px',
				'title' => esc_html__( 'Widget Spacing', 'aardvark' ),
				'output' => array( '.gp-sidebar .widget' ),
				'mode' => 'margin',
				'top' => false,
				'right' => false,
				'left' => false,
				'default' => array(
					'margin-bottom'     => '35',
				),
			),
							
			array(
				'id'        => 'widget_title_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Widget Title Typography', 'aardvark' ),
				'output'    => array( '.widgettitle', '.widgettitle a', '.wpb_heading' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '19px',
					'line-height' => '19px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#232323',
					'text-transform' => 'none',
				),
			),

			array(
				'id'        => 'widget_text_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Widget Text Typography', 'aardvark' ),
				'output'    => array( '.widget' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '16px',
					'line-height' => '24px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#777',
					'text-transform' => 'none',
				),
			),
			
			array(
				'id'        => 'widget_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Widget Link Colors', 'aardvark' ),
				'output'    => array( '.widget a' ),
				'default'   => array(
					'regular' => '#777',
					'hover'   => '#39c8df',
					'active'  => false,
				),
			),	
																															
		),
	
	) );      	
	Redux::setSection( $opt_name, array(
		'id' => 'styling-fields-buttons',
		'title'     => esc_html__( 'Fields & Buttons', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-check',
		'fields'    => array(
						
			array(
				'id'        => 'input_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Input Box Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => 'input, textarea, .gp-theme #buddypress div.activity-comments form .ac-textarea, .gp-theme #buddypress form#whats-new-form textarea, .gp-theme #buddypress .dir-search input[type=search], .gp-theme #buddypress .dir-search input[type=text], .gp-theme #buddypress .groups-members-search input[type=search], .gp-theme #buddypress .groups-members-search input[type=text], .gp-theme #buddypress .standard-form input[type=color], .gp-theme #buddypress .standard-form input[type=date], .gp-theme #buddypress .standard-form input[type=datetime-local], .gp-theme #buddypress .standard-form input[type=datetime], .gp-theme #buddypress .standard-form input[type=email], .gp-theme #buddypress .standard-form input[type=month], .gp-theme #buddypress .standard-form input[type=number], .gp-theme #buddypress .standard-form input[type=password], .gp-theme #buddypress .standard-form input[type=range], .gp-theme #buddypress .standard-form input[type=search], .gp-theme #buddypress .standard-form input[type=tel], .gp-theme #buddypress .standard-form input[type=text], .gp-theme #buddypress .standard-form input[type=time], .gp-theme #buddypress .standard-form input[type=url], .gp-theme #buddypress .standard-form input[type=week], .gp-theme #buddypress .standard-form select, .gp-theme #buddypress .standard-form textarea' ),
				'default'   => '#fff',
			),

			array(
				'id'        => 'input_border',
				'type'      => 'color',
				'title'     => esc_html__( 'Input Box Border Color', 'aardvark' ),
				'output'    => array( 'border-color' => 'input, textarea, .gp-theme #buddypress div.activity-comments form .ac-textarea, .gp-theme #buddypress form#whats-new-form textarea, .gp-theme #buddypress .rtm-plupload-list .rtm-upload-edit-desc, .gp-theme #buddypress .dir-search input[type=search], .gp-theme #buddypress .dir-search input[type=text], .gp-theme #buddypress .groups-members-search input[type=search], .gp-theme #buddypress .groups-members-search input[type=text], .gp-theme #buddypress .standard-form input[type=color], .gp-theme #buddypress .standard-form input[type=date], .gp-theme #buddypress .standard-form input[type=datetime-local], .gp-theme #buddypress .standard-form input[type=datetime], .gp-theme #buddypress .standard-form input[type=email], .gp-theme #buddypress .standard-form input[type=month], .gp-theme #buddypress .standard-form input[type=number], .gp-theme #buddypress .standard-form input[type=password], .gp-theme #buddypress .standard-form input[type=range], .gp-theme #buddypress .standard-form input[type=search], .gp-theme #buddypress .standard-form input[type=tel], .gp-theme #buddypress .standard-form input[type=text], .gp-theme #buddypress .standard-form input[type=time], .gp-theme #buddypress .standard-form input[type=url], .gp-theme #buddypress .standard-form input[type=week], .gp-theme #buddypress .standard-form select, .gp-theme #buddypress .standard-form textarea' ),  'default'   => '#e6e6e6',
			),

			array(
				'id'        => 'input_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Input Box Typography', 'aardvark' ),
				'output'    => array( 'input, textarea, .gp-theme #buddypress div.activity-comments form .ac-textarea, .gp-theme #buddypress div.activity-comments form textarea, .gp-theme #buddypress form#whats-new-form textarea, .gp-theme #buddypress .dir-search input[type=search], .gp-theme #buddypress .dir-search input[type=text], .gp-theme #buddypress .groups-members-search input[type=search], .gp-theme #buddypress .groups-members-search input[type=text], .gp-theme #buddypress .standard-form input[type=color], .gp-theme #buddypress .standard-form input[type=date], .gp-theme #buddypress .standard-form input[type=datetime-local], .gp-theme #buddypress .standard-form input[type=datetime], .gp-theme #buddypress .standard-form input[type=email], .gp-theme #buddypress .standard-form input[type=month], .gp-theme #buddypress .standard-form input[type=number], .gp-theme #buddypress .standard-form input[type=password], .gp-theme #buddypress .standard-form input[type=range], .gp-theme #buddypress .standard-form input[type=search], .gp-theme #buddypress .standard-form input[type=tel], .gp-theme #buddypress .standard-form input[type=text], .gp-theme #buddypress .standard-form input[type=time], .gp-theme #buddypress .standard-form input[type=url], .gp-theme #buddypress .standard-form input[type=week], .gp-theme #buddypress .standard-form select, .gp-theme #buddypress .standard-form textarea' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '14px',
					'line-height' => '20px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#999',
					'text-transform' => 'none',
				),
			),
						
			array(
				'id'        => 'select_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Selection Menu Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => 'select' ),   'transparent' => false,
				'default'   => '#fff',
			),

			array(
				'id'        => 'select_border',
				'type'      => 'color',
				'title'     => esc_html__( 'Selection Menu Border Color', 'aardvark' ),
				'output'    => array( 'border-color' => 'select' ),  'default'   => '#e6e6e6',
			),

			array(
				'id'        => 'select_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Selection Menu Typography', 'aardvark' ),
				'output'    => array( 'select' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '14px',
					'line-height' => '15px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#999',
					'text-transform' => 'none',
				),
			),
						
			array(
				'id'        => 'button_bg',
				'type'      => 'color_gradient',
				'title'     => esc_html__( 'Button Background Color', 'aardvark' ),
				'transparent' => false,   
				'default' => array(
					'from' => '#009fe6',
					'to' => '#39c8df',
				),	
			),
			
			 array(
				'id'        => 'button_bg_hover',
				'type'      => 'color_gradient',
				'title'     => esc_html__( 'Button Background Hover Color', 'aardvark' ),
				'transparent' => false,   
				'default' => array(
					'from' => '',
					'to' => '',
				),	
			),
											
			array(
				'id'        => 'button_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Button Typography', 'aardvark' ),
				'output'    => array( 'input[type="button"]', 'input[type="submit"]', 'input[type="reset"]', 'button', '.button',  'input[type="button"]:hover', 'input[type="submit"]:hover', 'input[type="reset"]:hover', 'button:hover', '.button:hover', '.gp-theme #buddypress .comment-reply-link', '.gp-theme #buddypress .generic-button a',
				'.gp-theme #buddypress input[type=button]', '.gp-theme #buddypress input[type=reset]', '.gp-theme #buddypress input[type=submit]', '.gp-theme #buddypress ul.button-nav li a', 'a.bp-title-button', '.gp-theme #buddypress .comment-reply-link:hover',
				'.gp-theme #buddypress div.generic-button a:hover', '.gp-theme #buddypress input[type=button]:hover', '.gp-theme #buddypress input[type=reset]:hover', '.gp-theme #buddypress input[type=submit]:hover', '.gp-theme #buddypress ul.button-nav li a:hover', '.gp-theme #buddypress ul.button-nav li.current a', '.gp-theme .course-container a.button', '.gp-theme .course-container a.button:visited', '.gp-theme .course-container a.comment-reply-link', '.gp-theme .course-container #commentform #submit', '.gp-theme .course-container .submit', '.gp-theme .course-container input[type=submit]', '.gp-theme .course-container input.button', '.gp-theme .course-container button.button', '.gp-theme .course a.button', '.gp-theme .course a.button:visited', '.gp-theme .course a.comment-reply-link', '.gp-theme .course #commentform #submit', '.gp-theme .course .submit', '.gp-theme .course input[type=submit]', '.gp-theme .course input.button', '.gp-theme .course button.button', '.gp-theme .lesson a.button', '.gp-theme .lesson a.button:visited', '.gp-theme .lesson a.comment-reply-link', '.gp-theme .lesson #commentform #submit', '.gp-theme .lesson .submit', '.gp-theme .lesson input[type=submit]', '.gp-theme .lesson input.button', '.gp-theme .lesson button.button', '.gp-theme .quiz a.button, .quiz a.button:visited', '.gp-theme .quiz a.comment-reply-link', '.gp-theme .quiz #commentform #submit', '.gp-theme .quiz .submit', '.gp-theme .quiz input[type=submit]', '.gp-theme .quiz input.button', '.gp-theme .quiz button.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce div.product form.cart .button, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce div.product form.cart .button:hover, .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce #respond input#submit.alt:disabled[disabled]:hover, .woocommerce input.button:disabled, .woocommerce input.button:disabled:hover, .woocommerce input.button:disabled[disabled], .woocommerce input.button:disabled[disabled]:hover, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled[disabled], .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled[disabled], .woocommerce button.button.alt:disabled[disabled]:hover, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt:disabled[disabled], .woocommerce input.button.alt:disabled[disabled]:hover, .pmpro_btn, .pmpro_btn:link, .pmpro_content_message a, .pmpro_content_message a:link, .pmpro_btn:hover, .pmpro_btn:focus, .pmpro_checkout .pmpro_btn:hover, .pmpro_checkout .pmpro_btn:focus, .pmpro_content_message a:focus, .pmpro_content_message a:hover' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '14px',
					'line-height' => '14px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '500',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#fff',
					'text-transform' => 'none',
				),
			),
				
		)		
	) );

	Redux::setSection( $opt_name, array(
		'id' => 'styling-footer',
		'title'     => esc_html__( 'Footer', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-photo',
		'fields'    => array(
														
			array(
				'id'        => 'footer_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Footer Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '#gp-footer' ),
				'default' => '#fff',
			),

			array(
				'id'        => 'footer_border',
				'type'      => 'color',
				'title'     => esc_html__( 'Footer Border Color', 'aardvark' ),
				'desc'  => esc_html__( 'Divides the footer widgets and copyright text.', 'aardvark' ),
				'output'    => array( 'border-color' => '#gp-footer, #gp-footer-widgets, .gp-footer-widget li' ),
				'default'   => '#e6e6e6',
			),

			array(
				'id'        => 'footer_widget_title_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Footer Widget Title Typography', 'aardvark' ),
				'output'    => array( '.gp-footer-widget .widgettitle', '.gp-footer-widget .widgettitle a' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '19px',
					'line-height' => '19px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#232323',
					'text-transform' => 'none',
				),
			),

			array(
				'id'        => 'footer_widget_text_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Footer Widget Text Typography', 'aardvark' ),
				'output'    => array( '.gp-footer-widget .widget' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '16px',
					'line-height' => '20px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#999',
					'text-transform' => 'none',
				),
			),
			
			array(
				'id'        => 'footer_widget_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Footer Widget Link Colors', 'aardvark' ),
				'output'    => array( '.gp-footer-widget .widget a' ),
				'default'   => array(
					'regular' => '#39c8df',
					'hover'   => '#00a0e3',
					'active'  => false,
				),
			),

			array(
				'id'        => 'copyright_text_typography',
				'type'      => 'typography',
				'title'     => esc_html__( 'Copyright Text Typography', 'aardvark' ),
				'output'    => array( '#gp-copyright' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '14px',
					'line-height' => '20px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#232323',
					'text-transform' => 'none',
				),
			),

			array(
				'id'        => 'copyright_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Copyright Link Colors', 'aardvark' ),
				'output'    => array( '#gp-copyright-text a' ),
				'default'   => array(
					'regular' => '#39c8df',
					'hover'   => '#00a0e3',
					'active'  => false,
				),
			),
						
			array(
				'id'        => 'footer_nav_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Footer Navigation Link Colors', 'aardvark' ),
				'output'    => array( '#gp-footer-nav > .menu > li > a' ),
				'default'   => array(
					'regular' => '#39c8df',
					'hover'   => '#00a0e3',
					'active'  => false,
				),
			),
																																										
			array(
				'id'        => 'back_to_top_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Back To Top Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '#gp-to-top' ),
				'default'   => '#000',
			),
														
			array(
				'id'        => 'back_to_top_icon_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Back To Top Icon Color', 'aardvark' ),
				'output'    => array( '#gp-to-top' ),
				'transparent' => false,
				'default'   => '#fff',
			),
																																	 
		)
	) );                    

	Redux::setSection( $opt_name, array(
		'id' => 'styling-misc',
		'title'     => esc_html__( 'Misc', 'aardvark' ),
		'subsection' => true,
		'icon' => 'el-icon-random',
		'fields'    => array(

			array(
				'id'        => 'misc_table_header_bg_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Table Header Background Color', 'aardvark' ),
				'output'    => array( 
					'background-color' => 'table thead td', 
					'border-color' => 'table thead td', 
				),
				'transparent' => false,
				'default' => '',
			),

			array(
				'id'        => 'misc_table_header_text_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Table Header Text Color', 'aardvark' ),
				'output'    => array( 
					'color' => 'table thead td', 
				),
				'transparent' => false,
				'default' => '',
			),
			
			array(
				'id'        => 'misc_table_body_bg_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Table Body Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => 'table tbody td', ),
				'transparent' => false,
				'default' => '',
			),	

			array(
				'id'        => 'misc_table_body_text_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Table Body Text Color', 'aardvark' ),
				'output'    => array( 
					'color' => 'table tbody td', 
				),
				'transparent' => false,
				'default' => '',
			),		
					
			array(
				'id'        => 'misc_tab_link_colors',
				'type'      => 'color',
				'title'     => esc_html__( 'Tab Link Colors', 'aardvark' ),
				'desc'  => esc_html__( 'Used for WooCommerce, BuddyPress and Sensei tabs.', 'aardvark' ),
				'output'    => array( 'color' => '.gp-theme #buddypress div.item-list-tabs ul li a, .gp-theme #buddypress .main-navs ul li a, .gp-theme #buddypress .bp-subnavs ul li a, .gp-theme #buddypress div.item-list-tabs ul li a span, .gp-theme #buddypress .main-navs ul li a span, .woocommerce-account .woocommerce-MyAccount-navigation li a, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .sensei-course-filters li a, .learner-profile #my-courses.ui-tabs .ui-tabs-nav li.ui-state-active a, .gp-theme #buddypress #gp-bp-tabs-button', ),
				'transparent' => false,
				'default' => '#232323',
			),

			array(
				'id'        => 'misc_price_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Price Color', 'aardvark' ),
				'desc'  => esc_html__( 'Used in WooCommerce and Sensei.', 'aardvark' ),
				'output'    => array( 'color' => '.gp-loop-price, .woocommerce ul.products li.product .price, .woocommerce div.product p.price, .woocommerce div.product span.price, .widget_sensei_category_courses .course-price, .widget_sensei_course_component .course-price', ),
				'transparent' => false,
				'default' => '#39c8df',
			),

			array(
				'id'        => 'misc_star_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Star Rating Color', 'aardvark' ),
				'desc'  => esc_html__( 'Used in WooCommerce.', 'aardvark' ),
				'output'    => array( 'color' => '.woocommerce .star-rating, .woocommerce p.stars a',
				),
				'transparent' => false,
				'default' => '#FFC01F',
			),

			array(
				'id'        => 'bp_activity_list_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'BuddyPress Activity List Background Color', 'aardvark' ),
				'output'    => array( 	
					'background-color' => '.gp-theme #buddypress .activity-list .activity-content, .gp-theme #buddypress #activity-stream .activity-comments ul, .gp-theme #buddypress div.activity-comments form.ac-form, .gp-theme #buddypress div#message-thread div.odd, .gp-theme #buddypress div#message-thread div.alt, .gp-theme #buddypress table#message-threads.sitewide-notices tr',
					'border-bottom-color' => '.gp-theme #buddypress div.activity-comments:after, .gp-theme #buddypress div#message-thread div.message-box:after, .gp-theme #buddypress table#message-threads.sitewide-notices tr:after',
				),
				'transparent' => false,
				'default' => '#f8f8f8',
			),

			array(
				'id'        => 'bp_activity_text_color',
				'type'      => 'color',
				'title'     => esc_html__( 'BuddyPress Activity Text Color', 'aardvark' ),
				'output'    => array( 'color' => '.gp-theme #buddypress ul.activity-list > li, .gp-theme #buddypress .activity-list .activity-content .activity-header, .gp-theme #buddypress .activity-list .activity-content .comment-header, .gp-theme #buddypress a.activity-time-since' ),
				'transparent' => false,
				'default'  => '#777',
			),

			array(
				'id'        => 'bp_activity_link_color',
				'type'      => 'link_color',
				'title'     => esc_html__( 'BuddyPress Activity Link Color', 'aardvark' ),
				'output'    => array( '.gp-theme #buddypress ul.activity-list > li a' ),
				'default' => array(
					'regular'  => '#39c8df',
					'hover'    => '#00a0e3',
					'active'   => false,
				),	
			),
									
			array(
				'id'        => 'bp_activity_button_text_color',
				'type'      => 'link_color',
				'title'     => esc_html__( 'BuddyPress Activity Button Text Color', 'aardvark' ),
				'output'    => array( '.gp-theme #buddypress ul.activity-list > li div.activity-meta a', '.gp-theme #buddypress ul.activity-list > li .acomment-options a' ),
				'default' => array(
					'regular' => '#999',
					'hover' => '#232323',
					'active'   => false,
				),	
			),


			array(
				'id'        => 'bbpress_forum_cat_header_text_color',
				'type'      => 'color',
				'title'     => esc_html__( 'bbPress Forum Category Header Text Color', 'aardvark' ),
				'output'    => array( '.gp-theme #bbpress-forums .gp-forum-home .bbp-forum-title, .gp-theme #bbpress-forums .bbp-topics .bbp-header, .gp-theme #bbpress-forums .bbp-replies .bbp-header, .gp-theme #bbpress-forums .bbp-search-results .bbp-header' ),
				'transparent' => false,
				'default'   => '#232323',
			),

			array(
				'id'        => 'bbpress_meta_text_color',
				'type'      => 'color',
				'title'     => esc_html__( 'bbPress Forum Meta Text Color', 'aardvark' ),
				'output'    => array( '.gp-theme #bbpress-forums .topic-reply-counts, .gp-theme #bbpress-forums .freshness-forum-link, .gp-theme #bbpress-forums .freshness-forum-link a, .gp-theme #bbpress-forums .bbp-topic-meta, .gp-theme #bbpress-forums .bbp-topic-meta a, .gp-theme #bbpress-forums .bbp-body .bbp-forum-freshness, .gp-theme #bbpress-forums .bbp-body .bbp-forum-freshness a, .gp-theme #bbpress-forums .bbp-body .bbp-topic-freshness a, .gp-theme #bbpress-forums .bbp-body .bbp-topic-voice-count, .gp-theme #bbpress-forums .bbp-body .bbp-topic-reply-count, .gp-theme #bbpress-forums .bbp-forum-header .bbp-meta, .gp-theme #bbpress-forums .bbp-topic-header .bbp-meta, .gp-theme #bbpress-forums .bbp-reply-header .bbp-meta, .gp-theme #bbpress-forums .bbp-author-role' ),
				'transparent' => false,
				'default'   => '#b1b1b1',
			),
													
			array(
				'id'        => 'bbpress_forum_border',
				'type'      => 'color',
				'title'     => esc_html__( 'bbPress Forum Border Color', 'aardvark' ),
				'output'    => array( 'border-color' => '.gp-theme #bbpress-forums .gp-forum-home li.odd-forum-row, .gp-theme #bbpress-forums .gp-forum-home li.even-forum-row,  .gp-theme #bbpress-forums .bbp-topics .bbp-header, .gp-theme #bbpress-forums div.bbp-forum-header, .gp-theme #bbpress-forums div.bbp-topic-header, .gp-theme #bbpress-forums div.bbp-reply-header, .gp-theme #bbpress-forums li.bbp-body ul.forum, .gp-theme #bbpress-forums .bbp-topics ul.topic' ),
				'default'   => '#e6e6e6',
			),
			
			array(
				'id'        => 'login_popup_bg',
				'type'      => 'color',
				'title'     => esc_html__( 'Login Popup Background Color', 'aardvark' ),
				'output'    => array( 'background-color' => '#gp-login-modal' ),
				'default' => '#fff',
			),
			
			array(
				'id'        => 'login_popup_title',
				'type'      => 'typography',
				'title'     => esc_html__( 'Login Popup Title Typography', 'aardvark' ),
				'output'    => array( '.gp-login-title' ),
				'google'    => true,
				'text-align' => false,
				'font-backup' => true,
				'text-transform' => true,
				'letter-spacing' => true,
				'default'   => array(
					'font-size'   => '19px',
					'line-height' => '19px',
					'font-family' => 'Roboto',
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '400',
					'subsets'     => 'latin',
					'letter-spacing' => '0px',
					'color' 	  => '#232323',
					'text-transform' => 'none',
				),
			),
			
			array(
				'id'        => 'login_popup_link_colors',
				'type'      => 'link_color',
				'title'     => esc_html__( 'Login Popup Link Colors', 'aardvark' ),
				'output'    => array( '#gp-login-close', '.gp-login-links a' ),
				'default'   => array(
					'regular' => '#232323',
					'hover'   => '#232323',
					'active'  => false,
				),
			),
																			
		)		
	) );
	

	Redux::setSection( $opt_name, array(
		'id' => 'theme_update',
		'title' => esc_html__( 'Theme Update', 'aardvark' ),
		'desc' => esc_html__( 'To automatically update the theme you need to enter your ThemeForest (Envato) username and API key.', 'aardvark' ) . '<br/>' . esc_html__( 'Please make a backup of the current theme files before you update the theme.', 'aardvark' ),
		'icon' => 'el-icon-key',
		'fields' => array(

			array(
				'id'       => 'tf_username',
				'type'     => 'text',
				'title'    => esc_html__( 'ThemeForest Username', 'aardvark' ),
				'default'  => ''
			),
			
			array(
				'id'       => 'tf_apikey',
				'type'     => 'text',
				'title'    => esc_html__( 'ThemeForest API Key', 'aardvark' ),
				'desc' => '<a href="https://ticksy_attachments.s3.amazonaws.com/9076411986.jpg" class="thickbox" target="_blank">' . esc_html__( 'See how to get your API Key', 'aardvark' ) . '</a>',
				'default'  => ''
			),
			
		)
	) );
 
    /*
     * <--- END SECTIONS
     */