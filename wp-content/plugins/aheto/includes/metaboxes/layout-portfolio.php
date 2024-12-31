<?php

use Aheto\Helper;


$cmb->add_field([
	'id'      => 'aheto_external_link',
	'type'    => 'text',
	'name'    => esc_html__( 'External Link', 'aheto' ),
	'desc'    => esc_html__( 'You can add external link for post here.', 'aheto' ),
]);

$cmb->add_field([
	'id'         => 'aheto_cpt_width',
	'type'       => 'radio_inline',
	'name'       => esc_html__( 'Double Width', 'aheto' ),
	'desc'       => esc_html__( 'You can enable/disable double width for post.', 'aheto' ),
	'default'    => 'off',
	'options'    => [
		'off' => esc_html__( 'Off', 'aheto' ),
		'on'  => esc_html__( 'On', 'aheto' ),
	],
]);

$cmb->add_field([
	'id'         => 'aheto_cpt_height',
	'type'       => 'radio_inline',
	'name'       => esc_html__( 'Double Height', 'aheto' ),
	'desc'       => esc_html__( 'You can enable/disable double height for post.', 'aheto' ),
	'default'    => 'off',
	'options'    => [
		'off' => esc_html__( 'Off', 'aheto' ),
		'on'  => esc_html__( 'On', 'aheto' ),
	],
]);
