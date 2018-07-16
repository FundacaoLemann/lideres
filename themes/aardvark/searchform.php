<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" name="s" class="gp-search-bar" placeholder="<?php esc_attr_e( 'search', 'aardvark' ); ?>" value="<?php the_search_query(); ?>" />
</form>