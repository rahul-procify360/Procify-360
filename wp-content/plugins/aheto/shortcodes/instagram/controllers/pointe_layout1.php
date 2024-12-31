<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_instagram_register', 'pointe_instagram_layout1' );


/**
 * Heading
 */
function pointe_instagram_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/instagram/previews/';

	$shortcode->add_layout( 'pointe_layout1', [
		'title' => esc_html__( 'Pointe Instagram', 'pointe' ),
		'image' => $preview_dir . 'pointe_layout1.jpg',
	] );


	aheto_demos_add_dependency(['limit', 'size'], ['pointe_layout1'], $shortcode);

	\Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'         => 'pointe_',
        'dependency' => ['template',  ['pointe_layout1']]
    ]);

}


