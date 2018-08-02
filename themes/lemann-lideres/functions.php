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

add_filter('login_redirect', 'my_login_redirect', 10, 3);
function my_login_redirect($redirect_to, $requested_redirect_to, $user) {
    if (is_wp_error($user)) {
        session_start();
        $error_types = array_keys($user->errors);
        $error_type = 'both_empty';
        if (is_array($error_types) && !empty($error_types)) {
            $error_type = $error_types[0];
        }

        $_SESSION["login_error"] = $user->get_error_message();

        wp_redirect( get_permalink( 93 ) . "/login?login=failed&reason=" . $error_type );
        exit;
    } else {
        return home_url();
    }
}
