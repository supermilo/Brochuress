/**
 * UpSolution Element: Grid
 */
( function( $ ) {
	"use strict";

	$us.WGrid = function( container, options ) {
		this.init( container, options );
	};

	$us.WGrid.prototype = {

		init: function( container, options ) {
			// Commonly used dom elements
			this.$container = $( container );
			this.$filters = this.$container.find( '.g-filters-item' );
			this.$list = this.$container.find( '.w-grid-list' );
			this.$items = this.$container.find( '.w-grid-item' );
			this.$pagination = this.$container.find( '.pagination' );
			this.$loadmore = this.$container.find( '.g-loadmore' );
			this.$preloader = this.$container.find( '.w-grid-preloader' );
			this.curFilterTaxonomy = '';
			this.paginationType = this.$pagination.length ? 'regular' : ( this.$loadmore.length ? 'ajax' : 'none' );
			this.filterTaxonomyName = this.$list.data( 'filter_taxonomy_name' ) ? this.$list.data( 'filter_taxonomy_name' ) : 'category';
			this.loading = false;

			// Prevent double init
			if ( this.$container.data( 'gridInit' ) == 1 ) {
				return;
			}
			this.$container.data( 'gridInit', 1 );

			var $jsonContainer = this.$container.find( '.w-grid-json' );
			if ( $jsonContainer.length ) {
				this.ajaxData = $jsonContainer[ 0 ].onclick() || {};
				this.ajaxUrl = this.ajaxData.ajax_url || '';
				$jsonContainer.remove();
			}
			this.carouselSettings = this.ajaxData.carousel_settings;
			this.breakpoints = this.ajaxData.carousel_breakpoints || {};

			if ( $us.detectIE() == 11 ) {
				// Add object-fit support library for IE11
				$us.getScript( $us.templateDirectoryUri + '/common/js/vendor/objectFitPolyfill.js', function() {
					objectFitPolyfill();
				} );
				// Bind objectFitPolyfill() event for IE11 on lazy load event
				$us.$document.on( 'lazyload', function() {
					objectFitPolyfill();
				} );
			}

			if ( this.$list.hasClass( 'owl-carousel' ) ) {
				$us.getScript( $us.templateDirectoryUri + '/common/js/vendor/owl.carousel.js', function() {

					this.carouselOptions = {
						mouseDrag: !jQuery.isMobile,
						items: parseInt( this.carouselSettings.items ),
						rtl: $( '.l-body' ).hasClass( 'rtl' ),
						nav: this.carouselSettings.nav,
						navElement: 'div',
						navText: [this.carouselSettings.navPrev, this.carouselSettings.navNext],
						dots: this.carouselSettings.dots,
						loop: this.carouselSettings.center,
						rewind: true,
						center: this.carouselSettings.center,
						autoplay: this.carouselSettings.autoplay,
						autoplayTimeout: this.carouselSettings.timeout,
						autoHeight: this.carouselSettings.autoHeight,
						slideBy: this.carouselSettings.slideby,
						smartSpeed: this.carouselSettings.speed,
						slideTransition: this.carouselSettings.transition,
						autoplayHoverPause: true,
						responsive: this.breakpoints
					};

					if ( this.carouselSettings.autoplay == 1 ) {
						this.carouselOptions.loop = 1;
					}
					if ( this.carouselSettings.smooth_play == 1 ) {
						this.carouselOptions.slideTransition = 'linear';
						this.carouselOptions.autoplaySpeed = this.carouselSettings.timeout;
						this.carouselOptions.slideBy = 1;
						this.carouselOptions.loop = 1;
					}

					this.$list.on('changed.owl.carousel', function() {
						$( document ).trigger( 'uslazyloadevent' );
					});
					// https://owlcarousel2.github.io/OwlCarousel2/docs/started-welcome.html
					this.$list.owlCarousel( this.carouselOptions );

				}.bind( this ) );
			}

			if ( this.$container.hasClass( 'popup_page' ) ) {
				if ( this.ajaxData == undefined ) {
					return;
				}

				this.lightboxTimer = null;
				this.$lightboxOverlay = this.$container.find( '.l-popup-overlay' );
				this.$lightboxWrap = this.$container.find( '.l-popup-wrap' );
				this.$lightboxBox = this.$container.find( '.l-popup-box' );
				this.$lightboxContent = this.$container.find( '.l-popup-box-content' );
				this.$lightboxContentPreloader = this.$lightboxContent.find( '.g-preloader' );
				this.$lightboxContentFrame = this.$container.find( '.l-popup-box-content-frame' );
				this.$lightboxNextArrow = this.$container.find( '.l-popup-arrow.to_next' );
				this.$lightboxPrevArrow = this.$container.find( '.l-popup-arrow.to_prev' );
				this.$container.find( '.l-popup-closer' ).click( function() {
					this.hideLightbox();
				}.bind( this ) );
				this.$container.find( '.l-popup-box' ).click( function() {
					this.hideLightbox();
				}.bind( this ) );
				this.$container.find( '.l-popup-box-content' ).click( function( e ) {
					e.stopPropagation();
				}.bind( this ) );
				this.originalURL = window.location.href;
				this.lightboxOpened = false;

				if ( this.$list.hasClass( 'owl-carousel' ) ) {
					$us.getScript( $us.templateDirectoryUri + '/common/js/vendor/owl.carousel.js', function() {
						this.initLightboxAnchors();
					}.bind( this ) );
				} else {
					this.initLightboxAnchors();
				}

				$( window ).on( 'resize', function() {
					if ( this.lightboxOpened && $us.$window.width() < $us.canvasOptions.disableEffectsWidth ) {
						this.hideLightbox();
					}
				}.bind( this ) );
			}

			if ( this.$list.hasClass( 'owl-carousel' ) ) {
				return;
			}

			if ( this.paginationType != 'none' || this.$filters.length ) {
				if ( this.ajaxData == undefined ) {
					return;
				}

				this.templateVars = this.ajaxData.template_vars || {};
				if ( this.filterTaxonomyName ) {
					this.initialFilterTaxonomy = this.$list.data( 'filter_default_taxonomies' ) ? this.$list.data( 'filter_default_taxonomies' ).split( ',' ) : '';
					this.curFilterTaxonomy = this.initialFilterTaxonomy;
				}
				this.curPage = this.ajaxData.current_page || 1;
				this.perpage = this.ajaxData.perpage || this.$items.length;
				this.infiniteScroll = this.ajaxData.infinite_scroll || 0;
			}

			if ( this.$container.hasClass( 'with_isotope' ) ) {
				$us.getScript( $us.templateDirectoryUri + '/common/js/vendor/isotope.js', function() {
					this.$list.imagesLoaded( function() {
						var smallestItemSelector,
							isotopeOptions = {
								itemSelector: '.w-grid-item',
								layoutMode: ( this.$container.hasClass( 'isotope_fit_rows' ) ) ? 'fitRows' : 'masonry',
								isOriginLeft: !$( '.l-body' ).hasClass( 'rtl' )
							};
						if ( this.$list.find( '.size_1x1' ).length ) {
							smallestItemSelector = '.size_1x1';
						} else if ( this.$list.find( '.size_1x2' ).length ) {
							smallestItemSelector = '.size_1x2';
						} else if ( this.$list.find( '.size_2x1' ).length ) {
							smallestItemSelector = '.size_2x1';
						} else if ( this.$list.find( '.size_2x2' ).length ) {
							smallestItemSelector = '.size_2x2';
						}
						if ( smallestItemSelector ) {
							smallestItemSelector = smallestItemSelector || '.w-grid-item';
							isotopeOptions.masonry = { columnWidth: smallestItemSelector };
						}
						this.$list.isotope( isotopeOptions );
						this.$list.isotope();

						if ( this.paginationType == 'ajax' ) {
							this.initAjaxPagination();
						}
						$us.$canvas.on( 'lazyload contentChange', function() {
							this.$list.imagesLoaded( function() {
								this.$list.isotope( 'layout' );
							}.bind( this ) );
						}.bind( this ) );

					}.bind( this ) );
				}.bind( this ) );
			} else if ( this.paginationType == 'ajax' ) {
				this.initAjaxPagination();
			}

			this.$filters.each( function( index, filter ) {
				var $filter = $( filter ),
					taxonomy = $filter.data( 'taxonomy' );
				$filter.on( 'click', function() {
					if ( taxonomy != this.curFilterTaxonomy ) {
						if ( this.loading ) {
							return;
						}
						this.setState( 1, taxonomy );
						this.$filters.removeClass( 'active' );
						$filter.addClass( 'active' );
					}
				}.bind( this ) )
			}.bind( this ) );
		},
		initLightboxAnchors: function() {
			this.$anchors = this.$list.find( '.w-grid-item-anchor' );
			this.$anchors.on( 'click', function( e ) {
				var $clicked = $( e.target ),
					$item = $clicked.closest( '.w-grid-item' ),
					$anchor = $item.find( '.w-grid-item-anchor' ),
					itemUrl = $anchor.attr( 'href' );
				if ( !$item.hasClass( 'custom-link' ) ) {
					if ( $us.$window.width() >= $us.canvasOptions.disableEffectsWidth ) {
						e.stopPropagation();
						e.preventDefault();

						this.openLightboxItem( itemUrl, $item );
					}
				}
			}.bind( this ) );
		},
		// Pagination and Filters functions
		initAjaxPagination: function() {
			this.$loadmore.on( 'click', function() {
				if ( this.curPage < this.ajaxData.max_num_pages ) {
					this.setState( this.curPage + 1 );
				}
			}.bind( this ) );

			if ( this.infiniteScroll ) {
				$us.scroll.addWaypoint( this.$loadmore, '-70%', function() {
					this.$loadmore.click();
				}.bind( this ) );
			}
		},
		setState: function( page, taxonomy ) {

			if ( this.loading ) {
				return;
			}

			this.loading = true;

			if ( this.$filters.length ) {
				taxonomy = taxonomy || this.curFilterTaxonomy;
				if ( taxonomy == '*' ) {
					taxonomy = this.initialFilterTaxonomy;
				}

				if ( taxonomy != '' ) {
					var newTaxArgs = {
							'taxonomy': this.filterTaxonomyName,
							'field': 'slug',
							'terms': taxonomy
						},
						taxQueryFound = false;
					if ( this.templateVars.query_args.tax_query == undefined ) {
						this.templateVars.query_args.tax_query = [];
					} else {
						$.each( this.templateVars.query_args.tax_query, function( index, taxArgs ) {
							if ( taxArgs != null && taxArgs.taxonomy == this.filterTaxonomyName ) {
								this.templateVars.query_args.tax_query[ index ] = newTaxArgs;
								taxQueryFound = true;
								return false;
							}
						}.bind( this ) );
					}
					if ( !taxQueryFound ) {
						this.templateVars.query_args.tax_query.push( newTaxArgs );
					}
				} else if ( this.templateVars.query_args.tax_query != undefined ) {
					$.each( this.templateVars.query_args.tax_query, function( index, taxArgs ) {
						if ( taxArgs != null && taxArgs.taxonomy == this.filterTaxonomyName ) {
							this.templateVars.query_args.tax_query[ index ] = null;
							return false;
						}
					}.bind( this ) );
				}

			}

			this.templateVars.query_args.paged = page;


			if ( this.paginationType == 'ajax' ) {
				if ( page == 1 ) {
					this.$loadmore.addClass( 'done' );
				} else {
					this.$loadmore.addClass( 'loading' );
				}
			}

			if ( this.paginationType != 'ajax' || page == 1 ) {
				this.$preloader.addClass( 'active' );
				if ( this.$list.data( 'isotope' ) ) {
					this.$list.isotope( 'remove', this.$container.find( '.w-grid-item' ) );
					this.$list.isotope( 'layout' );
				} else {
					this.$container.find( '.w-grid-item' ).remove();
				}
			}

			this.ajaxData.template_vars = JSON.stringify( this.templateVars );

			$.ajax( {
				type: 'post',
				url: this.ajaxData.ajax_url,
				data: this.ajaxData,
				success: function( html ) {
					var $result = $( html ),
						$container = $result.find( '.w-grid-list' ),
						$items = $container.children(),
						isotope = this.$list.data( 'isotope' ),
						smallestItemSelector;

					$container.imagesLoaded( function() {
						this.beforeAppendItems( $items );

						$items.appendTo( this.$list );
						$container.html( '' );
						var $sliders = $items.find( '.w-slider' );
						this.afterAppendItems( $items );
						if ( isotope ) {
							isotope.insert( $items );
						}
						if ( $sliders.length ) {
							$us.getScript( $us.templateDirectoryUri + '/common/js/vendor/royalslider.js', function() {
								$sliders.each( function( index, slider ) {
									$( slider ).wSlider().find( '.royalSlider' ).data( 'royalSlider' ).ev.on( 'rsAfterInit', function() {
										if ( isotope ) {
											this.$list.isotope( 'layout' );
										}
									} );
								}.bind( this ) );

							}.bind( this ) );
						}

						if ( isotope ) {
							if ( this.$list.find( '.size_1x1' ).length ) {
								smallestItemSelector = '.size_1x1';
							} else if ( this.$list.find( '.size_1x2' ).length ) {
								smallestItemSelector = '.size_1x2';
							} else if ( this.$list.find( '.size_2x1' ).length ) {
								smallestItemSelector = '.size_2x1';
							} else if ( this.$list.find( '.size_2x2' ).length ) {
								smallestItemSelector = '.size_2x2';
							}
							if ( isotope.options.masonry ) {
								isotope.options.masonry.columnWidth = smallestItemSelector || '.w-grid-item';
							}
							this.$list.isotope( 'layout' );
						}

						if ( this.paginationType == 'ajax' ) {
							if ( page == 1 ) {
								var $jsonContainer = $result.find( '.w-grid-json' );
								if ( $jsonContainer.length ) {
									var ajaxData = $jsonContainer[ 0 ].onclick() || {};
									this.ajaxData.max_num_pages = ajaxData.max_num_pages || this.ajaxData.max_num_pages;
								} else {
									this.ajaxData.max_num_pages = 1;
								}
							}

							if ( this.templateVars.query_args.paged >= this.ajaxData.max_num_pages ) {
								this.$loadmore.addClass( 'done' );
							} else {
								this.$loadmore.removeClass( 'done' );
								this.$loadmore.removeClass( 'loading' );
							}

							if ( this.infiniteScroll ) {
								$us.scroll.addWaypoint( this.$loadmore, '-70%', function() {
									this.$loadmore.click();
								}.bind( this ) );
							}
						}

						if ( this.$container.hasClass( 'popup_page' ) ) {
							$.each( $items, function( index, item ) {
								var $loadedItem = $( item ),
									$anchor = $loadedItem.find( '.w-grid-item-anchor' ),
									itemUrl = $anchor.attr( 'href' );

								if ( !$loadedItem.hasClass( 'custom-link' ) ) {
									$anchor.click( function( e ) {
										if ( $us.$window.width() >= $us.canvasOptions.disableEffectsWidth ) {
											e.stopPropagation();
											e.preventDefault();
											this.openLightboxItem( itemUrl, $loadedItem );
										}
									}.bind( this ) );
								}
							}.bind( this ) );

						}
						// Resize canvas to avoid Parallax calculation issues
						$us.$canvas.resize();
						this.$preloader.removeClass( 'active' );
					}.bind( this ) );

					this.loading = false;

				}.bind( this ),
				error: function() {
					this.$loadmore.removeClass( 'loading' );
				}.bind( this )
			} );


			this.curPage = page;
			this.curFilterTaxonomy = taxonomy;

		},
		// Lightbox Functions
		_hasScrollbar: function() {
			return document.documentElement.scrollHeight > document.documentElement.clientHeight;
		},
		_getScrollbarSize: function() {
			if ( $us.scrollbarSize === undefined ) {
				var scrollDiv = document.createElement( 'div' );
				scrollDiv.style.cssText = 'width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;';
				document.body.appendChild( scrollDiv );
				$us.scrollbarSize = scrollDiv.offsetWidth - scrollDiv.clientWidth;
				document.body.removeChild( scrollDiv );
			}
			return $us.scrollbarSize;
		},
		openLightboxItem: function( itemUrl, $item ) {
			this.showLightbox();

			var $nextItem = $item.nextAll( 'article:visible:not(.custom-link)' ).first(),
				$prevItem = $item.prevAll( 'article:visible:not(.custom-link)' ).first();

			if ( $nextItem.length != 0 ) {
				this.$lightboxNextArrow.show();
				this.$lightboxNextArrow.attr( 'title', $nextItem.find( '.w-grid-item-title' ).text() );
				this.$lightboxNextArrow.off( 'click' ).click( function( e ) {
					var $nextItemAnchor = $nextItem.find( '.w-grid-item-anchor' ),
						nextItemUrl = $nextItemAnchor.attr( 'href' );
					e.stopPropagation();
					e.preventDefault();

					this.openLightboxItem( nextItemUrl, $nextItem );
				}.bind( this ) );
			} else {
				this.$lightboxNextArrow.attr( 'title', '' );
				this.$lightboxNextArrow.hide();
			}

			if ( $prevItem.length != 0 ) {
				this.$lightboxPrevArrow.show();
				this.$lightboxPrevArrow.attr( 'title', $prevItem.find( '.w-grid-item-title' ).text() );
				this.$lightboxPrevArrow.off( 'click' ).click( function( e ) {
					var $prevItemAnchor = $prevItem.find( '.w-grid-item-anchor' ),
						prevItemUrl = $prevItemAnchor.attr( 'href' );
					e.stopPropagation();
					e.preventDefault();

					this.openLightboxItem( prevItemUrl, $prevItem );
				}.bind( this ) );
			} else {
				this.$lightboxPrevArrow.attr( 'title', '' );
				this.$lightboxPrevArrow.hide();
			}

			if ( itemUrl.indexOf( '?' ) !== - 1 ) {
				this.$lightboxContentFrame.attr( 'src', itemUrl + '&us_iframe=1' );
			} else {
				this.$lightboxContentFrame.attr( 'src', itemUrl + '?us_iframe=1' );
			}

			// Replace window location with item's URL // TODO: bring back history replacement before production
			//if (history.replaceState) {
			//	history.replaceState(null, null, itemUrl);
			//}
			this.$lightboxContentFrame.load( function() {
				this.lightboxContentLoaded();
			}.bind( this ) );

		},
		lightboxContentLoaded: function() {
			this.$lightboxContentPreloader.css( 'display', 'none' );
		},
		showLightbox: function() {
			clearTimeout( this.lightboxTimer );
			this.$lightboxOverlay.appendTo( $us.$body ).show();
			this.$lightboxWrap.appendTo( $us.$body ).show();
			this.lightboxOpened = true;

			this.$lightboxContentPreloader.css( 'display', 'block' );
			// this.$lightboxContentFrame.css('display', 'none');
			// this.$lightboxContentFrame.css('width', this.$lightboxContent.width());
			$us.$html.addClass( 'usoverlay_fixed' );

			if ( !$.isMobile ) {
				// Storing the value for the whole popup visibility session
				this.windowHasScrollbar = this._hasScrollbar();
				if ( this.windowHasScrollbar && this._getScrollbarSize() ) {
					$us.$html.css( 'margin-right', this._getScrollbarSize() );
				}
			}
			this.lightboxTimer = setTimeout( function() {
				this.afterShowLightbox();
			}.bind( this ), 25 );
		},
		afterShowLightbox: function() {
			clearTimeout( this.lightboxTimer );
			this.$lightboxOverlay.addClass( 'active' );
			this.$lightboxBox.addClass( 'active' );

			$us.$canvas.trigger( 'contentChange' );
			$us.$window.trigger( 'resize' );
		},
		hideLightbox: function() {
			clearTimeout( this.lightboxTimer );
			this.lightboxOpened = false;
			this.$lightboxOverlay.removeClass( 'active' );
			this.$lightboxBox.removeClass( 'active' );
			// Replace window location back to original URL
			if ( history.replaceState ) {
				history.replaceState( null, null, this.originalURL );
			}

			this.lightboxTimer = setTimeout( function() {
				this.afterHideLightbox();
			}.bind( this ), 500 );
		},
		afterHideLightbox: function() {
			clearTimeout( this.lightboxTimer );
			this.$lightboxOverlay.appendTo( this.$container ).hide();
			this.$lightboxWrap.appendTo( this.$container ).hide();
			this.$lightboxContentFrame.attr( 'src', 'about:blank' );
			$us.$html.removeClass( 'usoverlay_fixed' );
			if ( !$.isMobile ) {
				if ( this.windowHasScrollbar ) {
					$us.$html.css( 'margin-right', '' );
				}
			}
		},
		/**
		 * Overloadable function for themes
		 * @param $items
		 */
		beforeAppendItems: function( $items ) {
		},

		afterAppendItems: function( $items ) {
		}

	};

	$.fn.wGrid = function( options ) {
		return this.each( function() {
			$( this ).data( 'wGrid', new $us.WGrid( this, options ) );
		} );
	};

	$( function() {
		$( '.w-grid' ).wGrid();
	} );

	$( '.w-grid-list' ).each( function() {
		var $list = $( this );
		if ( ! $list.find( '[ref=magnificPopupGrid]' ).length ) {
			return;
		}
		$us.getScript( $us.templateDirectoryUri + '/common/js/vendor/magnific-popup.js', function() {
			var delegateStr = 'a[ref=magnificPopupGrid]:visible',
				popupOptions;
			if ( $list.hasClass( 'owl-carousel' ) ) {
				delegateStr = '.owl-item:not(.cloned) a[ref=magnificPopupGrid]';
			}
			popupOptions = {
				type: 'image',
				delegate: delegateStr,
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0, 1],
					tPrev: $us.langOptions.magnificPopup.tPrev, // Alt text on left arrow
					tNext: $us.langOptions.magnificPopup.tNext, // Alt text on right arrow
					tCounter: $us.langOptions.magnificPopup.tCounter // Markup for "1 of 7" counter
				},
				removalDelay: 300,
				mainClass: 'mfp-fade',
				fixedContentPos: true
			};
			$list.magnificPopup( popupOptions );
			if ( $list.hasClass( 'owl-carousel' ) ) {
				$us.getScript( $us.templateDirectoryUri + '/common/js/vendor/owl.carousel.js', function() {
					$( '.owl-item.cloned' ).click( function( e ) {
						e.preventDefault();
						e.stopPropagation();
						var $gridItem = $( this ).find( '.w-grid-item' ),
							id = $gridItem.data( 'id' ),
							$originalGridItem = $list.find( '.owl-item:not(.cloned) > .w-grid-item[data-id=' + id + ']' ),
							$originalOwlItem = $originalGridItem.parent(),
							index = $list.find( '.owl-item:not(.cloned)' ).index( $originalOwlItem );
						$list.magnificPopup( 'open', index );
					} );
				} );
			}
		} );

	} );
} )( jQuery );
