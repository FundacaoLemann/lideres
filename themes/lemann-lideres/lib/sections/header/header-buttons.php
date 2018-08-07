<?php

$user_required_field_group = lemann_check_required_fields();
if ( $user_required_field_group ) {
	$user_required_field_group = bp_loggedin_user_domain() . '/profile/edit/group/' . $user_required_field_group . '#buddypress';
}


if ( ghostpool_option( 'profile_button' ) != 'gp-profile-button-disabled' OR ghostpool_option( 'search_button' ) != 'gp-search-button-disabled' OR ghostpool_option( 'cart_button' ) != 'gp-cart-button-disabled' OR has_nav_menu( 'gp-mobile-primary-nav' ) ) { ?>

	<div class="gp-header-buttons gp-nav menu">

		<?php if ( function_exists( 'is_woocommerce' ) && ghostpool_option( 'cart_button' ) != 'gp-cart-button-disabled' ) { echo ghostpool_dropdown_cart(); } ?>

		<?php if ( ghostpool_option( 'search_button' ) != 'gp-search-button-disabled' ) { ?>
			<div class="gp-search-button gp-header-button"></div>
		<?php } ?>

		<?php if ( ghostpool_option( 'profile_button' ) != 'gp-profile-button-disabled' ) { ?>
			<?php if ( is_user_logged_in() ) { ?>
				<div class="gp-profile-button gp-header-button menu-item gp-standard-menu<?php if ( has_nav_menu( 'gp-profile-nav' ) ) { ?> gp-has-menu<?php } ?>">

					<a href="<?php if ( function_exists( 'bp_is_active' ) ) {
							global $bp;
							echo apply_filters( 'ghostpool_profile_url', $bp->loggedin_user->domain );
						} else {
							$user_id = get_current_user_id();
							echo get_author_posts_url( $user_id );
						} ?>" class="gp-profile-button-avatar">
						<?php if ( function_exists( 'bp_is_active' ) ) {
							echo bp_core_fetch_avatar( array( 'item_id' => bp_loggedin_user_id() ) );
						} else {
							echo get_avatar( $user_id, 30 );
						} ?>
					</a>

					<?php
					if ( $user_required_field_group ) {
						?>
						<a href="<?php echo $user_required_field_group; ?>" class="gp-notification-counter gp-notification-required-fields">!</a>
						<?php
					}  elseif ( function_exists( 'bp_notifications_get_notifications_for_user' ) ) {
						global $bp;
						$notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id() );
						if ( isset( $notifications ) && $notifications > 0 ) {
							?>
							<a href="<?php echo apply_filters( 'ghostpool_notifications_url', $bp->loggedin_user->domain . '/notifications' ); ?>" class="gp-notification-counter"><?php echo count( $notifications ); ?></a>
							<?php
						}
					}

					?>
					<div class="sub-menu">
						<?php

						if ( $user_required_field_group ) {
							?>
							<div class="gp-profile-required-fields-warning">
								Seu perfil está incompleto!<br>
								<a href="<?php echo $user_required_field_group; ?>">Complete agora mesmo</a>
							</div>
							<?php
						}

						wp_nav_menu( array(
							'theme_location' => 'gp-profile-nav',
							'sort_column'    => 'menu_order',
							'container'      => 'ul',
							'menu_id'        => 'gp-profile-menu',
							'menu_class'     => 'gp-profile-menu',
							'fallback_cb'    => 'null',
							'walker'         => new Ghostpool_Custom_Menu,
						) );
						?>
					</div>

				</div>

			<?php } else { ?>

				<a href="<?php if ( ghostpool_option( 'login_register_popup_redirect' ) == 'enabled' ) { echo apply_filters( 'ghostpool_login_popup_url', '#login' ); } else { echo apply_filters( 'ghostpool_login_standard_url', '' ); } ?>" class="gp-profile-button gp-header-button"></a>

			<?php } ?>

		<?php } ?>

		<?php if ( has_nav_menu( 'gp-mobile-primary-nav' ) ) { ?>
			<div class="gp-open-mobile-nav-button">
				<div>
					<div class="gp-nav-button-icon"></div>
				</div>
			</div>
		<?php } ?>

	</div>

<?php } ?>
