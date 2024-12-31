<?php

use Aheto\Helper;

add_action('aheto_before_aheto_recent-posts_register', 'famulus_recent_posts_layout1');
/**
 * Progress Bar Shortcode
 */

function famulus_recent_posts_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/recent-posts/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Recent Posts 1', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);

	aheto_demos_add_dependency('limit', ['famulus_layout1'], $shortcode);

}
