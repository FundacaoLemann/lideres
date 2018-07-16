jQuery( document ).ready( function( $ ) {

	'use strict';
	
	$( '.ghostpool-login-wpb-template' ).click( function() {
    	$( '#page_template' ).val( 'homepage-template.php' );
    	$( '#page_header_display-select' ).val( 'gp-header-disabled' );
    	$( '#page_footer_display-select' ).val( 'disabled' );
    	$( '#layout_6' ).prop( 'checked', true );
	});

});
	