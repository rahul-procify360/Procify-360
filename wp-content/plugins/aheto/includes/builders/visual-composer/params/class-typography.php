<?php
/**
 * The typography param.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Visual_Composer\Params
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Visual_Composer\Params;

defined('ABSPATH') || exit;

/**
 * Typography base class.
 */
class Typography {

	/**
	 * The Constructor.
	 */
	public function __construct() {
		vc_add_shortcode_param('typography', [$this, 'render']);
		add_filter('vc_google_fonts_get_fonts_filter', [$this, 'add_empty']);
	}

	/**
	 * Add default option.
	 *
	 * @param  array $fonts Font list.
	 *
	 * @return array
	 */
	public function add_empty( $fonts ) {
		$default = \json_decode('[{"font_family":"Use default","font_styles":"regular","font_types":"400 regular:400:normal"}]');
		return $default + $fonts;
	}

	/**
	 * Render typography field
	 *
	 * @param  mixed $settings Param settings.
	 * @param  mixed $value    Param values.
	 *
	 * @return string
	 */
	public function render( $settings, $value ) {
		$this->transform_typography($settings);

		$font_settings = $settings;

		$font_family = '';
		if ( in_array('font_family', $font_settings['settings']['fields']) ) {
			$font_family = vc_google_fonts_form_field($settings, $value);

			$index = array_search('font_family', $font_settings['settings']['fields']);
			unset($font_settings['settings']['fields'][$index]);

			if ( $index = array_search('font_style', $font_settings['settings']['fields']) ) { // @codingStandardsIgnoreLine
				unset($font_settings['settings']['fields'][$index]);
			}
		}

		$font_weight = '';
		if ( in_array('font_weight', $font_settings['settings']['fields']) ) {
			$values = vc_parse_multi_attribute($value, ['font_weight' => 400]);

			$font_weight = '
			<div class="vc_row-fluid vc_column">
				<div class="wpb_element_label">' . __('Font weight', 'aheto') . '</div>
				<div class="vc_font_container_form_field-font_weight-container">
					<select class="vc_font_container_form_field-font_weight-select">';

			$weights = ['Default', 100, 200, 300, 400, 500, 600, 700, 800, 900];
			foreach ( $weights as $weight ) {
				$font_weight .= '<option value="' . $weight . '" class="' . $weight . '" ' . ($values['font_weight'] == $weight ? 'selected' : '') . '>' . $weight . '</option>';
			}
			$font_weight .= '
					</select>
				</div>';
			if ( isset($fields['font_weight_description']) && strlen($fields['font_weight_description']) > 0 ) {
				$font_weight .= '
				<span class="vc_description clear">' . $fields['font_weight_description'] . '</span>
				';
			}

			$font_weight .= '</div>';
		}

		return $font_weight . vc_font_container_form_field($font_settings, $value) . $font_family;
	}

	/**
	 * Parse typography settings.
	 *
	 * @param array $param Array of param.
	 */
	public function transform_typography( &$param ) {
		$defaults = [
			'tag',
			'text_align',
			'font_size',
			'line_height',
			'color',
			'font_family',
			'font_style',
			'font_weight',
			'tag_description'         => esc_html__('Select element tag.', 'aheto'),
			'text_align_description'  => esc_html__('Select text alignment.', 'aheto'),
			'font_weight_description' => esc_html__('Select font weight.', 'aheto'),
			'font_size_description'   => esc_html__('Enter font size.', 'aheto'),
			'line_height_description' => esc_html__('Enter line height.', 'aheto'),
			'color_description'       => esc_html__('Select heading color.', 'aheto'),
			'font_family_description' => esc_html__('Select font family.', 'aheto'),
			'font_style_description'  => esc_html__('Select font style.', 'aheto'),
		];
		$settings = $param['settings'];

		// Exclude.
		foreach ( ['tag', 'text_align', 'font_size', 'line_height', 'color', 'font_family', 'font_style', 'font_weight'] as $index => $key ) {
			if ( isset($settings[$key]) && false === $settings[$key] ) {
				unset($settings[$key]);
				unset($defaults[$index]);
				unset($defaults[$key . '_description']);
			}
		}

		$param['type']     = 'font_container';
		$param['settings'] = [ 'fields' => wp_parse_args( isset( $param['settings'] ) ? $settings : [], $defaults ) ];
	}
}
