<?php
/**
 * The Template for displaying all single courses.
 *
 * Override this template by copying it to yourtheme/sensei/single-course.php
 *
 * @author 		Automattic
 * @package 	Sensei
 * @category    Templates
 * @version     1.9.0
 */
?>

<?php get_sensei_header();  ?>

<article <?php post_class( array( 'course', 'post' ) ); ?>>

    <?php

    /**
     * Hook inside the single course post above the content
     *
     * @since 1.9.0
     *
     * @param integer $course_id
     *
     * @hooked Sensei()->frontend->sensei_course_start     -  10
     * @hooked Sensei_Course::the_title                    -  10
     * @hooked Sensei()->course->course_image              -  20
     * @hooked Sensei_WC::course_in_cart_message           -  20
     * @hooked Sensei_Course::the_course_enrolment_actions -  30
     * @hooked Sensei()->message->send_message_link        -  35
     * @hooked Sensei_Course::the_course_video             -  40
     */
    do_action( 'sensei_single_course_content_inside_before', get_the_ID() );
    
    global $woothemes_sensei;
		
    ?>

	<div class="gp-post-thumbnail gp-entry-featured">
		<?php $woothemes_sensei->course->course_image( get_the_ID() ); ?>
	</div>	
	
	<?php Sensei_Course::the_course_video( get_the_ID() ); ?>

	<?php 
	
	if ( function_exists( 'is_woocommerce' ) ) {
	
		// Check if this course can be purchased
		$course_product_id = Sensei_WC::get_course_product_id( absint( get_the_ID() ) );
	
		// Check if user is taking course
		$is_user_taking_course = Sensei_Utils::user_started_course( get_the_ID(), get_current_user_id() );
	
	} else { 
	
		$course_product_id = '';
		$is_user_taking_course = '';
		
	}
			
	if ( ( $course_product_id && $is_user_taking_course ) OR ! $course_product_id ) { ?>

		<div class="gp-entry-content">
			<?php the_content(); ?>
		</div>

	<?php } else { ?>

		<div class="gp-entry-content">
			<?php echo get_the_excerpt(); ?>
			<div class="gp-sensei-teaser-gradient"></div>
		</div>	
		
		<div class="sensei-message alert gp-sensei-teaser-message"><?php esc_html_e( 'You need to purchase this course to view this content.', 'aardvark' ); ?></div>

	<?php } ?>
	
    <?php

    /**
     * Hook inside the single course post above the content
     *
     * @since 1.9.0
     *
     * @param integer $course_id
     *
     */
    do_action( 'sensei_single_course_content_inside_after', get_the_ID() );

    ?>
</article><!-- .post .single-course -->

<?php get_sensei_footer(); ?>