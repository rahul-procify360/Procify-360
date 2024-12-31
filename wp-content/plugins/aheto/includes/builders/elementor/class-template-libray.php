<?php
/**
 * The Elementor Configurator.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Elementor
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Elementor;

use Elementor\Plugin;
use Aheto\Traits\Hooker;
use Aheto\Template_Kit\API;
use Elementor\TemplateLibrary\Source_Base;

defined( 'ABSPATH' ) || exit;

/**
 * Template Libray class.
 */
class Template_Libray extends Source_Base {

	/**
	 * Get remote template ID.
	 *
	 * Retrieve the remote template ID.
	 *
	 * @return string The remote template ID.
	 */
	public function get_id() {
		return 'aheto';
	}


	/**
	 * Get remote template title.
	 *
	 * Retrieve the remote template title.
	 *
	 * @return string The remote template title.
	 */
	public function get_title() {
		return aheto()->plugin_name() . __( ' Templates', 'aheto' );
	}

	/**
	 * Register remote template data.
	 *
	 * Used to register custom template data like a post type, a taxonomy or any
	 * other data.
	 */
	public function register_data() {}

	/**
	 * Get remote templates.
	 *
	 * Retrieve remote templates from Elementor.com servers.
	 *
	 * @param array $args Optional. Nou used in remote source.
	 *
	 * @return array Remote templates.
	 */
	public function get_items( $args = [] ) {
		$templates    = [];
		$library_data = API::get()->get_templates();

		if ( ! empty( $library_data ) ) {
			foreach ( $library_data as $template_data ) {
				$templates[] = $this->prepare_template( $template_data );
			}
		}

		return $templates;
	}

	/**
	 * Get remote template.
	 *
	 * Retrieve a single remote template from Elementor.com servers.
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return array Remote template.
	 */
	public function get_item( $template_id ) {
		$templates = $this->get_items();

		return $templates[ $template_id ];
	}

	/**
	 * Save remote template.
	 *
	 * Remote template from Elementor.com servers cannot be saved on the
	 * database as they are retrieved from remote servers.
	 *
	 * @param array $template_data Remote template data.
	 *
	 * @return \WP_Error
	 */
	public function save_item( $template_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot save template to a remote source' );
	}

	/**
	 * Update remote template.
	 *
	 * Remote template from Elementor.com servers cannot be updated on the
	 * database as they are retrieved from remote servers.
	 *
	 * @param array $new_data New template data.
	 *
	 * @return \WP_Error
	 */
	public function update_item( $new_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot update template to a remote source' );
	}

	/**
	 * Delete remote template.
	 *
	 * Remote template from Elementor.com servers cannot be deleted from the
	 * database as they are retrieved from remote servers.
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return \WP_Error
	 */
	public function delete_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot delete template from a remote source' );
	}

	/**
	 * Export remote template.
	 *
	 * Remote template from Elementor.com servers cannot be exported from the
	 * database as they are retrieved from remote servers.
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return \WP_Error
	 */
	public function export_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot export template from a remote source' );
	}

	/**
	 * Get remote template data.
	 *
	 * Retrieve the data of a single remote template from Elementor.com servers.
	 *
	 * @param array  $args    Custom template arguments.
	 * @param string $context Optional. The context. Default is `display`.
	 *
	 * @return array Remote Template data.
	 */
	public function get_data( array $args, $context = 'display' ) {
		$template = API::get()->get_template_by_id( $args['template_id'], 'elementor' );
		if ( is_wp_error( $template ) ) {
			return $template;
		}

		$data            = $template['data'];
		$elementor       = new \Aheto\Elementor\Importer;
		$data['content'] = $elementor->replace_elements_ids( $data['content'] );
		$data['content'] = $elementor->process_export_import_content( $data['content'], 'on_import' );

		$post_id  = $args['editor_post_id'];
		$document = Plugin::$instance->documents->get( $post_id );
		if ( $document ) {
			$data['content'] = $document->get_elements_raw_data( $data['content'], true );
		}

		return $data;
	}

	/**
	 * Prepare single template data.
	 *
	 * @param array $template_data Fetched template data.
	 *
	 * @return array
	 */
	private function prepare_template( array $template_data ) {
		$favorite_templates = $this->get_user_meta( 'favorites' );

		return [
			'template_id'     => $template_data['ID'],
			'source'          => $this->get_id(),
			'type'            => $template_data['type'],
			'subtype'         => $template_data['subtype'],
			'title'           => $template_data['title'],
			'thumbnail'       => $template_data['elementor_thumbnail'],
			'date'            => (string) $template_data['tmpl_created'],
			'author'          => $template_data['author'],
			'tags'            => $template_data['tags']['terms'],
			'isPro'           => false,
			'popularityIndex' => (int) $template_data['popularity_index'],
			'trendIndex'      => (int) $template_data['trend_index'],
			'hasPageSettings' => ( '1' === $template_data['has_page_settings'] ),
			'url'             => $template_data['preview_url'],
			'favorite'        => ! empty( $favorite_templates[ $template_data['ID'] ] ),
		];
	}
}
