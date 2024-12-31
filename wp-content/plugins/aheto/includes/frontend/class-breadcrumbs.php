<?php
/**
 * The Breadcrumbs.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Frontend;

defined( 'ABSPATH' ) || exit;

/**
 * Breadcrumbs class.
 */
class Breadcrumbs {

	/**
	 * Breadcrumb trail.
	 *
	 * @var array
	 */
	private $crumbs = [];

	/**
	 * Breadcrumb settings.
	 *
	 * @var array
	 */
	private $settings = [];

	/**
	 * String.
	 *
	 * @var array
	 */
	private $strings = [];

	/**
	 * Magic method to use in case the class would be send to string.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->get_breadcrumb();
	}

	/**
	 * The Constructor
	 *
	 * @codeCoverageIgnore
	 *
	 * @param array $settings (Optional) Breadcrumb settings.
	 * @param array $strings  (Optional) Strings.
	 */
	public function __construct( $settings = [], $strings = [] ) {

		$this->settings = wp_parse_args( $settings, [
			'home'           => true,
			'hide_tax_name'  => true,
			'show_ancestors' => false,
		]);

		$this->strings = wp_parse_args( $strings, [
			'home'           => esc_html__( 'Home', 'aheto' ),
			'error404'       => esc_html__( '404 Error: page not found', 'aheto' ),
			/* translators: archive title */
			'archive_format' => esc_html__( 'Archives for %s', 'aheto' ),
			/* translators: search query */
			'search_format'  => esc_html__( 'Results for %s', 'aheto' ),
		]);
	}

	/**
	 * Get the breadcrumb
	 *
	 * @return string
	 */
	public function get_breadcrumb( $ul_class = 'breadcrumbs', $li_class = 'breadcrumbs__item' ) {
		$html   = '';
		$crumbs = $this->get_crumbs();
		$size   = sizeof( $crumbs );

		foreach ( $crumbs as $key => $crumb ) {
			if ( ! empty( $crumb[1] ) && ( $size !== $key + 1 ) ) {
				$html .= '<li class="' . $li_class . '"><a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a></li>';
			} else {
				$html .= '<li class="' . $li_class . ' current">' . esc_html( $crumb[0] ) . '</li>';
			}
		}

		return '<ul class="' . $ul_class . '">' . $html . '</ul>';
	}

	/**
	 * Get the breadrumb trail
	 *
	 * @return array
	 */
	public function get_crumbs() {
		if ( empty( $this->crumbs ) ) {
			$this->generate();
		}

		return $this->crumbs;
	}

	/**
	 * Add a crumb so we don't get lost
	 *
	 * @param string $name Name.
	 * @param string $link Link.
	 */
	private function add_crumb( $name, $link = '' ) {
		$this->crumbs[] = [
			strip_tags( $name ),
			$link,
		];
	}

	/**
	 * Generate breadcrumb trail
	 */
	private function generate() {
		$conditionals = [
			'is_home',
			'is_404',
			'is_search',
			'is_attachment',
			'is_shop',
			'is_product',
			'is_singular',
			'is_product_category',
			'is_product_tag',
			'is_post_type_archive',
			'is_category',
			'is_tag',
			'is_tax',
			'is_date',
			'is_author',
		];

		if ( ! empty( $this->settings['home'] ) ) {
			$this->add_crumb( $this->strings['home'], home_url() );
		}

		$condition = ( ! is_front_page() && ! ( is_post_type_archive() && function_exists( 'wc_get_page_id' ) && intval( get_option( 'page_on_front' ) ) === wc_get_page_id( 'shop' ) ) ) || is_paged();
		if ( ! $condition ) {
			return;
		}

		foreach ( $conditionals as $conditional ) {
			if ( function_exists( $conditional ) && call_user_func( $conditional ) ) {
				call_user_func( [ $this, 'add_crumbs_' . substr( $conditional, 3 ) ] );
				break;
			}
		}
	}

	/**
	 * Is home trail
	 */
	private function add_crumbs_home() {
		$this->add_crumb( single_post_title( '', false ) );
	}

