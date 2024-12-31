<?php
/**
 * The image selector param.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Visual_Composer\Params
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Visual_Composer\Params;

defined( 'ABSPATH' ) || exit;

/**
 * Image_Selector base class.
 */
class Image_Selector {

	/**
	 * The Constructor.
	 */
	public function __construct() {
		vc_add_shortcode_param( 'image_selector', [ $this, 'render' ] );
	}

	/**
	 * Render typography field
	 *
	 * @param  mixed $settings Param settings.
	 * @param  mixed $value    Param values.
	 * @return string
	 */
	public function render( $settings, $value ) {

		$output = '';

		if ( empty( $settings['layouts'] ) ) {
			return '';
		}

		$select = sprintf(
			'<select name="%1$s" class="wpb_vc_param_value wpb-input wpb-select hidden %1$s %2$s">',
			$settings['param_name'],
			$settings['type']
		);
		foreach ( $settings['layouts'] as $key => $data ) {
            $checked = checked( $value, $key, false );

			$output .= sprintf(
				'<li><input type="radio" id="%3$s" name="%4$s" value="%5$s"%6$s><label for="%3$s"><div class="thumbnail-wrapper"><img src="%1$s"></div><span>%2$s</span></label></li>',
				$data['image'], $data['title'],
                $settings['param_name'] . '-' . $key, $settings['param_name'],
				$key, $checked
			);

			$select .= sprintf( '<option value="%2$s"%3$s>%1$s</option>', $data['title'], $key, selected( $value, $key, false ) );
		}

		return $select . '</select><ul class="aheto-image-selector">' . $output . '</ul>';
	}
}
