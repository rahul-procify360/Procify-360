<?php
/**
 * The CMB2 typography field.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\CMB2
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\CMB2;

use CMB2_Type_Base;

defined( 'ABSPATH' ) || exit;

/**
 * Typography class.
 */
class Typography extends CMB2_Type_Base {

	use Helpers;

	/**
	 * Alignment options.
	 *
	 * @var array
	 */
	protected static $text_align = [
		''        => 'Default',
		'left'    => 'Left',
		'center'  => 'Center',
		'right'   => 'Right',
		'justify' => 'Justify',
		'inherit' => 'Inherit',
	];

	/**
	 * Fields options.
	 *
	 * @var array
	 */
	protected static $fields = [
		'font-family'    => true,
		'font-size'      => true,
		'font-weight'    => true,
		'color'          => true,
		'color_hover'          => true,
		'text-align'     => true,
		'text-transform' => true,
		'line-height'    => true,
		'letter-spacing' => true,
		'word-spacing'   => true,
		'margin-top'     => true,
		'margin-bottom'  => true,
	];

	/**
	 * Transform options.
	 *
	 * @var array
	 */
	protected static $transform = [
		''           => 'Default',
		'none'       => 'None',
		'capitalize' => 'Capitalize',
		'uppercase'  => 'Uppercase',
		'lowercase'  => 'Lowercase',
		'initial'    => 'Initial',
		'inherit'    => 'Inherit',
	];

	/**
	 * Font Weight options.
	 *
	 * @var array
	 */
	protected static $font_weight = [
		'400' => 'Normal 400',
		'400italic' => 'Italic 400',
		'100' => 'Normal 100',
		'100italic' => 'Italic 100',
		'200' => 'Normal 200',
		'200italic' => 'Italic 200',
		'300' => 'Normal 300',
		'300italic' => 'Italic 300',
		'500' => 'Normal 500',
		'500italic' => 'Italic 500',
		'600' => 'Normal 600',
		'600italic' => 'Italic 600',
		'700' => 'Normal 700',
		'700italic' => 'Italic 700',
		'800' => 'Normal 800',
		'800italic' => 'Italic 800',
		'900' => 'Normal 900',
		'900italic' => 'Italic 900',
	];

