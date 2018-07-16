<?php 

/**
* Add background hover option to vc_btn element
*
*/
$attributes = array(
	'type' => 'colorpicker',
	'heading' => esc_html__( 'Background Hover', 'aardvark' ),
	'param_name' => 'custom_background_hover',
	'description' => esc_html__( 'Select custom background hover color for your element.', 'aardvark' ),
	'dependency' => array(
		'element' => 'style',
		'value' => array( 'custom' ),
	),
	'edit_field_class' => 'vc_col-sm-6',
	'std' => '#777',
);
vc_add_param( 'vc_btn', $attributes );
	
/**
* Add custom horizontal tab styling options
*
*/
if ( ! function_exists( 'ghostpool_add_custom_htab_options' ) ) {
	function ghostpool_add_custom_htab_options() {
		$param = WPBMap::getParam( 'vc_tta_tabs', 'style' );
		$param['value'][esc_html__( 'GP Style 1', 'aardvark' )] = 'gp-1';
		$param['value'][esc_html__( 'GP Style 2', 'aardvark' )] = 'gp-2';
		$param['value'][esc_html__( 'GP Style 3', 'aardvark' )] = 'gp-3';
		vc_update_shortcode_param( 'vc_tta_tabs', $param );
	}
}
add_action( 'vc_after_init', 'ghostpool_add_custom_htab_options' );

/**
* Add custom vertical tab styling options
*
*/
if ( ! function_exists( 'ghostpool_add_custom_vtab_options' ) ) {
	function ghostpool_add_custom_vtab_options() {
		$param = WPBMap::getParam( 'vc_tta_tour', 'style' );
		$param['value'][esc_html__( 'GP Style 1', 'aardvark' )] = 'gp-1';
		$param['value'][esc_html__( 'GP Style 2', 'aardvark' )] = 'gp-2';
		$param['value'][esc_html__( 'GP Style 3', 'aardvark' )] = 'gp-3';
		vc_update_shortcode_param( 'vc_tta_tour', $param );
	}
}
add_action( 'vc_after_init', 'ghostpool_add_custom_vtab_options' );

/**
* Add new element tags
*
*/
if ( ! function_exists( 'ghostpool_vc_font_container_get_allowed_tags' ) ) {
	function ghostpool_vc_font_container_get_allowed_tags( $allowed_tags ) {
		$new_elements = array( 'span' );
		return array_merge( $allowed_tags, $new_elements );
	}
}
add_filter( 'vc_font_container_get_allowed_tags', 'ghostpool_vc_font_container_get_allowed_tags' );

/**
* Add custom hover box color options
*
*/
if ( ! function_exists( 'ghostpool_add_custom_hover_box_options' ) ) {
	function ghostpool_add_custom_hover_box_options() {
		$param = WPBMap::getParam( 'vc_hoverbox', 'hover_background_color' );
		$param['value'][esc_html__( 'GP Primary Color', 'aardvark' )] = 'gp-primary-color';
		vc_update_shortcode_param( 'vc_hoverbox', $param );
	}
}
add_action( 'vc_after_init', 'ghostpool_add_custom_hover_box_options' );

/**
* Add user status support to vc_row element
*
*/
$attributes = array(
	'param_name' => 'user_status',
	'heading' => esc_html__( 'Logged In/Out Display', 'aardvark' ),
	'description' => esc_html__( 'Choose what users see this row.', 'aardvark' ),
	'type' => 'dropdown',
	'type' => 'dropdown',
	'value' => array(
		esc_html__( 'Show for all users', 'aardvark' ) => 'all', 
		esc_html__( 'Show for logged in users only', 'aardvark' ) => 'logged-in',
		esc_html__( 'Show for logged out users only', 'aardvark' ) => 'logged-out',
	),
	'std' => 'all',
);
vc_add_param( 'vc_row', $attributes );

/**
* Add membership levels support to vc_row element
*
*/
if ( defined( 'PMPRO_VERSION' ) ) {
	$attributes = array(
		'param_name' => 'membership_levels',
		'heading' => esc_html__( 'Membership Levels', 'aardvark' ),
		'description' => esc_html__( 'Enter the ID or name of the membership levels you want to see this row, separating each with a comma. Enter 0 to display row for non-members.', 'aardvark' ),
		'type' => 'textfield',
		'value' => '',
	);
	vc_add_param( 'vc_row', $attributes );
}

/**
* Add masonry support to vc_row element
*
*/
$attributes = array(
	'param_name' => 'masonry_support',
	'heading' => esc_html__( 'Masonry Support', 'aardvark' ),
	'description' => esc_html__( 'Elements added within this row will be arranged in a masonry format.', 'aardvark' ),
	'type' => 'checkbox',
	'value' => true,
);
vc_add_param( 'vc_row', $attributes );

