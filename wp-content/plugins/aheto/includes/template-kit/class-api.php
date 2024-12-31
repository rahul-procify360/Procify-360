<?php
/**
 * The template api functionality of the plugin.
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
 * API class.
 */
class API {


	/**
	 * API endpoint.
	 *
	 * @var string
	 */

	private $url = 'https://import.getaheto.com/wp-json';

	/**
	 * The constructor
	 */
	public function __construct() {
		$this->url = $this->check_url();
	}

	public function check_url() {

		$custom_api_url = apply_filters( 'aheto_api_url', '' );

		return !empty($custom_api_url) ? $custom_api_url : 'https://import.getaheto.com/wp-json';

	}


	/**
	 * Get class instance.
	 *
	 * @return API
	 */
	public static function get() {

		static $instance;

		if ( ! is_null( $instance ) ) {
			return $instance;
		}

		$instance = new self;

		return $instance;
	}

	/**
	 * Get template categories.
	 *
	 * @return array
	 */
	public function get_categories() {

		$cats = $this->get_data( '/wp/v2/aheto-template-category', [ $this, 'format_categories' ] );

		return is_array( $cats ) ? $cats : [ esc_html__( 'All', 'aheto' ) => 75 ];
	}

	/**
	 * Get template categories.
	 *
	 * @return array
	 */
	public function get_templates_categories() {

		$cat_theme = apply_filters( 'aheto_template_kit_category', false );
		$cat_theme = ( $cat_theme && is_string( $cat_theme ) ) ? $cat_theme : '';

		$response = wp_remote_get( $this->url . '/aheto/v1/getTemplatesCategories?cat=' . $cat_theme );

		$body = array();
		if ( is_wp_error( $response ) ) {
			echo $response->get_error_message();
		} elseif ( wp_remote_retrieve_response_code( $response ) === 200 ) {
			$body = (array) json_decode( wp_remote_retrieve_body( $response ) );
		}

		return $body ? $body : [ esc_html__( 'All', 'aheto' ) => 0 ];

	}

	/**
	 * Function get skins categories
	 *
	 * @return array
	 */
	public function get_skins_categories() {

		$cat_theme = apply_filters( 'aheto_template_kit_category', false );
		$cat_theme = ( $cat_theme && is_string( $cat_theme ) ) ? $cat_theme : '';

		$response = wp_remote_get( $this->url . '/aheto/v1/getSkinsCategories?cat=' . $cat_theme );

		$body = array();
		if ( is_wp_error( $response ) ) {
			echo $response->get_error_message();
		} elseif ( wp_remote_retrieve_response_code( $response ) === 200 ) {
			$body = (array) json_decode( wp_remote_retrieve_body( $response ) );
		}

		return $body ? $body : [ esc_html__( 'All', 'aheto' ) => 0 ];

	}

	/**
	 * Function get skins categories
	 *
	 * @return array
	 */
	public function get_headers_footers_categories( $type ) {

		$cat_theme = apply_filters( 'aheto_template_kit_category', false );
		$cat_theme = ( $cat_theme && is_string( $cat_theme ) ) ? $cat_theme : '';


		$response = wp_remote_get( $this->url . '/aheto/v1/getHeadersFootersCats?type=' . $type . '&cat=' . $cat_theme );


		$body = array();
		if ( is_wp_error( $response ) ) {
			echo $response->get_error_message();
		} elseif ( wp_remote_retrieve_response_code( $response ) === 200 ) {
			$body = (array) json_decode( wp_remote_retrieve_body( $response ) );
		}

		return $body ? $body : [ esc_html__( 'All', 'aheto' ) => 0 ];

	}

	/**
	 * Format categories data.
	 *
	 * @param array $categories Arrayd of fetched categories.
	 *
	 * @return array
	 */
	protected function format_categories( $categories ) {
		$categories = wp_list_pluck( $categories, 'count', 'name' );
		$count      = array_sum( $categories );

		return [ esc_html__( 'All', 'aheto' ) => $count ] + $categories;
	}

	/**
	 * Get skin templates.
	 *
	 * @return array
	 */
	public function get_skinss( $tags = false, $category = false ) {
		$endpoint = '/aheto/v1/getSkins';
	//	$tags     = apply_filters( 'aheto_template_kit_category', false );

		$set = "?";

		if ( isset( $tags ) && $tags && is_string( $tags ) ) {
			$endpoint .= $set . 'cat=' . $tags;
			$set      = "&";
		}

		if ( isset( $category ) && $category && is_string( $category ) ) {
			$endpoint .= $set . 'category=' . $category;
			$set      = "&";
		}

		$templates = $this->get_data( $endpoint, false, false );

		if ( ! is_array( $templates ) ) {
			return false;
		}

		return $templates;
	}

	/**
	 * Get headers/footers templates.
	 *
	 * @return array
	 */
	public function get_headers_footers( $tags = false, $category = false, $type = '' ) {
		$endpoint = '/aheto/v1/getHeadersFooters';
		$tags     = apply_filters( 'aheto_template_kit_category', false );

		$set = "?";

		//	if ( isset( $tags ) && $tags && is_string( $tags ) ) {
//			$endpoint .= $set . 'cat=' . $tags;
//			$set      = "&";
//		}//

		if ( ! empty( $type ) ) {
			$endpoint .= $set . 'type=' . $type;
			$set      = "&";
		}//

//		if ( isset( $category ) && $category && is_string( $category ) ) {
//			$endpoint .= $set . 'category=' . $category;
//			$set      = "&";
//		}

		$templates = $this->get_data( $endpoint, false, false );

		if ( ! is_array( $templates ) ) {
			return false;
		}

		return $templates;
	}


