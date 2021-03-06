<?php
/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the display of a member's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_header' );
?>

<div id="item-header-avatar">
	<a href="<?php bp_displayed_user_link(); ?>">
		<?php echo ghostpool_is_user_online( bp_displayed_user_id(), bp_get_last_activity( bp_displayed_user_id() ) ); ?>
		<?php bp_displayed_user_avatar( 'type=full' ); ?>
	</a>
</div>

<div id="item-header-content">
	<div class="vc_row">
		<div class="vc_col-md-8">
			<div>
				<div class="gp-bp-header-title">
					<?php echo bp_core_get_user_displayname( bp_displayed_user_id() ); ?>
				</div>

				<?php
				$cargo   = xprofile_get_field_data( 'Cargo em' );
				$empresa = xprofile_get_field_data( 'Organização em que trabalha' );
				if ( ! empty( $cargo ) || ! empty( $empresa ) ) {
					?>
					<div class="header-cargo-empresa">
						<span class="header-cargo"><?php echo $cargo; ?></span>
						<?php if ( ! empty( $cargo ) && ! empty( $empresa ) ) { ?>
							em
						<?php } ?>
						<span class="header-empresa"><?php echo $empresa; ?></span>
					</div>
				<?php } ?>
			</div>

			<?php

			$descricao = xprofile_get_field_data( 'Subtítulo descritivo' );
			if ( $descricao ) {
				?>
				<div class="header-descricao">
					<?php echo $descricao; ?>
				</div>
				<?php
			}

			$temas_id = xprofile_get_field_id_from_name( 'Temas de Interesse' );
			$temas    = xprofile_get_field_data( $temas_id );
			if ( isset( LEMANN_BP_OUTROS[ $temas_id ] ) ) {
				$temas_outros = xprofile_get_field_data( LEMANN_BP_OUTROS[ $temas_id ] );
			}
			if ( ! empty( $temas ) || ! empty( $temas_outros ) ) {
				?>
				<div class="header-temas-interesse">
					<span class="header-temas-interesse--titulo">Áreas de interesse</span>
					<?php
					$temas = ( ! empty( $temas ) ) ? $temas : [];
					if ( ! empty( $temas_outros ) ) {
						$temas_outros = explode( ',', $temas_outros );
						$temas        = array_merge( $temas, $temas_outros );
					}
					foreach ( $temas as $tema ) {
						if ( 'Outros' != $tema ) {
							?>
							<span class="lemann-tag header-tema-interesse"><?php echo $tema; ?></span>
							<?php
						}
					}
					?>
				</div>
				<?php
			}

			?>

			<?php do_action( 'bp_before_member_header_meta' ); ?>

			<div class="gp-bp-header-actions">
				<?php
				function lemann_bp_get_add_friend_button( $button ) {
					if ( 'not_friends' == $button['id'] ) {
						$button['link_text'] = 'Adicionar contato';
					}
					return $button;
				}
				add_filter( 'bp_get_add_friend_button', 'lemann_bp_get_add_friend_button' );
				remove_action( 'bp_member_header_actions', 'bp_send_public_message_button', 20 );
				do_action( 'bp_member_header_actions' );
				?>
			</div>

			<?php do_action( 'bp_profile_header_meta' ); /* Display custom profile fields */ ?>
		</div>

		<div class="vc_col-md-4">
			<div class="responsive-column">
				<?php
				$telefone = xprofile_get_field_data( 'Telefone' );
				$email    = xprofile_get_field_data( 'Email' );
				if ( $telefone || $email ) { ?>
					<h2>Contatos</h2>
					<ul>
						<?php
						if ( $telefone ) {
							echo "<li>{$telefone}</li>";
						}
						if ( $email ) {
							echo "<li>{$email}</li>";
						}
						?>
					</ul>
					<?php
				}

				?>

				<div id="gp-author-social-icons">
					<?php
					// Profile fields.
					$redes_sociais = [
						'linkedin'   => [
							'name'      => 'Linkedin',
							'css_class' => 'linkedin',
						],
						'facebook'   => [
							'name'      => 'Facebook',
							'css_class' => 'facebook',
						],
						'twitter'    => [
							'name'      => 'Twitter',
							'css_class' => 'twitter',
						],
						'googleplus' => [
							'name'      => 'Google+',
							'css_class' => 'google-plus',
						],
					];
					foreach ( $redes_sociais as $slug => $data ) {
						$url = bp_get_profile_field_data( array( 'field' => $data['name'] ) );
						if ( ! $url ) {
							$url = get_the_author_meta( $slug, bp_displayed_user_id() );
						}
						if ( $url ) {
							?>
							<a href="<?php echo esc_url( $url ); ?>" class="gp-<?php echo $data['css_class']; ?>-icon"></a>
							<?php
						}
					}
					?>
				</div>
			</div>

			<div class="responsive-column">
				<?php

				// Localidade.
				$pais = xprofile_get_field_data( 'País em que reside' );
				if ( ! empty( $pais ) ) {
					$estado = xprofile_get_field_data( 'Estado em que reside' );
					$cidade = xprofile_get_field_data( 'Cidade em que reside' );
					?>
						<h2>Localidade</h2>
						<span class="header-localidade--texto">
							<?php
							$output = $pais;
							if ( ! empty( $estado ) ) {
								$output = $estado . ' - ' . $output;
							}
							if ( ! empty( $cidade ) ) {
								$output = $cidade . ', ' . $output;
							}
							echo $output;
							?>
						</span>
					<?php
				}
				?>

				<?php

				$_perfil = xprofile_get_field_data( 'Perfil' );
				if ( $_perfil ) {
					?>
					<h2>Rede de Líderes</h2>
					<?php
					echo is_array($_perfil) ? implode(', ', $_perfil) : $_perfil;
				}
				?>
			</div>
		</div>
	</div>
	<div class="vc_row">
		<?php
		/**
		 * Fires after the display of a member's header.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_header' );
		?>
		<div id="template-notices" role="alert" aria-atomic="true">
			<?php
			/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
			do_action( 'template_notices' );
			?>

		</div>
	</div>

</div>

