<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RTMediaMemberGalleryWidget
 *
 * @author sanket
 */

class RTMediaGalleryWidget extends WP_Widget {
	var $rtmedia_wd_time = '';

	function __construct() {
		$widget_ops = array(
			'classname' => 'RTMediaGalleryWidget',
			'description' => __( 'rtMedia Gallery widget', 'rtmedia' ),
		);

		parent::__construct( 'RTMediaGalleryWidget', __( 'rtMedia Gallery Widget', 'rtmedia' ), $widget_ops );
	}

	/**
	 *  Set time duration in where clause for sidebar gallery widget
	 * @global type $wpdb
	 * @param type $where
	 * @param type $table_name
	 * @return type
	 */
	function where_query_wdtime( $where, $table_name ) {
		global $wpdb;

		$join_table = $wpdb->posts;
		$end_time = 'tomorrow';
		$all_flag = false;

		switch ( $this->rtmedia_wd_time ) {
			case 'today':
				$start_time = 'yesterday';

				break;
			case 'this_week':
				$start_time = 'sunday last week';

				break;
			case 'this_month':
				$start_time = 'last day of last month';

				break;
			default:
				$all_flag = true;

				break;
		}

		if ( ! $all_flag ) {
			$lastMonth = strtotime( 'last month' );
			$start_date = date( 'Y-m-d', strtotime( $start_time ) );
			$start_date .= ' 23:59:59';
			$end_date = date( 'Y-m-d', strtotime( $end_time ) );
			$end_date .= ' 00:00:00';
			$where .= " AND ( {$table_name}.upload_date > '$start_date' and {$table_name}.upload_date < '$end_date' ) ";

			return $where;
		}

		return $where;
	}

	/**
	 * Getting meta_value and meta_key for view count
	 * @param string $select
	 * @param string $table_name
	 * @return string
	 */
	function rtmedia_select_query_view_count_column( $select, $table_name ) {
		$rtmedia_meta = new RTMediaInteractionModel();
		// table name
		$select_table = $rtmedia_meta->table_name;

		return $select . ', ' . $select_table . '.action, ' . 'count( ' . $select_table . '.value) as vcw_media_view_count ';
	}

	/**
	 *  Setting order for views
	 */
	function rtmedia_select_query_view_count_order( $orderby, $table_name ) {
		$orderby = ' ORDER BY vcw_media_view_count DESC ';

		return $orderby;
	}

	/**
	 * @param $group_by
	 * @param $table_name
	 */
	function rtmedia_select_query_view_count_group( $group_by, $table_name ) {
		$rtmedia_meta = new RTMediaInteractionModel();
		// table name
		$select_table = $rtmedia_meta->table_name;
		$group_by = " GROUP BY {$select_table}.media_id ";
		return $group_by;
	}

	/**
	 *  Function for join query with rtmedia_interaction table to get view count
	 */
	function join_query_rtmedia_interaction_view_count( $join, $table_name ) {
		$rtmedia_meta = new RTMediaInteractionModel();
		$join_table = $rtmedia_meta->table_name;
		$join_type = apply_filters( 'rtm_sidebar_widget_most_view_join_type', 'INNER' );
		$join .= " {$join_type} JOIN {$join_table} ON ( {$join_table}.media_id = {$table_name}.id AND ( {$join_table}.action = 'view' ) ) ";

		return $join;
	}

	/**
	 * render the gallery widget
	 * @param type $args
	 * @param type $instance
	 */
	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		$wdType = isset( $instance['wdType'] ) ? esc_attr( $instance['wdType'] ) : 'recent';
		$wdTime = isset( $instance['wdTime'] ) ? esc_attr( $instance['wdTime'] ) : 'all';

		if ( 'all' != $wdTime ) {
			$default_title = ucfirst( str_replace( '_', ' ', $wdTime ) ) . "'s  " . ucfirst( str_replace( '_', ' ', $wdType ) );
		} else {
			$default_title = ucfirst( str_replace( '_', ' ', $wdType ) );
		}

