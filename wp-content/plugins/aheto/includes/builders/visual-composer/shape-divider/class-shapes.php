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

use Aheto\Sanitize;

defined( 'ABSPATH' ) || exit;

/**
 * Shapes base class.
 */
class Shapes {

	/**
	 * The exclude filter.
	 */
	const FILTER_EXCLUDE = 'exclude';

	/**
	 * The include filter.
	 */
	const FILTER_INCLUDE = 'include';

	/**
	 * Shapes.
	 *
	 * Holds the list of supported shapes.
	 *
	 * @var array A list of supported shapes.
	 */
	private static $shapes;

	/**
	 * Shapes options.
	 *
	 * @var array A list of shapes for dropdown.
	 */
	private static $shapes_options;

	/**
	 * Register Prams.
	 */
	public static function register_param() {
		vc_add_params( 'vc_row', self::get_shape_param( 'top' ) );
		vc_add_params( 'vc_row', self::get_shape_param( 'bottom' ) );
	}

	/**
	 * Get shaps param
	 *
	 * @param string $prefix Prefix.
	 *
	 * @return array
	 */
	private static function get_shape_param( $prefix ) {
		self::get_shapes();
		$group    = 'Shape Divider';
		$base_key = 'shape_divider_' . $prefix;

		return [
			[
				'type'             => 'heading',
				'heading'          => 'Shape Divider ' . ucwords( $prefix ),
				'param_name'       => $base_key . '_heading',
				'group'            => $group,
				'edit_field_class' => 'colored-heading',
			],
			[
				'type'       => 'dropdown',
				'heading'    => __( 'Type', 'aheto' ),
				'param_name' => $base_key,
				'value'      => [ 'None' => '' ] + self::$shapes_options,
				'group'      => $group,
			],
			[
				'type'       => 'colorpicker',
				'heading'    => __( 'Color', 'aheto' ),
				'param_name' => $base_key . '_color',
				'group'      => $group,
				'dependency' => [
					'element'   => $base_key,
					'not_empty' => true,
				],
			],
			[
				'type'             => 'responsive_spacing',
				'heading'          => __( 'Width', 'aheto' ),
				'param_name'       => $base_key . '_width',
				'group'            => $group,
				'text'             => [ 'width' => 'Width' ],
				'edit_field_class' => 'vc_column-with-padding vc_col-xs-6 fullwidth-responsive-control',
				'dependency'       => [
					'element' => $base_key,
					'value'   => array_keys( self::filter_shapes( 'height_only', self::FILTER_EXCLUDE ) ),
				],
			],
			[
				'type'             => 'responsive_spacing',
				'heading'          => __( 'Height', 'aheto' ),
				'param_name'       => $base_key . '_height',
				'group'            => $group,
				'text'             => [ 'height' => 'Height' ],
				'edit_field_class' => 'vc_column-with-padding vc_col-xs-6  fullwidth-responsive-control',
				'dependency'       => [
					'element'   => $base_key,
					'not_empty' => true,
				],
			],
			[
				'type'       => 'checkbox',
				'heading'    => __( 'Flip', 'aheto' ),
				'param_name' => $base_key . '_flip',
				'group'      => $group,
				'dependency' => [
					'element' => $base_key,
					'value'   => array_keys( self::filter_shapes( 'has_flip' ) ),
				],
			],
			[
				'type'       => 'checkbox',
				'heading'    => __( 'Invert', 'aheto' ),
				'param_name' => $base_key . '_negative',
				'group'      => $group,
				'dependency' => [
					'element' => $base_key,
					'value'   => array_keys( self::filter_shapes( 'has_negative' ) ),
				],
			],
			[
				'type'       => 'checkbox',
				'heading'    => __( 'Bring to Front', 'aheto' ),
				'param_name' => $base_key . '_above_content',
				'group'      => $group,
				'dependency' => [
					'element'   => $base_key,
					'not_empty' => true,
				],
			],
		];
	}

	/**
	 * Get shapes.
	 *
	 * Retrieve a shape from the lists of supported shapes. If no shape specified
	 * it will return all the supported shapes.
	 *
	 * @param array $shape Optional. Specific shape. Default is `null`.
	 *
	 * @return array The specified shape or a list of all the supported shapes.
	 */
	private static function get_shapes( $shape = null ) {
		if ( null === self::$shapes ) {
			self::init_shapes();
			self::init_shapes_dropdown();
		}

		if ( $shape ) {
			return isset( self::$shapes[ $shape ] ) ? self::$shapes[ $shape ] : null;
		}

		return self::$shapes;
	}

