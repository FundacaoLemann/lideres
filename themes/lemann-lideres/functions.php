<?php
defined( 'ABSPATH' ) || exit;

// Cria as roles e capabilities personalizadas do site
require get_stylesheet_directory() . '/includes/roles-capabilities.php';

// Custom Post Types e seus campos
require get_stylesheet_directory() . '/post-types/index.php';

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/assets/css/style.css' );
});
