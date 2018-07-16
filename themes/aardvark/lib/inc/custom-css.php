<?php	

$custom_css = '';

$custom_css .= 

// Primary gradient background color
'#gp-page-header, .gp-ranking-counter, .tagcloud a, .woocommerce span.onsale, .gp-primary-color .vc-hoverbox-back, .wpb-js-composer .vc_tta.vc_tta-style-gp-1 .vc_tta-tab.vc_active, 
.wpb-js-composer .vc_tta.vc_tta-style-gp-1 .vc_tta-panel.vc_active .vc_tta-panel-title, .wpb-js-composer .vc_tta.vc_tta-style-gp-2 .vc_tta-tab.vc_active:before, .wpb-js-composer .vc_tta.vc_tta-style-gp-2 .vc_tta-panel.vc_active .vc_tta-panel-title:before, .wpb-js-composer .vc_tta.vc_tta-style-gp-3 .vc_tta-tab.vc_active, .wpb-js-composer .vc_tta.vc_tta-style-gp-3 .vc_tta-panel.vc_active .vc_tta-panel-title, .wpb-js-composer .vc_tta.vc_general.vc_tta-style-gp-1 .vc_tta-tab:not(.vc_active):hover .vc_tta-title-text, .wpb-js-composer .vc_tta.vc_general.vc_tta-style-gp-1 .vc_tta-panel:not(.vc_active) .vc_tta-panel-title:hover .vc_tta-title-text, .wpb-js-composer .vc_tta.vc_general.vc_tta-style-gp-3 .vc_tta-tab:not(.vc_active):hover .vc_tta-title-text, .wpb-js-composer .vc_tta.vc_general.vc_tta-style-gp-3 .vc_tta-panel:not(.vc_active) .vc_tta-panel-title:hover .vc_tta-title-text{background-color: ' . ghostpool_option( 'primary_color', 'from' ) . ';';
	if ( ghostpool_option( 'primary_color', 'to' ) ) { 
		$custom_css .= 'background-image: -webkit-linear-gradient(left, ' . ghostpool_option( 'primary_color', 'from' ) . ', ' . ghostpool_option( 'primary_color', 'to' ) . ');background-image: linear-gradient(to right, ' . ghostpool_option( 'primary_color', 'from' ) . ', ' . ghostpool_option( 'primary_color', 'to' ) . ');';
	}
$custom_css .=  '}' .

// Tab style 2 bottom border (not for IE11)
'.wpb-js-composer .vc_tta.vc_general.vc_tta-style-gp-2 .vc_tta-tab.vc_active .vc_tta-title-text, .wpb-js-composer .vc_tta.vc_general.vc_tta-style-gp-2 .vc_tta-tab:hover .vc_tta-title-text, .wpb-js-composer .vc_tta.vc_general.vc_tta-style-gp-2 .vc_tta-panel.vc_active .vc_tta-title-text, .wpb-js-composer .vc_tta.vc_general.vc_tta-style-gp-2 .vc_tta-panel:hover .vc_tta-title-text {color:' . ghostpool_option( 'primary_color', 'from' ) . ';';
	if ( ghostpool_option( 'primary_color', 'to' ) ) { 
		$custom_css .= 'background-image: -webkit-linear-gradient(left, ' . ghostpool_option( 'primary_color', 'from' ) . ', ' . ghostpool_option( 'primary_color', 'to' ) . ');';
	} elseif ( ghostpool_option( 'primary_color', 'from' ) ) { 
		$custom_css .= 'background-image: -webkit-linear-gradient(left, ' . ghostpool_option( 'primary_color', 'from' ) . ', ' . ghostpool_option( 'primary_color', 'from' ) . ');';
	}
$custom_css .=  '}' .


// Primary gradient border color
'.woocommerce .widget_price_filter .ui-slider .ui-slider-handle {border-color: ' . ghostpool_option( 'primary_color', 'from' ) . ';}' .

// Button background color
'input[type="button"], input[type="submit"], input[type="reset"], button, .button, .gp-theme #buddypress .comment-reply-link, .gp-theme #buddypress .generic-button a, .gp-theme #buddypress input[type=button], .gp-theme #buddypress input[type=reset], .gp-theme #buddypress input[type=submit], .gp-theme #buddypress ul.button-nav li a, a.bp-title-button, .gp-lesson-details-wrapper footer input, .gp-lesson-details-wrapper footer .button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce div.product form.cart .button, .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce #respond input#submit.alt:disabled[disabled]:hover, .woocommerce input.button:disabled, .woocommerce input.button:disabled:hover, .woocommerce input.button:disabled[disabled], .woocommerce input.button:disabled[disabled]:hover, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled[disabled], .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled[disabled], .woocommerce button.button.alt:disabled[disabled]:hover, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt:disabled[disabled], .woocommerce input.button.alt:disabled[disabled]:hover, .pmpro_btn, .pmpro_btn:link, .pmpro_content_message a, .pmpro_content_message a:link, div.css-search div.em-search-main .em-search-submit, input[type="button"]:hover, input[type="submit"]:hover, input[type="reset"]:hover, button:hover, .button:hover, .gp-theme #buddypress .comment-reply-link:hover, .gp-theme #buddypress div.generic-button a:hover, .gp-theme #buddypress input[type=button]:hover, .gp-theme #buddypress input[type=reset]:hover, .gp-theme #buddypress input[type=submit]:hover, .gp-theme #buddypress ul.button-nav li a:hover, .gp-theme #buddypress ul.button-nav li.current a, .gp-lesson-details-wrapper footer input:hover, .gp-lesson-details-wrapper footer .button:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce div.product form.cart .button:hover, .pmpro_btn:hover, .pmpro_content_message a:hover, div.css-search div.em-search-main .em-search-submit:hover{';
	if ( ghostpool_option( 'button_bg', 'from' ) ) {
		$custom_css .= 'background-color: ' . ghostpool_option( 'button_bg', 'from' ) . ';';
	}	
	if ( ghostpool_option( 'button_bg', 'to' ) ) {
		$custom_css .= 'background-image: -webkit-linear-gradient(left, ' . ghostpool_option( 'button_bg', 'from' ) . ' 0%, ' . ghostpool_option( 'button_bg', 'to' ) . ' 50%,' . ghostpool_option( 'button_bg', 'from' ) . ' 100%);background-image: linear-gradient(to right, ' . ghostpool_option( 'button_bg', 'from' ) . ' 0%, ' . ghostpool_option( 'button_bg', 'to' ) . ' 50%,' . ghostpool_option( 'button_bg', 'from' ) . ' 100%);';
	}	
$custom_css .= '}' .

// Button background hover color
'input[type="button"]:hover, input[type="submit"]:hover, input[type="reset"]:hover, button:hover, .button:hover, .gp-theme #buddypress .comment-reply-link:hover, .gp-theme #buddypress div.generic-button a:hover, .gp-theme #buddypress input[type=button]:hover, .gp-theme #buddypress input[type=reset]:hover, .gp-theme #buddypress input[type=submit]:hover, .gp-theme #buddypress ul.button-nav li a:hover, .gp-theme #buddypress ul.button-nav li.current a, .gp-lesson-details-wrapper footer input:hover, .gp-lesson-details-wrapper footer .button:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce div.product form.cart .button:hover, .pmpro_btn:hover, .pmpro_content_message a:hover, div.css-search div.em-search-main .em-search-submit:hover{';
	if ( ghostpool_option( 'button_bg_hover', 'from' ) ) {
		$custom_css .= 'background-color: ' . ghostpool_option( 'button_bg_hover', 'from' ) . ';';
	}
	if ( ghostpool_option( 'button_bg_hover', 'to' ) ) {
		$custom_css .= 'background-image: -webkit-linear-gradient(left, ' . ghostpool_option( 'button_bg_hover', 'from' ) . ' 0%, ' . ghostpool_option( 'button_bg_hover', 'to' ) . ' 50%,' . ghostpool_option( 'button_bg_hover', 'from' ) . ' 100%);background-image: linear-gradient(to right, ' . ghostpool_option( 'button_bg_hover', 'from' ) . ' 0%, ' . ghostpool_option( 'button_bg_hover', 'to' ) . ' 50%,' . ghostpool_option( 'button_bg_hover', 'from' ) . ' 100%);';
	}	
$custom_css .= '}' .
	
'.gp-active{color: ' . ghostpool_option( 'general_link_colors', 'regular' ) . ';}' . 

'#gp-content-wrapper{padding-top:' . str_replace( 'px', '', ghostpool_option( 'mobile_content_wrapper_padding', 'padding-top' ) ) . 'px;padding-bottom:' . str_replace( 'px', '', ghostpool_option( 'mobile_content_wrapper_padding', 'padding-bottom' ) ) . 'px;}' .	
	
'#gp-sidebar-left{margin-right: ' . ghostpool_option( 'sidebar_gap', 'width' ) . ';}' .

'.rtl #gp-sidebar-left{margin-left: ' . ghostpool_option( 'sidebar_gap', 'width' ) . ';}' .

'#gp-sidebar-right{margin-left: ' . ghostpool_option( 'sidebar_gap', 'width' ) . ';}' .

'.rtl #gp-sidebar-right{margin-right: ' . ghostpool_option( 'sidebar_gap', 'width' ) . ';}' .

'.gp-nav .menu li .gp-menu-tabs li.gp-selected a{color:' . ghostpool_option( 'dropdown_menu_link_colors', 'hover' ) . ' !important;}' .

'#gp-top-header .menu > .menu-item.current-menu-item > a{color: ' . ghostpool_option( 'top_header_nav_link_colors', 'hover' ) . ';}' .
	
'#gp-top-header .menu > .menu-item > .gp-menu-text{color: ' . ghostpool_option( 'top_header_nav_link_colors', 'regular' ) . ';}' .

'#gp-standard-header .gp-header-button:before,#gp-standard-header .gp-cart-button .gp-cart-bag{color: ' . ghostpool_option( 'header_buttons_link_colors', 'regular' ) . ';font-size: ' . ghostpool_option( 'header_buttons_size', 'font-size' ) . ';}' .
		
'#gp-standard-header .gp-header-button:hover:before,#gp-standard-header .gp-header-button.gp-active:before,#gp-standard-header .gp-cart-button:hover .gp-cart-bag{color: ' . ghostpool_option( 'header_buttons_link_colors', 'hover' ) . ';}' .

'#gp-standard-header .gp-cart-bag,#gp-standard-header .gp-cart-handle{border-color: ' . ghostpool_option( 'header_buttons_link_colors', 'regular' ) . ';}' .

'#gp-standard-header .gp-cart-button:hover .gp-cart-bag,#gp-standard-header .gp-cart-button:hover .gp-cart-handle{border-color: ' . ghostpool_option( 'header_buttons_link_colors', 'hover' ) . ';}' .

'#gp-mobile-header .gp-header-button:before,#gp-mobile-header .gp-cart-button .gp-cart-bag{color: ' . ghostpool_option( 'mobile_header_buttons_link_colors', 'regular' ) . ';font-size: ' . ghostpool_option( 'mobile_header_buttons_size', 'font-size' ) . ';}' .
		
'#gp-mobile-header .gp-header-button:hover:before,#gp-mobile-header .gp-header-button.gp-active:before,#gp-mobile-header .gp-cart-button:hover .gp-cart-bag{color: ' . ghostpool_option( 'mobile_header_buttons_link_colors', 'hover' ) . ';}' .

'#gp-mobile-header .gp-cart-bag,#gp-mobile-header .gp-cart-handle{border-color: ' . ghostpool_option( 'mobile_header_buttons_link_colors', 'regular' ) . ';}' .

'#gp-mobile-header .gp-cart-button:hover .gp-cart-bag,#gp-mobile-header .gp-cart-button:hover .gp-cart-handle{border-color: ' . ghostpool_option( 'mobile_header_buttons_link_colors', 'hover' ) . ';}' .

'#gp-main-header-primary-nav > .menu > .menu-item > .gp-menu-text{color: ' . ghostpool_option( 'main_header_primary_nav_link_colors', 'regular' ) . ';}' .

'#gp-main-header-secondary-nav > .menu > .menu-item > .gp-menu-text{color: ' . ghostpool_option( 'main_header_secondary_nav_link_colors', 'regular' ) . ';}' .

'#gp-main-header-primary-nav > .menu > .menu-item.current-menu-item > a{color: ' . ghostpool_option( 'main_header_primary_nav_link_colors', 'hover' ) . ';}' .

'#gp-side-menu-nav .menu-item.current-menu-item > a{color: ' . ghostpool_option( 'side_menu_nav_link_colors', 'hover' ) . ';}' .

'#gp-side-menu-nav .sub-menu .menu-item.current-menu-item > a{color: ' . ghostpool_option( 'side_menu_nav_sub_menu_link_colors', 'hover' ) . ';}' .

'.gp-header-over-content.gp-standard-page-header #gp-page-title{padding-top:' . str_replace( 'px', '', ghostpool_option( 'mobile_header_height', 'height' ) ) . 'px;}' .

'#gp-page-title h1{font-size: ' . ghostpool_option( 'mobile_page_title_typography', 'font-size' ) . ';line-height: ' . ghostpool_option( 'mobile_page_title_typography', 'line-height' ) . ';letter-spacing: ' . ghostpool_option( 'mobile_page_title_typography', 'letter-spacing' ) . ';color: ' . ghostpool_option( 'page_title_typography', 'color' ) . ';font-family: ' . ghostpool_option( 'page_title_typography', 'font-family' ) . ',' . ghostpool_option( 'page_title_typography', 'font-backup' ) . ';font-weight: ' . ghostpool_option( 'page_title_typography', 'font-weight' ) . ';text-transform: ' . ghostpool_option( 'page_title_typography', 'text-transform' ) . ';}' .

'.widget .current-cat > a,.widget .current-cat > span,.widget .current_page_item a{color: ' . ghostpool_option( 'widget_link_colors', 'hover' ) . ';}' . 

'.gp-footer-widget .widget .current-cat > a,.gp-footer-widget .widget .current-cat > span,.gp-footer-widget .widget .current_page_item a{color: ' . ghostpool_option( 'footer_widget_link_colors', 'hover' ) . ';}' . 

'@media only screen and (min-width: 992px){' .

	'#gp-content-wrapper{padding-top:' . str_replace( 'px', '', ghostpool_option( 'desktop_content_wrapper_padding', 'padding-top' ) ) . 'px;padding-bottom:' . str_replace( 'px', '', ghostpool_option( 'desktop_content_wrapper_padding', 'padding-bottom' ) ) . 'px;}' .
	
	'.gp-header-over-content.gp-standard-page-header #gp-page-title{padding-top:' . str_replace( 'px', '', ghostpool_option( 'desktop_header_height', 'height' ) ) . 'px;}' .
			
	'.gp-header-over-content.gp-header-nav-bottom-1.gp-standard-page-header #gp-page-title,.gp-header-over-content.gp-header-nav-bottom-2.gp-standard-page-header #gp-page-title,.gp-header-over-content.gp-header-nav-bottom-3.gp-standard-page-header #gp-page-title{padding-top:' . str_replace( 'px', '', ( ghostpool_option( 'desktop_header_height', 'height' ) + ghostpool_option( 'desktop_header_nav_height', 'height' ) ) ) . 'px;}' .

	'#gp-side-menu-content{height: calc(100% - ' . ( ghostpool_option( 'side_menu_header_height', 'height' ) + 50) . 'px);}' .
	
	'.admin-bar #gp-side-menu-content{height: calc(100% - ' . ( ghostpool_option( 'side_menu_header_height', 'height' ) + 50 + 32 ) . 'px);}' .
		
	'#gp-page-title h1{font-size: ' . ghostpool_option( 'page_title_typography', 'font-size' ) . ';line-height: ' . ghostpool_option( 'page_title_typography', 'line-height' ) . ';letter-spacing: ' . ghostpool_option( 'page_title_typography', 'letter-spacing' ) . ';}' .
			
'}';
			
if ( ghostpool_option( 'custom_css' ) ) {
	$custom_css .= ghostpool_option( 'custom_css' );
}

if ( $custom_css != '' ) {
	echo '<style>' . $custom_css . '</style>';
}

?>