	/**
	 * Get shape dropdown.
	 */
	private static function init_shapes_dropdown() {
		self::$shapes_options = [];
		foreach ( self::get_shapes() as $value => $shape ) {
			self::$shapes_options[ $shape['title'] ] = $value;
		}
	}

	/**
	 * Init shapes.
	 *
	 * Set the supported shapes.
	 */
	private static function init_shapes() {
		self::$shapes = [
			'mountains'             => [
				'title'    => _x( 'Mountains', 'Shapes', 'aheto' ),
				'has_flip' => true,
			],
			'drops'                 => [
				'title'        => _x( 'Drops', 'Shapes', 'aheto' ),
				'has_negative' => true,
				'has_flip'     => true,
				'height_only'  => true,
			],
			'clouds'                => [
				'title'        => _x( 'Clouds', 'Shapes', 'aheto' ),
				'has_negative' => true,
				'has_flip'     => true,
				'height_only'  => true,
			],
			'zigzag'                => [
				'title' => _x( 'Zigzag', 'Shapes', 'aheto' ),
			],
			'pyramids'              => [
				'title'        => _x( 'Pyramids', 'Shapes', 'aheto' ),
				'has_negative' => true,
				'has_flip'     => true,
			],
			'triangle'              => [
				'title'        => _x( 'Triangle', 'Shapes', 'aheto' ),
				'has_negative' => true,
			],
			'triangle-asymmetrical' => [
				'title'        => _x( 'Triangle Asymmetrical', 'Shapes', 'aheto' ),
				'has_negative' => true,
				'has_flip'     => true,
			],
			'tilt'                  => [
				'title'       => _x( 'Tilt', 'Shapes', 'aheto' ),
				'has_flip'    => true,
				'height_only' => true,
			],
			'opacity-tilt'          => [
				'title'    => _x( 'Tilt Opacity', 'Shapes', 'aheto' ),
				'has_flip' => true,
			],
			'opacity-fan'           => [
				'title' => _x( 'Fan Opacity', 'Shapes', 'aheto' ),
			],
			'curve'                 => [
				'title'        => _x( 'Curve', 'Shapes', 'aheto' ),
				'has_negative' => true,
			],
			'curve-asymmetrical'    => [
				'title'        => _x( 'Curve Asymmetrical', 'Shapes', 'aheto' ),
				'has_negative' => true,
				'has_flip'     => true,
			],
			'waves'                 => [
				'title'        => _x( 'Waves', 'Shapes', 'aheto' ),
				'has_negative' => true,
				'has_flip'     => true,
			],
			'wave-brush'            => [
				'title'    => _x( 'Waves Brush', 'Shapes', 'aheto' ),
				'has_flip' => true,
			],
			'waves-pattern'         => [
				'title'    => _x( 'Waves Pattern', 'Shapes', 'aheto' ),
				'has_flip' => true,
			],
			'arrow'                 => [
				'title'        => _x( 'Arrow', 'Shapes', 'aheto' ),
				'has_negative' => true,
			],
			'split'                 => [
				'title'        => _x( 'Split', 'Shapes', 'aheto' ),
				'has_negative' => true,
			],
			'book'                  => [
				'title'        => _x( 'Book', 'Shapes', 'aheto' ),
				'has_negative' => true,
			],
		];
	}

	/**
	 * Filter shapes.
	 *
	 * Retrieve shapes filtered by a specific condition, from the list of
	 * supported shapes.
	 *
	 * @param string $by     Specific condition to filter by.
	 * @param string $filter Optional. Comparison condition to filter by.
	 *                       Default is `include`.
	 *
	 * @return array A list of filtered shapes.
	 */
	public static function filter_shapes( $by, $filter = self::FILTER_INCLUDE ) {
		return array_filter(
			self::get_shapes(), function( $shape ) use ( $by, $filter ) {
				return self::FILTER_INCLUDE === $filter xor empty( $shape[ $by ] );
			}
		);
	}

	/**
	 * Get shape path.
	 *
	 * For a given shape, retrieve the file path.
	 *
	 * @param string $shape       The shape.
	 * @param bool   $is_negative Optional. Whether the file name is negative or
	 *                            not. Default is `false`.
	 *
	 * @return string Shape file path.
	 */
	public static function get_shape_path( $shape, $is_negative = false ) {

		if ( isset( self::$shapes[ $shape ] ) && isset( self::$shapes[ $shape ]['path'] ) ) {
			return self::$shapes[ $shape ]['path'];
		}

		if ( $is_negative ) {
			$shape .= '-negative';
		}

		return aheto()->plugin_dir() . 'assets/shapes/' . $shape . '.svg';
	}

