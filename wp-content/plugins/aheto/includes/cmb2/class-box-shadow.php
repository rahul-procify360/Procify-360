<?php
/**
 * The CMB2 Box_Shadow field.
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
 * Box_Shadow class.
 */


class Box_Shadow extends CMB2_Type_Base {

	use Helpers;

	/**
	 * Fields options.
	 *
	 * @var array
	 */
	protected static $fields = [
		'hoffset' => true,
		'voffset' => true,
		'blur'    => true,
		'spread'  => true,
		'color'   => true,
		'inset'   => true,
	];

	/**
	 * Handles outputting the address field.
	 */
	public function render() {
		// Make sure we assign each part of the value we need.
		$value = wp_parse_args( $this->field->escaped_value(), [
			'hoffset' => '',
			'voffset' => '',
			'blur'    => '',
			'spread'  => '',
			'color'   => '',
			'inset'   => '',
		]);

		$this->selected_fields = wp_parse_args( $this->field->args( 'fields', [] ), self::$fields );

		ob_start();

		$strings = [
			'voffset' => 'Vertical',
			'hoffset' => 'Horizontal',
			'blur'    => 'Blur',
			'spread'  => 'Spread',
		];

		foreach ( [ 'voffset', 'hoffset', 'blur', 'spread' ] as $id ) :

			if ( ! $this->if_fields( $id ) ) {
				continue;
			}

			$this->render_col();

			echo $this->types->input([
				'id'          => $this->_id( '_' . $id ),
				'name'        => $this->_name( '[' . $id . ']' ),
				'desc'        => '',
				'class'       => 'cmb2-text-small',
				'value'       => $value[ $id ],
				'placeholder' => esc_html( $strings[ $id ] ),
			]);

			$this->render_col( true );

		endforeach;

		if ( $this->if_fields( 'color' ) ) {
			$this->render_col();
			echo $this->types->colorpicker([
				'id'   => $this->_id( '_color' ),
				'name' => $this->_name( '[color]' ),
				'desc' => '',

			], $value['color'] );
			$this->render_col( true );
		}

		if ( $this->if_fields( 'inset' ) ) {
			$this->render_col();
			echo $this->types->select([
				'id'      => $this->_id( '_inset' ),
				'name'    => $this->_name( '[inset]' ),
				'desc'    => '',
				'options' => $this->select_options([
					''      => esc_html__( 'Outset', 'aheto' ),
					'inset' => esc_html__( 'Inset', 'aheto' ),
				], $value['inset'] ),
			]);
			$this->render_col( true );
		}

		$this->_desc( true, true, true );

		// Grab the data from the output buffer.
		return $this->rendered( ob_get_clean() );
	}
}
