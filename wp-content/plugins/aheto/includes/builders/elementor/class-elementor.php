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

use Aheto\Helper;
use Aheto\Traits\Hooker;
use Aheto\Elementor\Controls\Image_Selector;
use Aheto\Generate_elementor_admin_css;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor base class.
 */
class Elementor {

	use Hooker;

	/**
	 * The Constructor.
	 */
	public function __construct() {
		$post_types = [ 'post', 'page', 'aheto-header', 'aheto-footer', 'aheto-portfolio' ];
		foreach ( $post_types as $post_type ) {
			add_post_type_support( $post_type, 'elementor' );
		}

		$this->action( 'init', 'init' );
		$this->action( 'elementor/editor/before_enqueue_scripts', 'controls' );
		$this->action( 'elementor/controls/register', 'add_controls' );
		$this->action( 'elementor/preview/enqueue_scripts', 'preview_enqueue_scripts' );
		$this->action( 'elementor/editor/before_enqueue_scripts', 'enqueue_modal' );
		$this->action( 'elementor/editor/footer', 'add_templates' );

		// AJAX.

		$this->action( 'wp_ajax_autocomplete_aheto_taxonomies', 'autocomplete_taxonomies' );
		$this->action( 'wp_ajax_autocomplete_aheto_exclude_field_search', 'autocomplete_posts_field' );
		$this->action( 'wp_ajax_autocomplete_aheto_include_field_search', 'autocomplete_posts_field' );
	}

	/**
	 * Add templates.
	 */
	public function add_templates() {

		include_once( dirname( __FILE__ ) . '/templates.php' );
	}

	/**
	 * Add custom controls to elementor
	 *
	 * @param ElementorControls_Manager $manager Controls manager instance.
	 */
	public function add_controls( $manager ) {
		require_once( __DIR__ . '/controls/class-image-selector.php' );
		$manager->register( new Image_Selector );
	}

	/**
	 * Add aheto categry to elementor
	 */
	public function init() {
		if ( ! \class_exists( '\\Elementor\\Plugin' ) ) {
			return;
		}

		\Elementor\Plugin::instance()->elements_manager->add_category( 'aheto', [
			'title' => aheto()->plugin_name(),
			'icon'  => 'fa fa-plug',
		]);

		\Elementor\Plugin::instance()->templates_manager->register_source( '\Aheto\Elementor\Template_Libray' );
	}

	/**
	 * Enqueue control scripts and styles.
	 *
	 * Used to register and enqueue custom scripts and styles used by the control.
	 */
	public function controls() {
		wp_enqueue_script( 'aheto-elementor-image-selector', aheto()->assets() . 'admin/js/elementor/image-selector.js', [ 'jquery' ], aheto()->version, true );
	}

	/**
	 * Enqueue preview scripts and styles.
	 *
	 * Used to register and enqueue custom scripts and styles used by the control.
	 */
	public function preview_enqueue_scripts() {
		wp_enqueue_script( 'aheto-elementor-image-selector', aheto()->assets() . 'admin/js/elementor/elementor-editor.js', [ 'jquery' ], aheto()->version, true );
	}

	/**
	 * Enqueue aheto template modal
	 */
	public function enqueue_modal() {

		wp_enqueue_script( 'aheto-elementor-templates', aheto()->assets() . 'admin/js/elementor/elementor-modal.js', [ 'jquery', 'backbone', 'elementor-editor' ], aheto()->version, true );
	}

	/**
	 * Autocomplete taxonomy search.
	 */
	public function autocomplete_taxonomies() {

		$query = isset( $_REQUEST['query'] ) ? $_REQUEST['query'] : false;

		if ( false ) {
			return [];
		}

		$data       = [];
		$taxonomies = Helper::get_taxonomies_types();
		$terms      = get_terms(
			array_keys( $taxonomies ),
			[
				'hide_empty' => false,
				'search'     => $query,
			]
		);

		if ( is_array( $terms ) && ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				if ( ! is_object( $term ) ) {
					continue;
				}

				if ( ! isset( $data[ $term->taxonomy ] ) ) {
					$data[ $term->taxonomy ] = [
						'text'     => isset( $taxonomies[ $term->taxonomy ], $taxonomies[ $term->taxonomy ]->labels, $taxonomies[ $term->taxonomy ]->labels->name ) ? $taxonomies[ $term->taxonomy ]->labels->name : __( 'Taxonomies', 'aheto' ),
						'children' => [],
					];
				}

				$data[ $term->taxonomy ]['children'][] = [
					'id'   => $term->term_id,
					'text' => $term->name,
				];
			}
		}

		wp_send_json( array_values( $data ) );
	}

	/**
	 * Autocomplete posts field search
	 */
	public function autocomplete_posts_field() {
		$query = isset( $_REQUEST['query'] ) ? $_REQUEST['query'] : false;
		if ( false ) {
			return [];
		}

		$data        = [];
		$search_args = [
			's'                => $query,
			'post_type'        => isset( $_REQUEST['postType'] ) ? $_REQUEST['postType'] : 'any',
			'posts_per_page'   => -1,
			'suppress_filters' => false,
		];

		if ( 0 === strlen( $search_args['s'] ) ) {
			unset( $search_args['s'] );
		}

		$this->filter( 'posts_search', 'search_by_title_only', 100, 2 );
		$posts = get_posts( $search_args );
		if ( is_array( $posts ) && ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				if ( ! isset( $data[ $post->post_type ] ) ) {
					$post_type_object         = get_post_type_object( $post->post_type );
					$data[ $post->post_type ] = [
						'text'     => $post_type_object->labels->name,
						'children' => [],
					];
				}

				$data[ $post->post_type ]['children'][] = [
					'id'   => $post->ID,
					'text' => $post->post_title,
				];
			}
		}

		wp_send_json( array_values( $data ) );
	}

	/**
	 * Search by title only
	 *
	 * @param string    $search      Search term.
	 * @param \WP_Query $wp_query Query instance.
	 *
	 * @return string
	 */
	public function search_by_title_only( $search, $wp_query ) {
		global $wpdb;

		if ( empty( $search ) ) {
			return $search; // skip processing - no search term in query.
		}

		$q = $wp_query->query_vars;
		$n = ! empty( $q['exact'] ) ? '' : '%';

		$search    = '';
		$searchand = '';

		foreach ( (array) $q['search_terms'] as $term ) {
			$term      = $wpdb->esc_like( $term );
			$like      = $n . $term . $n;
			$search   .= $wpdb->prepare( "{$searchand}($wpdb->posts.post_title LIKE %s)", $like );
			$searchand = ' AND ';
		}

		if ( ! empty( $search ) ) {
			$search = " AND ({$search}) ";
			if ( ! is_user_logged_in() ) {
				$search .= " AND ($wpdb->posts.post_password = '') ";
			}
		}

		return $search;
	}
}
