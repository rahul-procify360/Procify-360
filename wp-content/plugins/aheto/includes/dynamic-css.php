<?php
/**
 * The skin generator.
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use Aheto\Helper;
use Aheto\Helpers\Color;

defined ( 'ABSPATH' ) || exit;

include_once aheto () -> plugin_dir () . 'includes/' . 'aheto-core-functions.php';

/**
 * Format of the $css array:
 * $css['media-query']['element']['property'] = value
 * If no media query is required then set it to 'global'
 * If we want to add multiple values for the same property then we have to make it an array like this:
 * $css[media-query][element]['property'][] = value1
 * $css[media-query][element]['property'][] = value2
 * Multiple values defined as an array above will be parsed separately.
 * @param array $settings Array of current skin settings.
 */
function aheto_dynamic_css_array ( $settings )
{
	$css = [];

	// Sanitize Common Values.
	$settings[ 'white' ] = '#fff';
	$settings[ 'black' ] = '#000';

	$colors = [ 'active', 'alter', 'alter2', 'alter3', 'grey', 'light', 'dark', 'dark2', 'white', 'black' ];
	foreach ( $colors as $color ) {
		if ( !empty( $settings[ $color ] ) ) {
			$colorAlpha = Color ::setAlpha ( $settings[ $color ], 1 );
			$colorAlpha = str_replace ( [ 'rgba(', ',1)' ], '', $colorAlpha );

			$css[ 'global' ][ ':root' ][ '--c-' . $color ] = Sanitize ::color ( $settings[ $color ] );
			$css[ 'global' ][ ':root' ][ '--ca-' . $color ] = $colorAlpha;
		}
	}


	// Typography Text.
	if ( !empty( $settings[ 'text_font' ] ) ) {
		$css[ 'global' ][ aheto_implode ( [ 'html', 'body', 'p' ] ) ] = Sanitize ::typography ( $settings[ 'text_font' ] );
	}

	// Links.
	if ( !empty( $settings[ 'links' ] ) ) {

		$link = $settings[ 'links' ];
		$link_hover = isset($settings[ 'links' ][ 'color_hover' ]) && !empty($settings[ 'links' ][ 'color_hover' ]) ? $settings[ 'links' ][ 'color_hover' ] : '';
		unset( $link[ 'color_hover' ] );

		$css[ 'global' ][ 'a' ] = Sanitize ::typography ( $link );

		if ( isset( $link_hover ) && !empty( $link_hover ) ) {
			$css[ 'global' ][ 'a:hover' ][ 'color' ] = $link_hover;
		} else if ( isset( $link_hover ) && !empty( $link_hover ) ) {
			$css[ 'global' ][ 'a:hover' ][ 'color' ] = $link_hover;
		}
	}
	// Fonts.
	if ( isset( $settings[ 'headings' ]['font-family'] ) ) {
		$css[ 'global' ][ ':root' ][ '--t-primary-font-family' ] = $settings[ 'headings' ]['font-family'];
	}
	if ( isset( $settings[ 'text_font' ]['font-family']) ) {
		$css[ 'global' ][ ':root' ][ '--t-secondary-font-family' ] = $settings[ 'text_font' ]['font-family'];
	}
	if ( isset( $settings[ 'tertiary_font' ] ) ) {
		$css[ 'global' ][ ':root' ][ '--t-tertiary-font-family' ] = $settings[ 'tertiary_font' ][ 'font-family' ];
	}

	// Sanitize buttons.
	$settings[ 'button' ] = aheto_sanitize_button ( 'button', $settings );
	$settings[ 'button_primary' ] = aheto_sanitize_button ( 'button_primary', $settings );
	$settings[ 'button_dark' ] = aheto_sanitize_button ( 'button_dark', $settings );
	$settings[ 'button_small' ] = aheto_sanitize_button ( 'button_small', $settings );
	$settings[ 'button_large' ] = aheto_sanitize_button ( 'button_large', $settings );
	$settings[ 'button_light' ] = aheto_sanitize_button ( 'button_light', $settings );
	$settings[ 'button_inline' ] = aheto_sanitize_button ( 'button_inline', $settings );
	$settings[ 'button_video' ] = aheto_sanitize_button ( 'button_video', $settings );
	$settings[ 'button_video_small' ] = aheto_sanitize_button ( 'button_video_small', $settings );
	$settings[ 'button_video_large' ] = aheto_sanitize_button ( 'button_video_large', $settings );



	aheto_headings ( $css, $settings );
	aheto_blockquote ( $css, $settings );
	aheto_buttons ( $css, $settings );
	aheto_widgets ( $css, $settings );
	aheto_google_fonts ( $css, $settings );
	aheto_forms ( $css, $settings );

	return $css;
}

/**
 * Own  dynamic style for admin panel
 */
