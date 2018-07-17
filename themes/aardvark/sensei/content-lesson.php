<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Content-lesson.php template file
 *
 * responsible for content on archive like pages. Only shows the lesson excerpt.
 *
 * For single lesson content please see single-lesson.php
 *
 * @author 		Automattic
 * @package 	Sensei
 * @category    Templates
 * @version     1.9.0
 */
?>

<section <?php post_class( array( get_the_ID(), 'gp-post-item' ) ); ?>>

	<?php
	/**
	 * sensei_content_lesson_before
	 * action that runs before the sensei {post_type} content. It runs inside the sensei
	 * content.php template. This applies to the specific post type that you've targeted.
	 *
	 * @since 1.9.0
	 * @param string $lesson_id
	 */
	do_action( 'sensei_content_lesson_before', get_the_ID() );
	?>

	<?php
	/**
	 * Fires just before the post content in the content-lesson.php file.
	 *
	 * @since 1.9.0
	 *
	 * @hooked Sensei()->modules->module_archive_description -  11
	 * @hooked Sensei_Lesson::the_lesson_meta                -  20
	 *
	 * @param string $lesson_id
	 */
	do_action('sensei_content_lesson_inside_before', get_the_ID());
	
	global $woothemes_sensei;
	
	$sensei_settings = get_option( 'woothemes-sensei-settings' );
	
	?>
	
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="gp-post-thumbnail gp-loop-featured">
			<?php echo get_the_post_thumbnail( get_the_ID(), array( $sensei_settings['lesson_archive_image_width'], $sensei_settings['lesson_archive_image_height'] ) ); ?>
		</div>
	<?php } ?>
		
	<div class="gp-loop-content">
		
		<h2 class="gp-loop-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		
		<div class="gp-loop-text">
			<?php sensei_the_lesson_excerpt(); ?>
		</div>
		
		<div class="gp-loop-meta">
			<?php echo Sensei_Lesson::the_lesson_meta( get_the_ID() ); ?>
		</div>

		<?php
		/**
		 * Fires just after the post content in the lesson-content.php file.
		 *
		 * @since 1.9.0
		 *
		 * @param string $lesson_id
		 */
		do_action('sensei_content_lesson_inside_after', get_the_ID());
		?>
	
	</div>

	<?php
	/**
	 * This action runs after the sensei lesson content. It runs inside the sensei
	 * lesson-content.php template.
	 *
	 * @since 1.9.0
	 * @param string $lesson_id
	 */
	do_action( 'sensei_content_lesson_after', get_the_ID() );
	?>

</section> <!-- article .(<?php echo esc_attr( join( ' ', get_post_class( array( 'lesson', 'post' ) ) ) ); ?>  -->