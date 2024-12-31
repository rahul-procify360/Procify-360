import elementor from 'elementor'
import Component from '@library/Component'
import AhetoTemplateCollection from '@library/TemplateCollection'

const Manager = function() {
	this.modalConfig = {}

	const self = this,
		templateTypes = {}

	let deleteDialog,
		errorDialog,
		templatesCollection,
		config = {},
		filterTerms = {}

	const registerDefaultTemplateTypes = function() {
		const data = {
			saveDialog: {
				description: elementor.translate( 'save_your_template_description' ),
			},
			ajaxParams: {
				success( successData ) {
					$e.route( 'ahetolibrary/templates/my-templates', {
						onBefore: () => {
							if ( templatesCollection ) {
								const itemExist = templatesCollection.findWhere( {
									template_id: successData.template_id,
								} )

								if ( ! itemExist ) {
									templatesCollection.add( successData )
								}
							}
						},
					} )
				},
				error( errorData ) {
					self.showErrorDialog( errorData )
				},
			},
		}

		_.each( [ 'page', 'section', elementor.config.document.type ], function( type ) {
			const safeData = jQuery.extend( true, {}, data, {
				saveDialog: {
					title: elementor.translate( 'save_your_template', [ elementor.translate( type ) ] ),
				},
			} )

			self.registerTemplateType( type, safeData )
		} )
	}

	const registerDefaultFilterTerms = function() {
		filterTerms = {
			text: {
				callback( value ) {
					value = value.toLowerCase()

					if ( this.get( 'title' ).toLowerCase().indexOf( value ) >= 0 ) {
						return true
					}

					return _.any( this.get( 'tags' ), function( tag ) {
						return tag.toLowerCase().indexOf( value ) >= 0
					} )
				},
			},
			type: {},
			subtype: {},
			favorite: {},
		}
	}

	this.init = function() {
		registerDefaultTemplateTypes()

		registerDefaultFilterTerms()

		this.component = $e.components.register( new Component( { manager: this } ) )

		elementor.addBackgroundClickListener( 'libraryToggleMore', {
			element: '.elementor-template-library-template-more',
		} )
	}

	this.getTemplateTypes = function( type ) {
		if ( type ) {
			return templateTypes[ type ]
		}

		return templateTypes
	}

	this.registerTemplateType = function( type, data ) {
		templateTypes[ type ] = data
	}

	this.deleteTemplate = function( templateModel, options ) {
		const dialog = self.getDeleteDialog()

		dialog.onConfirm = function() {
			if ( options.onConfirm ) {
				options.onConfirm()
			}

			elementorCommon.ajax.addRequest( 'delete_template', {
				data: {
					source: templateModel.get( 'source' ),
					template_id: templateModel.get( 'template_id' ),
				},
				success( response ) {
					templatesCollection.remove( templateModel, { silent: true } )

					if ( options.onSuccess ) {
						options.onSuccess( response )
					}
				},
			} )
		}

		dialog.show()
	}

	this.importTemplate = function( templateModel, options ) {
		options = options || {}

		self.layout.showLoadingView()
		self.requestTemplateContent( templateModel.get( 'source' ), templateModel.get( 'template_id' ), {
			data: {
				page_settings: options.withPageSettings,
			},
			success( data ) {
				// Clone `self.modalConfig` because it deleted during the closing.
				const importOptions = jQuery.extend( {}, self.modalConfig.importOptions )

				// Hide for next open.
				self.layout.hideLoadingView()

				self.layout.hideModal()

				elementor.channels.data.trigger( 'template:before:insert', templateModel )

				elementor.getPreviewView().addChildModel( data.content, importOptions )

				elementor.channels.data.trigger( 'template:after:insert', templateModel )

				if ( options.withPageSettings ) {
					elementor.settings.page.model.setExternalChange( data.page_settings )
				}

				if ( importOptions.inside ) {
					elementor.getPreviewView().children.findByIndex( importOptions.at ).destroyAddSectionView()
				}
			},
			error( data ) {
				self.showErrorDialog( data )
			},
			complete() {
				self.layout.hideLoadingView()
			},
		} )
	}

	this.saveTemplate = function( type, data ) {
		const templateType = templateTypes[ type ]

		_.extend( data, {
			source: 'local',
			type,
		} )

		if ( templateType.prepareSavedData ) {
			data = templateType.prepareSavedData( data )
		}

		data.content = JSON.stringify( data.content )

		const ajaxParams = { data }

		if ( templateType.ajaxParams ) {
			_.extend( ajaxParams, templateType.ajaxParams )
		}

		elementorCommon.ajax.addRequest( 'save_template', ajaxParams )
	}

	this.requestTemplateContent = function( source, id, ajaxOptions ) {
		const options = {
			unique_id: id,
			data: {
				source,
				edit_mode: true,
				display: true,
				template_id: id,
			},
		}

		if ( ajaxOptions ) {
			jQuery.extend( true, options, ajaxOptions )
		}

		return elementorCommon.ajax.addRequest( 'get_template_data', options )
	}

	this.markAsFavorite = function( templateModel, favorite ) {
		const options = {
			data: {
				source: templateModel.get( 'source' ),
				template_id: templateModel.get( 'template_id' ),
				favorite,
			},
		}

		return elementorCommon.ajax.addRequest( 'mark_template_as_favorite', options )
	}

	this.getDeleteDialog = function() {
		if ( ! deleteDialog ) {
			deleteDialog = elementorCommon.dialogsManager.createWidget( 'confirm', {
				id: 'elementor-template-library-delete-dialog',
				headerMessage: elementor.translate( 'delete_template' ),
				message: elementor.translate( 'delete_template_confirm' ),
				strings: {
					confirm: elementor.translate( 'delete' ),
				},
			} )
		}

		return deleteDialog
	}

	this.getErrorDialog = function() {
		if ( ! errorDialog ) {
			errorDialog = elementorCommon.dialogsManager.createWidget( 'alert', {
				id: 'elementor-template-library-error-dialog',
				headerMessage: elementor.translate( 'an_error_occurred' ),
			} )
		}

		return errorDialog
	}

	this.getTemplatesCollection = function() {
		return templatesCollection
	}

	this.getConfig = function( item ) {
		if ( item ) {
			return config[ item ] ? config[ item ] : {}
		}

		return config
	}

	this.requestLibraryData = function( options ) {
		if ( templatesCollection && ! options.forceUpdate ) {
			if ( options.onUpdate ) {
				options.onUpdate()
			}

			return
		}

		if ( options.onBeforeUpdate ) {
			options.onBeforeUpdate()
		}

		const ajaxOptions = {
			data: {},
			success( data ) {
				templatesCollection = new AhetoTemplateCollection( data.templates )

				if ( data.config ) {
					config = data.config
				}

				if ( options.onUpdate ) {
					options.onUpdate()
				}
			},
		}

		if ( options.forceSync ) {
			ajaxOptions.data.sync = true
		}

		elementorCommon.ajax.addRequest( 'get_library_data', ajaxOptions )
	}

	this.getFilter = function( name ) {
		return elementor.channels.templates.request( 'filter:' + name )
	}

	this.setFilter = function( name, value, silent ) {
		elementor.channels.templates.reply( 'filter:' + name, value )

		if ( ! silent ) {
			elementor.channels.templates.trigger( 'filter:change' )
		}
	}

	this.getFilterTerms = function( termName ) {
		if ( termName ) {
			return filterTerms[ termName ]
		}

		return filterTerms
	}

	this.setScreen = function( args ) {
		elementor.channels.templates.stopReplying()

		self.setFilter( 'source', args.source, true )
		self.setFilter( 'type', args.type, true )
		self.setFilter( 'subtype', args.subtype, true )

		self.showTemplates()
	}

	this.loadTemplates = function( onUpdate ) {
		self.requestLibraryData( {
			onBeforeUpdate: self.layout.showLoadingView.bind( self.layout ),
			onUpdate() {
				self.layout.hideLoadingView()

				if ( onUpdate ) {
					onUpdate()
				}
			},
		} )
	}

	this.showTemplates = function() {
		// The tabs should exist in DOM on loading.
		self.layout.setHeaderDefaultParts()

		self.loadTemplates( function() {
			const templatesToShow = self.filterTemplates()

			self.layout.showTemplatesView( new AhetoTemplateCollection( templatesToShow ) )
		} )
	}

	this.filterTemplates = function() {
		const activeSource = self.getFilter( 'source' )
		return templatesCollection.filter( function( model ) {
			if ( activeSource !== model.get( 'source' ) ) {
				return false
			}

			const typeInfo = templateTypes[ model.get( 'type' ) ]

			return ! typeInfo || false !== typeInfo.showInLibrary
		} )
	}

	this.showErrorDialog = function( errorMessage ) {
		if ( 'object' === typeof errorMessage ) {
			let message = ''

			_.each( errorMessage, function( error ) {
				message += '<div>' + error.message + '.</div>'
			} )

			errorMessage = message
		} else if ( errorMessage ) {
			errorMessage += '.'
		} else {
			errorMessage = '<i>&#60;The error message is empty&#62;</i>'
		}

		self.getErrorDialog()
			.setMessage( elementor.translate( 'templates_request_error' ) + '<div id="elementor-template-library-error-info">' + errorMessage + '</div>' )
			.show()
	}
}
export default Manager
