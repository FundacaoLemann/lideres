jQuery(function ($) {

    var custom_css = '';

    $('.lvca-gallery-carousel').each(function () {

        var gallery_carousel = $(this);

        var id_selector = '#' + gallery_carousel.attr('id');

        var settings = gallery_carousel.data('settings');

        custom_css += id_selector + '.lvca-gallery-carousel .lvca-gallery-carousel-item { padding: ' + settings['gutter'] + 'px; }';

        custom_css += '@media screen and (max-width: ' + settings['tablet_width'] + 'px) {';

        custom_css += id_selector + '.lvca-gallery-carousel .lvca-gallery-carousel-item { padding: ' + settings['tablet_gutter'] + 'px; }';

        custom_css += '}';

        custom_css += '@media screen and (max-width: ' + settings['mobile_width'] + 'px) {';

        custom_css += id_selector + '.lvca-gallery-carousel .lvca-gallery-carousel-item { padding: ' + settings['mobile_gutter'] + 'px; }';

        custom_css += '}';

    });

    if (custom_css !== '') {
        var inline_css = '<style type="text/css">' + custom_css + '</style>';
        $('head').append(inline_css);
    }

    if ($().fancybox === undefined) {
        return;
    }

    $('.lvca-gallery-carousel').each(function () {

        /* ----------------- Lightbox Support ------------------ */

        $(this).fancybox({
            selector: '.lvca-gallery-carousel-item:not(.slick-cloned) a.lvca-lightbox-item,.lvca-gallery-carousel-item:not(.slick-cloned) a.lvca-video-lightbox', // the selector for gallery item
            loop: true,
            buttons: [
                "zoom",
                "share",
                "slideShow",
                "fullScreen",
                //"download",
                "thumbs",
                "close"
            ],
            caption: function (instance, item) {

                var caption = $(this).attr('title') || '';

                var description = $(this).data('description') || '';

                if (description !== '') {
                    caption += '<div class="lvca-fancybox-description">' + description + '</div>';
                }

                return caption;
            }
        });

    });


});