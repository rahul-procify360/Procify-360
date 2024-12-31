<?php
/**
 * The CMB2 field type helpers.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\CMB2
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\CMB2;

defined( 'ABSPATH' ) || exit;

/**
 * Spacing class.
 */
trait Helpers {

	/**
	 * If field is enabled.
	 *
	 * @param  string $field Field name.
	 * @return bool
	 */
	private function if_fields( $field = null ) {
		if ( ! is_string( $field ) ) {
			return false;
		}

		if ( ! isset( $this->selected_fields[ $field ] ) || ( isset( $this->selected_fields[ $field ] ) && true === $this->selected_fields[ $field ] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Render label for sub-field
	 *
	 * @param string $title Title to print.
	 * @param string $for   Field id for "for" attribute.
	 */
	private function render_label( $title, $for = '' ) {
		echo sprintf( '<label class="sub-label" for="%s">%s</label>', $for, $title );
	}

	/**
	 * Render grid
	 *
	 * @param string $what   What to render.
	 * @param string $grid   Grid size.
	 * @param string $column Column size.
	 */
	private function render_grid( $what = 'new', $grid = 'two', $column = 'col' ) {

		if ( 'new' === $what ) {
			echo '</div><div class="' . $column . '">';
			return;
		}

		if ( 'start' === $what ) {
			echo '<div class="aheto-grid"><div class="' . $grid . '-col"><div class="' . $column . '">';
			return;
		}

		if ( 'end' === $what ) {
			echo '</div></div></div>';
			return;
		}
	}

	/**
	 * Render col.
	 *
	 * @param bool $end Is end of column.
	 */
	private function render_col( $end = false ) {
		echo false === $end ? '<div class="col">' : '</div>';
	}

	/**
	 * Returns options markup for a select field.
	 *
	 * @param  array $options  Options for select.
	 * @param  mixed $selected Selected/saved state.
	 * @return string HTML string containing all options
	 */
	private function select_options( $options, $selected = false ) {
		$html = '';

		foreach ( $options as $value => $label ) {
			$html .= sprintf( "\t" . '<option value="%s" %s>%s</option>', $value, selected( $selected, $value, false ), $label ) . "\n";
		}

		return $html;
	}
}