		$title = apply_filters( 'widget_title', $instance['title'] ); // Removed default title when left blank
		$allow = rtm_gallery_widget_allow_type( $instance );

		$allowed = $allow;

		$allow_most_rated_album = false;
		if ( isset( $instance['allow_most_rated_album'] ) && true === (bool) $instance['allow_most_rated_album'] ) {
			$allow_most_rated_album = true;
		}

		$most_rated_album_title = ! empty( $instance['most_rated_album_title'] ) ? esc_attr( $instance['most_rated_album_title'] ) : '';

		if ( empty( $instance['number'] ) || ! ( $number = absint( $instance['number'] ) ) ) {
			$number = 10;
		}

		if ( empty( $instance['thumbnail_width'] ) || ! $thumbnail_width = absint( $instance['thumbnail_width'] ) ) {
			$thumbnail_width = 70;
		}
		if ( empty( $instance['thumbnail_height'] ) || ! $thumbnail_height = absint( $instance['thumbnail_height'] ) ) {
			$thumbnail_height = 70;
		}

		global $rtmedia;

		if ( ! empty( $title ) ) { // if title provided, show title
			echo $before_title . $title . $after_title;
		}

		$strings = array(
			'all' => __( 'All', 'rtmedia' ),
			'music' => __( 'Music', 'rtmedia' ),
			'video' => __( 'Videos', 'rtmedia' ),
			'photo' => __( 'Photos', 'rtmedia' ),
		);

		/**
		 * Filter to add/rename media tab name in rtMedia sidebar widget.
		 *
		 * @since 1.3.6
		 *
		 * @param array $strings Media tabs name.
		 *
		 * @return array $strings Media tabs name.
		 */
		$strings = (array) apply_filters( 'rtmedia_sidebar_widget_media_tab_name', $strings );

		$widgetid = $args['widget_id'];

		do_action( 'rtmedia_before_gallery_widget_content' );

