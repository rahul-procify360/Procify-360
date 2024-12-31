<?php
/**
 * The template importer api.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Template_Kit
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Template_Kit;

use Aheto\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Importer class.
 */
class Importer {

	/**
	 * Template data.
	 *
	 * @var array
	 */
	private $data;

	/**
	 * The Construct.
	 *
	 * @param array $data Template data.
	 */
	public function __construct( $data ) {
		$this->data = $data;
	}
}
