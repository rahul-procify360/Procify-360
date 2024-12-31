<?php
/**
 * The canvas template.
 *
 * @package Aheto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Aheto\Helper;

$header_path = \Aheto\Helper::get_settings( 'general.theme_header' );

if ( isset( $header_path ) && $header_path ) {

	get_header();

} else {

	add_action(
		'wp_enqueue_scripts',
		function () {
			wp_dequeue_style( 'twentyseventeen-style' );
			wp_dequeue_style( 'twentyseventeen-block-style' );
			wp_dequeue_style( 'twentyseventeen-colors-dark' );
			wp_dequeue_style( 'twentyseventeen-ie9' );
			wp_dequeue_style( 'twentyseventeen-ie8' );
		},
		20
	);

	$viewport = 'width=device-width, initial-scale=1';
	$viewport = apply_filters( "aheto_header_viewport", $viewport );

	?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
		<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
            <title><?php echo wp_get_document_title(); ?></title>
		<?php endif; ?>
		<?php wp_head(); ?>
        <meta name="viewport" content="<?php echo esc_attr( $viewport ); ?>">
    </head>
    <body <?php body_class(); ?>>
	<?php


	wp_body_open(); ?>
	<?php
}

/**
 * Before canvas page template content.
 *
 * @since 1.0.0
 */


do_action( 'aheto_preloader' );


if ( ! isset( $header_path ) || ! $header_path ) {

	do_action( 'aheto_header' );
}

while ( have_posts() ) :

	the_post();

	if ( post_password_required() ) {

		$content = apply_filters( 'aheto_password_protect', get_the_password_form() );

		echo $content;

	}else{

		remove_filter( 'the_content', 'wpautop' );
		the_content();
		add_filter( 'the_content', 'wpautop' );
	}

endwhile;


/**
 * Footer.
 */

$footer_path = \Aheto\Helper::get_settings( 'general.theme_footer' );

if ( isset( $footer_path ) && $footer_path ) {
	get_footer();
} else {
	do_action( 'aheto_footer' );

	wp_footer();
	?>
    </body>
    </html>

<?php }
