<?php
/**
 * Aheto Template Hooks
 *
 * Action/filter hooks used for Aheto functions/templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

defined( 'ABSPATH' ) || exit;

/**
 * Layout.
 *
 * @see aheto_header_markup()
 * @see aheto_footer_markup()
 * @see aheto_search_box()
 */
add_action( 'aheto_preloader', 'aheto_preloader_markup' );
add_action( 'aheto_header', 'aheto_header_markup' );
add_action( 'aheto_footer', 'aheto_footer_markup' );
add_action( 'aheto_footer', 'aheto_search_box', 99 );

/**
 * Before post content.
 */
add_action( 'aheto_before_post_content', 'aheto_post_format_content' );

/**
 * Partial after post content.
 *
 * @see aheto_post_footer_meta()
 * @see aheto_post_author_bio()
 * @see aheto_post_social_share()
 */
add_action( 'aheto_after_post_content', 'aheto_post_footer_meta' );
add_action( 'aheto_after_post_content', 'aheto_post_author_bio' );
add_action( 'aheto_after_post_content', 'aheto_post_social_share' );


/**
 * Partial after post content container.
 *
 * @see aheto_post_related_posts()
 * @see aheto_post_comments()
 */
add_action( 'aheto_after_post_container', 'aheto_post_related_posts' );
add_action( 'aheto_after_post_container', 'aheto_post_comments');


/**
 * 404 redirect.
 */
add_action('wp', 'aheto_404_redirect');
