GhostPoolScripts = {

	/*--------------------------------------------------------------
	Resize header upon scrolling
	--------------------------------------------------------------*/

	gpResizeHeader: function() {		
		if ( ! jQuery( 'body' ).hasClass( 'gp-relative-header' ) ) {
			var headerHeight = ( jQuery( window ).width() < 992 && jQuery( 'body' ).hasClass( 'gp-fixed-header-all' ) ) ? jQuery( '#gp-mobile-header' ).innerHeight() : jQuery( '#gp-standard-header' ).innerHeight();
			jQuery( '#gp-fixed-header-padding' ).height( headerHeight );
		}
	},

	gpScrollingHeader: function() {			
		if ( ! jQuery( 'body' ).hasClass( 'gp-relative-header' ) ) {
			if ( jQuery( document ).scrollTop() > ghostpool_script.scroll_to_fixed_header ) {
				jQuery( 'body' ).addClass( 'gp-scrolling' );
			} else {
				jQuery( 'body' ).removeClass( 'gp-scrolling' );
			}
		}
	},
	

	/*--------------------------------------------------------------
	Logo
	--------------------------------------------------------------*/

	gpLogo: function() {		

		if ( ! jQuery( 'body' ).hasClass( 'gp-header-disabled' ) && jQuery( '.gp-logo img' ).length > 0 && jQuery( '.gp-text-logo' ).length === 0 ) { 

			var logo = jQuery( '.gp-logo-image' ),
				logodata = logo.data();

			if ( jQuery( window ).width() < 992 && jQuery( 'body' ).hasClass( 'gp-scrolling' ) && logodata.mobilescrolling != null ) {

				if ( window.devicePixelRatio >= 2 && logodata.mobilescrollingretina != null ) {
					logo.attr( { 
						src: logodata.mobilescrollingretina,
						width: logodata.mobilescrollingwidth,
						height: logodata.mobilescrollingheight 
					} );
					if ( logodata.mobilescrollingretina == logodata.logo ) {
						logo.show();
					}
				} else {
					logo.attr( { 
						src: logodata.mobilescrolling,
						width: logodata.mobilescrollingwidth,
						height: logodata.mobilescrollingheight 
					} );
					if ( logodata.mobilescrolling == logodata.logo ) {
						logo.show();
					}
				}

			} else if ( jQuery( 'body' ).hasClass( 'gp-scrolling' ) && logodata.scrolling != null ) {

				if ( window.devicePixelRatio >= 2 && logodata.scrollingretina != null ) {
					logo.attr( { 
						src: logodata.scrollingretina,
						width: logodata.scrollingwidth,
						height: logodata.scrollingheight 
					} );
					if ( logodata.scrollingretina == logodata.logo ) {
						logo.show();
					}
				} else {
					logo.attr( { 
						src: logodata.scrolling,
						width: logodata.scrollingwidth,
						height: logodata.scrollingheight 
					} );
					if ( logodata.scrolling == logodata.logo ) {
						logo.show();
					}
				}
		
			} else if ( jQuery( window ).width() < 992 && jQuery( 'body' ).hasClass( 'gp-header-over-content' ) && ! jQuery( 'body' ).hasClass( 'gp-scrolling' ) && logodata.mobileoverlay != null ) {

				if ( window.devicePixelRatio >= 2 && logodata.mobileoverlayretina != null ) {
					logo.attr( { 
						src: logodata.mobileoverlayretina,
						width: logodata.mobileoverlaywidth,
						height: logodata.mobileoverlayheight 
					} );
					if ( logodata.mobileoverlayretina == logodata.logo ) {
						logo.show();
					}
				} else {
					logo.attr( { 
						src: logodata.mobileoverlay,
						width: logodata.mobileoverlaywidth,
						height: logodata.mobileoverlayheight 
					} );
					if ( logodata.mobileoverlay == logodata.logo ) {
						logo.show();
					}
				}

			} else if ( jQuery( 'body' ).hasClass( 'gp-header-over-content' ) && ! jQuery( 'body' ).hasClass( 'gp-scrolling' ) && logodata.overlay != null ) {

				if ( window.devicePixelRatio >= 2 && logodata.overlayretina != null ) {
					logo.attr( { 
						src: logodata.overlayretina,
						width: logodata.overlaywidth,
						height: logodata.overlayheight 
					} );
					if ( logodata.overlayretina == logodata.logo ) {
						logo.show();
					}
				} else {
					logo.attr( { 
						src: logodata.overlay,
						width: logodata.overlaywidth,
						height: logodata.overlayheight 
					} );
					if ( logodata.overlay == logodata.logo ) {
						logo.show();
					}
				}

			} else if ( jQuery( window ).width() < 992 && logodata.mobile != null ) {

				if ( window.devicePixelRatio >= 2 && logodata.mobileretina != null ) {
					logo.attr( { 
						src: logodata.mobileretina,
						width: logodata.mobilewidth,
						height: logodata.mobileheight 
					} );
					if ( logodata.mobileretina == logodata.logo ) {
						logo.show();
					}
				} else {
					logo.attr( { 
						src: logodata.mobile,
						width: logodata.mobilewidth,
						height: logodata.mobileheight 
					} );
					if ( logodata.mobile == logodata.logo ) {
						logo.show();
					}
				}
		
			} else {

				if ( window.devicePixelRatio >= 2 && logodata.logoretina != null ) {
					logo.attr( { 
						src: logodata.logoretina,
						width: logodata.logowidth,
						height: logodata.logoheight 
					} );
					if ( logodata.logoretina == logodata.logo ) {
						logo.show();
					}
				} else {
					logo.attr( { 
						src: logodata.logo,
						width: logodata.logowidth,
						height: logodata.logoheight 
					} );
					logo.show(); // Show logo since none is replaced
				}	

			}

			// Only show logo after src replaced
			logo.load( function() {
				logo.show();
			});
	
		}				
	},		


	/*--------------------------------------------------------------
	Move left sidebar into right sidebar
	--------------------------------------------------------------*/

	gpMoveSidebars: function() {		
		if ( jQuery( 'body' ).hasClass( 'gp-both-sidebars' ) && jQuery( window ).width() <= 1120 && jQuery( window ).width() >= 768 ) {
			if ( jQuery( 'body' ).hasClass( 'gp-sticky-sidebars' ) && jQuery( 'div' ).hasClass( 'theiaStickySidebar' ) ) {
				jQuery( '#gp-sidebar-left .theiaStickySidebar > *' ).addClass( 'gp-moved-widget' ).prependTo( '#gp-sidebar-right .theiaStickySidebar' );	
			} else {
				jQuery( '#gp-sidebar-left > *' ).addClass( 'gp-moved-widget' ).prependTo( '#gp-sidebar-right' );	
			}
		} else {
			if ( jQuery( 'body' ).hasClass( 'gp-sticky-sidebars' ) && jQuery( 'div' ).hasClass( 'theiaStickySidebar' ) ) {
				jQuery( '.gp-moved-widget' ).prependTo( '#gp-sidebar-left .theiaStickySidebar' );
			} else {
				jQuery( '.gp-moved-widget' ).prependTo( '#gp-sidebar-left' );
			}
		}
	},


	/*--------------------------------------------------------------
	Hide links if they go outside header
	--------------------------------------------------------------*/

	gpMenuWidths: function() {		

		if ( ghostpool_script.hide_move_primary_menu_links == 'enabled' && jQuery( window ).width() >= 992 ) {	

			jQuery( '#gp-standard-header .gp-nav:not(.gp-header-buttons)' ).each( function() {

				if ( jQuery( this ).length > 0 ) {

					var navContainer = jQuery( this ),
						navWidth = navContainer.width() + 1,
						linkWidth = 0,
						newNavWidth = 0;

					navContainer.find( 'ul' ).first().children( 'li' ).each( function() {
						linkWidth += jQuery( this ).outerWidth( true );
						if ( linkWidth > navWidth ) {
							jQuery( this ).addClass( 'gp-hide-menu' );
						} else {
							newNavWidth += jQuery( this ).width();
						}
					});
		
					if ( linkWidth > navWidth ) {
						navContainer.css( 'width', newNavWidth + 90 );
					}
			
					if ( ! navContainer.find( '.menu-item' ).hasClass( 'gp-more-menu-items' ) ) {
						navContainer.find( '.gp-hide-menu' ).wrapAll( '<li class="menu-item gp-standard-menu menu-item-has-children gp-more-menu-items"><ul class="sub-menu"></ul><li>' );
					}
					
					if ( ! navContainer.find( '.gp-more-menu-items span' ).hasClass( 'gp-more-menu-items-icon' ) ) {
						navContainer.find( '.gp-more-menu-items' ).prepend( '<span class="gp-more-menu-items-icon"></span>' );
					}				
	
					//console.log( 'link width ' + linkWidth + ' nav width ' + navWidth );

				}

			});

		}	

	},


	/*--------------------------------------------------------------
	Mobile navigation
	--------------------------------------------------------------*/

	gpMobileNav: function() {		

		if ( jQuery( window ).width() < 992 ) {	
			
			// Open primary mobile menu
			jQuery( document ).on( 'click', '.gp-open-mobile-nav-button', function() {
				jQuery( 'body' ).addClass( 'gp-mobile-primary-nav-active' );
				jQuery( window ).scrollTop( 0 );
			});
	
			// Open profile mobile menu
			jQuery( document ).on( 'click', '.logged-in #gp-mobile-header .gp-profile-button.gp-has-menu .avatar', function(event) {
				event.preventDefault();
				jQuery( 'body' ).addClass( 'gp-mobile-profile-nav-active' );
				jQuery( window ).scrollTop( 0 );
			});

			// Close all mobile menus	
			jQuery( document ).on( 'click', '#gp-close-mobile-nav-button', function() {
				jQuery( 'body' ).removeClass( 'gp-mobile-primary-nav-active' ).removeClass( 'gp-mobile-profile-nav-active' );
			});	
			
		} else {

			jQuery( 'body' ).removeClass( 'gp-mobile-primary-nav-active gp-mobile-profile-nav-active' );

		}

	},


	/*--------------------------------------------------------------
	Mobile dropdown menus
	--------------------------------------------------------------*/
	
	gpMobileDropdownMenus: function() {		

		jQuery( '.gp-mobile-nav li' ).each( function() {
	
			var navItem = jQuery( this );
	
			if ( jQuery( navItem ).find( 'ul' ).length > 0 ) {	

				// Add dropdown icon
				jQuery( '<i class="gp-mobile-dropdown-icon fa" />' ).insertAfter( jQuery( this ).children( ':first' ) );	
				jQuery( '.gp-megamenu ul .gp-mobile-dropdown-icon' ).remove();
					
				// Toggle dropdown icon and show/hide menus
				jQuery( navItem ).children( '.gp-mobile-dropdown-icon' ).on( 'click', function() {
					if ( jQuery( navItem ).hasClass( 'gp-selected' ) ) {
						jQuery( navItem ).removeClass( 'gp-selected' );
						jQuery( navItem ).children( '.sub-menu' ).stop().hide();		
					} else {
						jQuery( navItem ).addClass( 'gp-selected' );
						jQuery( navItem ).children( '.sub-menu' ).stop().show();
					}
				});
	
				// Keep sub menu open if child link selected
				if ( jQuery( navItem ).find( 'ul li' ).hasClass( 'current-menu-item' ) ) {
					jQuery( navItem ).find( 'ul li' ).parent().stop().show();
					jQuery( navItem ).find( 'ul li' ).parent().parent().addClass( 'gp-selected' );
				}
					
			}
			
		});

	},


	/*--------------------------------------------------------------
	Shift dropdown menu position
	--------------------------------------------------------------*/

	gpShiftDropdownPosition: function() {		

		jQuery( document ).on( 'mouseenter mouseleave', '.gp-nav > .menu > .gp-standard-menu.menu-item-has-children', function(e) {
			if ( jQuery( 'ul', this ).length ) {
				var menu = jQuery( 'ul:first', this ),
					menuOffset = menu.offset(),
					menuLeftOffset = menuOffset.left,
					menuWidth = menu.width(),
					container = jQuery( '#gp-standard-header' ),
					containerOffset = container.offset(),
					containerLeftOffset = containerOffset.left,
					containerWidth = container.width(),
					visible = ( menuLeftOffset + ( menuWidth * 2 ) <= ( containerWidth + containerLeftOffset ) );
				if ( ! visible ) {
					jQuery( this ).addClass( 'gp-nav-shift' );
				} else {
					jQuery( this ).removeClass( 'gp-nav-shift' );
				}
			}
		});

	},

			
	/*--------------------------------------------------------------
	Profile menu tabs and notification list
	--------------------------------------------------------------*/	

	gpNotificationsTab: function() {		

		jQuery( document ).on( 'click', '.gp-profile-tab', function( event ) {	
			event.preventDefault();
			jQuery( '.gp-notifications-tab' ).removeClass( 'gp-active' );
			jQuery( this ).addClass( 'gp-active' );
			jQuery( '.gp-profile-menu > li:not(.gp-notification-link)' ).show();
			jQuery( '.gp-profile-menu > li.gp-notification-link:not(.gp-profile-menu-tabs)' ).hide();
		});	

		jQuery( document ).on( 'click', '.gp-notifications-tab', function( event ) {
			event.preventDefault();
			jQuery( '.gp-profile-tab' ).removeClass( 'gp-active' );
			jQuery( this ).addClass( 'gp-active' );
			jQuery( '.gp-profile-menu > li:not(.gp-notification-link):not(.gp-profile-menu-tabs)' ).hide();
			jQuery( '.gp-profile-menu > li.gp-notification-link' ).show();
		});

	},


	/*--------------------------------------------------------------
	Click menu link to smooth scroll to container
	--------------------------------------------------------------*/

	gpMenuScroll: function() {		

		// Get heights
		var menuItem = jQuery( '.gp-scroll-to-link a[href*="#"]' ),
			mainHeaderHeight = ( jQuery( window ).width() < 992 ) ? jQuery( '#gp-mobile-header' ).outerHeight() : jQuery( '#gp-standard-header' ).outerHeight(),
			topHeaderHeight = ( jQuery( '#gp-top-header' ).length > 0 ) ? jQuery( '#gp-top-header' ).innerHeight() : 1,
			adminBar = ( jQuery( '#wpadminbar' ).length > 0 ) ? jQuery( '#wpadminbar' ).outerHeight() : 0,
			headerHeight = mainHeaderHeight + adminBar;

		// Scroll to container when clicking menu link	
		jQuery( menuItem ).on( 'click', function( event ) {
			event.preventDefault();
			var targetOffset = jQuery( this.hash ).offset() ? jQuery( this.hash ).offset().top : 0;
			jQuery( 'html, body' ).animate( { scrollTop: targetOffset - headerHeight + 1 }, 500 );
		});

		// Add class to menu item when scrolling to section	
		var scrollItems = menuItem.map( function() {
			var href = jQuery( this ).attr( 'href' ),
				id = href.substring( href.indexOf( '#' ) ),
				item = jQuery( id );
			if ( item.length ) { 
				return item;
			}
		});

		jQuery( window ).on( 'scroll', function() {

			// Get container scroll position
			var fromTop = jQuery( this ).scrollTop() + headerHeight + 1;

			// Get id of current scroll item
			var cur = scrollItems.map( function() {
				if ( jQuery( this ).offset().top < fromTop ) {
					return this;
				}	
			});

			// Get the id of the current element
			cur = cur[cur.length-1];
			var id = cur && cur.length ? cur[0].id : '';
			menuItem.parent().removeClass( 'current-menu-item' );
			if ( id ) {
				menuItem.parent().end().filter( '[href*="#' + id + '"]' ).parent().addClass( 'current-menu-item' );
			} else if ( jQuery( this ).scrollTop() <= topHeaderHeight ) {
				menuItem.parent().end().filter( '[href="#home"]' ).parent().addClass( 'current-menu-item' );
			} else {
				menuItem.parent().end().filter( '[href*="#' + id + '"]' ).parent().removeClass( 'current-menu-item' );
			}

		});

	},


	/*--------------------------------------------------------------
	Show/hide side menu
	--------------------------------------------------------------*/

	gpSideMenu: function() {		

		if ( ! jQuery( 'body' ).hasClass( 'gp-header-disabled' ) ) { 

			var globalContainer = jQuery( '#gp-global-wrapper' );	
	
			jQuery( document ).on( 'click', '.bp-suggestions', function() {
				setTimeout( function() {
			
					if ( jQuery( '.gp-posts-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
						GhostPoolScripts.gpPostsMasonry();
					}
					if ( jQuery( '.gp-sensei-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
						GhostPoolScripts.gpSenseiMasonry();
					}
					if ( jQuery( '.gp-bp-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
						GhostPoolScripts.gpBPMasonry();
					}		
					if ( jQuery( '.vc_row' ).hasClass( 'gp-row-masonry' ) ) {
						GhostPoolScripts.gpRowMasonry();
					}
			
				}, 500 );
			});

			if ( jQuery( window ).width() < 992 ) {

				globalContainer.removeClass( 'gp-active-desktop-side-menu' );

				jQuery( document ).on( 'click', '#gp-close-side-menu-button', function() {
					globalContainer.removeClass( 'gp-active-mobile-side-menu gp-active-desktop-side-menu' );
					setTimeout( function() {
				
						if ( jQuery( '.gp-posts-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
							GhostPoolScripts.gpPostsMasonry();
						}
						if ( jQuery( '.gp-sensei-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
							GhostPoolScripts.gpSenseiMasonry();
						}
						if ( jQuery( '.gp-bp-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
							GhostPoolScripts.gpBPMasonry();
						}		
						if ( jQuery( '.vc_row' ).hasClass( 'gp-row-masonry' ) ) {
							GhostPoolScripts.gpRowMasonry();
						}
			
					}, 500 );
				}); 

				jQuery( document ).on( 'click', '#gp-open-side-menu-button', function() {
					globalContainer.addClass( 'gp-active-mobile-side-menu' ).removeClass( 'gp-active-desktop-side-menu' );
					setTimeout( function() { 
				
						if ( jQuery( '.gp-posts-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
							GhostPoolScripts.gpPostsMasonry();
						}
						if ( jQuery( '.gp-sensei-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
							GhostPoolScripts.gpSenseiMasonry();
						}
						if ( jQuery( '.gp-bp-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
							GhostPoolScripts.gpBPMasonry();
						}		
						if ( jQuery( '.vc_row' ).hasClass( 'gp-row-masonry' ) ) {
							GhostPoolScripts.gpRowMasonry();
						}

					 }, 500 );
				});

			} else {

				globalContainer.removeClass( 'gp-active-mobile-side-menu' );
				globalContainer.addClass( 'gp-active-desktop-side-menu' );
	
				jQuery( document ).on( 'click', '#gp-close-side-menu-button', function() {
					globalContainer.removeClass( 'gp-active-desktop-side-menu gp-active-mobile-side-menu' );
					setTimeout( function() { 
				
						if ( jQuery( '.gp-posts-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
							GhostPoolScripts.gpPostsMasonry();
						}
						if ( jQuery( '.gp-sensei-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
							GhostPoolScripts.gpSenseiMasonry();
						}
						if ( jQuery( '.gp-bp-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
							GhostPoolScripts.gpBPMasonry();
						}		
						if ( jQuery( '.vc_row' ).hasClass( 'gp-row-masonry' ) ) {
							GhostPoolScripts.gpRowMasonry();
						}

					}, 500 );
				}); 

				jQuery( document ).on( 'click', '#gp-open-side-menu-button', function() {
					globalContainer.addClass( 'gp-active-desktop-side-menu' ).removeClass( 'gp-active-mobile-side-menu' );
					setTimeout( function() {
			
						if ( jQuery( '.gp-posts-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
							GhostPoolScripts.gpPostsMasonry();
						}
						if ( jQuery( '.gp-sensei-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
							GhostPoolScripts.gpSenseiMasonry();
						}
						if ( jQuery( '.gp-bp-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {
							GhostPoolScripts.gpBPMasonry();
						}		
						if ( jQuery( '.vc_row' ).hasClass( 'gp-row-masonry' ) ) {
							GhostPoolScripts.gpRowMasonry();
						}
				
					}, 500 );
				});

			}

		}
	
	},


	/*--------------------------------------------------------------
	Search box
	--------------------------------------------------------------*/	

	gpSearchBox: function() {		

		// Open search box when button clicked
		jQuery( document ).on( 'click', '.gp-search-button:not(.gp-active)', function() {
			jQuery( this ).addClass( 'gp-active' );
			jQuery( '.gp-search-box' ).slideDown(100);
			jQuery( '.gp-search-box input[type="text"]' ).focus();
			jQuery( '#gp-mobile-nav-button.gp-close-nav' ).removeClass( 'gp-close-nav' ).addClass( 'gp-open-nav' );
			jQuery( 'body' ).removeClass( 'gp-mobile-primary-nav-active gp-mobile-profile-nav-active' );
		});			

		// Close search box	when button clicked	
		jQuery( document ).on( 'click', '.gp-search-button.gp-active', function() {
			jQuery( this ).removeClass( 'gp-active' );
			jQuery( '.gp-search-box' ).slideUp(100);
		});

		// Close search box when page clicked
		jQuery( document ).mouseup( function(e) {		
			var container = jQuery( '.gp-search-button, .gp-search-box' );
			if ( ( ! container.is( e.target ) && container.has( e.target ).length === 0 ) && jQuery( '.gp-search-button' ).hasClass( 'gp-active' ) ) {
				jQuery( '.gp-search-box' ).slideUp( 100 );
				jQuery( '.gp-search-button' ).removeClass( 'gp-active' );
			}
		});

	},


	/*--------------------------------------------------------------
	WPBakery full width row RTL support
	--------------------------------------------------------------*/

	gpFullWidthRowRTLSupport: function() {		
		jQuery( document ).on( 'vc-full-width-row', function() {
			if ( jQuery( 'body' ).hasClass( 'rtl' ) ) {
				var elements = jQuery( '[data-vc-full-width="true"]' );
				jQuery.each( elements, function() {
					var jQueryel = jQuery( this );
					jQueryel.css( 'right', jQueryel.css( 'left' ) ).css( 'left', '' );
				});
			}
		});	
	},


	/*--------------------------------------------------------------
	Back to top button
	--------------------------------------------------------------*/

	gpBackToTop: function() {		
		if ( ! jQuery( 'body' ).hasClass( 'gp-no-back-to-top' ) ) {	
			jQuery().UItoTop({ 
				containerID: 'gp-to-top',
				text: '<i class="fa fa-chevron-up"></i>',
				scrollSpeed: 600
			});
		}
	},


	/*--------------------------------------------------------------
	Lightbox
	--------------------------------------------------------------*/

	gpLightbox: function() {		
		if ( ghostpool_script.lightbox == 'group_images' ) {
			jQuery( 'a[data-lightbox="gallery"],.prettyphoto' ).featherlightGallery({
				previousIcon: '',
				nextIcon: ''
			});
		}
	},
	

	/*--------------------------------------------------------------
	Create featured scroll box
	--------------------------------------------------------------*/

	gpFeaturedScrollBox: function() {		

		jQuery( '.gp-featured-box-wrapper.gp-featured-box-2-1-2' ).each( function() {
	
			var featuredBox = jQuery( this );
			
			if ( jQuery( window ).width() < 768 ) {
	
				if ( featuredBox.find( '.gp-featured-box-scroll' ).length === 0 ) {
					featuredBox.find( '.gp-featured-small-col' ).wrapAll( '<div class="gp-featured-box-scroll" />' );
				}

			} else {

				if ( featuredBox.find( '.gp-featured-box-scroll' ).length > 0 ) {
					jQuery( '.gp-featured-small-col' ).unwrap();
				}
	
			}

		});	

	},
	
	
	/*--------------------------------------------------------------
	Posts masonry
	--------------------------------------------------------------*/

	gpPostsMasonry: function() {		
		if ( jQuery( '.gp-posts-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {

			var container = jQuery( '.gp-posts-masonry .gp-section-loop-inner' ),
				element = container;

			if ( container.find( 'img' ).length === 0 ) {
				element = jQuery( '<img />' );
			}	

			imagesLoaded( element, function( instance ) {

				container.isotope({
					itemSelector: '.gp-post-item',
					masonry: {
						columnWidth: '.gp-post-item',
						gutter: '.gp-gutter-size'
					}
				});

				container.animate( { 'opacity': 1 }, 1300 );
				jQuery( '.gp-pagination' ).animate( { 'opacity': 1 }, 1300 );
				jQuery( '.gp-load-more' ).animate( { 'opacity': 1 }, 1300 );

			});
	
		}
	},
	
	
	/*--------------------------------------------------------------
	Courses/lessons masonry
	--------------------------------------------------------------*/

	gpSenseiMasonry: function() {		
		if ( jQuery( '.gp-sensei-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {

			var container = jQuery( '.gp-posts-masonry' ),
				element = container;

			if ( container.find( 'img' ).length === 0 ) {
				element = jQuery( '<img />' );
			}	

			imagesLoaded( element, function( instance ) {

				container.isotope({
					itemSelector: '.gp-post-item',
					masonry: {
						columnWidth: '.gp-post-item',
						gutter: '.gp-gutter-size'
					}
				});

				container.animate( { 'opacity': 1 }, 1300 );
				jQuery( '.gp-pagination' ).animate( { 'opacity': 1 }, 1300 );
				jQuery( '.gp-load-more' ).animate( { 'opacity': 1 }, 1300 );

			});
		
		}
	},
	

	/*--------------------------------------------------------------
	BuddyPress groups/members masonry
	--------------------------------------------------------------*/

	gpIsotope: function() {		

		var isoOptions = {
			itemSelector: '.gp-post-item',
			masonry: {
				columnWidth: '.gp-post-item',
				gutter: '.gp-gutter-size'
			}
		};

		var container = jQuery( document ).find( '.gp-bp-wrapper.gp-posts-masonry' ),
			element = container;

		if ( container.find( 'img' ).length === 0 ) {
			element = jQuery( '<img />' );
		}

		imagesLoaded( element, function( instance ) {		
			container.isotope( isoOptions );					
			container.animate( { 'opacity': 1 }, 1300 );
		});

	},

	gpBPMasonry: function() {		

		if ( jQuery( '.gp-bp-wrapper' ).hasClass( 'gp-posts-masonry' ) ) {

			GhostPoolScripts.gpIsotope();

			jQuery( '.pagination-links a' ).on( 'click', function() {	
				jQuery( document ).ajaxComplete( function( e, xhr, settings ) {
					jQuery.ajax({
						success: function() {
							GhostPoolScripts.gpIsotope();
						}
					});
				});	
			});
		
			jQuery( '.item-list-tabs' ).on( 'click', function() {
				jQuery( document ).ajaxComplete( function( e, xhr, settings ) {
					jQuery.ajax({
						success: function() {		
							GhostPoolScripts.gpIsotope();
						}
					});
				});	
			});	
	
			jQuery( '.filter select' ).on( 'change', function() {
				jQuery.ajax({
					success: function() {
						GhostPoolScripts.gpIsotope();
					}
				});
			});

			jQuery( '.dir-search input' ).on( 'change', function() {
				jQuery.ajax({
					success: function() {
						GhostPoolScripts.gpIsotope();
					}
				});
			});
			
			/*jQuery( '.gp-bp-element .item-options' ).on( 'click', function() {
				jQuery.ajax({
					success: function() {
						GhostPoolScripts.gpIsotope();
					}
			
				});
			});*/
	
		}
	},


	/*--------------------------------------------------------------
	VC Row masonry
	--------------------------------------------------------------*/

	gpRowMasonry: function() {		
		if ( jQuery( '.vc_row' ).hasClass( 'gp-row-masonry' ) ) {

			var container = jQuery( '.gp-row-masonry' );

			container.isotope({
				itemSelector: '.vc_row.vc_inner',
				masonry: {
					columnWidth: '.vc_row.vc_inner',
					gutter: '.gp-gutter-size'
				}
			});
	
			container.animate( { 'opacity': 1 }, 1300 );
		
		}
	},
		
	
	/*--------------------------------------------------------------
	Load more content
	--------------------------------------------------------------*/

	gpLoadMoreContent: function() {		

		var maxNumPages = ghostpool_script.max_num_pages;

		jQuery( '#gp-content .gp-archive-wrapper .gp-section-loop-inner' ).infinitescroll({
			debug: false,
			loading: {
				finishedMsg: '',
				img: ghostpool_script.get_template_directory_uri + '/lib/framework/images/blank.gif',
				msgText: '',
				speed: 'fast',
			},
			nextSelector: '#gp-content .gp-archive-wrapper ul.page-numbers a',
			navSelector: '#gp-content .gp-archive-wrapper .gp-pagination',
			itemSelector: '#gp-content .gp-archive-wrapper section',
			maxPage: maxNumPages,
			extraScrollPx: 0,
			bufferPx: 0
		}, function( json, opts ) {
			if ( opts.state.currPage == maxNumPages ) {
				jQuery( '#gp-content .gp-archive-wrapper .gp-load-more' ).remove();
			}
		});
		jQuery( '#gp-content .gp-archive-wrapper .gp-section-loop-inner' ).infinitescroll( 'unbind' );
		jQuery( '#gp-content .gp-archive-wrapper .gp-load-more-button' ).on( 'click', function() {
			 jQuery( '#gp-content .gp-archive-wrapper .gp-section-loop-inner' ).infinitescroll( 'retrieve' );
			 return false;
		});	

	},
	

	/*--------------------------------------------------------------
	Add class to iframe parent element
	--------------------------------------------------------------*/

	gpVideoIframeWrapper: function() {		
		jQuery( 'p > iframe, span > iframe, .course-video iframe, .video iframe' ).not( '.wp-embedded-content' ).wrap( '<div class="gp-video-wrapper"></div>' );
		jQuery( '.gp-video-wrapper iframe' ).show();
	},


	/*--------------------------------------------------------------
	Stop touch swipe issues on iOS
	--------------------------------------------------------------*/

	gpSliderTouchSwipe: function() {		
		jQuery( '.gp-slider' ).on( 'touchmove', function(e) { e.stopPropagation(); });
	},


	/*--------------------------------------------------------------
	Gallery category post slider
	--------------------------------------------------------------*/

	gpLoopGallerySlider: function() {		
		jQuery( '.gp-section-loop .gp-post-format-gallery-slider' ).flexslider( {
			animation: 'fade',
			slideshowSpeed: 9999999,
			animationSpeed: 600,
			directionNav: true,			
			controlNav: false,			
			pauseOnAction: true, 
			pauseOnHover: false,
			prevText: '',
			nextText: ''
		});
	},


	/*--------------------------------------------------------------
	Gallery single post slider
	--------------------------------------------------------------*/

	gpSingleGallerySlider: function() {		
		jQuery( window ).load( function() {
			jQuery( '.gp-entry-featured .gp-post-format-gallery-slider' ).flexslider( { 
				animation: 'fade',
				slideshowSpeed: 9999999,
				animationSpeed: 600,
				directionNav: true,			
				controlNav: false,			
				pauseOnAction: true, 
				pauseOnHover: false,
				prevText: '',
				nextText: '',
				smoothHeight: true
			});
		});
	},


	/*--------------------------------------------------------------
	Login box
	--------------------------------------------------------------*/

	gpLoginBox: function() {		

		// Submit forms
		var formArray = ['.gp-login-form', '.gp-lost-password-form', '.gp-register-form'];

		jQuery.each( formArray, function( index, value ) {

			jQuery( value ).submit( function() {
				var form = jQuery( this ); 
				form.find( '.gp-login-results' ).html( '<div class="gp-verify-form">' + jQuery( '.gp-login-results' ).data( 'verify' ) + '</div>' ).fadeIn();
				var input_data = form.serialize();
				jQuery.ajax({
					type: 'POST',
					url:  ghostpool_script.url,
					data: input_data,
					success: function( msg ) {
						form.find( '.gp-verify-form' ).remove();
						jQuery( msg ).appendTo( form.find( '.gp-login-results' ) ).fadeIn( 'slow' );
						if ( jQuery( '.gp-register-form' ).find( '.gp-login-results .gp-success' ) ) {						
							jQuery( '.gp-register-form' ).find( 'p, .gglcptch, .wp-submit' ).hide();
						}
					},
					error: function( xhr, status, error ) {
				
						// Reset captcha on error
						if ( jQuery( '.gglcptch' ).length > 0 ) {
							grecaptcha.getResponse();
							grecaptcha.reset();
						}
						
						form.find( '.gp-verify-form' ).remove();
						jQuery( '<div>' ).html( xhr.responseText ).appendTo( form.find( '.gp-login-results' ) ).hide().fadeIn( 'slow' );
					}
				});
				return false;
			});

		});

		// Close modal window when clicking outside of it		
		jQuery( document ).mouseup( function( e ) {
			var container = jQuery( '#gp-login-modal' );
			if ( ! container.is( e.target ) && container.has( e.target ).length === 0 ) {
				jQuery( '#login' ).hide();
			}
		});
	
		// Close modal window when clicking close button
		jQuery( '#gp-login-close' ).on( 'click', function() {		
			jQuery( '#login' ).hide();
			jQuery( '#gp-login-modal .gp-login-results > div' ).remove();
		});	

		// Switch to login form when clicking links
		jQuery( '.gp-login-link' ).on( 'click', function( event ) {
			event.preventDefault();
			var parent = jQuery( this ).parent().parent().parent().parent();
			parent.find( '.gp-login-form-wrapper' ).show();
			parent.find( '.gp-register-form-wrapper, .gp-lost-password-form-wrapper' ).hide();
			parent.find( '.gp-login-results > div' ).remove();
		});	
		
		// Open login modal window when clicking link	
		if ( jQuery( '.gp-login-form-wrapper' ).length > 0 ) {
			jQuery( 'a[href="#login"]' ).on( 'click', function( event ) {
				event.preventDefault();
				jQuery( '#login' ).show();
				jQuery( '#gp-login-modal .gp-login-form-wrapper' ).show();
				jQuery( '#gp-login-modal .gp-register-form-wrapper, .gp-lost-password-form-wrapper' ).hide();
				jQuery( '#gp-login-modal .gp-login-results > div' ).remove();
			});	
		}
		
		// Open login modal window directly from URL
		if ( /#login/.test( window.location.href ) && jQuery( '.gp-login-form-wrapper' ).length > 0 ) {
			jQuery( '#login' ).show();
			jQuery( '#gp-login-modal .gp-login-form-wrapper' ).show();
			jQuery( '#gp-login-modal .gp-register-form-wrapper, .gp-lost-password-form-wrapper' ).hide();
			jQuery( '#gp-login-modal .gp-login-results > div' ).remove();
		}	

		// Switch to lost password form when clicking link								
		if ( jQuery( '.gp-lost-password-form-wrapper' ).length > 0 ) {
			jQuery( '.gp-lost-password-link' ).on( 'click', function( event ) {
				event.preventDefault();
				var parent = jQuery( this ).parent().parent().parent().parent();
				parent.find( '.gp-lost-password-form-wrapper' ).show();
				parent.find( '.gp-register-form-wrapper, .gp-login-form-wrapper' ).hide();
				parent.find( '.gp-login-results > div' ).remove();
			});	
		}
				
		// Open lost password modal window directly from URL
		if ( /#lost-password/.test( window.location.href ) && jQuery( '.gp-lost-password-form-wrapper' ).length > 0 ) {
			jQuery( '#login' ).show();
			jQuery( '#gp-login-modal .gp-lost-password-form-wrapper' ).show();
			jQuery( '#gp-login-modal .gp-register-form-wrapper, .gp-login-form-wrapper' ).hide();
			jQuery( '#gp-login-modal .gp-login-results > div' ).remove();
		}

		// Switch to registration form when clicking link	
		jQuery( '.gp-register-link' ).on( 'click', function( event ) {
			event.preventDefault();
			var parent = jQuery( this ).parent().parent().parent().parent();
			parent.find( '.gp-register-form-wrapper, .gp-register-form .login-form > p, .gp-register-form .wp-submit' ).show();
			parent.find( '.gp-register-form .login-form p > input[type="text"]' ).val( '' );
			parent.find( '.gp-login-form-wrapper, .gp-lost-password-form-wrapper' ).hide();
			parent.find( '.gp-login-results > div' ).remove();
		});
		
		// Open registration modal window when clicking link	
		if ( jQuery( '.gp-register-form-wrapper' ).length > 0 ) {
			jQuery( 'a[href="#register"]' ).on( 'click', function( event ) {
				event.preventDefault();
				jQuery( '#login' ).show();
				jQuery( '#gp-login-modal .gp-register-form-wrapper, .gp-register-form .login-form > p, .gp-register-form .wp-submit' ).show();
				jQuery( '#gp-login-modal .gp-register-form .login-form p > input[type="text"]' ).val( '' );
				jQuery( '#gp-login-modal .gp-login-form-wrapper, .gp-lost-password-form-wrapper' ).hide();
				jQuery( '#gp-login-modal .gp-login-results > div' ).remove();
			});
		}
		
		// Open registration modal window directly from URL
		if ( /#register/.test( window.location.href ) && jQuery( '.gp-register-form-wrapper' ).length > 0 ) {
			jQuery( '#login' ).show();
			jQuery( '#gp-login-modal .gp-register-form-wrapper, .gp-register-form .login-form > p, .gp-register-form .wp-submit' ).show();
			jQuery( '#gp-login-modal .gp-register-form .login-form p > input[type="text"]' ).val( '' );
			jQuery( '#gp-login-modal .gp-login-form-wrapper, .gp-lost-password-form-wrapper' ).hide();
			jQuery( '#gp-login-modal .gp-login-results > div' ).remove();
		}
		
		// Close reset success message	
		jQuery( '#gp-close-reset-message' ).on( 'click', function() {
			jQuery( '#gp-reset-message' ).remove();
		});

	},


	/*--------------------------------------------------------------
	BuddyPress main item tabs
	--------------------------------------------------------------*/

	gpBPTabsButton: function() {		

		jQuery( '.item-list-tabs#object-nav' ).prepend( '<div id="gp-bp-tabs-button">' + ghostpool_script.bp_item_tabs_nav_text + '</div>' );

	},
	
	gpBPTabs: function() {		

		var bptabs = jQuery( '.item-list-tabs#object-nav > ul' );

		if ( bptabs.length > 0 ) {	

			if ( jQuery( window ).width() < 768 ) {

				jQuery( bptabs ).hide();

				jQuery( '#gp-bp-tabs-button' ).toggle( function() {
					jQuery( bptabs ).stop().slideDown();
				}, function() {
					jQuery( bptabs ).stop().slideUp();
				});

			} else {

				jQuery( bptabs ).css( 'height', 'auto' ).show();

			}

		}
				
	},


	/*--------------------------------------------------------------
	Add class to events map
	--------------------------------------------------------------*/

	gpEventsMap: function() {		
		var mapContainer = jQuery( '.single-event .em-location-map-container' ).parent();
		mapContainer.addClass( 'gp-events-map' );		
	},
	

	/*--------------------------------------------------------------
	WooCommerce secondary hover image
	--------------------------------------------------------------*/

	gpWCSecondaryHoverImage: function() {		
		jQuery( '.products .gp-hover-image' ).css( 'opacity', 0 ).on( 'hover', function() {
			jQuery( this ).fadeTo( 'fast', 1 );
		}, function() {
			jQuery( this ).fadeTo( 'fast', 0 );
		});
	},


	/*--------------------------------------------------------------
	Remove page loader once page has loaded
	--------------------------------------------------------------*/

	gpPageLoader: function() {		
		jQuery( '#gp-page-loader' ).addClass( 'gp-remove-loader' );
	}

};

// Run functions
( function ( jQuery ) {

	'use strict';

	jQuery( document ).on( 'ready', function() {
		GhostPoolScripts.gpResizeHeader();	
		GhostPoolScripts.gpLogo();
		GhostPoolScripts.gpMoveSidebars();
		GhostPoolScripts.gpMobileDropdownMenus();
		GhostPoolScripts.gpShiftDropdownPosition();
		GhostPoolScripts.gpNotificationsTab();	
		GhostPoolScripts.gpMenuScroll();
		GhostPoolScripts.gpMobileNav();
		GhostPoolScripts.gpSideMenu();
		GhostPoolScripts.gpSearchBox();
		GhostPoolScripts.gpFullWidthRowRTLSupport();
		GhostPoolScripts.gpBackToTop();
		GhostPoolScripts.gpLightbox();
		GhostPoolScripts.gpFeaturedScrollBox();
		GhostPoolScripts.gpPostsMasonry(); 
		GhostPoolScripts.gpBPMasonry();
		GhostPoolScripts.gpSenseiMasonry();
		GhostPoolScripts.gpRowMasonry();
		GhostPoolScripts.gpLoadMoreContent();
		GhostPoolScripts.gpVideoIframeWrapper();
		GhostPoolScripts.gpSliderTouchSwipe();
		GhostPoolScripts.gpSingleGallerySlider();
		GhostPoolScripts.gpLoopGallerySlider();
		GhostPoolScripts.gpLoginBox();
		GhostPoolScripts.gpBPTabsButton();
		GhostPoolScripts.gpBPTabs();
		GhostPoolScripts.gpEventsMap();
		GhostPoolScripts.gpWCSecondaryHoverImage();
		GhostPoolScripts.gpPageLoader();
	});

	jQuery( window ).on( 'load', function() {
		GhostPoolScripts.gpMenuWidths();
	});
	
	jQuery( window ).on( 'resize', function() {
		GhostPoolScripts.gpResizeHeader();
		GhostPoolScripts.gpLogo();
		GhostPoolScripts.gpMenuWidths();
		GhostPoolScripts.gpMobileNav();
		GhostPoolScripts.gpMoveSidebars();
		GhostPoolScripts.gpSideMenu();
		GhostPoolScripts.gpFeaturedScrollBox();
		GhostPoolScripts.gpBPTabs();
	});

	jQuery( window ).on( 'scroll', function() {
		GhostPoolScripts.gpScrollingHeader();
		GhostPoolScripts.gpLogo();
		GhostPoolScripts.gpMobileNav();
	});
	
})( jQuery );