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
<div class="page-login">
    <div class="logo"><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/logo_negativo_branco.png" alt=""></div>
    <div class="row">
        <div class="col-md-6 align-center">
            <h1>Boas vindas à plataforma de líderes da Fundação Lemann</h1>
            <h3>acesse a plataforma e participe da comunidade Lemann</h3>
            <p> * Em caso de dúvidas, entre em contato via <a href="mailto:lideres@fundacaolemann.org.br">lideres@fundacaolemann.org.br</a></p>
        </div>
        <div class="col-md-6">
            <?php
            if ( ! empty( $_SESSION["login_error"] ) ) { ?>
                <div class="login-error">
                    <?= isset($_SESSION["login_error"]) ? str_replace('<strong>ERRO</strong>: ', '', $_SESSION["login_error"]) : 'Usuário ou senha inválido. <a href="#lost-password/">Esqueceu sua senha?</a>' ?>
                </div>
                <?php
                unset($_SESSION['login_error']);
            }
            ?>
            <?php wp_login_form(); ?>
            <a href="#lost-password" class="lost-password lost-password_block">Esqueceu sua senha?</a>
        </div>


    </div>
    <?php
    get_template_part( 'lib/sections/login/login-modal' );
    wp_footer();
    ?>
    <script>
        jQuery( document ).ready(function( $ ) {
            $( '.lost-password' ).click(function() {
                $( '#login' ).show();
                $( '#gp-login-modal .gp-lost-password-form-wrapper' ).show();
                return false;
            });
        });
    </script>
</div>
