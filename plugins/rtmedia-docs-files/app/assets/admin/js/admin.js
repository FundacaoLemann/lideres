/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery( document ).ready( function() {

    jQuery( '.rtmedia-settings-submit' ).on( "click", function( e ) {
        //e.preventDefault();
        if( jQuery( '.rtm_allow_other_upload input[type=checkbox]' ).is( ":checked" ) ) {
	        var otherExtensions = jQuery( '#rtm_other_extensions' );
	        if( !otherExtensions.prop( 'read-only' ) && jQuery.trim( otherExtensions.val() ) == "" ) {
	            alert( rtmedia_empty_extension_msg );
	            return false;
	        }

	        var regex = /^[a-zA-Z0-9, ]*$/;

	        if( !otherExtensions.prop( 'read-only' ) && !regex.test( otherExtensions.val() ) ) {
	            alert( rtmedia_invalid_extension_msg );

	            return false;
	        }
    	}
        //jQuery( this ).closest( 'form' ).submit();
    } );

    if( !jQuery( '.rtm_allow_other_upload input[type=checkbox]' ).is( ":checked" ) ) {
        jQuery( "#rtmedia-other-types-warning" ).css( "display", 'none' );
        jQuery( "#rtm_other_extensions" ).attr( "read-only", true );
    }

    jQuery( '.rtm_allow_other_upload input[type=checkbox]' ).on( "click", function( e ) {
        if( jQuery( this ).is( ":checked" ) ) {
            jQuery( "#rtm_other_extensions" ).prop( "read-only", false );
            jQuery( "#rtmedia-other-types-warning" ).css( "display", 'block' );
        } else {
            jQuery( "#rtm_other_extensions" ).prop( "read-only", true );
            jQuery( "#rtmedia-other-types-warning" ).css( "display", 'none' );
        }
    } );

} );
