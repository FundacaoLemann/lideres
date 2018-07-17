<?php get_header(); ?>

<?php ghostpool_page_header( get_the_ID(), 'gp-standard-page-header' ); ?>
	
<div id="gp-content-wrapper" class="gp-container">
				
	<div id="gp-inner-container">
		
		<div id="gp-content">

			<?php the_attachment_link( get_the_ID(), true ) ?>

			<div class="gp-entry-content">
				<?php the_content(); ?>
			</div>

		</div>

		<?php get_sidebar( 'left' ); ?>

		<?php get_sidebar( 'right' ); ?>

	</div>

	<?php do_action( 'ghostpool_end_content_wrapper' ); ?>
			
	<div class="gp-clear"></div>
	
</div>

<?php get_footer(); ?>