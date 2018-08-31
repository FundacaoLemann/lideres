<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bprm_render_field_type_html_for_resume( $field_type, $value_to_render, $field_name ) {
	$field_html = '';
	switch ( $field_type ) {
		case 'textbox':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</div>';
				}
			}
			break;

		case 'email':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'><a href='mailto:" . $_value . "'>" . $_value . '</a></div>';
				}
			}
			break;

		case 'phone_number':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'><a href='tel:" . $_value . "'>" . $_value . '</a></div>';
				}
			}
			break;

		case 'url':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'><a href='" . $_value . "' target='blank'>" . $_value . '</a></div>';
				}
			}
			break;

		case 'textarea':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</div>';
				}
			}
			break;

		case 'dropdown':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</div>';
				}
			}
			break;

		case 'year_dropdown':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</div>';
				}
			}
			break;

		case 'text_dropdown':
			$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'><ul>";
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				if ( is_numeric( $value['dropdown_val'] ) ) {
					if ( ! empty( $value['text'] ) ) {
						$field_html .= '<li>' . $value['text'] . "
										<div class='level-bar'>
											<div class='level-bar-inner' data-level='" . $value['dropdown_val'] . "'></div>
										</div>
									</li>";
					}
				} else {
					if ( ! empty( $value['text'] ) ) {
						$field_html .= '<li>' . $value['text'] . "&nbsp;&nbsp<span class='text-desc'>(" . $value['dropdown_val'] . ')</span></li>';
					}
				}
			}
			$field_html .= '</ul></div>';
			break;

		case 'place_autocomplete':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</div>';
				}
			}
			break;

		case 'calender_field':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</div>';
				}
			}
			break;

		case 'selectize':
			$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'><ul>";
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$selectize_val = explode( ',', $_value );

					foreach ( $selectize_val as $key => $value ) {
						$field_html .= '<li>' . $value . '</li>';
					}
				}
			}
			$field_html .= '</ul></div>';
			break;

		case 'checkbox':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</div>';
				}
			}
			break;

		case 'radio_button':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<div class='fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</div>';
				}
			}
			break;
		case 'image':
			$field_html .='<div class="bprm-resume-image-container">';
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$image = wp_get_attachment_image_src( $_value, array('150','150'));
					$field_html .= "<div class='bprm-resume-image fields-items " . $field_name . " " . $field_type . "'><img class='fields-image " . $field_name . " " . $field_type . "' src=".$image[0]."></div>";
				}
			}
			$field_html .='</div>';
			break;	

		default:
			$field_html = apply_filters( 'wbbpp_render_extra_field_type_content', $field_type, $value_to_render, $field_name );
			break;
	}
	return $field_html;
}
