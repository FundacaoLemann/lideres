<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RTMediaOtherTypeSupport
 *
 * @author sanket
 */
class RTMediaOtherTypeSupport {

	var $thumbnail = 'app/assets/img/other-types-icon.png';
	var $no_preview_img = 'app/assets/img/nopreview.png';

	public function __construct() {
		add_filter( 'rtmedia_query_media_type_filter', array( $this, 'rtmedia_add_other_media_type' ), 10, 1 );

		// Creates slug for other type files
		if ( ! defined( 'RTMEDIA_OTHER_SLUG' ) ) {
			define( 'RTMEDIA_OTHER_SLUG', apply_filters( 'rtmedia_other_type_slug', 'other' ) );
		}

		add_filter( 'rtmedia_allowed_types', array( $this, 'add_other_allowed_types' ), 20, 1 );
		add_filter( 'rtmedia_single_content_filter', array( $this, 'rtmedia_other_content_filter' ), 10, 2 );
		add_filter( 'rtmedia_filter_featured_checkbox', array( $this, 'rtmedia_hide_featured_checkbox_for_other_types' ), 10, 2 );
		add_filter( 'rtmedia_filter_allow_upload_checkbox', array( $this, 'rtmedia_filter_allow_upload_for_other_types' ), 10, 3 );
		// add notice after the Media Type settings table
		add_filter( 'rtmedia_type_settings_filter_extension', array( $this, 'rtmedia_type_settings_filter_other_extension' ), 10, 2 );
		add_action( 'rtmedia_other_type_settings_textarea', array( $this, 'rtmedia_other_type_settings_textarea' ) );
		add_filter( 'rtmedia_single_activity_filter', array( $this, 'rtmedia_other_media_single_activity_filter' ), 10, 3 );
		//add_action( 'rtmedia_before_uploader', array( $this, 'rtmedia_after_uploader_message' ), 10 );
		add_filter( 'rtmedia_pro_options_save_settings', array( $this, 'rtmedia_other_files_save_other_extensions' ), 10, 1 );
	}

	/**
	 * Filter the extensions for Other file types before saving
	 * @params accepts the settings options to be saved
	 * @Returns the filtered settings options
	 */
	function rtmedia_other_files_save_other_extensions( $options ) {
		if ( isset( $options['rtmedia_other_file_extensions'] ) && '' != $options['rtmedia_other_file_extensions'] ) {
			$extensions = explode( ',', trim( $options['rtmedia_other_file_extensions'] ) );
			$new_extn = array();

			foreach ( $extensions as $extn ) {
				$extn = preg_replace( '/[^A-Za-z0-9]/', '', $extn );

				if ( $extn && $this->rtm_is_new_extension( $extn ) ) {
					$new_extn[] = $extn; }
			}

			if (  '' != $new_extn ) {
				$options['rtmedia_other_file_extensions'] = implode( ',', $new_extn );
			} else {
				$options['allowedTypes_other_enabled'] = 0; //disable the other media type
			}
		}

		return $options;
	}

