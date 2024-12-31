<?php
/**
 * The Choices helpers.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Helpers
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Choices class.
 */
trait Choices {

	/**
	 * Get post types.
	 *
	 * @param boolean $any Add any option at begining.
	 *
	 * @return array
	 */
	public static function choices_post_types( $any = true ) {
		$post_types = get_post_types( [ 'public' => true ] );
		$post_types = array_filter( $post_types, 'is_post_type_viewable' );

		$post_types = array_map( function ( $post_type ) {
			$object = get_post_type_object( $post_type );

			return $object->label;
		}, $post_types );

		if ( ! $any ) {
			return $post_types;
		}

		return [ 'any' => esc_html( 'Any', 'aheto' ) ] + $post_types;
	}

	/**
	 * Get post type as options
	 *
	 * @param  string $post_type Post type to get.
	 * @param  bool|string $all_option All option for select box.
	 *
	 * @return array
	 */
	public static function choices_posts_by_type( $post_type, $all_option = false ) {
		$posts = get_posts( [
			'posts_per_page' => - 1,
			'post_type'      => $post_type,
			'post_status'    => 'publish',
		] );
		$posts = wp_list_pluck( $posts, 'post_title', 'post_name' );

		if ( $all_option ) {
			$posts = [ '0' => $all_option ] + $posts;
		}

		return $posts;
	}


	/**
	 * Get post type as options
	 *
	 * @param  string $post_type Post type to get.
	 * @param  bool|string $all_option All option for select box.
	 *
	 * @return array
	 */
	public static function choices_posts_images_by_type( $post_type, $all_option = false ) {
		$posts = get_posts( [
			'posts_per_page' => - 1,
			'post_type'      => $post_type,
			'post_status'    => 'publish',
		] );
		$posts = wp_list_pluck( $posts, 'ID', 'post_name' );

		if ( $all_option ) {
			$posts = [ '0' => $all_option ] + $posts;
		}

		foreach ( $posts as $key => $post_id ) {

			if ( $key !== 0 ) {

				$image_url = get_the_post_thumbnail_url( $post_id, 'large' );
				$image     = ! empty( $image_url ) ? 'src=' . $image_url . 'title=' . get_the_title( $post_id ) : get_the_title( $post_id );

				$posts[ $key ] = $image;
			}

		}

		return $posts;
	}


	/**
	 * Get sidebars.
	 *
	 * @return array
	 */
	public static function choices_sidebars() {
		static $aheto_sidebars;

		if ( ! is_null( $aheto_sidebars ) ) {
			return $aheto_sidebars;
		}

		$aheto_sidebars = [ '' => esc_html__( 'No Sidebar', 'aheto' ) ];
		if ( ! isset( $GLOBALS['wp_registered_sidebars'] ) || empty( $GLOBALS['wp_registered_sidebars'] ) ) {
			return $aheto_sidebars;
		}

		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			$aheto_sidebars[ $sidebar['id'] ] = $sidebar['name'];
		}

