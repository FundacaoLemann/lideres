<?php
require '/var/www/html/wp-load.php';

global $wpdb;

if(false){ $wpdb = new wpdb; }

$raw = file_get_contents('/importer/base.csv');

$lines = explode("\n", $raw);

$array_data = array_map(function ($line) { return str_getcsv($line, ';'); }, $lines);

/* CHAVES dos ARRAYS
            [0] => Nome Completo
            [1] => Biografia
            [2] => Cargo atual
            [3] => Organiza��o
            [4] => E-mail
            [5] => Linkedin
            [6] => CPF
*/

$bp_field_ids = [
    'linkedin' => 80,
    'biografia' => 79,
    'organizacao' => 26,
    'cargo' => 25
];

$columns = array_shift($array_data);

foreach($array_data as $data){
    if(!$data || !count($data)){
        continue;
    }
    $user_data = [
        'user_pass' => uniqid(true)
    ];
    $user_meta = [
        'show_admin_bar_front' => false
    ];
    $profile_meta = [];

    $where = [];

    if(!$data[0]){
        continue;
    }

    $data[0] = ucwords(strtolower($data[0]));

    if(isset($data[0])){
        $user_data['display_name'] = $data[0];
    }

    if(isset($data[4])){
        $user_data['user_email'] = $data[4];
    }

    if(isset($data[6])){
        $user_meta['CPF'] = $data[6];
    }

    if(isset($data[1])){
        $profile_meta['biografia'] = $data[1];
    }

    if(isset($data[5])){
        $profile_meta['linkedin'] = $data[5];
        $user_meta['linkedin'] = $data[5];
    }

    if(isset($data[2])){
        $profile_meta['cargo'] = $data[2];
    }

    if(isset($data[3])){
        $profile_meta['organizacao'] = $data[3];
    }
    echo "\n";

    $names = explode(' ', $user_data['display_name']);
    $first_name = $names[0];
    $last_name = array_pop($names);

    $user_meta['first_name'] = $first_name;
    $user_meta['last_name'] = $last_name;

    $user_meta['nickname'] = "{$first_name} {$last_name}";

    $user_data['user_login'] = strtolower(sanitize_title("{$first_name}-{$last_name}"));

    print_r($user_data);

    echo "\n";

    print_r([
        'user_data' => $user_data,
        'user_meta' => $user_meta
    ]);
    
    $user_id = wp_insert_user($user_data);

    foreach($user_meta as $meta => $value){
        update_user_meta($user_id, $meta, $value);
    }

    foreach($profile_meta as $meta => $value){
        $wpdb->insert("{$wpdb->prefix}bp_xprofile_data", [
            'field_id' => $bp_field_ids[$meta],
            'user_id' => $user_id,
            'value' => $value
        ]);
        echo "\n ---- > $meta";
    }

    $user = new WP_User( $user_id );
    $user->set_role('inativo');
    
// DELETE FROM wp_users WHERE user_id > 28; DELETE FROM wp_usermeta WHERE user_id NOT IN (SELECT ID FROM wp_users); DELETE FROM wp_bp_xprofile_data WHERE user_id NOT IN (SELECT ID FROM wp_users);


}