function aheto_dynamic_admin_css_array ( $settings )
{
	$css = [];

	// Sanitize Common Values.
	$settings[ 'white' ] = '#fff';
	$settings[ 'black' ] = '#000';

	$colors = [ 'active', 'alter', 'alter2', 'alter3', 'grey', 'light', 'dark', 'dark2', 'white', 'black' ];
	foreach ( $colors as $color ) {
		if ( !empty( $settings[ $color ] ) ) {
			$colorAlpha = Color ::setAlpha ( $settings[ $color ], 1 );
			$colorAlpha = str_replace ( [ 'rgba(', ',1)' ], '', $colorAlpha );

			$css[ 'global' ][ 'body .editor-styles-wrapper' ][ '--c-' . $color ] = Sanitize ::color ( $settings[ $color ] );
			$css[ 'global' ][ 'body .editor-styles-wrapper' ][ '--ca-' . $color ] = $colorAlpha;
		}
	}


	// Typography Text.
	if ( !empty( $settings[ 'text_font' ] ) ) {
		$css[ 'global' ][ aheto_implode ( [ 'body .editor-styles-wrapper, body .editor-styles-wrapper p' ] ) ] = Sanitize ::typography ( $settings[ 'text_font' ] );

	}

	// Links.
	if ( !empty( $settings[ 'links' ] ) ) {
		$css[ 'global' ][ 'body .editor-styles-wrapper a' ] = Sanitize ::typography ( $settings[ 'links' ] );
	}

	// Fonts.
	if ( isset( $settings[ 'primary_font' ] ) ) {
		$css[ 'global' ][ 'body .editor-styles-wrapper' ][ '--t-primary-font-family' ] = $settings[ 'primary_font' ][ 'font-family' ];
	}
	if ( isset( $settings[ 'secondary_font' ] ) ) {
		$css[ 'global' ][ 'body .editor-styles-wrapper' ][ '--t-secondary-font-family' ] = $settings[ 'secondary_font' ][ 'font-family' ];
	}
	if ( isset( $settings[ 'tertiary_font' ] ) ) {
		$css[ 'global' ][ 'body .editor-styles-wrapper' ][ '--t-tertiary-font-family' ] = $settings[ 'tertiary_font' ][ 'font-family' ];
	}

	// Sanitize buttons.
	$settings[ 'button' ] = aheto_sanitize_button ( 'button', $settings );
	$settings[ 'button_primary' ] = aheto_sanitize_button ( 'button_primary', $settings );
	$settings[ 'button_primary_large' ] = aheto_sanitize_button ( 'button_primary_large', $settings );
	$settings[ 'button_primary_small' ] = aheto_sanitize_button ( 'button_primary_small', $settings );

	$settings[ 'button_dark' ] = aheto_sanitize_button ( 'button_dark', $settings );
	$settings[ 'button_dark_large' ] = aheto_sanitize_button ( 'button_dark_large', $settings );
	$settings[ 'button_dark_small' ] = aheto_sanitize_button ( 'button_dark_small', $settings );

	$settings[ 'button_light' ] = aheto_sanitize_button ( 'button_light', $settings );
	$settings[ 'button_light_large' ] = aheto_sanitize_button ( 'button_light_large', $settings );
	$settings[ 'button_light_small' ] = aheto_sanitize_button ( 'button_light_small', $settings );

	$settings[ 'button_small' ] = aheto_sanitize_button ( 'button_small', $settings );
	$settings[ 'button_large' ] = aheto_sanitize_button ( 'button_large', $settings );
	$settings[ 'button_inline' ] = aheto_sanitize_button ( 'button_inline', $settings );
	$settings[ 'button_inline_dark' ] = aheto_sanitize_button ( 'button_inline_dark', $settings );
	$settings[ 'button_inline_light' ] = aheto_sanitize_button ( 'button_inline_light', $settings );


	$settings[ 'button_video' ] = aheto_sanitize_button ( 'button_video', $settings );
	$settings[ 'button_video_small' ] = aheto_sanitize_button ( 'button_video_small', $settings );
	$settings[ 'button_video_large' ] = aheto_sanitize_button ( 'button_video_large', $settings );

	aheto_headings ( $css, $settings, true );
	aheto_blockquote ( $css, $settings, true );
	aheto_buttons ( $css, $settings );
	aheto_google_fonts ( $css, $settings );
	aheto_forms ( $css, $settings );
	//aheto_breakpoints ( $css, $settings );


	return $css;
}

/**
 * Button border-radius mixin
 * @param  mixed $radius Border-radius to asses.
 * @param  int $line_height Button Line height.
 * @param  int $font_size Button font size.
 * @param  int $padding Button padding.
 * @param  int $border_width Button border width.
 * @return string
 */
function aheto_mixin_btn_radius ( $radius, $line_height, $font_size, $padding, $border_width )
{
	if ( true === $radius || 'true' === $radius ) {
		return ( ( ( $line_height * $font_size ) + ( $padding * 2 ) + ( $border_width * 2 ) ) / 2 ) . 'px';
	}

	$radius = absint ( $radius );
	if ( is_int ( $radius ) ) {
		return $radius . 'px';
	}

	return 0;
}

/**
 * Sanitize button values.
 * @param  array $button Settings to sanitize.
 * @param  array $settings Settings to get values from.
 * @return array
 */
function aheto_sanitize_button ( $button, $settings )
{
	$defaults = [
		'font_size' => '',
		'letter_spacing' => '',
		'padding' => [],
		'border' => '',
		'background' => '',
		'color' => '',
		'box_shadow' => [],
	];

	if ( !isset( $settings[ $button ], $settings[ $button ][ 0 ] ) ) {
		return $defaults;
	}

	return wp_parse_args ( $settings[ $button ][ 0 ], $defaults );
}

/**
 * Sanitize form values.
 * @param  array $form Settings to sanitize.
 * @param  array $settings Settings to get values from.
 * @return array
 */
function aheto_sanitize_form ( $form, $settings )
{
	$defaults = [
		'font_size' => '',
		'letter_spacing' => '',
		'padding' => [],
		'border' => '',
		'background' => '',
		'color' => '',
		'box_shadow' => [],
	];

	if ( !isset( $settings[ $form ], $settings[ $form ][ 0 ] ) ) {
		return $defaults;
	}

	return wp_parse_args ( $settings[ $form ][ 0 ], $defaults );
}

