jQuery(function(){
    setTimeout(function(){
        jQuery('#_job_expires').datepicker( "option", "dateFormat", 'dd/mm/yy' );
    },2000);

    if (window.parent) {
        jQuery('.components-notice.is-success a').attr('target', '_parent');
    }
});