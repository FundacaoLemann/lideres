<?php
defined( 'ABSPATH' ) || exit;

// Cria as roles e capabilities personalizadas do site.
require get_stylesheet_directory() . '/includes/roles-capabilities.php';

// RT Media Gallery.
require get_stylesheet_directory() . '/includes/rt-media-gallery.php';

// Custom Post Types e seus campos.
require get_stylesheet_directory() . '/post-types/index.php';

// Page builder.
require get_stylesheet_directory() . '/page-builder/index.php';

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/assets/css/style.css' );

    wp_enqueue_style( 'js_composer_front' );
});

/**
 * Redireciona o usuário para a paǵina de login colocando
 * a mensagem de erro em uma variável de sessão.
 */
add_filter( 'authenticate', function( $user, $username, $password ) {
    if ( empty( $username ) || empty( $password ) || is_wp_error( $user ) || null == $user ) {

        if ( ! session_id() ) {
            session_start();
        }

        if ( empty( $username ) || empty( $password ) ) {
            $_SESSION["login_error"] = 'Usuário e senha são obrigatórios.';
        } else {
            $_SESSION["login_error"] = 'Usuário ou senha inválidos. <a href="#lost-password/"  class="lost-password-trigger">Esqueceu sua senha?</a>';
        }

        wp_redirect( get_permalink( 100000179 ) );
        exit;

    }
    return $user;
}, 9999, 3 );
