/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery( document ).ready( function( $ ) {
    
    //rtmedia_lightbox_enabled from setting
    if( typeof( rtmedia_lightbox_enabled ) != 'undefined' && rtmedia_lightbox_enabled == "1" ) {
        apply_rtMagnificPopup( '.widget-item-listing' );
    }
    
} );
