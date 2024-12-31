<?php
/**
 * The Post_Types
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use Aheto\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Post_Types class.
 */
class Post_Types {

	use Hooker;

	/**
	 * The Constructor
	 */
	public function __construct() {
		$this->header();
		$this->footer();
		$this->portfolio();
		$this->media();

		$this->action( 'load-post.php', 'adjust_portfolio_post_formats' );
		$this->action( 'load-post-new.php', 'adjust_portfolio_post_formats' );
	}

	/**
	 * Header Post Type
	 */
	public function header() {
		$labels = [
			'name'           => esc_html_x( 'Headers', 'Post Type General Name', 'aheto' ),
			'singular_name'  => esc_html_x( 'Header', 'Post Type Singular Name', 'aheto' ),
			'menu_name'      => esc_html__( 'Headers', 'aheto' ),
			'name_admin_bar' => esc_html__( 'Headers', 'aheto' ),
			'add_new_item'   => esc_html__( 'Add New Header', 'aheto' ),
			'new_item'       => esc_html__( 'New Header', 'aheto' ),
			'edit_item'      => esc_html__( 'Edit Header', 'aheto' ),
			'update_item'    => esc_html__( 'Update Header', 'aheto' ),
			'view_item'      => esc_html__( 'View Header', 'aheto' ),
			'search_items'   => esc_html__( 'Search Header', 'aheto' ),
		];

		$args = [
			'label'               => esc_html__( 'Header', 'aheto' ),
			'labels'              => $labels,
			'description'         => esc_html__( 'To create custom header using visual builder.', 'aheto' ),
			'supports'            => [ 'title', 'editor', 'revisions', 'thumbnail' ],
			'public'              => true,
			'show_ui'             => true,
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-align-center',
			'rewrite'             => false,
			'capability_type'     => 'page',
			'exclude_from_search' => true,
			'publicly_queryable'  => $this->is_elementor_editing(),
		];

		register_post_type( 'aheto-header', $args );
	}

	/**
	 * Footer Post Type
	 */
	public function footer() {
		$labels = [
			'name'           => esc_html_x( 'Footers', 'Post Type General Name', 'aheto' ),
			'singular_name'  => esc_html_x( 'Footer', 'Post Type Singular Name', 'aheto' ),
			'menu_name'      => esc_html__( 'Footers', 'aheto' ),
			'name_admin_bar' => esc_html__( 'Footers', 'aheto' ),
			'add_new_item'   => esc_html__( 'Add New Footer', 'aheto' ),
			'new_item'       => esc_html__( 'New Footer', 'aheto' ),
			'edit_item'      => esc_html__( 'Edit Footer', 'aheto' ),
			'update_item'    => esc_html__( 'Update Footer', 'aheto' ),
			'view_item'      => esc_html__( 'View Footer', 'aheto' ),
			'search_items'   => esc_html__( 'Search Footer', 'aheto' ),
		];

		$args = [
			'label'               => esc_html__( 'Footer', 'aheto' ),
			'labels'              => $labels,
			'description'         => esc_html__( 'To create custom footer using visual builder.', 'aheto' ),
			'supports'            => [ 'title', 'editor', 'revisions', 'thumbnail' ],
			'public'              => true,
			'show_ui'             => true,
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-align-center',
			'rewrite'             => false,
			'capability_type'     => 'page',
			'exclude_from_search' => true,
			'publicly_queryable'  => $this->is_elementor_editing(),
		];

		register_post_type( 'aheto-footer', $args );
	}

