<?php global $bp; ?>

<div id="gp-buddypress-column-left">
		
	<h2 class="gp-username"><?php echo esc_attr( $bp->groups->current_group->name ); ?></h2>

</div>

<div id="gp-buddypress-column-right">
	<?php the_content(); ?>
</div>