<?php if ( $GLOBALS['ghostpool_layout'] == 'gp-both-sidebars' OR $GLOBALS['ghostpool_layout'] == 'gp-right-sidebar' ) { ?>

	<aside id="gp-sidebar-right" class="gp-sidebar">

		<?php
		if ( bp_is_profile_component() && bp_is_current_action( 'public' ) ) {
			$groups = [ 9, 10, 11 ];
			// Se estamos no mês do evento, apresenta o grupo sobre o evento anual primeiro.
			if ( is_event_month() ) {
				array_unshift( $groups, 8 );
			}
			foreach ( $groups as $group ) {
				if ( lemann_user_can_see_group( $group ) ) {
					$args = [
						'exclude_fields'   => '420 422 424 426', // Campos usados para visibilidade.
						'profile_group_id' => $group,
					];
					if ( bp_has_profile( $args ) ) {
						bp_get_template_part( 'members/single/profile/profile-group-loop' );
					}
				}
			}
		}
		?>

		<?php get_template_part( 'lib/sections/sensei/sensei-details' ); ?>

		<?php if ( is_active_sidebar( $GLOBALS['ghostpool_right_sidebar'] ) ) {
			dynamic_sidebar( $GLOBALS['ghostpool_right_sidebar'] );
		} ?>

	</aside>

<?php } ?>