		if ( ! is_array( $allowed ) || count( $allowed ) < 1 ) {
			echo '<p>';

			printf( __( 'Please configure this widget <a href="%s" target="_blank" title="Configure BuddyPress Media Widget">here</a>.', 'rtmedia' ), admin_url( '/widgets.php' ) );

			echo '</p>';
		} else {
			if ( count( $allowed ) > 3 ) {
				unset( $allowed['all'] );
			}
			$allowMimeType = array();

			$this->rtmedia_wd_time = $wdTime;
			//$columns[ "privacy" ] = array( "0" );
			$offset = 0;
			$orderby = 'media_id DESC';

			if ( 'most_rated' == $wdType ) {
				$orderby = 'ratings_count DESC, ratings_total DESC';
			} else if ( $wdType == 'popular' ) {
				$orderby = 'likes DESC';
			} else if ( $wdType == 'views' ) {
				// Filter for join with wp_rt_rtm_media_interaction table
				add_filter( 'rtmedia-model-join-query', array( $this, 'join_query_rtmedia_interaction_view_count' ), 20, 2 );
				// Select view and count value from meta table
				add_filter( 'rtmedia-model-select-query', array( $this, 'rtmedia_select_query_view_count_column' ), 20, 2 );
				// Group by
				add_filter( 'rtmedia-model-group-by-query', array( $this, 'rtmedia_select_query_view_count_group' ), 20, 2 );
				// Assigning order according to the view count
				add_filter( 'rtmedia-model-order-by-query', array( $this, 'rtmedia_select_query_view_count_order' ), 20, 2 );
			}

			add_filter( 'rtmedia-model-where-query', array( $this, 'where_query_wdtime' ), 20, 2 );

			if ( apply_filters( 'rtmedia_widget_show_public_media_only', true ) ) {
				add_filter( 'rtmedia-model-where-query', array( $this, 'rtmedia_query_where_filter' ), 10, 3 );
			}

			add_filter( 'rtmedia_context_filter', array( $this, 'rtmedia_gallery_widget_context_filter' ), 10, 1 );

			$widget_media_array = array();

			foreach ( $allowed as $type ) {

				if ( $type != 'all' ) {
					$columns['media_type'] = $type;
				} else {
					/**
					 * Filter to add/remove media type that is being allow to be display in rtMedia sidebar widget under all tab.
					 *
					 * @since 1.3.6
					 *
					 * @param array $allowed Media type that are being allow from the rtMedia sidebar widget setting.
					 * @param string $widgetid widget id.
					 *
					 * @return array $allowed Media type that is being allow to show in the rtMedia sidebar widget under all tab.
					 */
					$columns['media_type'] = (array) apply_filters( 'rtmedia_sidebar_widget_media_type_all_tab', $allowed, $widgetid );
				}

				$widget_media_array[ $type ] = rtm_gallery_widget_get_media( $columns, $offset, $number, $orderby );
			}

			$this->remove_widget_media_filters();

			// most rated albums
			if ( $allow_most_rated_album ) {
				$type = 'most_rated_album';
				$orderby = 'ratings_count DESC, ratings_total DESC';
				$columns = array( 'media_type' => 'album' );
				$widget_media_array[ $type ] = rtm_gallery_widget_get_media( $columns, $offset, $number, $orderby );
			}

			/**
			 * Filters rtmedia_gallery_widget_ordering contain media tabs of rtMedia sidebar gallery widget.
			 *
			 * It's can be use to change the order of the media tab in rtMedia sidebar gallery widget.
			 *
			 * @since 1.3.6
			 *
			 * @param array $allowed media tab list.
			 * @param string $widgetid widget id.
			 *
			 * @return array $allowed media tab that are being ordered.
			 */
			$new_allowed = (array) apply_filters( 'rtmedia_gallery_widget_ordering', $allowed, $widgetid );

			// Pass $new_allowed in loop to check if media type is being $allowed.
			foreach ( $new_allowed as $key => $type ) {

				// Check if media tab does not exist in $allowed list.
				if ( ! in_array( $type, $allowed ) ) {

					// Remove the extra add Media tab.
					unset( $new_allowed[ $key ] );
				}
			}

			// Add Media type that has not being add in the filter rtmedia_gallery_widget_ordering when sorting media tab.
			// Used full when user forget to mention the media type that has being allow in the widget when using rtmedia_gallery_widget_ordering filter.
			$new_allowed = array_unique( array_merge( $new_allowed , array_diff( $allowed, $new_allowed ) ) );

			// Pass the $new_allowed media tab to $allowed.
			$allowed = $new_allowed;

			include RTMediaTemplate::locate_template( 'sidebar-gallery', 'widget' );
		}