	/**
	 * Print section shape divider.
	 *
	 * Used to generate the shape dividers HTML.
	 *
	 * @param array  $atts Attributes array.
	 * @param string $side Shape divider side, used to set the shape key.
	 */
	public static function print_shape_divider( $atts, $side ) {
		$base_setting_key = "shape_divider_$side";

		if ( ! isset( $atts[ $base_setting_key ] ) || empty( $atts[ $base_setting_key ] ) ) {
			return '';
		}

		$negative = ! empty( $atts[ $base_setting_key . '_negative' ] );

		$out  = '';
		$out .= '<div class="aheto-shape aheto-shape-' . esc_attr( $side ) . '" data-negative="' . ( $negative ? 'true' : 'false' ) . '">';
		\ob_start();
		include self::get_shape_path( $atts[ $base_setting_key ], ! empty( $atts[ $base_setting_key . '_negative' ] ) );
		$out .= \ob_get_clean();
		$out .= '</div>';

		return $out;
	}

	/**
	 * Add CSS to array.
	 *
	 * @param array $atts Attributes array.
	 * @param array $css  Css array.
	 */
	public static function add_css_array( $atts, $css ) {
		$breakpoint_md = '@media (max-width: 1199px)';
		$breakpoint_sm = '@media (max-width: 991px)';
		$breakpoint_xs = '@media (max-width: 767px)';

		foreach ( [ 'top', 'bottom' ] as $side ) {
			$base_setting_key = "shape_divider_$side";
			if ( ! isset( $atts[ $base_setting_key ] ) || empty( $atts[ $base_setting_key ] ) ) {
				continue;
			}

			$selector = '%1$s > .aheto-shape-' . $side;

			if ( ! empty( $atts[ $base_setting_key . '_color' ] ) ) {
				$css['global'][ $selector . ' .aheto-shape-fill' ]['fill'] = Sanitize::color( $atts[ $base_setting_key . '_color' ] );
			}

			if ( ! empty( $atts[ $base_setting_key . '_flip' ] ) ) {
				$css['global'][ $selector . ' svg' ]['transform'] = 'translateX(-50%) rotateY(180deg)';
			}

			if ( ! empty( $atts[ $base_setting_key . '_above_content' ] ) ) {
				$css['global'][ $selector ]['z-index']        = 2;
				$css['global'][ $selector ]['pointer-events'] = 'none';
			}

			// Width.
			if ( ! empty( $atts[ $base_setting_key . '_width' ] ) ) {
				$width = vc_parse_multi_attribute( $atts[ $base_setting_key . '_width' ] );

				if ( ! empty( $width['desktop'] ) ) {
					$css['global'][ $selector . ' svg' ]['width'] = 'calc( ' . Sanitize::size( $width['desktop'], $width['unit'] ) . ' + 1.3px)';
				}

				if ( ! empty( $width['laptop'] ) ) {
					$css[ $breakpoint_md ][ $selector . ' svg' ]['width'] = 'calc( ' . Sanitize::size( $width['laptop'], $width['unit'] ) . ' + 1.3px)';
				}

				if ( ! empty( $width['tablet'] ) ) {
					$css[ $breakpoint_sm ][ $selector . ' svg' ]['width'] = 'calc( ' . Sanitize::size( $width['tablet'], $width['unit'] ) . ' + 1.3px)';
				}

				if ( ! empty( $width['mobile'] ) ) {
					$css[ $breakpoint_xs ][ $selector . ' svg' ]['width'] = 'calc( ' . Sanitize::size( $width['mobile'], $width['unit'] ) . ' + 1.3px)';
				}
			}

			// Height.
			if ( ! empty( $atts[ $base_setting_key . '_height' ] ) ) {
				$height = vc_parse_multi_attribute( $atts[ $base_setting_key . '_height' ] );

				if ( ! empty( $height['desktop'] ) ) {
					$css['global'][ $selector . ' svg' ]['height'] = Sanitize::size( $height['desktop'], $height['unit'] );
				}

				if ( ! empty( $height['laptop'] ) ) {
					$css[ $breakpoint_md ][ $selector . ' svg' ]['height'] = Sanitize::size( $height['laptop'], $height['unit'] );
				}

				if ( ! empty( $height['tablet'] ) ) {
					$css[ $breakpoint_sm ][ $selector . ' svg' ]['height'] = Sanitize::size( $height['tablet'], $height['unit'] );
				}

				if ( ! empty( $height['mobile'] ) ) {
					$css[ $breakpoint_xs ][ $selector . ' svg' ]['height'] = Sanitize::size( $height['mobile'], $height['unit'] );
				}
			}
		}

		return $css;
	}
}
