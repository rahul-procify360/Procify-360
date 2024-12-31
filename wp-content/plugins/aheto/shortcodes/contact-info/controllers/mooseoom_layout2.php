<?php


use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'mooseoom_contact_info_layout2');

/**
 * Contact forms
 */

function mooseoom_contact_info_layout2($shortcode)
{

	$preview_dir = '//assets.aheto.co/contact-info/previews/';

	$shortcode->add_layout('mooseoom_layout2', [
		'title' => esc_html__('Contact Info 5', 'mooseoom'),
		'image' => $preview_dir . 'mooseoom_layout2.jpg',
	]);

	aheto_demos_add_dependency( ['address', 'phone', 'use_typo_text', 'text_typo'], ['mooseoom_layout2' ], $shortcode );

	\Aheto\Params::add_icon_params( $shortcode, [
		'add_icon'  => true,
		'add_label' => esc_html__( 'Add address icon?', 'mooseoom' ),
		'group'     => esc_html__( 'Icons', 'mooseoom' ),
		'prefix'    => 'mooseoom_address_',
		'exclude'    => [ 'align'],
		'dependency' => ['template', ['mooseoom_layout2']]
	]);
	\Aheto\Params::add_icon_params( $shortcode, [
		'add_icon'  => true,
		'add_label' => esc_html__( 'Add phone icon?', 'mooseoom' ),
		'group'     => esc_html__( 'Icons', 'mooseoom' ),
		'prefix'    => 'mooseoom_phone_',
		'exclude'    => [ 'align'],
		'dependency' => ['template', ['mooseoom_layout2']]
	]);
	
}
