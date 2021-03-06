jQuery(function ($) {

    $('.lvca-icon-list .lvca-icon-list-item').powerTip({
        placement: 'n' // north-east tooltip position
    });

    var custom_css = '';

    $('.lvca-icon-list').each(function () {

        var icon_list = $(this);

        var settings = icon_list.data('settings'); // parses the json automatically

        /* --------------- Custom CSS ------------------ */

        var id_selector = '#' + icon_list.attr('id');

        custom_css += id_selector + '.lvca-icon-list .lvca-icon-list-item .lvca-image-wrapper img { width:' + settings.icon_size + 'px; }';

        custom_css += id_selector + '.lvca-icon-list .lvca-icon-list-item .lvca-icon-wrapper span { font-size:' + settings.icon_size + 'px; color:' + settings.icon_color + '; }';

        custom_css += id_selector + '.lvca-icon-list .lvca-icon-list-item .lvca-icon-wrapper span:hover { color:' + settings.hover_color + '; }';

    });

    if (custom_css != '') {
        var inline_css = '<style type="text/css">' + custom_css + '</style>';
        $('head').append(inline_css);
    }


});