(function($){
    $(function(){
        if($('body').hasClass('search')){
            return;
        }
        var cache = {};
        var $searchform = $('.searchform input');
        $searchform.attr('autocomplete', "off");

        $searchform.each(function(){
            var $this = $(this);
            var $container = $('<div class="search-result">');

            $this.after($container);

            var cube = '<div class="sk-folding-cube"><div class="sk-cube1 sk-cube"></div> <div class="sk-cube2 sk-cube"></div> <div class="sk-cube4 sk-cube"></div> <div class="sk-cube3 sk-cube"></div></div>';

            var timeout;
            var lastTerm;
            $this.on('keyup', function(){
                var term = $this.val().trim();

                console.log('term', term);

                if(term.length < 3){
                    return;
                }

                if(term == lastTerm){
                    return;
                }

                lastTerm = term;

                if(cache[term]){
                    $container.html(cache[term]);
                    return;
                }
                clearTimeout(timeout);

                $container.html(cube);

                console.log('will search', term);
                
                timeout = setTimeout(function(){
                    console.log('searching', term);
                    $.get(leman_search.ajaxurl, {action: 'fl_search', 'search': term}).success(function(r){
                        console.log('searched', term);
                        cache[term] = r;
                        $container.html(r);
                    });
                },750)
            });

        });
    });
})(jQuery);