/* global vc */
( function( $ ) {

	// Document Ready
	$( function() {

		vcParseMultiAttribute = function( value, defaults ) {
			if ( 'undefined' === typeof value ) {
				return defaults || ''
			}

			var obj = {}
			value = value.split( '|' )
			$.each( value, function() {
				var item = this.split( ':' )

				obj[ item[0] ] = decodeURIComponent( item[1])
			})

			return obj
		}

		// Params
		vc.atts.typography = {
			parse: function( param ) {
				var google = vc.atts.google_fonts.parse.call( this, param ),
					fonts  = vc.atts.font_container.parse.call( this, param ),
					$block = this.content().find( '.wpb_vc_param_value[name=' + param.param_name + ']' ).parent()
					fontWeight = $block.find( '.vc_font_container_form_field-font_weight-select > option:selected' ).val()

				fontWeight = 'Default' === fontWeight ? '' : '|font_weight:' + fontWeight

				return google + '|' + fonts + fontWeight
			},
			init: function( param, $field ) {
				vc.atts.google_fonts.init( param, $field )
				vc.atts.font_container.init( param, $field )
			}
		};

		vc.atts.image_selector = {
			render: function( param, value ) {
				return vc.atts.dropdown.render( param, value )
			},
			init: function( param, $field ) {
				// var select = $field.find( '.wpb_vc_param_value' );

				var select_id = param.param_name;
				var select = $('.'+select_id);

				$field.find( 'li > input' ).on( 'change', function() {
					var value = $( this ).val();
					select.val( value ).trigger( 'change' )
				});

				vc.atts.dropdown.init( param, $field )
			}
		};

		vc.atts.responsive_spacing = {
			parse: function( param ) {
				var options = {
					desktop: this.content().find( 'input[name=' + param.param_name + '_desktop]' ).val(),
					laptop: this.content().find( 'input[name=' + param.param_name + '_laptop]' ).val(),
					tablet: this.content().find( 'input[name=' + param.param_name + '_tablet]' ).val(),
					mobile: this.content().find( 'input[name=' + param.param_name + '_mobile]' ).val()
				};

				var pieces = _.map( options, function( value, key ) {
					if ( _.isString( value ) && 0 < value.length && ',,,' !== value ) {
						return key + ':' + encodeURIComponent( value )
					}
				});

				pieces = $.grep( pieces, function( value ) {
					return _.isString( value ) && 0 < value.length
				})

				if ( 0 === pieces.length ) {
					return '';
				}

				pieces.push( 'unit:' + encodeURIComponent( this.content().find( 'input[name=' + param.param_name + '_unit]:checked' ).val() ) );
				return pieces.join( '|' );
			},
			init: function( param, $field ) {
				var switchers = $( '.aheto-responsive-switcher', $field ),
					inputs = $( '.aheto-control-input-wrapper input', $field ),
					current = null;

				switchers.on( 'click', function( event ) {
					event.preventDefault();
					var button = $( this ),
						device = button.data( 'device' ),
						values = $( '.aheto-responsive-value-' + device, $field ).val().split( ',' )

					current = $( '.aheto-responsive-value-' + device, $field )
					button.addClass( 'active' ).siblings().removeClass( 'active' )

					inputs.each( function( index ) {
						$( this ).val( values[ index ]);
					});
				});

				inputs.on( 'change keyup', function() {
					var value = [];
					inputs.each( function() {
						value.push( $( this ).val() )
					});

					current.val( value.join( ',' ) ).trigger( 'change' );
				});

				// Set values.
				var values = vcParseMultiAttribute( this.model.get( 'params' )[ param.param_name ], {
					desktop: ',,,',
					laptop: ',,,',
					tablet: ',,,',
					mobile: ',,,',
					unit: 'px'
				});

				$( '.aheto-responsive-value-desktop', $field ).val( values.desktop );
				$( '.aheto-responsive-value-laptop', $field ).val( values.laptop );
				$( '.aheto-responsive-value-tablet', $field ).val( values.tablet );
				$( '.aheto-responsive-value-mobile', $field ).val( values.mobile );
				$( 'input[name=' + param.param_name + '_unit][value=' + values.unit + ']', $field ).prop( 'checked', true );

				switchers.eq( 0 ).trigger( 'click' );
			}
		}
	})

}( jQuery ) )
