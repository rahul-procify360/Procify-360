<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'pointe_features_single_layout2' );

/**
 * Features Single
 */

function pointe_features_single_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'pointe_layout2', [
		'title' => esc_html__( 'Pointe Style', 'pointe' ),
		'image' => $preview_dir . 'pointe_layout2.jpg',
	] );

	aheto_demos_add_dependency(['s_heading', 'use_heading', 't_heading'], ['pointe_layout2'], $shortcode);


    $shortcode->add_dependecy('pointe_image', 'template', 'pointe_layout2');

	$shortcode->add_params( [

		'pointe_image'   => [
            'type'    => 'attach_image',
            'heading' => esc_html__('Add Image', 'pointe'),
            'grid'    => 12,
        ]
	] );
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'pointe_',
		'dependency' => ['template', ['pointe_layout2']]
	]);
}