<?php  if ( ! function_exists( 'ghostpool_wpb_pricing_column_options' ) ) {

	function ghostpool_wpb_pricing_column_options() {

		vc_map( array( 
			'name' => esc_html__( 'Pricing Column', 'aardvark' ),
			'base' => 'gp_pricing_column',
			'description' => esc_html__( 'Pricing column.', 'aardvark' ),
			'class' => 'wpb_vc_pricing_column',
			'controls' => 'full',
			'icon' => 'gp-icon-pricing-column',
			'category' => esc_html__( 'Theme', 'aardvark' ),
			'params' => array( 
			
				array( 
					'heading' => esc_html__( 'Membership Level', 'aardvark' ),
					'description' => esc_html__( 'Enter the membership level ID (requires Paid Membership Pro plugin) you want to show details for, you can then leave the title, pricing and button fields empty.', 'aardvark' ),
					'param_name' => 'level_id',
					'value' => '',
					'type' => 'textfield',
				),
				array( 
					'heading' => esc_html__( 'Title', 'aardvark' ),
					'description' => esc_html__( 'E.g. Bronze, Silver, Gold.', 'aardvark' ),
					'param_name' => 'title',
					'value' => '',
					'type' => 'textfield',
					'admin_label' => true,
				),
				array( 
					'heading' => esc_html__( 'Currency Symbol', 'aardvark' ),
					'param_name' => 'currency_symbol',
					'value' => '',
					'type' => 'textfield',
					'edit_field_class' => 'vc_col-xs-4 ',
				),
				array( 
					'heading' => esc_html__( 'Price', 'aardvark' ),
					'param_name' => 'price',
					'value' => '',
					'type' => 'textfield',
					'edit_field_class' => 'vc_col-xs-4',
				),	
				array( 
					'heading' => esc_html__( 'Trial Price', 'aardvark' ),
					'param_name' => 'trial_price',
					'value' => '',
					'type' => 'textfield',
					'edit_field_class' => 'vc_col-xs-4',
				),		
				array( 
					'heading' => esc_html__( 'Payment Interval', 'aardvark' ),
					'description' => esc_html__( 'E.g. per week, per month.', 'aardvark' ),
					'param_name' => 'payment_interval',
					'value' => '',
					'type' => 'textfield',
					'edit_field_class' => 'vc_col-xs-4',
				),		
				array( 
					'heading' => esc_html__( 'Highlight Column', 'aardvark' ),
					'param_name' => 'highlight',
					'value' => array( esc_html__( 'Disabled', 'aardvark' ) => 'gp-normal-column', esc_html__( 'Enabled', 'aardvark' ) => 'gp-highlight-column' ),
					'type' => 'dropdown'
				),	
				array( 
					'heading' => esc_html__( 'Highlight Text', 'aardvark' ),
					'param_name' => 'highlight_text',
					'value' => '',
					'dependency' => array( 'element' => 'highlight', 'value' => 'gp-highlight-column' ),
					'type' => 'textfield',
				),
				array( 
					'heading' => esc_html__( 'Content', 'aardvark' ),
					'description' => esc_html__( 'Use the Bulleted List button to create a list of features.', 'aardvark' ),
					'param_name' => 'content',
					'type' => 'textarea_html',
				),	
				array( 
					'heading' => esc_html__( 'Button Text', 'aardvark' ),
					'param_name' => 'button_text',
					'value' => '',
					'type' => 'textfield',
				),							
				array( 
					'heading' => esc_html__( 'Button Link', 'aardvark' ),
					'param_name' => 'button_link',
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
					'heading' => esc_html__( 'Style', 'aardvark' ),
					'param_name' => 'style',
					'value' => array( 
						esc_html__( 'Style 1', 'aardvark' ) => 'gp-style-1', 
						esc_html__( 'Style 2', 'aardvark' ) => 'gp-style-2',
						esc_html__( 'Style 3', 'aardvark' ) => 'gp-style-3',
					),
					'type' => 'dropdown',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),
				array( 
					'heading' => esc_html__( 'Title Background Color', 'aardvark' ),
					'param_name' => 'title_bg_color',
					'value' => '#232323',
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),
				array( 
					'heading' => esc_html__( 'Highlight Title Background Color', 'aardvark' ),
					'param_name' => 'highlight_title_bg_color',
					'value' => '#fd643b',
					'dependency' => array( 'element' => 'highlight', 'value' => 'gp-highlight-column' ),
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),	
				array( 
					'heading' => esc_html__( 'Title Text Color', 'aardvark' ),
					'param_name' => 'title_text_color',
					'value' => '#fff',
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),		
				array( 
					'heading' => esc_html__( 'Highlight Title Text Color', 'aardvark' ),
					'param_name' => 'highlight_title_text_color',
					'value' => '#fff',
					'dependency' => array( 
						'element' => 'highlight', 
						'value' => 'gp-highlight-column' 
					),
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				), 
				array( 
					'heading' => esc_html__( 'Price Background Color', 'aardvark' ),
					'param_name' => 'price_bg_color',
					'value' => '#fff',
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),
				array( 
					'heading' => esc_html__( 'Price Circle Color', 'aardvark' ),
					'param_name' => 'price_circle_color',
					'value' => '#f8f8f8',
					'type' => 'colorpicker',
					'dependency' => array( 
						'element' => 'style', 
						'value' => 'gp-style-2' 
					),
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),	
				array( 
					'heading' => esc_html__( 'Price Text Color', 'aardvark' ),
					'param_name' => 'price_text_color',
					'value' => '#232323',
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),	
				array( 
					'heading' => esc_html__( 'Content Background Color', 'aardvark' ),
					'param_name' => 'content_bg_color',
					'value' => '#fff',
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),
				array( 
					'heading' => esc_html__( 'Alternative Content Background Color', 'aardvark' ),
					'param_name' => 'content_bg_color_alt',
					'value' => '#f8f8f8',
					'type' => 'colorpicker',
					'dependency' => array( 
						'element' => 'style', 
						'value' => 'gp-style-2' 
					),
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),	
				array( 
					'heading' => esc_html__( 'Content Text Color', 'aardvark' ),
					'param_name' => 'content_text_color',
					'value' => '#232323',
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),
				array( 
					'heading' => esc_html__( 'Footer Background Color', 'aardvark' ),
					'param_name' => 'footer_bg_color',
					'value' => '#fff',
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),
				array( 
					'heading' => esc_html__( 'Button Background Color', 'aardvark' ),
					'param_name' => 'button_bg_color',
					'value' => '#39c8df',
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),
				array( 
					'heading' => esc_html__( 'Button Background Hover Color', 'aardvark' ),
					'param_name' => 'button_bg_hover_color',
					'value' => '#00a0e3',
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),
				array( 
					'heading' => esc_html__( 'Button Text Color', 'aardvark' ),
					'param_name' => 'button_text_color',
					'value' => '#fff',
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),			 
				array( 
					'heading' => esc_html__( 'Divider Color', 'aardvark' ),
					'param_name' => 'divider_color',
					'value' => '#e6e6e6',
					'dependency' => array( 
						'element' => 'style', 
						'value' => array( 'gp-style-1', 'gp-style-3' ), 
					),
					'type' => 'colorpicker',
					'edit_field_class' => 'vc_col-xs-4',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),	
				array(
					'param_name' => 'styling_divider_end',
					'type' => 'gp_divider',
					'edit_field_class' => 'vc_col-xs-12',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),
				array( 
					'heading' => esc_html__( 'Extra Class Name', 'aardvark' ),
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'aardvark' ),
					'param_name' => 'classes',
					'value' => '',
					'type' => 'textfield',
				),					
				/*array(
					'heading' => esc_html__( 'CSS', 'aardvark' ),
					'type' => 'css_editor',
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),*/
																																							
			 )
		 ) );
		 
	}		
} 
add_action( 'init', 'ghostpool_wpb_pricing_column_options' ); ?>