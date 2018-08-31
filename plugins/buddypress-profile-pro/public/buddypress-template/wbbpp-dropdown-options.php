<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bprm_year_list( $edu_yoc ) {
	echo '<option value="">Select Year</option>';
	$current_year = date( 'Y' );
	for ( $i = $current_year;$i >= 1917;$i-- ) {
		if ( $i == $edu_yoc ) {
			$selected = 'selected';
		} else {
			$selected = '';
		}
		echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
	}
}

function bprm_month_list( $from_month ) {
	for ( $i = 1;$i <= 12;$i++ ) {
		if ( $i == $from_month ) {
			$selected = 'selected';
		} else {
			$selected = '';
		}
		echo '<option value="' . date( 'm', mktime( 0, 0, 0, $i ) ) . '" ' . $selected . '>' . date( 'F', mktime( 0, 0, 0, $i ) ) . '</option>';
	}
}

/*
 *
 * Function to  render textbox field html.
 */
function bprm_get_field_textbox_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key => $value ) {
				?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
					<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key; ?>]" type="text" value="<?php if ( ! is_array( $value ) ) {echo $value;}?>" size="30" />
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
			<div class="field-<?php echo $field_name; ?> bprm-field-contain">
				<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="text" value="" size="30" />
				<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
				<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
			</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="field-<?php echo $field_name; ?> bprm-field-contain">
			<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="text" value="<?php if ( isset( $resume_data[0] ) ) {echo $resume_data[0];}?>" size="30" />
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
		</div>
		<?php
	}
	// bprm_check_required( $fields, 'required', $fields['field_tile'] );
}

/*
 *
 * Function to  render email field html.
 */
function bprm_get_field_email_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key => $value ) {
				?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
					<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key; ?>]" type="email" value="<?php if ( ! is_array( $value ) ) {echo $value;}?>" size="30" />
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
			<div class="field-<?php echo $field_name; ?> bprm-field-contain">
				<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="email" value="" size="30" />
				<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
				<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
			</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="field-<?php echo $field_name; ?> bprm-field-contain">
			<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="email" value="<?php if ( isset( $resume_data[0] ) ) { echo $resume_data[0]; }?>" size="30" />
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
		</div>
		<?php
	}
	// bprm_check_required( $fields, 'required', $fields['field_tile'] );
}

/*
 *
 * Function to  render url field html.
 */
function bprm_get_field_url_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key => $value ) {
				?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
					<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key; ?>]" type="url" value="<?php if ( ! is_array( $value ) ) {echo $value;}?>" size="30" />
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
			<div class="field-<?php echo $field_name; ?> bprm-field-contain">
				<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="url" value="" size="30" />
				<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
				<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
			</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="field-<?php echo $field_name; ?> bprm-field-contain">
			<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="url" value="<?php if ( isset( $resume_data[0] ) ) {echo $resume_data[0];}?>" size="30" />
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
		</div>
		<?php
	}
	// bprm_check_required( $fields, 'required', $fields['field_tile'] );
}

/*
 *
 * Function to  render phone number field html.
 */
function bprm_get_field_phone_number_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key => $value ) {
				?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
					<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key; ?>]" type="tel" value="<?php if ( ! is_array( $value ) ) { echo $value;}?>" size="30" />
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
			<div class="field-<?php echo $field_name; ?> bprm-field-contain">
				<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="tel" value="" size="30" />
				<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
				<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
			</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="field-<?php echo $field_name; ?> bprm-field-contain">
			<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="tel" value="<?php if ( isset( $resume_data[0] ) ) {echo $resume_data[0];}?>" size="30" />
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
		</div>
		<?php
	}
	// bprm_check_required( $fields, 'required', $fields['field_tile'] );
}

/*
 *
 * Function to  render textarea field html.
 */
function bprm_get_field_textarea_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key => $value ) {
				?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
					<textarea name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key; ?>]" cols="30" rows="2" class="<?php bprm_add_required_cls( $fields, 'required' ); ?>"><?php echo $value; ?></textarea>
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
			<div class="field-<?php echo $field_name; ?> bprm-field-contain">
				<textarea name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" cols="30" rows="2" class="<?php bprm_add_required_cls( $fields, 'required' ); ?>"></textarea>
				<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
				<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
			</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="field-<?php echo $field_name; ?> bprm-field-contain">
			<textarea name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" cols="30" rows="2" class="<?php bprm_add_required_cls( $fields, 'required' ); ?>"><?php if ( isset( $resume_data[0] ) ) {echo $resume_data[0];}?>
			</textarea>
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
		</div>
		<?php
	}
	// bprm_check_required( $fields, 'required', $fields['field_tile'] );
}

