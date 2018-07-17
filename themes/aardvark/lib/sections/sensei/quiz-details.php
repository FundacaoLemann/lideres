<?php if ( is_singular( 'quiz' ) ) { 

	// Course ID
	$lesson_id = intval( get_post_meta( get_the_ID(), '_quiz_lesson', true ) );

	?>

	<div class="gp-quiz-details-wrapper gp-course-wrapper">
	
		<div class="gp-lesson-title"><?php esc_html_e( 'Quiz Details', 'aardvark' ); ?></div>
	
		<div class="gp-course-stats">
			
			<?php if ( $lesson_id > 0 ) { ?>
				<div class="gp-course-stat">
					<div class="gp-course-stat-top"><?php esc_html_e( 'Lesson', 'aardvark' ); ?></div> 
					<div class="gp-course-stat-bottom gp-link"><a href="<?php echo get_permalink( $lesson_id ); ?>"><?php echo get_the_title( $lesson_id ); ?></a></div>
				</div>
			<?php } ?>

			 <?php do_action( 'sensei_single_quiz_questions_before', get_the_ID() ); ?>
	
		</div>

	</div>

<?php } ?>	