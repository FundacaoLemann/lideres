<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bprm_profile_render_field_type_html_for_resume( $field_type, $value_to_render, $field_name ) {
	$field_html = '';
	switch ( $field_type ) {
		case 'textbox':
			$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'><ul>";
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<li>".$_value."</li>";
				}
			}
			$field_html .= '</ul></td>';
			break;

		case 'email':
			$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'><ul>";
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<li><a href='mailto:" . $_value . "'>" . $_value . '</a></li>';
				}
			}
			$field_html .= '</ul></td>';
			break;

		case 'phone_number':
		$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'>";
			$lastElement = end($value_to_render);
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<a href='tel:" . $_value . "'>" . $_value . '</a>';
					if ($_value != $lastElement) {
        				$field_html .= ', ';
					}
				}
				
			}
		$field_html .= "</td>";	
			break;

		case 'url':
			$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'><ul>";
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<li><a href='" . $_value . "' target='blank'>" . $_value . "</a></li>";
				}
			}
			$field_html .= '</ul></td>';
			break;

		case 'textarea':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</td>';
				}
			}
			break;

		case 'dropdown':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</td>';
				}
			}
			break;

		case 'year_dropdown':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</td>';
				}
			}
			break;

		case 'text_dropdown':
			$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'><ul>";
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
			$field_html .= '</ul></td>';
			break;

		case 'place_autocomplete':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</td>';
				}
			}
			break;

		case 'calender_field':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</td>';
				}
			}
			break;

		case 'selectize':
			$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'><ul>";
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$_value = str_replace(","," | ",$_value);
					$field_html .= '<li>' . $_value . '</li>';
				}
			}
			$field_html .= '</ul></td>';
			break;

		case 'checkbox':
		$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'><ul>";
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<li>" . $_value . '</li>';
				}
			}
			$field_html .= '</ul></td>';
			break;

		case 'radio_button':
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'>" . $_value . '</td>';
				}
			}
			break;
		case 'image':
		$field_html .= "<td class='data fields-items " . $field_name . ' ' . $field_type . "'><ul class='bprm-profile-image-ul'>";
			foreach ( $value_to_render as $key => $value ) {
				if ( ! is_array( $value ) ) {
					$value = array( $value );
				}
				foreach ( $value as $_key => $_value ) {
					$image = wp_get_attachment_image_src( $_value, array('150','150'));
					$field_html .= "<li class='bprm-profile-image-li'><img class='fields-image " . $field_name . " " . $field_type . "' src=".$image[0]."></li>";
				}
			}
			$field_html .= '</ul></td>';
			break;
		default:
			$field_html = apply_filters( 'wbbpp_render_extra_field_type_content_cases', $field_type, $value_to_render, $field_name );
			break;
	}
	return $field_html;
}
