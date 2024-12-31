<?php
/**
 * The importer
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Elementor
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Elementor;

use Elementor\Plugin;
use Elementor\Utils;
use Aheto\Helper;
use Aheto\Dynamic_CSS;
use Elementor\Core\Settings\Page\Model;

defined( 'ABSPATH' ) || exit;

/**
 * Importer class.
 */
class Importer {

	/**
	 * Import template.
	 *
	 * @param array  $template  Template data.
	 * @param string $title     Post type title.
	 * @param string $post_type Post type where to import template.
	 */
	public function import_template( $template, $title = false, $post_type = 'elementor_library' ) {
		if ( empty( $template ) ) {
			return new \WP_Error( 'data_error', 'Invalid Data' );
		}

		$data    = $template['data'];
		$content = $data['content'];
		$content = $this->process_export_import_content( $content, 'on_import' );

		$page_settings = [];
		if ( ! empty( $data['page_settings'] ) ) {
			$page = new Model( [
				'id'       => 0,
				'settings' => $data['page_settings'],
			] );

			$page_settings_data = $this->process_element_export_import_content( $page, 'on_import' );

			if ( ! empty( $page_settings_data['settings'] ) ) {
				$page_settings = $page_settings_data['settings'];
			}
		}

		$template_id = $this->save_item( [
			'content'       => $content,
			'title'         => $title ? $title : $template['title'],
			'type'          => $data['type'],
			'post_type'     => $post_type,
			'page_settings' => $page_settings,
		], true );


		update_post_meta( $template_id, '_wp_page_template', 'aheto_canvas' );

		return $template_id;
	}

	/**
	 * Function preparing and setting thumbnail for just imported header
	 *
	 * @param $thumb
	 * @param $post_id
	 */
	private function prepare_thumbnail_for_post( $thumb, $post_id ) {
		$image_url        = $thumb;
		$image_name       = 'thmb-'.$post_id.'.png';
		$upload_dir       = wp_upload_dir();
		$image_data       = file_get_contents( $image_url );
		$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name );
		$filename         = basename( $unique_file_name );

		if( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}

		file_put_contents( $file, $image_data );

