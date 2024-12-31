<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'djo_custom_post_types_skins');

/**
 * Custom Post Type Shortcode
 */

function djo_custom_post_types_skins($shortcode) {

	$aheto_skins  = $shortcode->params['skin']['options'];
	$djo_skins = array(
		'djo_skin-1' => 'Djo skin',
		'djo_skin-2' => 'Djo skin banner',
	);


	$shortcode->add_dependecy( 'djo_use_date', 'skin', 'djo_skin-2' );
	$shortcode->add_dependecy( 'djo_date_typo', 'skin', 'djo_skin-2' );
	$shortcode->add_dependecy( 'djo_date_typo', 'djo_use_date', 'true' );
	$shortcode->add_dependecy( 'djo_use_desc', 'skin', 'djo_skin-2' );
	$shortcode->add_dependecy( 'djo_desc_typo', 'skin', 'djo_skin-2' );
	$shortcode->add_dependecy( 'djo_desc_typo', 'djo_use_desc', 'true' );
	$shortcode->add_params([
		'djo_use_date' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for date?', 'djo' ),
			'grid'    => 6,
		],

		'djo_date_typo' => [
			'type'     => 'typography',
			'group'    => 'Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
		],
		'djo_use_desc' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'djo' ),
			'grid'    => 6,
		],

		'djo_desc_typo' => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt',
		],
	]);

	$all_skins = array_merge($aheto_skins, $djo_skins);
	$shortcode->params['skin']['options'] = $all_skins;

}


function djo_custom_post_type_skins_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['djo_use_date']) && $shortcode->atts['djo_use_date'] && isset($shortcode->atts['djo_date_typo']) && !empty($shortcode->atts['djo_date_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__date'], $shortcode->parse_typography($shortcode->atts['djo_date_typo']));
	}
	if ( isset($shortcode->atts['djo_use_desc']) && $shortcode->atts['djo_use_desc'] && isset($shortcode->atts['djo_desc_typo']) && !empty($shortcode->atts['djo_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__excerpt'], $shortcode->parse_typography($shortcode->atts['djo_desc_typo']));
	}

	return $css;
}

add_filter('aheto_custom_post_type_dynamic_css', 'djo_custom_post_type_skins_dynamic_css', 10, 2);
