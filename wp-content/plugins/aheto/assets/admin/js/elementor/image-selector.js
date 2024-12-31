/*eslint no-undef:0*/
jQuery( window ).on( 'elementor:init', function() {
	var ControlImageSelectorItemView = elementor.modules.controls.BaseData.extend({
		ui: function() {
			var ui = elementor.modules.controls.BaseData.prototype.ui.apply( this, arguments )

			ui.inputs = '[type="radio"]';

			return ui;
		},

		events: function() {
			return _.extend( elementor.modules.controls.BaseData.prototype.events.apply( this, arguments ), {
				'mousedown label': 'onMouseDownLabel',
				'click @ui.inputs': 'onClickInput',
				'change @ui.inputs': 'onBaseInputChange'
			});
		},

		onMouseDownLabel: function( event ) {
			var $clickedLabel = this.$( event.currentTarget ),
				$selectedInput = this.$( '#' + $clickedLabel.attr( 'for' ) );

			$selectedInput.data( 'checked', $selectedInput.prop( 'checked' ) );
		},

		onClickInput: function( event ) {
			if ( ! this.model.get( 'toggle' ) ) {
				return;
			}

			var $selectedInput = this.$( event.currentTarget );

			if ( $selectedInput.data( 'checked' ) ) {
				$selectedInput.prop( 'checked', false ).trigger( 'change' );
			}
		},

		onRender: function() {
			elementor.modules.controls.BaseData.prototype.onRender.apply( this, arguments );

			var currentValue = this.getControlValue();

			if ( currentValue ) {
				this.ui.inputs.filter( '[value="' + currentValue + '"]' ).prop( 'checked', true );
			}
		}
	});

	elementor.addControlView( 'image_selector', ControlImageSelectorItemView );

});
