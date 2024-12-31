<?php
/**
 * The CSS Generator interface
 *
 * @since      1.0.0
 * @package    Aheto\CSS\Generator
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\CSS\Generator;

defined( 'ABSPATH' ) || exit;

/**
 * Interface for css generator.
 */
interface Parser {

	/**
	 * Parse group values.
	 *
	 * @param int $post_id Current post id.
	 */
	public function parse_content( int $post_id );
}
