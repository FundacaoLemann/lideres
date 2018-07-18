<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
	<div id="gp-buddypress-header">
	
		<?php
		
		// Page options
		if ( bp_is_activity_component() ) {
			$header = $GLOBALS['ghostpool_page_header'];
			$bg = ghostpool_option( 'bp_activity_page_header_bg', 'url' ) != '' ? ghostpool_option( 'bp_activity_page_header_bg' ) : ghostpool_option( 'bp_page_header_bg' );
			$height = ghostpool_option( 'bp_activity_page_header_height', 'height' ) != '' ? ghostpool_option( 'bp_activity_page_header_height', 'height' ) : ghostpool_option( 'bp_page_header_height', 'height' );	
		} elseif ( bp_is_members_component() ) {
			$header = $GLOBALS['ghostpool_page_header'];
			$bg = ghostpool_option( 'bp_members_page_header_bg', 'url' ) != '' ? ghostpool_option( 'bp_members_page_header_bg' ) : ghostpool_option( 'bp_page_header_bg' );
			$height = ghostpool_option( 'bp_members_page_header_height', 'height' ) != '' ? ghostpool_option( 'bp_members_page_header_height', 'height' ) : ghostpool_option( 'bp_page_header_height', 'height' );	
		} elseif ( bp_is_groups_component() ) {
			$header = $GLOBALS['ghostpool_page_header'];
			$bg = ghostpool_option( 'bp_groups_page_header_bg', 'url' ) != '' ? ghostpool_option( 'bp_groups_page_header_bg' ) : ghostpool_option( 'bp_page_header_bg' );	
			$height = ghostpool_option( 'bp_groups_page_header_height', 'height' ) != '' ? ghostpool_option( 'bp_groups_page_header_height', 'height' ) : ghostpool_option( 'bp_page_header_height', 'height' );	
		} elseif ( bp_is_register_page() ) {
			$header = $GLOBALS['ghostpool_page_header'];
			$bg = ghostpool_option( 'bp_register_page_header_bg', 'url' ) != '' ? ghostpool_option( 'bp_register_page_header_bg' ) : ghostpool_option( 'bp_page_header_bg' );
			$height = ghostpool_option( 'bp_register_page_header_height', 'height' ) != '' ? ghostpool_option( 'bp_register_page_header_height', 'height' ) : ghostpool_option( 'bp_page_header_height', 'height' );
		} else {
			$header = ghostpool_option( 'bp_page_header' );
			$bg = ghostpool_option( 'bp_page_header_bg' );
			$height = ghostpool_option( 'bp_page_header_height', 'height' );
		}
		
		// Page options
		if ( bp_is_group_single() OR bp_is_user() ) {
			$header = 'gp-fullwidth-page-header';
		}
		
		?>

		<?php ghostpool_page_header( 
			$post_id = '', 
			$type = $header,
			$bg = $bg,
			$height = $height
		); ?>
				
		<?php ghostpool_page_title( '', $header ); ?>
		
	</div>
			
	<div id="gp-content-wrapper" class="gp-container">
		
		<?php do_action( 'ghostpool_begin_content_wrapper' ); ?>
		
		<div id="gp-inner-container">

			<div id="gp-content">

				<?php the_content(); ?>
						
			</div>
			
			<?php get_sidebar( 'left' ); ?>

			<?php get_sidebar( 'right' ); ?>

		</div>
		
		<?php do_action( 'ghostpool_end_content_wrapper' ); ?>
		
		<div class="gp-clear"></div>
	
	</div>
	
<?php endwhile; endif; ?>
	
<?php get_footer(); ?>