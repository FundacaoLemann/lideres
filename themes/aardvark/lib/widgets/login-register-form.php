<?php

if ( ! function_exists( 'ghostpool_login_widget' ) ) {
	function ghostpool_login_widget() {
		register_widget( 'GhostPool_Login' );
	}
}
add_action( 'widgets_init', 'ghostpool_login_widget' );

if ( ! class_exists( 'GhostPool_Login' ) ) {
	class GhostPool_Login extends WP_Widget {
	
		function __construct() {
			$widget_ops = array( 'classname' => 'gp-login-widget', 'description' => esc_html__( 'Display a login/register widget.', 'aardvark' ) );
			parent::__construct( 'gp-login-widget', esc_html__( 'GP Login/Register Form', 'aardvark' ), $widget_ops );
		}

		function widget( $args, $instance ) {
		
			extract( $args );
			
			if ( ! is_user_logged_in() ) {
				
				echo html_entity_decode( $before_widget );
			
					get_template_part( 'lib/sections/login/login-form' );
				
				echo html_entity_decode( $after_widget );
			
			}
			
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			return $instance;
		}

		function form( $instance ) { ?>
		
			<p></p>
			
			<?php

		}
	}

}

?>