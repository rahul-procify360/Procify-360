<?php
/**
 * Blockquote settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

$fields = [
	[
		'id'     => 'quote',
		'type'   => 'typography',
		'name'   => __( '<i class="fas fa-align-left yellow-color"></i> Blockquote', 'aheto' ),
		'desc'   => esc_html__( 'Please, enter a values to customize the typography style for blockquote.', 'aheto' ),
		'fields' => [
			'font-size'      => false,
			'text-align'     => false,
			'text-transform' => false,
			'line-height'    => false,
			'word-spacing'   => false,
			'margin-top'     => false,
			'margin-bottom'  => false,
		],
	],
	[
		'id'     => 'author',
		'type'   => 'typography',
		'name'   => __( '<i class="fas fa-align-left yellow-color"></i> Author', 'aheto' ),
		'desc'   => esc_html__( 'Please, enter a values to customize the author typography style.', 'aheto' ),
		'fields' => [
			'text-align'     => false,
			'word-spacing'   => false,
			'margin-bottom'  => false,
		],
	]
];

$cmb->add_field([
	'id'         => 'quoutes',
	'type'       => 'group',
	'options'    => [
		'closed'      => false,
		'group_title' => esc_html__( 'Blockquote Default Styling', 'aheto' ),
	],
	'repeatable' => false,
	'fields'     => $fields,
]);

$fields_bg = $fields;

array_push($fields_bg, [
	'id'   => 'qoute_bg',
	'type' => 'colorpicker',
	'name' => esc_html__( 'Blockquote Background', 'aheto' ),
	'desc' => esc_html__( 'Please, choose color for blockquote background.', 'aheto' ),
]);

$cmb->add_field([
	'id'         => 'quoutes_bg',
	'type'       => 'group',
	'options'    => [
		'closed'      => true,
		'group_title' => esc_html__( 'Blockquote Background Styling', 'aheto' ),
	],
	'repeatable' => false,
	'fields'     => $fields_bg,
]);

$fields_border = $fields;

array_push($fields_border, [
	'id'   => 'qoute_border',
	'type' => 'colorpicker',
	'name' => esc_html__( 'Border Color', 'aheto' ),
	'desc' => esc_html__( 'Please, choose color for blockquote border.', 'aheto' ),
]);

$cmb->add_field([
	'id'         => 'quoutes_border',
	'type'       => 'group',
	'options'    => [
		'closed'      => true,
		'group_title' => esc_html__( 'Blockquote Border Styling', 'aheto' ),
	],
	'repeatable' => false,
	'fields'     => $fields_border,
]);

$fields_line = $fields;

array_push($fields_line, [
	'id'   => 'qoute_line',
	'type' => 'colorpicker',
	'name' => esc_html__( 'Line Color', 'aheto' ),
	'desc' => esc_html__( 'Please, Enter a values to customize the blockquote line.', 'aheto' ),
]);

$cmb->add_field([
	'id'         => 'quoutes_line',
	'type'       => 'group',
	'options'    => [
		'closed'      => true,
		'group_title' => esc_html__( 'Blockquote Line Styling', 'aheto' ),
	],
	'repeatable' => false,
	'fields'     => $fields_line,
]);
