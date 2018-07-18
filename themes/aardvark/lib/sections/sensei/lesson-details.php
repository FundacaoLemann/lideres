<?php if ( is_singular( 'lesson' ) ) {

	// Get course ID
	$course_id = intval( get_post_meta( get_the_ID(), '_lesson_course', true ) );

	?>

	<div class="gp-lesson-details-wrapper gp-course-wrapper">
	
		<div class="gp-lesson-title"><?php esc_html_e( 'Lesson Details', 'aardvark' ); ?></div>
	
		<div class="gp-course-stats">
		
			<?php if ( $course_id > 0 ) { ?>
				<div class="gp-course-stat">
					<div class="gp-course-stat-top"><?php esc_html_e( 'Course', 'aardvark' ); ?></div> 
					<div class="gp-course-stat-bottom gp-link"><a href="<?php echo get_permalink( $course_id ); ?>"><?php echo get_the_title( $course_id ); ?></a></div>
				</div>
			<?php } ?>
						
			<?php if ( get_post_meta( get_the_ID(), '_lesson_length', true ) ) { ?>
				<div class="gp-course-stat">	
					<div class="gp-course-stat-left"><?php esc_html_e( 'Length', 'aardvark' ); ?></div> 
					<div class="gp-course-stat-right"><?php echo esc_attr( get_post_meta( get_the_ID(), '_lesson_length', true ) ); ?> <?php esc_html_e( 'minutes', 'aardvark' ); ?></div>
				</div>
			<?php } ?>
			
			<?php if ( get_post_meta( get_the_ID(), '_lesson_complexity', true ) ) { ?>			
				<div class="gp-course-stat">	
					<div class="gp-course-stat-left"><?php esc_html_e( 'Complexity', 'aardvark' ); ?></div> 
					<div class="gp-course-stat-right">
						<?php if ( get_post_meta( get_the_ID(), '_lesson_complexity', true ) == 'easy' ) {
							esc_html_e( 'Easy', 'aardvark' );
						} elseif ( get_post_meta( get_the_ID(), '_lesson_complexity', true ) == 'std' ) {
							esc_html_e( 'Standard', 'aardvark' );
						} elseif ( get_post_meta( get_the_ID(), '_lesson_complexity', true ) == 'hard' ) {
							esc_html_e( 'Hard', 'aardvark' );
						} ?>	
					</div>
				</div>
			<?php } ?>
			
			<?php 
			
			// Get prev/next lessons
			$nav_id_array = sensei_get_prev_next_lessons( get_the_ID() );
			if ( isset( $nav_id_array['prev_lesson'] ) ) {
				$previous_lesson_id = absint( $nav_id_array['prev_lesson'] );
			} else {
				$previous_lesson_id = 0;
			}
			if ( isset( $nav_id_array['next_lesson'] ) ) {
				$next_lesson_id = absint( $nav_id_array['next_lesson'] );
			} else {
				$next_lesson_id = 0;
			}
			
			if ( ( 0 < $previous_lesson_id ) OR ( 0 < $next_lesson_id ) ) { ?>
			
				 <?php if ( 0 < $previous_lesson_id ) { ?>
					<div class="gp-course-stat">	
						<div class="gp-course-stat-top"><?php esc_html_e( 'Previous Lesson', 'aardvark' ); ?></div> 
						<div class="gp-course-stat-bottom gp-link"><a href="<?php echo esc_url( get_permalink( $previous_lesson_id ) ); ?>" rel="prev"><?php echo get_the_title( $previous_lesson_id ); ?></a></div>
					</div>
				<?php } ?>

				 <?php if ( 0 < $next_lesson_id ) { ?>
					<div class="gp-course-stat">	
						<div class="gp-course-stat-top"><?php esc_html_e( 'Next Lesson', 'aardvark' ); ?></div> 
						<div class="gp-course-stat-bottom gp-link"><a href="<?php echo esc_url( get_permalink( $next_lesson_id ) ); ?>" rel="prev"><?php echo get_the_title( $next_lesson_id ); ?></a></div>
					</div>
				<?php } ?>
						
			<?php } ?>
			
			<?php do_action( 'sensei_single_lesson_content_inside_after', get_the_ID() ); ?>
	
		</div>

	</div>

<?php } ?>	