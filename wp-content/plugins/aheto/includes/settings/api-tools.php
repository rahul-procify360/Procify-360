<?php
/**
 * API Tools Settings settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

$cmb->add_field([
	'id'      => 'google_api_key',
	'type'    => 'text',
	'name'    => __( '<i class="fas fa-map-marker-alt"></i> <span>Google API Key</span>', 'aheto' ),
	'desc'    => esc_html__( 'Add google API key', 'aheto' ),
]);

$cmb->add_field([
	'id'      => 'google_api_style',
	'type'    => 'textarea',
	'name'    => __( '<i class="fas fa-map-marked-alt"></i> <span>Google API Style</span>', 'aheto' ),
	'desc'    => esc_html__( 'Add google map style from snazzymaps.com', 'aheto' ),
]);

