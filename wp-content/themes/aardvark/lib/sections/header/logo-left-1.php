<div class="gp-container">

	<?php get_template_part( 'lib/sections/header/logo' ); ?>
	
	<?php if ( has_nav_menu( 'gp-main-header-primary-nav' ) OR has_nav_menu( 'gp-main-header-secondary-nav' ) OR ghostpool_option( 'profile_button' ) != 'gp-profile-button-disabled' OR ghostpool_option( 'search_button' ) != 'gp-search-button-disabled' OR ghostpool_option( 'cart_button' ) != 'gp-cart-button-disabled' OR has_nav_menu( 'gp-mobile-primary-nav' ) ) { ?>
	
		<div class="gp-nav-column">
		
			<?php if ( ghostpool_option( 'header_search_bar' ) == 'enabled' ) { ?>
				<div id="gp-header-search"><?php get_search_form(); ?></div>
			<?php } ?>
	
			<?php get_template_part( 'lib/sections/header/primary-nav' ); ?>
		
			<?php get_template_part( 'lib/sections/header/header-buttons' ); ?>

			<?php get_template_part( 'lib/sections/header/secondary-nav' ); ?>		
	
		</div>
	
	<?php } ?>
		
</div>