	/**
	 * Checks if the provided extension already exists
	 * @params $extn to be checked
	 * @Returns boolean
	 */
	function rtm_is_new_extension( $extn ) {
		global $rtmedia;

		if ( isset( $rtmedia->allowed_types ) ) {
			foreach ( $rtmedia->allowed_types as $allowed_types ) {
				if ( isset( $allowed_types['name'] ) && 'other' != $allowed_types['name'] &&  '' != $allowed_types['extn'] && in_array( $extn, $allowed_types['extn'] ) ) {
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Displays a message before the uploader under the "Others" tab
	 * with list of new file extensions allowed for upload
	 */
	function rtmedia_after_uploader_message() {
		global $rtmedia_query, $rtmedia;

		if ( isset( $rtmedia_query->media_query['media_type'] ) && ! is_array( $rtmedia_query->media_query['media_type'] ) && 'other' == $rtmedia_query->media_query['media_type'] && isset( $rtmedia->options['allowedTypes_other_enabled'] ) && 1 == $rtmedia->options['allowedTypes_other_enabled'] ) {
			if ( isset( $rtmedia->options['rtmedia_other_file_extensions'] ) && '' != $rtmedia->options['rtmedia_other_file_extensions'] ) {
				echo '<p>' . __( 'You can also upload file with following formats : ', 'rtmedia' ) . str_replace( ',', ', ', $rtmedia->options['rtmedia_other_file_extensions'] ) . '</p>';
			}
		}
	}

	/**
	 *
	 * @param type $allow_upload_checkbox
	 * @param type $media_type
	 * @param string $args
	 * @return type
	 */
	function rtmedia_filter_allow_upload_for_other_types( $allow_upload_checkbox, $media_type, $args ) {
		if ( isset( $media_type ) && 'other' == $media_type ) {
			$args['class'] = array( 'rtm_allow_other_upload' ); // this class is used to disable the extension text-area in js
			$allow_upload_checkbox = RTMediaFormHandler::checkbox( $args, $echo = false );
		}

		return $allow_upload_checkbox;
	}

	/**
	 * Function to filter the markup for the extensions and show a textarea
	 * for user to enter the required extensions for the other media types.
	 *
	 * @params accepts the current media type
	 * @params accepts the current markup for the extensions
	 * @Returns the filtered markeup
	 */
	function rtmedia_type_settings_filter_other_extension( $extensions, $media_type ) {
		if ( isset( $media_type ) && 'other' == $media_type ) {
			global $rtmedia;

			$value = '';

			if ( isset( $rtmedia->options['rtmedia_other_file_extensions'] ) && '' != $rtmedia->options['rtmedia_other_file_extensions'] && '0' != $rtmedia->options['rtmedia_other_file_extensions'] ) {
				$value = $rtmedia->options['rtmedia_other_file_extensions'];
			}

			$args = array(
				'id'	=> 'rtm_other_extensions',
				'key'	=> 'rtmedia_other_file_extensions',
				'value'	=> $value,

			);
			$extensions = RTMediaFormHandler::textarea( $args, $echo = false ) . ' <span class="rtm-tooltip"><i class="dashicons dashicons-info rtmicon"></i><span class="rtm-tip">' . __( 'Provide comma seperated values for other file types. Allowing other file types for upload could be dangerous.', 'rtmedia' ) . '</span></span>';
		}

		return $extensions;
	}

	/**
	 * Creates textarea field for Other type extantion input
	 * @global type $rtmedia
	 * @param type $media_type	media object
	 */
	public function rtmedia_other_type_settings_textarea( $media_type ) {
		global $rtmedia;

		if ( isset( $media_type ) && 'other' == $media_type  ) {
			?>
			<tr data-depends="allowedTypes_other_enabled">
				<th>
					<?php echo __( 'File Extensions', 'rtmedia' ); ?>
					<span class="rtm-tooltip rtm-extensions rtm-set-top">
						<i class="dashicons dashicons-info rtmicon"></i>
						<span class="rtm-tip"><?php _e( 'Provide comma seperated values for other file types. Allowing other file types for upload could be dangerous.', 'rtmedia' ); ?></span>
					</span>
				</th>
				<td colspan="4">
					<?php
					$value = '';

					if ( isset( $rtmedia->options['rtmedia_other_file_extensions'] ) && '' != $rtmedia->options['rtmedia_other_file_extensions'] && '0' != $rtmedia->options['rtmedia_other_file_extensions'] ) {
						$value = $rtmedia->options['rtmedia_other_file_extensions'];
					}

					$args = array(
						'id' => 'rtm_other_extensions',
						'key' => 'rtmedia_other_file_extensions',
						'value' => $value,
						'desc'	=> 'For "example.tar.gz" add "gz" OR for "example.zip" add "zip".',
						'show_desc' => true,
					);

					$extensions = RTMediaFormHandler::textarea( $args, $echo = false );

					echo $extensions;
					?>
				</td>
			</tr>
			<?php
		}
	}

	/**
	 * Function to hide the "Featured" enable/disable button for the Other media type
	 * @params accepts the current "featured checkbox" markup
	 * @params accepts the current "media type"
	 * @Returns the filtered "Featured" button markup if media type is "Other"
	 */
	function rtmedia_hide_featured_checkbox_for_other_types( $featured_checkbox, $media_type ) {
		if ( isset( $media_type ) && 'other' == $media_type ) {
			$featured_checkbox = '--' . '<input type="hidden" name="rtmedia-options[allowedTypes_other_featured]" value="0" />';
		}

		return $featured_checkbox;
	}

	/**
	 * Function to filter the Single Media Content for the Document media type
	 * @params accepts the current html markup of single media
	 * @params accepts the rtmedia_media object
	 * @Returns the filtered markup for the single medias
	 */
	function rtmedia_other_content_filter( $html, $rtmedia_media ) {
		if ( is_rtm_other_file_type() ) {
			$html = '<img src="' . RTMEDIA_OTHER_FILES_URL . $this->no_preview_img . '" alt="' . __( 'No preview available', 'rtmedia' ) . '" />';
		}

		return $html;
	}

	/**
	 * Function to add Other media type into the media query.
	 * @params accepts the array of current media types
	 * @Returns the filtered media_type array
	 */
	function rtmedia_add_other_media_type( $media_type ) {
		if ( isset( $media_type['value'] ) && '' != $media_type['value'] ) {
			$media_type['value'][] = 'other';
		}

		return $media_type;
	}

	/**
	 * filters the allowed media types and adds "documents" as allowed media type.
	 * @params $allowed_types  accepts the array of currently allowed media types
	 */
	function add_other_allowed_types( $allowed_types ) {
		global $rtmedia;

		$extensions = array( '' );

		if ( isset( $rtmedia->options['rtmedia_other_file_extensions'] ) && '' != $rtmedia->options['rtmedia_other_file_extensions'] ) {
			$extensions = explode( ',', $rtmedia->options['rtmedia_other_file_extensions'] );
		}

		$other_type = array(
			'other' => array(
				'name' => 'other',
				'plural' => 'others',
				'label' => __( 'Other', 'rtmedia' ),
				'plural_label' => __( 'Others', 'rtmedia' ),
				'extn' => $extensions,
				'thumbnail' => RTMEDIA_OTHER_FILES_URL . $this->thumbnail,
				'settings_visibility' => true,
			),
		);

		if ( ! defined( 'RTMEDIA_OTHER_PLURAL_LABEL' ) ) {
			define( 'RTMEDIA_OTHER_PLURAL_LABEL', $other_type['other']['plural_label'] );
		}

		if ( ! defined( 'RTMEDIA_OTHER_LABEL' ) ) {
			define( 'RTMEDIA_OTHER_LABEL', $other_type['other']['label'] );
		}

		$allowed_types = array_merge( $allowed_types, $other_type );

		return $allowed_types;
	}

	/**
	 * Filters the single media content for the activity
	 * @param type $html	html render content
	 * @param type $media	media object
	 * @param type $status
	 * @return string $html html content to be render
	 */
	function rtmedia_other_media_single_activity_filter( $html, $media, $status ) {
		if ( isset( $media->media_type ) && 'other' == $media->media_type ) {
			$html = '<a href="' . get_rtmedia_permalink( $media->id ) . '">';
			// use rtmedia_image function for image src
			$src = rtmedia_image( 'rt_media_activity_image', $media->id, false );
			$html .= '<img src="' . $src . '"  class="rtmedia-other-files-activity-thumbnail"  />';
			$html .= '</a>';
		}

		return $html;
	}
}
