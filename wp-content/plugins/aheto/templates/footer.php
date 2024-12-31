<?php
/**
 * The footer template.
 *
 * @package Aheto
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
