<?php
/**
 * The Options helpers.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Helpers
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Options class.
 */
trait Options {

	/**
	 * Option prefix
	 *
	 * @var string
	 */
	private static $prefix = 'aheto_';

	/**
	 * Option handler.
	 *
	 * @param  string $key   Option to perform action.
	 * @param  mixed  $value Pass null to get option,
	 *                       Pass false to delete option,
	 *                       Pass value to update option.
	 * @return mixed
	 */
	private static function option( $key, $value = null ) {

		$key = self::$prefix . $key;

		if ( false === $value ) {
			return delete_option( $key );
		}

		if ( is_null( $value ) ) {
			return get_option( $key, [] );
		}

		return update_option( $key, $value );
	}

	/**
	 * Get platform stats
	 *
	 * @param  mixed $value Same as option().
	 * @return mixed
	 */
	public static function skins( $value = null ) {
		return self::option( 'generated_skins', $value );
	}

    /**
     * Get skin options
     *
     * @param $name
     * @return mixed
     */
	public static function skin( $name ) {
        return self::option( $name, null );
    }

    /**
     * returns the active skin selected by the user
     *
     * @return mixed
     */
    public static function get_active_skin() {
	    $multiply_skins = aheto()->settings->get( 'general.multiply_skins' );
        $skin = $multiply_skins ? 'default' : aheto()->settings->get( 'general.skin' );

	    return ( is_array( $skin ) && count($skin) !== 0 ) ? current( $skin ) : 'default';
    }

    public static function get_page_skin(){

	    if ( is_page() || is_home() ) {
		    $post_id = get_queried_object_id();
	    } else {
		    $post_id = get_the_ID();
	    }


	    $page_skin = get_post_meta( $post_id, 'aheto_skin_layout', true );
	    $page_skin = apply_filters( "aheto_page_skin", $page_skin );
	    $skin = isset($page_skin) && !empty($page_skin) && ! is_search() && !is_archive() && ! is_category() && ! is_tag()? $page_skin : '';

	    return $skin;
    }
}