	/**
	 * Handles outputting the address field.
	 */
	public function render() {

		// Setup scripts.
//		wp_enqueue_style( 'select2', aheto()->assets() . 'select2/select2.min.css', null, '4.0' );
		wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css', null, '4.0' );
		wp_enqueue_style( 'font', 'https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet', null, null );
		wp_register_style( 'ionicons', aheto()->assets() . 'fonts/ionicons.min.css', null, null );
//		wp_enqueue_script( 'select2', aheto()->assets() . 'select2/select2.min.js', [ 'jquery' ], '4.0', true );
		wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', [ 'jquery' ], '4.0', true );
		wp_enqueue_script( 'cmb2-google-fonts', aheto()->assets() . 'admin/js/google-fonts.js', null, aheto()->version, true );
		wp_enqueue_script( 'default-color', aheto()->assets() . 'admin/js/default_color.js', null, aheto()->version, true );
		wp_enqueue_script( 'cmb2-typography-field', aheto()->assets() . 'admin/js/cmb2-typography.js', [ 'jquery' ], aheto()->version, true );

		// Make sure we assign each part of the value we need.
		$value = wp_parse_args( $this->field->escaped_value(), [
			'font-family'    => '',
			'font-size'      => '',
			'font-weight'    => '',
			'color'          => '',
			'color_hover'          => '',
			'text-align'     => '',
			'text-transform' => '',
			'line-height'    => '',
			'letter-spacing' => '',
			'word-spacing'   => '',
			'margin-top'     => '',
			'margin-bottom'  => '',
		]);


		$fields = $this->field->args( 'fields' );

		if ( empty( $fields ) ) {
			$fields = self::$fields;
		}
		$this->selected_fields = $fields;

		$text_align = $this->field->args( 'text_align' );
		if ( empty( $text_align ) ) {
			$text_align = self::$text_align;
		}

		$text_transform = $this->field->args( 'text_transform' );
		if ( empty( $text_transform ) ) {
			$text_transform = self::$transform;
		}

		$font_weight = $this->field->args( 'font_weight' );
		if ( empty( $font_weight ) ) {
			$font_weight = self::$font_weight;
		}

		ob_start();

		if ( $this->if_fields( 'font-family' ) ) {
			$this->render_col();
			$this->render_label( esc_html__( 'Font Family', 'aheto' ) );
			echo $this->types->select([
				'id'         => $this->_id( '_font_family' ),
				'name'       => $this->_name( '[font-family]' ),
				'data-value' => $value['font-family'],
				'desc'       => '',
				'class'      => 'cmb2-typography-fs',
			]);

			$this->render_col( true );
		}

		if ( $this->if_fields( 'font-weight' ) ) {
			$this->render_col();
			$this->render_label( esc_html__( 'Font Weight', 'aheto' ) );
			echo $this->types->select([
				'id'         => $this->_id( '_font_weight' ),
				'name'       => $this->_name( '[font-weight]' ),
				'desc'       => '',
				'data-value' => $value['font-weight'],
				'options'    => $this->select_options( $font_weight, $value['font-weight'] ),
				'class'      => 'cmb2-typography-variants',
			]);
			$this->render_col( true );
		}

		if ( $this->if_fields( 'text-align' ) ) {
			$this->render_col();
			$this->render_label( esc_html__( 'Text Align', 'aheto' ) );
			echo $this->types->select([
				'id'      => $this->_id( '_text_align' ),
				'name'    => $this->_name( '[text-align]' ),
				'desc'    => '',
				'options' => $this->select_options( $text_align, $value['text-align'] ),
			]);
			$this->render_col( true );
		}

		if ( $this->if_fields( 'text-transform' ) ) {
			$this->render_col();
			$this->render_label( esc_html__( 'Transform', 'aheto' ) );
			echo $this->types->select([
				'id'      => $this->_id( '_transform' ),
				'name'    => $this->_name( '[text-transform]' ),
				'desc'    => '',
				'options' => $this->select_options( $text_transform, $value['text-transform'] ),
			]);
			$this->render_col( true );
		}

		if ( $this->if_fields( 'font-size' ) ) {
			$this->render_col();
			$this->render_label( esc_html__( 'Font Size', 'aheto' ) );
			echo $this->types->input([
				'id'              => $this->_id( '_font_size' ),
				'name'            => $this->_name( '[font-size]' ),
				'desc'            => '',
				'value'           => $value['font-size'],
				'class'           => 'cmb2-text-small',
				'data-responsive' => $this->field->args( 'responsive' ) ? 'true' : 'false',
			]);
			$this->render_col( true );
		}

		if ( $this->if_fields( 'line-height' ) ) {
			$this->render_col();
			$this->render_label( esc_html__( 'Line Height', 'aheto' ) );
			echo $this->types->input([
				'id'              => $this->_id( '_line_height' ),
				'name'            => $this->_name( '[line-height]' ),
				'desc'            => '',
				'value'           => $value['line-height'],
				'class'           => 'cmb2-text-small',
				'data-responsive' => $this->field->args( 'responsive' ) ? 'true' : 'false',
			]);
			$this->render_col( true );
		}

		if ( $this->if_fields( 'letter-spacing' ) ) {
			$this->render_col();
			$this->render_label( esc_html__( 'Letter Spacing', 'aheto' ) );
			echo $this->types->input([
				'id'    => $this->_id( '_letter_spacing' ),
				'name'  => $this->_name( '[letter-spacing]' ),
				'desc'  => '',
				'value' => $value['letter-spacing'],
				'class' => 'cmb2-text-small',
				'data-responsive' => $this->field->args( 'responsive' ) ? 'true' : 'false',
			]);
			$this->render_col( true );
		}


		if ( $this->if_fields( 'word-spacing' ) ) {
			$this->render_col();
			$this->render_label( esc_html__( 'Word Spacing', 'aheto' ) );
			echo $this->types->input([
				'id'    => $this->_id( '_word_spacing' ),
				'name'  => $this->_name( '[word-spacing]' ),
				'desc'  => '',
				'value' => $value['word-spacing'],
				'class' => 'cmb2-text-small',
			]);
			$this->render_col( true );
		}


		if ( $this->if_fields( 'color' ) ) {
			$set_colors = array();

			if ( isset( $_GET['aheto-edit-skin'] ) && !empty( $_GET['aheto-edit-skin'] ) ) {
				$skin_id = $_GET['aheto-edit-skin'];

				$colors = ['active', 'alter', 'alter2', 'alter3', 'grey', 'light', 'dark', 'dark2', 'white', 'black'];

				$settings = get_option( 'aheto_skin_' . $skin_id );

				foreach ( $colors as $color ) {
					if(isset($settings[$color]) && !empty($settings[$color])){
						$set_colors[] = $settings[$color];
					}
				}
			}
			$this->render_col();
			$this->render_label( esc_html__( 'Font Color', 'aheto' ) );
			echo $this->types->colorpicker([
				'id'   => $this->_id( '_color' ),
				'name' => $this->_name( '[color]' ),
				'desc' => '',
			], $value['color'] );
			$this->render_col( true );
		}

		if ( $this->if_fields( 'color_hover' ) ) {
			$this->render_col();
			$this->render_label( esc_html__( 'Font Hover Color', 'aheto' ) );
			echo $this->types->colorpicker([
				'id'   => $this->_id( '_color_hover' ),
				'name' => $this->_name( '[color_hover]' ),
				'desc' => '',
			], $value['color_hover'] );
			$this->render_col( true );
		}

		if ( $this->if_fields( 'margin-top' ) ) {
			$this->render_col();
			$this->render_label( esc_html__( 'Margin Top', 'aheto' ) );
			echo $this->types->input([
				'id'    => $this->_id( '_margin_top' ),
				'name'  => $this->_name( '[margin-top]' ),
				'desc'  => '',
				'value' => $value['margin-top'],
				'class' => 'cmb2-text-small',
			]);
			$this->render_col( true );
		}

		if ( $this->if_fields( 'margin-bottom' ) ) {
			$this->render_col();
			$this->render_label( esc_html__( 'Margin Bottom', 'aheto' ) );
			echo $this->types->input([
				'id'    => $this->_id( '_margin_bottom' ),
				'name'  => $this->_name( '[margin-bottom]' ),
				'desc'  => '',
				'value' => $value['margin-bottom'],
				'class' => 'cmb2-text-small',
			]);
			$this->render_col( true );
		}

		$this->_desc( true, true, true );

		// Grab the data from the output buffer.
		return $this->rendered( ob_get_clean() );
	}
}
