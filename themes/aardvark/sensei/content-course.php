<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Content-course.php template file
 *
 * responsible for content on archive like pages. Only shows the course excerpt.
 *
 * For single course content please see single-course.php
 *
 * @author 		Automattic
 * @package 	Sensei
 * @category    Templates
 * @version     1.9.0
 */
?>

<li <?php post_class( WooThemes_Sensei_Course::get_course_loop_content_class() ); ?> >

    <?php
    /**
     * This action runs before the sensei course content. It runs inside the sensei
     * content-course.php template.
     *
     * @since 1.9
     *
     * @param integer $course_id
     */
    do_action( 'sensei_course_content_before', get_the_ID() );
    ?>

	<?php
	/**
	 * Fires just before the course content in the content-course.php file.
	 *
	 * @since 1.9
	 *
	 * @param integer $course_id
	 *
	 * @hooked Sensei_Templates::the_title          - 5
	 * @hooked Sensei()->course->course_image       - 10
	 * @hooked  Sensei()->course->the_course_meta   - 20
	 */
	do_action('sensei_course_content_inside_before', get_the_ID() );

	global $woothemes_sensei;

	?>
	
	<div class="gp-post-thumbnail gp-loop-featured">
		<?php echo wp_kses_post( $woothemes_sensei->course->course_image( get_the_ID() ) ); ?>
	</div>
	
	<div class="gp-loop-content">

		<h2 class="gp-loop-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		
		<?php echo ghostpool_course_price( get_the_ID() ); ?>
						
		<div class="gp-loop-text">
			<?php echo get_the_excerpt(); ?>
		</div>
		
		<?php echo ghostpool_purchase_course_button( get_the_ID() ); ?>
				
		<div class="gp-loop-meta">
		
			<?php $woothemes_sensei->course->the_course_meta( get_the_ID() ); ?>

			<?php
			/**
			 * Fires just after the course content in the content-course.php file.
			 *
			 * @since 1.9
			 *
			 * @param integer $course_id
			 *
			 * @hooked  Sensei()->course->the_course_free_lesson_preview - 20
			 */
			do_action('sensei_course_content_inside_after', get_the_ID() );
			?>

		</div>
			
	</div>
	
    <?php
    /**
     * Fires after the course block in the content-course.php file.
     *
     * @since 1.9
     *
     * @param integer $course_id
     *
     * @hooked  Sensei()->course->the_course_free_lesson_preview - 20
     */
    do_action('sensei_course_content_after', get_the_ID() );
    ?>

</li>