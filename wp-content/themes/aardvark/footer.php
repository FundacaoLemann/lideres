			<div class="gp-clear"></div>

		</div>

		<?php 

		// Page options
		$footer_display = ghostpool_option( 'page_footer_display' ) != 'default' ? ghostpool_option( 'page_footer_display' ) : ghostpool_option( 'footer_display' );

		if ( $footer_display == 'enabled' ) { ?>

			<footer id="gp-footer" class="gp-container <?php echo sanitize_html_class( ghostpool_option( 'footer_width' ) ); ?> <?php echo sanitize_html_class( ghostpool_option( 'footer_widgets_display' ) ); ?><?php if ( ghostpool_option( 'copyright_display' ) == 'enabled' ) { ?> gp-has-copyright<?php } ?>">				
	
				<div class="gp-container">

					<?php if ( ghostpool_option( 'footer_image', 'url' ) ) { ?>
						<div id="gp-footer-image">
							<img src="<?php echo esc_url( ghostpool_option( 'footer_image', 'url' ) ); ?>" width="<?php echo absint( ghostpool_option( 'footer_image_dimensions', 'width' ) ); ?>" height="<?php echo absint( ghostpool_option( 'footer_image_dimensions', 'height' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="gp-standard-image" />
							<img src="<?php echo esc_url( ghostpool_option( 'footer_image_retina', 'url' ) ); ?>" width="<?php echo absint( ghostpool_option( 'footer_image_dimensions', 'width' ) ); ?>" height="<?php echo absint( ghostpool_option( 'footer_image_dimensions', 'height' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="gp-retina-image" />
						</div>
					<?php } ?>
		
					<?php if ( is_active_sidebar( 'gp-footer-1' ) OR is_active_sidebar( 'gp-footer-2' ) OR is_active_sidebar( 'gp-footer-3' ) OR is_active_sidebar( 'gp-footer-4' ) OR is_active_sidebar( 'gp-footer-5' ) ) { ?>

						<div id="gp-footer-widgets">

							<?php if ( is_active_sidebar( 'gp-footer-1' ) && is_active_sidebar( 'gp-footer-2' ) && is_active_sidebar( 'gp-footer-3' ) && is_active_sidebar( 'gp-footer-4' ) && is_active_sidebar( 'gp-footer-5' ) ) {
								$footer_widget_class = 'gp-footer-fifth';
							} elseif ( is_active_sidebar( 'gp-footer-1' ) && is_active_sidebar( 'gp-footer-2' ) && is_active_sidebar( 'gp-footer-3' ) && is_active_sidebar( 'gp-footer-4' ) ) { 			
								$footer_widget_class = 'gp-footer-fourth';
							} elseif ( is_active_sidebar( 'gp-footer-1' ) && is_active_sidebar( 'gp-footer-2' ) && is_active_sidebar( 'gp-footer-3' ) ) {
								$footer_widget_class = 'gp-footer-third';
							} elseif ( is_active_sidebar( 'gp-footer-1' ) && is_active_sidebar( 'gp-footer-2' ) ) {
								$footer_widget_class = 'gp-footer-half';
							} elseif ( is_active_sidebar( 'gp-footer-1' ) ) {
								$footer_widget_class = 'gp-footer-whole';
							} else {
								$footer_widget_class = '';
							} ?>

							<?php if ( is_active_sidebar( 'gp-footer-1' ) ) { ?>
								<div class="gp-footer-widget gp-footer-1 <?php echo sanitize_html_class( $footer_widget_class ); ?>">
									<?php dynamic_sidebar( 'gp-footer-1' ); ?>
								</div>
							<?php } ?>

							<?php if ( is_active_sidebar( 'gp-footer-2' ) ) { ?>
								<div class="gp-footer-widget gp-footer-2 <?php echo sanitize_html_class( $footer_widget_class ); ?>">
									<?php dynamic_sidebar( 'gp-footer-2' ); ?>
								</div>
							<?php } ?>

							<?php if ( is_active_sidebar( 'gp-footer-3' ) ) { ?>
								<div class="gp-footer-widget gp-footer-3 <?php echo sanitize_html_class( $footer_widget_class ); ?>">
									<?php dynamic_sidebar( 'gp-footer-3' ); ?>
								</div>
							<?php } ?>

							<?php if ( is_active_sidebar( 'gp-footer-4' ) ) { ?>
								<div class="gp-footer-widget gp-footer-4 <?php echo sanitize_html_class( $footer_widget_class ); ?>">
									<?php dynamic_sidebar( 'gp-footer-4' ); ?>
								</div>
							<?php } ?>

							<?php if ( is_active_sidebar( 'gp-footer-5' ) ) { ?>
								<div class="gp-footer-widget gp-footer-5 <?php echo sanitize_html_class( $footer_widget_class ); ?>">
									<?php dynamic_sidebar( 'gp-footer-5' ); ?>
								</div>
							<?php } ?>

						</div>
		
					<?php } ?>
		
					<?php if ( ghostpool_option( 'copyright_display' ) == 'enabled' ) { ?>
						<div id="gp-copyright">

							<div id="gp-copyright-text">
								<?php if ( ghostpool_option( 'copyright_text' ) ) { ?>
									<?php echo wp_kses_post( ghostpool_option( 'copyright_text' ) ); ?>
								<?php } else { ?>
									<?php esc_html_e( 'Copyright &copy;', 'aardvark' ); ?> <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( 'http://themeforest.net/user/GhostPool/portfolio?ref=GhostPool' ); ?>" rel="nofollow"><?php esc_html_e( 'GhostPool.com', 'aardvark' ); ?></a>
								<?php } ?>
							</div>
				
							<?php if ( has_nav_menu( 'gp-footer-nav' ) ) { ?>
								<nav id="gp-footer-nav" class="gp-nav">
									<?php wp_nav_menu( array( 'theme_location' => 'gp-footer-nav', 'sort_column' => 'menu_order', 'container' => 'ul', 'fallback_cb' => 'null', 'walker' => new Ghostpool_Custom_Menu ) ); ?>			
								</nav>
							<?php } ?>

						</div>
					<?php } ?>	
		
				</div>

			</footer>
	
		<?php } ?>

	</div>

</div>
		
<?php if ( ghostpool_option( 'login_register_popup_redirect' ) == 'enabled' ) {
	get_template_part( 'lib/sections/login/login-modal' );
} ?>

<?php wp_footer(); ?>
</body>
</html>