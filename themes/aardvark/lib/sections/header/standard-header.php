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

?>

<header id="gp-standard-header" class="gp-main-header gp-container">

	<?php if ( $header_layout == 'gp-header-logo-left-1' ) {
		get_template_part( 'lib/sections/header/logo-left-1' );	
	} elseif ( $header_layout == 'gp-header-logo-left-2' ) {
		get_template_part( 'lib/sections/header/logo-left-1' );	
	} elseif ( $header_layout == 'gp-header-logo-right-1' ) {
		get_template_part( 'lib/sections/header/logo-right-1' );		
	} elseif ( $header_layout == 'gp-header-nav-bottom-1' ) {
		get_template_part( 'lib/sections/header/nav-bottom-1' );	
	} elseif ( $header_layout == 'gp-header-nav-bottom-2' ) {
		get_template_part( 'lib/sections/header/nav-bottom-2' );	
	} elseif ( $header_layout == 'gp-header-nav-bottom-3' ) {
		get_template_part( 'lib/sections/header/nav-bottom-3' );		
	} elseif ( $header_layout == 'gp-header-side-menu' ) {
		get_template_part( 'lib/sections/header/side-menu-right' );	
	} ?>
							
	<div class="gp-search-box">
		<div class="gp-container">				
			<?php get_search_form(); ?>
		</div>
	</div>
	
	<div class="gp-clear"></div>
		
</header>

<div id="gp-fixed-header-padding"></div>