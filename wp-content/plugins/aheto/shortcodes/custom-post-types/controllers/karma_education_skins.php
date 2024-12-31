<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'karma_education_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function karma_education_custom_post_types_skins( $shortcode ) {

	$aheto_skins  = $shortcode->params['skin']['options'];
	$aheto_addon_skins = array(
		'karma_education_skin-1'  => 'Karma Education skin 1 (For Product)',
	);
	$all_skins = array_merge( $aheto_skins, $aheto_addon_skins );
	$shortcode->params['skin']['options'] = $all_skins;


}

