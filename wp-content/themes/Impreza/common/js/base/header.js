/**
 * $us.header
 * Dev note: should be initialized after $us.canvas
 */
! function( $ ) {
	"use strict";

	function USHeader( settings ) {
		this.settings = settings || {};
		this.state = 'default'; // 'tablets' / 'mobiles'
		this.$container = $us.$canvas.find( '.l-header' );
		// Will be used to count fullscreen sections heights and proper scroll positions
		this.scrolledOccupiedHeight = 0;
		if ( this.$container.length == 0 ) {
			return;
		}
		this.$topCell = this.$container.find( '.l-subheader.at_top .l-subheader-cell:first' );
		this.$middleCell = this.$container.find( '.l-subheader.at_middle .l-subheader-cell:first' );
		this.$bottomCell = this.$container.find( '.l-subheader.at_bottom .l-subheader-cell:first' );
		this.$showBtn = $( '.w-header-show:first' );
		this.orientation = $us.$body.usMod( 'header' );
		this.pos = this.$container.usMod( 'pos' ); // 'fixed' / 'static'
		this.bg = this.$container.usMod( 'bg' ); // 'solid' / 'transparent'
		this.shadow = this.$container.usMod( 'shadow' ); // 'none' / 'thin' / 'wide'

		// Will be used to count fullscreen sections heights and proper scroll positions
		this.scrolledOccupiedHeight = 0;

		// Breakpoints
		this.tabletsBreakpoint = parseInt( settings.tablets && settings.tablets.options && settings.tablets.options.breakpoint ) || 900;
		this.mobilesBreakpoint = parseInt( settings.mobiles && settings.mobiles.options && settings.mobiles.options.breakpoint ) || 600;

		this._events = {
			scroll: this.scroll.bind( this ),
			resize: this.resize.bind( this ),
			contentChange: function() {
				this._countScrollable();
			}.bind( this ),
			hideMobileVerticalHeader: function( e ) {
				if ( $.contains( this.$container[ 0 ], e.target ) ) {
					return;
				}
				$us.$body
					.off( $.isMobile ? 'touchstart' : 'click', this._events.hideMobileVerticalHeader );
				setTimeout( function() {
					$us.$body.removeClass( 'header-show' );
				}, 10 );
			}.bind( this )
		};
		this.$elms = {};
		this.$places = {
			hidden: this.$container.find( '.l-subheader.for_hidden' )
		};
		this.$container.find( '.l-subheader-cell' ).each( function( index, cell ) {
			var $cell = $( cell );
			this.$places[ $cell.parent().parent().usMod( 'at' ) + '_' + $cell.usMod( 'at' ) ] = $cell;
		}.bind( this ) );
		var regexp = /(^| )ush_([a-z_]+)_([0-9]+)( |$)/;
		this.$container.find( '[class*=ush_]' ).each( function( index, elm ) {
			var $elm = $( elm ),
				matches = regexp.exec( $elm.attr( 'class' ) );
			if ( ! matches ) {
				return;
			}
			var id = matches[ 2 ] + ':' + matches[ 3 ];
			this.$elms[ id ] = $elm;
			if ( $elm.is( '.w-vwrapper, .w-hwrapper' ) ) {
				this.$places[ id ] = $elm;
			}
		}.bind( this ) );
		// TODO Objects with the header elements
		$us.$window.on( 'scroll', this._events.scroll );
		$us.$window.on( 'resize load', this._events.resize );
		this.resize();

		$us.$canvas.on( 'contentChange', function() {
			if ( this.orientation == 'ver' ) {
				this.docHeight = $us.$document.height();
			}
		}.bind( this ) );

		this.$container.on( 'contentChange', this._events.contentChange );

		this.$showBtn.on( 'click', function( e ) {
			if ( $us.$body.hasClass( 'header-show' ) ) {
				return;
			}
			e.stopPropagation();
			$us.$body
				.addClass( 'header-show' )
				.on( $.isMobile ? 'touchstart' : 'click', this._events.hideMobileVerticalHeader );
		}.bind( this ) );
	}

	$.extend( USHeader.prototype, {
		scroll: function() {
			var scrollTop = parseInt( $us.$window.scrollTop() );
			if ( this.pos == 'fixed' ) {
				if ( this.orientation == 'hor' ) {
					if ( ( $us.canvas.headerInitialPos == 'bottom' || $us.canvas.headerInitialPos == 'below' ) && ( $us.$body.usMod( 'state' ) == 'default' ) ) {
						if ( this.adminBarHeight ) {
							scrollTop += this.adminBarHeight;
						}
						if ( scrollTop >= this.headerTop ) {
							if ( ! this.$container.hasClass( 'sticky' ) ) {
								this.$container.addClass( 'sticky' );
							}
							if ( this.applyHeaderTop && this.$container.css( 'top' ) != '' ) {
								this.$container.css( 'top', '' );
							}
						} else if ( scrollTop < this.headerTop ) {
							if ( this.$container.hasClass( 'sticky' ) ) {
								this.$container.removeClass( 'sticky' );
							}
							if ( this.applyHeaderTop && this.$container.css( 'top' ) != this.headerTop ) {
								this.$container.css( 'top', this.headerTop );
							}
						}

					} else {
						this.$container.toggleClass( 'sticky', scrollTop >= ( parseInt( this.settings[ this.state ].options.scroll_breakpoint ) || 100 ) );
					}

				} else if ( ! jQuery.isMobile && this.$container.hasClass( 'scrollable' ) && this.docHeight > this.headerHeight + this.htmlTopMargin ) {
					var scrollRangeDiff = this.headerHeight - $us.canvas.winHeight + this.htmlTopMargin;
					if ( this._sidedHeaderScrollRange === undefined ) {
						this._sidedHeaderScrollRange = [ 0, scrollRangeDiff ];
					}
					if ( scrollTop <= this._sidedHeaderScrollRange[ 0 ] ) {
						this._sidedHeaderScrollRange[ 0 ] = Math.max( 0, scrollTop );
						this._sidedHeaderScrollRange[ 1 ] = this._sidedHeaderScrollRange[ 0 ] + scrollRangeDiff;
						this.$container.css( {
							position: 'fixed',
							top: this.htmlTopMargin
						} );
					}
					else if ( this._sidedHeaderScrollRange[ 0 ] < scrollTop && scrollTop < this._sidedHeaderScrollRange[ 1 ] ) {
						this.$container.css( {
							position: 'absolute',
							top: this._sidedHeaderScrollRange[ 0 ]
						} );
					}
					else if ( this._sidedHeaderScrollRange[ 1 ] <= scrollTop ) {
						this._sidedHeaderScrollRange[ 1 ] = Math.min( this.docHeight - $us.canvas.winHeight, scrollTop );
						this._sidedHeaderScrollRange[ 0 ] = this._sidedHeaderScrollRange[ 1 ] - scrollRangeDiff;
						this.$container.css( {
							position: 'fixed',
							top: $us.canvas.winHeight - this.headerHeight
						} );
					}
				}
			}
		},
		resize: function() {
			var newState = 'default';
			if ( window.innerWidth < this.tabletsBreakpoint ) {
				newState = ( window.innerWidth < this.mobilesBreakpoint ) ? 'mobiles' : 'tablets';
			}
			this.setState( newState );
			if ( this.pos == 'fixed' && this.orientation == 'hor' ) {
				var isSticky = this.$container.hasClass( 'sticky' );
				this.$container.addClass( 'notransition' );
				if ( ! isSticky ) {
					this.$container.addClass( 'sticky' );
				}
				this.scrolledOccupiedHeight = this.$container.height();
				if ( ! isSticky ) {
					this.$container.removeClass( 'sticky' );
				}
				// Removing with a small delay to prevent css glitch
				setTimeout( function() {
					this.$container.removeClass( 'notransition' );
				}.bind( this ), 50 );
			} else /*if (this.orientation == 'ver' || this.pos == 'static')*/ {
				this.scrolledOccupiedHeight = 0;
			}

			if ( this.orientation == 'hor' ) {
				if ( this.pos == 'fixed' && ( $us.canvas.headerInitialPos == 'bottom' || $us.canvas.headerInitialPos == 'below' ) && ( $us.$body.usMod( 'state' ) == 'default' ) ) {
					var adminBar = $( '#wpadminbar' );
					this.adminBarHeight = ( adminBar.length ) ? adminBar.height() : 0;

					this.headerTop = $us.canvas.$firstSection.outerHeight() + this.adminBarHeight;
					if ( $us.canvas.headerInitialPos == 'bottom' ) {
						this.headerTop = this.headerTop - this.$container.outerHeight();
					}
					if ( ! $us.canvas.$firstSection.hasClass( 'height_full' ) ) {
						this.$container.css( 'bottom', 'auto' );
						this.applyHeaderTop = true;
						this.$container.css( 'top', this.headerTop );
					}

				} else {
					this.applyHeaderTop = false;
					this.$container.css( 'top', '' );
				}
			} else {
				this.applyHeaderTop = false;
				this.$container.css( 'top', '' );
			}

			this._countScrollable();
			this.scroll();
		},
		setState: function( newState ) {
			if ( newState == this.state ) {
				return;
			}
			var newOrientation = this.settings[ newState ].options.orientation || 'hor',
				newPos = $us.toBool( this.settings[ newState ].options.sticky ) ? 'fixed' : 'static',
				newBg = $us.toBool( this.settings[ newState ].options.transparent ) ? 'transparent' : 'solid',
				newShadow = this.settings[ newState ].options.shadow || 'thin';
			if ( newOrientation == 'ver' ) {
				newPos = 'fixed';
				newBg = 'solid';
			}
			this.state = newState;
			// Don't change the order: orientation -> pos -> bg -> layout
			this._setOrientation( newOrientation );
			this._setPos( newPos );
			this._setBg( newBg );
			this._setShadow( newShadow );
			this._setLayout( this.settings[ newState ].layout || {} );
			$us.$body.usMod( 'state', newState );
			if ( newState == 'default' ) {
				$us.$body.removeClass( 'header-show' );
			}
			// Updating the menu because of dependencies
			if ( $us.nav !== undefined ) {
				$us.nav.resize();
			}
		},
		_setOrientation: function( newOrientation ) {
			if ( newOrientation == this.orientation ) {
				return;
			}
			$us.$body.usMod( 'header', newOrientation );
			this.orientation = newOrientation;
		},
		_countScrollable: function() {
			if ( this.orientation == 'ver' && this.pos == 'fixed' && this.state == 'default' ) {
				this.docHeight = $us.$document.height();
				this.htmlTopMargin = parseInt( $us.$html.css( 'margin-top' ) );
				this.headerHeight = this.$topCell.height() + this.$middleCell.height() + this.$bottomCell.height();
				if ( this.headerHeight > $us.canvas.winHeight - this.htmlTopMargin ) {
					this.$container.addClass( 'scrollable' );
				} else if ( this.$container.hasClass( 'scrollable' ) ) {
					this.$container.removeClass( 'scrollable' ).resetInlineCSS( 'position', 'top', 'bottom' );
					delete this._sidedHeaderScrollRange;
				}
				if ( this.headerHeight + this.htmlTopMargin >= this.docHeight ) {
					this.$container.css( {
						position: 'absolute',
						top: 0
					} );
				}
			} else if ( this.$container.hasClass( 'scrollable' ) ) {
				this.$container.removeClass( 'scrollable' ).resetInlineCSS( 'position', 'top', 'bottom' );
				delete this._sidedHeaderScrollRange;
			}
		},
		_setPos: function( newPos ) {
			if ( newPos == this.pos ) {
				return;
			}
			this.$container.usMod( 'pos', newPos );
			if ( newPos == 'static' ) {
				this.$container.removeClass( 'sticky' );
			}
			this.pos = newPos;
			this._countScrollable();
		},
		_setBg: function( newBg ) {
			if ( newBg == this.bg ) {
				return;
			}
			this.$container.usMod( 'bg', newBg );
			this.bg = newBg;
		},
		_setShadow: function( newShadow ) {
			if ( newShadow == this.shadow ) {
				return;
			}
			this.$container.usMod( 'shadow', newShadow );
			this.shadow = newShadow;
		},
		/**
		 * Recursive function to place elements based on their ids
		 * @param {Array} elms
		 * @param {jQuery} $place
		 * @private
		 */
		_placeElements: function( elms, $place ) {
			for ( var i = 0; i < elms.length; i ++ ) {
				var elmId;
				if ( typeof elms[ i ] == 'object' ) {
					// Wrapper
					elmId = elms[ i ][ 0 ];
					if ( this.$places[ elmId ] === undefined || this.$elms[ elmId ] === undefined ) {
						continue;
					}
					this.$elms[ elmId ].appendTo( $place );
					this._placeElements( elms[ i ].shift(), this.$places[ elmId ] );
				} else {
					// Element
					elmId = elms[ i ];
					if ( this.$elms[ elmId ] === undefined ) {
						continue;
					}
					this.$elms[ elmId ].appendTo( $place );
				}
			}
		},
		_setLayout: function( newLayout ) {
			// Retrieving the currently shown layout structure
			var curLayout = {};
			$.each( this.$places, function( place, $place ) {
			}.bind( this ) );
			for ( var place in newLayout ) {
				if ( ! newLayout.hasOwnProperty( place ) || this.$places[ place ] === undefined ) {
					continue;
				}
				this._placeElements( newLayout[ place ], this.$places[ place ] );
			}
		}
	} );
	$us.header = new USHeader( $us.headerSettings || {} );
}( jQuery );