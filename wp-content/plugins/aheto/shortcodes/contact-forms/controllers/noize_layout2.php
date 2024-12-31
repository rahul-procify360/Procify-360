<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'noize_contact_forms_layout2' );

/**
 * Contact forms Shortcode
 */
function noize_contact_forms_layout2( $shortcode ) {
    $preview_dir = '//assets.aheto.co/contact-forms/previews/';

    $shortcode->add_layout( 'noize_layout2', [
        'title' => esc_html__( 'Contact Form 21', 'noize' ),
        'image' => $preview_dir . 'noize_layout2.jpg',
    ] );
}

function noize_contact_forms_layout2_button( $form_button ) {
    $form_button['dependency'][1][] = 'noize_layout2';

    return $form_button;
}

add_filter( 'aheto_button_contact-forms', 'noize_contact_forms_layout2_button', 10, 2 );