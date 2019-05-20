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
        
        $('input.application_button.button').on('click', function(){
            var $button = $(this);
            if(!$button.data('sent')){
                $button.data('sent', true);
                var $form = $('form.job-manager-application-form');
                $button.val('Registrando seu interesse');
                $.post($form.attr('action'), $form.serialize(), function(){
                    $button.val('Seu interesse foi registrado')
                });
            }
        });
	});

	setTimeout(function(){
		$('#submit-job-form #prazo_inscricao').datepicker( "option", "dateFormat", 'dd/mm/yy' );
	},2000);
}(jQuery));
