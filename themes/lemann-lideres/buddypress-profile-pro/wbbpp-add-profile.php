<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$user_id      = get_current_user_id();
$bprm_rs_data = array();
$bprm_rs_data = get_user_meta( $user_id, 'wbbpp_userdata', true );
if ( isset( $_POST['bprm_save_resume'] ) && wp_verify_nonce( $_POST['save_bprm_resume'], 'bprm-resume' ) ) {
	if(isset($_FILES)){
		// These files need to be included as dependencies when on the front end.
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
		foreach ($_FILES as $data => $file_data_info) {
			foreach ($file_data_info['name'] as $group_name => $file_info) {
				foreach ($file_info as $key => $files_data) {
					foreach ($files_data as $field_key => $values) {
						foreach ($values as $_key => $_value) {
							$file = array(
								'name' => $file_data_info['name'][$group_name][$key][$field_key][$_key],
								'type' => $file_data_info['type'][$group_name][$key][$field_key][$_key],
								'tmp_name' => $file_data_info['tmp_name'][$group_name][$key][$field_key][$_key],
								'error' => $file_data_info['error'][$group_name][$key][$field_key][$_key],
								'size' => $file_data_info['size'][$group_name][$key][$field_key][$_key]
							);
							$_FILES = array ("my_image_upload" => $file);
							foreach ($_FILES as $file => $array) {
								$attach_id = media_handle_upload( $file, -1 );
								if ( !is_wp_error( $attach_id ) ) {
									$_POST['wbbpp_userdata'][$group_name][$key][$field_key][$_key] = $attach_id;
								}else{
									$_POST['wbbpp_userdata'][$group_name][$key][$field_key][$_key] = $bprm_rs_data[$group_name][$key][$field_key][$_key];
								}
							}
						}
					}
				}
			}
		}
	}
	$bprm_rs_post_data = $_POST['wbbpp_userdata'];
	$bprm_rs_post_data = bprs_array_filter_recursive( $bprm_rs_post_data );
	array_walk_recursive( $bprm_rs_post_data, 'bprm_sanitize_data' );
	update_user_meta( $user_id, 'wbbpp_userdata', $bprm_rs_post_data );
}
function bprs_array_filter_recursive( $input ) {
	foreach ( $input as &$value ) {
		if ( is_array( $value ) ) {
			$value = array_map(
				function( $v ) {
						$v = array_map( 'array_filter', $v );
						return $v;
				}, $value
			);
		}
	}
	return array_filter( $input );
}
function bprm_sanitize_data( &$item, $key ) {
	$item = sanitize_text_field( $item );
}
$bprm_rs_data = get_user_meta( $user_id, 'wbbpp_userdata', true );
if ( is_multisite() && is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
	$wbbpp_profile_fields_settings = get_site_option( 'wbbpp_profile_fields_settings' );
} else {
	$wbbpp_profile_fields_settings = get_option( 'wbbpp_profile_fields_settings' );
}
if ( is_array( $wbbpp_profile_fields_settings ) ) {
	foreach ( $wbbpp_profile_fields_settings as $key => $value ) {
		unset( $wbbpp_profile_fields_settings[ $key ]['bprm_identifier'] );
	}
}
function bprm_check_required( $bprm_settings, $field_name, $req_field ) {
	if ( array_key_exists( $field_name, $bprm_settings ) ) {
		if ( isset( $bprm_settings[ $field_name ] ) && $bprm_settings[ $field_name ] == 'yes' ) {
			echo '<p class="bprm-empty-error">';
			echo sprintf( __( '%s is required.', 'buddypress-profile-pro' ), $req_field );
			echo '</p>';
		}
	}
}
function bprm_add_required_mark( $bprm_settings, $field_value ) {
	if ( array_key_exists( $field_value, $bprm_settings ) ) {
		if ( isset( $bprm_settings[ $field_value ] ) && $bprm_settings[ $field_value ] == 'yes' ) {
			echo '*';
		}
	}
}
function bprm_add_required_cls( $bprm_settings, $field_value ) {
	if ( array_key_exists( $field_value, $bprm_settings ) ) {
		if ( isset( $bprm_settings[ $field_value ] ) && $bprm_settings[ $field_value ] == 'yes' ) {
			echo 'bprm_req_field';
		}
	}
}
if ( is_multisite() && is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
	$grp_args = get_site_option( 'wbbpp_profile_groups_settings' );
} else {
	$grp_args = get_option( 'wbbpp_profile_groups_settings' );
}

