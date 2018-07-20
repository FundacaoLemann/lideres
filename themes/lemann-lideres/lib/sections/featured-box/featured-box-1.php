<?php
global $format, $gp_counter;

// Nosso formato.
if ( 'gp-featured-box-1-2' == $format ) {
	if ( 1 == $gp_counter % 5 ) {
		?>
		<div class="gp-featured-large-col">
			<div class="gp-featured-large">
				<?php get_template_part( 'lib/sections/featured-box/featured-box-item-1-2' ); ?>
			</div>
		</div>
		<?php
	} elseif ( 2 == $gp_counter % 5 ) {
		?>
		<div class="gp-featured-box-scroll">
			<div class="gp-featured-small-col gp-col-1">
				<div class="gp-featured-small">
					<?php get_template_part( 'lib/sections/featured-box/featured-box-item-1-2' ); ?>
				</div>
		<?php
	} elseif ( 3 == $gp_counter % 5 ) {
		?>
				<div class="gp-featured-small">
					<?php get_template_part( 'lib/sections/featured-box/featured-box-item-1-2' ); ?>
				</div>
			</div>
		</div>
		<?php
	}
} else {
	?>
	<div class="gp-featured-large-col">
		<div class="gp-featured-large">
			<?php get_template_part( 'lib/sections/featured-box/featured-box-item' ); ?>
		</div>
	</div>
	<?php
}
