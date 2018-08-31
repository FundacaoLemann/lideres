(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 var autocomplete;

	function initialize() {

		var work_loc_elements = document.getElementsByClassName( "bprm-wautocomplete" );
		var p;
		for ( p = 0; p < work_loc_elements.length; p++ ) {
			var work_elmt = $( work_loc_elements[p] ).attr( 'id' );
			autocomplete  = new google.maps.places.Autocomplete(
				(document.getElementById( work_elmt )),
				{ types: ['geocode'] }
			);
			google.maps.event.addListener( autocomplete, 'place_changed', function() {} );
		}

	}

	jQuery( document ).ready(
		function($) {

			var autocomplete;

			function initialize() {

				var work_loc_elements = document.getElementsByClassName( "bprm-wautocomplete" );
				var p;
				for ( p = 0; p < work_loc_elements.length; p++ ) {
					var work_elmt = $( work_loc_elements[p] ).attr( 'id' );
					autocomplete  = new google.maps.places.Autocomplete(
						(document.getElementById( work_elmt )),
						{ types: ['geocode'] }
					);
					google.maps.event.addListener( autocomplete, 'place_changed', function() {} );
				}

			}
			if ( typeof google != 'undefined' ) {
				google.maps.event.addDomListener( window, 'load', initialize );
			}

			/* start hide to year on page load if current company is set */
			var work_checkboxes = $( 'input.bprm_curcomp' );
			work_checkboxes.each(
				function(){
					var check_work = $( this );
					if ( check_work.filter( ':checked' ).length == check_work.length ) {
						$( this ).closest( '.bprm-bprm_curcomp' ).siblings( '.bprm-bprms_posto' ).hide();
					} else {
						$( this ).closest( '.bprm-bprm_curcomp' ).siblings( '.bprm-bprms_posto' ).show();
					}
				}
			);
			/* end hide to year on page load if current company is set */

			/* start hide to year on page load if current school is set */
			var edu_checkboxes = $( 'input.bprms_curschol' );
			edu_checkboxes.each(
				function(){
					var check_edu = $( this );
					if ( check_edu.filter( ':checked' ).length == check_edu.length ) {
						$( this ).closest( '.bprm-bprms_curschol' ).siblings( '.bprm-bprms_yoc' ).hide();
					} else {
						$( this ).closest( '.bprm-bprms_curschol' ).siblings( '.bprm-bprms_yoc' ).show();
					}
				}
			);
			/* end hide to year on page load if current school is set */

			/* datepicker for field type calender */
			$( 'input.bprm-calender' ).datepicker(
				{
					changeMonth: true,
					changeYear: true,
					yearRange: "-100:+0"
				}
			);

			/* selectize for field type selectize */
			$( '.bprm_intrst .inp-text' ).selectize(
				{
					delimiter: ',',
					persist: false,
					create: function(input) {
						return {
							value: input,
							text: input
						}
					}
				}
			);

			/* start - to set level bar width in case of text_dropdown fields for numeric value */
			$( '.level-bar-inner' ).css( 'width', '0' );
			$( '.level-bar-inner' ).each(
				function() {
					var itemWidth = 20 * $( this ).data( 'level' ) + '%';
					$( this ).animate(
						{
							width: itemWidth
						}, 800
					);
				}
			);
			/* end - to set level bar width in case of text_dropdown fields for numeric value */

			/*start to unwrap select elements extra div in buddyboss theme*/
			setTimeout(
				function () {
					if ( jQuery( 'select.inp-text' ).parent().hasClass( "buddyboss-select-inner" )) {
						jQuery( 'select.inp-text' ).prev().remove();
						jQuery( 'select.inp-text' ).unwrap();
						if ( jQuery( 'select.inp-text' ).parent().hasClass( "buddyboss-select" ) ) {
							jQuery( 'select.inp-text' ).unwrap();
						}
					}
				}, 1000
			);

			/*start to hide first remove repeater grp icon*/
			if ($( '.bprm-container.group-bprm_grp_prof_exprnc :first' )) {
				$( '.bprm-container.group-bprm_grp_prof_exprnc:first' ).find( '.bprm_remove_repeater_grp' ).hide();
			}
			if ($( '.bprm-container.group-bprm_grp_edu :first' )) {
				$( '.bprm-container.group-bprm_grp_edu:first' ).find( '.bprm_remove_repeater_grp' ).hide();
			}
			if( $( '.bprm-container:first' ).find( '.bprm_remove_repeater_grp' ) ){
				$( '.bprm-container:first' ).find( '.bprm_remove_repeater_grp' ).hide();
			}


			/*start to hide first remove repeater field icon*/
			if ($( '.bprm-field-inputs-wrap' )) {
				$( '.bprm-field-inputs-wrap' ).find( '.bprm-remove-repeater-field:first' ).hide();
			}

			// $("#bprm_resume_form input, #bprm_resume_form textarea, #bprm_resume_form select ").keyup(function(){
			// $( this ).nextAll('.bprm-empty-error:first').hide();
			// });
			$( "#bprm_resume_form" ).submit(
				function( event ) {
					// var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
					// var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
					var bprm_elmt = jQuery( this ).serializeArray();
					for (var x = 0; x < bprm_elmt.length; x++) {
						var name     = bprm_elmt[x].name;
						var hasClass = $( "input[name*='" + name + "'], textarea[name*='" + name + "'], select[name*='" + name + "']" ).hasClass( "bprm_req_field" );
						// if(name == 'wbbpp_userdata[bprm_email]'){
						// if(hasClass) {
						// var bprm_email = bprm_elmt[x].value;
						// if (!bprm_email.match(emailReg)) {
						// $('.invalid-email').show();
						// event.preventDefault();
						// }else{
						// $('.invalid-email').hide();
						// }
						// }
						// }
						// if(name == 'wbbpp_userdata[bprm_conctno]'){
						// var co_no = bprm_elmt[x].value;
						// if(hasClass) {
						// if (!co_no.match(phoneno)) {
						// $('.invalid-no').show();
						// event.preventDefault();
						// }else{
						// $('.invalid-no').hide();
						// }
						// }
						// }
						if (hasClass) {
							if (bprm_elmt[x].value == '' || bprm_elmt[x].value == '0') {
								$( '[name="' + name + '"]' ).nextAll( "p.bprm-empty-error:first" ).show();
								// $('[name="'+name+'"]').parent().find("p.bprm-empty-error:first").show();
							} else {
								if ( ! bprm_elmt[x].value == '' || ! bprm_elmt[x].value == '0') {
									$( '[name="' + name + '"]' ).nextAll( "p.bprm-empty-error:first" ).hide();
									// $('[name="'+name+'"]').parent().find("p.bprm-empty-error:first").hide();
								}
							}
						}
					}
					var query     = $( '.bprm-empty-error' );
					var isVisible = query.is( ':visible' );
					if (isVisible === true) {
						event.preventDefault();
						$( 'html, body' ).animate(
							{
								scrollTop: $( 'p.bprm-empty-error:visible:first' ).offset().top - 120
							}, 'slow'
						);
					} else {
						$( "#bprm_resume_form" ).unbind( 'submit' );
					}

				}
			);

		}
	);

	 /*start current school show hide condition 12dec*/
	$( document ).on(
		'click', 'input.bprms_curschol', function(){
			if ($( this ).is( ":checked" )) {
				$( this ).closest( '.bprm-bprms_curschol' ).siblings( '.bprm-bprms_yoc' ).find( "option:selected" ).removeAttr( "selected" );
				$( this ).closest( '.bprm-bprms_curschol' ).siblings( '.bprm-bprms_yoc' ).hide();
			} else {
				$( this ).closest( '.bprm-bprms_curschol' ).siblings( '.bprm-bprms_yoc' ).show();
			}
		}
	);
	 /*end current school show hide condition*/

	 /*start current school show hide condition 12dec*/
	$( document ).on(
		'click', 'input.bprm_curcomp', function(){
			if ($( this ).is( ":checked" )) {
				$( this ).closest( '.bprm-bprms_curschol' ).siblings( '.bprm-bprms_posto' ).find( "option:selected" ).removeAttr( "selected" );
				$( this ).closest( '.bprm-bprm_curcomp' ).siblings( '.bprm-bprms_posto' ).hide();
			} else {
				$( this ).closest( '.bprm-bprm_curcomp' ).siblings( '.bprm-bprms_posto' ).show();
			}
		}
	);
	 /*end current school show hide condition 12dec*/

	 /*start to add repeater fields*/
	$( document ).on(
		'click','.bprm-add-repeater-field',function(){
			var field_div = $( this ).data( 'id' );
			var f_name    = $( this ).data( 'fname' );

			if ($( '.' + field_div ).hasClass( 'bprm_intrst' )) {
				$( '.bprm_intrst .inp-text' ).each(
					function(){ // do this for every select with the 'combobox' class
						if ($( this )[0].selectize) { // requires [0] to select the proper object
							var value = $( this ).val(); // store the current value of the select/input
							$( this )[0].selectize.destroy(); // destroys selectize()
							$( this ).val( value );  // set back the value of the select/input
						}
					}
				);
			}

			var clonedObj = $( this ).parent().siblings( '.' + field_div + ':first' ).clone().insertAfter( $( this ).parent().siblings( '.' + field_div + ':last' ) );
			var groups    = $( this ).parent().siblings( '.' + field_div );
			clonedObj.find( 'input:text' ).each(
				function(){
					this.value = '';
				}
			);
			clonedObj.find( 'input' ).each(
				function(){
					this.value = '';
				}
			);
			clonedObj.find( 'input:file' ).each(
				function(){
					clonedObj.find('.bprm-image-type-span').remove();
				}
			);
			clonedObj.find( 'textarea' ).each(
				function(){
					this.value = '';
				}
			);
			clonedObj.find( ':checkbox' ).each(
				function(){
					$( this ).attr( 'checked', false );
				}
			);
			clonedObj.find( "option:selected" ).removeAttr( "selected" );

			if (clonedObj.hasClass( 'text-dropdown' )) {
				update_TD_RepeaterFieldsName( field_div, f_name, groups );
			} else {
				updateRepeaterFieldsName( field_div, f_name, groups );
			}

			if (clonedObj.hasClass( 'bprm_intrst' )) {
				update_Selectize( clonedObj );
			}

			if (clonedObj.find( 'input' ).hasClass( 'bprm-calender' )) {
				clonedObj.find( 'input.bprm-calender' ).each(
					function(){
						$( this ).removeAttr( 'id' ).removeClass( 'hasDatepicker' );
						$( this ).datepicker(
							{
								changeMonth: true,
								changeYear: true,
								yearRange: "-100:+0"
							}
						);
					}
				);
			}

			if ($( '.bprm-field-inputs-wrap' )) {
				$( '.bprm-field-inputs-wrap' ).find( '.bprm-remove-repeater-field:not(:first)' ).show();
			}
		}
	);

	function update_Selectize(clonedObj){
		$( '.bprm_intrst .inp-text' ).selectize(
			{
				delimiter: ',',
				persist: false,
				create: function(input) {
					return {
						value: input,
						text: input
					}
				}
			}
		);
	}

	 /*function to update last index in repeater fields name*/
	function updateRepeaterFieldsName(field_div, f_name, groups){
		var field_groups = $( '.' + field_div );
		groups.each(
			function(index) {
				var prefix = f_name + '[' + index + ']';
				$( this ).find( "input" ).each(
					function() {
						if (this.type == 'checkbox') {
							var chk_prefix = f_name + '[' + index + '][]';
							this.name      = this.name.replace( this.name, chk_prefix );
						} else {
							this.name = this.name.replace( this.name, prefix );
						}
					}
				);
				$( this ).find( "textarea" ).each(
					function(){
						this.name = this.name.replace( this.name, prefix );
					}
				);
				$( this ).find( "select" ).each(
					function(){
						this.name = this.name.replace( this.name, prefix );
					}
				);
				if ($( this ).hasClass( 'bprm-auto-complete' )) {
					field_groups.find( 'input.bprm-wautocomplete[type="text"]' ).each(
						function(indexs){
							$( this ).attr( 'id',"bprm-wautocomplete-" + indexs );
							initialize();
						}
					);
				}
			}
		);
	}

	function update_TD_RepeaterFieldsName(field_div, f_name){
		var field_groups = $( '.' + field_div );
		field_groups.each(
			function(index) {
				$( this ).find( "input" ).each(
					function() {
						var inp_prefix = f_name + '[' + index + '][text]';
						this.name      = this.name.replace( this.name, inp_prefix );
					}
				);
				$( this ).find( "select" ).each(
					function(){
						var dd_prefix = f_name + '[' + index + '][dropdown_val]';
						this.name     = this.name.replace( this.name, dd_prefix );
					}
				);
			}
		);
	}

	$( document ).on(
		'click','.bprm_add_repeater_grp', function(){
			var g_name  = $( this ).data( 'gname' );
			var g_group = $( this ).data( 'group' );
			var g_regrp = $( this ).data( 'regrp' );

			$( '.bprm_intrst .inp-text' ).each(
				function(){ // do this for every select with the 'combobox' class
					if ($( this )[0].selectize) { // requires [0] to select the proper object
						var value = $( this ).val(); // store the current value of the select/input
						$( this )[0].selectize.destroy(); // destroys selectize()
						$( this ).val( value );  // set back the value of the select/input
					}
				}
			);

			var clonedObj = $( this ).siblings( '.bprm-container:first' ).clone().insertAfter( $( this ).siblings( '.bprm-container:last' ) );

			clonedObj.find( 'input:text' ).each(
				function(){
					this.value = '';
				}
			);
			clonedObj.find( 'input' ).each(
				function(){
					this.value = '';
				}
			);
			clonedObj.find( 'input:file' ).each(
				function(){
					clonedObj.find('.bprm-image-type-span').remove();
				}
			);
			clonedObj.find( ':checkbox' ).each(
				function(){
					$( this ).attr( 'checked', false );
				}
			);
			clonedObj.find( 'textarea' ).each(
				function(){
					this.value = '';
				}
			);
			clonedObj.find( '.bprm-bprms_yoc' ).show();
			clonedObj.find( '.bprm-bprms_posto' ).show();

			update_group_index( g_name,g_group,g_regrp );

			$( '.bprm_intrst .inp-text' ).selectize(
				{
					delimiter: ',',
					persist: false,
					create: function(input) {
						return {
							value: input,
							text: input
						}
					}
				}
			);

			if ($( '.bprm-container.group-bprm_grp_prof_exprnc:not(:first)' )) {
				$( '.bprm-container.group-bprm_grp_prof_exprnc:not(:first)' ).find( '.bprm_remove_repeater_grp' ).show();
			}
			if ($( '.bprm-container.group-bprm_grp_edu:not(:first)' )) {
				$( '.bprm-container.group-bprm_grp_edu:not(:first)' ).find( '.bprm_remove_repeater_grp' ).show();
			}
		}
	);

	$( document ).on(
		'click','.bprm_remove_repeater_grp', function(){
			var g_name  = $( this ).data( 'gname' );
			var g_group = $( this ).data( 'group' );
			var g_regrp = $( this ).data( 'regrp' );

			$( this ).closest( 'div.' + g_name ).remove();
			update_group_index( g_name,g_group,g_regrp );
		}
	);

	function update_group_index(g_name,g_group,g_regrp){
		var repeater_groups = $( '.' + g_name );
		repeater_groups.each(
			function(index) {
				$( this ).find( "input" ).each(
					function() {
						this.name = this.name.replace( '[' + g_group + '][0]' , '[' + g_group + ']' + '[' + index + ']' );
					}
				);
				$( this ).find( "textarea" ).each(
					function() {
						this.name = this.name.replace( '[' + g_group + '][0]' , '[' + g_group + ']' + '[' + index + ']' );
					}
				);
				$( this ).find( "select" ).each(
					function(){
						this.name = this.name.replace( '[' + g_group + '][0]' , '[' + g_group + ']' + '[' + index + ']' );
					}
				);
			}
		);
		repeater_groups.find( 'input.bprm-wautocomplete[type="text"]' ).each(
			function(indexs){
				$( this ).attr( 'id',"bprm-wautocomplete-" + indexs );
				initialize();
			}
		);
		repeater_groups.find( 'input.bprm-calender' ).each(
			function(){
				$( this ).removeAttr( 'id' ).removeClass( 'hasDatepicker' );
				$( this ).datepicker(
					{
						changeMonth: true,
						changeYear: true,
						yearRange: "-100:+0"
					}
				);
			}
		);
	}

	$( document ).on(
		'click','.bprm-remove-repeater-field',function(){
			var field_div = $( this ).data( 'id' );
			var f_name    = $( this ).data( 'fname' );
			var groups    = $( this ).parent().parent().siblings( '.' + field_div );

			$( this ).parent( 'div.' + field_div ).remove();
			updateRepeaterFieldsName( field_div, f_name, groups );
		}
	);
})( jQuery );
