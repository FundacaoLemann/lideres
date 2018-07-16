<?php if ( ! function_exists( 'ghostpool_wpb_carousel_images_options' ) ) {

	function ghostpool_wpb_carousel_images_options() { 

		vc_map( array( 
			'name' => esc_html__( 'Carousel Images', 'aardvark' ),
			'base' => 'gp_carousel_images',
			'description' => esc_html__( 'Image carousel.', 'aardvark' ),
			'class' => 'wpb_vc_carousel_images',
			'controls' => 'full',
			'icon' => 'gp-icon-carousel',
			'category' => esc_html__( 'Theme', 'aardvark' ),
			'front_enqueue_js' => array( get_template_directory_uri() . '/lib/scripts/jquery.flexslider-min.js' ),
			'params' => array(				
				array( 
					'heading' => esc_html__( 'Title', 'aardvark' ),
					'param_name' => 'widget_title',
					'type' => 'textfield',
					'admin_label' => true,
				),		
				array( 
					'param_name' => 'images',
					'heading' => esc_html__( 'Images', 'aardvark' ),
					'type' => 'attach_images',
				),
				array( 
					'heading' => esc_html__( 'Image Link', 'aardvark' ),
					'param_name' => 'image_link',
					'value' => array(
						esc_html__( 'Lightbox', 'aardvark' ) => 'lightbox',
						esc_html__( 'Image URL', 'aardvark' ) => 'url',
						esc_html__( 'Disabled', 'aardvark' ) => 'disabled',
					),
					'std' => 'lightbox',
					'type' => 'dropdown',
				),
				array( 
					'heading' => esc_html__( 'Items In View', 'aardvark' ),
					'description' => esc_html__( 'Set to 0 to keep images at a fixed width.', 'aardvark' ),
					'param_name' => 'items_in_view',
					'value' => '0',
					'type' => 'textfield',
				),
				array( 
					'heading' => esc_html__( 'Image Size', 'aardvark' ),
					'description' => esc_html__( 'Choose from one of the default image sizes or you can register your own image size as explained', 'aardvark' ) . ' <a href="' . esc_url( 'https://ghostpool.ticksy.com/article/10923' ) . '" target="_blank">'. esc_html__( 'here', 'aardvark' ) . '</a>.',
					'param_name' => 'image_size',
					'type'     => 'dropdown',
					'value' => ghostpool_wpb_image_size_field( false ),
					'std' => 'gp_square_image',
				),
				array( 
					'heading' => esc_html__( 'Carousel Speed', 'aardvark' ),
					'description' => esc_html__( 'The number of seconds before the carousel goes to the next set of items.', 'aardvark' ),
					'param_name' => 'slider_speed',
					'value' => '0',
					'type' => 'textfield',
				),
				array( 
					'heading' => esc_html__( 'Animation Speed', 'aardvark' ),
					'param_name' => 'animation_speed',
					'value' => '0.6',
					'type' => 'textfield',		
				),	
				array( 
					'heading' => esc_html__( 'Navigation Buttons', 'aardvark' ),
					'param_name' => 'buttons',
					'value' => array(
						esc_html__( 'Enabled', 'aardvark' ) => 'enabled',
						esc_html__( 'Disabled', 'aardvark' ) => 'disabled',
					),
					'std' => 'disabled',
					'type' => 'dropdown',
				),					
				array( 
					'heading' => esc_html__( 'Navigation Arrows', 'aardvark' ),
					'param_name' => 'arrows',
					'value' => array(
						esc_html__( 'Enabled', 'aardvark' ) => 'enabled',
						esc_html__( 'Disabled', 'aardvark' ) => 'disabled',
					),
					'std' => 'enabled',
					'type' => 'dropdown',
				),
				array( 
					'heading' => esc_html__( 'Extra Class Name', 'aardvark' ),
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'aardvark' ),
					'param_name' => 'classes',
					'type' => 'textfield',
				),
				array(
					'param_name' => 'styling_divider_begin',
					'type' => 'gp_divider',
					'dependency' => array( 'element' => 'type', 'value' => 'posts-pages' ),
					'edit_field_class' => 'vc_col-xs-12',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				), 			 				 		   			 			 
				array( 
					'heading' => esc_html__( 'Title Icon Color', 'aardvark' ),
					'param_name' => 'icon_color',
					'type' => 'colorpicker',
					'dependency' => array( 'element' => 'type', 'value' => 'posts-pages' ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),
				array( 
					'heading' => esc_html__( 'Title Icon', 'aardvark' ),
					'param_name' => 'icon',
					'type' => 'iconpicker',
					'dependency' => array( 'element' => 'type', 'value' => 'posts-pages' ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),
				array(
					'param_name' => 'styling_divider_end',
					'type' => 'gp_divider',
					'dependency' => array( 'element' => 'type', 'value' => 'posts-pages' ),
					'edit_field_class' => 'vc_col-xs-12',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),					
				array(
				'heading' => esc_html__( 'CSS', 'aardvark' ),
				'type' => 'css_editor',
				'param_name' => 'css',
				'group' => esc_html__( 'Design Options', 'aardvark' ),
				),
																																																					
			 )
		) );
		
	}		
} 
add_action( 'vc_before_init', 'ghostpool_wpb_carousel_images_options' ); ?>