/*
 *
 * Function to  render dropdown field html.
 */
function bprm_get_field_dropdown_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key1 => $value1 ) {
				?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
					<select name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key1; ?>]" class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>">
					<option value=''><?php _e( 'Select', 'buddypress-profile-pro' ); ?></option>
				<?php
				foreach ( $fields['field_type']['options'] as $key => $value ) {
					if ( $value == $resume_data[ $key1 ] ) {
						$selected = 'selected';
					} else {
						$selected = '';
					}
					?>
					<option value='<?php echo $value; ?>' <?php echo $selected; ?> ><?php echo $value; ?></option>
					<?php
				}
				?>
					</select>
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
					<select name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>">
						<option value=''><?php _e( 'Select', 'buddypress-profile-pro' ); ?></option>
						<?php
						foreach ( $fields['field_type']['options'] as $key => $value ) {
							?>
							<option value='<?php echo $value; ?>'><?php echo $value; ?></option>
							<?php
						}
						?>
					</select>
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="field-<?php echo $field_name; ?> bprm-field-contain">
			<select name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>">
				<option value=''><?php _e( 'Select', 'buddypress-profile-pro' ); ?></option>
				<?php
				foreach ( $fields['field_type']['options'] as $key => $value ) {
					if ( $value == $resume_data[0] ) {
						$selected = 'selected';
					} else {
						$selected = '';
					}
					?>
				<option value='<?php echo $value; ?>' <?php echo $selected; ?> ><?php echo $value; ?></option>
					<?php } ?>
			</select>
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
		</div>
		<?php
	}
	// bprm_check_required( $fields, 'required', $fields['field_tile'] );
}

/*
 *
 * Function to  render checkbox field html.
 */
function bprm_get_field_checkbox_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key1 => $value1 ) {
				echo '<div class="bprm-field-contain field-' . $field_name . '">';
				foreach ( $fields['field_type']['options'] as $key => $value ) {
					if ( is_array( $resume_data[ $key1 ] ) && in_array( $value, $resume_data[ $key1 ] ) ) {
						$checked = 'checked';
					} else {
						$checked = '';
					}
					?>
					<div class="bprm-checkbox-field"><input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); echo $field_name;?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key1; ?>][]" type="checkbox" value="<?php echo $value; ?>" size="30" <?php echo $checked; ?> /><span><?php echo $value; ?></span></div>
					<?php
				}
				?>
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			echo '<div class="bprm-field-contain field-' . $field_name . '">';
			foreach ( $fields['field_type']['options'] as $key => $value ) {
				?>
				<input class="inp-text<?php bprm_add_required_cls( $fields, 'required' ); echo $field_name;?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0][]" type="checkbox" value="<?php echo $value; ?>" size="30"/><?php echo $value; ?>
					<?php
			}
				?>
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="field-<?php echo $field_name; ?> bprm-field-contain">
		<?php
		foreach ( $fields['field_type']['options'] as $key => $value ) {
			if ( ! empty( $resume_data ) && is_array( $resume_data[0] ) && in_array( $value, $resume_data[0] ) ) {
				$checked = 'checked';
			} else {
				$checked = '';
			}
			?>
				<div class="bprm-checkbox-field">
					<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); echo $field_name; ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0][]" type="checkbox" value="<?php echo $value; ?>" size="30" <?php echo $checked; ?>/><span><?php echo $value; ?></span>
				</div>
					<?php
					bprm_check_required( $fields, 'required', $fields['field_tile'] );
		}
		?>
		</div>
		<?php

	}
	// bprm_check_required( $fields, 'required', $fields['field_tile'] );
}

/*
 *
 * Function to  render selectize field html.
 */