	/**
	 * Portfolio Post Type and Taxonomies.
	 */
	public function portfolio() {
		$labels = [
			'name'             => esc_html_x( 'Portfolios', 'Post Type General Name', 'aheto' ),
			'singular_name'    => esc_html_x( 'Portfolio', 'Post Type Singular Name', 'aheto' ),
			'menu_name'        => esc_html__( 'Portfolio items', 'aheto' ),
			'name_admin_bar'   => esc_html__( 'Portfolio item', 'aheto' ),
			'archives'         => esc_html__( 'Portfolio item Archives', 'aheto' ),
			'add_new_item'     => esc_html__( 'Add New Portfolio', 'aheto' ),
			'new_item'         => esc_html__( 'New Portfolio', 'aheto' ),
			'edit_item'        => esc_html__( 'Edit Portfolio', 'aheto' ),
			'update_item'      => esc_html__( 'Update Portfolio', 'aheto' ),
			'view_item'        => esc_html__( 'View Portfolio', 'aheto' ),
			'search_items'     => esc_html__( 'Search Portfolios', 'aheto' ),
			'insert_into_item' => esc_html__( 'Insert into Portfolio', 'aheto' ),
		];
		$labels = apply_filters( 'aheto_portfolio_items_labels', $labels );

		$args = [
			'label'             => esc_html__( 'Portfolio', 'aheto' ),
			'labels'            => $labels,
			'public'            => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => true,
			'menu_position'     => 25.3,
			'menu_icon'         => 'dashicons-format-image',
			'capability_type'   => 'page',
			'has_archive'       => 'portfolios',
			'query_var'         => 'portfolios',
			'supports'          => [ 'title', 'editor', 'excerpt', 'thumbnail', 'post-formats' ],
			'rewrite'           => [
				'slug'       => 'portfolio',
				'with_front' => true,
				'pages'      => true,
				'feeds'      => false,
			],
		];
		$args = apply_filters( 'aheto_portfolio_items_args', $args );

		register_post_type( 'aheto-portfolio', $args );

		/**
		 * Taxonomy: Portfolio Category
		 * Register Custom Taxonomy
		 */
		$args = [
			'label'             => esc_html_x( 'Portfolio Categories', 'Taxonomy General Name', 'aheto' ),
			'labels'            => [
				'name'          => esc_html_x( 'Portfolio Categories', 'Taxonomy General Name', 'aheto' ),
				'singular_name' => esc_html_x( 'Portfolio Category', 'Taxonomy Singular Name', 'aheto' ),
				'menu_name'     => __( 'Categories', 'aheto' ),
			],
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'query_var'         => 'portfolio-category',
			'rewrite'           => [
				'slug'         => 'portfolio-category',
				'with_front'   => true,
				'hierarchical' => false,
			],
		];

		register_taxonomy( 'aheto-portfolio-category', [ 'aheto-portfolio' ], $args );
		register_taxonomy_for_object_type( 'post_format', 'aheto-portfolio' );

		/**
		 * Taxonomy: Portfolio Tags
		 * Register Custom Taxonomy
		 */
		$args = [
			'label'             => esc_html_x( 'Portfolio Tags', 'Taxonomy General Name', 'aheto' ),
			'labels'            => [
				'name'          => esc_html_x( 'Portfolio Tags', 'Taxonomy General Name', 'aheto' ),
				'singular_name' => esc_html_x( 'Portfolio Tag', 'Taxonomy Singular Name', 'aheto' ),
				'menu_name'     => __( 'Tags', 'aheto' ),
				'new_item_name' => 'New Tag Name',
				'add_new_item'  => 'Add New Tag',
				'edit_item'     => 'Edit Tag',
			],
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'query_var'         => 'portfolio-tag',
			'rewrite'           => [
				'slug'         => 'portfolio-tag',
				'with_front'   => true,
				'hierarchical' => false,
			],
		];

		register_taxonomy( 'aheto-portfolio-tag', [ 'aheto-portfolio' ], $args );
		register_taxonomy_for_object_type( 'post_format', 'aheto-portfolio' );
	}



	/**
	 * Media Taxonomies.
	 */
	public function media() {

		/**
		 * Taxonomy: Media Category
		 * Register Custom Taxonomy
		 */
		$args = [
			'label'             => esc_html_x( 'Categories', 'Taxonomy General Name', 'aheto' ),
			'labels'            => [
				'name'          => esc_html_x( 'Categories', 'Taxonomy General Name', 'aheto' ),
				'singular_name' => esc_html_x( 'Category', 'Taxonomy Singular Name', 'aheto' ),
				'menu_name'     => __( 'Categories', 'aheto' ),
			],
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'query_var'         => 'media-category',
			'rewrite'           => [
				'slug'         => 'media-category',
				'with_front'   => true,
				'hierarchical' => false,
			],
		];

		register_taxonomy( 'media-category', [ 'attachment' ], $args );
		register_taxonomy_for_object_type( 'post_format', 'attachment' );

		/**
		 * Taxonomy: Portfolio Tags
		 * Register Custom Taxonomy
		 */
		$args = [
			'label'             => esc_html_x( 'Tags', 'Taxonomy General Name', 'aheto' ),
			'labels'            => [
				'name'          => esc_html_x( 'Tags', 'Taxonomy General Name', 'aheto' ),
				'singular_name' => esc_html_x( 'Tag', 'Taxonomy Singular Name', 'aheto' ),
				'menu_name'     => __( 'Tags', 'aheto' ),
				'new_item_name' => 'New Tag Name',
				'add_new_item'  => 'Add New Tag',
				'edit_item'     => 'Edit Tag',
			],
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'query_var'         => 'media-tag',
			'rewrite'           => [
				'slug'         => 'media-tag',
				'with_front'   => true,
				'hierarchical' => false,
			],
		];

		register_taxonomy( 'media-tag', [ 'attachment' ], $args );
		register_taxonomy_for_object_type( 'post_format', 'attachment' );
	}


	/**
	 * Adjust post format type for portfolio post type.
	 */
	public function adjust_portfolio_post_formats() {
		if ( 'aheto-portfolio' == Helper::get_post_type() ) {
			add_theme_support( 'post-formats', [ 'audio', 'gallery', 'video' ] );
		}
	}

	/**
	 * Check if is editing mode for elementor.
	 *
	 * @return bool
	 */
	private function is_elementor_editing() {
		return isset( $_GET['elementor-preview'] );
	}
}
