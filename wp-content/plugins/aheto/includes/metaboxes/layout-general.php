<?php
/**
 * Layout metabox settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;


$skins = [ '' => esc_html__( 'Default Skin', 'aheto' ) ] + Helper::skins();
$cmb->add_field([
	'id'      => 'aheto_skin_layout',
	'type'    => 'select',
	'name'    => esc_html__( 'Skin', 'aheto' ),
	'options' => $skins,
	'desc'    => esc_html__( 'Please, choose your default skin.', 'aheto' ),
]);


$header_path = Helper::get_settings( 'general.theme_header' );

if( !isset($header_path) || !$header_path ){
	$option_header = Helper::get_settings( 'general.header' );
	$default_header = isset($option_header['image_select']) && !empty($option_header['image_select']) ? $option_header['image_select'] : 0;
	$headers = [ $default_header => esc_html__( 'Default Header', 'aheto' ) ] + Helper::choices_posts_by_type( 'aheto-header', esc_html__( 'No Header', 'aheto' ) );
	$cmb->add_field([
		'id'      => 'aheto_header_layout',
		'type'    => 'select',
		'name'    => esc_html__( 'Header', 'aheto' ),
		'options' => $headers,
		'desc'    => esc_html__( 'Please, choose your default header.', 'aheto' ),
	]);
}


$footer_path = Helper::get_settings( 'general.theme_footer' );

if( !isset($footer_path) || !$footer_path ) {

	$option_footer  = Helper::get_settings( 'general.footer' );
	$default_footer = isset( $option_footer['image_select'] ) && ! empty( $option_footer['image_select'] ) ? $option_footer['image_select'] : 0;
	$footers        = [ $default_footer => esc_html__( 'Default Footer', 'aheto' ) ] + Helper::choices_posts_by_type( 'aheto-footer', esc_html__( 'No Footer', 'aheto' ) );
	$cmb->add_field( [
		'id'      => 'aheto_footer_layout',
		'type'    => 'select',
		'name'    => esc_html__( 'Footer', 'aheto' ),
		'options' => $footers,
		'desc'    => esc_html__( 'Please, choose your default footer.', 'aheto' ),
	] );
}