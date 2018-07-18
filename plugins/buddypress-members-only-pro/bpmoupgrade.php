<?php
if (!defined('ABSPATH'))
{
	exit;
}

function bpmo_upgrade_254() {
	$bpmocurrentversion = get_option ( 'bpmocurrentversion' );
	$bpmocurrentversion = str_replace ( '.', '', $bpmocurrentversion );
	
	if ((empty ( $bpmocurrentversion )) || ($bpmocurrentversion < 254)) {
		
		global $wpdb, $wp_roles;
		
		$user = wp_get_current_user ();
		$userroles = $user->roles;
		
		$tomas_roles_all_array = $wp_roles->roles;
		
		foreach ( $tomas_roles_all_array as $tomas_roles_single_key => $tomas_roles_single_array ) 
		{
			$tomas_roles_single_name = $tomas_roles_single_array ['name'];
			$tomas_roles_single_id = $tomas_roles_single_key;
			
			$tomas_roles_single_name_low = strtolower ( $tomas_roles_single_name );
			
			$bpmemonlyredirecttypeafterlogin = 'bpmemonlyredirecttypeafterlogin_' . $tomas_roles_single_name;
			$bpmemonlyredirecturlafterlogin = 'bpmemonlyredirecturlafterlogin_' . $tomas_roles_single_name;
			$bpmemonlyredirecttypeafterlogout = 'bpmemonlyredirecttypeafterlogout_' . $tomas_roles_single_name;
			$bpmemonlyredirecturlafterlogout = 'bpmemonlyredirecturlafterlogout_' . $tomas_roles_single_name;
			
			$bpmemonlyredirecttypeafterlogin_id = 'bpmemonlyredirecttypeafterlogin_' . $tomas_roles_single_id;
			$bpmemonlyredirecturlafterlogin_id = 'bpmemonlyredirecturlafterlogin_' . $tomas_roles_single_id;
			$bpmemonlyredirecttypeafterlogout_id = 'bpmemonlyredirecttypeafterlogout_' . $tomas_roles_single_id;
			$bpmemonlyredirecturlafterlogout_id = 'bpmemonlyredirecturlafterlogout_' . $tomas_roles_single_id;
			
			$bpmemonlyredirecttypeafterloginori = get_option ( $bpmemonlyredirecttypeafterlogin );
			if (! (empty ( $bpmemonlyredirecttypeafterloginori ))) {
				update_option ( $bpmemonlyredirecttypeafterlogin_id, $bpmemonlyredirecttypeafterloginori );
				$bpmemonlyredirecttypeafterlogin_result = get_option ( $bpmemonlyredirecttypeafterlogin_id );
			}
			
			$bpmemonlyredirecturlafterloginori = get_option ( $bpmemonlyredirecturlafterlogin );
			if (! (empty ( $bpmemonlyredirecturlafterloginori ))) {
				update_option ( $bpmemonlyredirecturlafterlogin_id, $bpmemonlyredirecturlafterloginori );
			}
			
			$bpmemonlyredirecttypeafterlogoutori = get_option ( $bpmemonlyredirecttypeafterlogout );
			if (! (empty ( $bpmemonlyredirecttypeafterlogoutori ))) {
				update_option ( $bpmemonlyredirecttypeafterlogout_id, $bpmemonlyredirecttypeafterlogoutori );
			}
			
			$bpmemonlyredirecturlafterlogoutori = get_option ( $bpmemonlyredirecturlafterlogout );
			if (! (empty ( $bpmemonlyredirecttypeafterlogoutori ))) {
				update_option ( $bpmemonlyredirecturlafterlogout_id, $bpmemonlyredirecturlafterlogoutori );
			}
			
			$bp_component_role_name = $tomas_roles_single_array ['name'];
			$bp_component_role_name = str_replace ( ' ', '-', $tomas_roles_single_array ['name'] );
			$rolebasedcustomizedcomponent = 'bpopenedcustomizedcomponent_' . $bp_component_role_name;
			
			$rolebasedcustomizedcomponent_id = 'bpopenedcustomizedcomponent_' . $tomas_roles_single_id;
			
		
			$rolebasedcustomizedcomponentori = get_option ( $rolebasedcustomizedcomponent );
			if (! (empty ( $rolebasedcustomizedcomponentori ))) {
				update_option ( $rolebasedcustomizedcomponent_id, $rolebasedcustomizedcomponentori );
				$bpmemonlyredirecttypeafterlogin_result = get_option ( $rolebasedcustomizedcomponent_id );
			}
			
			$rolebasedstandardcomponent = 'bpstandardcomponent_' . $bp_component_role_name;
			$rolebasedstandardcomponent_id = 'bpstandardcomponent_' . $tomas_roles_single_id;
			
			$rolebasedstandardcomponentori = get_option ( $rolebasedstandardcomponent );
			
			if (! (empty ( $rolebasedstandardcomponentori ))) {
				update_option ( $rolebasedstandardcomponent_id, $rolebasedstandardcomponentori );
				
				$bpmemonlyredirecttypeafterlogin_result = get_option ( $rolebasedstandardcomponent_id );
			}
		}
		
		update_option ( 'bpmocurrentversion', '3.1.4' );
	}
}

add_action('init', 'bpmo_upgrade_254');