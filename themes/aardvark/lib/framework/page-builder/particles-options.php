<?php if ( ! function_exists( 'ghostpool_wpb_particles_options' ) ) {
	function ghostpool_wpb_particles_options() {

		vc_map( array(
			'name' => esc_html__( 'Particles', 'aardvark' ),
			'base' => 'gp_particles',
			'description' => esc_html__( 'Particles background.', 'aardvark' ),
			'class' => 'wpb_vc_particles',
			'controls' => 'full',
			'icon' => 'gp-icon-particles',
			'category' => esc_html__( 'Theme', 'aardvark' ),
			'params' => array(
						
				array( 
				'heading' => esc_html__( 'Particle Number', 'aardvark' ),
				'param_name' => 'number',
				'value' => '80',
				'type' => 'textfield',
				),
				array( 
				'heading' => esc_html__( 'Particle Size', 'aardvark' ),
				'param_name' => 'size',
				'value' => '4',
				'type' => 'textfield',
				),
				array( 
				'heading' => esc_html__( 'Particle Color', 'aardvark' ),
				'param_name' => 'color',
				'value' => '#ffffff',
				'type' => 'colorpicker',
				),	
				array( 
				'heading' => esc_html__( 'Line Color', 'aardvark' ),
				'param_name' => 'line_color',
				'value' => '#ffffff',
				'type' => 'colorpicker',
				),	 				 		   			 			 
				array( 
				'heading' => esc_html__( 'Extra Class Name', 'aardvark' ),
				'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'aardvark' ),
				'param_name' => 'classes',
				'value' => '',
				'type' => 'textfield',
				),
			
			)
		) );
		
	}
}	
add_action( 'vc_before_init', 'ghostpool_wpb_particles_options' ); ?>