	/**
	 * 404 trail
	 */
	private function add_crumbs_404() {
		$this->add_crumb( $this->strings['error404'] );
	}

	/**
	 * Add a breadcrumb for search results
	 */
	private function add_crumbs_search() {
		$this->add_crumb( sprintf( $this->strings['search_format'], get_search_query() ), remove_query_arg( 'paged' ) );
	}

	/**
	 * Attachment trail
	 */
	private function add_crumbs_attachment() {
		global $post;

		$this->add_crumbs_singular( $post->post_parent, get_permalink( $post->post_parent ) );
		$this->add_crumb( get_the_title(), get_permalink() );
	}

	/**
	 * Single product trail
	 */
	private function add_crumbs_product() {
		global $post;

		$this->prepend_shop_page();
		$this->maybe_add_primary_term( wc_get_product_terms( $post->ID, 'product_cat', [
			'orderby' => 'parent',
			'order'   => 'DESC',
		]));

		if ( isset( $post->ID ) ) {
			$this->add_crumb( get_the_title( $post ), get_permalink( $post ) );
		}
	}

	/**
	 * Single post trail
	 *
	 * @param int    $post_id   Post ID.
	 * @param string $permalink Post permalink.
	 */
	private function add_crumbs_singular( $post_id = 0, $permalink = '' ) {
		$post      = ! $post_id ? $GLOBALS['post'] : get_post( $post_id );
		$post_type = get_post_type( $post );
		$permalink = $permalink ? $permalink : get_permalink( $post );

		$this->add_crumbs_post_type_archive( $post_type );

		if ( ! isset( $post->ID ) ) {
			return;
		}

		if ( isset( $post->post_parent ) && 0 !== $post->post_parent ) {
			$this->add_post_ancestors( $post );
		}

		$this->add_crumb( get_the_title( $post ), $permalink );
	}

	/**
	 * Product category trail
	 */
	private function add_crumbs_product_category() {
		$term = $GLOBALS['wp_query']->get_queried_object();
		$this->prepend_shop_page();
		$this->maybe_add_term_ancestors( $term );
		$this->add_crumb( $term->name );
	}

	/**
	 * Product tag trail
	 */
	private function add_crumbs_product_tag() {
		$term = $GLOBALS['wp_query']->get_queried_object();
		$this->prepend_shop_page();
		/* translators: %s: product tag */
		$this->add_crumb( sprintf( __( 'Products tagged &ldquo;%s&rdquo;', 'aheto' ), $term->name ) );
	}

	/**
	 * Shop breadcrumb
	 */
	private function add_crumbs_shop() {
		$shop_page_id = wc_get_page_id( 'shop' );
		if ( intval( get_option( 'page_on_front' ) ) === $shop_page_id ) {
			return;
		}

		$name = $shop_page_id ? get_the_title( $shop_page_id ) : '';
		if ( ! $name ) {
			$post_type = get_post_type_object( 'product' );
			$name      = $post_type->labels->singular_name;
		}
		$this->add_crumb( $name, get_post_type_archive_link( 'product' ) );
	}

	/**
	 * Post type archive trail
	 *
	 * @param string $post_type Post type.
	 */
	private function add_crumbs_post_type_archive( $post_type = null ) {
		if ( 'post' !== $post_type ) {
			return;
		}

		$type_object = get_post_type_object( $post_type );
		if ( ! empty( $type_object->has_archive ) ) {
			$this->add_crumb( $type_object->labels->singular_name, get_post_type_archive_link( $post_type ) );
		}
	}

	/**
	 * Category trail
	 */
	private function add_crumbs_category() {
		$term = $GLOBALS['wp_query']->get_queried_object();
		$this->maybe_add_term_ancestors( $term );
		$this->add_crumb( $term->name, get_term_link( $term ) );
	}

	/**
	 * Tag trail
	 */
	private function add_crumbs_tag() {
		$term = $GLOBALS['wp_query']->get_queried_object();
		$this->add_crumb( $term->name, get_term_link( $term ) );
	}

