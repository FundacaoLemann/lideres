<?php
/**
 * The Template for displaying all single lessons.
 *
 * Override this template by copying it to yourtheme/sensei/single-lesson.php
 *
 * @author 		Automattic
 * @package 	Sensei
 * @category    Templates
 * @version     1.9.0
 */
?>

<?php get_sensei_header();  ?>

<?php the_post(); ?>

<article <?php post_class( array( 'lesson', 'post' ) ); ?>>

    <?php

        /**
         * Hook inside the single lesson above the content
         *
         * @since 1.9.0
         *
         * @param integer $lesson_id
         *
         * @hooked deprecated_lesson_image_hook - 10
         * @hooked deprecate_sensei_lesson_single_title - 15
         * @hooked Sensei_Lesson::lesson_image() -  17
         * @hooked deprecate_lesson_single_main_content_hook - 20
         */
        do_action( 'sensei_single_lesson_content_inside_before', get_the_ID() );

    ?>

	<?php if ( has_post_thumbnail() ) { ?>
		<div class="gp-post-thumbnail gp-entry-featured">
			<?php Sensei_Lesson::the_lesson_image( get_the_ID() ); ?>
		</div>
	<?php } ?>
	
	<?php if ( sensei_can_user_view_lesson() ) {

		if ( apply_filters( 'sensei_video_position', 'top', $post->ID ) == 'top' ) {

			do_action( 'sensei_lesson_video', $post->ID );

		} ?>

		<div class="gp-entry-content">
			<?php the_content(); ?>
		</div>

	<?php } else { ?>

		  <div class="gp-entry-content">
		  	<?php echo get_the_excerpt(); ?>
		  	<div class="gp-sensei-teaser-gradient"></div>
		  </div>	

	<?php } ?>

    <?php

        /**
         * Hook inside the single lesson template after the content
         *
         * @since 1.9.0
         *
         * @param integer $lesson_id
         *
         * @hooked Sensei()->frontend->sensei_breadcrumb   - 30
         */
        do_action( 'sensei_single_lesson_content_inside_after', get_the_ID() );

    ?>

</article><!-- .post -->

<?php get_sensei_footer(); ?>