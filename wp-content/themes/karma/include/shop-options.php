<?php
/**
 * General settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     KARMA <info@karma.com>
 */

$cmb->add_field([
	'id'      => 'karma_shop_image',
	'type'    => 'file',
	'name'    => __( '<i class="fas fa-image green-color"></i> <span>Banner image</span>', 'aheto' ),
	'desc'    => esc_html__( 'This options only for shop pages', 'aheto' ),
]);