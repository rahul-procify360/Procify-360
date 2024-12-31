<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'bizy_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function bizy_custom_post_types_skins( $shortcode ) {

    $aheto_skins  = $shortcode->params['skin']['options'];
    $aheto_addon_skins = array(
        'bizy_skin-1' => 'Bizy skin 1',
		'bizy_skin-2' => 'Bizy skin 2',
		'bizy_skin-3' => 'Bizy skin 3',
    );
    $all_skins = array_merge( $aheto_skins, $aheto_addon_skins );
    $shortcode->params['skin']['options'] = $all_skins;

    $shortcode->add_params([
	    'bizy_button_title'        => [
		    'type'    => 'text',
		    'heading' => esc_html__( 'Text for Button', 'bizy' ),
		    'default' => esc_html__( 'Get Started', 'bizy' ),
		    'group'      => esc_html__( 'Bizy Button', 'bizy' ),
	    ],
    ]);

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'bizy_btn_',
		'icons' => true,
		'link' => false,
		'dependency'     => [ 'skin', ['bizy_skin-2', 'bizy_skin-3' ] ],
		'group'      => esc_html__( 'Bizy Button', 'bizy' ),
	]);
}
function bizy_cpt_skin1_dynamic_css($css, $shortcode) {
    return $css;
}

add_filter('aheto_cpt_skin_dynamic_css', 'bizy_cpt_skin1_dynamic_css', 10, 2);