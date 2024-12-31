<?php
/**
 * Custom code settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

$cmb->add_field([
	'id'      => 'custom_css',
	'type'    => 'textarea_code',
	'name'    => __( '<i class="fab fa-css3-alt"></i> <span>Custom CSS</span>', 'aheto' ),
	'desc'    => esc_html__( 'Add custom CSS code', 'aheto' ),
	'options' => array( 'disable_codemirror' => true )
]);

$cmb->add_field([
	'id'      => 'custom_js',
	'type'    => 'textarea_code',
	'name'    => __( '<i class="fab fa-js"></i> <span>Custom JS</span>', 'aheto' ),
	'desc'    => esc_html__( 'Add custom JS code', 'aheto' ),
	'options' => array( 'disable_codemirror' => true )
]);

$cmb->add_field([
	'id'      => 'custom_html',
	'type'    => 'textarea_code',
	'name'    => __( '<i class="fab fa-html5"></i> <span>Custom HTML code (for &lt;head&gt; tag )</span>', 'aheto' ),
	'desc'    => esc_html__( 'Add custom HTML code, which will be paste in &lt;head&gt; tag', 'aheto' ),
	'options' => array( 'disable_codemirror' => true )
]);

