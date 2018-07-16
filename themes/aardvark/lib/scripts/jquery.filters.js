jQuery( function( $ ) {
	
	/*--------------------------------------------------------------
	Default values
	--------------------------------------------------------------*/

	var cats_filtered = 0;
	var orderby_filtered = 0;
	var tab_cat_filtered = 0;
	var pagenumber = 1;
	
	
	/*--------------------------------------------------------------
	Get current value
	--------------------------------------------------------------*/

	function gpCurrentValue( parent ) {
		cats_filtered = parent.find( 'select[name="gp-filter-cats"]' ).attr( 'value' );
		orderby_filtered = parent.find( 'select[name="gp-filter-orderby"]' ).attr( 'value' );
		pagenumber = 1;
	}
		
			   			
	/*--------------------------------------------------------------
	Load posts
	--------------------------------------------------------------*/
	
	function gpLoadPosts( element ) { 	

		var ajaxLoop = element.find( '.gp-ajax-loop' );	
		var filterWrapper = element.find( '.gp-filter-wrapper' );

		// Ajax query
		$.ajax({
			type: 'GET',
			data: {
				action: 'ghostpool_filters_action',
				ghostpool_filters_nonce: ghostpool_filters.nonce,
				query_string: ghostpool_filters.query_string,
				cats_filtered: cats_filtered,
				orderby_filtered: orderby_filtered,
				tab_cat_filtered: tab_cat_filtered,
				pagenumber: pagenumber,			
				type: element.data('type'),
				cpostid: element.data('cpostid'),
				cats: element.data('cats'),
				pageids: element.data('pageids'),
				posttypes: element.data('posttypes'),
				ranking: element.data('ranking'),
				format: element.data('format'),
				style: element.data('style'),
				orderby: element.data('orderby'),
				perpage: element.data('perpage'),
				imagesize: element.data('imagesize'),
				offset: element.data('offset'),
				imagewidth: element.data('imagewidth'),
				imageheight: element.data('imageheight'),
				contentdisplay: element.data('contentdisplay'),
				excerptlength: element.data('excerptlength'),
				metaauthor: element.data('metaauthor'),
				metadate: element.data('metadate'),
				metacommentcount: element.data('metacommentcount'),
				metaviews: element.data('metaviews'),
				metalikes: element.data('metalikes'),
				metacats: element.data('metacats'),
				metatags: element.data('metatags'),
				readmorelink: element.data('readmorelink'),
				pagearrows: element.data('pagearrows'),
				pagination: element.data('pagination'),
				largeexcerptlength: element.data('largeexcerptlength'),
				smallexcerptlength: element.data('smallexcerptlength'),
				largemetaauthor: element.data('largemetaauthor'),
				smallmetaauthor: element.data('smallmetaauthor'),
				largemetadate: element.data('largemetadate'),
				smallmetadate: element.data('smallmetadate'),
				largemetacommentcount: element.data('largemetacommentcount'),
				smallmetacommentcount: element.data('smallmetacommentcount'),
				largemetaviews: element.data('largemetaviews'),
				smallmetaviews: element.data('smallmetaviews'),
				largemetalikes: element.data('largemetalikes'),
				smallmetalikes: element.data('smallmetalikes'),
				largemetacats: element.data('largemetacats'),
				smallmetacats: element.data('smallmetacats'),
				largemetatags: element.data('largemetatags'),
				smallmetatags: element.data('smallmetatags'),
				largereadmorelink: element.data('largereadmorelink'),
				smallreadmorelink: element.data('smallreadmorelink'),
				category: element.data('category')
			},
			dataType: 'html',
			url: ghostpool_filters.ajaxurl,
			success: function( data ) {	
	
				// Fade in and remove old pagination once content has loaded
				$( '.gp-post-item:last-child .gp-post-image' ).promise().done( function() {
					ajaxLoop.html( data ).removeClass( 'gp-filter-loading' ).find( '.gp-post-item' ).fadeIn();
					element.find( '.gp-standard-pagination' ).hide();
				});
		
				// Needed for posts masonry positioning of page numbers
				ajaxLoop.after( $( '.gp-posts-masonry .gp-ajax-pagination.gp-pagination-numbers' ) );
				$( '.gp-posts-masonry .gp-ajax-pagination.gp-pagination-numbers:not(:first)' ).remove();

				// If clicking ajax pagination numbers
				element.find( '.gp-ajax-pagination.gp-pagination-numbers a' ).click( function() {
					
					if ( $( this ).hasClass( 'page-numbers' ) ) {
						var parentElement = $( this ).parent().parent().parent().parent().parent().parent();
					} else {
						var parentElement = $( this ).parent().parent().parent().parent();	
					}		
					gpCurrentValue( parentElement );
					
					// Get page numbers from page links
					var ajaxPagination = $( this );	
						
					if ( ajaxPagination.hasClass( 'prev' ) ) {
						var pagelink = ajaxPagination.attr( 'href' );
						if ( pagelink.match( 'pagenumber=2' ) ) {
							pagenumber = 1;
						} else {
							var prev = pagelink.match(/\d+/);
							pagenumber = prev[0];
						}	
					} else if ( ajaxPagination.hasClass( 'next' ) ) {
						var next = ajaxPagination.attr( 'href' ).match(/\d+/);
						pagenumber = next[0];
					} else {
						pagenumber = ajaxPagination.text();
					}
					
					gpLoadPosts( element );

					// Scroll to top of page if not a Visual Composer element
					if ( ! element.is( '.gp-ajax-element' ) ) {
						$( 'html, body' ).animate({ scrollTop : 0 }, 0);
					} else {
						$( 'html, body' ).animate({ scrollTop: ( parentElement.offset().top - 200 ) }, 0);
					}
					
					return false;
				});
				
				// If clicking ajax pagination arrows
				element.find( '.gp-ajax-pagination.gp-pagination-arrows a' ).click( function() {
					
					if ( $( this ).hasClass( 'page-numbers' ) ) {
						var parentElement = $( this ).parent().parent().parent().parent().parent().parent();
					} else {
						var parentElement = $( this ).parent().parent().parent().parent();	
					}		
					gpCurrentValue( parentElement );
					
					// Get page numbers from page links
					var ajaxPagination = $( this );	
					
					pagenumber = ajaxPagination.data( 'pagelink' );	
					
					gpLoadPosts( element );

					if ( ! element.is( '.gp-vc-element' ) ) {
						$( 'html, body' ).animate({ scrollTop : 0 }, 0);
					} else {
						$( 'html, body' ).animate({ scrollTop: ( parentElement.offset().top - 200 ) }, 0);
					}
					
					return false;
				});			
				
				// Load WordPress media players	
				if ( element.find( '.wp-audio-shortcode' ).length > 0 ) {
					element.find( '.wp-audio-shortcode' ).mediaelementplayer({
						alwaysShowControls: true
					});
				}
				if ( element.find( '.wp-video-shortcode' ).length > 0 ) {		
					element.find( '.wp-video-shortcode' ).mediaelementplayer({
						alwaysShowControls: true
					});
				}

				// Load masonry
				$( document ).ajaxComplete( function( e, xhr, settings ) {
					GhostPoolScripts.gpPostsMasonry();
				});

				// Load video wrapper
				$( document ).ajaxComplete( function( e, xhr, settings ) {
					GhostPoolScripts.gpVideoIframeWrapper();
				});
		
				// Load gallery slider
				$( document ).ajaxComplete( function( e, xhr, settings ) {
					GhostPoolScripts.gpLoopGallerySlider();
				});
								
			},
			error: function( jqXHR, textStatus, errorThrown ) {
				//alert( jqXHR + " :: " + textStatus + " :: " + errorThrown );
			}
		});	

		// Add loading class
		ajaxLoop.addClass( 'gp-filter-loading' );
									
		return false;
		
	}	
	
	
	/*--------------------------------------------------------------
	Filter options
	--------------------------------------------------------------*/
		
	// If selecting category filter	
	$( 'select[name="gp-filter-cats"]' ).change( function() {
		var filterCats = $( this );
		var parentElement = filterCats.parent().parent().parent();
		gpCurrentValue( parentElement );
		cats_filtered = filterCats.attr( 'value' );	
		gpLoadPosts( parentElement );		
	});
						
	// If selecting orderby filter		
	$( 'select[name="gp-filter-orderby"]' ).change( function() {
		var filterOrderby = $( this );
		var parentElement = filterOrderby.parent().parent().parent();
		gpCurrentValue( parentElement );
		orderby_filtered = filterOrderby.attr( 'value' );
		gpLoadPosts( parentElement );
	});
		
	// If clicking menu categories
	$( '.gp-menu-tabs:not(.gp-mobile-menu-tabs) li' ).hover( function() {
		var filterMenuCats = $( this );
		var parentElement = filterMenuCats.parent().parent();
		gpCurrentValue( parentElement );
		tab_cat_filtered = filterMenuCats.attr( 'id' );
		$( 'li.gp-selected' ).removeClass( 'gp-selected' );
		filterMenuCats.addClass( 'gp-selected' );	
		gpLoadPosts( parentElement );
	}, function() {
  	});
	$( '.gp-menu-tabs.gp-mobile-menu-tabs li' ).click( function() {
		var filterMenuCats = $( this );
		var parentElement = filterMenuCats.parent().parent();
		gpCurrentValue( parentElement );
		tab_cat_filtered = filterMenuCats.attr( 'id' );
		$( 'li.gp-selected' ).removeClass( 'gp-selected' );
		filterMenuCats.addClass( 'gp-selected' );	
		gpLoadPosts( parentElement );	
		return false;	
	});

	// If clicking original pagination (numbers)
	$( '#gp-content-wrapper .gp-ajax-loop .gp-pagination ul.page-numbers a' ).click( function() {
		// Get page numbers from page links
		var filterPagination = $( this );
		var parentElement = filterPagination.parent().parent().parent().parent().parent();
		gpCurrentValue( parentElement );
		if ( filterPagination.hasClass( 'prev' ) ) {
			var prev = filterPagination.attr('href').match(/(\d+)\D*$/);
			pagenumber = prev[0];
		} else if ( filterPagination.hasClass( 'next' ) ) {
			var next = filterPagination.attr( 'href' ).match(/(\d+)\D*$/);
			pagenumber = next[0];
		} else {
			pagenumber = filterPagination.text();
		}
		gpLoadPosts( parentElement );
		if ( ! parentElement.hasClass( 'gp-vc-element' ) ) {
			$( 'html, body' ).animate({ scrollTop : 0 }, 0);
		} else {
			$( 'html, body' ).animate({ scrollTop: ( parentElement.offset().top - 200 ) }, 0);
		}
		return false;
	});	

	// If clicking original pagination (arrows)
	$( '#gp-content-wrapper .gp-pagination-arrows a' ).click( function() {
		var filterPagination = $( this );
		var parentElement = filterPagination.parent().parent().parent();
		gpCurrentValue( parentElement );
		pagenumber = filterPagination.data( 'pagelink' );
		gpLoadPosts( parentElement );
		return false;
	});

	// If clicking original menu pagination
	$( '.gp-nav .gp-ajax-loop .gp-pagination-arrows a' ).click( function() {
		cats_filtered = 0;
		orderby_filtered = 0;
		var filterPagination = $( this );
		var parentElement = filterPagination.parent().parent().parent();
		pagenumber = filterPagination.data( 'pagelink' );
		gpLoadPosts( parentElement );
		return false;
	});

});