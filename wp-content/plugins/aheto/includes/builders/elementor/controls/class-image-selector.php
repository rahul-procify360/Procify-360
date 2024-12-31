<?php
/**
 * The image selector param.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Elementor\Controls
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Elementor\Controls;

use Elementor\Base_Data_Control;

defined( 'ABSPATH' ) || exit;

/**
 * Image_Selector base class.
 */
class Image_Selector extends Base_Data_Control {

	/**
	 * Get image selector control type.
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'image_selector';
	}

	/**
	 * Get default settings.
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'toggle'      => false,
			'layouts'     => [],
			'label_block' => true,
		];
	}

	/**
	 * Render image selector control output in the editor.
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid( '{{value}}' );
		?>
		<div class="elementor-control-field">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<div class="elementor-choices" style="flex-wrap: wrap; height: auto;">
					<# _.each( data.layouts, function( options, value ) { #>
					<li style="width: 50%;">
						<input id="<?php echo $control_uid; ?>" type="radio" name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="{{ value }}">
						<label class="elementor-choices-label tooltip-target" for="<?php echo $control_uid; ?>" data-tooltip="{{ options.title }}" title="{{ options.title }}" style="display:block; width: 100%;">
							<div class="thumbnail-wrapper"><img src="{{ options.image }}"></div>
							<span class="elementor-screen-only">{{{ options.title }}}</span>
						</label>
					</li>
					<# } ); #>
				</div>
			</div>
		</div>

		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
