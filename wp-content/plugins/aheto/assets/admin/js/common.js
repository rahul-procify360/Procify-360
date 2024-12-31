( function( $ ) {

	// Document Ready
	$( function() {

		var ahetoAdmin = {

			init: function() {
				this.tabs()
				this.misc()
				this.notifications()
				this.dependencyManager()
				this.editing_skin()
			},

			notifications: function() {
				$( '.aheto-alert.is-dismissible' ).on( 'click', '.notice-dismiss', function() {
					var notice = $( this ).parent()
					$.ajax({
						url: ajaxurl,
						type: 'POST',
						dataType: 'json',
						data: {
							action: 'aheto_notice_dismissible',
							security: notice.data( 'security' ),
							notificationId: notice.attr( 'id' )
						}
					})
				})
			},

			// Settings Tabs
			tabs: function() {
				let settingTabWrapper = $( '.cmb2-tabs-navigation' );
				if ( ! settingTabWrapper.length ) {
					return;
				}

				settingTabWrapper.each( function() {
					var wrapper = $( this ),
						container = wrapper.parent(),
						nav = $( '>a', wrapper ),
						panels = $( '>.cmb2-tabs-content>.cmb2-panel', container ),
						activeClass = wrapper.data( 'active-class' ) || 'active';

					function getURIParameter(param, asArray) {
						return document.location.search.substring(1).split('&').reduce(function(p,c) {
							var parts = c.split('=', 2).map(function(param) { return decodeURIComponent(param); });
							if(parts.length == 0 || parts[0] != param) return (p instanceof Array) && !asArray ? null : p;
							return asArray ? p.concat(parts.concat(true)[1]) : parts.concat(true)[1];
						}, []);
					}

					$(window).on('load', function () {

						if (getURIParameter("open")){
							nav.removeClass( activeClass );
							panels.hide();
							$('.cmb2-tabs-navigation a[href="#setting-panel-colors"]').each(function() {
								$(this).addClass( activeClass );
							});
							$( '#setting-panel-colors' ).show();
						}

					});

					// Click Event
					nav.on( 'click', function() {
						var $this = $( this ),
							target = $this.attr( 'href' )

						nav.removeClass( activeClass )
						panels.hide()

						$this.addClass( activeClass )
						$( target ).show()

						if($this.data('icon').includes(' ')){
							wrapper.closest('.cmb2-panel-container').find('.options-page-title-wrap img').remove();
							wrapper.closest('.cmb2-panel-container').find('.options-page-title-wrap .img-box').addClass($this.data('icon'));
						}else{
							wrapper.closest('.cmb2-panel-container').find('.options-page-title-wrap img').attr('src', $this.data('icon'));
						}


						wrapper.closest('.cmb2-panel-container').find('.options-page-title').text($this.text());


                        if ($( "#setting-panel-container-aheto-skin-generator_options" ).length) {
                            setTimeout(updateSkin, 0);

                            function updateSkin() {
                                let activeSkin = $('.active_skin').find('.aheto_skin_name').val();
                                wrapper.closest('.cmb2-panel-container').find('.options-page-title').text('Design');
                                let infoFontFamily = document.createElement("span");
                                infoFontFamily.classList.add('skin_name');

                                infoFontFamily.innerHTML = activeSkin;
                                wrapper.closest('.cmb2-panel-container').find('.options-page-title').append(infoFontFamily);

                                var createA = document.createElement('a');
                                createA.classList.add('skin_change');
                                createA.innerHTML = 'Change Skin';
                                wrapper.closest('.cmb2-panel-container').find('.options-page-title').append(createA);

                                $('.skin_change').on( 'click', function() {
                                    nav.removeClass( activeClass );
                                    panels.hide();
                                    $('.cmb2-tabs-navigation a[href="#setting-panel-skins"]').each(function() {
                                        $(this).addClass( activeClass );
                                    });
                                    $('#setting-panel-skins').show();
                                });
                                // $('.edit-skin-js').on( 'click', function() {
                                //     nav.removeClass( activeClass );
                                //     panels.hide();
                                //     $('.cmb2-tabs-navigation a[href="#setting-panel-colors"]').each(function() {
                                //         $(this).addClass( activeClass );
                                //     });
                                //     $( '#setting-panel-colors' ).show();
                                // });
								$('.skins__inner').on( 'click', function() {
                                   let href = $(this).data('href');

                                   if(href.length){
									   window.location.href = href;
								   }

                                });
                            }
						}

						// Save in localStorage
						localStorage.setItem( container.attr( 'id' ), target )

						return false
					});
                    $( '>a:first-of-type', wrapper ).trigger('click');

					var target = localStorage.getItem( container.attr( 'id' ) );
					if ( null === target ) {
						nav.eq( 0 ).trigger( 'click' )
					} else {
						target = $( 'a[href="' + target + '"]', wrapper );
						if ( target.length ) {
							target.trigger( 'click' );
						} else {
							nav.eq( 0 ).trigger( 'click' );
						}
					}

					// Set min height
					settingTabWrapper.next().css( 'min-height', wrapper.outerHeight() )
				})
			},

			dependencyManager: function() {
				var self = this

				// Group correction
				var elem = $( '.aheto-wrap-settings > .cmb-form, .aheto-metabox-wrap' )
				$( '.cmb-repeat-group-wrap', elem ).each( function() {
					var $this = $( this ),
						dep = $this.next( '.cmb-dependency.hidden' )

					if ( dep.length ) {
						$this.find( '> .cmb-td' ).append( dep )
					}
				})

				$( '.cmb-dependency', elem ).each( function() {
					self.loopDependencies( $( this ) )
				})

				$( 'input, select', elem ).on( 'change', function() {
					var fieldName = $( this ).attr( 'name' )

					$( 'span[data-field="' + fieldName + '"]' ).each( function() {
						self.loopDependencies( $( this ).closest( '.cmb-dependency' ) )
					})
				})
			},

			checkDependency: function( currentValue, desiredValue, comparison ) {

				// Multiple values
				if ( 'string' === typeof desiredValue && desiredValue.includes( ',' ) && '=' === comparison ) {
					return desiredValue.includes( currentValue )
				}
				if ( 'string' === typeof desiredValue && desiredValue.includes( ',' ) && '!=' === comparison ) {
					return ! desiredValue.includes( currentValue )
				}
				if ( '=' === comparison && currentValue === desiredValue ) {
					return true
				}
				if ( '==' === comparison && currentValue === desiredValue ) {
					return true
				}
				if ( '>=' === comparison && currentValue >= desiredValue ) {
					return true
				}
				if ( '<=' === comparison && currentValue <= desiredValue ) {
					return true
				}
				if ( '>' === comparison && currentValue > desiredValue ) {
					return true
				}
				if ( '<' === comparison && currentValue < desiredValue ) {
					return true
				}
				if ( '!=' === comparison && currentValue !== desiredValue ) {
					return true
				}

				return false
			},

			loopDependencies: function( $container ) {


				var self     = this,
					relation = $container.data( 'relation' ),
					passed

				$container.find( 'span' ).each( function() {

					var $this      = $( this ),
						value      = $this.data( 'value' ),
						comparison = $this.data( 'comparison' ),
						field      = $( '[name=\'' + $this.data( 'field' ) + '\']' ),
						fieldValue = field.val()

					if ( field.is( ':radio' ) ) {
						fieldValue = field.filter( ':checked' ).val()
					}

					if ( field.is( ':checkbox' ) ) {
						fieldValue = field.is( ':checked' )
					}

					var result = self.checkDependency( fieldValue, value, comparison )

					if ( 'or' === relation && result ) {
						passed = true
						return false
					} else if ( 'and' === relation ) {

						if ( undefined === passed ) {
							passed = result
						} else {
							passed = passed && result
						}
					}
				})

				var hideMe = $container.closest( '.rank-math-cmb-group' )

				if ( ! hideMe.length ) {
					hideMe = $container.closest( '.cmb-row' )
				}

				if ( passed ) {
					hideMe.slideDown( 300 )
				} else {
					hideMe.hide()
				}
			},

			misc: function() {

				$( '.cmb-type-title' ).each( function() {
					$( this ).prev( '.cmb-row' ).addClass( 'cmb-type-title-next' )
				})

				$( '.cmb-group-text-only,.cmb-group-fix-me' ).each( function() {
					var $this  = $( this ),
						nested = $this.find( '.cmb-repeatable-group' ),
						th     = nested.find( '> .cmb-row:eq(0) > .cmb-th' )

					$this.prepend( '<div class="cmb-th"><label>' + th.find( 'h2' ).text() + '</label></div>' )
					nested.find( '.cmb-add-row' ).append( '<span class="cmb2-metabox-description">' + th.find( 'p' ).text() + '</span>' )

					th.parent().remove()
				})
			},

			editing_skin: function () {
				// var $this = $( this ),
				// 	target = $this.attr( 'href' )

				// nav.removeClass( activeClass )
				// panels.hide()
				//
				// $this.addClass( activeClass )
				// $( target ).show()

				// wrapper.next('.cmb2-tabs-content').find('.options-page-title-wrap i').attr('class', $this.data('icon'));
				// wrapper.next('.cmb2-tabs-content').find('.options-page-title').text($this.text());

				// Save in localStorage
				if ( typeof edit_skin != 'undefined' ) {
					// localStorage.setItem( 'setting-panel-container-aheto-skin-generator_options', '#setting-panel-colors', );
				}
			}
		}

		ahetoAdmin.init()
	})


}( jQuery ) )
