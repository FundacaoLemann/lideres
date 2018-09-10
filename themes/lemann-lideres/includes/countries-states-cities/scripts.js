(function ($) {
	'use strict';
	$(function () {
		var $country_field = $( '#field_647' ),
			$state_field   = $( '#field_648' ),
			$city_field    = $( '#field_649' ),
			country_value  = $country_field.val(),
			state_value    = $state_field.val(),
			city_value     = $city_field.val();

		function transform_into_select( $element ) {
			var field_id   = $element.attr( 'id' ),
				field_name = $element.attr( 'name' ),
				$input = $( '<select id="' + field_id + '" name="' + field_name + '"></select>' );

			$element.replaceWith( $input )

			return $input;
		}
		$country_field = transform_into_select( $country_field );
		$state_field = transform_into_select( $state_field );
		$city_field = transform_into_select( $city_field );

		var country_options = '<option value="">---</option><option value="Brasil">Brasil</option>';
		$.each( lemann_coutries.countries, function( i, country ) {
			country_options += '<option value="' + country + '">' + country + '</option>';
		} );
		$country_field.html( country_options );
		$country_field.val( country_value );
		$country_field.change( function() {
			var is_brasil = ( 'Brasil' == $( this ).val() );
			if ( ! is_brasil ) {
				$state_field.val( '' );
				$city_field.val( '' );
				state_value = '';
				city_value  = '';
			}
			$state_field.closest( 'fieldset' ).toggle( is_brasil );
			$city_field.closest( 'fieldset' ).toggle( is_brasil );
		} ).trigger( 'change' );

		var state_options = '<option value="">---</option>';
		$.each( lemann_coutries['states-cities'], function( code, cities ) {
			state_options += '<option value="' + code + '">' + code + '</option>';
		} );
		$state_field.html( state_options );
		$state_field.val( state_value );
		$state_field.change( function() {
			var $$           = $( this ),
				state        = $$.val(),
				city_options = '';
			if ( '' == state || 'undefined' == typeof lemann_coutries['states-cities'][ state ] ) {
				city_options = '<option value="">Escolha o estado</option>';
			} else {
				city_options = '<option value="">---</option>';
				$.each( lemann_coutries['states-cities'][ state ], function( i, city ) {
					city_options += '<option value="' + city + '">' + city + '</option>';
				} );
				$city_field.html( city_options );
			}
		} ).trigger( 'change' );



	});
}(jQuery));
