<div id="gp-header-row-1" class="gp-header-row">		

	<div class="gp-container">

		<?php if ( ghostpool_option( 'header_search_bar' ) == 'enabled' ) { ?>
			<div id="gp-header-search"><?php get_search_form(); ?></div>
		<?php } ?>
			
		<?php get_template_part( 'lib/sections/header/logo' ); ?>

		<?php get_template_part( 'lib/sections/header/secondary-nav' ); ?>

	</div>

</div>

<div id="gp-header-row-2" class="gp-header-row">

	<div class="gp-container">
	
		<div>
		
			<?php get_template_part( 'lib/sections/header/primary-nav' ); ?>
	
			<?php get_template_part( 'lib/sections/header/header-buttons' ); ?>
		
		</div>
				
	</div>

</div>