<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('lemann-search', get_stylesheet_directory_uri() . '/includes/search/search.js', array('lemann-scripts'), null, true);
    wp_localize_script('lemann-search', 'leman_search', ['ajaxurl' => admin_url( 'admin-ajax.php' )]);
});

add_action('wp_ajax_fl_search', 'fl_search');
add_action('wp_ajax_nopriv_fl_search', 'fl_search');

function fl_search() {
    global $wpdb;
    if(false) $wpdb = new wpdb;
    
    $text = @$_GET['search'];

    $sql = "
        SELECT
            ID, display_name, user_nicename
        FROM
            $wpdb->users
        WHERE
            user_status = 0 AND
            (
                display_name LIKE '%{$text}%' OR
                ID IN (
                    SELECT user_id FROM {$wpdb->prefix}bp_xprofile_data WHERE value LIKE '%{$text}%'
                )
            )";
    
    $result = $wpdb->get_results($sql);

    include __DIR__ . '/user-template.php';
    
    exit;
}
