<?php
require '/var/www/html/wp-load.php';

global $wpdb;

if(false){ $wpdb = new wpdb; }

$raw = file_get_contents('/importer/lideres-nao-cadastrados.csv');

$lines = explode("\n", $raw);

$array_data = array_map(function ($line) { return str_getcsv($line, ';'); }, $lines);

/* CHAVES dos ARRAYS
            [0] => Nome Completo
            [1] => Biografia
            [2] => Cargo atual
            [3] => Organização
            [4] => E-mail
            [5] => Linkedin
            [6] => CPF
*/

$bp_field_ids = [
    'linkedin' => 80,
    'telefone' => 77,
    'biografia' => 79,
    'organizacao' => 26,
    'cargo' => 25,
    'perfil' => 27
];


$perfil_rede = [
    'Talento da Saúde',
    'Talento da Educação',
    'Lemann Fellow',
    'Líder Público',
    'Terceiro Setor Transforma'
];

$columns = array_shift($array_data);

$logins = [];

foreach($array_data as $data){

    if(!$data || !count($data)){
        continue;
    }
    $user_data = [
        'user_pass' => uniqid()
    ];
    $user_meta = [
        'show_admin_bar_front' => false
    ];
    $profile_meta = [];

    $where = [];

    if(!$data[0]){
        continue;
    }

    /*
    0 Nome completo
    1 Email
    2 CPF
    3 Perfil
    4 Celular
    5 Mini-bio
    6 Linkedin
    7 Cargo atual
    8 Organização
    */

    $data[0] = ucwords(strtolower($data[0]));

    if(isset($data[0])){
        $user_data['display_name'] = $data[0];
    } else {
        continue;
    }

    if(isset($data[1])){
        $user_data['user_email'] = $data[1];
    } else {
        continue;
    }

    $roles = ['inativo'];

    if(isset($data[3])){
        $perfis = array_map(function($el) use($perfil_rede) {
            return trim($el);
        }, explode('/', $data[3]));

        if(in_array('Parceiro', $perfis)){
            $roles[] = 'parceiro';
        }

        if(in_array('Equipe', $perfis) || in_array('Equipe Fundação Lemann', $perfis)){
            $roles[] = 'equipe';
        }

        $perfis = array_filter($perfis, function($el) use($perfil_rede) {
            if(in_array($el, $perfil_rede)){
                return $el;
            }
        });

        if(count($perfis) > 0){
            $roles[] = 'lider';
        }

        $profile_meta['perfil'] = array_filter($perfis);
    }

    if(!count($roles) < 2){
        $roles[] = 'lider';
    }

    if(isset($data[4])){
        $profile_meta['telefone'] = $data[4];
    }

    if(isset($data[5])){
        $profile_meta['biografia'] = $data[5];
    }

    if(isset($data[6])){
        $profile_meta['linkedin'] = $data[6];
        $user_meta['linkedin'] = $data[6];
    }

    if(isset($data[7])){
        $profile_meta['cargo'] = $data[7];
    }

    if(isset($data[8])){
        $profile_meta['organizacao'] = $data[8];
    }

    if(isset($data[2])){
        $user_meta['CPF'] = $data[2];
    }

    echo "\n";

    $names = explode(' ', $user_data['display_name']);
    $first_name = $names[0];
    $last_name = array_pop($names);

    $user_meta['force_password_change'] = true;

    $user_meta['first_name'] = $first_name;
    $user_meta['last_name'] = $last_name;

    $user_meta['nickname'] = "{$first_name} {$last_name}";

    $login = strtolower(sanitize_title("{$first_name}-{$last_name}"));

    if(in_array($login, $logins)){
        $login = strtolower(sanitize_title("{$first_name}{$last_name}"));
    }

    if(in_array($login, $logins)){
        $login = strtolower(sanitize_title("{$first_name}-{$last_name}2"));
    }

    if(in_array($login, $logins)){
        $login = strtolower(sanitize_title("{$first_name}{$last_name}2"));
    }

    $logins[] = $login;

    $user_data['user_login'] = $login;

    $user_id = wp_insert_user($user_data);

    if($user_id instanceof WP_Error){
        var_dump($user_data,$user_id);
        continue;
    }

    foreach($user_meta as $meta => $value){
        update_user_meta($user_id, $meta, $value);
    }

    foreach($profile_meta as $meta => $value){
        if(is_object($value) || is_array($value)){
            $value = serialize($value);
        }

        $value = esc_sql("$value");

        $field_id = $bp_field_ids[$meta];

        $wpdb->query("INSERT INTO {$wpdb->prefix}bp_xprofile_data (field_id, user_id, value) VALUES ($field_id, $user_id, '$value')");

        echo "\n ---- > $meta";
    }

    $user = new WP_User( $user_id );
    $user->set_role('');
    foreach($roles as $role){
        $user->add_role($role);
    }
}