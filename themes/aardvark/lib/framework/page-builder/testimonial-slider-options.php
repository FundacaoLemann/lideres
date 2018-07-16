<?php  if ( ! function_exists( 'ghostpool_wpb_testimonial_slider_options' ) ) {

	function ghostpool_wpb_testimonial_slider_options() {

		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			class WPBakeryShortCode_GP_Testimonial_Slider extends WPBakeryShortCodesContainer {}
		}
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_GP_Testimonial extends WPBakeryShortCode {}
		}
		vc_map( array( 
			'name' => esc_html__( 'Testimonial Slider', 'aardvark' ),
			'base' => 'gp_testimonial_slider',
			'description' => esc_html__( 'Testimonials slider.', 'aardvark' ),
			'as_parent' => array( 'only' => 'gp_testimonial' ), 
			'class' => 'wpb_vc_testimonial',
			'controls' => 'full',
			'icon' => 'gp-icon-testimonial-slider',
			'category' => esc_html__( 'Theme', 'aardvark' ),
			'js_view' => 'VcColumnView',
			'params' => array( 	
				array( 
					'heading' => esc_html__( 'Effect', 'aardvark' ),
					'param_name' => 'effect',
					'value' => array( 
						esc_html__( 'Slide', 'aardvark' ) => 'slide', 
						esc_html__( 'Fade', 'aardvark' ) => 'fade' 
					),
					'type' => 'dropdown'
				),
				array( 
					'heading' => esc_html__( 'Slider Speed', 'aardvark' ),
					'param_name' => 'speed',
					'value' => '0',
					'description' => esc_html__( 'The number of seconds between slide transitions, set to 0 to disable the autoplay.', 'aardvark' ),
					'type' => 'textfield',
				),
				array( 
					'heading' => esc_html__( 'Buttons', 'aardvark' ),
					'param_name' => 'buttons',
					'value' => array( 
						esc_html__( 'Hide', 'aardvark' ) => 'false', 
						esc_html__( 'Show', 'aardvark' ) => 'true' 
					),
					'type' => 'dropdown',
				),			
				array( 
					'heading' => esc_html__( 'Arrows', 'aardvark' ),
					'param_name' => 'arrows',
					'value' => array( 
						esc_html__( 'Show', 'aardvark' ) => 'true', 
						esc_html__( 'Hide', 'aardvark' ) => 'false' 
					),
					'type' => 'dropdown',
				),			
				array( 
					'heading' => esc_html__( 'Extra Class Name', 'aardvark' ),
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'aardvark' ),
					'param_name' => 'classes',
					'value' => '',
					'type' => 'textfield',
					),						
				array(
					'param_name' => 'styling_divider_begin',
					'type' => 'gp_divider',
					'edit_field_class' => 'vc_col-xs-12',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),						
				array( 
					'heading' => esc_html__( 'Headline Font Size', 'aardvark' ),
					'param_name' => 'headline_font_size',
					'value' => '18px',
					'type' => 'textfield',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),				
				array( 
					'heading' => esc_html__( 'Headline Line Height', 'aardvark' ),
					'param_name' => 'headline_line_height',
					'value' => '22px',
					'type' => 'textfield',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),				
				array( 
					'heading' => esc_html__( 'Quote Font Size', 'aardvark' ),
					'param_name' => 'quote_font_size',
					'value' => '16px',
					'type' => 'textfield',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),				
				array( 
					'heading' => esc_html__( 'Quote Line Height', 'aardvark' ),
					'param_name' => 'quote_line_height',
					'value' => '24px',
					'type' => 'textfield',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),				
				array( 
					'heading' => esc_html__( 'Name Font Size', 'aardvark' ),
					'param_name' => 'name_font_size',
					'value' => '14px',
					'type' => 'textfield',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),				
				array( 
					'heading' => esc_html__( 'Name Line Height', 'aardvark' ),
					'param_name' => 'name_line_height',
					'value' => '18px',
					'type' => 'textfield',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),
				array( 
					'heading' => esc_html__( 'Image Border Color', 'aardvark' ),
					'param_name' => 'avatar_border_color',
					'value' => '',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),
				array( 
					'heading' => esc_html__( 'Headline Color', 'aardvark' ),
					'param_name' => 'headline_color',
					'value' => '',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),	
				array( 
					'heading' => esc_html__( 'Quote Color', 'aardvark' ),
					'param_name' => 'quote_color',
					'value' => '',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),	
				array( 
					'heading' => esc_html__( 'Name Color', 'aardvark' ),
					'param_name' => 'name_color',
					'value' => '',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),	
				array(
					'param_name' => 'styling_divider_end',
					'type' => 'gp_divider',
					'edit_field_class' => 'vc_col-xs-12',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),
				array(
					'heading' => esc_html__( 'CSS', 'aardvark' ),
					'type' => 'css_editor',
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),																																													
			 ),
			'js_view' => 'VcColumnView'
		 ) );

		vc_map( array( 
			'name' => esc_html__( 'Testimonial', 'aardvark' ),
			'base' => 'gp_testimonial',
			'content_element' => true,
			'as_child' => array( 'only' => 'gp_testimonial_slider' ),
			'icon' => 'gp-icon-testimonial-slider',
			'params' => array( 	
				array( 
				'heading' => esc_html__( 'Image', 'aardvark' ),
				'param_name' => 'image',
				'value' => '',
				'type' => 'attach_image'
				),
				array( 
				'heading' => esc_html__( 'Headline', 'aardvark' ),
				'param_name' => 'headline',
				'value' => '',
				'type' => 'textfield',
				),
				array( 
				'heading' => esc_html__( 'Quote', 'aardvark' ),
				'param_name' => 'content',
				'value' => '',
				'type' => 'textarea',
				),		
				array( 
				'heading' => esc_html__( 'Name', 'aardvark' ),
				'param_name' => 'name',
				'value' => '',
				'type' => 'textfield',
				'admin_label' => true,
				),																																							
			 )
		 ) );																																
	}
	
}
add_action( 'vc_before_init', 'ghostpool_wpb_testimonial_slider_options' ); ?>