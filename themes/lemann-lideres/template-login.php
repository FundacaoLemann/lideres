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
        </div>
        <div class="col-md-6">
            <?php wp_login_form(); ?>
            <p> "Em caso de dúvidas, entre em contato via lideres@fundacaolemann.org.br"</p>
        </div>
        
    </div>
    <?php wp_footer();  ?>
</div>
