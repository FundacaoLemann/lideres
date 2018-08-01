<?php
/**
 * Template Name: Template login
 */

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
            <?php wp_login_form(); ?>
            <a href="/#lost-password/" class="lost-password lost-password_block">Esqueceu sua senha?</a>
        </div>
        
        
    </div>
    <?php wp_footer();  ?>
</div>
