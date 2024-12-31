/*global aheto*/

import jQuery from 'jquery'

class AhetoTemplateKit {
    constructor() {
        this.currentID = 0
        this.templateModal = jQuery( '#template-modal-content' )
        this.filters()
        this.modal()
        this.import()
    }

    filters() {
        jQuery( '.filter-nav' ).select2( {
            width: '100%',
            placeholder: 'Select category',
        } ).on( 'select2:select', ( e ) => {
            const selectedElement = jQuery( e.currentTarget )
            const selectVal = selectedElement.val()
            const allOptions = selectedElement.find( 'option' )
            let targetFilter = 'tk-all'
            let targetTitle = 'All'

            allOptions.each( function() {
                const option = jQuery( this )
                const optionVal = option.val()

                if ( optionVal === selectVal ) {
                    targetFilter = option.data( 'filter' )
                    targetTitle = option.attr( 'data-title' )
                }
            } )

            this.updateGallery( targetFilter, targetTitle )
        } )
    }

    updateGallery( targetFilter, targetTitle ) {
        const container = jQuery( '.filter-content' )

        if ( 'tk-all' === targetFilter ) {
            container.fadeOut( 300, function() {
                jQuery( '.post' ).show()
                container.fadeIn()
            } )
        } else {
            container.find( '.post' ).each( function( index, element ) {
                container.fadeOut( 300, function() {
                    if ( jQuery( element ).hasClass( targetFilter ) ) {
                        jQuery( element ).show()
                    } else {
                        jQuery( element ).hide()
                    }
                    container.fadeIn()
                } )
            } )
        }

        this.templateModal.removeClass( 'show' )
        jQuery( '.filter-title' ).text( targetTitle )
    }

    modal() {
        jQuery( '.post' ).on( 'click', ( e ) => {
            const post = jQuery( e.currentTarget )
            const template = aheto.templates[ post.data( 'index' ) ]

            this.currentID = post.data( 'index' )
            this.templateModal.find( '.template-preview' ).attr( 'href', template.preview_url )
            this.templateModal.find( '.template-title' ).html( template.title )
            this.templateModal.find( '.template-screenshot' ).attr( 'src', template.screenshot )
            this.templateModal.find( '.template-id' ).val( this.currentID )

            this.templateModal.addClass( 'show' )
        } )

        jQuery( '.template-kit-import h3 small' ).on( 'click', () => {
            jQuery( '.post' ).removeClass( 'act' )
            this.templateModal.removeClass( 'show' )
            this.currentID = 0
        } )
    }

    import() {
        const skinTemplate = jQuery( '.action-skin-import ' );
        const importTemplate = jQuery( '.action-template-import ' );
        const createPage = jQuery( 'form', '.template-kit-create-page' );

		jQuery( document ).on( 'click', '.action-skin-import', ( event ) => {
			event.preventDefault();
			this.fetch( 'skin' )
				.done( ( response ) => {
					if ( response.message ) {
						this.addNotice( response.message, 'success', skinTemplate, 3000 )
					}
				} )
		} )

        jQuery( document ).on( 'click', '.action-template-import', ( event ) => {
            event.preventDefault()
            this.fetch( 'template' )
                .done( ( response ) => {
                    if ( response.message ) {
                        this.addNotice( response.message, 'success', importTemplate, 3000 )
                    }
                } )
        } )

        jQuery( document ).on( 'click', '.action-template-create-page', ( event ) => {
            event.preventDefault()

            const title = jQuery( '.aheto-page-name' ).val()
            if ( '' === title ) {
                this.addNotice( 'Please enter title for page.', 'error', createPage, 3000 )
                return
            }

            this.fetch( 'page', { pageTitle: title } )
                .done( ( response ) => {
                    if ( response.message ) {
                        this.addNotice( response.message, 'success', createPage, 3000 )
                    }
                } )
        } )
    }

    fetch( action, data ) {
        return jQuery.ajax(
            {
                url: window.ajaxurl,
                method: 'post',
                data: jQuery.extend(
                    {},
                    {
                        action: 'aheto_import_' + action,
                        security: aheto.security,
                        templateID: this.currentID,
                    },
                    data
                ),
            }
        )
    }

    addNotice( msg, which, after, fadeout ) {
        const notice = jQuery( '<div class="notice notice-' + which + ' is-dismissible"><p>' + msg + '</p></div>' ).hide()

        which = which || 'error'
        fadeout = fadeout || false
        after.next( '.notice' ).remove()
        after.after( notice )
        notice.slideDown()

        jQuery( document ).trigger( 'wp-updates-notice-added' )
        if ( fadeout ) {
            setTimeout( function() {
                notice.fadeOut( () => notice.remove() )
            }, fadeout )
        }
    }

}

( function() {
    new AhetoTemplateKit;

    jQuery('.filter-content .post').on('click', function () {
        jQuery("html, body").animate({ scrollTop: 0 }, "slow");
    });

}( jQuery ) )

