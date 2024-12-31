<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'famulus_features_single_layout4');


/**
 * Feature Single
 */

function famulus_features_single_layout4($shortcode)
{
    $preview_dir = '//assets.aheto.co/features-single/previews/';
    $shortcode->add_layout('famulus_layout4', [
        'title' => esc_html__('Features Single 10', 'famulus'),
        'image' => $preview_dir . 'famulus_layout4.jpg',
    ]);

    aheto_demos_add_dependency(['s_image', 's_heading', 's_description', 'use_description', 't_description', 'use_heading', 't_heading'], ['famulus_layout4'], $shortcode);

}
