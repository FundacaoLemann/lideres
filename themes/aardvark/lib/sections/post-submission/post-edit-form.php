<?php 

// Pass ID of post being edited from URL
$post_edit = get_post( $_GET['id'] ); ?>

<div id="gp_post_edit_form_wrapper">
					
	<form class="gp-post-edit-form gp-post-form" name="ghostpool_post_edit_form" method="post" enctype="multipart/form-data">						

		<div class="gp-success">
			<strong><?php esc_html_e( 'Thanks for editing your post!', 'aardvark' ); ?></strong>
			<p><?php if ( ghostpool_option( 'post_editing' ) == 'approved' ) {
				echo esc_html__( 'Your post was succesfully edited. You can view your post', 'aardvark' ) . ' <span class="gp-view-post-link"><a href="' . get_permalink( $_GET['id'] ) . '">' . esc_html__( 'here', 'aardvark' ) . '</a>.</span>';
			} else {
				if ( get_option( 'permalink_structure' ) ) {
					$permalink_structure = '?';
				} else { 
					$permalink_structure = '&';
				}
				esc_html_e( 'Your post is currently being reviewed. ', 'aardvark' );
				if ( is_user_logged_in() ) {
					echo esc_html__( 'You can check the status of your post', 'aardvark' ) . ' <span class="gp-view-post-link"><a href="' . get_permalink( ghostpool_option( 'post_submission_page' ) ) . '">' . esc_html__( 'here', 'aardvark' ) . '</a>.</span>';
				}	
			} ?></p>
		</div>

		<?php if ( $post_edit->post_title ) { ?>
			<p class="gp-post-form-title gp-field-container">
				<input type="text" name="ghostpool_post_title" class="gp-field" value="<?php echo esc_attr( stripslashes( $post_edit->post_title ) ); ?>" required>
			</p>	
		<?php } ?>

		<p class="gp-post-form-image gp-field-container">						

			<a id="gp-upload-edit-image" class="gp-upload-image button gp-field" data-upload-image="<?php if ( has_post_thumbnail( $post_edit->ID ) ) { esc_html_e( 'Edit image', 'aardvark' ); } else { esc_html_e( 'Add image', 'aardvark' ); } ?>" data-image-added="<?php esc_html_e( 'Image added', 'aardvark' ); ?>" data-image-not-added="<?php esc_html_e( 'Can you only upload 1 image', 'aardvark' ); ?>" /><?php esc_html_e( 'Edit image', 'aardvark' ); ?></a>							
		
			<span class="gp-uploads">
				<?php if ( has_post_thumbnail( $post_edit->ID ) ) { $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_edit->ID ), 'thumbnail' ); ?>
					<span class="gp-image-preview">
						<img src="<?php echo esc_url( $image[0] ); ?>" />
					</span>
				<?php } ?>
			</span>
	
		</p>

		<?php if ( $post_edit->post_category[0] ) { ?>		
			<p class="gp-post-form-categories gp-field-container">
				<?php $categories = get_categories( array(
					'orderby' => 'name',
					'order'   => 'asc',							
				) ); ?>
				<select name="ghostpool_post_categories" class="gp-field" required>	
					<option value=""><?php esc_html_e( 'Select a category', 'aardvark' ); ?></option>							
					<?php foreach ( $categories as $category ) { ?>
						<option value="<?php echo esc_attr( $category->term_id ); ?>"<?php if ( $category->term_id == $post_edit->post_category[0] ) { ?> selected<?php } ?>><?php echo esc_html( $category->name ); ?></option>
					<?php } ?>
				</select>
			</p>
		<?php } ?>
	
		<?php if ( get_post_format( $post_edit->ID ) ) { ?>
			<p class="gp-post-form-formats gp-field-container">
				<select name="ghostpool_post_formats" class="gp-field" required>
					<option value="0"<?php if ( get_post_format( $post_edit->ID ) == 0 ) { ?> selected<?php } ?>><?php esc_html_e( 'Standard', 'aardvark' ); ?></option>
					<?php $post_formats = get_theme_support( 'post-formats' ); ?>
					<?php foreach ( $post_formats[0] as $post_format ) { ?>
						<option value="<?php echo esc_attr( $post_format ); ?>"<?php if ( $post_format == get_post_format( $post_edit->ID ) ) { ?> selected<?php } ?>><?php echo esc_attr( ucfirst( $post_format ) ); ?></option>
					<?php } ?>
				</select>
			</p>
		<?php } ?>
	
		<?php if ( $post_edit->post_content ) { ?>		
			<p class="gp-post-form-content gp-field-container">
				<textarea name="ghostpool_post_content" class="gp-field" placeholder="<?php esc_html_e( 'Enter text', 'aardvark' ); ?>" required><?php echo stripslashes( $post_edit->post_content ); ?></textarea>
			</p>
		<?php } ?>

		<?php if ( $post_edit->tags_input ) { ?>
			<p class="gp-post-form-tags gp-field-container">
				<input type="text" name="ghostpool_post_tags" class="gp-field" value="<?php echo esc_attr( implode( $post_edit->tags_input, ', ' ) ); ?>" placeholder="<?php esc_html_e( 'Separate tags with commas', 'aardvark' ); ?>">
			</p>
		<?php } ?>
	
		<p class="gp-post-form-submit">
			<input type="submit" value="<?php esc_attr_e( 'Edit Post', 'aardvark' ); ?>" tabindex="40" class="gp-submit" name="submit" />
		</p>

		<input type="hidden" class="gp-post-form-post-id" value="<?php echo absint( $post_edit->ID ); ?>" />

	</form>

</div>