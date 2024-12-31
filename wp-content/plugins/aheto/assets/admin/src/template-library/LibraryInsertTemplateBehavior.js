import elementor from 'elementor'

let AhetoTemplateLibraryInsertTemplateBehavior = null
AhetoTemplateLibraryInsertTemplateBehavior = Marionette.Behavior.extend( {
	ui: {
		insertButton: '.elementor-template-library-template-insert',
	},

	events: {
		'click @ui.insertButton': 'onInsertButtonClick',
	},

	onInsertButtonClick() {
		const autoImportSettings = elementor.config.document.remoteLibrary.autoImportSettings

		if ( ! autoImportSettings && this.view.model.get( 'hasPageSettings' ) ) {
			AhetoTemplateLibraryInsertTemplateBehavior.showImportDialog( this.view.model )

			return
		}

		window.ahetoTemplateManager.importTemplate( this.view.model, { withPageSettings: autoImportSettings } )
	},
}, {
	dialog: null,

	showImportDialog( model ) {
		const dialog = AhetoTemplateLibraryInsertTemplateBehavior.getDialog()

		dialog.onConfirm = function() {
			window.ahetoTemplateManager.importTemplate( model, { withPageSettings: true } )
		}

		dialog.onCancel = function() {
			window.ahetoTemplateManager.importTemplate( model )
		}

		dialog.show()
	},

	initDialog() {
		AhetoTemplateLibraryInsertTemplateBehavior.dialog = elementorCommon.dialogsManager.createWidget( 'confirm', {
			id: 'elementor-insert-template-settings-dialog',
			headerMessage: elementor.translate( 'import_template_dialog_header' ),
			message: elementor.translate( 'import_template_dialog_message' ) + '<br>' + elementor.translate( 'import_template_dialog_message_attention' ),
			strings: {
				confirm: elementor.translate( 'yes' ),
				cancel: elementor.translate( 'no' ),
			},
		} )
	},

	getDialog() {
		if ( ! AhetoTemplateLibraryInsertTemplateBehavior.dialog ) {
			AhetoTemplateLibraryInsertTemplateBehavior.initDialog()
		}

		return AhetoTemplateLibraryInsertTemplateBehavior.dialog
	},
} )

export default AhetoTemplateLibraryInsertTemplateBehavior
