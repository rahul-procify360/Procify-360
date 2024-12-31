<?php
	/**
	 * Oders settings.
	 *
	 * @since      1.0.0
	 * @package    Aheto
	 * @subpackage Aheto
	 * @author     UPQODE <info@upqode.com>
	 */



	$cmb->add_field([
		'id'   => 'widget_title_border',
		'type' => 'border',
		'name' => esc_html__( 'Widget Title Border', 'aheto' ),
		'desc' => esc_html__( 'Please, enter values to customize your Title Border.', 'aheto' ),
	]);


	$cmb->add_field([
		'id'   => 'widget_title_padding',
		'type' => 'spacing',
		'name' => esc_html__( 'Widget Title Padding', 'aheto' ),
		'desc' => esc_html__( 'Please, enter values to customize your Title Padding.', 'aheto' ),
	]);

	$cmb->add_field( array(
		'name'         => 'Content Width',
		'id'           => 'content_width',
		'type'         => 'text',
	) );

	$cmb->add_field( array(
		'name'         => 'Tablet Breakpoint',
		'id'           => 'tablet_breakpoint',
		'type'         => 'text',
	) );

	$cmb->add_field( array(
		'name'         => 'Mobile Breakpoint',
		'id'           => 'mobile_breakpoint',
		'type'         => 'text',
	) );

