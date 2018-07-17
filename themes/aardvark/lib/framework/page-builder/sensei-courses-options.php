<?php if ( function_exists( 'is_sensei' ) ) {

	if ( ! function_exists( 'ghostpool_wpb_courses_options' ) ) {
		function ghostpool_wpb_courses_options() {

			vc_map( array( 
				'name' => esc_html__( 'Courses', 'aardvark' ),
				'base' => 'gp_sensei_courses',
				'description' => esc_html__( 'Sensei courses.', 'aardvark' ),
				'class' => 'wpb_vc_courses',
				'controls' => 'full',
				'icon' => 'gp-icon-courses',
				'category' => esc_html__( 'Theme', 'aardvark' ),
				'params' => array(
				
					array( 
					'heading' => esc_html__( 'Format', 'aardvark' ),
					'param_name' => 'format',
					'value' => array(
						esc_html__( 'Masonry', 'aardvark' ) => 'gp-posts-masonry',
						esc_html__( 'List', 'aardvark' ) => 'gp-posts-list',
						esc_html__( 'Large', 'aardvark' ) => 'gp-posts-large', 
						esc_html__( '2 Columns', 'aardvark' ) => 'gp-posts-columns-2', 
						esc_html__( '3 Columns', 'aardvark' ) => 'gp-posts-columns-3', 
						esc_html__( '4 Columns', 'aardvark' ) => 'gp-posts-columns-4',
					),
					'type' => 'dropdown',
					),					
					array( 
						'param_name' => 'style',
						'heading' => esc_html__( 'Style', 'aardvark' ),
						'type' => 'dropdown',
						'value' => array( 
							esc_html__( 'Classic', 'aardvark' ) => 'gp-style-classic',
							esc_html__( 'Modern', 'aardvark' ) => 'gp-style-modern',
						),
					),											
					array( 				
						'param_name' => 'alignment',
						'heading' => esc_html__( 'Content Alignment', 'aardvark' ),
						'type' => 'dropdown',
						'value' => array(
							esc_html__( 'Left Aligned', 'aardvark' ) => 'gp-align-left',
							esc_html__( 'Center Aligned', 'aardvark' ) => 'gp-align-center',
						),
					),		
					array( 
					'heading' => esc_html__( 'Teacher', 'aardvark' ),
					'description' => esc_html__( 'Show courses from specific teachers, enter the user IDs separating each one with a comma.', 'aardvark' ),
					'param_name' => 'teacher',
					'type' => 'textfield',
					'value' => '',
					),			
					array( 
					'heading' => esc_html__( 'Categories', 'aardvark' ),
					'description' => esc_html__( 'Show courses from specific categories, enter the slugs, terms or IDs separating each one with a comma.', 'aardvark' ),
					'param_name' => 'cats',
					'type' => 'textfield',
					'value' => '',
					),			
					array( 
					'heading' => esc_html__( 'Exclude', 'aardvark' ),
					'description' => esc_html__( 'Specific courses to exclude from display, enter the course IDs separating each one with a comma.', 'aardvark' ),
					'param_name' => 'exclude',
					'type' => 'textfield',
					'value' => '',
					),			
					array( 
					'heading' => esc_html__( 'Include', 'aardvark' ),
					'description' => esc_html__( 'Specific courses to display, enter the course IDs separating each one with a comma.', 'aardvark' ),
					'param_name' => 'include',
					'type' => 'textfield',
					'value' => '',
					),
					array( 
					'heading' => esc_html__( 'Number', 'aardvark' ),
					'param_name' => 'number',
					'type' => 'textfield',
					'value' => '8',
					),		
					array( 
					'heading' => esc_html__( 'Orderby', 'aardvark' ),
					'param_name' => 'orderby',
					'value' => array(
							esc_html__( 'Date', 'aardvark' ) => 'date',
							esc_html__( 'Name', 'aardvark' ) => 'name',
							esc_html__( 'Menu Order', 'aardvark' ) => 'menu_order',
						),
					'type' => 'dropdown',	
					),	
					array( 
					'heading' => esc_html__( 'Order', 'aardvark' ),
					'param_name' => 'order',
					'value' => array(
							esc_html__( 'Descending', 'aardvark' ) => 'desc',
							esc_html__( 'Ascending', 'aardvark' ) => 'asc',
						),
					'type' => 'dropdown',		
					),
					array(
					'heading' => esc_html__( 'Post Meta', 'aardvark' ),
					'param_name' => 'purchase_button',
					'value' => array( esc_html__( 'Purchase Button', 'aardvark' ) => '1' ),
					'type' => 'checkbox',
					),	
					array(			
					'param_name' => 'meta_author',
					'value' => array( esc_html__( 'Author Name', 'aardvark' ) => '1' ),
					'type' => 'checkbox',
					),	
					array(
					'param_name' => 'meta_lessons',
					'value' => array( esc_html__( 'Lessons', 'aardvark' ) => '1' ),
					'type' => 'checkbox',
					),	
					array( 
					'param_name' => 'meta_cats',
					'value' => array( esc_html__( 'Categories', 'aardvark' ) => '1' ),
					'type' => 'checkbox',
					),						
					array(
					'param_name' => 'meta_progress',
					'value' => array( esc_html__( 'Progress', 'aardvark' ) => '1' ),
					'type' => 'checkbox',
					),						
					array(
					'param_name' => 'meta_previews',
					'value' => array( esc_html__( 'Previews', 'aardvark' ) => '1' ),
					'type' => 'checkbox',
					),	
					array( 
					'heading' => esc_html__( 'Extra Class Name', 'aardvark' ),
					'param_name' => 'classes',
					'value' => '',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'aardvark' ),
					'type' => 'textfield',
					),					
					array(
					'heading' => esc_html__( 'CSS', 'aardvark' ),
					'type' => 'css_editor',
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),							
					array( 
					'heading' => esc_html__( 'Post Title Color', 'aardvark' ),
					'param_name' => 'post_title_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),							
					array( 
					'heading' => esc_html__( 'Post Title Hover Color', 'aardvark' ),
					'param_name' => 'post_title_hover_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),	
					array( 
					'heading' => esc_html__( 'Post Link Color', 'aardvark' ),
					'param_name' => 'post_link_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),								
					array( 
					'heading' => esc_html__( 'Post Link Hover Color', 'aardvark' ),
					'param_name' => 'post_link_hover_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),									
					array( 
					'heading' => esc_html__( 'Post Text Color', 'aardvark' ),
					'param_name' => 'post_text_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),
					array( 
					'heading' => esc_html__( 'Meta Text Color', 'aardvark' ),
					'param_name' => 'meta_text_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),										
					array( 
					'heading' => esc_html__( 'Masonry Background Color', 'aardvark' ),
					'param_name' => 'masonry_bg_color',
					'type' => 'colorpicker',
					'dependency' => array( 'element' => 'format', 'value' => 'gp-posts-masonry' ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),										
					array( 
					'heading' => esc_html__( 'Border Color', 'aardvark' ),
					'param_name' => 'masonry_border_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),
																																						
				 )
			) );
	
		}	
	}		
	add_action( 'vc_before_init', 'ghostpool_wpb_courses_options' ); 

} ?>