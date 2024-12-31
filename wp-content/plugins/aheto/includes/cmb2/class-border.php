<?php
/**
 * The CMB2 Border field.
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
 * Border class.
 */
class Border extends CMB2_Type_Base {

	use Helpers;

	/**
	 * Style options.
	 *
	 * @var array
	 */
	protected static $style = [
		'none'   => 'None',
		'solid'  => 'Solid',
		'hidden' => 'Hidden',
		'dashed' => 'Dashed',
		'dotted' => 'Dotted',
		'double' => 'Double',
		'groove' => 'Groove',
		'ridge'  => 'Ridge',
		'inset'  => 'Inset',
		'outset' => 'Outset',
	];

	/**
	 * Fields options.
	 *
	 * @var array
	 */
	protected static $fields = [
		'all'    => false,
		'top'    => true,
		'right'  => true,
		'bottom' => true,
		'left'   => true,
		'style'  => true,
		'color'  => true,
	];

	/**
	 * Handles outputting the address field.
	 */
	public function render() {
		// Make sure we assign each part of the value we need.
		$value = wp_parse_args( $this->field->escaped_value(), [
			'all'    => '',
			'top'    => '',
			'right'  => '',
			'bottom' => '',
			'left'   => '',
			'style'  => '',
			'color'  => '',
		]);

		$this->selected_fields = wp_parse_args( $this->field->args( 'fields', [] ), self::$fields );

		$style = $this->field->args( 'style', [] );
		if ( empty( $style ) ) {
			$style = self::$style;
		}

		ob_start();

		$strings = [
			'all'        => 'All',
			'vertical'   => 'Vertical',
			'horizontal' => 'Horizontal',
			'top'        => 'Top',
			'right'      => 'Right',
			'bottom'     => 'Bottom',
			'left'       => 'Left',
			'units'      => 'Units',
		];

		$fields = [ 'top', 'right', 'bottom', 'left' ];
		if ( $this->if_fields( 'all' ) ) {
			$fields = [ 'all' ];
		}

		echo '<div class="spacing-parts">';
		foreach ( $fields as $id ) :

			if ( ! $this->if_fields( $id ) ) {
				continue;
			}

			echo '<div class="part part-' . $id . '">' . $this->types->input([
				'id'          => $this->_id( '_' . $id ),
				'name'        => $this->_name( '[' . $id . ']' ),
				'desc'        => '',
				'value'       => $value[ $id ],
				'placeholder' => esc_html( $strings[ $id ] ),
			]) . '</div>';
		endforeach;

		if ( $this->if_fields( 'style' ) ) {
			echo '<div class="part part-style">' . $this->types->select([
				'id'      => $this->_id( '_style' ),
				'name'    => $this->_name( '[style]' ),
				'desc'    => '',
				'options' => $this->select_options( $style, $value['style'] ),
			]) . '</div>';
		}

		if ( $this->if_fields( 'color' ) ) {
			echo '<div class="part part-color">' . $this->types->colorpicker([
				'id'   => $this->_id( '_color' ),
				'name' => $this->_name( '[color]' ),
				'desc' => '',
			], $value['color'] ) . '</div>';
		}

		echo '</div>';

		$this->_desc( true, true, true );

		// Grab the data from the output buffer.
		return $this->rendered( ob_get_clean() );
	}
}
