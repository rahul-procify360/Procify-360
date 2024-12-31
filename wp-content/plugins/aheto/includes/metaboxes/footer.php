<?php
/**
 * Footer metabox settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

$cmb->add_field([
	'id'   => 'aheto_footer_css_classes',
	'type' => 'text',
	'name' => esc_html__( 'CSS Classes', 'aheto' ),
	'desc' => esc_html__( 'You can add your footer custom classes here.', 'aheto' ),
]);

$cmb->add_field([
	'id'      => 'aheto_footer_text_color',
	'type'    => 'colorpicker',
	'name'    => esc_html__( 'Text Color', 'aheto' ),
	'options' => [ 'alpha' => true ],
	'desc'    => esc_html__( 'You can add your footer text color here.', 'aheto' ),
]);

$cmb->add_field([
	'id'      => 'aheto_footer_link_color',
	'type'    => 'colorpicker',
	'name'    => esc_html__( 'Link Color', 'aheto' ),
	'options' => [ 'alpha' => true ],
	'desc'    => esc_html__( 'You can add your footer link color here.', 'aheto' ),
]);

$cmb->add_field([
	'id'   => 'aheto_footer_padding',
	'type' => 'spacing',
	'name' => esc_html__( 'Padding', 'aheto' ),
	'desc' => esc_html__( 'You can add your footer padding here.', 'aheto' ),
]);

$cmb->add_field([
	'id'   => 'aheto_footer_background',
	'type' => 'background',
	'name' => esc_html__( 'Background', 'aheto' ),
	'desc' => esc_html__( 'You can add your footer background color here.', 'aheto' ),
]);
