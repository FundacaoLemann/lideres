<?php

if ( ! function_exists( 'ghostpool_showcase_posts_widget' ) ) {
	function ghostpool_showcase_posts_widget() {
		register_widget( 'GhostPool_Showcase_Posts' );
	}
}
add_action( 'widgets_init', 'ghostpool_showcase_posts_widget' );

if ( ! class_exists( 'GhostPool_Showcase_Posts' ) ) {
	class GhostPool_Showcase_Posts extends WP_Widget {
	
		function __construct() {
			$widget_ops = array( 'classname' => 'gp-showcase-posts-widget', 'description' => esc_html__( 'Horizontal and vertical content formats.', 'aardvark' ) );
			parent::__construct( 'gp-showcase-posts-widget', esc_html__( 'GP Showcase Posts', 'aardvark' ), $widget_ops );
		}

		function widget( $args, $instance ) {

			extract( $args );

			$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Showcase Posts', 'aardvark' );
			$cats = isset( $instance['cats'] ) ? $instance['cats'] : '';
			$page_ids = isset( $instance['page_ids'] ) ? $instance['page_ids'] : '';
			$post_types = isset( $instance['post_types'] ) ? $instance['post_types'] : 'post';
			$ranking = isset( $instance['ranking'] ) ? $instance['ranking'] : 'gp-no-ranking';
			$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'newest';
			$filter_cats = isset( $instance['filter_cats'] ) ? (bool) $instance['filter_cats'] : 0;
			$filter_date = isset( $instance['filter_date'] ) ? (bool) $instance['filter_date'] : 0;
			$filter_title = isset( $instance['filter_title'] ) ? (bool) $instance['filter_title'] : 0;
			$filter_comment_count = isset( $instance['filter_comment_count'] ) ? (bool) $instance['filter_comment_count'] : 0;
			$filter_likes = isset( $instance['filter_likes'] ) ? (bool) $instance['filter_likes'] : 0;
			$filter_cat_id = isset( $instance['filter_cat_id'] ) ? $instance['filter_cat_id'] : '';
			$per_page = isset( $instance['per_page'] ) ? absint( $instance['per_page'] ) : '5';
			$offset =  isset( $instance['offset'] ) ? absint( $instance['offset'] ) : '';
			$large_excerpt_length = isset( $instance['large_excerpt_length'] ) ? absint( $instance['large_excerpt_length'] ) : 0;
			$small_excerpt_length = isset( $instance['small_excerpt_length'] ) ? absint( $instance['small_excerpt_length'] ) : 0;
			$large_meta_author = isset( $instance['large_meta_author'] ) ? (bool) $instance['large_meta_author'] : 0;
			$large_meta_date = isset( $instance['large_meta_date'] ) ? (bool) $instance['large_meta_date'] : 0;
			$large_meta_comment_count = isset( $instance['large_meta_comment_count'] ) ? (bool) $instance['large_meta_comment_count'] : 0;
			$large_meta_views = isset( $instance['large_meta_views'] ) ? (bool) $instance['large_meta_views'] : 0;
			$large_meta_likes = isset( $instance['large_meta_likes'] ) ? (bool) $instance['large_meta_likes'] : 0;
			$large_meta_cats = isset( $instance['large_meta_cats'] ) ? (bool) $instance['large_meta_cats'] : 0;
			$large_meta_tags = isset( $instance['large_meta_tags'] ) ? (bool) $instance['large_meta_tags'] : 0;
			$small_meta_author = isset( $instance['small_meta_author'] ) ? (bool) $instance['small_meta_author'] : 0;
			$small_meta_date = isset( $instance['small_meta_date'] ) ? (bool) $instance['small_meta_date'] : 0;
			$small_meta_comment_count = isset( $instance['small_meta_comment'] ) ? (bool) $instance['small_meta_comment_count'] : 0;
			$small_meta_views = isset( $instance['small_meta_views'] ) ? (bool) $instance['small_meta_views'] : 0;
			$small_meta_likes = isset( $instance['small_meta_likes'] ) ? (bool) $instance['small_meta_likes'] : 0;
			$small_meta_cats = isset( $instance['small_meta_cats'] ) ? (bool) $instance['small_meta_cats'] : 0;
			$small_meta_tags = isset( $instance['small_meta_tags'] ) ? (bool) $instance['small_meta_tags'] : 0;
			$large_read_more_link = isset( $instance['large_read_more_link'] ) ? $instance['large_read_more_link'] : 'disabled';
			$small_read_more_link = isset( $instance['small_read_more_link'] ) ? $instance['small_read_more_link'] : 'disabled';
						
			echo html_entity_decode( $before_widget );	

				echo do_shortcode( '[gp_showcase
				widget_title="' . $title . '"
				cats="' . $cats .'" 
				page_ids="' . $page_ids . '" 
				post_types="' . $post_types . '" 
				ranking="' . $ranking . '"
				format="gp-posts-vertical" 
				orderby="' . $orderby . '"
				filter_cats="' . $filter_cats . '"
				filter_date="' . $filter_date . '"
				filter_title="' . $filter_title . '"
				filter_comment_count="' . $filter_comment_count . '"
				filter_likes="' . $filter_likes . '"
				filter_cat_id="' . $filter_cat_id . '"
				per_page="' . $per_page . '" 
				offset="' . $offset . '"
				large_excerpt_length="' . $large_excerpt_length . '" 
				small_excerpt_length="' . $small_excerpt_length . '" 
				large_meta_author="' . $large_meta_author . '" 
				large_meta_date="' . $large_meta_date . '" 
				large_meta_comment_count="' . $large_meta_comment_count . '" 
				large_meta_views="' . $large_meta_views . '" 
				large_meta_likes="' . $large_meta_likes . '" 
				large_meta_cats="' . $large_meta_cats . '" 
				large_meta_tags="' . $large_meta_tags . '"
				small_meta_author="' . $small_meta_author . '" 
				small_meta_date="' . $small_meta_date . '" 
				small_meta_comment_count="' . $small_meta_comment_count . '" 
				small_meta_views="' . $small_meta_views . '" 
				small_meta_likes="' . $small_meta_likes . '" 
				small_meta_cats="' . $small_meta_cats . '" 
				small_meta_tags="' . $small_meta_tags . '"
				large_read_more_link="' . $large_read_more_link . '" 
				small_read_more_link="' . $small_read_more_link . '" 
				page_arrows="disabled" 
				pagination="disabled" 
				see_all="disabled" 
				see_all_link="" 
				see_all_text=""
				classes="" 
				icon=""]' );
		
			echo html_entity_decode( $after_widget );

		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = isset( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : esc_html__( 'Showcase Posts', 'aardvark' );
			$instance['cats'] = isset( $new_instance['cats'] ) ? $new_instance['cats'] : '';
			$instance['page_ids'] = isset( $new_instance['page_ids'] ) ? $new_instance['page_ids'] : '';
			$instance['post_types'] = isset( $new_instance['post_types'] ) ? $new_instance['post_types'] : 'post';
			$instance['ranking'] = isset( $_POST['ranking'] ) ? $_POST['ranking'] : 'gp-no-ranking';	
			$instance['orderby'] = isset( $_POST['orderby'] ) ? $_POST['orderby'] : 'newest';
			$instance['filter_cats'] = isset( $new_instance['filter_cats'] ) ? $new_instance['filter_cats'] : '';
			$instance['filter_date'] = isset( $new_instance['filter_date'] ) ? $new_instance['filter_date'] : '';
			$instance['filter_title'] = isset( $new_instance['filter_title'] ) ? $new_instance['filter_title'] : '';
			$instance['filter_comment_count'] = isset( $new_instance['filter_comment_count'] ) ? $new_instance['filter_comment_count'] : '';
			$instance['filter_likes'] = isset( $new_instance['filter_likes'] ) ? $new_instance['filter_likes'] : '';
			$instance['filter_cat_id'] = isset( $new_instance['filter_cat_id'] ) ? $new_instance['filter_cat_id'] : '';
			$instance['per_page'] = isset( $new_instance['per_page'] ) ? absint( $new_instance['per_page'] ) : '5';
			$instance['offset'] = isset( $new_instance['offset'] ) ? absint( $new_instance['offset'] ) : '';
			$instance['large_excerpt_length'] = isset( $new_instance['large_excerpt_length'] ) ? absint( $new_instance['large_excerpt_length'] ) : 0;
			$instance['small_excerpt_length'] = isset( $new_instance['small_excerpt_length'] ) ? absint( $new_instance['small_excerpt_length'] ) : 0;
			$instance['large_meta_author'] = isset( $new_instance['large_meta_author'] ) ? (bool) $new_instance['large_meta_author'] : 0;
			$instance['large_meta_date'] = isset( $new_instance['large_meta_date'] ) ? (bool) $new_instance['large_meta_date'] : 0;
			$instance['large_meta_comment_count'] = isset( $new_instance['large_meta_comment_count'] ) ? (bool) $new_instance['large_meta_comment_count'] : 0;
			$instance['large_meta_views'] = isset( $new_instance['large_meta_views'] ) ? (bool) $new_instance['large_meta_views'] : 0;
			$instance['large_meta_likes'] = isset( $new_instance['large_meta_likes'] ) ? (bool) $new_instance['large_meta_likes'] : 0;
			$instance['large_meta_cats'] = isset( $new_instance['large_meta_cats'] ) ? (bool) $new_instance['large_meta_cats'] : 0;
			$instance['large_meta_tags'] = isset( $new_instance['large_meta_tags'] ) ? (bool) $new_instance['large_meta_tags'] : 0;
			$instance['small_meta_author'] = isset( $new_instance['small_meta_author'] ) ? (bool) $new_instance['small_meta_author'] : 0;
			$instance['small_meta_date'] = isset( $new_instance['small_meta_date'] ) ? (bool) $new_instance['small_meta_date'] : 0;
			$instance['small_meta_comment_count'] = isset( $new_instance['small_meta_comment_count'] ) ? (bool) $new_instance['small_meta_comment_count'] : 0;
			$instance['small_meta_views'] = isset( $new_instance['small_meta_views'] ) ? (bool) $new_instance['small_meta_views'] : 0;
			$instance['small_meta_likes'] = isset( $new_instance['small_meta_likes'] ) ? (bool) $new_instance['small_meta_likes'] : 0;
			$instance['small_meta_cats'] = isset( $new_instance['small_meta_cats'] ) ? (bool) $new_instance['small_meta_cats'] : 0;
			$instance['small_meta_tags'] = isset( $new_instance['small_meta_tags'] ) ? (bool) $new_instance['small_meta_tags'] : 0;
			$instance['large_read_more_link'] = isset( $_POST['large_read_more_link'] ) ? $_POST['large_read_more_link'] : 'disabled';
			$instance['small_read_more_link'] = isset( $_POST['small_read_more_link'] ) ? $_POST['small_read_more_link'] : 'disabled';		
			return $instance;
		}

		function form( $instance ) {
	
			// Defaults
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : esc_html__( 'Showcase Posts', 'aardvark' );
			$cats = isset( $instance['cats'] ) ? esc_attr( $instance['cats'] ) : '';
			$page_ids = isset( $instance['page_ids'] ) ? esc_attr( $instance['page_ids'] ) : '';
			$post_types = isset( $instance['post_types'] ) ? esc_attr( $instance['post_types'] ) : 'post';
			$ranking = isset( $instance['ranking'] ) ? esc_attr( $instance['ranking'] ) : 'gp-no-ranking';
			$orderby = isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : 'newest';
			$filter_cats = isset( $instance['filter_cats'] ) ? (bool) $instance['filter_cats'] : 0;
			$filter_date = isset( $instance['filter_date'] ) ? (bool) $instance['filter_date'] : 0;
			$filter_title = isset( $instance['filter_title'] ) ? (bool) $instance['filter_title'] : 0;
			$filter_comment_count = isset( $instance['filter_comment_count'] ) ? (bool) $instance['filter_comment_count'] : 0;
			$filter_likes = isset( $instance['filter_likes'] ) ? (bool) $instance['filter_likes'] : 0;
			$filter_cat_id = isset( $instance['filter_cat_id'] ) ? esc_attr( $instance['filter_cat_id'] ) : '';	
			$per_page = isset( $instance['per_page'] ) ? absint( $instance['per_page'] ) : '5';
			$offset =  isset( $instance['offset'] ) ? absint( $instance['offset'] ) : '';
			$large_excerpt_length = isset( $instance['large_excerpt_length'] ) ? absint( $instance['large_excerpt_length'] ) : 0;
			$small_excerpt_length = isset( $instance['small_excerpt_length'] ) ? absint( $instance['small_excerpt_length'] ) : 0;
			$large_meta_author = isset( $instance['large_meta_author'] ) ? (bool) $instance['large_meta_author'] : 0;
			$large_meta_date = isset( $instance['large_meta_date'] ) ? (bool) $instance['large_meta_date'] : 0;
			$large_meta_comment_count = isset( $instance['large_meta_comment_count'] ) ? (bool) $instance['large_meta_comment_count'] : 0;
			$large_meta_views = isset( $instance['large_meta_views'] ) ? (bool) $instance['large_meta_views'] : 0;
			$large_meta_likes = isset( $instance['large_meta_likes'] ) ? (bool) $instance['large_meta_likes'] : 0;
			$large_meta_cats = isset( $instance['large_meta_cats'] ) ? (bool) $instance['large_meta_cats'] : 0;
			$large_meta_tags = isset( $instance['large_meta_tags'] ) ? (bool) $instance['large_meta_tags'] : 0;
			$small_meta_author = isset( $instance['small_meta_author'] ) ? (bool) $instance['small_meta_author'] : 0;
			$small_meta_date = isset( $instance['small_meta_date'] ) ? (bool) $instance['small_meta_date'] : 0;
			$small_meta_comment_count = isset( $instance['small_meta_comment_count'] ) ? (bool) $instance['small_meta_comment_count'] : 0;
			$small_meta_views = isset( $instance['small_meta_views'] ) ? (bool) $instance['small_meta_views'] : 0;
			$small_meta_likes = isset( $instance['small_meta_likes'] ) ? (bool) $instance['small_meta_likes'] : 0;
			$small_meta_cats = isset( $instance['small_meta_cats'] ) ? (bool) $instance['small_meta_cats'] : 0;
			$small_meta_tags = isset( $instance['small_meta_tags'] ) ? (bool) $instance['small_meta_tags'] : 0;
			$large_read_more_link = isset( $instance['large_read_more_link'] ) ? esc_attr( $instance['large_read_more_link'] ) : 'disabled';
			$small_read_more_link = isset( $instance['small_read_more_link'] ) ? esc_attr( $instance['small_read_more_link'] ) : 'disabled';
	
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'aardvark' ); ?></label>
				<br/><input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cats' ) ); ?>"><?php esc_html_e( 'Categories:', 'aardvark' ); ?></label> 
				<br/><input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cats' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cats' ) ) ?>" value="<?php echo esc_attr( $cats ); ?>" />
				<br/><small><?php esc_html_e( 'Enter the slugs or IDs separating each one with a comma e.g. xbox,ps3,pc.', 'aardvark' ); ?></small>
			</p>
		
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'page_ids' ) ); ?>"><?php esc_html_e( 'Page IDs:', 'aardvark' ); ?></label> 
				<br/><input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'page_ids' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_ids' ) ) ?>" value="<?php echo esc_attr( $page_ids ); ?>" />
				<br/><small><?php esc_html_e( 'Enter the IDs of the pages you want to include, separating each with a comma e.g. 48,142.', 'aardvark' ); ?></small>
			</p>
		
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'post_types' ) ); ?>"><?php esc_html_e( 'Post Types:', 'aardvark' ); ?></label> 
				<br/><input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_types' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_types' ) ) ?>" value="<?php echo esc_attr( $post_types ); ?>" />
				<br/><small><?php esc_html_e( 'Separate each post type with a comma e.g. post, page.', 'aardvark' ); ?></small>
			</p>
		
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'ranking' ) ); ?>"><?php esc_html_e( 'Ranking:', 'aardvark' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'ranking' ) ); ?>" name="ranking">
					<option value="gp-ranking" <?php if ( $ranking == 'gp-ranking' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Enabled', 'aardvark' ); ?></option>
					<option value="gp-no-ranking" <?php if ( $ranking == 'gp-no-ranking' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Disabled', 'aardvark' ); ?></option>
				</select>	
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order By:', 'aardvark' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="orderby">
					<option value="newest" <?php if ( $orderby == 'newest' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Newest', 'aardvark' ); ?></option>			
					<option value="oldest" <?php if ( $orderby == 'oldest' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Oldest', 'aardvark' ); ?></option> 			
					<option value="title_az" <?php if ( $orderby == 'title_az' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Title (A-Z)', 'aardvark' ); ?></option>
					<option value="title_za" <?php if ( $orderby == 'title_za' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Title (Z-A)', 'aardvark' ); ?></option>
					<option value="comment_count" <?php if ( $orderby == 'comment_count' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Most Comments', 'aardvark' ); ?></option>
					<option value="likes" <?php if ( $orderby == 'likes' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Most Likes', 'aardvark' ); ?></option>
					<option value="menu_order" <?php if ( $orderby == 'menu_order' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Menu Order', 'aardvark' ); ?></option>
					<option value="rand" <?php if ( $orderby == 'rand' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Random', 'aardvark' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'filters' ) ); ?>"><?php esc_html_e( 'Filters:', 'aardvark' ); ?></label><br/>
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'filter_cats' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter_cats' ) ); ?>" value="1" <?php checked( $filter_cats, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'filter_cats' ) ); ?>"><?php esc_html_e( 'Categories', 'aardvark' ); ?></label>
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'filter_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter_date' ) ); ?>" value="1" <?php checked( $filter_date, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'filter_date' ) ); ?>"><?php esc_html_e( 'Date', 'aardvark' ); ?></label>
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'filter_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter_title' ) ); ?>" value="1" <?php checked( $filter_title, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'filter_title' ) ); ?>"><?php esc_html_e( 'Title', 'aardvark' ); ?></label>
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'filter_comment_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter_comment_count' ) ); ?>" value="1" <?php checked( $filter_comment_count, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'filter_comment_count' ) ); ?>"><?php esc_html_e( 'Comment Count', 'aardvark' ); ?></label>
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'filter_likes' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter_likes' ) ); ?>" value="1" <?php checked( $filter_likes, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'filter_likes' ) ); ?>"><?php esc_html_e( 'Likes', 'aardvark' ); ?></label>
			</p>
		
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'filter_cat_id' ) ); ?>"><?php esc_html_e( 'Filter Category:', 'aardvark' ); ?></label> 
				<br/><input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'filter_cat_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter_cat_id' ) ) ?>" value="<?php echo esc_attr( $filter_cat_id ); ?>" />
				<br/><small><?php esc_html_e( 'Enter the slug or ID of the category you want to filter by, leave blank to display all categories - the sub categories of this category will also be displayed.', 'aardvark' ); ?></small>
			</p>
						
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'per_page' ) ); ?>"><?php esc_html_e( 'Per Page:', 'aardvark' ); ?></label> <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'per_page' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'per_page' ) ) ?>" value="<?php echo esc_attr( $per_page ); ?>" size="3" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Offset:', 'aardvark' ); ?></label> <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ) ?>" value="<?php echo esc_attr( $offset ); ?>" size="3" />
			</p>		

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'large_excerpt_length' ) ); ?>"><?php esc_html_e( 'Large Excerpt Length:', 'aardvark' ); ?></label> <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'large_excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'large_excerpt_length' ) ) ?>" value="<?php echo esc_attr( $large_excerpt_length ); ?>" size="3" />
			</p>
		
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'small_excerpt_length' ) ); ?>"><?php esc_html_e( 'Small Excerpt Length:', 'aardvark' ); ?></label> <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'small_excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_excerpt_length' ) ) ?>" value="<?php echo esc_attr( $small_excerpt_length ); ?>" size="3" />
			</p>
															
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'large_post_meta' ) ); ?>"><?php esc_html_e( 'Large Post Meta:', 'aardvark' ); ?></label><br/>
				
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'large_meta_author' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'large_meta_author' ) ); ?>" value="1" <?php checked( $large_meta_author, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'large_meta_author' ) ); ?>"><?php esc_html_e( 'Large Author Name', 'aardvark' ); ?></label>
			
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'large_meta_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'large_meta_date' ) ); ?>" value="1" <?php checked( $large_meta_date, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'large_meta_date' ) ); ?>"><?php esc_html_e( 'Large Post Date', 'aardvark' ); ?></label>
			
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'large_meta_comment_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'large_meta_comment_count' ) ); ?>" value="1" <?php checked( $large_meta_comment_count, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'large_meta_comment_count' ) ); ?>"><?php esc_html_e( 'Large Comment Count', 'aardvark' ); ?></label>
			
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'large_meta_views' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'large_meta_views' ) ); ?>" value="1" <?php checked( $large_meta_views, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'large_meta_views' ) ); ?>"><?php esc_html_e( 'Large Views', 'aardvark' ); ?></label>
			
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'large_meta_likes' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'large_meta_likes' ) ); ?>" value="1" <?php checked( $large_meta_likes, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'large_meta_likes' ) ); ?>"><?php esc_html_e( 'Large Likes', 'aardvark' ); ?></label>
			
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'large_meta_cats' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'large_meta_cats' ) ); ?>" value="1" <?php checked( $large_meta_cats, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'large_meta_cats' ) ); ?>"><?php esc_html_e( 'Large Post Categories', 'aardvark' ); ?></label>
			
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'large_meta_tags' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'large_meta_tags' ) ); ?>" value="1" <?php checked( $large_meta_tags, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'large_meta_tags' ) ); ?>"><?php esc_html_e( 'Large Post Tags', 'aardvark' ); ?></label>

			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'small_post_meta' ) ); ?>"><?php esc_html_e( 'Small Post Meta:', 'aardvark' ); ?></label><br/>
			
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'small_meta_author' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_meta_author' ) ); ?>" value="1" <?php checked( $small_meta_author, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'small_meta_author' ) ); ?>"><?php esc_html_e( 'Small Author Name', 'aardvark' ); ?></label>
			
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'small_meta_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_meta_date' ) ); ?>" value="1" <?php checked( $small_meta_date, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'small_meta_date' ) ); ?>"><?php esc_html_e( 'Small Post Date', 'aardvark' ); ?></label>
			
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'small_meta_comment_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_meta_comment_count' ) ); ?>" value="1" <?php checked( $small_meta_comment_count, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'small_meta_comment_count' ) ); ?>"><?php esc_html_e( 'Small Comment Count', 'aardvark' ); ?></label>
			
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'small_meta_views' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_meta_views' ) ); ?>" value="1" <?php checked( $small_meta_views, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'small_meta_views' ) ); ?>"><?php esc_html_e( 'Small Views', 'aardvark' ); ?></label>
			
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'small_meta_likes' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_meta_likes' ) ); ?>" value="1" <?php checked( $small_meta_likes, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'small_meta_likes' ) ); ?>"><?php esc_html_e( 'Small Likes', 'aardvark' ); ?></label>
			
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'small_meta_cats' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_meta_cats' ) ); ?>" value="1" <?php checked( $small_meta_cats, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'small_meta_cats' ) ); ?>"><?php esc_html_e( 'Small Post Categories', 'aardvark' ); ?></label>
		
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'small_meta_tags' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_meta_tags' ) ); ?>" value="1" <?php checked( $small_meta_tags, 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'small_meta_tags' ) ); ?>"><?php esc_html_e( 'Small Post Tags', 'aardvark' ); ?></label>
		
			</p>
				
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'large_read_more_link' ) ); ?>"><?php esc_html_e( 'Large Read More Link:', 'aardvark' ); ?></label>
				<select id="large_read_more_link" name="large_read_more_link">
					<option value="enabled" <?php if ( $large_read_more_link == 'enabled' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Enabled', 'aardvark' ); ?></option>
					<option value="disabled" <?php if ( $large_read_more_link == 'disabled' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Disabled', 'aardvark' ); ?></option>
				</select>	
			</p>
		
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'small_read_more_link' ) ); ?>"><?php esc_html_e( 'Small Read More Link:', 'aardvark' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'small_read_more_link' ) ); ?>" name="small_read_more_link">
					<option value="enabled" <?php if ( $small_read_more_link == 'enabled' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Enabled', 'aardvark' ); ?></option>
					<option value="disabled" <?php if ( $small_read_more_link == 'disabled' ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Disabled', 'aardvark' ); ?></option>
				</select>	
			</p>
									
			<?php

		}
	}

}

?>