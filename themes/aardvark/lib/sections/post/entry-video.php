<?php

global $wp_embed, $_wp_additional_image_sizes;

// Get image dimensions
$image_width = $_wp_additional_image_sizes['gp_featured_image']['width'];
$image_height = $_wp_additional_image_sizes['gp_featured_image']['height'];
	
if ( get_post_meta( get_the_ID(), 'video_embed_url', true ) ) {
	
	$output = do_shortcode( $wp_embed->run_shortcode( '[embed width="' . absint( $image_width ) . '" height="' . absint( $image_height ) . '"]' . esc_url( get_post_meta( get_the_ID(), 'video_embed_url', true ) ) . '[/embed]' ) );

} else { 

	$mp4 = '';
	$m4v = '';
	$webm = '';
	$ogv = '';

	if ( get_post_meta( get_the_ID(), 'video_mp4_url', true ) ) {	
		$mp4 = get_post_meta( get_the_ID(), 'video_mp4_url', true );
		$mp4 = $mp4['url'];
	}

	if ( get_post_meta( get_the_ID(), 'video_m4v_url', true ) ) {		
		$m4v = get_post_meta( get_the_ID(), 'video_m4v_url', true );
		$m4v = $m4v['url'];
	}

	if ( get_post_meta( get_the_ID(), 'video_webm_url', true ) ) {	
		$webm = get_post_meta( get_the_ID(), 'video_webm_url', true );
		$webm = $webm['url'];
	}

	if ( get_post_meta( get_the_ID(), 'video_ogv_url', true ) ) {	
		$ogv = get_post_meta( get_the_ID(), 'video_ogv_url', true );
		$ogv = $ogv['url'];
	}

	$output = do_shortcode( '[video mp4="' . esc_url( $mp4 ) . '" m4v="' . esc_url( $m4v ) . '" webm="' . esc_url( $webm ). '" ogv="' . esc_url( $ogv ) . '" width="' . absint( $image_width ) . '" height="' . absint( $image_height ) . '"][/video]' );

}

if ( ! empty( $output ) ) {
	echo '<div class="gp-video-wrapper">' . $output . '</div>'; 
} ?>	