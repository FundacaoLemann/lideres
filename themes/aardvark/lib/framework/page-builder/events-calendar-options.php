<?php if ( function_exists( 'em_init' ) ) {

	if ( ! function_exists( 'ghostpool_wpb_events_calendar_options' ) ) {
		function ghostpool_wpb_events_calendar_options() {

			vc_map( array( 
				'name' => esc_html__( 'Events Calendar', 'aardvark' ),
				'base' => 'gp_events_calendar',
				'description' => esc_html__( 'Events calendar.', 'aardvark' ),
				'class' => 'wpb_vc_events_calendar',
				'controls' => 'full',
				'icon' => 'gp-icon-events',
				'category' => esc_html__( 'Theme', 'aardvark' ),
				'params' => array(				

					array( 
						'heading' => esc_html__( 'Title', 'aardvark' ),
						'param_name' => 'title',
						'type' => 'textfield',
						'value' => esc_html__( 'Calendar', 'aardvark' ),
					),	
					array( 
						'heading' => esc_html__( 'Show Long Events?', 'aardvark' ),
						'param_name' => 'long_events',
						'type' => 'checkbox',
						'value' => 0,
					),	
					array( 
						'heading' => esc_html__( 'Category IDs', 'aardvark' ),
						'param_name' => 'category',
						'description' => esc_html__( '1,2,3 or 2 (0 = all)', 'aardvark' ),
						'type' => 'checkbox',
						'value' => 0,
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
		
				 )
			) );

		}	
	}		
	add_action( 'vc_before_init', 'ghostpool_wpb_events_calendar_options' ); 

} ?>