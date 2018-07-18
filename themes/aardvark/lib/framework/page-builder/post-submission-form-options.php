<?php  if ( ! function_exists( 'ghostpool_wpb_post_submission_form_options' ) ) {

	function ghostpool_wpb_post_submission_form_options() {

		vc_map( array( 
			'name' => esc_html__( 'Post Submission Form', 'aardvark' ),
			'base' => 'gp_post_submission_form',
			'description' => esc_html__( 'Post submission form.', 'aardvark' ),
			'class' => 'wpb_vc_post_submission_form',
			'controls' => 'full',
			'icon' => 'gp-icon-post-submission-form',
			'category' => esc_html__( 'Theme', 'aardvark' ),
			'params' => array( 	
			
				array( 
				'heading' => esc_html__( 'Email Address', 'aardvark' ),
				'description' => esc_html__( 'The email address the form is sent to (leave blank to use the admin email).', 'aardvark' ),
				'param_name' => 'email_address',
				'value' => '',
				'type' => 'textfield',
				),
				array( 
				'heading' => esc_html__( 'Subject', 'aardvark' ),
				'description' => esc_html__( 'The subject line of the email.', 'aardvark' ),
				'param_name' => 'subject',
				'value' => '',
				'type' => 'textfield',
				),								
				array( 
				'heading' => esc_html__( 'Fields', 'aardvark' ),
				'param_name' => 'post_title',
				'value' => array( esc_html__( 'Post Title', 'aardvark' ) => '1' ),
				'std' => '1',
				'type' => 'checkbox',
				),				
				array( 
				'param_name' => 'featured_image',
				'value' => array( esc_html__( 'Featured Image', 'aardvark' ) => '1' ),
				'std' => '1',
				'type' => 'checkbox',
				),					
				array(
				'param_name' => 'name',
				'value' => array( esc_html__( 'Name', 'aardvark' ) => '1' ),
				'std' => '1',
				'type' => 'checkbox',
				),
				array(
				'param_name' => 'email',
				'value' => array( esc_html__( 'Email', 'aardvark' ) => '1' ),
				'std' => '1',
				'type' => 'checkbox',
				),
				array( 
				'param_name' => 'cats',
				'value' => array( esc_html__( 'Category', 'aardvark' ) => '1' ),
				'std' => '1',
				'type' => 'checkbox',
				),
				array(
					'param_name' => 'formats',
					'value' => array( esc_html__( 'Post Formats', 'aardvark' ) => '1' ),
					'std' => '1',
					'type' => 'checkbox',
				),					
				array(
					'param_name' => 'post_content',
					'value' => array( esc_html__( 'Content', 'aardvark' ) => '1' ),
					'std' => '1',
					'type' => 'checkbox',
				),
				array(
					'param_name' => 'tags',
					'value' => array( esc_html__( 'Tags', 'aardvark' ) => '1' ),
					'std' => '1',
					'type' => 'checkbox',
				),					
				array( 
					'heading' => esc_html__( 'Parent Category', 'aardvark' ), 
					'description' => esc_html__( 'Enter the slug or ID of the category you want to filter by, leave blank to display all categories - the sub categories of this category will also be displayed.', 'aardvark' ),
					'param_name' => 'parent_cat',
					'value' => '',
					'type' => 'textfield',
					'dependency' => array( 'element' => 'cats', 'value' => '1' ),
				),
				array( 
					'heading' => esc_html__( 'Vistor Submissions', 'aardvark' ),
					'param_name' => 'visitors_can_post',
					'value' => array(
							esc_html__( 'Enabled', 'aardvark' ) => 'enabled',
							esc_html__( 'Disabled', 'aardvark' ) => 'disabled',
						),
					'type' => 'dropdown',
				),				
				array( 
					'heading' => esc_html__( 'Submitting Posts', 'aardvark' ),
					'param_name' => 'submit_status',
					'value' => array(
							esc_html__( 'Posts need to be approved before showing up on the site', 'aardvark' ) => 'pending',
							esc_html__( 'Posts are approved automatically', 'aardvark' ) => 'publish',
						),
					'type' => 'dropdown',
				),		
				array( 
					'heading' => esc_html__( 'Email Notification', 'aardvark' ),
					'description' => esc_html__( 'Choose to receive an email notification when a user submits a post.', 'aardvark' ),
					'param_name' => 'email_notification',
					'value' => array(
							esc_html__( 'Enabled', 'aardvark' ) => 'enabled',
							esc_html__( 'Disabled', 'aardvark' ) => 'disabled',
						),
					'type' => 'dropdown',
				),	
				array( 
					'heading' => esc_html__( 'Terms Of Use URL', 'aardvark' ), 
					'description' => esc_html__( 'Terms of condition URL.', 'aardvark' ),
					'param_name' => 'toc_url',
					'value' => '',
					'type' => 'textfield',
				),		
				array( 
					'heading' => esc_html__( 'Privacy Policy Checkbox (GDPR)', 'aardvark' ),
					'description' => esc_html__( 'Add a privacy policy checkbox to the form.', 'aardvark' ),
					'param_name' => 'gdpr',
					'value' => array(
							esc_html__( 'Enabled', 'aardvark' ) => 'enabled',
							esc_html__( 'Disabled', 'aardvark' ) => 'disabled',
						),
					'std' => 'disabled',
					'type' => 'dropdown',
				),				
				array( 
					'heading' => esc_html__( 'Privacy Policy Text', 'aardvark' ), 
					'description' => esc_html__( 'Add your own privacy policy text next to the checkbox. To add a link within your text use HTML tags e.g. "This is my text and this is a <a href="http://domain.com/privacy-policy">link</a>."', 'aardvark' ),
					'param_name' => 'gdpr_text',
					'value' => '',
					'type' => 'textarea',
					'dependency' => array( 'element' => 'gdpr', 'value' => 'enabled' ),
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
add_action( 'vc_before_init', 'ghostpool_wpb_post_submission_form_options' ); ?>