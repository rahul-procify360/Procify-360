<?php
/**
 * The CMB2 Spacing field.
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
 * Spacing class.
 */
class Spacing extends CMB2_Type_Base {

	use Helpers;

	/**
	 * Units options.
	 *
	 * @var array
	 */
	protected static $units = [
		'px'  => 'px',
		'%'   => '%',
		'em'  => 'em',
		'rem' => 'rem',
	];

	/**
	 * Fields options.
	 *
	 * @var array
	 */
	protected static $fields = [
		'all'        => false,
		'vertical'   => false,
		'horizontal' => false,
		'top'        => true,
		'right'      => true,
		'bottom'     => true,
		'left'       => true,
		'units'      => true,
	];

	/**
	 * Handles outputting the address field.
	 */
	public function render() {
		// Make sure we assign each part of the value we need.
		$value = wp_parse_args( $this->field->escaped_value(), [
			'all'        => '',
			'vertical'   => '',
			'horizontal' => '',
			'top'        => '',
			'right'      => '',
			'bottom'     => '',
			'left'       => '',
			'units'      => 'px',
		]);

		$this->selected_fields = wp_parse_args( $this->field->args( 'fields', [] ), self::$fields );

		$units = $this->field->args( 'units', [] );
		if ( empty( $units ) ) {
			$units = self::$units;
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
		} elseif ( $this->if_fields( 'vertical' ) || $this->if_fields( 'horizontal' ) ) {
			$fields = [];
			if ( $this->if_fields( 'vertical' ) ) {
				$fields[] = 'vertical';
			}
			if ( $this->if_fields( 'horizontal' ) ) {
				$fields[] = 'horizontal';
			}
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

		if ( $this->if_fields( 'units' ) ) {
			echo '<div class="part part-units">' . $this->types->select([
				'id'      => $this->_id( '_units' ),
				'name'    => $this->_name( '[units]' ),
				'desc'    => '',
				'options' => $this->select_options( $units, $value['units'] ),
			]) . '</div>';
		}

		echo '</div>';

		$this->_desc( true, true, true );

		// Grab the data from the output buffer.
		return $this->rendered( ob_get_clean() );
	}
}
