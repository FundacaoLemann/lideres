<?php if ( has_nav_menu( 'gp-main-header-primary-nav' ) ) { ?>
	<nav id="gp-main-header-primary-nav" class="gp-nav">
		<?php wp_nav_menu( array( 'theme_location' => 'gp-main-header-primary-nav', 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'gp-main-header-primary-menu', 'fallback_cb' => 'null', 'walker' => new Ghostpool_Custom_Menu ) ); ?>			
	</nav>
<?php } ?>