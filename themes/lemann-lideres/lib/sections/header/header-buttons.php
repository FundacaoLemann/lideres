<?php

/*
 * Determina se o usuário ainda precisa preencher alguma coisa do perfil.
 * Se há algum campo *obrigatório* incompleto encaminha para lá,
 * senão para o primeiro campo incompleto.
 */
$incomplete_profile_level = 'completo';
$incomplete_field_group   = lemann_check_all_fields();
if ( $incomplete_field_group ) {
	$incomplete_profile_level = 'medio';
	$group_to_complete        = $incomplete_field_group;

	$required_field_group = lemann_check_required_fields();
	if ( $required_field_group ) {
		$incomplete_profile_level = 'insuficiente';
		$group_to_complete        = $required_field_group;
	}

	$group_to_complete    = bp_loggedin_user_domain() . '/profile/edit/group/' . $group_to_complete . '#buddypress';
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
					if ( 'completo' != $incomplete_profile_level ) {
						?>
						<a href="<?php echo $group_to_complete; ?>" class="gp-notification-counter gp-notification-required-fields">!</a>
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
						<div class="gp-profile-required-fields-warning gp-profile-status-<?php echo $incomplete_profile_level; ?>">
							<?php
							if ( 'completo' != $incomplete_profile_level ) {
								_e( 'Seu perfil está incompleto!', 'lemann-lideres' );
							} else {
								_e( 'Seu perfil está completo!', 'lemann-lideres' );
							}
							?>
							<br>

							<div class="gp-profile-complete-levels">
								<?php
								$levels = [ 'insuficiente', 'medio', 'completo' ];
								foreach ( $levels as $level ) {
									?>
									<div class="gp-profile-complete-level<?php echo ( $incomplete_profile_level == $level ) ? ' active' : ''; ?>">
										<span><?php echo $level; ?></span>
									</div>
									<?php
								}
								?>
							</div>

							<a href="<?php echo $group_to_complete; ?>">
								<?php
								if ( 'completo' != $incomplete_profile_level ) {
									_e( 'Complete agora mesmo', 'lemann-lideres' );
								} else {
									_e( 'Atualize', 'lemann-lideres' );
								}
								?>
							</a>
						</div>
						<?php

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
