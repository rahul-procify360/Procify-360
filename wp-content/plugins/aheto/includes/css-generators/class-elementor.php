<?php
/**
 * The CSS Generator abstract
 *
 * @since      1.0.0
 * @package    Aheto\CSS\Generator
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\CSS\Generator;

defined( 'ABSPATH' ) || exit;

/**
 * CLass Elementor
 */
class Elementor extends Generator {

	/**
	 * Builder slug.
	 *
	 * @var string
	 */
	protected $slug = 'elementor';

	/**
	 * Parse content for css.
	 *
	 * @param int $post_id Current post id.
	 *
	 * @return array|null
	 */
	public function parse_content( int $post_id ) {
		if ( ! empty( $_POST['actions'] ) ) {
			$content = json_decode( stripslashes( $_POST['actions'] ), true );
		}

		$data = [];
		$elements = ( isset( $content['save_builder']['data']['elements'] ) ) ? $content['save_builder']['data']['elements'] : [];

		$this->recursive( $elements, $data );

		return $data;
	}

	private function recursive( $elements, &$data ) {
		foreach ( $elements as $element ) {
			if ( isset( $element['widgetType'] ) && ! empty( $element['widgetType'] ) ) {
				if ( ! isset( $data[ $element['widgetType'] ] ) ) {
					$data[ $element['widgetType'] ] = [];
				}

				$template = ! empty( $element['settings']['template'] ) ? $element['settings']['template'] : 'view';
				$data[ $element['widgetType'] ][ $template ] = true;
			}

			if ( isset( $element['elements'] ) && ! empty( $element['elements'] ) ) {
				$this->recursive( $element['elements'], $data );
			}
		}
	}
}
