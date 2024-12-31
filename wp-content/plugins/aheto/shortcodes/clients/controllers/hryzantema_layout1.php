<?php

use Aheto\Helper;

add_action('aheto_before_aheto_clients_register', 'hryzantema_clients_layout1');

/**
 * HR Consult Coming Soon
 */

function hryzantema_clients_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/clients/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Clients 3', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );
	aheto_demos_add_dependency(['clients', 'item_per_row', 'hover_style'], ['hryzantema_layout1'], $shortcode);
}
