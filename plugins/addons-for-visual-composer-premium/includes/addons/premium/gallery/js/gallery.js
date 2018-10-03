jQuery(function ($) {


    var LVCA_Gallery_Helper = function ($element) {

        this._gallery = $element;

    };

    LVCA_Gallery_Helper.prototype = {

        _gallery: null,

        getItemsToDisplay: function (items, paged, items_per_page) {

            var start = items_per_page * (paged - 1);

            var end = start + items_per_page;

            // send only the relevant items
            items = items.slice(start, end);

            return items;

        },

        // Manage page number display so that it does not get too long with too many page numbers displayed
        processNumberedPagination: function () {

            var maxpages = parseInt(this._gallery.data('maxpages'));

            var currentPage = parseInt(this._gallery.attr('data-current'));

            // Remove all existing dotted navigation elements
            this._gallery.find('.lvca-page-nav.lvca-dotted').remove();

            // proceed only if there are too many pages to display navigation for
            if (maxpages > 5) {

                var beenHiding = false;

                this._gallery.find('.lvca-page-nav.lvca-numbered').each(function () {

                    var page = $(this).attr('data-page'); // can return next and prev too

                    var pageNum = parseInt(page);

                    // Deal with only those pages between 1 and maxpages
                    if (pageNum > 1 && pageNum <= maxpages) {

                        var $navElement = $(this);

                        if (pageNum == currentPage || (pageNum == currentPage - 1) || (pageNum == currentPage + 1) || (pageNum == currentPage + 2)) {

                            if (beenHiding)
                                $('<a class="lvca-page-nav lvca-dotted" href="#" data-page="">...</a>').insertBefore($navElement);

                            $navElement.show();

                            beenHiding = false;
                        }
                        else if (pageNum == maxpages) {

                            if (beenHiding)
                                $('<a class="lvca-page-nav lvca-dotted" href="#" data-page="">...</a>').insertBefore($navElement);

                            beenHiding = false; // redundant for now
                        }
                        else {

                            $navElement.hide();

                            beenHiding = true;
                        }
                    }
                });
            }
        },
    };
    if ($().isotope === undefined) {
        return;
    }

    var custom_css = '';

    $('.lvca-gallery-wrap').each(function () {

        var container = $(this).find('.lvca-gallery:first');
        if (container.length === 0) {
            return; // no items to filter or load and hence don't continue
        }

        var $parent = $(this),
            settings = $parent.data('settings'),
            items = $parent.data('items'),
            maxpages = parseInt($parent.data('maxpages'));

        var gallery_helper = new LVCA_Gallery_Helper($(this));

        // layout Isotope after all images have loaded
        var htmlContent = $(this).find('.js-isotope:first');

        var isotopeOptions = htmlContent.data('isotope-options');

        htmlContent.isotope({
            // options
            itemSelector: isotopeOptions['itemSelector'],
            layoutMode: isotopeOptions['layoutMode'],
            transitionDuration: '0.8s',
            masonry: {
                columnWidth: '.lvca-grid-sizer'
            }
        });

        htmlContent.imagesLoaded(function () {
            htmlContent.isotope('layout');
        });

        // Relayout on inline full screen video and back
        $(document).on('webkitfullscreenchange mozfullscreenchange fullscreenchange',function(e){
            htmlContent.isotope('layout');
        });

        // Hide a few page links with dotted navigation f the number of page links crosses a certain threshold
        if (settings["pagination"] == 'paged')
            gallery_helper.processNumberedPagination();

        /* -------------- Taxonomy Filter --------------- */

        $(this).find('.lvca-taxonomy-filter .lvca-filter-item a').on('click', function (e) {
            e.preventDefault();

            var selector = $(this).attr('data-value');
            container.isotope({filter: selector});
            $(this).closest('.lvca-taxonomy-filter').children().removeClass('lvca-active');
            $(this).closest('.lvca-filter-item').addClass('lvca-active');
            return false;
        });

        /* ------------------- Pagination ---------------------- */

        $(this).find('.lvca-pagination a.lvca-page-nav').on('click', function (e) {
            e.preventDefault();

            var $this = $(this),
                paged = $this.attr('data-page'),
                current = parseInt($parent.attr('data-current'));

            // Do not continue if already processing or if the page is currently being shown
            if ($this.is('.lvca-current-page') || $parent.is('.lvca-processing'))
                return;

            if (paged == 'prev') {
                if (current <= 1)
                    return;
                paged = current - 1;
            }
            else if (paged == 'next') {
                if (current >= maxpages)
                    return;
                paged = current + 1;
            }

            var items_per_page = parseInt(settings["items_per_page"]);

            var display_items = gallery_helper.getItemsToDisplay(items, paged, items_per_page);

            $parent.addClass('lvca-processing');

            var data = {
                'action': 'lvca_load_gallery_items',
                'settings': settings,
                'items': display_items,
                'paged': paged
            };
            // We can also pass the url value separately from ajaxurl for front end AJAX implementations
            $.post(lvca_ajax_object.ajax_url, data, function (response) {

                var $grid = $parent.find('.lvca-gallery:first');

                var $existing_items = $grid.children('.lvca-gallery-item');

                $grid.isotope('remove', $existing_items);

                var $response = $('<div></div>').html(response);

                $response.imagesLoaded(function () {

                    var $new_items = $response.children('.lvca-gallery-item');

                    $grid.isotope('insert', $new_items);
                });

                // Set attributes of DOM elements based on page loaded
                $parent.attr('data-current', paged);

                $parent.data('current', paged);

                $this.siblings('.lvca-current-page').removeClass('lvca-current-page');

                $parent.find('.lvca-page-nav[data-page="' + parseInt(paged) + '"]').addClass('lvca-current-page');

                // Once the current page is set, process the pagination links for dotted links
                gallery_helper.processNumberedPagination();

                $parent.find('.lvca-page-nav[data-page="next"]').removeClass('lvca-disabled');
                $parent.find('.lvca-page-nav[data-page="prev"]').removeClass('lvca-disabled');

                if (paged <= 1)
                    $parent.find('.lvca-page-nav[data-page="prev"]').addClass('lvca-disabled');
                else if (paged >= maxpages)
                    $parent.find('.lvca-page-nav[data-page="next"]').addClass('lvca-disabled');

                $parent.removeClass('lvca-processing');
            });

        });


        /*---------------- Load More Button --------------------- */

        $(this).find('.lvca-pagination a.lvca-load-more').on('click', function (e) {
            e.preventDefault();

            var $this = $(this),
                current = parseInt($parent.attr('data-current')),
                total = $parent.data('total');

            if (current >= maxpages || $parent.is('.lvca-processing'))
                return;

            $parent.addClass('lvca-processing');

            var paged = current + 1;

            var items_per_page = parseInt(settings["items_per_page"]);

            var display_items = gallery_helper.getItemsToDisplay(items, paged, items_per_page);

            var data = {
                'action': 'lvca_load_gallery_items',
                'settings': settings,
                'items': display_items,
                'paged': paged
            };

            // We can also pass the url value separately from ajaxurl for front end AJAX implementations
            $.post(lvca_ajax_object.ajax_url, data, function (response) {

                var $grid = $parent.find('.lvca-gallery:first');

                var $response = $('<div></div>').html(response);

                $response.imagesLoaded(function () {

                    var $new_items = $response.children('.lvca-gallery-item');

                    $grid.isotope('insert', $new_items);

                });

                $parent.attr('data-current', paged);

                // Set remaining posts to be loaded and hide the button if we just loaded the last page
                if (settings['show_remaining']) {
                    if (paged == maxpages) {
                        $this.find('span').text(0);
                    }
                    else {
                        var remaining = total - (paged * settings['items_per_page']);
                        $this.find('span').text(remaining);
                    }
                }

                if (paged == maxpages)
                    $this.addClass('lvca-disabled');

                $parent.removeClass('lvca-processing');
            });

        });

        /* ----------------- Lightbox Support ------------------ */

        $(this).fancybox({
            selector: 'a.lvca-lightbox-item, a.lvca-video-lightbox', // the selector for gallery item
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


        /* --------------- Custom CSS ------------------ */

        var settings = $(this).data('settings');

        var element_id = $(this).children('.lvca-gallery').eq(0).attr('id');
        var id_selector = '#' + element_id;

        custom_css += id_selector + '.lvca-gallery { margin-left: -' + settings['gutter'] + 'px; margin-right: -' + settings['gutter'] + 'px; }';

        custom_css += '@media screen and (max-width: ' + settings['tablet_width'] + 'px) {';

        custom_css += id_selector + '.lvca-gallery { margin-left: -' + settings['tablet_gutter'] + 'px; margin-right: -' + settings['tablet_gutter'] + 'px; }';

        custom_css += '}';

        custom_css += '@media screen and (max-width: ' + settings['mobile_width'] + 'px) {';

        custom_css += id_selector + '.lvca-gallery { margin-left: -' + settings['mobile_gutter'] + 'px; margin-right: -' + settings['mobile_gutter'] + 'px; }';

        custom_css += '}';


        custom_css += id_selector + '.lvca-gallery .lvca-gallery-item { padding: ' + settings['gutter'] + 'px; }';

        custom_css += '@media screen and (max-width: ' + settings['tablet_width'] + 'px) {';

        custom_css += id_selector + '.lvca-gallery .lvca-gallery-item { padding: ' + settings['tablet_gutter'] + 'px; }';

        custom_css += '}';

        custom_css += '@media screen and (max-width: ' + settings['mobile_width'] + 'px) {';

        custom_css += id_selector + '.lvca-gallery .lvca-gallery-item { padding: ' + settings['mobile_gutter'] + 'px; }';

        custom_css += '}';


    });

    if (custom_css !== '') {
        var inline_css = '<style type="text/css">' + custom_css + '</style>';
        $('head').append(inline_css);
    }


});