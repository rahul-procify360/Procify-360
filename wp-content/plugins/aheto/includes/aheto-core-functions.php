<?php
/**
 * The core functions.
 *
 * Functions to be used on front-end only.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * [aheto_get_post_meta description]
 *
 * @param  integer $post_id [description].
 * @param  string  $key     [description].
 * @param  boolean $single  [description].
 * @return mixed
 */
function aheto_get_post_meta( $post_id = 0, $key = '', $single = true ) {

	if ( 0 === $post_id ) {
		$post_id = get_post()->ID;
	}

	return get_post_meta( $post_id, 'aheto_' . $key, $single );
}


/**
 * Get header id.
 *
 * @param  integer $post_id Post ID.
 * @return integer
 */
function aheto_get_header_id( $post_id = 0 ) {

	$id = aheto_get_post_meta( $post_id, 'header_layout' );
	$id = apply_filters( "aheto_page_header", $id );
	$redirect_page_id = \Aheto\Helper::get_settings( 'general.404_redirect' );
	$redirect_page_slug = \Aheto\Helper::get_settings( 'general.404_redirect_slug' );
	$redirect_header_id = isset($redirect_page_id) && !empty($redirect_page_id) ? aheto_get_post_meta( $redirect_page_id, 'header_layout' ) : 0;

	$general_header = Helper::get_settings( 'general.header' );
	$general_header = isset($general_header['image_select']) && !empty($general_header['image_select']) ? $general_header['image_select'] : 0;
	$general_header = get_post_type() === 'aheto-header' || get_post_type() === 'aheto-footer' ? 0 : $general_header;


	if(is_404() && !empty($redirect_header_id) && $redirect_page_slug){
		$id = $redirect_header_id;
	}


	// No Header.
	if ( empty( $id ) && !is_404() && !is_search() && !is_archive() && !is_category() && !is_tag() && !$general_header) {

		return 0;
	}


	if(empty( $id ) && is_404()){
		$option_header = Helper::get_settings( 'general.header' );
		$default_header = isset($option_header['image_select']) && !empty($option_header['image_select']) ? $option_header['image_select'] : 0;


		$args = array(
			'name'        => $default_header,
			'post_type'   => 'aheto-header',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$aheto_header = get_posts($args);

		$default_header = $aheto_header ? $aheto_header[0]->ID : 0;


		return $default_header;
	}


	// Post setting.
	if ( ! empty( $id ) && 'default' !== $id ) {
		$args = array(
			'name'        => $id,
			'post_type'   => 'aheto-header',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$aheto_header = get_posts($args);

		$id = $aheto_header ? $aheto_header[0]->ID : 0;

		return $id;
	}

	if($id === '0'){
		return 0;
	}


	// Options.

	if($general_header){
		$args = array(
			'name'        => $general_header,
			'post_type'   => 'aheto-header',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$aheto_header = get_posts($args);

		$general_header = $aheto_header ? $aheto_header[0]->ID : 0;

		return $general_header;

	}else{
		return 0;
	}

}


/**
 * Get footer id.
 *
 * @param  integer $post_id Post ID.
 * @return integer
 */
function aheto_get_footer_id( $post_id = 0 ) {

	$id = aheto_get_post_meta( $post_id, 'footer_layout' );
	$id = apply_filters( "aheto_page_footer", $id );
	$redirect_page_id = \Aheto\Helper::get_settings( 'general.404_redirect' );
	$redirect_page_slug = \Aheto\Helper::get_settings( 'general.404_redirect_slug' );
	$redirect_footer_id = isset($redirect_page_id) && !empty($redirect_page_id) ? aheto_get_post_meta( $redirect_page_id, 'footer_layout' ) : 0;

	$general_footer = Helper::get_settings( 'general.footer' );
	$general_footer = isset($general_footer['image_select']) && !empty($general_footer['image_select']) ? $general_footer['image_select'] : 0;
	$general_footer = get_post_type() === 'aheto-header' || get_post_type() === 'aheto-footer' ? 0 : $general_footer;

	if(is_404() && !empty($redirect_footer_id) && $redirect_page_slug){
		$id = $redirect_footer_id;
	}

	//	// No Footer.
	if ( empty( $id ) && !is_404() && !is_search() && ! is_archive() && !is_category() && !is_tag() && !$general_footer) {
		return 0;
	}

	if(empty( $id ) && is_404()){
		$option_footer = Helper::get_settings( 'general.footer' );
		$default_footer = isset($option_footer['image_select']) && !empty($option_footer['image_select']) ? $option_footer['image_select'] : 0;
		$args = array(
			'name'        => $default_footer,
			'post_type'   => 'aheto-footer',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$aheto_footer = get_posts($args);

		$default_footer = $aheto_footer ? $aheto_footer[0]->ID : 0;

		return $default_footer;
	}

	// Post setting.
	if ( ! empty( $id ) && 'default' !== $id ) {
		$args = array(
			'name'        => $id,
			'post_type'   => 'aheto-footer',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$aheto_footer = get_posts($args);

		$id = $aheto_footer ? $aheto_footer[0]->ID : 0;

		return $id;
	}

	if($id === '0'){
		return 0;
	}

	// Options.
	if($general_footer){
		$args = array(
			'name'        => $general_footer,
			'post_type'   => 'aheto-footer',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$aheto_footer = get_posts($args);

		$general_footer = $aheto_footer ? $aheto_footer[0]->ID : 0;

		return $general_footer;

	}else{
		return 0;
	}
}

/**
 * Get footer id.
 *
 * @param  integer $post_id Post ID.
 * @return integer
 */
function aheto_get_skins_id( $post_id = 0 ) {
	$id = aheto_get_post_meta( $post_id, 'skin_layout' );
	$default_skin = Helper::get_active_skin();

	// No Skin.
	if ( empty( $id ) ) {
		return $default_skin;
	}

	// Post setting.
	if ( ! empty( $id ) && 'default' !== $id ) {
		return $id;
	}

	// Options.
	return Helper::get_active_skin();
}


/**
 * Add props to already inittiated selectors.
 *
 * @param array $css      Dynamic CSS holder.
 * @param array $settings Array of current value.
 */
function aheto_add_props( &$css, $settings ) {
	foreach ( $settings as $key => $val ) {

		if(!empty($val)){
			$css[ $key ] = $val;
		}

	}
}

/**
 * Helper function.
 * Merge and combine the CSS elements.
 *
 * @param  string|array $elements An array of our elements.
 *                                If we use a string then it is directly returned.
 * @return  string
 */
function aheto_implode( $elements = [] ) {

	if ( ! is_array( $elements ) ) {
		return $elements;
	}

	// Make sure our values are unique.
	$elements = array_unique( $elements );

	// Sort elements alphabetically.
	// This way all duplicate items will be merged in the final CSS array.
	sort( $elements );

	// Implode items and return the value.
	return implode( ',', $elements );

}

/**
 * Maps elements from dynamic css to the selector.
 *
 * @param  array  $elements The elements.
 * @param  string $selector_after The selector after the element.
 * @param  string $selector_before The selector before the element.
 * @return array
 */
function aheto_map_selector( $elements, $selector_after = '', $selector_before = '' ) {
	$array = [];
	foreach ( $elements as $element ) {
		$array[] = $selector_before . $element . $selector_after;
	}
	return $array;
}

/**
 * Require the template file with WordPress environment.
 *
 * @param string $template Path to template file.
 */
function aheto_locate_template( $template ) {
	$template = aheto()->plugin_dir() . 'templates/' . $template . '.php';

	return file_exists( $template ) ? $template : '';
}

/**
 * Require the template file with WordPress environment.
 *
 * @param string $template     Path to template file.
 * @param bool   $require_once Whether to require_once or require.
 */
function aheto_load_template( $template, $require_once = true ) {
	$located = aheto_locate_template( $template );
	if ( '' !== $located ) {
		load_template( $located, $require_once );
	}
}
