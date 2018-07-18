<?php 

// Page options
$bp_header_layout = ghostpool_option( 'bp_header_layout' ) != 'default' ? ghostpool_option( 'bp_header_layout' ) : ghostpool_option( 'header_layout' );
if ( function_exists( 'bp_is_active' ) && bp_is_activity_component() ) {
	$header_layout = ghostpool_option( 'bp_activity_header_layout' ) != 'default' ? ghostpool_option( 'bp_activity_header_layout' ) : $bp_header_layout;
} elseif ( function_exists( 'bp_is_active' ) && bp_is_members_component() ) {
	$header_layout = ghostpool_option( 'bp_members_header_layout' ) != 'default' ? ghostpool_option( 'bp_members_header_layout' ) : $bp_header_layout;
} elseif ( function_exists( 'bp_is_active' ) && bp_is_groups_component() ) {
	$header_layout = ghostpool_option( 'bp_groups_header_layout' ) != 'default' ? ghostpool_option( 'bp_groups_header_layout' ) : $bp_header_layout;
} elseif ( function_exists( 'bp_is_active' ) && bp_is_register_page() ) {
	$header_layout = ghostpool_option( 'bp_register_header_layout' ) != 'default' ? ghostpool_option( 'bp_register_header_layout' ) : $bp_header_layout;	
} else {
	$header_layout = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header_layout', true ) && redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header_layout', true ) != 'default' ? redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header_layout', true ) : ghostpool_option( 'header_layout' );
}

if ( $header_layout == 'gp-header-side-menu' ) { ?>

	<div id="gp-side-menu-wrapper">
		
		<div id="gp-side-menu-logo">
			<?php get_template_part( 'lib/sections/header/logo' ); ?>
		</div>
		
		<div id="gp-side-menu-content">
			<div id="gp-side-menu-scroller">
				
				<?php if ( has_nav_menu( 'gp-side-menu-nav' ) ) { ?>	
					<nav id="gp-side-menu-nav" class="gp-mobile-nav">
						<?php wp_nav_menu( array( 'theme_location' => 'gp-side-menu-nav', 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'gp-side-menu-menu', 'fallback_cb' => 'null', 'walker' => new Ghostpool_Custom_Menu ) ); ?>		
					</nav>
				<?php } ?>
				
				<?php if ( is_active_sidebar( 'gp-side-menu' ) ) { ?>
					<aside id="gp-side-menu-widgets">
						<?php dynamic_sidebar( 'gp-side-menu' ); ?>
					</aside>
				<?php } ?>
						
			</div>
		</div>
		
		<div id="gp-side-menu-toggle">
			<div id="gp-close-side-menu-button"></div>
		</div>
		
	</div>
	
	<div id="gp-open-side-menu-button"></div>

<?php } ?>	