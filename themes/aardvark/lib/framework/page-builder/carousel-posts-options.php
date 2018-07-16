<?php if ( ! function_exists( 'ghostpool_wpb_carousel_posts_options' ) ) {

	function ghostpool_wpb_carousel_posts_options() { 

		vc_map( array( 
			'name' => esc_html__( 'Carousel Posts', 'aardvark' ),
			'base' => 'gp_carousel_posts',
			'description' => esc_html__( 'Posts carousel.', 'aardvark' ),
			'class' => 'wpb_vc_carousel_posts',
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
					'heading' => esc_html__( 'Categories', 'aardvark' ),
					'description' => esc_html__( 'Enter the slugs or IDs separating each one with a comma e.g. xbox,ps3,pc.', 'aardvark' ),
					'param_name' => 'cats',
					'type' => 'textfield',
				),
				array( 
					'heading' => esc_html__( 'Page IDs', 'aardvark' ),
					'description' => esc_html__( 'Enter the IDs of the pages you want to include, separating each with a comma e.g. 48,142.', 'aardvark' ),
					'param_name' => 'page_ids',
					'type' => 'textfield',
				),			
				array( 
					'heading' => esc_html__( 'Post Types', 'aardvark' ),
					'param_name' => 'post_types',
					'type' => 'posttypes',
					'value' => 'post',
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
					'heading' => esc_html__( 'Order By', 'aardvark' ),
					'param_name' => 'orderby',
					'value' => array(
						esc_html__( 'Newest', 'aardvark' ) => 'newest',
						esc_html__( 'Oldest', 'aardvark' ) => 'oldest',
						esc_html__( 'Title (A-Z)', 'aardvark' ) => 'title_az',
						esc_html__( 'Title (Z-A)', 'aardvark' ) => 'title_za',
						esc_html__( 'Most Comments', 'aardvark' ) => 'comment_count',
						esc_html__( 'Most Views', 'aardvark' ) => 'views',
						esc_html__( 'Most Likes', 'aardvark' ) => 'likes',
						esc_html__( 'Menu Order', 'aardvark' ) => 'menu_order',
						esc_html__( 'Random', 'aardvark' ) => 'rand',
					),
					'type' => 'dropdown',
				),
				array( 
					'heading' => esc_html__( 'Items In View', 'aardvark' ),
					'param_name' => 'items_in_view',
					'value' => '3',
					'type' => 'textfield',
				),								 
				array( 
					'heading' => esc_html__( 'Total Items', 'aardvark' ),
					'description' => esc_html__( 'The total number of items.', 'aardvark' ),
					'param_name' => 'per_page',
					'value' => '12',
					'type' => 'textfield',
				),
				array( 
					'heading' => esc_html__( 'Offset', 'aardvark' ),
					'description' => esc_html__( 'E.g. set to 3 to exclude the first 3 posts.', 'aardvark' ),
					'param_name' => 'offset',
					'type' => 'textfield',
				),
				array( 
					'heading' => esc_html__( 'Image Size', 'aardvark' ),
					'description' => esc_html__( 'Choose from one of the default image sizes or you can register your own image size as explained', 'aardvark' ) . ' <a href="' . esc_url( 'https://ghostpool.ticksy.com/article/10923' ) . '" target="_blank">'. esc_html__( 'here', 'aardvark' ) . '</a>.',
					'param_name' => 'image_size',
					'type'     => 'dropdown',
					'value' => ghostpool_wpb_image_size_field( false ),
					'std' => 'gp_column_image',
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
					'type' => 'dropdown',
				),					
				array( 
					'heading' => esc_html__( 'Navigation Arrows', 'aardvark' ),
					'param_name' => 'arrows',
					'value' => array(
						esc_html__( 'Enabled', 'aardvark' ) => 'enabled',
						esc_html__( 'Disabled', 'aardvark' ) => 'disabled',
					),
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
					'edit_field_class' => 'vc_col-xs-12',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				), 			 				 		   			 			 
				array( 
					'heading' => esc_html__( 'Title Icon Color', 'aardvark' ),
					'param_name' => 'icon_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),
				array( 
					'heading' => esc_html__( 'Title Icon', 'aardvark' ),
					'param_name' => 'icon',
					'type' => 'iconpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),					
				array( 
					'heading' => esc_html__( 'Title Color', 'aardvark' ),
					'param_name' => 'title_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),							
				array( 
					'heading' => esc_html__( 'Post Title Color', 'aardvark' ),
					'param_name' => 'post_title_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),							
				array( 
					'heading' => esc_html__( 'Post Title Hover Color', 'aardvark' ),
					'param_name' => 'post_title_hover_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),								
				array( 
					'heading' => esc_html__( 'Post Link Color', 'aardvark' ),
					'param_name' => 'post_link_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),								
				array( 
					'heading' => esc_html__( 'Post Link Hover Color', 'aardvark' ),
					'param_name' => 'post_link_hover_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),									
				array( 
					'heading' => esc_html__( 'Post Text Color', 'aardvark' ),
					'param_name' => 'post_text_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
				),
				array( 
					'heading' => esc_html__( 'Meta Text Color', 'aardvark' ),
					'param_name' => 'meta_text_color',
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
add_action( 'vc_before_init', 'ghostpool_wpb_carousel_posts_options' ); ?>