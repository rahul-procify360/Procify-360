<?php

use Aheto\Helper;

add_action('aheto_before_aheto_blockquote_register', 'bizy_blockquote_layout1');

/**
 * Blockquote Shortcode
 */
function bizy_blockquote_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/blockquote/previews/';

	$shortcode->add_layout('bizy_layout1', [
		'title' => esc_html__('Bizy Simple', 'bizy'),
		'image' => $preview_dir . 'bizy_layout1.jpg',
	]);

	$shortcode->add_dependecy( 'bizy_image', 'template', 'bizy_layout1' );

	aheto_demos_add_dependency(['quote', 'qoute_tag'], ['bizy_layout1'], $shortcode);

	$shortcode->add_params([
		'bizy_image'         => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Author Image', 'bizy' ),
		],
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Bizy Image size', 'bizy' ),
		'prefix' => 'bizy_',
		'dependency' => ['template', ['bizy_layout1']]
	]);

}