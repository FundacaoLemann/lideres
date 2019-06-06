<?php
function migration_not_applied($migration_name){
    return ! (bool) get_option('MIGRATION:' . $migration_name);
}

function apply_migration($migration_name, $function){
    if(migration_not_applied($migration_name)){
        if($function() !== false){
            add_option('MIGRATION:' . $migration_name, 1);
        }
    }
}

global $wpdb;
if(false) $wpdb = new \wpdb('','', '', '');

$migrations = [
    'merge_linkedin_fields' => function() use($wpdb) {
        $table_name = $wpdb->prefix . 'bp_xprofile_data';

        $vals = $wpdb->get_results("select * from $table_name where field_id in (80, 715) order by user_id asc");
    
        $users = [];

        foreach($vals as $val){
            if(!isset($users[$val->user_id])){
                $users[$val->user_id] = [];
            }
            $users[$val->user_id][$val->field_id] = $val;
        }
        
        foreach($users as $user_id => $fields){
            $field_715 = isset($fields[715]) ? $fields[715] : null;
            $field_80 = isset($fields[80]) ? $fields[80] : null;
            
            if($field_715 && !$field_80){
                $wpdb->query("UPDATE $table_name SET field_id = 80 WHERE id = {$field_715->id}");

            } else if($field_715 && $field_80){
                if(strlen(trim($field_715->value)) > strlen(trim($field_80->value))){
                    $wpdb->query("UPDATE $table_name SET value = '{$field_715->value}' WHERE id = {$field_80->id}");
                }
                $wpdb->query("DELETE FROM $table_name WHERE id = {$field_715->id}");
            }
        }
        
        $wpdb->query("delete from wp_bp_xprofile_fields where id = 715");
    }

];

foreach($migrations as $name => $fn){
    apply_migration($name, $fn);
}
