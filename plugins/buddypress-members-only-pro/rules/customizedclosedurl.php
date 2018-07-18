<?php
if (!defined('ABSPATH'))
{
	exit;
}

function fncbpclosedcustomizedurls($current_url)
{
	global $wp_roles, $user_ID;
	
	$tomas_roles_all_array = $wp_roles->roles;
	
	$bpopenedcustomizedurls = get_option ( 'bpclosedcustomizedurls' );

	if (is_user_logged_in () == false) {
	
		if (! (empty ( $bpopenedcustomizedurls ))) {
			$bpopenedcustomizedcomponentarray = explode ( "\n", trim ( $bpopenedcustomizedurls ) );
				
			if ((is_array ( $bpopenedcustomizedcomponentarray )) && (count ( $bpopenedcustomizedcomponentarray ) > 0)) {
				foreach ( $bpopenedcustomizedcomponentarray as $bpopenedcustomizedcomponentsingle ) {
					$bpopenedcustomizedcomponentsingle = str_replace ( '%sitename%', trim ( get_option ( 'siteurl' ) ), $bpopenedcustomizedcomponentsingle );
					$bpopenedcustomizedcomponentsingle = pro_pure_url ( $bpopenedcustomizedcomponentsingle );
						
					if (buddypress_user_type_filter ( $current_url ) == buddypress_user_type_filter ( $bpopenedcustomizedcomponentsingle )) {
						return false;
					}
				}
			}
		}
	} else {
		$user = wp_get_current_user ();
	
		if (empty ( $user->roles )) {
		} else {
			foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array ) {
				$bp_component_role_id = $tomas_roles_single_key;
	
				if (in_array ( $bp_component_role_id , $user->roles ))
				{
	
				}
				else
				{
					continue;
				}
	
				$bp_component_role_id = str_replace ( ' ', '-', $tomas_roles_single_key );
	
				$rolebasedcustomizedcomponent = 'bpclosedcustomizedurls_' . $bp_component_role_id;
				$rolebasedcustomizedcomponentoption_ori = get_option ( $rolebasedcustomizedcomponent );
	
				if (! (empty ( $rolebasedcustomizedcomponentoption_ori ))) {
					$rolebasedcustomizedcomponentoption = explode ( "\n", trim ( $rolebasedcustomizedcomponentoption_ori ) );
					foreach ( $rolebasedcustomizedcomponentoption as $rolebasedcustomizedcomponentoption_single ) {
	
						$rolebasedcustomizedcomponentoption_single = str_replace ( '%sitename%', trim ( get_option ( 'siteurl' ) ), $rolebasedcustomizedcomponentoption_single );
						$rolebasedcustomizedcomponentoption_single = str_replace ( '%username%', trim ( $user->data->user_login ), $rolebasedcustomizedcomponentoption_single );
						$rolebasedcustomizedcomponentoption_single = pro_pure_url ( $rolebasedcustomizedcomponentoption_single );
	
						if (buddypress_user_type_filter ( $current_url ) == buddypress_user_type_filter ( $rolebasedcustomizedcomponentoption_single )) {
							return false;
						} else {
						}
					}
				} else {
					continue;
				}
			}
		}
	}
	return true;
}