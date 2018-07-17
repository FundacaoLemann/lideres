<?php global $gp_counter; ?>

<?php if ( $gp_counter % 2 == 1 ) { ?>	

	<div class="gp-featured-large-col gp-col-1">

		<div class="gp-featured-large">
			<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
		</div>
	
	</div>
	
<?php } elseif ( $gp_counter % 2 == 0 ) { ?>

	<div class="gp-featured-large-col gp-col-2">

		<div class="gp-featured-large">
			<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
		</div>
		
	</div>	

<?php } ?>