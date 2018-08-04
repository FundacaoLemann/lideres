<?php
/**
 * Template Name: Template login
 */

if ( ! session_id() ) {
    session_start();
}
if ( is_user_logged_in() ) {
	wp_redirect( home_url( '/' ) );
	exit;
}

wp_head();
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<div class="page-login">
    <div class="logo"><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/logo_negativo_branco.png" alt=""></div>
    <div class="row">
        <div class="col-md-6 align-center">
            <h1>Boas vindas à plataforma de líderes da Fundação Lemann</h1>
            <h3>acesse a plataforma e participe da comunidade Lemann</h3>
            <p class="hide-for-mobile"> * Em caso de dúvidas, entre em contato via <a href="mailto:lideres@fundacaolemann.org.br">lideres@fundacaolemann.org.br</a></p>
        </div>
        <div class="col-md-6">
            <?php
            if ( ! empty( $_SESSION["login_error"] ) ) { ?>
                <div class="login-error">
                    <?php echo $_SESSION["login_error"]; ?>
                </div>
                <?php
                unset( $_SESSION['login_error'] );
            }
            ?>
            <?php wp_login_form(); ?>
            <a href="#lost-password" class="lost-password lost-password-trigger lost-password_block">Esqueceu sua senha?</a>

            <p class="hide-for-desktop mt-15"> * Em caso de dúvidas, entre em contato via <a href="mailto:lideres@fundacaolemann.org.br">lideres@fundacaolemann.org.br</a></p>
        </div>


    </div>
    <?php
    get_template_part( 'lib/sections/login/login-modal' );
    wp_footer();
    ?>
    <script>
        jQuery( document ).ready(function( $ ) {
            $( '.lost-password-trigger' ).click(function() {
                $( '#login' ).show();
                $( '#gp-login-modal .gp-lost-password-form-wrapper' ).show();
                return false;
            });
        });
    </script>
</div>
