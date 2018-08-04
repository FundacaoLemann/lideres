(function ($) {
	'use strict';
	$(function () {
		$( window ).load(function() {
			var $owl = $( '.owl-carousel' );
			$owl.each(function() {
				$( this ).on( 'changed.owl.carousel', function() {
					if ( ! $( this ).find( '.owl-nav.top' ).length ) {
						var $owl_nav_1   = $( this ).find( '.owl-nav' ).eq( 0 ),
							$owl_nav_top = $owl_nav_1.clone( true );

						$owl_nav_top.addClass( 'top' );
						$owl_nav_1.after( $owl_nav_top );
					}
				} );
			});
		});
	});
}(jQuery));