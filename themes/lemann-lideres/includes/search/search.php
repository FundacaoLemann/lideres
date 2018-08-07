<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('lemann-search', get_stylesheet_directory_uri() . '/includes/search/search.js', array('lemann-scripts'), null, true);
    wp_localize_script('lemann-search', 'leman_search', ['ajaxurl' => admin_url( 'admin-ajax.php' )]);
});

add_action('wp_ajax_fl_search', 'fl_search');
add_action('wp_ajax_nopriv_fl_search', 'fl_search');

function fl_sanitize_term($term){
    return esc_sql(strtolower(trim($term)));
}

function fl_search() {

    if(!isset($_GET['search']) || !trim($_GET['search'])){
        echo "";
    }

    $term = @$_GET['search'];

    echo fl_get_search_result($term);
    exit;
}

function fl_get_search_result($term){
    $members = fl_get_search_members($term);
    include __DIR__ . '/user-template.php';

    $posts = fl_get_search_posts($term);
    include __DIR__ . '/posts-template.php';

}

function fl_get_search_members($term){
    global $wpdb;
    if(false) $wpdb = new wpdb;
    
    $term = fl_sanitize_term($term);

    $cache_key = __METHOD__ . ':' . $term;

    if(apcu_exists($cache_key)){
        return apcu_fetch($cache_key);
    }

    $sql = "
        SELECT
            ID, display_name, user_nicename
        FROM
            $wpdb->users
        WHERE
            user_status = 0 AND
            (
                display_name LIKE '%{$term}%' OR
                ID IN (
                    SELECT user_id FROM {$wpdb->prefix}bp_xprofile_data WHERE value LIKE '%{$term}%'
                )
            )";


    $result = $wpdb->get_results($sql);
    $base_permalink = get_bloginfo('url') . "/conheca-a-rede/";
    foreach($result as &$user){
        $user->permalink = $base_permalink . $user->user_nicename;
    }
    
    apcu_store($cache_key, $result, 300);

    return $result;

}

function fl_get_search_posts($term){
    $term = fl_sanitize_term($term);

    $cache_key = __METHOD__ . ':' . $term;

    if(apcu_exists($cache_key)){
        return apcu_fetch($cache_key);
    }

    $result = get_posts([
        's' => $term,
        'post_type' => ['post', 'page'],
        'numberposts' => -1,
    ]);

    apcu_store($cache_key, $result, 300);

    return $result;
}



add_action( 'pre_get_posts', function($query){
    if($query->is_search()){
        $query->set('post_type', ['post', 'page']);
    }
});