function bprm_get_field_selectize_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key => $value ) {
				?>
				<div class="bprm_intrst field-<?php echo $field_name; ?> bprm-field-contain">
					<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key; ?>]" type="text" size="30" value="<?php if ( isset( $resume_data[ $key ] ) && ! is_array( $resume_data[ $key ] ) ) { echo $resume_data[ $key ];}?>" />
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
			<div class="bprm_intrst field-<?php echo $field_name; ?> bprm-field-contain">
				<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="text" size="30" value="" />
				<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
				<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
			</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a id="selectize-html" href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="bprm_intrst field-<?php echo $field_name; ?> bprm-field-contain">
			<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="text" size="30" value="<?php if ( isset( $resume_data[0] ) && ! is_array( $resume_data[0] ) ) { echo $resume_data[0];}?>" />
		<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
		</div>
		<?php
	}
	// bprm_check_required( $fields, 'required', $fields['field_tile'] );
}

/*
 *
 * Function to  render radio button field html.
 */
function bprm_get_field_radio_button_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key1 => $value1 ) {
				?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
				<?php
				foreach ( $fields['field_type']['options'] as $key => $value ) {
					if ( $value == $resume_data[ $key1 ] ) {
						$checked = 'checked';
					} else {
						$checked = '';
					}
					?>
					<div class="bprm-radio-field"><input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key1; ?>]" type="radio" value="<?php echo $value; ?>" size="30" <?php echo $checked; ?> /><span><?php echo $value; ?></span></div>
					<?php
				}
				?>
				  <span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
						<?php
						foreach ( $fields['field_type']['options'] as $key => $value ) {
							?>
							<div class="bprm-radio-field"><input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="radio" value="<?php echo $value; ?>" size="30" /><span><?php echo $value; ?></span></div>
							<?php
						}
						?>

					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="field-<?php echo $field_name; ?> bprm-field-contain">
			<?php
			foreach ( $fields['field_type']['options'] as $key => $value ) {
				if ( ! empty( $resume_data ) && is_array( $resume_data[0] ) && in_array( $value, $resume_data[0] ) ) {
					$checked = 'checked';
				} else {
					$checked = '';
				}
				?>
				<div class="bprm-radio-field">
					<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="radio" value="<?php echo $value; ?>" size="30" <?php echo $checked; ?> /><span><?php echo $value; ?></span>
				</div>
			<?php } ?>
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
			</div>
		<?php
	}
	// bprm_check_required( $fields, 'required', $fields['field_tile'] );
}

/*
 *
 * Function to  render year dropdown html fields.
 */
function bprm_get_field_year_dropdown_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key1 => $value1 ) {
				?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
					<select name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>">
				<?php
					bprm_year_list( $resume_data[ $key1 ] );
				?>
					</select>
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
					<select name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>">
						<?php
							$year_value = '';
							bprm_year_list( $year_value );
						?>
					</select>
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="field-<?php echo $field_name; ?> bprm-field-contain">
			<select name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>">
				<?php
					$year_value = isset( $resume_data[0] ) ? $resume_data[0] : '';

					bprm_year_list( $year_value );
				?>
			</select>
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
		</div>
		<?php
	}
}

/*
 *
 * Function to  render text and dropdown combination html fields.
 */
function bprm_get_field_text_dropdown_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key1 => $value1 ) {
				?>
				<div class="text-dropdown field-<?php echo $field_name; ?> bprm-field-contain">
					<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key1; ?>][text]" type="text" value="<?php echo isset( $resume_data[ $key1 ]['text'] ) ? $resume_data[ $key1 ]['text'] : ''; ?>" size="30" />
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
					<select name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key1; ?>][dropdown_val]" class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>">
						<option value=''><?php _e( 'Select', 'buddypress-profile-pro' ); ?></option>
				<?php
				foreach ( $fields['field_type']['options'] as $key => $value ) {
					if ( $value == $resume_data[ $key1 ]['dropdown_val'] ) {
						$selected = 'selected';
					} else {
						$selected = '';
					}
					?>
					<option value='<?php echo $value; ?>' <?php echo $selected; ?> ><?php echo $value; ?></option>
					<?php
				}
				?>
					</select>
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
				<div class="text-dropdown field-<?php echo $field_name; ?> bprm-field-contain">
					<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0][text]" type="text" value="<?php echo isset( $resume_data[0]['text'] ) ? $resume_data[0]['text'] : ''; ?>" size="30" />
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
					<select name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0][dropdown_val]" class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>">
						<option value=''><?php _e( 'Select', 'buddypress-profile-pro' ); ?></option>
						<?php
						foreach ( $fields['field_type']['options'] as $key => $value ) {
							?>
							<option value='<?php echo $value; ?>'><?php echo $value; ?></option>
							<?php
						}
						?>
					</select>
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="text-dropdown field-<?php echo $field_name; ?> bprm-field-contain">
			<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0][text]" type="text" value="<?php echo isset( $resume_data[0]['text'] ) ? $resume_data[0]['text'] : ''; ?>" size="30" />
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
			<select name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0][dropdown_val]" class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>">
				<option value=''><?php _e( 'Select', 'buddypress-profile-pro' ); ?></option>
				<?php
				foreach ( $fields['field_type']['options'] as $key => $value ) {
					if ( $value == $resume_data[0]['dropdown_val'] ) {
						$selected = 'selected';
					} else {
						$selected = '';
					}
					?>
				<option value='<?php echo $value; ?>' <?php echo $selected; ?> ><?php echo $value; ?></option>
					<?php } ?>
			</select>
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
		</div>
		<?php
	}
}

