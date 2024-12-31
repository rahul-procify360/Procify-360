<?php


use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'mooseoom_contact_info_layout1');

/**
 * Contact forms
 */

function mooseoom_contact_info_layout1($shortcode)
{

	$preview_dir = '//assets.aheto.co/contact-info/previews/';

	$shortcode->add_layout('mooseoom_layout1', [
		'title' => esc_html__('Contact Info 4', 'mooseoom'),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	]);

	aheto_demos_add_dependency( ['title', 'use_typo', 'title_typo', 'address', 'email', 'phone', 'hovercolor', 'use_typo_text', 'text_typo'], ['mooseoom_layout1' ], $shortcode );

	\Aheto\Params::add_icon_params( $shortcode, [
		'add_icon'  => true,
		'add_label' => esc_html__( 'Add address icon?', 'mooseoom' ),
		'group'     => esc_html__( 'Icons', 'mooseoom' ),
		'prefix'    => 'mooseoom_address_',
		'exclude'    => [ 'align', 'color'],
		'dependency' => ['template', ['mooseoom_layout1']]
	]);

	\Aheto\Params::add_icon_params( $shortcode, [
		'add_icon'  => true,
		'add_label' => esc_html__( 'Add email icon?', 'mooseoom' ),
		'group'     => esc_html__( 'Icons', 'mooseoom' ),
		'prefix'    => 'mooseoom_email_',
		'dependency' => ['template', ['mooseoom_layout1']]
	]);

	\Aheto\Params::add_icon_params( $shortcode, [
		'add_icon'  => true,
		'add_label' => esc_html__( 'Add phone icon?', 'mooseoom' ),
		'group'     => esc_html__( 'Icons', 'mooseoom' ),
		'prefix'    => 'mooseoom_phone_',
		'dependency' => ['template', ['mooseoom_layout1']]
	]);
	
}