		do_action( 'rtmedia_after_gallery_widget_content' );
		echo $after_widget;
	}

	function remove_widget_media_filters() {
		remove_filter( 'rtmedia_context_filter', array( $this, 'rtmedia_gallery_widget_context_filter' ), 10 );
		remove_filter( 'rtmedia-model-where-query', array( $this, 'rtmedia_query_where_filter' ), 10 );
		remove_filter( 'rtmedia-model-where-query', array( $this, 'where_query_wdtime' ), 20 );
		remove_filter( 'rtmedia-model-join-query', array( $this, 'join_query_rtmedia_interaction_view_count' ), 20 );
		remove_filter( 'rtmedia-model-select-query', array( $this, 'rtmedia_select_query_view_count_column' ), 20 );
		remove_filter( 'rtmedia-model-group-by-query', array( $this, 'rtmedia_select_query_view_count_group' ), 20 );
		remove_filter( 'rtmedia-model-order-by-query', array( $this, 'rtmedia_select_query_view_count_order' ), 20 );
	}

	/**
	 *  filter the rtmedia_query to exclude the group media in the sidebar gallery widget
	 */
	function rtmedia_query_where_filter( $where, $table_name, $join ) {
		$where .= ' AND ( ' . $table_name . '.privacy = "0" OR ' . $table_name . '.privacy is NULL )';
		return $where;
	}

	/**
	 * Processes the widget form
	 *
	 * @param array/object $new_instance The new instance of the widget
	 * @param array/object $old_instance The default widget instance
	 * @return array/object filtered and corrected instance
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		if ( isset( $new_instance['wdType'] ) ) {
			$instance['wdType'] = strip_tags( $new_instance['wdType'] );
		}
		if ( isset( $new_instance['wdTime'] ) ) {
			$instance['wdTime'] = strip_tags( $new_instance['wdTime'] );
		}
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['allow_audio'] = ! empty( $new_instance['allow_audio'] ) ? 1 : 0;
		$instance['allow_video'] = ! empty( $new_instance['allow_video'] ) ? 1 : 0;
		$instance['allow_image'] = ! empty( $new_instance['allow_image'] ) ? 1 : 0;
		$instance['allow_all'] = ! empty( $new_instance['allow_all'] ) ? 1 : 0;
		$instance['thumbnail_width'] = (int) $new_instance['thumbnail_width'];
		$instance['thumbnail_height'] = (int) $new_instance['thumbnail_height'];
		$instance['allow_most_rated_album'] = ! empty( $new_instance['allow_most_rated_album'] ) ? 1 : 0;
		$instance['most_rated_album_title'] = $new_instance['most_rated_album_title'];

		/**
		 * Filter run when user click to on save button rtMedia sidebar widget.
		 *
		 * @param array $instance The widget instance value.
		 * @param array $new_instance The widget new instance value.
		 *
		 * @return array $instance The widget new instance value.
		 */
		$instance = apply_filters( 'rtmedia_sidebar_widget_setting_save', $instance, $new_instance );

		return $instance;
	}

	/**
	 * Displays the form for the widget settings on the Widget screen
	 *
	 * @param object/array $instance The widget instance
	 */
	function form( $instance ) {
		$wdType = isset( $instance['wdType'] ) ? esc_attr( $instance['wdType'] ) : '';
		$wdTime = isset( $instance['wdTime'] ) ? esc_attr( $instance['wdTime'] ) : '';
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
		$allowAudio = isset( $instance['allow_audio'] ) ? (bool) $instance['allow_audio'] : true;
		$allowVideo = isset( $instance['allow_video'] ) ? (bool) $instance['allow_video'] : true;
		$allowImage = isset( $instance['allow_image'] ) ? (bool) $instance['allow_image'] : true;
		$allowAll = isset( $instance['allow_all'] ) ? (bool) $instance['allow_all'] : true;
		$thumbnailWidth = isset( $instance['thumbnail_width'] ) ? esc_attr( $instance['thumbnail_width'] ) : '';
		$thumbnailHeight = isset( $instance['thumbnail_height'] ) ? esc_attr( $instance['thumbnail_height'] ) : '';
		$allowAlbum = isset( $instance['allow_most_rated_album'] ) ? (bool) $instance['allow_most_rated_album'] : false;
		$most_rated_album_title = isset( $instance['most_rated_album_title'] ) ? esc_attr( $instance['most_rated_album_title'] ) : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'wdType' ); ?>"><?php _e( 'Widget Type:', 'rtmedia' ); ?></label>
			<select  class="widefat" id="<?php echo $this->get_field_id( 'wdType' ); ?>" name="<?php echo $this->get_field_name( 'wdType' ); ?>" data-value="<?php echo $wdType; ?>">
				<option value="most_rated"><?php _e( 'Most Rated Media', 'rtmedia' ); ?></option>
				<option value="recent" ><?php _e( 'Recent Media', 'rtmedia' ); ?></option>
				<option value="popular" ><?php _e( 'Popular Media', 'rtmedia' ); ?></option>
				<option value="views" ><?php _e( 'Most Viewed Media', 'rtmedia' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'wdTime' ); ?>"><?php _e( 'Media Uploaded Time:', 'rtmedia' ); ?></label>
			<select  class="widefat" id="<?php echo $this->get_field_id( 'wdTime' ); ?>" name="<?php echo $this->get_field_name( 'wdTime' ); ?>" data-value="<?php echo $wdTime; ?>">
				<option value="today"><?php _e( 'Today', 'rtmedia' ); ?></option>
				<option value="this_week" ><?php _e( 'This Week', 'rtmedia' ); ?></option>
				<option value="this_month" ><?php _e( 'This Month', 'rtmedia' ); ?></option>
				<option value="all" ><?php _e( 'All Time', 'rtmedia' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'rtmedia' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'rtmedia' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>
		<p>
			<input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'allow_all' ); ?>" id="<?php echo $this->get_field_id( 'allow_all' ); ?>" <?php checked( $allowAll ); ?> />
			<label for="<?php echo $this->get_field_id( 'allow_all' ); ?>"><?php _e( 'Show All', 'rtmedia' ); ?></label>
		</p>
		<p>
			<input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'allow_image' ); ?>" id="<?php echo $this->get_field_id( 'allow_image' ); ?>" <?php checked( $allowImage ); ?> />
			<label for="<?php echo $this->get_field_id( 'allow_image' ); ?>"><?php _e( 'Show Photos', 'rtmedia' ); ?></label>
		</p>
		<p>
			<input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'allow_audio' ); ?>" id="<?php echo $this->get_field_id( 'allow_audio' ); ?>" <?php checked( $allowAudio ); ?> />
			<label for="<?php echo $this->get_field_id( 'allow_audio' ); ?>"><?php _e( 'Show Music', 'rtmedia' ); ?></label>
		</p>
		<p>
			<input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'allow_video' ); ?>" id="<?php echo $this->get_field_id( 'allow_video' ); ?>" <?php checked( $allowVideo ); ?> />
			<label for="<?php echo $this->get_field_id( 'allow_video' ); ?>"><?php _e( 'Show Videos', 'rtmedia' ); ?></label>
		</p>

		<?php
		/**
		 * Action can being used to add other Media type.
		 *
		 * @since 1.3.6
		 *
		 * @param array $instance widget instance value.
		 * @param array $this class instance.
		 */
		do_action( 'rtmedia_sidebar_widget_media_type_allow', $instance, $this );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'thumbnail_width' ); ?>"><?php _e( 'Thumbnail Width:', 'rtmedia' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'thumbnail_width' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail_width' ); ?>" type="text" value="<?php echo $thumbnailWidth; ?>" size="3" />
			<label>px</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'thumbnail_height' ); ?>"><?php _e( 'Thumbnail Height:', 'rtmedia' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'thumbnail_width' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail_height' ); ?>" type="text" value="<?php echo $thumbnailHeight; ?>" size="3" />
			<label>px</label>
		</p>
		<?php
		global $rtmedia;
		$options = $rtmedia->options;
		if ( is_plugin_active( 'rtmedia-ratings/index.php' ) && isset( $options['general_enableAlbumRatings'] ) && '1' == $options['general_enableAlbumRatings']  ) { ?>
			<h3>Albums:</h3>
			<p>
				<input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'allow_most_rated_album' ); ?>" id="<?php echo $this->get_field_id( 'allow_most_rated_album' ); ?>" <?php checked( $allowAlbum ); ?> />
				<label for="<?php echo $this->get_field_id( 'allow_most_rated_album' ); ?>"><?php _e( 'Show Most Rated Albums', 'rtmedia' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'most_rated_album_title' ); ?>"><?php _e( 'Tab title:', 'rtmedia' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'most_rated_album_title' ); ?>" name="<?php echo $this->get_field_name( 'most_rated_album_title' ); ?>" type="text" value="<?php echo $most_rated_album_title; ?>" />
			</p>
		<?php } ?>
		<script type="text/javascript">
			jQuery( document ).ready( function () {
				jQuery( "div[id*='rtmediagallerywidget']" ).find( "select" ).each( function () {
					jQuery( this ).val( jQuery( this ).data( 'value' ) );
				} );
			} );
		</script>
		<?php
	}

	function rtmedia_gallery_widget_context_filter( $context ) {
		return 'widget/';
	}
}
