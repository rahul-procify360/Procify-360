/*!
 * jQuery.fontselect - A font selector for the Google Web Fonts api
 * Tom Moor, http://tommoor.com
 * Copyright (c) 2011 Tom Moor
 * MIT Licensed
 * Modified by Keith Miyake to include a reset button
 * @version 0.1.1
*/
( function( $ ) {

	'use strict'

	$.fn.fontselect = function( options ) {

		var __bind = function( fn, me ) {
			return function() {
				return fn.apply( me, arguments )
			}
		}

		var settings = $.extend({
			style: 'font-select',
			placeholder: 'Select a font',
			resettext: 'Reset',
			lookahead: 6,
			cssUrl: '//fonts.googleapis.com/css?family=',
			fonts: _fonts,
			apiUrl: '//www.googleapis.com/webfonts/v1/webfonts',
			apiKey: null,
			fetch: true,
			combine: false
		}, options )

		var Fontselect = ( function() {

			function Fontselect( original, o ) {
				this.$original = $( original )
				this.options = o
				this.active = false
				this.setupHtml()
				this.setupFonts()
				if ( this.options.fetch ) {
					this.fetchFonts()
				}
			}

			Fontselect.prototype.fetchFonts = function() {
				var fontselect = this
				var url = this.options.apiUrl
				if ( this.options.apiKey ) {
					url = url + '?key=' + this.options.apiKey
				}

				$.ajax({
					url: url,
					dataType: 'jsonp',
					success: function( data ) {
						if ( data.items && 0 < data.items.length ) {
							fontselect.options.fonts = []
							$.each( data.items, function( key, font ) {

								// TO-DO: add selectors for variants and subsets
								$.each( font.variants, function( key, variant ) {
									var family = font.family.replace( / /g, '+' )
									if ( 1 < font.variants.length || ( 400 !== variant && 'regular' !== variant ) ) {
										family = family + ':' + variant
									}
									fontselect.options.fonts.push( family )
								})
							})
						}

						fontselect.$drop.empty()
						fontselect.$results.empty()
						fontselect.$drop.append( fontselect.$results.append( fontselect.fontsAsHtml() ) ).hide()
						$( 'li', fontselect.$results )
							.click( __bind( fontselect.selectFont, fontselect ) )
							.mouseenter( __bind( fontselect.activateFont, fontselect ) )
							.mouseleave( __bind( fontselect.deactivateFont, fontselect ) )
					},
					error: function() {
					}
				})
			}

			Fontselect.prototype.setupFonts = function() {
				this.getVisibleFonts()
				this.bindEvents()

				var font = this.$original.val()
				if ( font ) {
					this.updateSelected()
					this.addFontLink( font )
				}
			}

			Fontselect.prototype.bindEvents = function() {
				$( 'li', this.$results )
					.click( __bind( this.selectFont, this ) )
					.mouseenter( __bind( this.activateFont, this ) )
					.mouseleave( __bind( this.deactivateFont, this ) )

				$( 'span', this.$select ).click( __bind( this.toggleDrop, this ) )
				this.$arrow.click( __bind( this.toggleDrop, this ) )
				this.$reset.click( __bind( this.resetSelected, this ) )
			}

			Fontselect.prototype.toggleDrop = function() {
				if ( this.active ) {
					this.$element.removeClass( 'font-select-active' )
					this.$top = this.$results.scrollTop()
					this.$drop.hide()
					clearInterval( this.visibleInterval )
				} else {
					this.$element.addClass( 'font-select-active' )
					this.$drop.show()
					this.$results.scrollTop( this.$top )
					this.moveToSelected()
					this.visibleInterval = setInterval( __bind( this.getVisibleFonts, this ), 500 )
				}

				this.active = ! this.active
			}

			Fontselect.prototype.selectFont = function() {
				var font = $( 'li.active', this.$results ).data( 'value' )
				this.$original.val( font ).change()
				this.updateSelected()
				this.toggleDrop()
			}

			Fontselect.prototype.moveToSelected = function() {
				var $li,
					font = this.$original.val()

				if ( font ) {
					$li = $( 'li[data-value=\'' + font + '\']', this.$results )
				} else {
					$li = $( 'li', this.$results ).first()
				}

				if ( ! $li.hasClass( 'active' ) ) {
					this.$results.scrollTop( 0 )
					this.$results.scrollTop( $li.addClass( 'active' ).position().top )
				}
			}

			Fontselect.prototype.activateFont = function( ev ) {
				$( 'li.active', this.$results ).removeClass( 'active' )
				$( ev.currentTarget ).addClass( 'active' )
			}

			Fontselect.prototype.deactivateFont = function( ev ) {
				$( ev.currentTarget ).removeClass( 'active' )
			}

			Fontselect.prototype.updateSelected = function() {
				var font = this.$original.val()
				$( 'span', this.$element ).text( this.toReadable( font ) ).css( this.toStyle( font ) )
			}

			Fontselect.prototype.resetSelected = function( ev ) {
				this.$original.val( '' ).change()
				$( 'span', this.$element ).text( this.options.placeholder ).css({
					'font-family': '',
					'font-weight': '',
					'font-style': '',
					'font-size': ''
				})
			}

			Fontselect.prototype.setupHtml = function() {
				this.$original.empty().hide()
				this.$element = $( '<div>', {'class': this.options.style })
				this.$arrow = $( '<div><b></b></div>' )
				this.$select = $( '<a><span>' + this.options.placeholder + '</span></a>' )
				this.$drop = $( '<div>', {'class': 'fs-drop' })
				this.$results = $( '<ul>', {'class': 'fs-results' })
				this.$reset = $( '<input type="button" class="' + this.options.style + ' fs-reset button" value="' + this.options.resettext + '" />' )
				this.$original.after( this.$element.append( this.$select.append( this.$arrow ) ).append( this.$drop ) )
				this.$reset.insertAfter( this.$element )
				this.$drop.append( this.$results.append( this.fontsAsHtml() ) ).hide()
			}

			Fontselect.prototype.fontsAsHtml = function() {
				var fonts = this.options.fonts
				var l = fonts.length

				if ( this.options.combine ) {
					var combined = []
					var name = ''
					var family = ''
					for ( var i = 0; i < l; i++ ) {
						var parts = fonts[i].split( ':' )
						if ( '' === name || name != parts[0]) {
							if ( '' !== name ) {
								combined.push( family )
							}
							name = parts[0]
							family = fonts[i]
						} else {
							family = family + '|' + fonts[i]
						}
						if ( i == l - 1 ) {
							combined.push( family )
						}
					}
					fonts = combined
					l = fonts.length
				}

				var r, s,
					h = ''

				for ( var i = 0; i < l; i++ ) {
					r = this.toReadable( fonts[i])
					s = this.toStyle( fonts[i])
					h += '<li data-value="' + fonts[i] + '">' + r + '</li>'
				}
				return h
			}

			Fontselect.prototype.toReadable = function( font ) {
				var readable = font
				if ( this.options.combine ) {
					readable = readable.replace( /:.*/, '' )
				}

				if ( -1 != readable.search( '_safe_' ) ) {
					if ( -1 != readable.search( ',' ) ) {
						readable = readable.split( ',' )
						readable = readable[0]
					}
					readable = readable.replace( '_safe_', '' )
					readable = readable.replace( /[\']/g, '' )
				}

				return readable.replace( /[\+|:]/g, ' ' )
			}

			Fontselect.prototype.toStyle = function( font ) {
				return {}
				var t = font.split( ':' )
				var variant = t[1] || ''
				var weight = variant.match( /(?:[0-9]+|bold)/ ) ? variant.match( /(?:[0-9]+|bold)/ )[0] : 400
				var style = variant.match( /italic/ ) ? variant.match( /italic/ )[0] : 'normal'

				var fontFamily
				if ( -1 != t[0].search( '_safe_' ) ) {
					fontFamily = t[0].replace( '_safe_, ', '' )
					fontFamily = t[0].replace( '_safe_', '' )
				} else {
					fontFamily = this.toReadable( t[0])
				}

				return {
					'font-family': fontFamily,
					'font-weight': weight,
					'font-style': style
				}
			}

			Fontselect.prototype.getVisibleFonts = function() {
				if ( this.$results.is( ':hidden' ) ) {
					return
				}
				var fs = this
				var top = this.$results.scrollTop()
				var bottom = top + this.$results.height()

				if ( this.options.lookahead ) {
					var li = $( 'li', this.$results ).first().height()
					bottom += li * this.options.lookahead
				}

				$( 'li', this.$results ).each( function() {
					var ft = $( this ).position().top + top
					var fb = ft + $( this ).height()
					if ( ( fb >= top ) && ( ft <= bottom ) ) {
						var font = $( this ).data( 'value' )
						fs.addFontLink( font )
					}
				})
			}

			Fontselect.prototype.addFontLink = function( font ) {
				if ( -1 != font.search( '_safe_' ) ) {
					return -1
				}

				var link = this.options.cssUrl + font

				if ( 0 === $( 'link[href*=\'' + font + '\']' ).length ) {
					$( 'link:last' ).after( '<link href="' + link + '" rel="stylesheet" type="text/css">' )
				}
			}

			return Fontselect
		}() )

		return this.each( function() {
			return new Fontselect( this, settings )
		})
	}

	var ahetoTypography = {
		init: function() {
			this.generateFonts()
		},

		generateFonts: function() {
		}
	}

	// Document Ready
	$( function() {
		var systemFonts = [
			'',
			'Georgia, serif',
			'\'Palatino Linotype\', \'Book Antiqua\', Palatino, serif',
			'\'Times New Roman\', Times, serif',
			'Arial, Helvetica, sans-serif',
			'\'Arial Black\', Gadget, sans-serif',
			'\'Comic Sans MS\', cursive, sans-serif',
			'Impact, Charcoal, sans-serif',
			'\'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif',
			'Tahoma, Geneva, sans-serif',
			'\'Trebuchet MS\', Helvetica, sans-serif',
			'Verdana, Geneva, sans-serif',
			'\'Courier New\', Courier, monospace',
			'\'Lucida Console\', Monaco, monospace'
		]

		var defaultVariants = {
			'400r': 'Normal 400',
			'400italic': 'Normal 400 Italic',
			'100r': 'Ultra-Light 100',
			'100italic': 'Ultra-Light 100 Italic',
			'200r': 'Light 200',
			'200italic': 'Light 200 Italic',
			'300r': 'Book 300',
			'300italic': 'Book 300 Italic',
			'500r': 'Medium 500',
			'500italic': 'Medium 500 Italic',
			'600r': 'Semi-Bold 600',
			'600italic': 'Semi-Bold 600 Italic',
			'700r': 'Bold 700',
			'700italic': 'Bold 700 Italic',
			'800r': 'Extra-Bold 800',
			'800italic': 'Extra-Bold 800 Italic',
			'900r': 'Ultra-Bold 900',
			'900italic': 'Ultra-Bold 900 Italic'
		},
		defaultVariantsOptions = Object.keys( defaultVariants )

		var systemFonts = $.merge( systemFonts, Object.keys( window.ahetoGoogleFonts ) )

		$( '.cmb2-typography-fs' ).each( function() {
			var typography = $( this ),
				variantSelect = typography.closest( '.cmb-type-typography' ).find( '.cmb2-typography-variants' )


			typography.select2({
				width: '100%',
				placeholder: 'Select fonts',
				allowClear: true,
				data: systemFonts
			}).on( 'select2:select select2:unselect', function( event ) {
				var variants = defaultVariantsOptions
				if ( 'select2:unselect' !== event.type && event.params.data.id in ahetoGoogleFonts ) {
					var font = ahetoGoogleFonts[ event.params.data.id ]
					variants = []

					if ( 'italic' in font.variants ) {
						$.each( font.variants.italic, function( key, value ) {
							variants.push( key + 'italic' )
						})
					}

					if ( 'normal' in font.variants ) {
						$.each( font.variants.normal, function( key, value ) {
							variants.push( key + 'r' )
						})
					}
				}


				variantSelect.html( '' )

				$.each( defaultVariants, function( value, label ) {
					if ( variants.includes( value ) ) {
						variantSelect.append( '<option value="' + value.replace( 'r', '' ) + '">' + label + '</option>' )
					}
				})

				variantSelect.val( variantSelect.data( 'value' ) );

				variantSelect.data( 'value', '400' );

			})


			typography.val( typography.data( 'value' ) )
			typography.trigger( 'change' ).trigger({
				type: 'select2:select',
				params: {
					data: {
						'id': typography.data( 'value' ),
						'text': typography.data( 'value' )
					}
				}
			})
		})

		$( '[data-responsive=true]', '.cmb-type-typography' ).each( function() {
			var input = $( this ),
				dummyInput = $( '<input type="text" class="cmb2-text-small" />' ),
				container = input.closest( '.col' ),
				value = input.val().split( ',' ),
				object = {
					desktop: value[0],
					tablet: undefined === value[1] ? '' : value[1],
					mobile: undefined === value[2] ? '' : value[2]
				}

			input.hide()
			input.data( 'desktop', object.desktop )
			input.data( 'tablet', object.tablet )
			input.data( 'mobile', object.mobile )

			container.addClass( 'has-responsive-input' )
			container.append( '<span class="controls"><i class="fas fa-desktop" data-type="desktop"></i><i class="fas fa-tablet-alt" data-type="tablet"></i><i class="fas fa-mobile-alt" data-type="mobile"></i></span>' )
			container.append( dummyInput )

			var icons = container.find( 'i' ),
				activeType = 'desktop'
			icons.on( 'click', function() {
				var icon = $( this )

				icons.removeClass( 'active' )
				icon.addClass( 'active' )

				activeType = icon.data( 'type' )
				dummyInput.val( input.data( activeType ) )
			})

			dummyInput.on( 'input', function() {
				input.data( activeType, dummyInput.val() )
				object[ activeType ] = dummyInput.val()
				input.val( Object.values( object ).join( ',' ) )
			})

			icons.eq( 0 ).trigger( 'click' )
		})
	})

}( jQuery ) )
