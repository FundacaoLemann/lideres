<?php global $gp_counter; ?>

<?php if ( $gp_counter % 8 == 1 ) { ?>

	<div class="gp-featured-box-scroll">

		<div class="gp-featured-small-col">

			<div class="gp-featured-small">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
			</div>

<?php } elseif ( $gp_counter % 8 == 2 ) { ?>

			<div class="gp-featured-small">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
			</div>
			
		</div>	

<?php } elseif ( $gp_counter % 8 == 3 ) { ?>	

		<div class="gp-featured-small-col">

			<div class="gp-featured-small">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
			</div>
						
<?php } elseif ( $gp_counter % 8 == 4 ) { ?>		

			<div class="gp-featured-small">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
			</div>
			
		</div>	

<?php } elseif ( $gp_counter % 8 == 5 ) { ?>	

		<div class="gp-featured-small-col">

			<div class="gp-featured-small">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
			</div>
						
<?php } elseif ( $gp_counter % 8 == 6 ) { ?>		

			<div class="gp-featured-small">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
			</div>
			
		</div>
	
<?php } elseif ( $gp_counter % 8 == 7 ) { ?>	

		<div class="gp-featured-small-col">

			<div class="gp-featured-small">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
			</div>
						
<?php } elseif ( $gp_counter % 8 == 0 ) { ?>		

			<div class="gp-featured-small">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
			</div>
			
		</div>	
		
	</div>	
	
<?php } ?>