/**
* Add background position option to vc_row element
*
*/
$attributes = array(
	'param_name' => 'background_position',
	'heading' => esc_html__( 'Background Position', 'aardvark' ),
	'group' => esc_html__( 'Design Options', 'aardvark' ),
	'type' => 'dropdown',
	'value' => array(
		esc_html__( 'Top Left', 'aardvark' ) => 'left top', 
		esc_html__( 'Top Center', 'aardvark' ) => 'center top',
		esc_html__( 'Top Right', 'aardvark' ) => 'right top',
		esc_html__( 'Center Left', 'aardvark' ) => 'left center',
		esc_html__( 'Center Center', 'aardvark' ) => 'center center',
		esc_html__( 'Center Right', 'aardvark' ) => 'right center',
		esc_html__( 'Bottom Left', 'aardvark' ) => 'left bottom',
		esc_html__( 'Bottom Center', 'aardvark' ) => 'center bottom',
		esc_html__( 'Bottom Right', 'aardvark' ) => 'right bottom',
	),
	'std' => 'center center',
	'edit_field_class' => 'vc_col-xs-5',
);
vc_add_param( 'vc_column', $attributes );
vc_add_param( 'vc_row', $attributes );

/**
* Add video background image on mobile option to vc_row element
*
*/
$attributes = array(
	'param_name' => 'video_bg_image',
	'heading' => esc_html__( 'Video Background Image', 'aardvark' ),
	'type' => 'attach_image',			
	'dependency' => array(
		'element' => 'video_bg',
		'not_empty' => true,
	),
);
vc_add_param( 'vc_row', $attributes );
				
/**
* Add gradient background options to vc_row element
*
*/
$attributes = array(

	array(	
		'param_name' => 'animated_bg',	
		'heading' => esc_html__( 'Animated Background', 'aardvark' ),
		'description' => esc_html__( 'Choose to use an animated background.', 'aardvark' ),
		'group' => esc_html__( 'Design Options', 'aardvark' ),
		'type' => 'checkbox',
		'value' => '1',
	),

	array( 
		'param_name' => 'animated_bg_type',
		'heading' => esc_html__( 'Type', 'aardvark' ),
		'description' => esc_html__( 'The type of animated background.', 'aardvark' ),
		'group' => esc_html__( 'Design Options', 'aardvark' ),
		'type' => 'dropdown',
		'value' => array( 
			esc_html__( 'Scrolling Gradient', 'aardvark' ) => 'gp-scrolling-gradient', 
			esc_html__( 'Scrolling Image', 'aardvark' ) => 'gp-scrolling-image',
			esc_html__( 'Static Gradient', 'aardvark' ) => 'gp-static-gradient', 
		),
		'dependency' => array( 
			'element' => 'animated_bg', 
			'not_empty' => true,
		),
	),

	array( 
		'param_name' => 'gradient_style',
		'heading' => esc_html__( 'Gradient Style', 'aardvark' ),
		'description' => esc_html__( 'The style of gradient.', 'aardvark' ),
		'group' => esc_html__( 'Design Options', 'aardvark' ),
		'type' => 'dropdown',
		'value' => array( 
			esc_html__( 'Style 1', 'aardvark' ) => 'gradient-style-1', 
			esc_html__( 'Custom', 'aardvark' ) => 'custom-gradient',
		),
		'dependency' => array( 'element' => 'animated_bg', 'not_empty' => true ),
	),
					
	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Color 1', 'aardvark' ),
		'param_name' => 'gradient_color_1',
		'group' => esc_html__( 'Design Options', 'aardvark' ),
		'value' => '#ee7752',
		'dependency' => array( 
			'element' => 'gradient_style', 
			'value' => 'gradient-style-1'
		),
	),

	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Color 2', 'aardvark' ),
		'param_name' => 'gradient_color_2',
		'group' => esc_html__( 'Design Options', 'aardvark' ),
		'value' => '#e73c7e',
		'dependency' => array( 
			'element' => 'gradient_style', 
			'value' => 'gradient-style-1'
		),
	),

	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Color 3', 'aardvark' ),
		'param_name' => 'gradient_color_3',
		'group' => esc_html__( 'Design Options', 'aardvark' ),
		'value' => '#39c8df',
		'dependency' => array( 
			'element' => 'gradient_style', 
			'value' => 'gradient-style-1'
		),
	),
	
	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Color 4', 'aardvark' ),
		'param_name' => 'gradient_color_4',
		'group' => esc_html__( 'Design Options', 'aardvark' ),
		'value' => '#deb',
		'dependency' => array( 
			'element' => 'gradient_style', 
			'value' => 'gradient-style-1'
		),
	),
					
	array(
		'type' => 'textarea',
		'heading' => esc_html__( 'Custom Gradient CSS', 'aardvark' ),
		'description' => esc_html__( 'Add custom CSS to create your own gradient. You can generate gradient CSS using', 'aardvark' ) . ' <a href="http://www.colorzilla.com/gradient-editor/" target="_blank">' . esc_html__( 'Ultimate CSS Gradient Generator', 'aardvark' ) . '</a>.',
		'param_name' => 'custom_gradient_css',
		'group' => esc_html__( 'Design Options', 'aardvark' ),
		'dependency' => array( 
			'element' => 'gradient_style', 
			'value' => 'custom-gradient'
		),
	),	
	
);
vc_add_params( 'vc_row', $attributes );

?>