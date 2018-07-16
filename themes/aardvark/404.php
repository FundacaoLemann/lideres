<?php get_header(); ?>

<?php ghostpool_page_title(); ?>

<div id="gp-content-wrapper" class="gp-container">

	<?php do_action( 'ghostpool_begin_content_wrapper' ); ?>
			
	<div id="gp-inner-container">
		
		<div id="gp-content">

			<div class="gp-entry-content">
			
				<strong class="gp-active"><?php esc_html_e( 'Are you lost?', 'aardvark' ); ?></strong>
			
				<p><?php esc_html_e( 'This page does not exist, if you are lost use the search form below or visit our', 'aardvark' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'homepage', 'aardvark' ); ?></a>.</p>
	
				<div class="gp-search">

					<?php get_search_form(); ?>

				</div>
			
			</div>
			
		</div>
			
		<?php get_sidebar( 'left' ); ?>

		<?php get_sidebar( 'right' ); ?>

	</div>

	<?php do_action( 'ghostpool_end_content_wrapper' ); ?>
				
	<div class="gp-clear"></div>
	
</div>
		
<?php get_footer(); ?>