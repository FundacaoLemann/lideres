<?php if ( function_exists( 'bp_is_active' ) && defined( 'BPS_FORM' ) ) {

	if ( ! function_exists( 'ghostpool_wpb_bp_profile_search_options' ) ) {
		function ghostpool_wpb_bp_profile_search_options() {

			vc_map( array( 
				'name' => esc_html__( 'BP Profile Search', 'aardvark' ),
				'base' => 'gp_bp_profile_search',
				'description' => esc_html__( 'BP profile search form.', 'aardvark' ),
				'class' => 'wpb_vc_bp_profile_search',
				'controls' => 'full',
				'icon' => 'gp-icon-bp-profile-search',
				'category' => esc_html__( 'Theme', 'aardvark' ),
				'params' => array(
			
					array( 
					'heading' => esc_html__( 'Title', 'aardvark' ),
					'param_name' => 'title',
					'value' => '',
					'type' => 'textfield',
					),			
					array( 
					'heading' => esc_html__( 'Form ID', 'aardvark' ),
					'description' => esc_html__( 'The ID of the form you want to display. You can create forms by clicking', 'aardvark' ) . ' <a href="' . admin_url( 'edit.php?post_type=bps_form' ) . '" target="_blank">' . esc_html__( 'here', 'aardvark' ). '</a>.',
					'param_name' => 'form_id',
					'value' => '',
					'type' => 'textfield',
					),
					array( 
					'heading' => esc_html__( 'Display', 'aardvark' ),
					'param_name' => 'display',
					'value' => array( 
						esc_html__( 'Show for everyone', 'aardvark' ) => 'all',
						esc_html__( 'Show for members only', 'aardvark' ) => 'members',
						esc_html__( 'Show login form for guests', 'aardvark' ) => 'login-form',
					),
					'type' => 'dropdown',
					),
					array( 
					'heading' => esc_html__( 'Format', 'aardvark' ),
					'param_name' => 'format',
					'value' => array( 
						esc_html__( 'Large', 'aardvark' ) => 'gp-large',
						esc_html__( 'Small', 'aardvark' ) => 'gp-small',
					),
					'type' => 'dropdown',
					),
					/*array( 
						'heading' => esc_html__( 'Template Name', 'aardvark' ),
						'description' => esc_html__( 'Leave blank to use the default template.', 'aardvark' ),
						'param_name' => 'template_name',
						'value' => '',
						'type' => 'textfield',
					),*/	 				 		   			 			 
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
					'heading' => esc_html__( 'Text Color', 'aardvark' ),
					'param_name' => 'text_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),	
					array( 
					'heading' => esc_html__( 'Background Color', 'aardvark' ),
					'param_name' => 'box_bg_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),	
					array( 
					'heading' => esc_html__( 'Border Color', 'aardvark' ),
					'param_name' => 'box_border_color',
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
								
				 )
			) );		

		}
	}	
	add_action( 'vc_before_init', 'ghostpool_wpb_bp_profile_search_options' ); 
	
} ?>