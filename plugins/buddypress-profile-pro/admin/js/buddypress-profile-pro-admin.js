(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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

	jQuery( document ).ready(
		function(){

			var new_field_form = $( '.bprm-add-new-form-container' ).html();

			$( 'ul.bprm-tabs li' ).click(
				function(){
					var tab_id = $( this ).attr( 'data-tab' );

					$( 'ul.bprm-tabs li' ).removeClass( 'current' );
					$( '.bprm-tab-content' ).removeClass( 'current' );

					$( this ).addClass( 'current' );
					$( "#" + tab_id ).addClass( 'current' );
				}
			);

			/*support tab accordion*/
			var bprm_elmt = document.getElementsByClassName( "bprm-accordion" );
			var k;
			var bprm_elmt_len = bprm_elmt.length;
			for (k = 0; k < bprm_elmt_len; k++) {
				bprm_elmt[k].onclick = function() {
					this.classList.toggle( "active" );
					var panel = this.nextElementSibling;
					if (panel.style.maxHeight) {
						panel.style.maxHeight = null;
					} else {
						panel.style.maxHeight = panel.scrollHeight + "px";
					}
				}
			}

			/*group field accordion*/
			var bprm_grp_elmt     = document.getElementsByClassName( "bprm-group-tabs-link" );
			var bprm_grp_elmt_len = bprm_grp_elmt.length;
			var k;
			for (k = 0; k < bprm_grp_elmt_len; k++) {
				bprm_grp_elmt[k].onclick = function() {
					this.classList.toggle( "active" );
					var panel = this.nextElementSibling;
					$( panel ).slideToggle( 500 );
				}
			}

			/*cancel new field toggle*/
			$( '.bprm-cancel-new-field-link' ).click(
				function(){
					$( '.bprm-add-new-form-container' ).html( new_field_form );
				}
			);
			$( '.bprm-cancel-new-group-link' ).click(
				function(){
					$( '.bprm-add-new-form-container' ).html( new_field_form );
				}
			);
			
			$(document).on('change', '#bprm_nf_type', function() {
				var bprm_fields_type = $( this ).find( ":selected" ).val();
				if (bprm_fields_type == 'dropdown' || bprm_fields_type == 'checkbox' || bprm_fields_type == 'radio_button' || bprm_fields_type == 'text_dropdown' ) {
					$( '.bprm-nf-loader' ).show();
					wbbpp_get_fieldsType( bprm_fields_type );
				} else {
					$( '.bprm-field-type-html' ).html( '' );
				}

				/* code to hide first remove option */
				setInterval(
					function(){
						if ($( '.bprm-get-field-type-html:first' )) {
							$( '.bprm-get-field-type-html:first' ).find( '.bprm-remove-option' ).hide();
						}
						if ($( '.bprm-get-field-type-html:not(:first)' )) {
							$( '.bprm-get-field-type-html:not(:first)' ).find( '.bprm-remove-option' ).show();
						}
					},50
				);
			});

			$( '#bprm_nf_group' ).change(
				function(){
					var bprm_fields_grps = $( this ).find( ":selected" ).val();
					if ( bprm_fields_grps == 'bprm_grp_others') {
						$( this ).closest( 'tr' ).nextAll( 'tr.bprm_field_section_title , tr.bprm_apprnc_section_field, tr.bprm_field_section_icon' ).show();
					} else {
						$( this ).closest( 'tr' ).nextAll( 'tr.bprm_field_section_title , tr.bprm_apprnc_section_field, tr.bprm_field_section_icon' ).hide();
						$( this ).closest( 'tr' ).nextAll( 'tr.bprm_field_section_title , tr.bprm_apprnc_section_field, tr.bprm_field_section_icon' ).find( 'input:text' ).each(
							function(){
								this.value = '';
							}
						);
					}
				}
			);

			function wbbpp_get_fieldsType(bprm_fields_type){
				var data = {
					'action': 'wbbpp_new_field_type_html',
					'ftype': bprm_fields_type,
					'ajax_nonce': bprm_admin_ajax_object.ajax_nonce
				};
				$.post(
					bprm_admin_ajax_object.ajax_url, data, function ( response ) {
						$( '.bprm-nf-loader' ).hide();
						$( '.bprm-field-type-html' ).html( response );
					}
				);
			}

			/*bprm register settings section field type change event*/
			$( document ).on(
				'change', '.bprm_rs_type_change', function () {
					var field_type      = $( this ).find( ":selected" ).val();
					var field_name_type = $( this ).attr( "name" );
					var field_name      = field_name_type.replace( '[type]','[options][]' );
					var rs_typ_chng_evt = $( this );
					if (field_type == 'dropdown' || field_type == 'checkbox' || field_type == 'radio_button' || field_type == 'text_dropdown') {
						$( '.bprm-onchange-type-loader' ).show();
						bprm_rs_type_field_options_html( field_type,field_name,rs_typ_chng_evt );

						/* code to hide first remove option */
						setInterval(
							function(){
								if ($( '.bprm-fld-existing-optn-html.bprm-fld-option-html:first' )) {
									$( '.bprm-fld-existing-optn-html .bprm-fld-option-html:first' ).find( '.bprm-remove-option' ).hide();
								}
								if ($( '.bprm-fld-existing-optn-html.bprm-fld-option-html:not(:first)' )) {
									$( '.bprm-fld-existing-optn-html.bprm-fld-option-html:not(:first)' ).find( '.bprm-remove-option' ).show();
								}
							},50
						);
					} else {
						rs_typ_chng_evt.closest( 'tr' ).next( 'tr.bprm_rs_type_change_options_html' ).html( '' );
						rs_typ_chng_evt.closest( 'tr' ).nextAll( 'tr.bprm-fld-existing-optn-html' ).html( '' );
					}
				}
			);

			/*function to set resume field options on field*/
			function bprm_rs_type_field_options_html(field_type,field_name,rs_typ_chng_evt){
				var data = {
					'action': 'wbbpp_setting_form_fld_typ_html',
					'ftype': field_type,
					'fname': field_name,
					'ajax_nonce': bprm_admin_ajax_object.ajax_nonce
				};
				$.post(
					bprm_admin_ajax_object.ajax_url, data, function ( response ) {
						$( '.bprm-onchange-type-loader' ).hide();
						rs_typ_chng_evt.closest( 'tr' ).next( 'tr.bprm_rs_type_change_options_html' ).html( response );
						rs_typ_chng_evt.closest( 'tr' ).nextAll( 'tr.bprm-fld-existing-optn-html' ).html( '' );
					}
				);
			}

			/*function to add new field option*/
			$( document ).on(
				'click', '.bprm-add-option', function () {

					var flag     = false;
					var add_div  = $( this ).data( 'id' );
					var last_div = $( this ).closest( '.' + add_div );

					var options_div = $( this ).closest( 'tr' ).find( '.' + add_div );
					options_div.find( 'input:text' ).each(
						function(){
							if (this.value == '') {
								flag = true;
								$( this ).addClass( 'border-alert' );
							} else {
								$( this ).removeClass( 'border-alert' );
							}
						}
					);

					if ( ! flag) {
						var clonedObj = $( this ).closest( '.' + add_div ).clone().insertAfter( last_div );
						clonedObj.find( 'input:text' ).each(
							function(){
								this.value = '';
							}
						);
					}
				}
			);

			/*function to remove new field option field*/
			$( document ).on(
				'click', '.bprm-remove-option', function () {
					var del_div = $( this ).data( 'id' );
					$( this ).closest( 'div.' + del_div ).remove();
				}
			);

			/*function to change jquery tab title on changing text*/
			$( ".bprm-field-title-text" ).on(
				'change keyup paste', function() {
					var field_title = $( this ).val();
					$( this ).parents( 'li' ).find( 'span.bprm-tab-field-title' ).text( field_title );
				}
			);

			/*function to change jquery group tab title on changing text*/
			$( ".bprm-group-title-text" ).on(
				'change keyup paste', function() {
					var group_title = $( this ).val();
					$( this ).parents( '.bprm-group-tab-link-container' ).find( 'span.brpm_grp_name' ).text( group_title );
				}
			);

			/*save new field ajax in add new field form*/
			$( document ).on(
				'click', '.wbbpp_save_new_field', function () {

					var anchor_obj  = $( this );
					var anchor_text = $( this ).html();
					var loader_text = 'Please wait <i class="fa fa-refresh fa-spin fa-fw bprm-anchor-loader"></i>';

					var nf_field_data = $( '#bprm-add-new-form' ).serialize();
					var nf_elmt       = $( '#bprm-add-new-form' ).serializeArray();
					var nf_flag       = false;
					var nf_elmt_len   = nf_elmt.length;
					for (var x = 0; x < nf_elmt_len; x++) {
						var name = nf_elmt[x].name;
						if (name == 'bprm_nf_title' || name == 'bprm_nf_type' || name == 'bprm_nf_group') {
							if (nf_elmt[x].value == '' || nf_elmt[x].value == '0') {
								$( '[name="' + name + '"]' ).siblings( ".bprm_nf_error:first" ).show();
								$( '[name="' + name + '"]' ).addClass( "border-alert" );
								$( 'html, body' ).animate(
									{
										scrollTop: $( '.bprm_nf_error:visible:first' ).offset().top - 120
									}, 'slow'
								);
							} else {
								if ( ! nf_elmt[x].value == '' || ! nf_elmt[x].value == '0') {
									$( '[name="' + name + '"]' ).siblings( ".bprm_nf_error:first" ).hide();
									$( '[name="' + name + '"]' ).removeClass( "border-alert" );
								}
							}
						}
					}

					var query     = $( '.bprm_nf_error' );
					var isVisible = query.is( ':visible' );
					if (isVisible === true) {
						nf_flag = false;
					} else {
						nf_flag = true;
					}

					var bprm_nf_group = $( '#bprm_nf_group' ).val();
					var data          = {
						'action': 'wbbpp_save_new_field',
						'data': nf_field_data,
						'ajax_nonce': bprm_admin_ajax_object.ajax_nonce
					};

					if (nf_flag) {
						anchor_obj.html( loader_text );
						$.post(
							bprm_admin_ajax_object.ajax_url, data, function ( response ) {
								$( '#' + bprm_nf_group ).append( response );
								var grp_obj = $( '#' + bprm_nf_group ).parent();
								var grp_tab = $( '#' + bprm_nf_group ).parent().siblings( '.bprm-group-tabs-link' );

								if ( ! grp_obj.is( ':visible' )) {
									grp_obj.slideDown( 500 );
									grp_tab.addClass( 'active' );
								}
								$( 'html, body' ).animate(
									{
										scrollTop: grp_obj.parent().offset().top - 120
									}, 'slow'
								);
							}
						);
						/*reset add new form*/
						$( '.bprm-add-new-form-container' ).html( new_field_form );
						anchor_obj.html( anchor_text );
					}

				}
			);

			/*save new field ajax in add new field form*/
			$( document ).on(
				'click', '.wbbpp_save_new_group', function () {

					var anchor_obj  = $( this );
					var anchor_text = $( this ).html();
					var loader_text = 'Please wait <i class="fa fa-refresh fa-spin fa-fw bprm-anchor-loader"></i>';

					var nf_field_data = $( '#bprm-add-new-group-form' ).serialize();
					var nf_elmt       = $( '#bprm-add-new-group-form' ).serializeArray();
					var nf_flag       = false;
					var nf_elmt_len   = nf_elmt.length;
					for (var x = 0; x < nf_elmt_len; x++) {
						var name = nf_elmt[x].name;
						if (name == 'bprm_gp_title' || name == 'bprm_gp_desc') {
							if (nf_elmt[x].value == '' || nf_elmt[x].value == '0') {
								$( '[name="' + name + '"]' ).siblings( ".bprm_gp_error:first" ).show();
								$( '[name="' + name + '"]' ).addClass( "border-alert" );
								$( 'html, body' ).animate(
									{
										scrollTop: $( '.bprm_gp_error:visible:first' ).offset().top - 120
									}, 'slow'
								);
							} else {
								if ( ! nf_elmt[x].value == '' || ! nf_elmt[x].value == '0') {
									$( '[name="' + name + '"]' ).siblings( ".bprm_gp_error:first" ).hide();
									$( '[name="' + name + '"]' ).removeClass( "border-alert" );
								}
							}
						}
					}

					var query     = $( '.bprm_gp_error' );
					var isVisible = query.is( ':visible' );
					if (isVisible === true) {
						nf_flag = false;
					} else {
						nf_flag = true;
					}

					var bprm_nf_group = $( '#bprm_nf_group' ).val();
					var data          = {
						'action': 'wbbpp_save_new_group',
						'data': nf_field_data,
						'ajax_nonce': bprm_admin_ajax_object.ajax_nonce
					};

					if (nf_flag) {
						anchor_obj.html( loader_text );
						$.post(
							bprm_admin_ajax_object.ajax_url, data, function ( response ) {
								var obj = $( '.bprm-group-tabs' ).append( response );
								obj.find( '.bprm-group-tabs-content:last' ).slideDown(500);
								$( 'html, body' ).animate(
									{
										scrollTop: obj.find( '.bprm-group-tabs-content:last' ).offset().top - 120
									}, 'slow'
								);
							}
						);
						/*reset add new form*/
						$( '.bprm-add-new-form-container' ).html( new_field_form );
						anchor_obj.html( anchor_text );
					}

				}
			);

			$( document ).on(
				'click','.bprm-show-field-zone', function(){
					$( this ).parents( 'li' ).find( '.bprm-field-zone' ).slideToggle( 500 );
					/*code to hide first remove option*/
					var obj = $( this ).parents( 'li' );
					setInterval(
						function(){
							obj.find( '.bprm-fld-option-html:first' ).find( '.bprm-remove-option' ).hide();
							obj.find( '.bprm-fld-option-html:not(:first)' ).find( '.bprm-remove-option' ).show();
						},50
					);

				}
			);

			$( document ).on(
				'click','.bprm-show-group-zone', function(){
					$( this ).parents( '.bprm-group-tab-link-container' ).find( '.bprm-group-tabs-content' ).slideToggle( 500 );
				}
			);

			/*Function to delete field.*/
			$( document ).on(
				'click','.bprm-remove-field-zone', function(){
					var c = confirm( "This field will be deleted." );
					if (c) {
						$( this ).parents( 'li' ).remove();
					}
					return c;
				}
			);
			$( document ).on(
				'click','.bprm-remove-group-zone', function(){
					var c = confirm( "This group will be deleted." );
					if (c) {
						$( this ).parents('.bprm-group-tab-link-container').remove();
					}
					return c;
				}
			);

			$(
				function() {
					$( ".ui-sortable" ).sortable();
					$( ".ui-sortable" ).disableSelection();
				}
			);
			$(
				function() {
					$( ".bprm-group-tabs" ).sortable();
					$( ".bprm-group-tabs" ).disableSelection();
				}
			);
			
		}
	);
})( jQuery );
