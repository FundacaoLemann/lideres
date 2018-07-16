<?php if ( ! function_exists( 'ghostpool_wpb_login_register_form_options' ) ) {

	function ghostpool_wpb_login_register_form_options() { 
	
		vc_map( array( 
			'name' => esc_html__( 'Login/Register Form', 'aardvark' ),
			'base' => 'gp_login_register_form',
			'description' => esc_html__( 'Login/register form.', 'aardvark' ),
			'class' => 'wpb_vc_login_register_form',
			'controls' => 'full',
			'icon' => 'gp-icon-login-register-form',
			'category' => esc_html__( 'Theme', 'aardvark' ),
			'params' => array(		
			
				array( 
					'heading' => esc_html__( 'Display Form', 'aardvark' ),
					'param_name' => 'display',
					'value' => array(
						esc_html__( 'Login Form', 'aardvark' ) => 'login-form',
						esc_html__( 'Registration Form', 'aardvark' ) => 'register-form',
						esc_html__( 'Lost Password Form', 'aardvark' ) => 'lost-password-form',
					),
					'std' => 'login-form,register-form,lost-password-form',
					'type' => 'checkbox',
				),
				array( 
					'heading' => esc_html__( 'Default Display', 'aardvark' ),
					'param_name' => 'default_display',
					'value' => array( 
						esc_html__( 'Login Form', 'aardvark' ) => 'gp-login-display', 
						esc_html__( 'Registration Form', 'aardvark' ) => 'gp-register-display', 
						esc_html__( 'Lost Password Form', 'aardvark' ) => 'gp-lost-password-display' 
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
					'heading' => esc_html__( 'CSS', 'aardvark' ),
					'type' => 'css_editor',
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
				),	
																																													
			 )
		) );
		
	}		
} 
add_action( 'vc_before_init', 'ghostpool_wpb_login_register_form_options' ); ?>