/*
 *
 * Function to render google autocomplete field type.
 */
function bprm_get_field_place_autocomplete_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key => $value ) {
				?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain bprm-auto-complete">
					<input id="bprm-wautocomplete-<?php echo rand(); ?>" class="bprm-wautocomplete inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key; ?>]" type="text" value="<?php echo $value; ?>" size="30" />
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
			<div class="field-<?php echo $field_name; ?> bprm-field-contain bprm-auto-complete">
				<input id="bprm-wautocomplete-<?php echo rand(); ?>" class="bprm-wautocomplete inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="text" value="" size="30" />
				<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
				<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
			</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="field-<?php echo $field_name; ?> bprm-field-contain bprm-auto-complete">
			<input id="bprm-wautocomplete-<?php echo rand(); ?>" class="bprm-wautocomplete inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="text" value="<?php if ( isset( $resume_data[0] ) ) {echo $resume_data[0];}?>" size="30" />
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
		</div>
		<?php
	}
}

/*
 *
 * Function to  render calender field html.
 */
function bprm_get_field_calender_field_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key => $value ) {
				?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
					<input class="bprm-calender inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key; ?>]" type="text" value="<?php echo $value; ?>" size="30" />
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
			<div class="field-<?php echo $field_name; ?> bprm-field-contain">
				<input class="bprm-calender inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="text" value="" size="30" />
				<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
				<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
			</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		?>
		<div class="field-<?php echo $field_name; ?> bprm-field-contain">
			<input class="bprm-calender inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="text" value="<?php if ( isset( $resume_data[0] ) ) {echo $resume_data[0];}?>" size="30" />
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
		</div>
		<?php
	}
}

/*
 *
 * Function to  render textbox field html.
 */
function bprm_get_field_image_html( $fields, $field_name, $resume_data, $grp_key, $key3 ) {
	if ( isset( $fields['repeater'] ) ) {
		$add_more_text = 'Add More ' . $fields['field_tile'];
		if ( ! empty( $resume_data ) && is_array( $resume_data ) ) {
			foreach ( $resume_data as $key => $value ) {
				$image = wp_get_attachment_image_src( $value, array('150','150'));
				?>
				<div class="field-<?php echo $field_name; ?> bprm-field-contain">
					<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][<?php echo $key; ?>]" type="file" value="<?php if ( ! is_array( $value ) ) {echo $value;}?>" size="30" />
					<span class="bprm-image-type-span"><img class="fields-image bprm-resume-form-image" src="<?php echo $image[0] ?>"></span>
					<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
					<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
				</div>
				<?php
			}
		} else {
			?>
			<div class="field-<?php echo $field_name; ?> bprm-field-contain">
				<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="file" value="" size="30" />
				<span class="bprm-remove-repeater-field" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]"><i class="fa fa-times" aria-hidden="true"></i></span>
				<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
			</div>
			<?php
		}
		?>
			<div class="bprm-repeater-link"><a href="javascript:void(0)" data-id="field-<?php echo $field_name; ?>" data-fname="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>]" class="bprm-add-repeater-field"><?php echo $add_more_text; ?></a></div>
		<?php
	} else {
		if ( isset( $resume_data[0] ) ){
			$single_image = wp_get_attachment_image_src( $resume_data[0], array('150','150'));	
		}
		
		?>
		<div class="field-<?php echo $field_name; ?> bprm-field-contain">
			<input class="inp-text <?php bprm_add_required_cls( $fields, 'required' ); ?>" name="wbbpp_userdata[<?php echo $grp_key; ?>][<?php echo $key3; ?>][<?php echo $field_name; ?>][0]" type="file" value="<?php if ( isset( $resume_data[0] ) ) {echo $resume_data[0];}?>" size="30" />
			<?php if(isset( $resume_data[0])){ ?>
			<span class="bprm-image-type-span"><img class="fields-image bprm-resume-form-image" src="<?php echo $single_image[0]; ?>"></span>
			<?php } ?>
			<?php bprm_check_required( $fields, 'required', $fields['field_tile'] ); ?>
		</div>
		<?php
	}
	// bprm_check_required( $fields, 'required', $fields['field_tile'] );
}

