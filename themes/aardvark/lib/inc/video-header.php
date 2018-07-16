<?php if ( ! function_exists( 'ghostpool_page_header_video' ) ) {

	function ghostpool_page_header_video( $post_id = '' ) {
	
		if ( $post_id == '' ) {
			$post_id = get_the_ID();
		}
		
		if ( get_post_meta( $post_id, 'page_header_video', true ) ) { 
																			
			// YouTube or Vimeo ID
			$video_url = str_replace( 'www.', '', get_post_meta( $post_id, 'page_header_video', true ) );
			if ( preg_match( '/http:\/\/vimeo/', $video_url ) ) {
				$video_id = str_replace( 'http://vimeo.com/', '', $video_url );
				$video_provider = 'vimeo';
			} elseif ( preg_match( '/https:\/\/vimeo/', $video_url ) ) {
				$video_id = str_replace('https://vimeo.com/', '', $video_url );
				$video_provider = 'vimeo';
			} elseif ( preg_match( '/http:\/\/youtube.com/', $video_url ) ) {
				$video_id = str_replace('http://youtube.com/watch?v=', '', $video_url );
				$video_provider = 'youtube';
			} elseif ( preg_match( '/https:\/\/youtube.com/', $video_url ) ) {
				$video_id = str_replace('https://youtube.com/watch?v=', '', $video_url );
				$video_provider = 'youtube';
			} elseif ( preg_match( '/http:\/\/youtu.be/', $video_url ) ) {
				$video_id = str_replace( 'http://youtu.be/', '', $video_url );	
				$video_provider = 'youtube';		
			} elseif ( preg_match( '/https:\/\/youtu.be/', $video_url ) ) {
				$video_id = str_replace( 'https://youtu.be/', '', $video_url );	
				$video_provider = 'youtube';													
			} else {
				$video_id = '';
				$video_provider = 'html5';
			} ?>
			
			<?php if ( $video_provider === 'youtube' ) { ?>
				<iframe src="https://youtube.com/embed/<?php echo esc_attr( $video_id ); ?>?autoplay=1&controls=1&showinfo=0&autohide=1" frameborder="0" id="gp-page-header-video" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			<?php } elseif ( $video_provider === 'vimeo' ) { ?>
				<iframe src="//player.vimeo.com/video/<?php echo esc_attr( $video_id ); ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=3d96d2&autoplay=1" frameborder="0" id="gp-page-header-video" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			<?php } elseif ( $video_provider  === 'html5' ) { ?>
				<video autoplay="true" controls id="gp-page-header-video">
					<source src="<?php echo esc_url( $video_url ); ?>.ogv" type="video/ogg">
					<source src="<?php echo esc_url( $video_url ); ?>.mp4" type="video/mp4">
				</video>
			<?php }
					
		}			
	}
}

if ( ! function_exists( 'ghostpool_page_header_video_bg' ) ) {

	function ghostpool_page_header_video_bg( $post_id = '' ) {
	
		if ( $post_id == '' ) {
			$post_id = get_the_ID();
		}
			 
		if ( get_post_meta( $post_id, 'page_header_video_bg', true ) ) {
																			
			// YouTube or Vimeo ID
			$video_url = str_replace( 'www.', '', get_post_meta( $post_id, 'page_header_video_bg', true ) );
			if ( preg_match( '/http:\/\/vimeo/', $video_url ) ) {
				$video_id = str_replace( 'http://vimeo.com/', '', $video_url );
				$video_provider = 'vimeo';
			} elseif ( preg_match( '/https:\/\/vimeo/', $video_url ) ) {
				$video_id = str_replace('https://vimeo.com/', '', $video_url );
				$video_provider = 'vimeo';
			} elseif ( preg_match( '/http:\/\/youtube.com/', $video_url ) ) {
				$video_id = str_replace('http://youtube.com/watch?v=', '', $video_url );
				$video_provider = 'youtube';
			} elseif ( preg_match( '/https:\/\/youtube.com/', $video_url ) ) {
				$video_id = str_replace('https://youtube.com/watch?v=', '', $video_url );
				$video_provider = 'youtube';
			} elseif ( preg_match( '/http:\/\/youtu.be/', $video_url ) ) {
				$video_id = str_replace( 'http://youtu.be/', '', $video_url );	
				$video_provider = 'youtube';		
			} elseif ( preg_match( '/https:\/\/youtu.be/', $video_url ) ) {
				$video_id = str_replace( 'https://youtu.be/', '', $video_url );	
				$video_provider = 'youtube';													
			} else {
				$video_id = $video_url;
				$video_provider = 'html5';
			} ?>
			
			<div id="gp-page-header-video-bg">
		
				<?php if ( $video_provider === 'youtube' ) { ?>
					<iframe src="https://youtube.com/embed/<?php echo esc_attr( $video_id ); ?>?autoplay=1&controls=0&showinfo=0&autohide=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				<?php } elseif ( $video_provider === 'vimeo' ) { ?>
					<iframe src="//player.vimeo.com/video/<?php echo esc_attr( $video_id ); ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=3d96d2&autoplay=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				<?php } elseif ( $video_provider  === 'html5' ) { ?>
					<video autoplay="true" loop="loop" muted>
						<source src="<?php echo esc_url( $video_url ); ?>.ogv" type="video/ogg">
						<source src="<?php echo esc_url( $video_url ); ?>.mp4" type="video/mp4">
					</video>
				<?php } ?>
			
			</div>
			
		<?php }	
	}
}

	