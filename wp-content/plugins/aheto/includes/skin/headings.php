<?php
/**
 * Heading settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

$heading_fields = [
	'font-family'    => false,
	'font-weight'    => false,
	'color'          => false,
	'text-align'     => false,
	'text-transform' => false,
	'word-spacing'   => false,
	'margin-top'     => false,
	'margin-bottom'  => false,
	'color_hover'  => false,
];

$cmb->add_field([
	'id'     => 'headings',
	'type'   => 'typography',
	'name'   => esc_html__( 'Heading', 'aheto' ),
	'desc'   => esc_html__( 'Please, enter values to customize your Heading (general options for all headings).', 'aheto' ),
	'fields' => [
		'font-size'      => false,
		'text-align'     => false,
		'text-transform' => false,
		'line-height'    => false,
		'word-spacing'   => false,
		'margin-top'     => false,
		'margin-bottom'  => false,
		'color_hover'  => false,
	],
]);

$cmb->add_field([
	'id'         => 'heading1',
	'type'       => 'typography',
	'name'       => esc_html__( 'Heading 1', 'aheto' ),
	'desc'       => esc_html__( 'Please, enter values to customize your Heading 1.', 'aheto' ),
	'fields'     => $heading_fields,
	'responsive' => true,
]);

$cmb->add_field([
	'id'         => 'heading2',
	'type'       => 'typography',
	'name'       => esc_html__( 'Heading 2', 'aheto' ),
	'desc'       => esc_html__( 'Please, enter values to customize your Heading 2.', 'aheto' ),
	'fields'     => $heading_fields,
	'responsive' => true,
]);

$cmb->add_field([
	'id'         => 'heading3',
	'type'       => 'typography',
	'name'       => esc_html__( 'Heading 3', 'aheto' ),
	'desc'       => esc_html__( 'Please, enter values to customize your Heading 3.', 'aheto' ),
	'fields'     => $heading_fields,
	'responsive' => true,
]);

$cmb->add_field([
	'id'         => 'heading4',
	'type'       => 'typography',
	'name'       => esc_html__( 'Heading 4', 'aheto' ),
	'desc'       => esc_html__( 'Please, enter values to customize your Heading 4.', 'aheto' ),
	'fields'     => $heading_fields,
	'responsive' => true,
]);

$cmb->add_field([
	'id'         => 'heading5',
	'type'       => 'typography',
	'name'       => esc_html__( 'Heading 5', 'aheto' ),
	'desc'       => esc_html__( 'Please, enter values to customize your Heading 5.', 'aheto' ),
	'fields'     => $heading_fields,
	'responsive' => true,
]);

$cmb->add_field([
	'id'         => 'heading6',
	'type'       => 'typography',
	'name'       => esc_html__( 'Heading 6', 'aheto' ),
	'desc'       => esc_html__( 'Please, enter values to customize your Heading 6.', 'aheto' ),
	'fields'     => $heading_fields,
	'responsive' => true,
]);
