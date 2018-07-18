<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The Template for displaying all single course meta information.
 *
 * Override this template by copying it to yourtheme/sensei/single-course/course-lessons.php
 *
 * @author 		Automattic
 * @package 	Sensei
 * @category    Templates
 * @version     1.9.0
 */
 
$format = ghostpool_option( 'courses_format' );
$style = ghostpool_option( 'courses_style' );

// Classes
$css_classes = array(
	'course-lessons',
	'gp-posts-wrapper',
	'gp-sensei-wrapper',
	$format,
	$format == 'gp-posts-masonry' ? 'gp-columns-4' : '',
	$style,
);
$css_classes = trim( implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

?>

<section class="<?php echo esc_attr( $css_classes ); ?>">

	<?php if ( ghostpool_option( 'courses_format' ) == 'gp-posts-masonry' ) { ?><div class="gp-gutter-size"></div><?php } ?>	

	<?php

		/**
		 * Actions just before the sensei single course lessons loop begins
		 *
		 * @hooked WooThemes_Sensei_Course::load_single_course_lessons_query
		 * @since 1.9.0
		 */
		do_action( 'sensei_single_course_lessons_before' );

	?>

	<?php

	//lessons loaded into loop in the sensei_single_course_lessons_before hook
	if( have_posts() ):

		// start course lessons loop
		while ( have_posts() ): the_post();  ?>

			<section <?php post_class( 'gp-post-item' ); ?> >

				<?php

					/**
					 * The hook is inside the course lesson on the single course. It fires
					 * for each lesson. It is just before the lesson excerpt.
					 *
					 * @since 1.9.0
					 *
					 * @param $lessons_id
					 *
					 * @hooked WooThemes_Sensei_Lesson::the_lesson_meta -  5
					 * @hooked WooThemes_Sensei_Lesson::the_lesson_thumbnail - 8
					 *
					 */
					do_action( 'sensei_single_course_inside_before_lesson', get_the_ID() );
				
					global $woothemes_sensei;
					
					$sensei_settings = get_option( 'woothemes-sensei-settings' );

				?>

				<div class="gp-post-thumbnail gp-loop-featured">
					<?php echo wp_kses_post( $woothemes_sensei->lesson->lesson_image( get_the_ID(), $sensei_settings['lesson_archive_image_width'], $sensei_settings['lesson_archive_image_height'] ) ); ?>
				</div>
		
				<div class="gp-loop-content">

					<h2 class="gp-loop-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

					<div class="gp-loop-text">
						<?php the_excerpt(); ?>
					</div>
			
					<div class="gp-loop-meta">
						<?php WooThemes_Sensei_Lesson::the_lesson_meta( get_the_ID() ); ?>
					</div>
					
			
				</div>

				<?php

					/**
					 * The hook is inside the course lesson on the single course. It is just before the lesson closing markup.
					 * It fires for each lesson.
					 *
					 * @since 1.9.0
					 */
					do_action( 'sensei_single_course_inside_after_lesson', get_the_ID() );

				?>

			</section>

		<?php endwhile; // end course lessons loop  ?>

	<?php endif; ?>

	<?php

		/**
		 * Actions just before the sensei single course lessons loop begins
		 *
		 * @hooked WooThemes_Sensei_Course::reset_single_course_query
		 *
		 * @since 1.9.0
		 */
		do_action( 'sensei_single_course_lessons_after' );

	?>
	
</section>