<?php if ( function_exists( 'em_init' ) ) {

	if ( ! function_exists( 'ghostpool_wpb_events_options' ) ) {
		function ghostpool_wpb_events_options() {

			vc_map( array( 
				'name' => esc_html__( 'Events', 'aardvark' ),
				'base' => 'gp_events',
				'description' => esc_html__( 'Events list.', 'aardvark' ),
				'class' => 'wpb_vc_events',
				'controls' => 'full',
				'icon' => 'gp-icon-events',
				'category' => esc_html__( 'Theme', 'aardvark' ),
				'params' => array(				

					array( 
						'heading' => esc_html__( 'Title', 'aardvark' ),
						'param_name' => 'title',
						'type' => 'textfield',
						'value' => esc_html__( 'Events', 'aardvark' ),
					),	
					array( 
						'heading' => esc_html__( 'Number Of Events', 'aardvark' ),
						'param_name' => 'limit',
						'type' => 'textfield',
						'value' => '5',
					),	
					array( 
						'heading' => esc_html__( 'Scope', 'aardvark' ),
						'param_name' => 'scope',
						'type' => 'dropdown',
						'value' => array( 
							esc_html__( 'All events', 'aardvark' ) => 'all', 
							esc_html__( 'Future events', 'aardvark' ) => 'future',
							esc_html__( 'Past events', 'aardvark' ) => 'past',
							esc_html__( 'Todays events', 'aardvark' ) => 'today',
							esc_html__( 'Tomorrow events', 'aardvark' ) => 'tomorrow',
							esc_html__( 'Events this month', 'aardvark' ) => 'month',
							esc_html__( 'Events next month', 'aardvark' ) => 'next-month',
							esc_html__( 'Events current and next month', 'aardvark' ) => '1-months',
							esc_html__( 'Events within 2 months', 'aardvark' ) => '2-months',
							esc_html__( 'Events within 3 months', 'aardvark' ) => '3-months',
							esc_html__( 'Events within 6 months', 'aardvark' ) => '6-months',
							esc_html__( 'Events within 12 months', 'aardvark' ) => '12-months',
						),
						'std' => 'future',
					),
					array( 
						'heading' => esc_html__( 'Order By', 'aardvark' ),
						'param_name' => 'orderby',
						'type' => 'dropdown',
						'value' => array( 
							esc_html__( 'start date, start time, event name', 'aardvark' ) => 'event_start_date,event_start_time,event_name', 
							esc_html__( 'name, start date, start time', 'aardvark' ) => 'event_name,event_start_date,event_start_time',
							esc_html__( 'name, end date, end time', 'aardvark' ) => 'event_name,event_end_date,event_end_time',
							esc_html__( 'end date, end time, event name	 ', 'aardvark' ) => 'event_end_date,event_end_time,event_name',
						),
						'std' => 'future',
					),	
					array( 
						'heading' => esc_html__( 'Order', 'aardvark' ),
						'param_name' => 'order',
						'type' => 'dropdown',
						'value' => array( 
							esc_html__( 'Ascending', 'aardvark' ) => 'ASC', 
							esc_html__( 'Descending', 'aardvark' ) => 'DESC',
						),
					),
    				array( 
						'heading' => esc_html__( 'Category IDs', 'aardvark' ),
						'description' => esc_html__( '1,2,3 or 2 (0 = all)', 'aardvark'),
						'param_name' => 'category',
						'type' => 'textfield',
						'value' => '0',
					),	
     				array( 
						'heading' => esc_html__( 'List item format', 'aardvark' ),
						'description' => esc_html__( 'The list is wrapped in a <ul> tag, so if an <li> tag is not wrapping the formats below it will be added automatically.', 'aardvark' ),
						'param_name' => 'format',
						'type' => 'textarea',
						'value' => '<li>#_EVENTLINK<ul><li>#_EVENTDATES</li><li>#_LOCATIONTOWN</li></ul></li>',
					),	
    		   		array( 
						'heading' => esc_html__( 'Show all events link at bottom?', 'aardvark' ),
						'param_name' => 'all_events',
						'type' => 'checkbox',
						'value' => 0,
					),
    				array( 
						'heading' => esc_html__( 'All events link text?', 'aardvark' ),
						'param_name' => 'all_events_text',
						'type' => 'textfield',
						'value' => esc_html__( 'all events', 'aardvark' ),
						'dependency' => array( 'element' => 'all_events', 'not_empty' => true ),
					),
    				array( 
						'heading' => esc_html__( 'No events message', 'aardvark' ),
						'param_name' => 'no_events_text',
						'type' => 'textfield',
						'value' => '<li>' . esc_html__( 'No events', 'aardvark' ) . '</li>',
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
	add_action( 'vc_before_init', 'ghostpool_wpb_events_options' ); 

} ?>