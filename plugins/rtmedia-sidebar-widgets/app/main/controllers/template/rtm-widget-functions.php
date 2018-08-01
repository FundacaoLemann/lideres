<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function rtm_widget_get_tab_id( $wdType, $type, $widgetid ) {
	echo $wdType .'-media-tabs-'. $type. '-' .$widgetid;
}

function rtm_gallery_widget_allow_type($instance) {
	$allow = array();
	if (isset($instance['allow_all']) && true === (bool) $instance['allow_all']) {
		$allow[] = 'all';
	}

	if (isset($instance['allow_image']) && true === (bool) $instance['allow_image']) {
		$allow[] = 'photo';
	}

	if (isset($instance['allow_audio']) && true === (bool) $instance['allow_audio']) {
		$allow[] = 'music';
	}

	if (isset($instance['allow_video']) && true === (bool) $instance['allow_video']) {
		$allow[] = 'video';
	}

	/**
	 * Filter to add/remove media type in rtMedia sidebar widgets.
	 *
	 * @since 1.3.5
	 *
	 * @param array $allow default media type in rtMedia sidebar widgets that are allow.
	 * @param array $instance widget instance value.
	 *
	 * @return array $allow media type that is being allow.
	 */
	$allow = (array) apply_filters( 'rtm_gallery_widget_allow_media_type', $allow, $instance );

	return $allow;
}

function rtm_gallery_widget_get_media( $columns, $offset, $number, $orderby ) {

	global $rtmediamodel;
	$rtmediamodel = new RTMediaModel();
	$bp_media_widget_query = $rtmediamodel->get( $columns, $offset, $number, $orderby );

	return $bp_media_widget_query;
}


add_filter( 'rtmedia_located_template', 'rtmedia_locate_gallery_widget_template', 10, 4 );
/**
 * filter the location of the template to locate the sidebar-gallery templates located under templates/media folder
 * @param type $located
 * @param boolean $url true for url, false for path
 * @param type $ogpath
 * @param type $template_name	name of tamplate file
 * @return string location of tamplate
 */
function rtmedia_locate_gallery_widget_template( $located, $url, $ogpath, $template_name ) {
	if ( isset( $template_name ) && 'sidebar-gallery.php' == $template_name ) {
		if ( $url ) {
			$located = trailingslashit( RTMEDIA_WIDGETS_URL ) . 'templates/' . $template_name;
		} else {
			$located = trailingslashit( RTMEDIA_WIDGETS_PATH ) . 'templates/' . $template_name;
		}
	}

	return $located;
}