	/**
	 * Add crumbs for taxonomies
	 */
	private function add_crumbs_tax() {
		$term = $GLOBALS['wp_query']->get_queried_object();
		if ( ! $this->settings['hide_tax_name'] ) {
			$taxonomy = get_taxonomy( $term->taxonomy );
			$this->add_crumb( $taxonomy->labels->name );
		}

		$this->maybe_add_term_ancestors( $term );
		$this->add_crumb( $term->name, get_term_link( $term ) );
	}

	/**
	 * Add crumbs for date based archives
	 */
	private function add_crumbs_date() {
		if ( is_year() || is_month() || is_day() ) {
			$this->add_crumb( sprintf( $this->strings['archive_format'], get_the_time( 'Y' ) ), get_year_link( get_the_time( 'Y' ) ) );
		}
		if ( is_month() || is_day() ) {
			$this->add_crumb( sprintf( $this->strings['archive_format'], get_the_time( 'F' ) ), get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) );
		}
		if ( is_day() ) {
			$this->add_crumb( sprintf( $this->strings['archive_format'], get_the_time( 'd' ) ) );
		}
	}

	/**
	 * Add a breadcrumb for author archives
	 */
	private function add_crumbs_author() {
		global $author;

		$userdata = get_userdata( $author );
		$this->add_crumb( sprintf( $this->strings['archive_format'], $userdata->display_name ) );
	}

	/**
	 * Add crumbs for a post
	 *
	 * @param WP_Post $post Post object.
	 */
	private function add_post_ancestors( $post ) {
		$ancestors = [];
		if ( isset( $post->ancestors ) ) {
			$ancestors = is_array( $post->ancestors ) ? array_values( $post->ancestors ) : [ $post->ancestors ];
		} elseif ( isset( $post->post_parent ) ) {
			$ancestors = [ $post->post_parent ];
		}

		if ( ! is_array( $ancestors ) ) {
			return;
		}

		// Reverse the order so it's oldest to newest.
		$ancestors = array_reverse( $ancestors );
		foreach ( $ancestors as $ancestor ) {
			$this->add_crumb( get_the_title( $ancestor ), get_permalink( $ancestor ) );
		}
	}

	/**
	 * Prepend the shop page to shop breadcrumbs
	 */
	private function prepend_shop_page() {
		$permalinks   = wc_get_permalink_structure();
		$shop_page_id = wc_get_page_id( 'shop' );
		$shop_page    = get_post( $shop_page_id );

		// If permalinks contain the shop page in the URI prepend the breadcrumb with shop.
		if ( $shop_page_id && $shop_page && isset( $permalinks['product_base'] ) && strstr( $permalinks['product_base'], '/' . $shop_page->post_name ) && intval( get_option( 'page_on_front' ) ) !== $shop_page_id ) {
			$this->add_crumb( get_the_title( $shop_page ), get_permalink( $shop_page ) );
		}
	}

	/**
	 * Get the primary term
	 *
	 * @param array $terms Terms attached to the current post.
	 */
	private function maybe_add_primary_term( $terms ) {
		// Early Bail!
		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return;
		}

		$term = $terms[0];
		$this->maybe_add_term_ancestors( $term );
		$this->add_crumb( $term->name, get_term_link( $term ) );
	}

	/**
	 * Add parent taxonomy crumbs to the crumb property for hierachical taxonomy
	 *
	 * @param object $term Term data object.
	 */
	private function maybe_add_term_ancestors( $term ) {
		// Early Bail!
		if ( 0 === $term->parent || false === $this->settings['show_ancestors'] || false === is_taxonomy_hierarchical( $term->taxonomy ) ) {
			return;
		}

		$ancestors = get_ancestors( $term->term_id, $term->taxonomy );
		$ancestors = array_reverse( $ancestors );

		foreach ( $ancestors as $ancestor ) {
			$ancestor = get_term( $ancestor, $term->taxonomy );
			if ( ! is_wp_error( $ancestor ) && $ancestor ) {
				$this->add_crumb( $ancestor->name, get_term_link( $ancestor ) );
			}
		}
	}
}
