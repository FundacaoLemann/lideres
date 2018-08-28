<?php if ( ! isset( $display ) ) {
	$display = array( 'login-form', 'register-form', 'lost-password-form' );
} ?>

<div class="gp-login-register-form <?php if ( isset( $css_classes ) ) { echo $css_classes; } ?>">

	<?php if ( in_array( 'login-form', $display ) ) { ?>

		<div class="gp-login-form-wrapper">

			<h5 class="gp-login-title"><?php esc_html_e( 'Sign In' ,'aardvark' ); ?></h5>

			<form name="loginform" class="gp-login-form" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">

				<p class="username"><input type="text" name="log" class="user_login" value="<?php if ( ! empty( $user_login ) ) { echo esc_html( stripslashes( $user_login ), 1 ); } ?>" size="20" placeholder="<?php esc_html_e( 'Username Or Email', 'aardvark' ); ?>" required /></p>

				<p class="password"><input type="password" name="pwd" class="user_pass" size="20" placeholder="<?php esc_html_e( 'Password', 'aardvark' ); ?>" required /></p>

				<p class="rememberme"><input name="rememberme" class="rememberme" type="checkbox" value="forever" /> <?php esc_html_e( 'Remember Me', 'aardvark' ); ?></p>

				<?php if ( function_exists( 'ghostpool_custom_captcha_display' ) ) {
					echo ghostpool_custom_captcha_display();
				} elseif ( function_exists( 'gglcptch_display' ) ) {
					echo gglcptch_display();
				} elseif ( has_filter( 'hctpc_verify' ) ) {
					echo apply_filters( 'hctpc_display', '' );
				} elseif ( has_filter( 'cptch_verify' ) ) {
					echo apply_filters( 'cptch_display', '' );
				} ?>

				<?php if ( has_action ( 'wordpress_social_login' ) ) { ?>
					<div class="gp-social-login">
						<div class="gp-login-or-lines">
							<div class="gp-login-or-left-line"></div>
							<div class="gp-login-or-text"><?php esc_html_e( 'or', 'aardvark' ); ?></div>
							<div class="gp-login-or-right-line"></div>
						</div>
						<?php do_action( 'wordpress_social_login' ); ?>
					</div>
				<?php } ?>

				<input type="submit" name="wp-submit" class="wp-submit" value="<?php esc_html_e( 'Sign In', 'aardvark' ); ?>" />

				<div class="gp-login-results" data-verify="<?php esc_html_e( 'Verifying...', 'aardvark' ); ?>"></div>

				<div class="gp-login-links">
					<?php if ( get_option( 'users_can_register' ) && in_array( 'register-form', $display ) ) { ?>
						<?php if ( function_exists( 'bp_is_active' ) ) { ?>
							<a href="<?php echo esc_url( bp_get_signup_page( false ) ); ?>" class="gp-bp-register-link"><?php esc_html_e( 'Register', 'aardvark' ); ?></a>
						<?php } else { ?>
							<a href="#" class="gp-register-link"><?php esc_html_e( 'Register', 'aardvark' ); ?></a>
						<?php } ?>
					<?php } ?>
					 <?php if ( in_array( 'lost-password-form', $display ) ) { ?>
						<a href="#" class="gp-lost-password-link"><?php esc_html_e( 'Lost Password', 'aardvark' ); ?></a>
					 <?php } ?>
				</div>

				<input type="hidden" name="action" value="ghostpool_login" />

				<?php if ( isset( $element_nonce ) && $element_nonce == true ) { ?>
					<?php wp_nonce_field( 'ghostpool_login_page_action', 'ghostpool_login_page_nonce' ); ?>
				<?php } else { ?>
					<?php wp_nonce_field( 'ghostpool_login_popup_action', 'ghostpool_login_popup_nonce' ); ?>
				<?php } ?>

			</form>

		</div>

	<?php } ?>

	<?php if ( in_array( 'lost-password-form', $display ) ) { ?>

		<div class="gp-lost-password-form-wrapper">

			<h5 class="gp-login-title"><?php esc_html_e( 'Para Primeiro Acesso e Esqueci minha Senha', 'lemann-lideres' ); ?></h5>

			<form name="lostpasswordform" class="gp-lost-password-form" action="#" method="post">

				<p class="gp-login-desc"><?php esc_html_e( 'Digite seu endereço de e-mail. Você receberá em seu e-mail um link para criar uma senha.', 'lemann-lideres' ); ?></p>

				<p><input type="text" name="user_login" class="user_login" value="" size="20" placeholder="<?php esc_html_e( 'Endereço de e-mail', 'lemann-lideres' ); ?>" required /></p>

				<input type="submit" name="wp-submit" class="wp-submit" value="<?php esc_html_e( 'Definir Senha', 'lemann-lideres' ); ?>" />

				<div class="gp-login-results" data-verify="<?php esc_html_e( 'Verifying...', 'aardvark' ); ?>"></div>

				<div class="gp-login-links">
					<?php if ( get_option( 'users_can_register' ) && in_array( 'register-form', $display ) ) { ?>
						<?php if ( function_exists( 'bp_is_active' ) ) { ?>
							<a href="<?php echo esc_url( bp_get_signup_page( false ) ); ?>" class="gp-bp-register-link"><?php esc_html_e( 'Register', 'aardvark' ); ?></a>
						<?php } else { ?>
							<a href="#" class="gp-register-link"><?php esc_html_e( 'Register', 'aardvark' ); ?></a>
						<?php } ?>
					<?php } ?>
					<?php if ( in_array( 'login-form', $display ) ) { ?>
						<a href="#" class="gp-login-link"><?php esc_html_e( 'Sign In', 'aardvark' ); ?></a>
					<?php } ?>
				</div>

				<input type="hidden" name="action" value="ghostpool_lost_password" />

				<?php if ( isset( $element_nonce ) && $element_nonce == true ) { ?>
					<?php wp_nonce_field( 'ghostpool_lost_password_page_action', 'ghostpool_lost_password_page_nonce' ); ?>
				<?php } else { ?>
					<?php wp_nonce_field( 'ghostpool_lost_password_popup_action', 'ghostpool_lost_password_popup_nonce' ); ?>
				<?php } ?>

			</form>

		</div>

	<?php } ?>

	<?php if ( get_option( 'users_can_register' ) && ! function_exists( 'bp_is_active' ) && in_array( 'register-form', $display ) ) { ?>

		<div class="gp-register-form-wrapper">

			<h5 class="gp-login-title"><?php esc_html_e( 'Sign Up' ,'aardvark' ); ?></h5>

			<form name="registerform" class="gp-register-form" action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>" method="post">

				<p class="user_login"><input type="text" name="user_login" class="user_login" value="<?php if ( ! empty( $user_login ) ) { echo esc_html( stripslashes( $user_login ), 1 ); } ?>" size="20" placeholder="<?php esc_html_e( 'Username', 'aardvark' ); ?>" required /></p>

				<p class="user_email"><input type="email" name="user_email" class="user_email" size="25" placeholder="<?php esc_html_e( 'Email', 'aardvark' ); ?>" required /></p>

				<p class="user_confirm_pass"><span class="gp-password-icon"></span><input type="password" name="user_confirm_pass" class="user_confirm_pass" size="25" placeholder="<?php esc_attr_e( 'Password', 'aardvark' ); ?>" required /></p>

				<p class="user_pass"><span class="gp-password-icon"></span><input type="password" name="user_pass" class="user_pass" size="25" placeholder="<?php esc_attr_e( 'Confirm Password', 'aardvark' ); ?>" required /></p>

				<?php if ( function_exists( 'ghostpool_custom_captcha_display' ) ) {
					return ghostpool_custom_captcha_display();
				} elseif ( function_exists( 'gglcptch_display' ) ) {
					echo gglcptch_display();
				} elseif ( has_filter( 'hctpc_verify' ) ) {
					echo apply_filters( 'hctpc_display', '' );
				} elseif ( has_filter( 'cptch_verify' ) ) {
					echo apply_filters( 'cptch_display', '' );
				} ?>

				<input type="submit" name="wp-submit" class="wp-submit" value="<?php esc_html_e( 'Sign Up', 'aardvark' ); ?>" />

				<?php if ( ghostpool_option( 'registration_gdpr' ) == 'enabled' ) { ?>
					<p class="gp-gdpr"><input name="gdpr" class="gdpr" type="checkbox" value="1" required /> <label><?php echo wp_kses_post( ghostpool_option( 'registration_gdpr_text' ) ); ?></label></p>
				<?php } ?>

				<div class="gp-login-results" data-verify="<?php esc_html_e( 'Verifying...', 'aardvark' ); ?>"></div>

				<div class="gp-login-links">
					 <?php if ( in_array( 'login-form', $display ) ) { ?>
						<a href="#" class="gp-login-link"><?php esc_html_e( 'Sign In', 'aardvark' ); ?></a>
					<?php } ?>
				</div>

				<input type="hidden" name="action" value="ghostpool_register" />

				<?php if ( isset( $element_nonce ) && $element_nonce == true ) { ?>
					<?php wp_nonce_field( 'ghostpool_register_page_action', 'ghostpool_register_page_nonce' ); ?>
				<?php } else { ?>
					<?php wp_nonce_field( 'ghostpool_register_popup_action', 'ghostpool_register_popup_nonce' ); ?>
				<?php } ?>

			</form>

		</div>

	<?php } ?>

</div>
