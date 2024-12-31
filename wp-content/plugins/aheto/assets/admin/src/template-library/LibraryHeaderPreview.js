import AhetoTemplateLibraryInsertTemplateBehavior from '@library/LibraryInsertTemplateBehavior'

export default Marionette.ItemView.extend( {
	template: '#tmpl-elementor-template-library-header-preview',

	id: 'elementor-template-library-header-preview',

	behaviors: {
		insertTemplate: {
			behaviorClass: AhetoTemplateLibraryInsertTemplateBehavior,
		},
	},
} )
