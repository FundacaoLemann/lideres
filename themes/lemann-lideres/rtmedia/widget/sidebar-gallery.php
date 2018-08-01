<?php
/*
 * Arquivo modificado a partir do
 * rtmedia-sidebar-widgets/templates/sidebar-gallery.php
 */
?>

<div id="<?php echo $wdType; ?>-media-tabs" class="rtm-tabs-container ">
	<?php
	$active_counter = 0;
	foreach ( $allowed as $type ) {
		$active_counter ++;
		?>
		<div id="<?php rtm_widget_get_tab_id( $wdType, $type, $widgetid ) ?>" class="rt-media-tab-panel <?php echo ( 1 === $active_counter ) ? 'active-div' : 'hide'; ?>">
			<?php

			$bp_media_widget_query = $widget_media_array[ $type ];

			if ( sizeof( $bp_media_widget_query ) > 0 ) {
				?>
				<ul class="widget-item-listing clearfix">

					<?php
					foreach ( $bp_media_widget_query as $rt_media_gallery ) {
						?>

						<li class="rtmedia-list-item" style="height:<?php echo $thumbnail_height; ?>px; width:<?php echo $thumbnail_width; ?>px;">
							<?php do_action( 'rtmedia_gallery_widget_before_media', $rt_media_gallery ); ?>
							<a href ="<?php echo get_rtmedia_permalink( $rt_media_gallery->id ); ?>" title="<?php echo $rt_media_gallery->media_title; ?>">
								<div class="rtmedia-item-thumbnail">
									<img src="<?php rtmedia_image( 'rt_media_thumbnail', $rt_media_gallery->id ); ?>" alt="<?php echo $rt_media_gallery->media_title; ?>">
								</div>
							</a>
							<?php do_action( 'rtmedia_gallery_widget_after_media', $rt_media_gallery ); ?>
						</li>
						<?php
					}
					?>
				</ul>
				<?php
			} else {
				$media_string = $type;

				if ( 'all' === $type ) {
					$media_string = 'media';
				}

				if ( 'recent' === $wdType  ) {
					if ( 'photo' === $media_string ) {
						esc_html_e( 'No recent photo found', 'rtmedia' );
					} else if ( 'music' === $media_string ) {
						esc_html_e( 'No recent music found', 'rtmedia' );
					} else if ( 'video' === $media_string ) {
						esc_html_e( 'No recent video found', 'rtmedia' );
					} else {
						esc_html_e( 'No recent media found', 'rtmedia' );
					}
				}

				if ( 'most_rated' === $wdType  ) {
					if ( 'photo' === $media_string ) {
						esc_html_e( 'No most rated photo found', 'rtmedia' );
					} else if ( 'music' === $media_string ) {
						esc_html_e( 'No most rated music found', 'rtmedia' );
					} else if ( 'video' === $media_string ) {
						esc_html_e( 'No most rated video found', 'rtmedia' );
					} else {
						esc_html_e( 'No most rated media found', 'rtmedia' );
					}
				}

				if ( 'views' === $wdType  ) {
					if ( 'photo' === $media_string ) {
						esc_html_e( 'No most viewed photo found', 'rtmedia' );
					} else if ( 'music' === $media_string ) {
						esc_html_e( 'No most viewed music found', 'rtmedia' );
					} else if ( 'video' === $media_string ) {
						esc_html_e( 'No most viewed video found', 'rtmedia' );
					} else {
						esc_html_e( 'No most viewed media found', 'rtmedia' );
					}
				}

				if ( 'popular' === $wdType  ) {
					if ( 'photo' === $media_string ) {
						esc_html_e( 'No popular photo found', 'rtmedia' );
					} else if ( 'music' === $media_string ) {
						esc_html_e( 'No popular music found', 'rtmedia' );
					} else if ( 'video' === $media_string ) {
						esc_html_e( 'No popular video found', 'rtmedia' );
					} else {
						esc_html_e( 'No popular media found', 'rtmedia' );
					}
				}
			}
			?>
		</div>
		<?php
	}
	// most rated albums
	if ( is_plugin_active( 'rtmedia-ratings/index.php' ) && $allow_most_rated_album && isset( $options['general_enableAlbumRatings'] ) && '1' == $options['general_enableAlbumRatings'] ) {
		$type = 'most_rated_album';
	?>
		<div id="<?php rtm_widget_get_tab_id( $wdType, $type, $widgetid ) ?>" class="0 rt-media-tab-panel <?php echo ( 1 === $active_counter ) ? 'active-div' : 'hide'; ?>">
			<?php

			$bp_media_widget_query = $widget_media_array[ $type ];

			if ( sizeof( $bp_media_widget_query ) > 0 ) {
				?>
				<ul class="widget-item-listing clearfix">

					<?php
					foreach ( $bp_media_widget_query as $rt_media_gallery ) {
						?>

						<li class="rtmedia-list-item" style="height:<?php echo $thumbnail_height; ?>px; width:<?php echo $thumbnail_width; ?>px;">
							<?php do_action( 'rtmedia_gallery_widget_before_media', $rt_media_gallery ); ?>
							<a href ="<?php echo get_rtmedia_permalink( $rt_media_gallery->id ); ?>" title="<?php echo $rt_media_gallery->media_title; ?>" class="no-popup">
								<div class="rtmedia-item-thumbnail">
									<img src="<?php rtmedia_image( 'rt_media_thumbnail', $rt_media_gallery->id ); ?>" alt="<?php echo $rt_media_gallery->media_title; ?>">
								</div>
							</a>
							<?php do_action( 'rtmedia_gallery_widget_after_media', $rt_media_gallery ); ?>
						</li>
						<?php
					}
					?>
				</ul>
				<?php
			} else {
				esc_html_e( 'No most rated album found', 'rtmedia' );
			}
			?>
		</div>
	<?php
	}
	?>
</div>
