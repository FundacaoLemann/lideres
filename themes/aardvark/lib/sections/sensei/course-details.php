<?php if ( is_singular( 'course' ) ) {

	wp_reset_postdata(); // Needed for BadgeOS plugin changing course ID

	// Check if user is taking course
	$is_user_taking_course = Sensei_Utils::user_started_course( get_the_ID(), get_current_user_id() );
	 
	if ( ! $is_user_taking_course ) { ?>

		<div class="gp-purchase-course-wrapper gp-course-wrapper">

			<?php
			
			// Start/purchase course button
			echo Sensei_Course::the_course_enrolment_actions( get_the_ID() ); ?>

			<?php if ( function_exists( 'is_woocommerce' ) ) {

				// Check if this course can be purchased
				$course_product_id = Sensei_WC::get_course_product_id( absint( get_the_ID() ) );
				
				if ( $course_product_id ) {
								
					// Get course product details					
					$product = wc_get_product( $course_product_id );
					$price = $product->get_price();
		
					?>

					<?php echo Sensei_WC::course_in_cart_message( get_the_ID() ); ?>

					<?php if ( ! is_user_logged_in() ) { ?>
						<a href="<?php echo ghostpool_login_link(); ?>" class="gp-course-login-link"><?php esc_html_e( 'Or login to access your purchased courses', 'aardvark' ); ?></a>
					<?php } ?>
				
				<?php } 
			} ?>
			
			<?php ghostpool_the_register_button( get_the_ID() ); ?>

			<div class="gp-course-stats">
		
				<?php if ( function_exists( 'is_woocommerce' ) && $course_product_id && $price > 0 ) { ?>
					<div class="gp-course-stat">
						<div class="gp-course-stat-left"><?php esc_html_e( 'Price', 'aardvark' ); ?></div> 
						<div class="gp-course-stat-right gp-link"><?php echo $product->get_price_html(); ?></div>
					</div>
				<?php } ?>

				<?php if ( function_exists( 'sensei_certificates_install' ) ) { ?>
					<div class="gp-course-stat gp-check"><?php esc_html_e( 'Course Badge', 'aardvark' ); ?></div> 
				<?php } ?>
											
				<?php if ( function_exists( 'sensei_certificates_install' ) ) { ?>
					<div class="gp-course-stat gp-check"><?php esc_html_e( 'Course Certificate', 'aardvark' ); ?></div> 
				<?php } ?>
	
				<?php do_action( 'sensei_single_course_content_inside_before', get_the_ID() ); ?>
			
				<?php echo ghostpool_course_participant_count( get_the_ID() ); ?>
		
			</div>

		</div>

	<?php } else { ?>
						
		<div class="gp-course-details-wrapper gp-course-wrapper">

			<?php $sensei_courses = new Sensei_Course; ?>
	
			<?php $sensei_courses->the_progress_statement( get_the_ID(), get_current_user_id() ); ?>
	
			<?php $sensei_courses->the_progress_meter( get_the_ID(), get_current_user_id() ); ?>

			<?php echo Sensei_Course::the_course_enrolment_actions( get_the_ID() ); ?>
			
			<?php echo ghostpool_bp_group_url( get_the_ID() ); ?>

			<?php //do_action( 'sensei_single_course_content_inside_before', get_the_ID() ); ?>
			
			<?php $sensei_messages = new Sensei_Messages; echo esc_attr( $sensei_messages->send_message_link( get_the_ID() ) ); ?>

			<?php echo ghostpool_course_participant_count( get_the_ID() ); ?>

		</div>

	<?php }
	
} ?>	