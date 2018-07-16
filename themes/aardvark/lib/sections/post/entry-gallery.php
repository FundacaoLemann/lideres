<?php

// Get image IDs
$image_ids = array_filter( explode( ',', get_post_meta( get_the_ID(), 'gallery_slider', true ) ) );	

if ( $image_ids ) { ?>

	<div class="gp-post-format-gallery-slider gp-slider"> 
						
		 <ul class="slides">
			<?php foreach ( $image_ids as $image_id ) { ?>
				<li>
				
					<?php 
					
					$image = wp_get_attachment_image_src( $image_id, 'gp_featured_image' );
					
					if ( $image[0] ) {
					
						$attachment_id = get_post( $image_id );
					
						// Get image dimensions
						global $_wp_additional_image_sizes;
						$image_width = $_wp_additional_image_sizes['gp_featured_image']['width'];
						$image_height = $_wp_additional_image_sizes['gp_featured_image']['height'];
					
						?>
						
						<img src="<?php echo esc_url( $image[0] ); ?>" width="<?php echo absint( $image_width ); ?>" height="<?php echo absint( $image_height ); ?>" alt="<?php if ( get_post_meta( $image_id, '_wp_attachment_image_alt', true) ) { echo esc_attr( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ); } else { the_title_attribute(); } ?>" />
						
					<?php } ?>
					
					<?php if ( $attachment_id->post_excerpt ) { ?>
						<div class="wp-caption-text"><?php echo esc_attr( $attachment_id->post_excerpt ); ?></div>
					<?php } ?>	
					
				</li>
			<?php } ?>
		</ul>
		
	 </div>
	
<?php } ?>