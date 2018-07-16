(function($) {
	"use strict";

	function initMaps(){
		if( $('.wcs-map').length > 0 ){

			$('.wcs-map').each(function(){

				var $lat = $(this).data('wcs-map-lat');
				var $lon = $(this).data('wcs-map-lon');
				var $type 	= $(this).data('wcs-map-type');
				var $theme 	= $(this).data('wcs-map-theme');
				var $zoom 	= $(this).data('wcs-map-zoom');
				var $map = $(this);

				if( $theme === 'light' ){
					$theme = [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"saturation":-100},{"lightness":20}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"on"},{"saturation":-100},{"lightness":40}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"saturation":-10},{"lightness":30}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"simplified"},{"saturation":-60},{"lightness":10}]},{"featureType":"landscape.natural","elementType":"all","stylers":[{"visibility":"simplified"},{"saturation":-60},{"lightness":60}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"},{"saturation":-100},{"lightness":60}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"},{"saturation":-100},{"lightness":60}]}];
				}

				if( $theme === 'dark' ){
					$theme = [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}];
				}

				if (typeof google === 'object' && typeof google.maps === 'object' ) {
					var map = new google.maps.Map( $map[0], {
						zoom: parseInt( $zoom ),
						center: { lat: Number( $lat ), lng: Number( $lon ) },
						mapTypeId: google.maps.MapTypeId[$type.toUpperCase()],
						mapTypeControl: false,
						mapTypeControlOptions: {},
						disableDefaultUI: true,
						draggable: true,
						navigationControl: true,
						scrollwheel: false,
						streetViewControl: false,
						styles: $theme
					});
					var marker = new google.maps.Marker({
	          position: { lat: Number( $lat ), lng: Number( $lon ) },
	          map: map
	        });
					$map.width("100%").height("340px");
				} else if( window.wcs_is_user_logged_in === '1' ){
					$map.append('<div class="missing-google-maps-api-key">To display a Google Map, it is mandatory to use an API key. You can add it at Classes > Settings > Google Maps > Google Maps Api Key. <small>You are seeing this message because you are logged and you have editing capabilities. Your website users will not see this message</small></div>');
				}

			});

		}
	}

	$(function(){

		initMaps();

	});

})(jQuery);
