<?php
/**
 * Template Name: Template login
 */
session_start();
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
            if(isset($_GET['login']) && $_GET['login'] == 'failed'){ ?>
                <div class="login-error">
                    <?= isset($_SESSION["login_error"]) ? str_replace('<strong>ERRO</strong>: ', '', $_SESSION["login_error"]) : 'Usuário ou senha inválido. <a href="/#lost-password/">Esqueceu sua senha?</a>' ?>
                </div>
                <?php
                unset($_SESSION['login_error']);
            }
            ?>
            <?php wp_login_form(); ?>
            <a href="/#lost-password/" class="lost-password lost-password_block">Esqueceu sua senha?</a>
        </div>


    </div>
    <?php wp_footer();  ?>
</div>
