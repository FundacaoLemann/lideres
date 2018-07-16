<?php global $gp_counter; ?>

<?php if ( $gp_counter % 5 == 1 ) { ?>

	<div class="gp-featured-large-col">

		<div class="gp-featured-large">
			<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
		</div>
	
	</div>

<?php } elseif ( $gp_counter % 5 == 2 ) { ?>

	<div class="gp-featured-box-scroll">

		<div class="gp-featured-small-col gp-col-1">

			<div class="gp-featured-small">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
			</div>

<?php } elseif ( $gp_counter % 5 == 3 ) { ?>	

			<div class="gp-featured-small">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
			</div>
	
		</div>
						
<?php } elseif ( $gp_counter % 5 == 4 ) { ?>		

		<div class="gp-featured-small-col gp-col-2">

			<div class="gp-featured-small">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
			</div>

<?php } elseif ( $gp_counter % 5 == 0 ) { ?>	
		
			<div class="gp-featured-small">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
			</div>
		
		</div>
		
	</div>	
					
<?php } ?>