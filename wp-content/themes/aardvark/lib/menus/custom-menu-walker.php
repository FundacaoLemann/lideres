<?php

if ( ! class_exists( 'Ghostpool_Custom_Menu' ) ) {

	class Ghostpool_Custom_Menu extends Walker_Nav_Menu {
		
		private $curItem;

		// Start level (add classes to ul sub-menus)
		function start_lvl( &$output, $depth = 0, $args = array() ) {
		
			// Depth dependent classes
			$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
			$display_depth = ( $depth + 1 ); // because it counts the first submenu as 0
			$classes = array(
				'sub-menu',
				( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
				( $display_depth >=2 ? 'sub-sub-menu' : '' ),
				'menu-depth-' . $display_depth
				);
			$class_names = implode( ' ', $classes );
			
			// Build html			
			$bg_image = '';
			if ( get_post_meta( $this->curItem->ID, 'menu-item-gp-bg-image', true ) ) { 
				$bg_image = ' style="background-image: url(' . get_post_meta( $this->curItem->ID, 'menu-item-gp-bg-image', true ) . ');"';
			}
			
			$output .= "\n" . $indent . '<ul class="' . $class_names . '"' . $bg_image . '>' . "\n";
			
		}
  
		// Start element (add main/sub classes to li's and links)
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $wp_query;
			
			$this->curItem = $item;
	
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

			// Depth dependent classes
			$depth_classes = array(
				( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
				( $depth >=2 ? 'sub-sub-menu-item' : '' ),
				( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
				'menu-item-depth-' . $depth
			);
			$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

			// Depth dependent classes
			$display_depth = ( $depth + 1); // because it counts the first submenu as 0
			$sub_menu_classes = array(
				'sub-menu',
				( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
				( $display_depth >=2 ? 'sub-sub-menu' : '' ),
				'menu-depth-' . $display_depth
				);
			$submenu_depth_class_names = implode( ' ', $sub_menu_classes );
			
			// Parsed classes
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			// Build html			
			$menu_type = get_post_meta( $item->ID, 'menu-item-gp-type', true ) ? get_post_meta( $item->ID, 'menu-item-gp-type', true ) : 'gp-standard-menu';
			
			// Dropdown menu background image
			$bg_image_class = get_post_meta( $item->ID, 'menu-item-gp-bg-image', true ) != '' ? 'gp-has-bg-image' : '';
			
			if ( ( is_user_logged_in() && get_post_meta( $item->ID, 'menu-item-gp-user-display', true ) != 'gp-show-logged-out' ) OR ( ! is_user_logged_in() && get_post_meta( $item->ID, 'menu-item-gp-user-display', true ) != 'gp-show-logged-in' ) ) {
			
				if ( ( is_user_logged_in() && ( $menu_type == 'gp-login-link' OR $menu_type == 'gp-register-link' ) ) OR ( ! is_user_logged_in() && $menu_type == 'gp-logout-link' ) ) {
				
					$output .= '';
					
				} elseif ( $menu_type != 'gp-menu-header' && get_post_meta( $item->menu_item_parent, 'menu-item-gp-type', true ) == 'gp-megamenu' && $depth == 1 ) {	
			
					$output .= '<li>';
					
				} elseif ( $menu_type == 'gp-notifications' ) {
					
					if ( function_exists( 'bp_notifications_get_notifications_for_user' ) ) {
						$notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id() );
						$output .= '<li class="menu-item gp-profile-menu-tabs">
							<span class="gp-profile-tab gp-active"></span>
							<span class="gp-notifications-tab"></span>
						</li>';
						if ( isset( $notifications ) && $notifications ) {
							foreach( $notifications as $notification ) {
								$output .= '<li class="menu-item gp-notification-link">' . $notification . '</li>';
							}
						} else {
							$output .= '<li class="menu-item gp-notification-link"><span class="gp-menu-text">' . esc_html__( 'You have no notifications.', 'aardvark' ) . '</span></li>';
						}
					}
						
				} else {

					// Link attributes
					$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
					$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
					$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
				
					// Link value
					if ( $menu_type == 'gp-login-link' && $item->url == '#' ) {			
						$item_link = '#login';
					} elseif ( $menu_type == 'gp-register-link' && $item->url == '#' ) {
						if ( function_exists( 'bp_is_active' ) ) {
							$item_link = bp_get_signup_page( false );
						} else {
							$item_link = '#register';
						}	
					} elseif ( $menu_type == 'gp-logout-link' ) {	
						$item_link = wp_logout_url( apply_filters( 'ghostpool_logout_redirect', home_url( '/' ) ) );						
					} else {
						$item_link = $item->url;
					}
				
					$attributes .= ! empty( $item_link ) ? ' href="' . esc_attr( $item_link ) .'"' : '';				
					$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
					
					// Defaults
					$attributes = '<a' . $attributes . '>';
					$link_before = $args->link_before;
					$nav_label = $item->title;
					$link_after = '</a>' . $args->link_after;
					$after = $args->after;
					$dropdown = '';
								
					// Hide navigation label
					if ( get_post_meta( $item->ID, 'menu-item-gp-hide-nav-label', true ) == 'gp-hide-nav-label' ) {
						$nav_label = '';
					}

					// Check whether menu item has icon
					if ( get_post_meta( $item->ID, 'menu-item-gp-icon', true ) != '' ) {
						$icon = '<span class="gp-menu-icon fa ' . get_post_meta( $item->ID, 'menu-item-gp-icon', true ) . '"></span>';
					} else {
						$icon = '';
					}
					
					// Menu Type
					if ( $menu_type == 'gp-tab-content-menu' OR $menu_type == 'gp-content-menu' ) {
						require_once( get_template_directory() . '/lib/menus/content-menus.php' );
						$dropdown = ghostpool_content_menu( $menu_type, $item, $submenu_depth_class_names, $class_names );				
					} elseif ( $menu_type == 'gp-menu-header' ) {
						$attributes = '';
						$link_before = '<span class="gp-menu-header">'. $icon;
						$link_after = '</span>';	
					} elseif ( $menu_type == 'gp-menu-text' ) {
						$attributes = '';
						$link_before = '<span class="gp-menu-text">' . $icon;
						$link_after = '</span>';
					} elseif ( $menu_type == 'gp-menu-image' ) {
						$attributes = '';
						$link_before = '<img src="' . $item->url . '" class="gp-menu-image" alt="" />';
						$nav_label = '';
						$link_after = '';					
					} else {
						$link_before = $args->link_before . $icon;
					}
										
					// Item Output
					$item_output = sprintf( '%1$s%2$s%3$s%4$s%5$s%6$s%7$s',
						$args->before,
						$attributes,
						$link_before,
						apply_filters( 'the_title', $nav_label, $item->ID ),
						$link_after,
						$after,
						$dropdown
					);
								
					// Remove class for registeration link if BP active		
					if ( function_exists( 'bp_is_active' ) && $menu_type == 'gp-register-link' ) {
						$menu_type = 'gp-bp-register-link';
					}
			
					// Build html
					$output .= $indent . '<li class="' . $menu_type . ' ' . get_post_meta( $item->ID, 'menu-item-gp-device-display', true ) . ' ' . get_post_meta( $item->ID, 'menu-item-gp-hide-nav-label', true ) . ' ' . $depth_class_names . ' ' . $bg_image_class . ' ' . $class_names . '">';
					
					$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
				}
				
			}
							
		}
		
		// End element (add closing li's)
		function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		
			$menu_type = get_post_meta( $item->ID, 'menu-item-gp-type', true ) ? get_post_meta( $item->ID, 'menu-item-gp-type', true ) : 'gp-standard-menu';

			if ( ( is_user_logged_in() && get_post_meta( $item->ID, 'menu-item-gp-user-display', true ) != 'gp-show-logged-out' ) OR ( ! is_user_logged_in() && get_post_meta( $item->ID, 'menu-item-gp-user-display', true ) != 'gp-show-logged-in' ) ) {
			
				if ( ( is_user_logged_in() && ( $menu_type == 'gp-login-link' OR $menu_type == 'gp-register-link' ) ) OR ( ! is_user_logged_in() && $menu_type == 'gp-logout-link' ) ) {
				
					$output .= '';
				
				} else {
				
					$output .= '</li>';

				}
			
			}
								
		}

	}
} 

?>