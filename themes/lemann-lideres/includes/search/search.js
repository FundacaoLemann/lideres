(function($){
    $(function(){
        var $searchform = $('.searchform input');
        $searchform.attr('autocomplete', "off");

        $searchform.each(function(){
            var $this = $(this);
            var $container = $('<div class="search-result">');

            $this.after($container);

            var cube = '<div class="sk-folding-cube"><div class="sk-cube1 sk-cube"></div> <div class="sk-cube2 sk-cube"></div> <div class="sk-cube4 sk-cube"></div> <div class="sk-cube3 sk-cube"></div></div>';

            var timeout;
            $this.on('keyup', function(){
                clearTimeout(timeout);

                $container.html(cube);

                timeout = setTimeout(function(){
                    $.get(leman_search.ajaxurl, {action: 'fl_search', 'search': $this.val()}).success(function(r){
                        $container.html(r);
                    });
                },750)
            });

        });
    });
})(jQuery);