<?php if ( ghostpool_option( 'post_meta', 'cats' ) == '1' OR ghostpool_option( 'post_meta', 'author' ) == '1' OR ghostpool_option( 'post_meta', 'date' ) == '1' OR ghostpool_option( 'post_meta', 'comment_count' ) == '1' OR ghostpool_option( 'post_meta', 'views' ) == '1' OR ghostpool_option( 'post_meta', 'likes' ) == '1' ) { ?>

	<div class="gp-entry-meta">

		<?php if ( ghostpool_option( 'post_meta', 'author' ) == '1' ) { ?>
			<span class="gp-post-meta gp-meta-author"><?php echo ghostpool_author_name( get_the_ID() ); ?></span>
		<?php } ?>

		<?php if ( ghostpool_option( 'post_meta', 'date' ) == '1' ) { ?>
			<time class="gp-post-meta gp-meta-date" itemprop="datePublished" datetime="<?php echo get_the_date( 'c' ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time>
		<?php } ?>

		<?php if ( ghostpool_option( 'post_meta', 'comment_count' ) == '1' ) { ?>
			<span class="gp-post-meta gp-meta-comments"><?php comments_popup_link( esc_html__( 'No Comments', 'aardvark' ), esc_html__( '1 Comment', 'aardvark' ), esc_html__( '% Comments', 'aardvark' ), 'comments-link', esc_html__( 'Comments Closed', 'aardvark' ) ); ?></span>
		<?php } ?>
	
		<?php if ( function_exists( 'wpp_get_views' )  && ghostpool_option( 'post_meta', 'views' ) == '1' ) { ?>
			<span class="gp-post-meta gp-meta-views"><?php if ( function_exists( 'wpp_get_views' ) ) { echo wpp_get_views( get_the_ID() ); } ?> <?php esc_html_e( 'views', 'aardvark' ); ?></span>
		<?php } ?>
	
		<?php if ( ghostpool_option( 'post_meta', 'likes' ) == '1' ) { ?>
			<span class="gp-post-meta gp-meta-likes"><?php if ( function_exists( 'ghostpool_voting_show_up_votes' ) ) { echo ghostpool_voting_show_up_votes(); } ?></span>
		<?php } ?>

		<?php if ( ghostpool_option( 'post_meta', 'cats' ) == '1' ) { ?>
			<span class="gp-post-meta gp-meta-cats"><?php echo ghostpool_exclude_cats( get_the_ID(), false, false ); ?></span>
		<?php } ?>
		
	</div>

<?php } ?>