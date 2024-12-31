<?php
/**
 * Header metabox settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

$cmb->add_field([
	'id'   => 'aheto_header_css_classes',
	'type' => 'text',
	'name' => esc_html__('CSS Classes', 'aheto'),
	'desc' => esc_html__('You can add your custom class here.', 'aheto'),
]);

$cmb->add_field([
	'id'      => 'aheto_header_position',
	'type'    => 'select',
	'options' => [
		''                       => esc_html__('Static', 'aheto'),
		'aheto-header--absolute' => esc_html__('Absolute', 'aheto'),
		'aheto-header--fixed' => esc_html__('Fixed', 'aheto'),
	],
	'name'    => esc_html__('Header position', 'aheto'),
	'desc'    => esc_html__('Please choose your header position.', 'aheto'),
]);
return;
$cmb->add_field([
	'id'      => 'aheto_header_primary_color',
	'type'    => 'colorpicker',
	'name'    => esc_html__('Primary Color', 'aheto'),
	'options' => ['alpha' => true],
	'desc'    => esc_html__('Please add your primary color.', 'aheto'),
]);

$cmb->add_field([
	'id'      => 'aheto_header_secondary_color',
	'type'    => 'colorpicker',
	'name'    => esc_html__('Secondary Color', 'aheto'),
	'options' => ['alpha' => true],
	'desc'    => esc_html__('Please add your secondary color.', 'aheto'),
]);

$cmb->add_field([
	'id'      => 'aheto_header_active_color',
	'type'    => 'colorpicker',
	'name'    => esc_html__('Active Color', 'aheto'),
	'options' => ['alpha' => true],
	'desc'    => esc_html__('Please add your active color.', 'aheto'),
]);

$cmb->add_field([
	'id'   => 'aheto_header_menu_item_spacing',
	'type' => 'spacing',
	'name' => esc_html__('Menu Item Spacing', 'aheto'),
	'desc' => esc_html__('You can add menu item spacing here.', 'aheto'),
]);

$cmb->add_field([
	'id'   => 'aheto_header_logo_spacing',
	'type' => 'spacing',
	'name' => esc_html__('Logo Spacing', 'aheto'),
	'desc' => esc_html__('You can add logo spacing here.', 'aheto'),
]);
