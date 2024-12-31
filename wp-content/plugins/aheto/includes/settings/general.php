<?php
/**
 * General settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;
use Aheto\Admin;

$cmb->add_field([
	'id'      => 'builder',
	'type'    => 'select',
	'name'    => __( '<i class="fas fa-grip-horizontal"></i> <span>Default Builder</span>', 'aheto' ),
	'options' => [
		'elementor'       => esc_html__( 'Elementor', 'aheto' ),
		'visual-composer' => esc_html__( 'Visual Composer', 'aheto' ),
	],
	'default'          => 'elementor',
	'desc'    => esc_html__( 'Please, choose  Page Builder for your theme.', 'aheto' ),
]);

$cmb->add_field( [
	'id'      => 'multiply_skins',
	'type'    => 'switch',
	'name'    => __( '<i class="fas fa-magic"></i> <span>Disable multiply skins</span>', 'aheto' ),
	'desc'    => esc_html__( 'Turn on if you want to use only one skin ', 'aheto' ),
	'default' => 'off',
] );


$cmb->add_field([
	'id'      => 'skin',
	'type'    => 'search_select',
	'name'    => __( '<i class="fas fa-paint-brush"></i> <span>Skins</span>', 'aheto' ),
	'options' => Helper::skins(),
	'desc'    => esc_html__( 'Please, choose main skin for your theme.', 'aheto' ),
	'attributes'    => array(
		'data-conditional-id'     => 'multiply_skins',
		'data-conditional-value'  => 'off',
	),
]);

$cmb->add_field( [
	'id'      => 'theme_header',
	'type'    => 'switch',
	'name'    => __( '<i class="fas fa-user-cog"></i> <span>Use Default Theme Header</span>', 'aheto' ),
	'desc'    => esc_html__( 'Turn on if you want to use Default Theme Header functionality ', 'aheto' ),
	'default' => 'off',
] );

$cmb->add_field([
	'id'      => 'header',
	'type'    => 'image_select',
	'name'    => __( '<i class="fas fa-equals"></i> <span>Global Header</span>', 'aheto' ),
	'options' => Helper::choices_posts_images_by_type( 'aheto-header', esc_html__( 'Select header', 'aheto' ) ),
	'desc'    => esc_html__( 'Please, choose main header for your theme.', 'aheto' ),
	'attributes'    => array(
		'data-conditional-id'     => 'theme_header',
		'data-conditional-value'  => 'off',
	),
]);

$cmb->add_field( [
	'id'      => 'theme_footer',
	'type'    => 'switch',
	'name'    => __( '<i class="fas fa-user-cog"></i> <span>Use Default Theme Footer</span>', 'aheto' ),
	'desc'    => esc_html__( 'Turn on if you want to use Default Theme Footer functionality ', 'aheto' ),
	'default' => 'off',
] );

$cmb->add_field([
	'id'      => 'footer',
	'type'    => 'image_select',
	'name'    => __( '<i class="fas fa-money-check"></i> <span>Global Footer</span>', 'aheto' ),
	'options' => Helper::choices_posts_images_by_type( 'aheto-footer', esc_html__( 'Select footer', 'aheto' ) ),
	'desc'    => esc_html__( 'Please, choose main footer for your theme.', 'aheto' ),
	'attributes'    => array(
		'data-conditional-id'     => 'theme_footer',
		'data-conditional-value'  => 'off',
	),
]);


$cmb->add_field([
	'id'      => 'font-icons',
	'type'    => 'multicheck',
	'name'    => __( '<i class="fas fa-list-alt"></i> <span>Additional Icon Font sets</span>', 'aheto' ),
	'desc'    => esc_html__( 'Select icon font sets you want to enable', 'aheto' ),
	'options' => [
		'elegant'          => esc_html__( 'Elegant', 'aheto' ),
		'font-awesome'     => esc_html__( 'Font Awesome', 'aheto' ),
		'ionicons'         => esc_html__( 'Ion Icons', 'aheto' ),
		'pe-icon-7-stroke' => esc_html__( 'Stroke Icon 7', 'aheto' ),
		'themify'          => esc_html__( 'Themify Icons', 'aheto' ),
	],
	'default' => 'ionicons',
]);

$cmb->add_field([
	'id'      => '404_redirect',
	'type'    => 'select',
	'name'    => __( '<i class="fas fa-exclamation-triangle"></i> <span>404 redirect page</span>', 'aheto' ),
	'options' => Helper::choices_pages( 'page', esc_html__( 'Select page', 'aheto' )),
	'default' => '0',
	'desc'    => esc_html__( 'If you don\'t use custom 404 redirect page, it\'ll be default 404 page from your theme.Please do not use "404" in the name and slug of the page for 404 redirect', 'aheto' ),
]);

$cmb->add_field([
	'id'      => '404_redirect_slug',
	'type'    => 'switch',
	'name'    => __( '<i class="fas fa-exclamation-triangle"></i> <span>404 redirect slug</span>', 'aheto' ),
	'desc'    => esc_html__( 'Turn on to change your 404 page slug for default "404. Please do not use "404" in the name and slug of the page for 404 redirect".', 'aheto' ),
	'default' => 'off',
]);

$cmb->add_field( [
	'id'      => 'use_real_images',
	'type'    => 'switch',
	'name'    => __( '<i class="fas fa-list-alt"></i> <span>Use real Images on Template Kits</span>', 'aheto' ),
	'desc'    => esc_html__( 'Please note all our images on demo sites are only for demo purpose, downloading the images on your website is under your own risk.
By turning to this to ON, will be able to use the demo images, otherwise will load Gray Images', 'aheto' ),
	'default' => 'off',
] );

$cmb->add_field( [
	'id'      => 'replace_shortcode_name',
	'type'    => 'switch',
	'name'    => __( '<i class="fas fa-exclamation-triangle"></i> <span>Turn on to replace Template kits with new names</span>', 'aheto' ),
	'desc'    => esc_html__( 'Turn On for correct import pages/headers/footers/skins in Template Kits', 'aheto' ),
	'default' => 'on',
] );