		return $aheto_sidebars;
	}



	/**
	 * Get post templates.
	 *
	 * @return array
	 */

	public static function choices_post_templates() {
		static $aheto_post_templates;

		if ( ! is_null( $aheto_post_templates ) ) {
			return $aheto_post_templates;
		}

		$aheto_post_templates = [ '' => esc_html__( 'Use Theme Default', 'aheto' ) ];

		$cpt_class = new \Aheto\Shortcodes\CustomPostTypes;
		$cpt_class->set_params();

		$aheto_post_templates = array_merge($aheto_post_templates, $cpt_class->params['skin']['options']);

		return $aheto_post_templates;
	}


	/**
	 * Get navigation menus.
	 *
	 * @return array
	 */
	public static function choices_nav_menu() {
		static $aheto_nav_menus;

		if ( ! is_null( $aheto_nav_menus ) ) {
			return $aheto_nav_menus;
		}

		$menus = wp_get_nav_menus();
		if ( ! isset( $menus ) || empty( $menus ) ) {
			return [ '' => esc_html__( 'No Menu', 'aheto' ) ];
		}

		foreach ( $menus as $menu ) {
			$aheto_nav_menus[ $menu->slug ] = $menu->name;
//			$aheto_nav_menus[ $menu->term_id ] = $menu->name;
		}

		return $aheto_nav_menus;
	}

	public static function choices_image_size($custom = false) {
		$sizes = [];

		foreach ( array_merge( array( 'full' ), get_intermediate_image_sizes() ) as $size ) {
			$sizes[ $size ] = $size;
		}

		$sizes[ 'custom' ] = 'custom';

		return $sizes;
	}

	/**
	 * Social networks.
	 *
	 * @return array
	 */
	public static function choices_social_network() {
		return [
//			'android'   => esc_html__( 'Android', 'aheto' ),
//			'apple'     => esc_html__( 'Apple', 'aheto' ),
			'dribbble'  => esc_html__( 'Dribbble', 'aheto' ),
//			'dropbox'   => esc_html__( 'Dropbox', 'aheto' ),
			'facebook'  => esc_html__( 'Facebook', 'aheto' ),
//			'github'    => esc_html__( 'Github', 'aheto' ),
//			'google'    => esc_html__( 'Google', 'aheto' ),
			'instagram' => esc_html__( 'Instagram', 'aheto' ),
			'linkedin'  => esc_html__( 'Linkedin', 'aheto' ),
			'pinterest' => esc_html__( 'Pinterest', 'aheto' ),
//			'reddit'    => esc_html__( 'Reddit', 'aheto' ),
			'rss'       => esc_html__( 'RSS', 'aheto' ),
			'skype'     => esc_html__( 'Skype', 'aheto' ),
//			'snapchat'  => esc_html__( 'Snapchat', 'aheto' ),
			'tumblr'    => esc_html__( 'Tumblr', 'aheto' ),
//			'twitch'    => esc_html__( 'Twitch', 'aheto' ),
			'twitter'   => esc_html__( 'Twitter', 'aheto' ),
			'vimeo'     => esc_html__( 'Vimeo', 'aheto' ),
//			'whatsapp'  => esc_html__( 'Whatsapp', 'aheto' ),
//			'yahoo'     => esc_html__( 'Yahoo', 'aheto' ),
			'youtube'   => esc_html__( 'YouTube', 'aheto' ),
		];
	}


	/**
	 * Icons.
	 *
	 * @return array
	 */
	public static function choices_icons() {
		return [
			''                   => esc_html__( 'None', 'aheto' ),
			'email'              => esc_html__( 'Email', 'aheto' ),
			'mobile'             => esc_html__( 'Mobile', 'aheto' ),
			'map-alt'            => esc_html__( 'Map Alt', 'aheto' ),
			'blackboard'         => esc_html__( 'Blackboard', 'aheto' ),
			'gift'               => esc_html__( 'Gift', 'aheto' ),
			'tablet'             => esc_html__( 'Tablet', 'aheto' ),
			'cloud-down'         => esc_html__( 'Cloud Down', 'aheto' ),
			'bookmark'           => esc_html__( 'Bookmark', 'aheto' ),
			'cup'                => esc_html__( 'Cup', 'aheto' ),
			'comment'            => esc_html__( 'Comment', 'aheto' ),
			'marker-alt'         => esc_html__( 'Marker Alt', 'aheto' ),
			'paint-bucket'       => esc_html__( 'Paint Bucket', 'aheto' ),
			'heart'              => esc_html__( 'Heart', 'aheto' ),
			'lightbulb-outline'  => esc_html__( 'Lightbulb Outline', 'aheto' ),
			'color-wand-outline' => esc_html__( 'Color Wand Outline', 'aheto' ),
			'cart-outline'       => esc_html__( 'cart Outline', 'aheto' ),
			'shield'             => esc_html__( 'Shield', 'aheto' ),
			'face-smile'         => esc_html__( 'Face Smile', 'aheto' ),
			'package'            => esc_html__( 'Package', 'aheto' ),
			'music-alt'          => esc_html__( 'Music Alt', 'aheto' ),
			'pencil-alt'         => esc_html__( 'Pencil Alt', 'aheto' ),
			'home'               => esc_html__( 'Home', 'aheto' ),
			'crown'              => esc_html__( 'Crown', 'aheto' ),
		];
	}

	/**
	 * Alignment.
	 *
	 * @return array
	 */
	public static function choices_alignment() {
		return [
			''         => esc_html__( 'Default', 'aheto' ),
			't-left'   => esc_html__( 'Left', 'aheto' ),
			't-center' => esc_html__( 'Center', 'aheto' ),
			't-right'  => esc_html__( 'Right', 'aheto' ),
		];
	}


	public static function choices_pages( $post_type, $all_option = false ) {

		$posts = get_posts( [
			'posts_per_page' => - 1,
			'post_type'      => $post_type,
			'post_status'    => 'publish',
		] );
		$posts = wp_list_pluck( $posts, 'ID', 'ID' );

		if ( $all_option ) {
			$posts = [ '0' => $all_option ] + $posts;
		}

		foreach ( $posts as $key => $post_id ) {

			if ( $key !== 0 ) {

				$page_title = get_the_title($post_id);

				$posts[ $post_id ] = $page_title;
			}

		}

		return $posts;

	}


}
