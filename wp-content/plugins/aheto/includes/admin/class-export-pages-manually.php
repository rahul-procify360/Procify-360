<?php
/**
 * The setup wizard.
 *
 * Walkthrough to the basic setup upon installation.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Admin
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Admin;

use Aheto\Helper;
use Aheto\Traits\Hooker;
use Aheto\Dynamic_CSS;
use Aheto\Helpers\Color;
use Header_Footer_Generator;
use TGM_Plugin_Activation;
use Aheto\Elementor\Importer;

/*
// TODO - don't delete it and uncomment it
use Elementor\Core\Base\Document;
use Elementor\DB;
use Elementor\Core\Settings\Manager as SettingsManager;
use Elementor\Plugin;
use Elementor\Utils;
*/

defined( 'ABSPATH' ) || exit;

/**
 * SetupWizard class.
 */
class ExportPagesManually {

	/**
	 * The Constructor
	 */
	public function __construct() {
		/*
		// TODO - don't delete it and uncomment it
		if ( ! Helper::is_setup_wizard() || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		add_action( 'elementor/template-library/after_save_template',  array( $this, 'export_page_new1' ), 999, 2 );
		*/
	}

	/* Functions for manually creating exporting-importing json files for pages in folder uploads/elementor/tmp
		// TODO - don't delete it and uncomment it

		public function export_page_new1(  $template_id, $template_data ) {

			$header_id   = get_post_meta( $template_data['post_id'], 'aheto_header_layout', true );
			$footer_id   = get_post_meta( $template_data['post_id'], 'aheto_footer_layout', true );
			$skin_id     = get_post_meta( $template_data['post_id'], 'aheto_skin_layout',   true );

			$input_array = json_decode( get_post_meta( $template_id, '_elementor_data', true ) );

			$array       = array(
				'header' => $header_id,
				'footer' => $footer_id,
				'skin'   => $skin_id,
			);

			$input_array[0]->header = $header_id;
			$input_array[0]->footer = $footer_id;
			$input_array[0]->skin   = $skin_id;

			$result = json_encode( $input_array );
			update_post_meta( $template_id, '_elementor_data', $result );

			$template_data = $this->get_data( [
				'template_id' => $template_id,
			] );

			$array1    = array(
				'title'  => get_the_title( $template_id )
			);
			$template_data = array_merge( $array1, $template_data, $array );
			$file_data     = $this->prepare_template_export( $template_id, $template_data );

			$wp_upload_dir = wp_upload_dir();
			$temp_path     = $wp_upload_dir['basedir'] . '/elementor/tmp';
			wp_mkdir_p( $temp_path );

			$this->send_file_headers( $file_data['name'], strlen( $file_data['content'] ) );

			foreach ( $template_data as $template_id ) {

				if ( is_wp_error( $file_data ) ) {
					continue;
				}

				$complete_path = $temp_path . '/' . $file_data['name'];

				$put_contents = file_put_contents( $complete_path, $file_data['content'] );

				if ( ! $put_contents ) {
					return new \WP_Error( '404', sprintf( 'Cannot create file "%s".', $file_data['name'] ) );
				}

				$files[] = [
					'path' => $complete_path,
					'name' => $file_data['name'],
				];
			}


			return true;

		}

		public function get_data( array $args ) {
			$db = Plugin::$instance->db;
			$template_id = $args['template_id'];
			if ( ! empty( $args['display'] ) ) {
				$content = $db->get_builder( $template_id );
			} else {
				$document = Plugin::$instance->documents->get( $template_id );
				$content = $document ? $document->get_elements_data() : [];
			}

			if ( ! empty( $content ) ) {
				$content = $this->replace_elements_ids( $content );
			}

			$data = [
				'content' => $content,
			];

			if ( ! empty( $args['page_settings'] ) ) {
				$page = SettingsManager::get_settings_managers( 'page' )->get_model( $args['template_id'] );

				$data['page_settings'] = $page->get_data( 'settings' );
			}

			return $data;
		}

		protected function replace_elements_ids( $content ) {
			return Plugin::$instance->db->iterate_data( $content, function( $element ) {
				$element['id'] = Utils::generate_random_string();

				return $element;
			} );
		}

		private function prepare_template_export( $template_id, $template_data  ) {

			$export_data = [
				'version' => '1.05',
				'type'    => 'page',
			];

			$export_data += $template_data;

			return [
				'name' => 'elementor-' . $template_id . '-' . date( 'Y-m-d' ) . '.json',
				'content' => wp_json_encode( $export_data ),
			];
		}

		public function send_file_headers( $name, $size ) {
		header( 'Content-Type: application/octet-stream' );
		header( 'Content-Disposition: attachment; filename=' . $name );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );
		header( 'Content-Length: ' . $size );
	}
	*/

}