		$wp_filetype = wp_check_filetype( $filename, null );

		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		set_post_thumbnail( $post_id, $attach_id );

	}

	/**
	 * Import template page
	 *
	 * @param $template
	 * @param $page_id
	 * @param string $post_type
	 * @return int|\WP_Error
	 */
	public function import_template_page( $template, $page_id, $post_type = 'elementor_library' ) {

		if ( empty( $template ) ) {
			return array( 'error' => 'Invalid Data in json.', 'success' => false );
		}

		$this->import_template( $template );
		$page      = get_post( $page_id );
		$page_name = $page->post_title;

		$data      = $template['data'];
		$content   = $data['content'];

		$style_settings = isset($content[0]['style_settings']) && !empty($content[0]['style_settings']) ? $content[0]['style_settings'] : '';
		$style_settings = !empty( $style_settings ) ? json_decode( $style_settings, true ) : '';

		$content   = $this->process_export_import_content( $content, 'on_import' );

		$page_settings = [];

		/* Fixes - import blog page */
		$short_name = strtolower( str_replace( ' ', '_', $template['title'] ) );
		if ( ( $short_name == 'blog_page' ) || ( $short_name == 'blogpage' ) ) {
			$content = '';
		}

		if ( ! empty( $data['page_settings'] ) ) {
			$page = new Model( [
				'id'       => 0,
				'settings' => $data['page_settings'],
			] );

			$page_settings_data = $this->process_element_export_import_content( $page, 'on_import' );

			if ( ! empty( $page_settings_data['settings'] ) ) {
				$page_settings = $page_settings_data['settings'];
			}
		}

		$additional = array(
			'header' =>  $content[0]['header'],
			'footer' =>  $content[0]['footer'],
			'skin'   =>  $content[0]['skin'],
		);

		$template_id = $this->save_item( [
			'ID'            => $page_id,
			'content'       => $content,
			'post_title'    => $page_name ? $page_name : $template['title'],
			'type'          => $data['type'],
			'post_status'   => isset($template['status']) ? $template['status'] : 'publish',
			'post_type'     => isset($template['post_type']) ? $template['post_type'] : '',
			'page_settings' => $page_settings,
		], false, true, $additional );

		update_post_meta( $template_id, '_wp_page_template', 		'aheto_canvas' );
		update_post_meta( $template_id, '_elementor_page_settings', $style_settings );


		if ( ( $post_type == 'page' ) && ( ( $short_name == 'front_page' ) || ( $short_name == 'frontpage' ) ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $page_id );
		}
		elseif ( ( $post_type == 'page' ) && ( ( $short_name == 'blog_page' ) || ( $short_name == 'blogpage' ) ) ) {
			update_option( 'page_for_posts', $page_id );
		}

		return array( 'template_id' => $template_id, 'success' => true );

	}

	/**
	 * Import template page
	 *
	 * @param $template
	 * @param $page_id
	 * @param string $post_type
	 * @return int|\WP_Error
	 */
	public function import_header_footer_json( $template, $post_type = 'elementor_library' ) {

		if ( empty( $template ) ) {
			return array( 'message' => 'Invalid Data in json or empty template.', 'success' => false );
		}

		$cpt 	 = '';
		if ( $post_type == 'headers' ) {
			$cpt = 'aheto-header';
		}
		elseif ( $post_type == 'footers' ) {
			$cpt = 'aheto-footer';
		}

		$content = json_decode( file_get_contents( $template->data->file ), true );
		$content = $content['content'];
		$content = $this->process_export_import_content( $content, 'on_import' );

		$page_settings = [];

		$template_id = $this->save_item( [
			'content'       => $content,
			'post_title'    => $template->title,
			'type'          => 'page',
			'post_status'   => 'publish',
			'post_type'     => $cpt,
			'page_settings' => $page_settings,
		], true, true, false );

		update_post_meta( $template_id, '_wp_page_template', 'aheto_canvas' );

		if ( !empty( $template_id ) && !empty( $template->thumb ) ) {
			$this->prepare_thumbnail_for_post( $template->thumb, $template_id );
		}

		return array( 'template_id' => $template_id, 'success' => true );

	}

	/**
	 * Import skin function.
	 *
	 * @param $template
	 * @param bool $title
	 * @param string $post_type
	 * @return array|\WP_Error
	 */
	public function import_skin( $template, $title = false, $post_type = 'elementor_library' ) {
		if ( empty( $template ) ) {
			return array( 'message' => 'Invalid Data in json or empty template.', 'status' => false );
		}

		$file_url    = $template->data->file;
		$name        = $template->title;

		// Parse Options.
		$wp_filesystem = Helper::init_filesystem();
		$settings      = $wp_filesystem->get_contents( $file_url );
		$settings      = json_decode( $settings, true );

		$name          = $settings['name'];
		$down      	   = false;
		$generated 	   = get_option( 'aheto_generated_skins' );
		$response  	   = array();

		foreach ( $settings as $key => $options ) {
			if ( ( $key != 'name' ) && ( $key != 'aheto_generated_skins' ) ) {
				$key = str_replace( 'aheto_skin_', '', $key );

				if ( !array_key_exists( $key, $generated ) ) {
					$generated[$key] = $name;
					new Dynamic_CSS( $key, $settings['aheto_skin_' . $key] );
					$down = true;
					update_option( 'aheto_skin_' . $key,    $options );
					update_option( 'aheto_generated_skins', $generated );
				}
				else {
					$response['message']  = 'This skin already exists.';
				}
			}
		}

		$response['status'] = $down;
		if ( $down ) {
			$response['message']  = 'Skin is successfully imported.';
		}

		wp_cache_flush();

		return $response;

	}

	/**
	 * Import template page - importing via json
	 *
	 * @param $template
	 * @param $page_id
	 * @param string $post_type
	 * @return int|\WP_Error
	 */
	public function import_template_page_via_json( $template, $post_type = 'page' ) {

		if ( empty( $template ) ) {
			return new \WP_Error( 'data_error', 'Invalid Data' );
		}


		$content    = $template['content'];


		$style_settings = $content[0]['style_settings'];
		$style_settings = !empty( $style_settings ) ? json_decode( $style_settings, true ) : '';

		$additional = array(
			'header' =>  $content[0]['header'],
			'footer' =>  $content[0]['footer'],
			'skin'   =>  $content[0]['skin'],
		);
		$content    = $this->process_export_import_content( $content, 'on_import' );

		/* Fixes - import blog page */
		$short_name = strtolower( str_replace( ' ', '_', $template['title'] ) );
		if ( ( $short_name == 'blog_page' ) || ( $short_name == 'blogpage' ) ) {
			$content = '';
		}

		$page_settings = [];

		$template_id = $this->save_item( [
			'content'       => $content,
			'post_title'    => $template['title'],
			'type'          => $template['type'],
			'post_status'   => 'publish',
			'post_type'     => $template['type'],
			'page_settings' => $page_settings,
		], true, true, $additional );

		update_post_meta( $template_id, '_wp_page_template', 		'aheto_canvas' );
		update_post_meta( $template_id, '_elementor_page_settings', $style_settings );

		if ( ( $post_type == 'page' ) && ( ( $short_name == 'front_page' ) || ( $short_name == 'frontpage' ) ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $template_id );
		}
		elseif ( ( $post_type == 'page' ) && ( ( $short_name == 'blog_page' ) || ( $short_name == 'blogpage' ) ) ) {
			update_option( 'page_for_posts', $template_id );
		}

		return $template_id;

	}

	/**
	 * Function creating page - ready demos
	 *
	 * @param $page_title
	 * @param string $type
	 * @return bool|int|\WP_Error
	 */
	public function creating_page(  $page_title, $type = 'page' ) {

		if ( empty( $page_title ) ) return false;
		$template_id = $this->save_item( [
			'content'       => 'content here',
			'title'         => $page_title ? $page_title : 'Created Page',
			'post_type'     => 'page',
			'type'          => 'page',
		] );

		return $template_id;
	}

	/**
	 * Replace elements IDs.
	 *
	 * For any given Elementor content/data, replace the IDs with new randomly
	 * generated IDs.
	 *
	 * @param array $content Any type of Elementor data.
	 *
	 * @return mixed Iterated data.
	 */
	public function replace_elements_ids( $content ) {
		return Plugin::$instance->db->iterate_data( $content, function( $element ) {
			$element['id'] = Utils::generate_random_string();

			return $element;
		} );
	}

	/**
	 * Process content for export/import.
	 *
	 * Process the content and all the inner elements, and prepare all the
	 * elements data for export/import.
	 *
	 * @param array  $content A set of elements.
	 * @param string $method  Accepts either `on_export` to export data or
	 *                        `on_import` to import data.
	 *
	 * @return mixed Processed content data.
	 */
	public function process_export_import_content( $content, $method ) {
		return Plugin::$instance->db->iterate_data(
			$content, function( $element_data ) use ( $method ) {


			$element = Plugin::$instance->elements_manager->create_element_instance( $element_data );

			// If the widget/element isn't exist, like a plugin that creates a widget but deactivated.
			if ( ! $element ) {
				return null;
			}

			return $this->process_element_export_import_content( $element, $method );
		}
		);
	}

	/**
	 * Process single element content for export/import.
	 *
	 * Process any given element and prepare the element data for export/import.
	 *
	 * @param object $element Element instance.
	 * @param string $method  Accepts either `on_export` to export data or
	 *                        `on_import` to import data.
	 *
	 * @return array Processed element data.
	 */
	public function process_element_export_import_content( $element, $method ) {
		$element_data = $element->get_data();

		if ( method_exists( $element, $method ) ) {
			$element_data = $element->{$method}( $element_data );
		}

		foreach ( $element->get_controls() as $control ) {
			$control_class = Plugin::$instance->controls_manager->get_control( $control['type'] );

			// If the control isn't exist, like a plugin that creates the control but deactivated.
			if ( ! $control_class ) {
				return $element_data;
			}

			if ( method_exists( $control_class, $method ) ) {
				$element_data['settings'][ $control['name'] ] = $control_class->{$method}( $element->get_settings( $control['name'] ), $control );
			}

			// On Export, check if the control has an argument 'export' => false.
			if ( 'on_export' === $method && isset( $control['export'] ) && false === $control['export'] ) {
				unset( $element_data['settings'][ $control['name'] ] );
			}
		}

		return $element_data;
	}

	/**
	 * Save local template.
	 *
	 * Save new or update existing template on the database.
	 *
	 * @param array $template_data Local template data.
	 *
	 * @return \WP_Error|int The ID of the saved/updated template, `WP_Error` otherwise.
	 */
	public function save_item( $template_data, $type = true, $third = false, $additional = array() ) {

		$post_type_object = get_post_type_object( $template_data['post_type'] );

		if ( ! current_user_can( $post_type_object->cap->edit_posts ) && $type ) {
			return new \WP_Error( 'save_error', __( 'Access denied.', 'aheto' ) );
		}

		$title_started = $third ? $template_data['post_title'] : __( '(no title)', 'aheto' );
		$template_data = wp_parse_args(
			$template_data,
			[
				'title'         => $title_started,
				'page_settings' => [],
				'status'        => current_user_can( 'publish_posts' ) ? 'publish' : 'pending',
			]
		);

		if ( $type ) {
			$document = Plugin::$instance->documents->create(
				$template_data['type'],
				[
					'post_title' => $template_data['title'],
					'post_status'=> $template_data['status'],
					'post_type'  => $template_data['post_type'],
				]
			);
		}
		else {
			$document = Plugin::$instance->documents->get( $template_data['ID'] );
		}

		if ( is_wp_error( $document ) ) {
			return $document;
		}

		$document->save( [
			'elements' => $template_data['content'],
			'settings' => $template_data['page_settings'],
		] );

		$template_id = ( $type ) ? $document->get_main_id(): $template_data['ID'];

		if ( !empty( $third ) && $third && !empty( $additional ) ) {
			update_post_meta( $template_id, '_wp_page_template', 'aheto_canvas' );
			update_post_meta( $template_id, 'aheto_footer_layout', $additional['footer'] );
			update_post_meta( $template_id, 'aheto_header_layout', $additional['header'] );
			update_post_meta( $template_id, 'aheto_skin_layout',   $additional['skin'] );
		}

		/**
		 * After template library save.
		 *
		 * Fires after Elementor template library was saved.
		 *
		 * @param int   $template_id   The ID of the template.
		 * @param array $template_data The template data.
		 */
		do_action( 'elementor/template-library/after_save_template', $template_id, $template_data ); //phpcs:ignore

		/**
		 * After template library update.
		 *
		 * Fires after Elementor template library was updated.
		 *
		 * @param int   $template_id   The ID of the template.
		 * @param array $template_data The template data.
		 */
		do_action( 'elementor/template-library/after_update_template', $template_id, $template_data ); //phpcs:ignore

		return $template_id;
	}

}
