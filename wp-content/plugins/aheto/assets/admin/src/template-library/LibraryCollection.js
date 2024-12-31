import elementor from 'elementor'
import AhetoTemplateLibraryTemplatesEmptyView from '@library/LibraryTemplatesEmpty'
import AhetoTemplateLibraryTemplateRemoteView from '@library/LibraryTemplateRemote'

export default Marionette.CompositeView.extend( {
	template: '#tmpl-aheto-template-library-templates',

	id: 'elementor-template-library-templates',

	childViewContainer: '#elementor-template-library-templates-container',

	reorderOnSort: true,

	emptyView() {
		return new AhetoTemplateLibraryTemplatesEmptyView()
	},

	ui: {
		textFilter: '#elementor-template-library-filter-text',
		selectFilter: '.elementor-template-library-filter-select',
		myFavoritesFilter: '#elementor-template-library-filter-my-favorites',
		orderInputs: '.elementor-template-library-order-input',
		orderLabels: 'label.elementor-template-library-order-label',
	},

	events: {
		'input @ui.textFilter': 'onTextFilterInput',
		'change @ui.selectFilter': 'onSelectFilterChange',
		'change @ui.myFavoritesFilter': 'onMyFavoritesFilterChange',
		'mousedown @ui.orderLabels': 'onOrderLabelsClick',
	},

	comparators: {
		title( model ) {
			return model.get( 'title' ).toLowerCase()
		},
		popularityIndex( model ) {
			let popularityIndex = model.get( 'popularityIndex' )

			if ( ! popularityIndex ) {
				popularityIndex = model.get( 'date' )
			}

			return -popularityIndex
		},
		trendIndex( model ) {
			let trendIndex = model.get( 'trendIndex' )

			if ( ! trendIndex ) {
				trendIndex = model.get( 'date' )
			}

			return -trendIndex
		},
	},

	getChildView() {
		return AhetoTemplateLibraryTemplateRemoteView
	},

	initialize() {
		this.listenTo( elementor.channels.templates, 'filter:change', this._renderChildren )
	},

	filter( childModel ) {
		let passingFilter = true

		jQuery.each( window.ahetoTemplateManager.getFilterTerms(), function( filterTermName ) {
			const filterValue = window.ahetoTemplateManager.getFilter( filterTermName )

			if ( ! filterValue ) {
				return
			}

			if ( this.callback ) {
				const callbackResult = this.callback.call( childModel, filterValue )

				if ( ! callbackResult ) {
					passingFilter = false
				}

				return callbackResult
			}

			const filterResult = filterValue === childModel.get( filterTermName )

			if ( ! filterResult ) {
				passingFilter = false
			}

			return filterResult
		} )

		return passingFilter
	},

	order( by, reverseOrder ) {
		let comparator = this.comparators[ by ] || by

		if ( reverseOrder ) {
			comparator = this.reverseOrder( comparator )
		}

		this.collection.comparator = comparator

		this.collection.sort()
	},

	reverseOrder( comparator ) {
		if ( 'function' !== typeof comparator ) {
			const comparatorValue = comparator

			comparator = function( model ) {
				return model.get( comparatorValue )
			}
		}

		return function( left, right ) {
			const l = comparator( left )
			if ( undefined === l ) {
				return -1
			}

			const r = comparator( right )
			if ( undefined === r ) {
				return 1
			}

			if ( l < r ) {
				return 1
			}
			if ( l > r ) {
				return -1
			}
			return 0
		}
	},

	addSourceData() {
		const isEmpty = this.children.isEmpty()

		this.$el.attr( 'data-template-source', isEmpty ? 'empty' : window.ahetoTemplateManager.getFilter( 'source' ) )
	},

	setFiltersUI() {
		const $filters = this.$( this.ui.selectFilter )

		$filters.select2( {
			placeholder: elementor.translate( 'category' ),
			allowClear: true,
			width: 150,
		} )
	},

	setMasonrySkin() {
		const masonry = new elementorModules.utils.Masonry( {
			container: this.$childViewContainer,
			items: this.$childViewContainer.children(),
		} )

		this.$childViewContainer.imagesLoaded( masonry.run.bind( masonry ) )
	},

	toggleFilterClass() {
		this.$el.toggleClass( 'elementor-templates-filter-active', ! ! ( window.ahetoTemplateManager.getFilter( 'text' ) || window.ahetoTemplateManager.getFilter( 'favorite' ) ) )
	},

	onRenderCollection() {
		this.addSourceData()

		this.toggleFilterClass()

		if ( 'aheto' === window.ahetoTemplateManager.getFilter( 'source' ) && 'page' !== window.ahetoTemplateManager.getFilter( 'type' ) ) {
			this.setFiltersUI()

			this.setMasonrySkin()
		}
	},

	onBeforeRenderEmpty() {
		this.addSourceData()
	},

	onTextFilterInput() {
		window.ahetoTemplateManager.setFilter( 'text', this.ui.textFilter.val() )
	},

	onSelectFilterChange( event ) {
		const $select = jQuery( event.currentTarget ),
			filterName = $select.data( 'elementor-filter' )

		window.ahetoTemplateManager.setFilter( filterName, $select.val() )
	},

	onMyFavoritesFilterChange() {
		window.ahetoTemplateManager.setFilter( 'favorite', this.ui.myFavoritesFilter[ 0 ].checked )
	},

	onOrderLabelsClick( event ) {
		const $clickedInput = jQuery( event.currentTarget.control )
		let toggle

		if ( ! $clickedInput[ 0 ].checked ) {
			toggle = 'asc' !== $clickedInput.data( 'default-ordering-direction' )
		}

		$clickedInput.toggleClass( 'elementor-template-library-order-reverse', toggle )

		this.order( $clickedInput.val(), $clickedInput.hasClass( 'elementor-template-library-order-reverse' ) )
	},
} )