	/**
	 * Get templates.
	 *
	 * @return array
	 */
	public function get_templates( $tags = false, $category = false, $blocks = false, $type = '' ) {

		$endpoint = '/aheto/v1/getTemplates';

		$theme_tags = apply_filters( 'aheto_template_kit_category', false );
		$set        = "?";

		//$blocks="headers";
		if ( isset( $theme_tags ) && $theme_tags && is_string( $theme_tags ) ) {
			//	$tags = $theme_tags;
		}

		if ( isset( $tags ) && $tags && is_string( $tags ) ) {
			$endpoint .= $set . 'cat=' . $tags;
			$set      = "&";
		}


		if ( isset( $category ) && $category && is_string( $category ) ) {
			$endpoint .= $set . 'categories=' . $category;
			$set      = "&";
		}

		if ( isset( $blocks ) && $blocks && is_string( $blocks ) ) {
			$endpoint .= $set . 'blocks=' . $blocks;

		}

		$templates = $this->get_data( $endpoint, false, false );


		if ( ! is_array( $templates ) ) {
			return false;
		}

		return $templates;
	}

	/**
	 * Get Themes Grouped.
	 *
	 * @return array
	 */
	public function get_themes_grouped() {


		$templates=array();
		$check = true;
		$page=0;
		$per_page = 100;

	while ($check == true ) {
		$page ++;

		$endpoint = '/wp/v2/aheto-template-category?per_page='.$per_page.'&page='.$page;


		$template = $this->get_data( $endpoint, false, false );


		if ( ! is_array( $template) or count($template)<2) {
			$check = false;
		}
		$templates = array_merge($templates, $template);
		}


		return $templates;
	}



	/**
	 * Get template by id.
	 *
	 * @param string $id Template ID.
	 * @param string $builder Builder to get template data for.
	 *
	 * @return array
	 */
	public function get_template_by_id( $id, $builder ) {

		$use_real_images        = Helper::get_settings( 'general.use_real_images' );
		$replace_shortcode_name = Helper::get_settings( 'general.replace_shortcode_name' );

		$template = $this->get_data( '/aheto/v1/getTemplate/' . $id . '?builder=' . $builder, false, false );

		if ( ! is_array( $template ) ) {
			return false;
		}


		return $template;
	}

	/**
	 * Get skin by id.
	 *
	 * @param string $id Template ID.
	 * @param string $builder Builder to get template data for.
	 *
	 * @return array
	 */
	public function get_skin_by_id( $id ) {

		$template    = wp_remote_get( $this->url . '/aheto/v1/getSkin/' . $id );
		$response    = json_decode( $template['body'] );
		$export_file = $response->data->data->file;


		if ( ! is_array( $template ) ) {
			return false;
		}

		return $response->data;
	}

	/**
	 * Get header-footer by id.
	 *
	 * @param string $id Template ID.
	 * @param string $builder Builder to get template data for.
	 *
	 * @return array
	 */
	public function get_header_footer_by_id( $id ) {

		$template    = wp_remote_get( $this->url . '/aheto/v1/getHeaderFooter/' . $id );
		$response    = json_decode( $template['body'] );
		$export_file = $response->data->data->file;

		if ( ! is_array( $template ) ) {
			return false;
		}

		return $response->data;
	}


	public function get_demodata( $endpoint, $callback = false, $cache = true, $is_cache = false  ) {

		return $this->get_data( $endpoint, $callback, $cache, $is_cache );
	}

	/**
	 * Get data from api.
	 *
	 * @param string $endpoint API endpoint.
	 * @param callback $callback Perform data normalizatio.
	 * @param boolean $cache Cache or not.
	 *
	 * @return mixed
	 */
	private function get_data( $endpoint, $callback = false, $cache = true, $is_cache = false ) {


		$user_dirname = wp_upload_dir()['basedir'] . "/aheto-demo/";

		if ( ! file_exists( $user_dirname ) ) {
			wp_mkdir_p( $user_dirname );
		}


		$saved_data = $user_dirname . md5( $endpoint ) . ".json";


		if ( file_exists( $saved_data ) and file_get_contents( $saved_data ) and $is_cache == false and strlen( file_get_contents( $saved_data ))> 10) {


			$response['body'] = file_get_contents( $saved_data );

		} else {

			$cache_key = str_replace( [ '/', '?', '=', '&' ], '_', $endpoint );
			$data      = get_transient( $cache_key );
			if ( $cache && false !== $data ) {
				return $data;
			}

			$endpoint = $this->url . $endpoint;
			$response = wp_remote_get( $endpoint );


			if ( ! is_array( $response ) || is_wp_error( $response ) ) {
				return false;
			}

			$response['body'] = $this->replace_str_content( $response['body'] );

			if (strlen($response['body'])>10)
			//file_put_contents($saved_data, $response['body']);
			file_put_contents( $saved_data, $response['body'] );

			// var_dump($response['body']);
			if ( $cache ) {
				set_transient( $cache_key, $data, DAY_IN_SECONDS );
			}
			if ( is_callable( $callback ) ) {
				$data = call_user_func( $callback, $data );
			}

		}


		$data = (array) json_decode( $response['body'], true );


		return $data;
	}

	public function replace_str_content( $content ) {

		$use_real_images        = Helper::get_settings( 'general.use_real_images' );
		$replace_shortcode_name = Helper::get_settings( 'general.replace_shortcode_name' );

		$content_array = json_decode( $content );

		if ( isset( $content_array->slug ) ) {
			$slug = $content_array->slug;
		} else {
			$slug = "cs_";
		}


		// In case we decided to replace the CS

		if ( $replace_shortcode_name ) {
			$content = str_replace( 'cs_', $slug . '_', $content );
		}

		// In case we want to replace
		if ( $use_real_images ) {
			$content = str_replace( 'demo-uploads', 'uploads', $content );
		}

		return $content;

	}

}
