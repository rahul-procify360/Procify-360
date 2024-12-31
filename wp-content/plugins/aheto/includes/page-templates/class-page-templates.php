<?php
/**
 * The Page templates
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use Aheto\Helper;
use Aheto\Settings;
use Aheto\Post_Types;
use Aheto\Json_Center;
use Aheto\Admin\Admin;
use Aheto\Traits\Hooker;
use Aheto\Builder_Loader;
use Aheto\Frontend\Frontend;
use Aheto\Notification_Center;

defined( 'ABSPATH' ) || exit;

/**
 * Page_Templates Class.
 */
class Page_Templates {

	use Hooker;

	/**
	 * Elementor Canvas template name.
	 */
	const TEMPLATE_CANVAS = 'aheto_canvas';

	/**
	 * The constructor
	 */
	public function __construct() {

		$this->filter( 'theme_templates', 'add_page_templates', 10 );
		$this->filter( 'template_include', 'template_include', 11 );
	}

	/**
	 * Add page templates.
	 *
	 * @param array $page_templates Array of page templates. Keys are filenames,
	 *                              checks are translated names.
	 *
	 * @return array Page templates.
	 */
	public function add_page_templates( $page_templates ) {
		$page_templates = [
			self::TEMPLATE_CANVAS => _x( aheto()->plugin_name() . ' Canvas', 'Page Template', 'aheto' ),
		] + $page_templates;

		return $page_templates;
	}

	/**
	 * Template include.
	 *
	 * Update the path for the Canvas template.
	 *
	 * @param  string $template The path of the template to include.
	 * @return string The path of the template to include.
	 */
	public function template_include( $template ) {
		$template_path = false;
		if ( is_singular() ) {
			$template_path = $this->get_template_path( get_post_meta( get_the_ID(), '_wp_page_template', true ) );
		}

		return $template_path ? $template_path : $template;
	}

	/**
	 * Get page template path.
	 *
	 * Retrieve the path for any given page template.
	 *
	 * @param  string $page_template The page template name.
	 * @return string Page template path.
	 */
	public function get_template_path( $page_template ) {
		$template_path = '';
		switch ( $page_template ) {
			case self::TEMPLATE_CANVAS:
				$template_path = __DIR__ . '/templates/canvas.php';
				break;
		}

		return $template_path;
	}
}
