<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php if ( is_singular() && pings_open( get_queried_object() ) ) { ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php } ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php if ( ghostpool_option( 'page_loader' ) == 'enabled' ) { ?>
	<div id="gp-page-loader">
		<div class="sk-folding-cube">
			<div class="sk-cube1 sk-cube"></div> <div class="sk-cube2 sk-cube"></div> <div class="sk-cube4 sk-cube"></div> <div class="sk-cube3 sk-cube"></div> 
		 </div>
	</div>
<?php } ?>

<?php 

// Page options
$header_display = get_post_meta( get_the_ID(), 'page_header_display', true ) != 'default' ? get_post_meta( get_the_ID(), 'page_header_display', true ) : ghostpool_option( 'header_display' ); ?>

<?php if ( has_nav_menu( 'gp-mobile-primary-nav' ) OR ( has_nav_menu( 'gp-mobile-profile-nav' ) && is_user_logged_in() ) ) { ?>
	
	<div id="gp-close-mobile-nav-button"></div>

	<?php if ( has_nav_menu( 'gp-mobile-primary-nav' ) ) { ?>
		<nav id="gp-mobile-primary-nav" class="gp-mobile-nav">
			<?php wp_nav_menu( array( 'theme_location' => 'gp-mobile-primary-nav', 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'gp-mobile-primary-menu', 'fallback_cb' => 'null', 'walker' => new Ghostpool_Custom_Menu ) ); ?>
		</nav>
	<?php } ?>

	<?php if ( has_nav_menu( 'gp-mobile-profile-nav' ) && is_user_logged_in() ) { ?>
		<nav id="gp-mobile-profile-nav" class="gp-mobile-nav">
			<?php wp_nav_menu( array( 'theme_location' => 'gp-mobile-profile-nav', 'sort_column' => 'menu_order', 'container' => 'ul','menu_id' => 'gp-mobile-profile-menu', 'menu_class' => 'menu gp-profile-menu', 'fallback_cb' => 'null', 'walker' => new Ghostpool_Custom_Menu ) ); ?>
		</nav>
	<?php } ?>

	<div id="gp-mobile-nav-bg"></div>

<?php } ?>

<div id="gp-global-wrapper"<?php if ( $header_display != 'gp-header-disabled' ) { ?> class="gp-active-desktop-side-menu"<?php } ?>>
		
	<?php if ( $header_display != 'gp-header-disabled' ) { get_template_part( 'lib/sections/header/side-menu-left' ); } ?>
		
	<div id="gp-site-wrapper">	

		<?php if ( $header_display != 'gp-header-disabled' ) { ?>

			<?php if ( ghostpool_option( 'top_header' ) != 'gp-top-header-disabled' ) { ?>
				<header id="gp-top-header" class="gp-container">
		
					<div class="gp-container">
		
						<?php if ( has_nav_menu( 'gp-top-header-left-nav' ) ) { ?>	
							<nav id="gp-top-nav-left" class="gp-nav">
								<?php wp_nav_menu( array( 'theme_location' => 'gp-top-header-left-nav', 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'gp-top-header-left-menu', 'fallback_cb' => 'null', 'walker' => new Ghostpool_Custom_Menu ) ); ?>		
							</nav>
						<?php } ?>
						<?php if ( has_nav_menu( 'gp-top-header-right-nav' ) ) { ?>	
							<nav id="gp-top-nav-right" class="gp-nav">
								<?php wp_nav_menu( array( 'theme_location' => 'gp-top-header-right-nav', 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'gp-top-header-right-menu', 'fallback_cb' => 'null', 'walker' => new Ghostpool_Custom_Menu ) ); ?>		
							</nav>
						<?php } ?>
			
					</div>
		
					<div class="gp-clear"></div>
		
				</header>
			<?php } ?>
		
			<?php get_template_part( 'lib/sections/header/mobile-header' ); ?>

			<?php get_template_part( 'lib/sections/header/standard-header' ); ?>
	
			<div class="gp-clear"></div>
	
		<?php } ?>
						
		<div id="gp-page-wrapper">	