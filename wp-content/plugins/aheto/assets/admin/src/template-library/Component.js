import elementor from 'elementor'
import AhetoTemplateLibraryLayoutView from '@library/LibraryLayoutView'

class Component extends elementorModules.common.ComponentModal {
	__construct( args ) {
		// Before contruct because it's used in defaultTabs().
		this.docLibraryConfig = elementor.config.document.remoteLibrary
		this.show = this.show.bind( this )

		super.__construct( args )

		if ( 'block' === this.docLibraryConfig.type ) {
			this.setDefaultRoute( 'templates/blocks' )
		} else {
			this.setDefaultRoute( 'templates/pages' )
		}
	}

	getNamespace() {
		return 'ahetolibrary'
	}

	getModalLayout() {
		return AhetoTemplateLibraryLayoutView
	}

	defaultTabs() {
		return {
			'templates/blocks': {
				title: elementor.translate( 'blocks' ),
				filter: {
					source: 'aheto',
					type: 'block',
					subtype: this.docLibraryConfig.category,
				},
			},
			'templates/pages': {
				title: elementor.translate( 'pages' ),
				filter: {
					source: 'aheto',
					type: 'page',
				},
			},
		}
	}

	defaultRoutes() {
		return {
		}
	}

	defaultCommands() {
		return Object.assign( super.defaultCommands(), {
			open: this.show,
		} )
	}

	getTabsWrapperSelector() {
		return '#elementor-template-library-header-menu'
	}

	renderTab( tab ) {
		this.manager.setScreen( this.tabs[ tab ].filter )
	}

	activateTab( tab ) {
		$e.routes.saveState( 'ahetolibrary' )

		super.activateTab( tab )
	}

	open() {
		window.oldTemplateManager = elementor.templates
		elementor.templates = window.ahetoTemplateManager
		super.open()

		if ( ! this.manager.layout ) {
			this.manager.layout = this.layout
		}

		return true
	}

	close() {
		if ( ! super.close() ) {
			return false
		}

		this.manager.modalConfig = {}
		elementor.templates = window.oldTemplateManager

		return true
	}

	show( args ) {
		this.manager.modalConfig = args

		if ( ! $e.routes.restoreState( 'ahetolibrary' ) ) {
			$e.route( this.getDefaultRoute() )
		}
	}
}

export default Component
