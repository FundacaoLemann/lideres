<?php

if ( ! function_exists( 'ghostpool_contact_details_widget' ) ) {
	function ghostpool_contact_details_widget() {
		register_widget( 'GhostPool_Contact_Details' );
	}
}
add_action( 'widgets_init', 'ghostpool_contact_details_widget' );

if ( ! class_exists( 'GhostPool_Contact_Details' ) ) {
	class GhostPool_Contact_Details extends WP_Widget {
	
		function __construct() {
			$widget_ops = array( 'classname' => 'gp-contact-details-widget', 'description' => esc_html__( 'Display your contact details.', 'aardvark' ) );
			parent::__construct( 'gp-contact-details-widget', esc_html__( 'GP Contact Details', 'aardvark' ), $widget_ops );
		}

		function widget( $args, $instance ) {
		
			extract( $args );
				
			$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'About Us', 'aardvark' );
			$intro = isset( $instance['intro'] ) ? $instance['intro'] : '';
			$email = isset( $instance['email'] ) ? $instance['email'] : '';
			$phone = isset( $instance['phone'] ) ? $instance['phone'] : '';
			$mobile = isset( $instance['mobile'] ) ? $instance['mobile'] : '';
			$address = isset( $instance['address'] ) ? $instance['address'] : '';
			$icon_color = isset( $instance['icon_color'] ) ? $instance['icon_color'] : '';
			$text_color = isset( $instance['text_color'] ) ? $instance['text_color'] : '';
			
			// Add CSS styling to header
			if ( function_exists( 'ghostpool_contact_details_css' ) ) {
				ghostpool_contact_details_css( $args['widget_id'], $icon_color, $text_color );
			}
							
			echo html_entity_decode( $before_widget ); 
			
				if ( $title ) { echo html_entity_decode( $before_title . $title . $after_title ); } ?>
				
				<?php if ( $intro ) { ?>
					<div class="gp-contact-intro"><?php echo esc_attr( $intro ); ?></div>
				<?php } ?>
				
				<?php if ( $email ) { ?>
					<div class="gp-contact-detail gp-contact-email">
						<div class="gp-contact-text"><?php echo esc_attr( $email ); ?></div>
					</div>
				<?php } ?>
				
				<?php if ( $phone ) { ?>
					<div class="gp-contact-detail gp-contact-phone">
						<div class="gp-contact-text"><?php echo esc_attr( $phone ); ?></div>
					</div>
				<?php } ?>
				
				<?php if ( $mobile ) { ?>
					<div class="gp-contact-detail gp-contact-mobile">
						<div class="gp-contact-text"><?php echo esc_attr( $mobile ); ?></div>
					</div>
				<?php } ?>
				
				<?php if ( $address ) { ?>
					<div class="gp-contact-detail gp-contact-address">
						<div class="gp-contact-text"><?php echo nl2br( esc_attr( $address ) ); ?></div>
					</div>
				<?php } ?>
		
			<?php echo html_entity_decode( $after_widget );

		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = isset( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : esc_html__( 'About Us', 'aardvark' );
			$instance['intro'] = isset( $new_instance['intro'] ) ? $new_instance['intro'] : '';
			$instance['email'] = isset( $new_instance['email'] ) ? $new_instance['email'] : '';
			$instance['phone'] = isset( $new_instance['phone'] ) ? $new_instance['phone'] : '';
			$instance['mobile'] = isset( $new_instance['mobile'] ) ? $new_instance['mobile'] : '';
			$instance['address'] = isset( $new_instance['address'] ) ? $new_instance['address'] : '';
			$instance['icon_color'] = isset( $new_instance['icon_color'] ) ? $new_instance['icon_color'] : '';
			$instance['text_color'] = isset( $new_instance['text_color'] ) ? $new_instance['text_color'] : '';
			return $instance;
		}

		function form( $instance ) {
		
			// Defaults
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : esc_html__( 'About Us', 'aardvark' );
			$intro = isset( $instance['intro'] ) ? esc_attr( $instance['intro'] ) : '';
			$email = isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';
			$phone = isset( $instance['phone'] ) ? esc_attr( $instance['phone'] ) : '';
			$mobile = isset( $instance['mobile'] ) ? esc_attr( $instance['mobile'] ) : '';
			$address = isset( $instance['address'] ) ? esc_attr( $instance['address'] ) : '';
			$icon_color = isset( $instance['icon_color'] ) ? esc_attr( $instance['icon_color'] ) : '';
			$text_color = isset( $instance['text_color'] ) ? esc_attr( $instance['text_color'] ) : '';

			// Load color picker
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
		
			?>
				
			<script>
				jQuery( document ).ready( function( $ ) {
					jQuery( '.gp-colorpicker' ).wpColorPicker();
				});
			</script>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'aardvark' ); ?></label>
				<br/><input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'intro' ) ); ?>"><?php esc_html_e( 'Introduction:', 'aardvark' ); ?></label>
				<br/><textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'intro' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'intro' ) ) ?>"><?php echo esc_attr( $intro ); ?></textarea>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Email:', 'aardvark' ); ?></label> 
				<br/><input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ) ?>" value="<?php echo esc_attr( $email ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"><?php esc_html_e( 'Phone:', 'aardvark' ); ?></label> 
				<br/><input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ) ?>" value="<?php echo esc_attr( $phone ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'mobile' ) ); ?>"><?php esc_html_e( 'Mobile:', 'aardvark' ); ?></label> 
				<br/><input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'mobile' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'mobile' ) ) ?>" value="<?php echo esc_attr( $mobile ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php esc_html_e( 'Address:', 'aardvark' ); ?></label> 
				<br/><textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ) ?>"><?php echo esc_attr( $address ); ?></textarea>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'icon_color' ) ); ?>"><?php esc_html_e( 'Icon Color:', 'aardvark' ); ?></label>
				<br/><input type="text" class="gp-colorpicker" id="<?php echo esc_attr( $this->get_field_id( 'icon_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_color' ) ); ?>" value="<?php echo esc_attr( $icon_color ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text_color' ) ); ?>"><?php esc_html_e( 'Text Color:', 'aardvark' ); ?></label>
				<br/><input type="text" class="gp-colorpicker" id="<?php echo esc_attr( $this->get_field_id( 'text_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_color' ) ); ?>" value="<?php echo esc_attr( $text_color ); ?>" />
			</p>

			<?php

		}
	}

}

?>