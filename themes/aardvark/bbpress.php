<?php get_header(); 

// Page options
$header = ghostpool_option( 'bbpress_page_header' );

?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>		
	
	<?php ghostpool_page_header( 
		$post_id = get_the_ID(), 
		$type = $header,
		$bg = ghostpool_option( 'bbpress_page_header_bg' ),
		$height = ghostpool_option( 'bbpress_page_header_height', 'height' )	
	); ?>
	
	<?php ghostpool_page_title( '', $header ); ?>

	<div id="gp-content-wrapper" class="gp-container">
	
		<?php do_action( 'ghostpool_begin_content_wrapper' ); ?>
		
		<div id="gp-inner-container">
		
			<div id="gp-content">
			
				<div <?php post_class(); ?>>
					<?php the_content(); ?>
				</div>

			</div>
		
			<?php bbp_restore_all_filters( 'the_content', 0 ); ?>

			<?php get_sidebar( 'left' ); ?>

			<?php get_sidebar( 'right' ); ?>
		
		</div>
				
		<div class="gp-clear"></div>
	
	</div>
	
<?php endwhile; endif; ?>
	
<?php get_footer(); ?>