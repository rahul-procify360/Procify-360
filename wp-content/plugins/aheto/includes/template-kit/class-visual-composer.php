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
use Aheto\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Visual_Composer class.
 */
class Visual_Composer extends Importer {

	private $default_title = 'Aheto Demo Template';

	use Hooker;

	public function __construct() {
		$this->action( 'admin_post_add_page_template', 'create_page_with_template' );
	}

	/**
	 * Import content into builder.
	 */
	public function import_content() {

	}

	/**
	 * Create page with template.
	 */
	public function create_page_with_template() {

		$template_id = ( ! empty( $_POST['aheto_page_template_id'] ) ) ? (int) $_POST['aheto_page_template_id'] : 0;

		$res = $this->insert_post();

		if ( ! $res || is_wp_error( $res ) ) {
			Helper::add_notification( esc_html__( 'Try again.', 'aheto' ) );
		} else {
			Helper::add_notification( esc_html__( 'Page created.', 'aheto' ) );
		}

		wp_redirect( Helper::get_admin_url( 'templates' ) );
	}

	private function insert_post() {

		$res = wp_insert_post( array(
			'post_title' => $this->generate_default_title(),
			'post_content' => $this->get_content(),
			'post_status' => 'draft',
			'post_type' => 'page'
		) );

		return $res;
	}

	private function generate_default_title() {
		global $wpdb;

		if ( empty( $_POST['aheto_page_template_name'] ) ) {
			$count = $wpdb->get_var( $wpdb->prepare("SELECT count(post_title) FROM $wpdb->posts WHERE post_title LIKE %s", '%' . $this->default_title . '%' ) );

			if ( ! $count ) {
				$title = $this->default_title;
			} else {
				$count++;
				$title = $this->default_title . ' ' . $count;
			}

			return $title;
		} else {
			return sanitize_text_field( $_POST['aheto_page_template_name'] );
		}
	}

	private function get_content() {
		return '[vc_row][vc_column][aheto_banner template-banner="layout1" banners="%5B%7B%22test_select%22%3A%22layout1%22%2C%22link_style%22%3A%22aheto-btn--primary%22%7D%5D" border_heading="" box_heading=""][aheto_features template-features="layout1"][aheto_testimonials][/vc_column][/vc_row]';
	}
}