/**
 * Gather google fonts.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_google_fonts ( &$css, $settings )
{

	$fonts = [];

	// Goes through all our fields and then populates the $fonts property.
	$fields = [
		'primary_font',
		'secondary_font',
		'tertiary_font',
		'text_font',
		'heading1',
		'heading2',
		'heading3',
		'heading4',
		'heading5',
		'heading6',
		'links',
		'widget_title',
		'headings',
		'button',
		'button_primary',
		'button_primary_large',
		'button_primary_small',
		'button_dark',
		'button_dark_large',
		'button_dark_small',
		'button_light',
		'button_light_large',
		'button_light_small',
		'button_inline',
		'button_inline_dark',
		'button_inline_light',
		'blockquote',
		'textarea',
		'input'
	];

	// Load all variants for these.
	$load_all = [
		'primary_font',
		'secondary_font',
		'tertiary_font',
		'text_font',
	];


	foreach ( $fields as $field ) {


//			var_dump ($field);
		if ( !isset( $settings[ $field ] ) ) {
			continue;
		}

		// Get the value.
		$value = $settings[ $field ];


		$btnsDef = [ 'button_primary', 'button_dark', 'button_light', 'button_inline' ];
		foreach ( $btnsDef as $btn ) {
			if ( $btn === $field && isset( $value ) ) {
				$value = isset($value[ 'font' ]) ? $value[ 'font' ] : array();
			}
		}


		$btns = [ 'button', 'button_primary_large', 'button_primary_small', 'button_dark', 'button_dark_large', 'button_dark_small', 'button_light_large', 'button_light_small', 'button_inline_dark', 'button_inline_light' ];

		foreach ( $btns as $btn ) {
			if ( $btn === $field && isset( $value[ 0 ] ) ) {
				$value = isset($value[ 0 ][ 'font' ]) && !empty($value[ 0 ][ 'font' ]) ? $value[ 0 ][ 'font' ] : array();
			}
		}


		// If we don't have a font-family then we can skip this.
		if ( !isset( $value[ 'font-family' ] ) || empty( $value[ 'font-family' ] ) ) {
			continue;
		}

		// Add the requested google-font.
		if ( !isset( $fonts[ $value[ 'font-family' ] ] ) ) {
			$fonts[ $value[ 'font-family' ] ] = [];
		}

		if ( in_array ( $field, $load_all ) ) {
			$fonts[ $value[ 'font-family' ] ] = [
				'200',
				'200i',
				'300',
				'300i',
				'400',
				'400i',
				'500',
				'500i',
				'600',
				'600i',
				'700',
				'700i',
				'800',
				'800i',
				'900',
				'900i',
			];
			continue;
		}

		$variant = '400';

		// Convert font-weight to variant.
		if ( !empty( $value[ 'font-weight' ] ) ) {
			$variant = str_replace ( 'italic', 'i', $value[ 'font-weight' ] );
		}

		if ( !in_array ( $variant, $fonts[ $value[ 'font-family' ] ], true ) ) {
			$fonts[ $value[ 'font-family' ] ][] = $variant;
		}
	}

	// If we don't have any fonts then we can exit.
	if ( empty( $fonts ) ) {
		return;
	}

	// Get font-family + subsets.
	$link_fonts = [];
	foreach ( $fonts as $font => $variants ) {

		$variants = implode ( ',', $variants );

		$link_font = str_replace ( ' ', '+', $font );
		if ( !empty( $variants ) ) {
			$link_font .= ':' . $variants;
		}
		$link_fonts[] = $link_font;
	}

	$query_args = array(
		'family' => str_replace ( '%2B', '+', implode ( '%7C', $link_fonts ) ),
		'display' => 'swap',
	);

	$link = add_query_arg ( $query_args , 'https://fonts.googleapis.com/css' );

	$css[ 'google_fonts' ] = $link;


}

//	die;
/**
 * Heading CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_headings ( &$css, $settings, $type = null )
{


	if ( $type ) {

		$elements = [ 'body .editor-styles-wrapper .wp-block h1',
			'body .editor-styles-wrapper .wp-block h2',
			'body .editor-styles-wrapper .wp-block h3',
			'body .editor-styles-wrapper .wp-block h4',
			'body .editor-styles-wrapper .wp-block h5',
			'body .editor-styles-wrapper .wp-block h6' ];

	} else {
		$elements = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];
	}


	if ( !empty( $settings[ 'headings' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $elements ) ] = Sanitize ::typography ( $settings[ 'headings' ] );
		$css[ 'global' ][ 'body.woocommerce-page div.product form.cart .variations label,
		body.woocommerce-page table.shop_attributes th,
		body.woocommerce-page table.shop_table th,
		body.woocommerce-page .woocommerce-MyAccount-content legend' ] = Sanitize ::typography ( $settings[ 'headings' ] );
	}

	$elements = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];

	foreach ( $elements as $element ) {

		$index = str_replace ( 'h', 'heading', $element );
		if ( !isset( $settings[ $index ] ) ) {
			continue;
		}
		if ( isset($settings[ $index ] ) && !empty( $settings[ $index ] ) ) {
			$value = Sanitize ::typography ( $settings[ $index ] );

			if ( $type ) {
				$element = 'body .editor-styles-wrapper .wp-block ' . $element;
			}

			if(isset($value[ 'font-size' ]) && is_string ( $value[ 'font-size' ] ) ){
				$value_fz = $value[ 'font-size' ];
			}else{
				$value_fz = isset ( $value[ 'font-size' ][ 'desktop' ] ) ? $value[ 'font-size' ][ 'desktop' ] : '';
			}

			if(isset($value[ 'line-height' ]) && is_string ( $value[ 'line-height' ] ) ){
				$value_lh = $value[ 'line-height' ];
			}else{
				$value_lh = isset ( $value[ 'line-height' ][ 'desktop' ] ) ? $value[ 'line-height' ][ 'desktop' ] : '';
			}

			if(isset($value[ 'letter-spacing' ]) && is_string ( $value[ 'letter-spacing' ] ) ){
				$value_ls = $value[ 'letter-spacing' ];
			}else{
				$value_ls = isset ( $value[ 'letter-spacing' ][ 'desktop' ] ) ? $value[ 'letter-spacing' ][ 'desktop' ] : '';
			}

			$css[ 'global' ][ $element ] = [
				'font-size' => $value_fz,
				'line-height' => $value_lh,
				'letter-spacing' => $value_ls,
			];

			$breakpoints = [
				'tablet' => '@media (max-width: 991px)',
				'mobile' => '@media (max-width: 767px)',
			];

			foreach ( $breakpoints as $key => $breakpoint ) {

				if ( is_array ( $value[ 'font-size' ] ) && !empty( $value[ 'font-size' ][ $key ] ) ) {
					$css[ $breakpoint ][ $element ][ 'font-size' ] = $value[ 'font-size' ][ $key ];
				}

				if ( is_array ( $value[ 'line-height' ] ) && !empty( $value[ 'line-height' ][ $key ] ) ) {
					$css[ $breakpoint ][ $element ][ 'line-height' ] = $value[ 'line-height' ][ $key ];
				}

				if ( isset( $value[ 'letter-spacing' ]) && is_array ( $value[ 'letter-spacing' ] ) && !empty( $value[ 'letter-spacing' ][ $key ] ) ) {
					$css[ $breakpoint ][ $element ][ 'letter-spacing' ] = $value[ 'letter-spacing' ][ $key ];
				}
			}

			if ( !empty( $value[ 'font-family' ] ) ) {
				$css[ 'global' ][ $element ][ 'font-family' ] = $value[ 'font-family' ];
			}
			if ( !empty( $value[ 'font-weight' ] ) ) {
				$variant = str_replace ( 'italic', 'i', $value[ 'font-weight' ] );
				$css[ 'global' ][ $element ][ 'font-weight' ] = $variant;
			}
			if (isset($value['color']) and !empty( $value[ 'color' ] ) ) {
				$css[ 'global' ][ $element ][ 'color' ] = $value[ 'color' ];
			}

//				$css['global'][$element]['font-style'] = $value['font-style'];

			if ( !empty( $value[ 'text-align' ] ) ) {
				$css[ 'global' ][ $element ][ 'text-align' ] = $value[ 'text-align' ];
			}
			if ( !empty( $value[ 'text-transform' ] ) ) {
				$css[ 'global' ][ $element ][ 'text-transform' ] = $value[ 'text-transform' ];
			}
			if ( !empty( $value[ 'word-spacing' ] ) ) {
				$css[ 'global' ][ $element ][ 'word-spacing' ] = $value[ 'word-spacing' ];
			}
			if ( !empty( $value[ 'margin-top' ] ) ) {
				$css[ 'global' ][ $element ][ 'margin-top' ] = $value[ 'margin-top' ];
			}
			if ( !empty( $value[ 'margin-bottom' ] ) ) {
				$css[ 'global' ][ $element ][ 'margin-bottom' ] = $value[ 'margin-bottom' ];
			}
			if ( !empty( $value[ 'font-style' ] ) ) {
				$css[ 'global' ][ $element ][ 'font-style' ] = $value[ 'font-style' ];
			}

		}

	}
}

/**
 * Blockquote CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_blockquote ( &$css, $settings, $type = null )
{
	$blockquote = $settings[ 'quoutes' ][ 0 ];
	$blockquote_bg = $settings[ 'quoutes_bg' ][ 0 ];
	$blockquote_line = $settings[ 'quoutes_line' ][ 0 ];
	$blockquote_border = $settings[ 'quoutes_border' ][ 0 ];

	$blockquote[ 'select' ] = '';
	$blockquote_bg[ 'select' ] = '.aheto-quote--bg';
	$blockquote_border[ 'select' ] = '.aheto-quote--border';
	$blockquote_line[ 'select' ] = '.aheto-quote--line';

	$blockquote_wrap = $type ? '.wp-block ' : '';
	$blockquote_cite = $type ? ' .wp-block-quote__citation' : ' cite';
	$pullquote_cite = $type ? ' .wp-block-pullquote__citation' : ' cite';

	foreach ( [ $blockquote, $blockquote_bg, $blockquote_line ] as $block ) {
		$css[ 'global' ][ $blockquote_wrap . 'blockquote' . $block[ 'select' ] ] = Sanitize ::typography ( $block[ 'quote' ] );
		if ( $type ) {
			$css[ 'global' ][ $blockquote_wrap . $block[ 'select' ] . $blockquote_cite . ',' . $blockquote_wrap . $block[ 'select' ] . $pullquote_cite ] = Sanitize ::typography ( $block[ 'author' ] );
		} else {
			$css[ 'global' ][ $blockquote_wrap . $block[ 'select' ] . $blockquote_cite ] = Sanitize ::typography ( $block[ 'author' ] );
		}

	}

	if ( isset( $blockquote_bg[ 'qoute_bg' ] ) ) {
		$css[ 'global' ][ $blockquote_wrap . $blockquote_bg[ 'select' ] ][ 'background-color' ] = Sanitize ::color ( $blockquote_bg[ 'qoute_bg' ] );
	}
	if ( isset( $blockquote_bg[ 'qoute_border' ] ) ) {
		$css[ 'global' ][ $blockquote_wrap . $blockquote_border[ 'select' ] ][ 'border-color' ] = Sanitize ::color ( $blockquote_border[ 'qoute_border' ] );
	}
	if ( isset( $blockquote_bg[ 'qoute_line' ] ) ) {
		$css[ 'global' ][ $blockquote_wrap . $blockquote_line[ 'select' ] ][ 'border-color' ] = Sanitize ::color ( $blockquote_line[ 'qoute_line' ] );
	}
}

/**
 * Button CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_buttons ( &$css, $settings )
{

	$button_selector = '.aheto-btn';
	$link_selector = '.aheto-link';
	$video_selector = '.aheto-btn-video';


	$button = isset($settings['button']) ? $settings[ 'button' ] : array();
	$button_primary = isset($settings['button_primary']) ? $settings[ 'button_primary' ] : array();

	$button_primary_large = isset($settings[ 'button_primary_large' ]) ? $settings[ 'button_primary_large' ] : array();
	$button_primary_small = isset($settings[ 'button_primary_small' ]) ? $settings[ 'button_primary_small' ] : array();

	$button_dark = isset($settings[ 'button_dark' ]) ? $settings[ 'button_dark' ] : array();
	$button_dark_large = isset( $settings[ 'button_dark_large' ] ) ? $settings[ 'button_dark_large' ] : array();
	$button_dark_small = isset($settings[ 'button_dark_small' ]) ? $settings[ 'button_dark_small' ] : array();

	$button_light = isset($settings[ 'button_light' ]) ? $settings[ 'button_light' ] : array();
	$button_light_large = isset($settings[ 'button_light_large' ]) ? $settings[ 'button_light_large' ] : array();
	$button_light_small = isset($settings[ 'button_light_small' ]) ? $settings[ 'button_light_small' ] : array();


	$button_small = isset($settings[ 'button_small' ]) ? $settings[ 'button_small' ] : array();
	$button_large = isset($settings[ 'button_large' ]) ? $settings[ 'button_large' ] : array();

	$button_inline = isset($settings[ 'button_inline' ]) ? $settings[ 'button_inline' ] : array();
	$button_inline_dark = isset($settings[ 'button_inline_dark' ]) ? $settings[ 'button_inline_dark' ] : array();
	$button_inline_light = isset($settings[ 'button_inline_light' ]) ? $settings[ 'button_inline_light' ] : array();

	$button_video = isset($settings[ 'button_video' ]) ? $settings[ 'button_video' ] : array();
	$button_video_small = isset($settings[ 'button_video_small' ]) ? $settings[ 'button_video_small' ] : array();
	$button_video_large = isset($settings[ 'button_video_large' ]) ? $settings[ 'button_video_large' ] : array();


	$elements = [
		$button_selector,
		'.aheto-form-btn [type="submit"]'
	];

	$shop_elements = [
		'.woocommerce #respond input#submit',
		'.woocommerce a.button',
		'.woocommerce button.button',
		'.woocommerce input.button',
		'.woocommerce #respond input#submit.alt',
		'.woocommerce a.button.alt',
		'.woocommerce button.button.alt',
		'.woocommerce input.button.alt',
		'.woocommerce button.button.alt.disabled',
		'.woocommerce button.button:disabled',
		'.woocommerce button.button:disabled[disabled]',
		'.woocommerce .widget_price_filter .price_slider_amount .button'
	];

	$shop_elements_hover = [
		'.woocommerce #respond input#submit:hover',
		'.woocommerce a.button:hover',
		'.woocommerce button.button:hover',
		'.woocommerce input.button:hover',
		'.woocommerce #respond input#submit.alt:hover',
		'.woocommerce a.button.alt:hover',
		'.woocommerce button.button.alt:hover',
		'.woocommerce input.button.alt:hover',
		'.woocommerce button.button.alt.disabled:hover',
		'.woocommerce button.button:disabled:hover',
		'.woocommerce button.button:disabled[disabled]:hover',
		'.woocommerce .widget_price_filter .price_slider_amount .button:hover'
	];

	if(isset($button[ 'font' ])){
		aheto_add_props ( $css[ 'global' ][ aheto_implode ( $elements ) ], Sanitize ::typography ( $button[ 'font' ] ) );
		aheto_add_props ( $css[ 'global' ][ aheto_implode ( $shop_elements ) ], Sanitize ::typography ( $button[ 'font' ] ) );
	}

	if(isset($button[ 'padding' ])){
		aheto_add_props ( $css[ 'global' ][ aheto_implode ( $elements ) ], Sanitize ::spacing ( $button[ 'padding' ] ) );
		aheto_add_props ( $css[ 'global' ][ 'body.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
		body.woocommerce-account .woocommerce-MyAccount-content form .button,
		.woocommerce #review_form #respond .form-submit .submit,
		.woocommerce-page #review_form #respond .form-submit .submit, body.woocommerce-account:not(.logged-in) form button' ], Sanitize ::spacing ( $button[ 'padding' ] ) );
	}

	if(isset($button[ 'border' ] ) && !empty($button[ 'border' ])){
		aheto_add_props ( $css[ 'global' ][ aheto_implode ( $elements ) ], Sanitize ::border ( $button[ 'border' ] ) );
		aheto_add_props ( $css[ 'global' ][ aheto_implode ( $shop_elements ) ], Sanitize ::border ( $button[ 'border' ] ) );
	}

	$css[ 'global' ][ aheto_implode ( $elements ) ][ 'border-radius' ] = aheto_mixin_btn_radius (
		isset( $button[ 'border_radius' ] ) ? $button[ 'border_radius' ] : 0,
		isset( $css[ 'global' ][ $button_selector ][ 'line-height' ] ) ? absint ( $css[ 'global' ][ $button_selector ][ 'line-height' ] ) : 0,
		isset( $css[ 'global' ][ $button_selector ][ 'font-size' ] ) ? absint ( $css[ 'global' ][ $button_selector ][ 'font-size' ] ) : 0,
		absint ( $button[ 'padding' ][ 'vertical' ] ),
		absint ( $button[ 'border' ][ 'all' ] )
	);

	$css[ 'global' ][ aheto_implode ( $shop_elements ) ][ 'border-radius' ] = aheto_mixin_btn_radius (
		isset( $button[ 'border_radius' ] ) ? $button[ 'border_radius' ] : 0,
		isset( $css[ 'global' ][ $button_selector ][ 'line-height' ] ) ? absint ( $css[ 'global' ][ $button_selector ][ 'line-height' ] ) : 0,
		isset( $css[ 'global' ][ $button_selector ][ 'font-size' ] ) ? absint ( $css[ 'global' ][ $button_selector ][ 'font-size' ] ) : 0,
		absint ( $button[ 'padding' ][ 'vertical' ] ),
		absint ( $button[ 'border' ][ 'all' ] )
	);


	$breakpoints = [
//		'tablet' => '@media (max-width: 991px)',
		'mobile' => '@media (max-width: 767px)',
	];

	foreach ( $breakpoints as $key => $breakpoint ) {
		if ( is_array ( $button[ 'mobile_padding' ] ) && !empty( $button[ 'mobile_padding' ] ) ) {
			aheto_add_props ( $css[ $breakpoint ][ aheto_implode ( $elements ) ], Sanitize ::spacing ( $button[ 'mobile_padding' ] ) );
		}
	}


	if ( isset( $button[ 'icon_margin' ] ) ) {
		/* ----- BUTTON ICON LEFT ----- */
		$elements = [
			$button_selector . '__icon--left',
			'.aheto-form-btn' . $button_selector . '__icon--left [type="submit"]'
		];

		$css[ 'global' ][ aheto_implode ( $elements ) ][ 'margin-right' ] = Sanitize ::size ( $button[ 'icon_margin' ] );

		/* ----- BUTTON ICON RIGHT ----- */
		$elements = [
			$button_selector . '__icon--right',
			'.aheto-form-btn' . $button_selector . '__icon--right [type="submit"]'
		];

		$css[ 'global' ][ aheto_implode ( $elements ) ][ 'margin-left' ] = Sanitize ::size ( $button[ 'icon_margin' ] );
	}

	/* ----- BUTTON ICON SIZE ----- */
	if ( isset( $button[ 'icon_size' ] ) ) {
		$elements = [
			$button_selector . ' i',
			$button_selector . ' span',
			$link_selector . ' i',
			$link_selector . ' span',
		];

		$css[ 'global' ][ aheto_implode ( $elements ) ][ 'font-size' ] = Sanitize ::size ( $button[ 'icon_size' ] );
		//$css['global'][aheto_implode($elements)]['height']    = Sanitize::size($button['icon_size']);
	}

	/* ----- ALL BUTTON VARIABLES ----- */
	$button_shadow = $button_selector . '--shadow';
	$button_reverse = $button_selector . '--reverse';
	$button_transparent = $button_selector . '--transparent';
	$button_primary[ 'selector' ] = $button_selector . '--primary';
	$button_dark[ 'selector' ] = $button_selector . '--dark';
	$button_light[ 'selector' ] = $button_selector . '--light';
	$button_primary_large[ 'selector' ] = $button_selector . '--primary' . $button_selector . '--large';
	$button_primary_small[ 'selector' ] = $button_selector . '--primary' . $button_selector . '--small';
	$button_dark_large[ 'selector' ] = $button_selector . '--dark' . $button_selector . '--large';
	$button_dark_small[ 'selector' ] = $button_selector . '--dark' . $button_selector . '--small';
	$button_light_large[ 'selector' ] = $button_selector . '--light' . $button_selector . '--large';
	$button_light_small[ 'selector' ] = $button_selector . '--light' . $button_selector . '--small';

	foreach ( [ $button_primary, $button_dark, $button_light ] as $button ) {
		/* ----- video button ----- */
		$css[ 'global' ][ $video_selector . $button[ 'selector' ] ][ 'color' ] = Sanitize ::color ( $button[ 'color' ] );
		$css[ 'global' ][ $video_selector . $button[ 'selector' ] ][ 'background' ] = Sanitize ::color ( $button[ 'background' ] );
		$css[ 'global' ][ $video_selector . $button[ 'selector' ] . '::before' ][ 'border-color' ] = Sanitize ::color ( $button[ 'background' ] );
	}

	if ( !empty( $button_primary[ 'background' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements ) ][ 'background' ] = Sanitize ::color ( $button_primary[ 'background' ] );
	}
	if ( !empty( $button_primary[ 'color' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements ) ][ 'color' ] = Sanitize ::color ( $button_primary[ 'color' ] );
	}
	if ( !empty( $button_primary[ 'border-color' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements ) ][ 'border-color' ] = Sanitize ::color ( $button_primary[ 'border' ] );
	}
	if ( !empty( $button_primary[ 'border_radius' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements ) ][ 'border-radius' ] = Sanitize ::size ( $button_primary[ 'border_radius' ] );
	}

	if ( !empty( $button_primary[ 'letter-spacing' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements ) ][ 'border-radius' ] = Sanitize ::size ( $button_primary[ 'border_radius' ] );
	}
	if ( !empty( $button_primary[ 'background_hover' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements_hover ) ][ 'background' ] = Sanitize ::color ( $button_primary[ 'background_hover' ] );
	}
	if ( !empty( $button_primary[ 'color_hover' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements_hover ) ][ 'color' ] = Sanitize ::color ( $button_primary[ 'color_hover' ] );
	}
	if ( !empty( $button_primary[ 'border_hover' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements_hover ) ][ 'border-color' ] = Sanitize ::color ( $button_primary[ 'border_hover' ] );
	}
	if ( !empty( $button_primary[ 'box_shadow' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements_hover ) ][ 'box-shadow' ] = Sanitize ::box_shadow ( $button_primary[ 'box_shadow' ] );
	}

	foreach ( [ $button_primary, $button_dark, $button_light, $button_primary_large, $button_primary_small, $button_dark_large, $button_dark_small, $button_light_large, $button_light_small ] as $index => $button ) {
		$example = !empty( $button[ 0 ] ) ? $button[ 0 ] : $button;

		/* --- Button Icon --- */

		if ( isset( $button[ 'icon_margin' ] ) ) {
			/* ----- BUTTON ICON LEFT ----- */
			$elements = [
				$button_selector . '__icon--left',
				'.aheto-form-btn' . $button_selector . '__icon--left [type="submit"]'
			];

			$css[ 'global' ][ aheto_implode ( $elements ) ][ 'margin-right' ] = Sanitize ::size ( $button[ 'icon_margin' ] );

			/* ----- BUTTON ICON RIGHT ----- */
			$elements = [
				$button_selector . '__icon--right',
				'.aheto-form-btn' . $button_selector . '__icon--right [type="submit"]'
			];

			$css[ 'global' ][ aheto_implode ( $elements ) ][ 'margin-left' ] = Sanitize ::size ( $button[ 'icon_margin' ] );
		}

		$elements = [
			$button_selector . $button[ 'selector' ],
			'.aheto-form-btn' . $button[ 'selector' ] . ' input[type="submit"]',
		];

		if($index === 0){
			$elements = array_merge($elements, $shop_elements);
		}

		$value = isset($example[ 'font' ]) && !empty($example[ 'font' ]) ? Sanitize ::typography ( $example[ 'font' ] ) : '';

		if( !empty( $value ) ){
			$css[ 'global' ][ aheto_implode ( $elements ) ] = [
				'font-size' => is_string ( $value[ 'font-size' ] ) ? $value[ 'font-size' ] : $value[ 'font-size' ][ 'desktop' ],
				'line-height' => is_string ( $value[ 'line-height' ] ) ? $value[ 'line-height' ] : $value[ 'line-height' ][ 'desktop' ],
				'letter-spacing' => is_string ( $value[ 'letter-spacing' ] ) ? $value[ 'letter-spacing' ] : $value[ 'letter-spacing' ][ 'desktop' ],
			];

			$breakpoints = [
				'tablet' => '@media (max-width: 991px)',
				'mobile' => '@media (max-width: 767px)',
			];

			foreach ( $breakpoints as $key => $breakpoint ) {

				if ( is_array ( $value[ 'font-size' ] ) && !empty( $value[ 'font-size' ][ $key ] ) ) {
					$css[ $breakpoint ][ aheto_implode ( $elements ) ][ 'font-size' ] = $value[ 'font-size' ][ $key ];
				}

				if ( is_array ( $value[ 'line-height' ] ) && !empty( $value[ 'line-height' ][ $key ] ) ) {
					$css[ $breakpoint ][ aheto_implode ( $elements ) ][ 'line-height' ] = $value[ 'line-height' ][ $key ];
				}

				if ( is_array ( $value[ 'letter-spacing' ] ) && !empty( $value[ 'letter-spacing' ][ $key ] ) ) {
					$css[ $breakpoint ][ aheto_implode ( $elements ) ][ 'letter-spacing' ] = $value[ 'letter-spacing' ][ $key ];
				}
			}

			if ( !empty( $value[ 'font-family' ] ) ) {
				$css[ 'global' ][ aheto_implode ( $elements ) ][ 'font-family' ] = $value[ 'font-family' ];
			}
			if ( !empty( $value[ 'font-weight' ] ) ) {
				$variant = str_replace ( 'italic', 'i', $value[ 'font-weight' ] );
				$css[ 'global' ][ aheto_implode ( $elements ) ][ 'font-weight' ] = $variant;
			}
			if (isset($value['color']) and !empty( $value[ 'color' ] ) ) {
				$css[ 'global' ][ aheto_implode ( $elements ) ][ 'color' ] = $value[ 'color' ];
			}
		}

		if(isset($example[ 'padding' ] )){
			aheto_add_props ( $css[ 'global' ][ aheto_implode ( $elements ) ], Sanitize ::spacing ( $example[ 'padding' ] ) );
		}
		if(isset($example[ 'border' ]) && !empty($example[ 'border' ])){
			aheto_add_props ( $css[ 'global' ][ aheto_implode ( $elements ) ], Sanitize ::border ( $example[ 'border' ] ) );
		}


		if ( isset($example[ 'background' ]) && !empty( $example[ 'background' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements ) ][ 'background' ] = Sanitize ::color ( $example[ 'background' ] );
		}
		if ( isset($example[ 'color' ]) && !empty( $example[ 'color' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements ) ][ 'color' ] = Sanitize ::color ( $example[ 'color' ] );
		}
		if ( isset($example[ 'border_radius' ]) && !empty( $example[ 'border_radius' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements ) ][ 'border-radius' ] = Sanitize ::size ( $example[ 'border_radius' ] );
		}
		/* ----- hover state ----- */
		$elements_hover = [
			$button_selector . $button[ 'selector' ] . ':hover',
			'.aheto-form-btn' . $button[ 'selector' ] . ' input[type="submit"]:hover',
		];
		if ( isset($example[ 'border_hover' ]) && !empty( $example[ 'border_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_hover ) ][ 'border-color' ] = Sanitize ::color ( $example[ 'border_hover' ] );
		}
		if ( isset($example[ 'background_hover' ]) && !empty( $example[ 'background_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_hover ) ][ 'background' ] = Sanitize ::color ( $example[ 'background_hover' ] );
		}
		if ( isset($example[ 'color_hover' ]) && !empty( $example[ 'color_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_hover ) ][ 'color' ] = Sanitize ::color ( $example[ 'color_hover' ] );
		}

		/* ----- shadow state ----- */
		$elements_shadow = [
			$button_selector . $button[ 'selector' ] . $button_shadow,
			'.aheto-form-btn' . $button[ 'selector' ] . $button_shadow . ' input[type="submit"]',
		];
		if ( !empty( $example[ 'box_shadow' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_shadow ) ][ 'box-shadow' ] = Sanitize ::box_shadow ( $example[ 'box_shadow' ] );
		}

		/* ----- reverse state ----- */
		$elements_reverse = [
			$button_selector . $button[ 'selector' ] . $button_reverse,
			'.aheto-form-btn' . $button[ 'selector' ] . $button_reverse . ' input[type="submit"]',
		];
		if ( isset($example[ 'background_hover' ]) && !empty( $example[ 'background_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_reverse ) ][ 'background' ] = Sanitize ::color ( $example[ 'background_hover' ] );
		}
		if ( isset($example[ 'color_hover' ]) && !empty( $example[ 'color_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_reverse ) ][ 'color' ] = Sanitize ::color ( $example[ 'color_hover' ] );
		}
		if ( isset($example[ 'border_hover' ]) && !empty( $example[ 'border_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_reverse ) ][ 'border-color' ] = Sanitize ::color ( $example[ 'border_hover' ] );
		}
		/* ----- reverse hover state ----- */
		$elements_reverse_hover = [
			$button_selector . $button[ 'selector' ] . $button_reverse . ':hover',
			'.aheto-form-btn' . $button[ 'selector' ] . $button_reverse . ' input[type="submit"]:hover',
		];
		if ( isset($example[ 'background' ]) && !empty( $example[ 'background' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_reverse_hover ) ][ 'background' ] = Sanitize ::color ( $example[ 'background' ] );
		}
		if ( isset($example[ 'color' ]) && !empty( $example[ 'color' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_reverse_hover ) ][ 'color' ] = Sanitize ::color ( $example[ 'color' ] );
		}
		if ( isset($example[ 'border' ]) && !empty( $example[ 'border' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_reverse_hover ) ][ 'border-color' ] = Sanitize ::color ( $example[ 'border' ] );
		}

		/* ----- transparent state ----- */
		$elements_transparent = [
			$button_selector . $button[ 'selector' ] . $button_transparent,
			'.aheto-form-btn' . $button[ 'selector' ] . $button_transparent . ' input[type="submit"]',
		];

		$css[ 'global' ][ aheto_implode ( $elements_transparent ) ][ 'background' ] = 'transparent';

		$elements_transparent_hover = [
			$button_selector . $button[ 'selector' ] . $button_transparent . ':hover',
			'.aheto-form-btn' . $button[ 'selector' ] . $button_transparent . ' input[type="submit"]:hover',
		];

		if ( isset($example[ 'background_hover' ]) && !empty( $example[ 'background_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_transparent_hover ) ][ 'background' ] = Sanitize ::color ( $example[ 'background_hover' ] );
		}

		/* ----- brekpoint state ----- */

		if ( isset ( $example[ 'tablet_padding' ] ) && !empty( $example[ 'tablet_padding' ] ) ) {
			aheto_add_props ( $css[ '@media (max-width: 991px)' ][ aheto_implode ( $elements ) ], Sanitize ::spacing ( $example[ 'tablet_padding' ] ) );
		}
		if ( isset ( $example[ 'mobile_padding' ] ) && !empty( $example[ 'mobile_padding' ] ) ) {
			aheto_add_props ( $css[ '@media (max-width: 767px)' ][ aheto_implode ( $elements ) ], Sanitize ::spacing ( $example[ 'mobile_padding' ] ) );
		}

	}

	/* ----- BUTTON INLINE ----- */
	$button_inline[ 'selector' ] = $button_selector . '--primary';
	$button_inline_dark[ 'selector' ] = $button_selector . '--dark';
	$button_inline_light[ 'selector' ] = $button_selector . '--light';
	foreach ( [ $button_inline, $button_inline_dark, $button_inline_light ] as $button ) {

		if(isset($button[ 'font' ]) && !empty($button[ 'font' ])){
			$example = $button[ 'font' ];
		}elseif(isset($button[ 0 ][ 'font' ])){
			$example = $button[ 0 ][ 'font' ];
		}else{
			$example = array();
		}

		$example_hover = isset($example[ 'color_hover' ]) ? $example[ 'color_hover' ] : '';
		unset( $example[ 'color_hover' ] );

		$elements = [
			$link_selector . $button[ 'selector' ],
			'.aheto-form-link' . $button[ 'selector' ] . ' input[type="submit"]'
		];
		$elements_hover = [
			$link_selector . $button[ 'selector' ] . ':hover',
		];
		if(is_array($example) && count($example) > 0){
			$value = Sanitize ::typography ( $example );

			$css[ 'global' ][ aheto_implode ( $elements ) ] = [
				'font-size' => isset ( $value[ 'font-size' ] ) && !is_array($value[ 'font-size' ]) ? $value[ 'font-size' ] : $value[ 'font-size' ][ 'desktop' ],
				'line-height' => isset ( $value[ 'line-height' ] ) && !is_array( $value[ 'line-height' ]) ? $value[ 'line-height' ] : $value[ 'line-height' ][ 'desktop' ],
				'letter-spacing' => isset ( $value[ 'letter-spacing' ] ) && !is_array($value[ 'letter-spacing' ]) ? $value[ 'letter-spacing' ] : $value[ 'letter-spacing' ][ 'desktop' ],
			];

			$breakpoints = [
				'tablet' => '@media (max-width: 991px)',
				'mobile' => '@media (max-width: 767px)',
			];

			foreach ( $breakpoints as $key => $breakpoint ) {

				if ( isset ( $value[ 'font-size' ] ) && !empty( $value[ 'font-size' ][ $key ] ) ) {
					$css[ $breakpoint ][ aheto_implode ( $elements ) ][ 'font-size' ] = $value[ 'font-size' ][ $key ];
				}

				if ( isset ( $value[ 'line-height' ] ) && !empty( $value[ 'line-height' ][ $key ] ) ) {
					$css[ $breakpoint ][ aheto_implode ( $elements ) ][ 'line-height' ] = $value[ 'line-height' ][ $key ];
				}

				if ( isset ( $value[ 'letter-spacing' ] ) && !empty( $value[ 'letter-spacing' ][ $key ] ) ) {
					$css[ $breakpoint ][ aheto_implode ( $elements ) ][ 'letter-spacing' ] = $value[ 'letter-spacing' ][ $key ];
				}
			}

			if ( isset ( $value[ 'font-family' ] ) && !empty( $value[ 'font-family' ] ) ) {
				$css[ 'global' ][ aheto_implode ( $elements ) ][ 'font-family' ] = $value[ 'font-family' ];
			}
			if ( isset ( $value[ 'font-weight' ] ) && !empty( $value[ 'font-weight' ] ) ) {
				$variant = str_replace ( 'italic', 'i', $value[ 'font-weight' ] );
				$css[ 'global' ][ aheto_implode ( $elements ) ][ 'font-weight' ] = $variant;
			}
			if (isset ( $value[ 'color' ] ) && isset($value['color']) and !empty( $value[ 'color' ] ) ) {
				$css[ 'global' ][ aheto_implode ( $elements ) ][ 'color' ] = $value[ 'color' ];
			}

		}


		$css[ 'global' ][ aheto_implode ( $elements_hover ) ][ 'color' ] = Sanitize ::color ( $example_hover );
	}

	/* ----- VIDEO BUTTON ----- */
	$button_video[ 'selector' ] = $video_selector;
	$button_video_small[ 'selector' ] = $video_selector . '--small';
	$button_video_large[ 'selector' ] = $video_selector . '--large';

	foreach ( [ $button_video, $button_video_small, $button_video_large ] as $button ) {
		if(isset($button[ 'font_size' ])){
			$css[ 'global' ][ $button[ 'selector' ] ][ 'font-size' ] = Sanitize ::size ( $button[ 'font_size' ] );
		}
		if(isset($button[ 'btn_size' ])){
			$css[ 'global' ][ $button[ 'selector' ] ][ 'width' ] = isset( $button[ 'btn_size' ] ) && !empty( $button[ 'btn_size' ] ) ? Sanitize ::size ( $button[ 'btn_size' ] ) : '';
			$css[ 'global' ][ $button[ 'selector' ] ][ 'height' ] = isset( $button[ 'btn_size' ] ) && !empty( $button[ 'btn_size' ] ) ? Sanitize ::size ( $button[ 'btn_size' ] ) : '';
		}
	}
}

/**
 * Form CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_forms ( &$css, $settings ){
	$input = isset($settings[ "input" ]) ? $settings[ "input" ] : array();
	$textarea = isset($settings[ "textarea" ]) ? $settings[ "textarea" ] : array();
	$input[ 'selector' ] = 'body input';
	$textarea[ 'selector' ] = 'body textarea';

	$select = isset($settings[ "select" ]) ? $settings[ "select" ] : array();
	$select[ 'selector' ] = 'body select';


	foreach ( [ $input, $textarea, $select] as $item ) {
		if(isset($item[ 0 ][ 'font' ])){
			aheto_add_props ( $css[ 'global' ][ $item[ 'selector' ] ], Sanitize ::typography ( $item[ 0 ][ 'font' ] ) );
		}
		if(isset($item[ 0 ][ 'border' ]) && !empty($item[ 0 ][ 'border' ])){
			aheto_add_props ( $css[ 'global' ][ $item[ 'selector' ] ], Sanitize ::border ( $item[ 0 ][ 'border' ] ) );
		}
		if ( isset( $item[ 0 ][ 'box_shadow' ] ) && !empty($item[ 0 ][ 'box_shadow' ])) {
			$css[ 'global' ][ $item[ 'selector' ] ][ 'box-shadow' ] = Sanitize ::box_shadow ( $item[ 0 ][ 'box_shadow' ] );
		}
		if(isset($item[ 0 ][ 'padding' ])){
			aheto_add_props ( $css[ 'global' ][ $item[ 'selector' ] ], Sanitize ::spacing ( $item[ 0 ][ 'padding' ] ) );
		}
		if ( !empty( $item[ 0 ][ 'background' ] ) ) {
			$css[ 'global' ] [ $item[ 'selector' ] ] [ 'background' ] = Sanitize ::color ( $item[ 0 ][ 'background' ] );
		}

		$elements_hover = [
			$item[ 'selector'] . ':hover ',
		];
		if ( isset($item[ 0 ][ 'border_hover' ] ) && !empty( $item[ 0 ][ 'border_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_hover )]['border-color'] = Sanitize::color( $item[ 0 ][ 'border_hover' ] );
		}
		if (  isset($item[ 0 ][ 'border_radius' ] ) && !empty( $item[ 0 ][ 'border_radius' ] ) ) {
			$css[ 'global' ] [ $item[ 'selector' ] ] [ 'border-radius' ] = Sanitize ::size ( $item[ 0 ][ 'border_radius' ] );
		}
		if (  isset($item[ 0 ][ 'height_textarea' ] ) && !empty( $item[ 0 ][ 'height_textarea' ] ) ) {
			$css[ 'global' ] [ $item[ 'selector' ] ] [ 'min-height' ] = Sanitize ::size ( $item[ 0 ][ 'height_textarea' ] );
		}
		if (  isset($item[ 0 ][ 'width_textarea' ] ) && !empty( $item[ 0 ][ 'width_textarea' ] ) ) {
			$css[ 'global' ] [ $item[ 'selector' ] ] [ 'min-width' ] = Sanitize ::size ( $item[ 0 ][ 'width_textarea' ] );
		}

	}

	foreach ( [ $input, $textarea] as $item ) {
		$elements_placeholder = [
			$item[ 'selector'] . '::-webkit-input-placeholder ',
		];
		if (isset($item[ 0 ][ 'color_placeholder' ]) &&  !empty( $item[ 0 ][ 'color_placeholder' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_placeholder )]['color'] = Sanitize::color( $item[ 0 ][ 'color_placeholder' ] );
		}
	}

	$checkbox = isset($settings[ "checkbox" ]) ? $settings[ "checkbox" ] : array();
	$checkbox[ 'selector' ] = 'body input[type=checkbox]';


	if ( isset( $checkbox[ 0 ][ 'box_shadow' ]) && !empty( $checkbox[ 0 ][ 'box_shadow' ] ) ) {
		$css[ 'global' ][ $checkbox[ 'selector' ] ][ 'box-shadow' ] = Sanitize ::box_shadow ( $checkbox[ 0 ][ 'box_shadow' ] );
	}
	if(isset( $checkbox[ 0 ][ 'border' ]) && !empty($checkbox[ 0 ][ 'border' ]) ){
		aheto_add_props ( $css[ 'global' ][ $checkbox[ 'selector' ] ], Sanitize ::border ( $checkbox[ 0 ][ 'border' ] ) );
	}

	if ( isset( $checkbox[ 0 ][ 'border_radius' ]) && !empty( $checkbox[ 0 ][ 'border_radius' ] ) ) {
		$css[ 'global' ] [ $checkbox[ 'selector' ] ] [ 'border-radius' ] = Sanitize ::size ( $checkbox[ 0 ][ 'border_radius' ] );
	}

	if ( isset( $checkbox[ 0 ][ 'background' ]) && !empty( $checkbox[ 0 ][ 'background' ] ) ) {
		$css[ 'global' ] [ $checkbox[ 'selector' ] ] [ 'background' ] = Sanitize ::color ( $checkbox[ 0 ][ 'background' ] );
	}

	$elements_hover = [
		'body input[type="submit"]:hover',
	];
	if ( isset( $checkbox[ 0 ][ 'border_hover' ]) && !empty( $checkbox[ 0 ][ 'border_hover' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $elements_hover )]['border-color'] = Sanitize::color( $checkbox[ 0 ][ 'border_hover' ] );
	}

}

/**
 * Form CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_breakpoints ( &$css, $settings ){
	$content_width = $settings[ "content_width" ];
	$tablet_breakpoint = $settings[ "tablet_breakpoint" ];
	$mobile_breakpoint = $settings[ "mobile_breakpoint" ];
}

/**
 * Widgets CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_widgets ( &$css, $settings )
{
	$elements = [
		'.widget_mc4wp_form_widget.aheto_mc_2 button[type=submit]:hover',
		'.widget_mc4wp_form_widget.aheto_mc_2 input[type=submit]:hover',
	];

	if(isset( $settings[ 'alter' ] ) && !empty( $settings[ 'alter' ] )){
		$css[ 'global' ][ aheto_implode ( $elements ) ][ 'background' ] = Color ::fadeOut ( $settings[ 'alter' ], 0.2 ) . ' !important';
	}


	$css[ 'global' ][ '.widget-title' ] = Sanitize ::typography ( $settings[ 'widget_title' ] );

	if( isset($settings[ 'widget_title_border' ]) && !empty($settings[ 'widget_title_border' ])){
		aheto_add_props ( $css[ 'global' ][ '.widget-title' ], Sanitize ::border ( $settings[ 'widget_title_border' ] ) );
	}
	if( isset($settings[ 'widget_title_padding' ]) && !empty($settings[ 'widget_title_padding' ])){
		aheto_add_props ( $css[ 'global' ][ '.widget-title' ], Sanitize ::spacing ( $settings[ 'widget_title_padding' ] ) );
	}
}
