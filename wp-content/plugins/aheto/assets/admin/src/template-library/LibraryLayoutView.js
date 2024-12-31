import elementor from 'elementor'
import AhetoTemplateLibraryHeaderMenuView from '@library/LibraryHeaderMenu'
import AhetoTemplateLibraryCollectionView from '@library/LibraryCollection'
import AhetoTemplateLibraryPreviewView from '@library/LibraryPreview'
import AhetoTemplateLibraryHeaderPreviewView from '@library/LibraryHeaderPreview'
import AhetoTemplateLibraryHeaderBackView from '@library/LibraryHeaderBack'

export default elementorModules.common.views.modal.Layout.extend( {
	getModalOptions() {
		return {
			id: 'elementor-template-library-modal',
		}
	},

	getLogoOptions() {
		return {
			title: elementor.translate( 'library' ),
			click() {
				$e.run( 'ahetolibrary/open', { toDefault: true } )
			},
		}
	},

	getTemplateActionButton( templateData ) {
		let viewId = '#tmpl-elementor-template-library-' + ( templateData.isPro ? 'get-pro-button' : 'insert-button' )
		viewId = elementor.hooks.applyFilters( 'elementor/editor/template-library/template/action-button', viewId, templateData )

		const template = Marionette.TemplateCache.get( viewId )

		return Marionette.Renderer.render( template )
	},

	setHeaderDefaultParts() {
		const headerView = this.getHeaderView()

		headerView.menuArea.show( new AhetoTemplateLibraryHeaderMenuView() )

		this.showLogo()
	},

	showTemplatesView( templatesCollection ) {
		this.modalContent.show( new AhetoTemplateLibraryCollectionView( {
			collection: templatesCollection,
		} ) )
	},

	showPreviewView( templateModel ) {
		this.modalContent.show( new AhetoTemplateLibraryPreviewView( {
			url: templateModel.get( 'url' ),
		} ) )

		const headerView = this.getHeaderView()

		headerView.menuArea.reset()

		headerView.tools.show( new AhetoTemplateLibraryHeaderPreviewView( {
			model: templateModel,
		} ) )

		headerView.logoArea.show( new AhetoTemplateLibraryHeaderBackView() )
	},
} )
