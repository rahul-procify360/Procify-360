<?php
/**
 * The header template.
 *
 * @package Aheto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


$header_path = \Aheto\Helper::get_settings( 'general.theme_header' );

if( isset($header_path) && $header_path ) {

    get_header();

}else{

	add_action(
		'wp_enqueue_scripts',
		function() {
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

	<?php wp_body_open(); ?>
	<?php
	/**
	 * Before canvas page template content.
	 *
	 * @since 1.0.0
	 */
	do_action( 'aheto_header' );


}
