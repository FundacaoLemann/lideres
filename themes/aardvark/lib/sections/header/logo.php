<div class="gp-logo">

	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>">
		
		<?php if ( ghostpool_option( 'text_logo' ) ) { ?>
			
			<span class="gp-text-logo"><?php echo esc_attr( ghostpool_option( 'text_logo' ) ); ?></span>
		
		<?php } elseif ( ghostpool_option( 'logo', 'url' ) ) {  ?>
		
			<img src="<?php echo esc_url( ghostpool_option( 'logo', 'url' ) ); ?>" class="gp-logo-image" data-logo="<?php echo esc_url( ghostpool_option( 'logo', 'url' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo absint( ghostpool_option( 'logo_dimensions', 'width' ) ); ?>" height="<?php echo absint( ghostpool_option( 'logo_dimensions', 'height' ) ); ?>"
			
			<?php if ( ghostpool_option( 'logo_retina', 'url' ) ) { ?>data-logoretina="<?php echo esc_url( ghostpool_option( 'logo_retina', 'url' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'logo_dimensions', 'width' ) ) { ?> data-logowidth="<?php echo absint( ghostpool_option( 'logo_dimensions', 'width' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'logo_dimensions', 'height' ) ) { ?> data-logoheight="<?php echo absint( ghostpool_option( 'logo_dimensions', 'height' ) ); ?>"<?php } ?>		
			
			<?php if ( ghostpool_option( 'logo_scrolling', 'url' ) ) { ?> data-scrolling="<?php echo esc_url( ghostpool_option( 'logo_scrolling', 'url' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'logo_scrolling_retina', 'url' ) ) { ?> data-scrollingretina="<?php echo esc_url( ghostpool_option( 'logo_scrolling_retina', 'url' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'logo_scrolling_dimensions', 'width' ) ) { ?> data-scrollingwidth="<?php echo absint( ghostpool_option( 'logo_scrolling_dimensions', 'width' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'logo_scrolling_dimensions', 'height' ) ) { ?> data-scrollingheight="<?php echo absint( ghostpool_option( 'logo_scrolling_dimensions', 'height' ) ); ?>"<?php } ?>
			
			<?php if ( ghostpool_option( 'logo_overlay', 'url' ) ) { ?> data-overlay="<?php echo esc_url( ghostpool_option( 'logo_overlay', 'url' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'logo_overlay_retina', 'url' ) ) { ?> data-overlayretina="<?php echo esc_url( ghostpool_option( 'logo_overlay_retina', 'url' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'logo_overlay_dimensions', 'width' ) ) { ?> data-overlaywidth="<?php echo absint( ghostpool_option( 'logo_overlay_dimensions', 'width' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'logo_overlay_dimensions', 'height' ) ) { ?> data-overlayheight="<?php echo absint( ghostpool_option( 'logo_overlay_dimensions', 'height' ) ); ?>"<?php } ?>
			
			<?php if ( ghostpool_option( 'mobile_logo', 'url' ) ) { ?> data-mobile="<?php echo esc_url( ghostpool_option( 'mobile_logo', 'url' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'mobile_logo_retina', 'url' ) ) { ?>data-mobileretina="<?php echo esc_url( ghostpool_option( 'mobile_logo_retina', 'url' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'mobile_logo_dimensions', 'width' ) ) { ?>data-mobilewidth="<?php echo absint( ghostpool_option( 'mobile_logo_dimensions', 'width' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'mobile_logo_dimensions', 'height' ) ) { ?>data-mobileheight="<?php echo absint( ghostpool_option( 'mobile_logo_dimensions', 'height' ) ); ?>"<?php } ?>

			<?php if ( ghostpool_option( 'mobile_logo_scrolling', 'url' ) ) { ?> data-mobilescrolling="<?php echo esc_url( ghostpool_option( 'mobile_logo_scrolling', 'url' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'mobile_logo_scrolling_retina', 'url' ) ) { ?> data-mobilescrollingretina="<?php echo esc_url( ghostpool_option( 'mobile_logo_scrolling_retina', 'url' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'mobile_logo_scrolling_dimensions', 'width' ) ) { ?> data-mobilescrollingwidth="<?php echo absint( ghostpool_option( 'mobile_logo_scrolling_dimensions', 'width' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'mobile_logo_scrolling_dimensions', 'height' ) ) { ?> data-mobilescrollingheight="<?php echo absint( ghostpool_option( 'mobile_logo_scrolling_dimensions', 'height' ) ); ?>"<?php } ?>
			
			<?php if ( ghostpool_option( 'mobile_logo_overlay', 'url' ) ) { ?>data-mobileoverlay="<?php echo esc_url( ghostpool_option( 'mobile_logo_overlay', 'url' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'mobile_logo_overlay_retina', 'url' ) ) { ?>data-mobileoverlayretina="<?php echo esc_url( ghostpool_option( 'mobile_logo_overlay_retina', 'url' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'mobile_logo_overlay_dimensions', 'width' ) ) { ?>data-mobileoverlaywidth="<?php echo absint( ghostpool_option( 'mobile_logo_overlay_dimensions', 'width' ) ); ?>"<?php } ?>
			<?php if ( ghostpool_option( 'mobile_logo_overlay_dimensions', 'height' ) ) { ?>data-mobileoverlayheight="<?php echo absint( ghostpool_option( 'mobile_logo_overlay_dimensions', 'height' ) ); ?>"<?php } ?> />
			
		<?php } ?>

		<?php if ( ghostpool_option( 'logo_retina', 'url' ) ) { ?>
			<img src="<?php echo esc_url( ghostpool_option( 'logo_retina', 'url' ) ); ?>" class="gp-hidden" alt="<?php bloginfo( 'name' ); ?>" />
		<?php } ?>			
		<?php if ( ghostpool_option( 'logo_scrolling', 'url' ) ) { ?>
			<img src="<?php echo esc_url( ghostpool_option( 'logo_scrolling', 'url' ) ); ?>" class="gp-hidden" alt="<?php bloginfo( 'name' ); ?>" />
		<?php } ?>			
		<?php if ( ghostpool_option( 'logo_scrolling_retina', 'url' ) ) { ?>
			<img src="<?php echo esc_url( ghostpool_option( 'logo_scrolling_retina', 'url' ) ); ?>" class="gp-hidden" alt="<?php bloginfo( 'name' ); ?>" />
		<?php } ?>
		<?php if ( ghostpool_option( 'mobile_logo_retina', 'url' ) ) { ?>
			<img src="<?php echo esc_url( ghostpool_option( 'mobile_logo_retina', 'url' ) ); ?>" class="gp-hidden" alt="<?php bloginfo( 'name' ); ?>" />
		<?php } ?>	
		<?php if ( ghostpool_option( 'mobile_logo_scrolling', 'url' ) ) { ?>
			<img src="<?php echo esc_url( ghostpool_option( 'mobile_logo_scrolling', 'url' ) ); ?>" class="gp-hidden" alt="<?php bloginfo( 'name' ); ?>" />
		<?php } ?>				
		<?php if ( ghostpool_option( 'mobile_logo_scrolling_retina', 'url' ) ) { ?>
			<img src="<?php echo esc_url( ghostpool_option( 'mobile_logo_scrolling_retina', 'url' ) ); ?>" class="gp-hidden" alt="<?php bloginfo( 'name' ); ?>" />
		<?php } ?>	
					
	</a>		

</div>