//$grp_args = bprm_existing_resume_groups();
if ( ! empty( $wbbpp_profile_fields_settings ) ) {
?>
<form action="" method="post" class="bprm_resume_form" id="bprm_resume_form" name="bprm_resume_form" enctype="multipart/form-data">

	<!-- ============================== Fieldset 1 ============================== -->
	<h2 class="bprm-form-headng"><?php _e( 'Editando os dados de Carreira', 'lemann-lideres' ); ?></h2>

	<?php if ( bp_profile_has_multiple_groups() ) : ?>
		<ul class="button-tabs button-nav">

			<?php bp_profile_group_tabs(); ?>

		</ul>
	<?php endif; ?>

<?php
foreach ( $wbbpp_profile_fields_settings as $grp_key => $fields ) {
	if( isset($grp_args[ $grp_key ]['profile_display']) ){
	$grp_name = $grp_args[ $grp_key ]['g_name'];
	if ( ! empty( $bprm_rs_data[$grp_key] ) ) {
		if ( $grp_key == 'bprm_grp_others' ) {
			foreach ( $bprm_rs_data[ $grp_key ] as $key3 => $value3 ) {
				foreach ( $fields as $field_name => $field_detail ) {
					if ( isset( $field_detail['display'] ) ) {
		?>

				<fieldset>
					<legend><?php echo $field_detail['section_title']; ?></legend>
					<div class="bprm-field-wrap bprm-<?php echo $field_name; ?>">
						<div class="bprm-field-label-wrap">
							<label for="input-one" class=""><?php echo $field_detail['field_tile']; ?><?php bprm_add_required_mark( $fields[ $field_name ], 'required' ); ?></label>
						</div>
						<div class="bprm-field-inputs-wrap">
						<?php
								$field_type = $field_detail['field_type']['type'];
						if ( $field_type ) {
								$resume_data = isset( $bprm_rs_data[ $grp_key ][ $key3 ][ $field_name ] ) ? $bprm_rs_data[ $grp_key ][ $key3 ][ $field_name ] : '';
								call_user_func( 'bprm_get_field_' . $field_type . '_html', $fields[ $field_name ], $field_name, $resume_data, $grp_key, $key3 );
						} // end if field type check
								?>
								</div>
								</div>
							</fieldset>
							<?php
					} // end if field display
				} //end foreach $fields
			} //end foreach $bprm_rs_data
		} else { // end if of check bprm others group
			?>
		<fieldset>
			<legend><?php echo $grp_name; ?></legend>
			<?php
				$repeater_grp = '';
				$reomve_grp   = '';
			if ( isset( $bprm_rs_data[ $grp_key ] ) ) {
				foreach ( $bprm_rs_data[ $grp_key ] as $key3 => $value3 ) {
					if ( isset($grp_args[$grp_key]['repeater']) || $grp_key == 'bprm_grp_edu' || $grp_key == 'bprm_grp_prof_exprnc' ) {
						if( 'yes' === $grp_args[$grp_key]['repeater'] ) {
							$repeater_grp = "<a href='javascript:void(0)' class='bprm_add_repeater_grp' data-gname='group-" . $grp_key . "' data-group='" . $grp_key . "' data-regrp='[" . $grp_key . '][' . $key3 . "]'>" . __( 'Add More ', 'buddypress-profile-pro' ) . $grp_name . '</a>';
							$reomve_grp   = "<div class='bprm_remove_repeater_grp_div'><a href='javascript:void(0)' class='bprm_remove_repeater_grp' data-gname='group-" . $grp_key . "' data-group='" . $grp_key . "' data-regrp='[" . $grp_key . '][' . $key3 . "]'><span><i class='fa fa-times-circle-o' aria-hidden='true'></i></span></a></div>";
						}
					} else {
						$repeater_grp = '';
						$reomve_grp   = '';
					}
				?>
			<div class="bprm-container group-<?php echo $grp_key; ?>">
					<?php
					echo $reomve_grp;
					foreach ( $fields as $field_name => $field_detail ) {
						if ( isset( $field_detail['display'] ) ) {
							?>

								<div class="bprm-field-wrap bprm-<?php echo $field_name; ?>">
									<div class="bprm-field-label-wrap">
										<label for="input-one" class=""><?php echo $field_detail['field_tile']; ?><?php bprm_add_required_mark( $fields[ $field_name ], 'required' ); ?></label>
									</div>
									<div class="bprm-field-inputs-wrap">
										<?php
										$field_type = $field_detail['field_type']['type'];
										if ( $field_type ) {
											$resume_data = isset( $bprm_rs_data[ $grp_key ][ $key3 ][ $field_name ] ) ? $bprm_rs_data[ $grp_key ][ $key3 ][ $field_name ] : '';
											call_user_func( 'bprm_get_field_' . $field_type . '_html', $fields[ $field_name ], $field_name, $resume_data, $grp_key, $key3 );
										} // end if field type check
									?>
								</div>
									</div>
								<?php
						} // end if field display
					} //end foreach $fields
			?>
			</div>
			<?php
				} // end foreach of bprm_resume_data
			} else {
					?>
						<div class="bprm-container group-<?php echo $grp_key; ?>">
					<?php
					echo $reomve_grp;
					foreach ( $fields as $field_name => $field_detail ) {
						if ( isset( $field_detail['display'] ) ) {
							?>

								<div class="bprm-field-wrap bprm-<?php echo $field_name; ?>">
									<div class="bprm-field-label-wrap">
										<label for="input-one" class=""><?php echo $field_detail['field_tile']; ?><?php bprm_add_required_mark( $fields[ $field_name ], 'required' ); ?></label>
									</div>
									<div class="bprm-field-inputs-wrap">
										<?php
										$field_type = $field_detail['field_type']['type'];
										if ( $field_type ) {
											$resume_data = isset( $bprm_rs_data[ $grp_key ][ $key3 ][ $field_name ] ) ? $bprm_rs_data[ $grp_key ][ $key3 ][ $field_name ] : '';
											call_user_func( 'bprm_get_field_' . $field_type . '_html', $fields[ $field_name ], $field_name, $resume_data, $grp_key, $key3 );
										} // end if field type check
									?>
								</div>
									</div>
								<?php
						} // end if field display
					} //end foreach $fields
			?>
			</div>
			<?php
			} // end if condition to check field grp is set
			echo $repeater_grp;
			?>
		</fieldset>
		<?php
		} //end listing groups except others
	} else { // condition start to list groups when resume data is empty
		$key3 = 0;
		if ( $grp_key == 'bprm_grp_others' ) {
			foreach ( $fields as $field_name => $field_detail ) {
				if ( isset( $field_detail['display'] ) ) {
				?>

				<fieldset>
					<legend><?php echo $field_detail['section_title']; ?></legend>
					<div class="bprm-field-wrap bprm-<?php echo $field_name; ?>">
						<div class="bprm-field-label-wrap">
							<label for="input-one" class=""><?php echo $field_detail['field_tile']; ?><?php bprm_add_required_mark( $fields[ $field_name ], 'required' ); ?></label>
						</div>
						<div class="bprm-field-inputs-wrap">
							<?php
							$field_type = $field_detail['field_type']['type'];
							if ( $field_type ) {
								$resume_data = isset( $bprm_rs_data[ $grp_key ][ $key3 ][ $field_name ] ) ? $bprm_rs_data[ $grp_key ][ $key3 ][ $field_name ] : '';
								call_user_func( 'bprm_get_field_' . $field_type . '_html', $fields[ $field_name ], $field_name, $resume_data, $grp_key, $key3 );
							} // end if field type check
							?>
						</div>
							</div>
						</fieldset>
						<?php
				} // end if field display
			} //end foreach $fields
		} else { // end if of check bprm others group
		?>
		<fieldset>
			<legend><?php echo $grp_name; ?></legend>
			<?php
				$repeater_grp = '';
				$reomve_grp   = '';
			if ( isset($grp_args[$grp_key]['repeater']) || $grp_key == 'bprm_grp_edu' || $grp_key == 'bprm_grp_prof_exprnc' ) {
				if( 'yes' === $grp_args[$grp_key]['repeater'] ) {
					$repeater_grp = "<a href='javascript:void(0)' class='bprm_add_repeater_grp' data-gname='group-" . $grp_key . "' data-group='" . $grp_key . "' data-regrp='[" . $grp_key . '][' . $key3 . "]'>" . __( 'Add More ', 'buddypress-profile-pro' ) . $grp_name . '</a>';
					$reomve_grp   = "<div class='bprm_remove_repeater_grp_div'><a href='javascript:void(0)' class='bprm_remove_repeater_grp' data-gname='group-" . $grp_key . "' data-group='" . $grp_key . "' data-regrp='[" . $grp_key . '][' . $key3 . "]'><span><i class='fa fa-times-circle-o' aria-hidden='true'></i></span></a></div>";
				}
			} else {
				$repeater_grp = '';
				$reomve_grp   = '';
			}
			?>
			<div class="bprm-container group-<?php echo $grp_key; ?>">
					<?php
					echo $reomve_grp;
					foreach ( $fields as $field_name => $field_detail ) {
						if ( isset( $field_detail['display'] ) ) {
							?>

								<div class="bprm-field-wrap bprm-<?php echo $field_name; ?>">
									<div class="bprm-field-label-wrap">
										<label for="input-one" class=""><?php echo $field_detail['field_tile']; ?><?php bprm_add_required_mark( $fields[ $field_name ], 'required' ); ?></label>
									</div>
									<div class="bprm-field-inputs-wrap">
										<?php
										$field_type = $field_detail['field_type']['type'];
										if ( $field_type ) {
											$resume_data = isset( $bprm_rs_data[ $grp_key ][ $key3 ][ $field_name ] ) ? $bprm_rs_data[ $grp_key ][ $key3 ][ $field_name ] : '';
											call_user_func( 'bprm_get_field_' . $field_type . '_html', $fields[ $field_name ], $field_name, $resume_data, $grp_key, $key3 );
										} // end if field type check
									?>
								</div>
									</div>
								<?php
						} // end if field display
					} //end foreach $fields
			?>
			</div>
			<?php
			echo $repeater_grp;
			?>
		</fieldset>
		<?php
		} //end listing groups except others
	} //end else condition to list groups when resume data is empty
	} //end check condition if display resume is set
}
		?>

	<?php wp_nonce_field( 'bprm-resume', 'save_bprm_resume' ); ?>
	<p><input class="submit-button" type="submit" alt="SUBMIT" name="bprm_save_resume" value="Salvar" id="bprm_save"/></p>
</form>
<?php } else { ?>
<div class="empty-resume-message">
<?php _e( 'Please set resume fields from plugin settings.', 'buddypress-profile-pro' ); ?>
</div>
<?php } ?>
