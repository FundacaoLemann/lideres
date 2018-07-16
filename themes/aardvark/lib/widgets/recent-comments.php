<?php

if ( ! function_exists( 'ghostpool_recent_comments_widget' ) ) {
	function ghostpool_recent_comments_widget() {
		register_widget( 'GhostPool_Recent_Comments' );
	}
}
add_action( 'widgets_init', 'ghostpool_recent_comments_widget' );

if ( ! class_exists( 'GhostPool_Recent_Comments' ) ) {
	class GhostPool_Recent_Comments extends WP_Widget {

		function __construct() {
			$widget_ops = array( 'classname' => 'gp-recent-comments-widget', 'description' => esc_html__( 'Your site\'s most recent comments with avatars.', 'aardvark' ) );
			parent::__construct( 'gp-recent-comments-widget', esc_html__( 'GP Recent Comments', 'aardvark' ), $widget_ops );
		}

		function widget( $args, $instance ) {
	
			extract( $args );
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? esc_html__( 'Recent Comments', 'aardvark' ) : $instance['title'] );
			$comment_number = empty( $instance['comment_number'] ) ? '5' : $instance['comment_number'];
		
			global $comment;
	
			echo html_entity_decode( $before_widget );
			
				if ( $title ) { echo html_entity_decode( $before_title . $title . $after_title ); } ?>

				<?php 
		
				$args = array( 
					'number' => $comment_number,
					'status' => 'approve',
				 );

				$comments = get_comments( $args );

				if ( $comments ) { ?>
	
					<ul>

						<?php foreach ( $comments as $comment ) {
											
							if ( function_exists( 'mb_substr' ) ) { 
								$comment_excerpt = mb_substr( apply_filters( 'get_comment_text', $comment->comment_content ), 0, 40 );
							} else {
								$comment_excerpt = substr( apply_filters( 'get_comment_text', $comment->comment_content ), 0, 40 );
							}
		
						 ?>
	 
							<li>
		
								<?php echo get_avatar( $comment->comment_author_email, 32 ); ?> 

								<span>
						
									<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php if ( $comment->user_id != '0' ) { echo esc_attr( get_user_meta( $comment->user_id, 'nickname', true ) ); } else { get_comment_author( $comment->comment_ID ); } ?> <?php esc_html_e( 'said', 'aardvark' ); ?> <?php echo strip_tags( $comment_excerpt ); ?>...</a>
								
									<div class="gp-loop-meta">
										<time class="gp-post-meta gp-meta-date" itemprop="datePublished" datetime="<?php echo get_comment_date( 'c', $comment->comment_ID ); ?>"><?php echo get_comment_date( get_option( 'date_format' ), $comment->comment_ID ); ?></time>
									</div>	
							
								</span>
			
							</li>					

						<?php } ?>
		
					</ul>
		
				<?php } else { ?>

					<strong><?php esc_html_e( 'There are no comments to display.', 'aardvark' ); ?></strong>

				<?php }	
		
			echo html_entity_decode( $after_widget );

		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['comment_number'] = $new_instance['comment_number'];
			return $instance;
		}

		function form( $instance ) {
	
			$defaults = array( 
				'title'          => 'Recent Comments',
				'comment_number' => '5',
			 ); $instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'aardvark' ); ?></label>
				<br/><input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'comment_number' ) ); ?>"><?php esc_html_e( 'Number of comments to show:', 'aardvark' ); ?></label>
				<input  type="text" id="<?php echo esc_attr( $this->get_field_id( 'comment_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comment_number' ) ); ?>" value="<?php echo esc_attr( $instance['comment_number'] ); ?>" size="3" />
			</p>
		
			<input type="hidden" name="widget-options" id="widget-options" value="1" />

			<?php

		}
	}

}

?>