/*
 *
 * Function to return field values with respect to field name.
 */
function wbbpp_get_field_values( $field_name ){
	$field_values = array();
	$user_id      = get_current_user_id();
	$bprm_rs_data = array();
	$bprm_rs_data = get_user_meta( $user_id, 'wbbpp_userdata', true );
	if ( ! empty( $bprm_rs_data ) && is_array( $bprm_rs_data ) ) {
		foreach ($bprm_rs_data as $grp_key => $grp_value) {
			foreach ($grp_value as $_key => $_value) {
				if( isset( $_value[$field_name] ) ){
					$field_values[] = $_value[$field_name];
				}
			}
		}
	}
	return $field_values;
}

/*
 *
 * Function to return group values with respect to field name.
 */
function wbbpp_get_group_values( $group_name ){
	$group_values = array();
	$user_id      = get_current_user_id();
	$bprm_rs_data = array();
	$bprm_rs_data = get_user_meta( $user_id, 'wbbpp_userdata', true );
	if ( ! empty( $bprm_rs_data ) && is_array( $bprm_rs_data ) ) {
		if( isset( $bprm_rs_data[$group_name] ) ){
			$group_values = $bprm_rs_data[$group_name];
		}
	}
	return $group_values;
}

/*
 *
 * Function to return field visibility level.
 */
function wbbpp_get_field_visibility_level( $field_name ){

	global $bp;

	$field_visibility = true;

	$visib_mode = wbbpp_get_admin_fields_visibility_mode();

	if( $visib_mode ){

		$friend_status = friends_check_friendship_status( $bp->loggedin_user->id, $bp->displayed_user->id );

		$wbbpp_visibility = get_user_meta( $bp->displayed_user->id, 'wbbpp_visibility', true );

		if( is_array( $wbbpp_visibility ) && isset( $wbbpp_visibility[ $field_name ] ) ){
			$visibility = $wbbpp_visibility[ $field_name ];
		}else{
			$visibility = 'public';
		}
		
		
		switch ($visibility) {
			case 'public':
				$field_visibility = true;								
			break;
			case 'adminsonly':
				if( !bp_is_my_profile() ){
					$field_visibility = false;
				}								
			break;
			case 'loggedin':
				if( !is_user_logged_in() ){
					$field_visibility = false;
				}								
			break;
			case 'friends':
				if ( $friend_status == 'is_friend' || $bp->loggedin_user->id == $bp->displayed_user->id ) {
					$field_visibility = true;
				}else{
					$field_visibility = false;
				}									
			break;
			default:
				$field_visibility = true;								
			break;
		}

	}

	return $field_visibility = apply_filters( 'wbbpp_field_visibility_filter', $field_visibility, $field_name );
}

/*
 *
 * Function to get admin fields visibility mode.
 */
function wbbpp_get_admin_fields_visibility_mode() {

	$wbbpp_general_settings = get_option( 'wbbpp_general_settings' );
	$visib_mode = false;

	if( isset( $wbbpp_general_settings['fld_visib_stngs'] ) ){
		$visib_mode = true;
	}

	return $visib_mode = apply_filters( 'wbbpp_admin_field_visibility_mode', $visib_mode );
}
