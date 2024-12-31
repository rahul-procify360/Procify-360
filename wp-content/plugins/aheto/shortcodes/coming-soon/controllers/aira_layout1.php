<?php

use Aheto\Helper;
use Aheto\Sanitize;


add_action( 'aheto_before_aheto_coming-soon_register', 'aira_coming_soon_layout1' );

/**
 * Coming Soon Shortcode
 */
function aira_coming_soon_layout1( $shortcode ) {

    $theme_dir = '//assets.aheto.co/coming-soon/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira coming soon', 'aira' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );

    aheto_demos_add_dependency([
        'light',
        'days_desktop',
        'days_mobile',
        'hours_desktop',
        'hours_mobile',
        'mins_desktop',
        'mins_mobile',
        'secs_desktop',
        'secs_mobile',
        'typo_numbers',
        'use_typo_numbers',
        'typo_caption',
        'use_typo_caption',
        ], ['aira_layout1'], $shortcode);
}