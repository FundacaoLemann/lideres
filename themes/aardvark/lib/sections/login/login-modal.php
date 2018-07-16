<?php if ( ! is_user_logged_in() ) { ?>

	<div id="login">

		<div id="gp-login-modal">
		
			<div id="gp-login-close"></div>		
		
			<?php get_template_part( 'lib/sections/login/login-form' ); ?>
								
		</div>
				
	</div>
	
<?php } ?>