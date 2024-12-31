<?php
/**
 * 404 Page
 */

get_header();

$redirect_page_id = \Aheto\Helper::get_settings( 'general.404_redirect' );

if ( isset( $redirect_page_id ) && ! empty( $redirect_page_id ) && $redirect_page_id !== 0 ) {

	$the_query = new WP_Query( 'page_id=' . $redirect_page_id );

	echo '<div class="container">';

	while ( $the_query->have_posts() ) : $the_query->the_post();

		remove_filter( 'the_content', 'wpautop' );
		the_content();
		add_filter( 'the_content', 'wpautop' );

	endwhile;

	echo '</div>';

}

get_footer();
