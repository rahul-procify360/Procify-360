import elementor from 'elementor'
import AhetoTemplateLibraryInsertTemplateBehavior from '@library/LibraryInsertTemplateBehavior'

export default Marionette.ItemView.extend( {
	template: '#tmpl-elementor-template-library-template-remote',

	className() {
		let classes = 'elementor-template-library-template'
		classes += ' elementor-template-library-template-remote'
		classes += ' elementor-template-library-template-' + this.model.get( 'type' )

		if ( this.model.get( 'isPro' ) ) {
			classes += ' elementor-template-library-pro-template'
		}

		return classes
	},

	ui() {
		return {
			previewButton: '.elementor-template-library-template-preview',
			favoriteCheckbox: '.elementor-template-library-template-favorite-input',
		}
	},

	events() {
		return {
			'click @ui.previewButton': 'onPreviewButtonClick',
			'change @ui.favoriteCheckbox': 'onFavoriteCheckboxChange',
		}
	},

	behaviors: {
		insertTemplate: {
			behaviorClass: AhetoTemplateLibraryInsertTemplateBehavior,
		},
	},

	onPreviewButtonClick() {
		window.ahetoTemplateManager.layout.showPreviewView( this.model )
	},

	onFavoriteCheckboxChange() {
		const isFavorite = this.ui.favoriteCheckbox[ 0 ].checked

		this.model.set( 'favorite', isFavorite )

		window.ahetoTemplateManager.markAsFavorite( this.model, isFavorite )

		if ( ! isFavorite && window.ahetoTemplateManager.getFilter( 'favorite' ) ) {
			elementor.channels.templates.trigger( 'filter:change' )
		}
	},
} )
