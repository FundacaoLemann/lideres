<?php if ( defined( 'PMPRO_VERSION' ) ) {

	if ( ! function_exists( 'ghostpool_wpb_pmp_register_form_options' ) ) {
		function ghostpool_wpb_pmp_register_form_options() {

			vc_map( array( 
				'name' => esc_html__( 'PMP Register Form', 'aardvark' ),
				'base' => 'gp_pmp_register_form',
				'description' => esc_html__( 'PMP register form.', 'aardvark' ),
				'class' => 'wpb_vc_pmp_register_form',
				'controls' => 'full',
				'icon' => 'gp-icon-pmp-register-form',
				'category' => esc_html__( 'Theme', 'aardvark' ),
				'params' => array(

					array( 
						'heading' => esc_html__( 'Fields', 'aardvark' ),
						'param_name' => 'fields',
						'value' => array(
							esc_html__( 'Username', 'aardvark' ) => 'username',
							esc_html__( 'Email', 'aardvark' ) => 'email',
							esc_html__( 'Confirm Email', 'aardvark' ) => 'confirm-email',
							esc_html__( 'Password', 'aardvark' ) => 'password',
							esc_html__( 'Confirm Password', 'aardvark' ) => 'confirm-password',
						),
						'std' => 'username,email,confirm-email,password',
						'type' => 'checkbox',
					),			  
					array( 
						'heading' => esc_html__( 'Button Text', 'aardvark' ),
						'param_name' => 'button_text',
						'value' => esc_html__( 'Sign Up', 'aardvark' ),
						'type' => 'textfield',
					),	 	
					array( 
						'heading' => esc_html__( 'Redirect URL', 'aardvark' ),
						'description' => esc_html__( 'The page that the user is taken to after submitting the form e.g. membership level page', 'aardvark' ),
						'param_name' => 'redirect_url',
						'value' => '',
						'type' => 'textfield',
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
	add_action( 'vc_before_init', 'ghostpool_wpb_pmp_register_form_options' ); 
	
} ?>