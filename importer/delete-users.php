<?php
require '/var/www/html/wp-load.php';

$users = get_users(['role' => 'inativo']);


foreach($users as $user){
    echo "\nDELETANDO USURÁRIO $user->user_email ($user->ID)...";
    wp_delete_user($user->ID);
    echo " OK\n\n";
}
