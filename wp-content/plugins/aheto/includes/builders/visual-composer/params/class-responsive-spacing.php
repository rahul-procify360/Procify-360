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

use Aheto\Sanitize;

defined( 'ABSPATH' ) || exit;

/**
 * Responsive_Spacing base class.
 */
class Responsive_Spacing {

	/**
	 * The Constructor.
	 */
	public function __construct() {
		vc_add_shortcode_param( 'responsive_spacing', [ $this, 'render' ] );
	}

	/**
	 * Render typography field
	 *
	 * @param  mixed $settings Param settings.
	 * @param  mixed $value    Param values.
	 * @return string
	 */
	public function render( $settings, $value ) {
		$settings = wp_parse_args( $settings, [
			'units' => [ 'px', 'em', 'rem' ],
			'text'  => [
				'top'    => 'Top',
				'right'  => 'Right',
				'bottom' => 'Bottom',
				'left'   => 'Left',
			],
		]);

		$value = wp_parse_args( $value, [
			'desktop' => ',,,,',
			'laptop'  => ',,,,',
			'tablet'  => ',,,,',
			'mobile'  => ',,,,',
			'unit'    => $settings['units'][0],
		]);
		ob_start();
		?>
		<div class="aheto-responsive-control">

			<div class="aheto-responsive-switchers">
				<a class="aheto-responsive-switcher" data-device="desktop"><i class="fa fa-desktop"></i></a>
				<a class="aheto-responsive-switcher" data-device="laptop"><i class="fa fa-laptop"></i></a>
				<a class="aheto-responsive-switcher" data-device="tablet"><i class="fa fa-tablet"></i></a>
				<a class="aheto-responsive-switcher" data-device="mobile"><i class="fa fa-mobile"></i></a>
			</div>

			<div class="aheto-responsive-units">
				<?php foreach ( $settings['units'] as $unit ) : ?>
				<input type="radio" id="<?php echo $settings['param_name'] . "-{$unit}"; ?>" name="<?php echo $settings['param_name'] . '_unit'; ?>" value="<?php echo $unit; ?>">
				<label for="<?php echo $settings['param_name'] . "-{$unit}"; ?>"><?php echo $unit; ?></label>
				<?php endforeach; ?>
			</div>

			<ul class="aheto-control-input-wrapper">

				<?php
				foreach ( $settings['text'] as $property => $label ) :
					$property = $settings['param_name'] . '-' . $property;
					?>
				<li class="aheto-control-dimension">
					<input id="<?php echo $property; ?>" type="number">
					<label for="<?php echo $property; ?>"><?php echo $label; ?></label>
				</li>
				<?php endforeach; ?>

			</ul>

			<input type="hidden" name="<?php echo $settings['param_name']; ?>" class="wpb_vc_param_value" value="1">
			<input type="hidden" name="<?php echo $settings['param_name']; ?>_desktop" class="aheto-responsive-value-desktop" value="<?php echo $value['desktop']; ?>">
			<input type="hidden" name="<?php echo $settings['param_name']; ?>_laptop" class="aheto-responsive-value-laptop" value="<?php echo $value['laptop']; ?>">
			<input type="hidden" name="<?php echo $settings['param_name']; ?>_tablet" class="aheto-responsive-value-tablet" value="<?php echo $value['tablet']; ?>">
			<input type="hidden" name="<?php echo $settings['param_name']; ?>_mobile" class="aheto-responsive-value-mobile" value="<?php echo $value['mobile']; ?>">

		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Parse value.
	 *
	 * @param  string $value Value to parse.
	 * @param  string $type  Type for spacing, either padding or margin.
	 * @return array
	 */
	public static function parse( $value, $type = 'padding' ) {
		$value = vc_parse_multi_attribute( $value );

		if ( isset( $value['desktop'] ) ) {
			$value['desktop'] = self::parse_single( $value['desktop'], $value['unit'], $type );
		}
		if ( isset( $value['laptop'] ) ) {
			$value['laptop'] = self::parse_single( $value['laptop'], $value['unit'], $type );
		}
		if ( isset( $value['tablet'] ) ) {
			$value['tablet'] = self::parse_single( $value['tablet'], $value['unit'], $type );
		}
		if ( isset( $value['mobile'] ) ) {
			$value['mobile'] = self::parse_single( $value['mobile'], $value['unit'], $type );
		}

		unset( $value['unit'] );

		return array_filter( $value );
	}

	/**
	 * Parse screen value.
	 *
	 * @param  string $value Value to parse.
	 * @param  string $unit  Unit to append.
	 * @param  string $type  Type for spacing, either padding or margin.
	 * @return string
	 */
	private static function parse_single( $value, $unit, $type = 'padding' ) {
		if ( 'single' !== $type ) {
			$props = 'border-radius' === $type ? [ 'top-left', 'top-right', 'bottom-left', 'bottom-right' ] : [ 'top', 'right', 'bottom', 'left' ];
			$value = explode( ',', $value );
			$value = array_map( 'trim', $value );
			$value = array_combine( $props, $value );
		}

		if ( empty( $value ) ) {
			return '';
		}

		if ( 'single' === $type ) {
			return Sanitize::size( $value, $unit );
		}

		$value['units'] = $unit;

		if ( is_array( $type ) ) {
			$value['style'] = $type[0];
			$value['color'] = $type[1];
			return Sanitize::border( $value );
		}

		if ( 'border-radius' === $type ) {
			return Sanitize::border_radius( $value );
		}

		return Sanitize::spacing( $value, $type );
	}
}
