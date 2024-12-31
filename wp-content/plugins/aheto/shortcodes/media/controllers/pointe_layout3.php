<?php

add_action('aheto_before_aheto_media_register', 'pointe_media_layout3');


/**
 * Media Shortcode
 */

function pointe_media_layout3($shortcode) {

	$preview_dir = '//assets.aheto.co/media/previews/';
    
	$shortcode->add_layout('pointe_layout3', [
		'title' => esc_html__('Pointe Media Gallary', 'pointe'),
		'image' => $preview_dir . 'pointe_layout3.jpg',
    ]);
    
    $shortcode->add_dependecy('pointe_image', 'template', 'pointe_layout3');


	$shortcode->add_params([
        'pointe_image'     => [
            'type'    => 'attach_images',
            'heading' => esc_html__('Add image', 'pointe'),
        ]
    ]);
    
	\Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'pointe_',
        'dependency' => ['template', ['pointe_layout3']]
    ]);
   
}
