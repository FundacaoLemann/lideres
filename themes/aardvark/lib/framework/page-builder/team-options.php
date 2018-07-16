<?php  if ( ! function_exists( 'ghostpool_wpb_team_options' ) ) {

	function ghostpool_wpb_team_options() {

		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			class WPBakeryShortCode_GP_Team extends WPBakeryShortCodesContainer {}
		}
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_GP_Team_Member extends WPBakeryShortCode {}	
		}
			
		vc_map( array( 
			'name' => esc_html__( 'Team', 'aardvark' ),
			'base' => 'gp_team',
			'description' => esc_html__( 'Team members.', 'aardvark' ),
			'as_parent' => array( 'only' => 'gp_team_member' ), 
			'class' => 'wpb_vc_team',
			'controls' => 'full',
			'icon' => 'gp-icon-team',
			'category' => esc_html__( 'Theme', 'aardvark' ),
			'js_view' => 'VcColumnView',
			'params' => array( 	
				array( 
				'heading' => esc_html__( 'Columns', 'aardvark' ),
				'param_name' => 'columns',
				'value' => '3',
				'type' => 'textfield',
				),		
				array(
					'heading' => esc_html__( 'Column Spacing (px)', 'aardvark' ),
					'param_name' => 'column_spacing',
					'value' => '30',
					'type' => 'textfield',
				),	
 				array( 
					'heading' => esc_html__( 'Image Width', 'aardvark' ),
					'param_name' => 'image_width',
					'value' => '250',
					'type' => 'textfield',
				),		
				array( 
					'heading' => esc_html__( 'Image Height', 'aardvark' ),
					'param_name' => 'image_height',
					'value' => '250',
					'type' => 'textfield',
				),
				array( 
					'heading' => esc_html__( 'Image Border', 'aardvark' ),
					'param_name' => 'image_border',
					'value' => 'rgba(0,0,0,0.1)',
					'type' => 'colorpicker',
				),				
				array( 
					'heading' => esc_html__( 'Extra Class Name', 'aardvark' ),
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'aardvark' ),
					'param_name' => 'classes',
					'value' => '',
					'type' => 'textfield',
				),						
				array(
					'heading' => esc_html__( 'CSS', 'aardvark' ),
					'type' => 'css_editor',
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),																																							
			 ),
			'js_view' => 'VcColumnView',
		) );

		vc_map( array( 
			'name' => esc_html__( 'Team Member', 'aardvark' ),
			'base' => 'gp_team_member',
			'icon' => 'gp-icon-team',
			'content_element' => true,
			'as_child' => array( 'only' => 'gp_team' ),
			'params' => array( 	
				array( 
				'heading' => esc_html__( 'Image', 'aardvark' ),
				'param_name' => 'image',
				'value' => '',
				'type' => 'attach_image'
				),							
				array( 
				'heading' => esc_html__( 'Name', 'aardvark' ),
				'param_name' => 'name',
				'admin_label' => true,
				'value' => '',
				'type' => 'textfield'
				),	
				array( 
				'heading' => esc_html__( 'Job Position', 'aardvark' ),
				'param_name' => 'position',
				'value' => '',
				'type' => 'textfield',
				),
				array( 
				'heading' => esc_html__( 'Link', 'aardvark' ),
				'param_name' => 'link',
				'value' => '',
				'type' => 'textfield',
				),	
				array( 
				'heading' => esc_html__( 'Link Target', 'aardvark' ),
				'param_name' => 'link_target',
				'value' => array( esc_html__( 'Same Window', 'aardvark' ) => '_self', esc_html__( 'New Window', 'aardvark' ) => '_blank' ),
				'type' => 'dropdown',
				'dependency' => array( 'element' => 'link', 'not_empty' => true ),
				),				
				array( 
				'heading' => esc_html__( 'Description', 'aardvark' ),
				'param_name' => 'content',
				'value' => '',
				'type' => 'textarea_html',
				),																																								
			 )
		 ) );
	
	}		 
} 
add_action( 'vc_before_init', 'ghostpool_wpb_team_options' ); ?>