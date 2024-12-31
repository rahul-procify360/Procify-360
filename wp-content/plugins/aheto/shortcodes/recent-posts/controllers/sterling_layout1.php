<?php

use Aheto\Helper;

add_action('aheto_before_aheto_recent-posts_register', 'sterling_recent_posts_layout1');

/**
 * Recent posts
 */

function sterling_recent_posts_layout1($shortcode)
{
	$dir = '//assets.aheto.co/recent-posts/previews/';

	$shortcode->add_layout('sterling_layout1', [
		'title' => esc_html__('Sterling recent post', 'sterling'),
		'image' => $dir . 'sterling_layout1.jpg',
	]);

	aheto_demos_add_dependency('post_type', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('limit', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('post_title_typo', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('hovercolor', ['sterling_layout1'], $shortcode);
	$shortcode->add_dependecy('sterling_use_date_typo', 'template', ['sterling_layout1']);
	$shortcode->add_dependecy('sterling_date_typo', 'sterling_use_date_typo', 'true');

	$shortcode->add_params([
		'sterling_use_date_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for date?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_date_typo' => [
			'type'     => 'typography',
			'group'    => 'Navigation date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .post-date',
		],
	]);
}

function sterling_recent_posts_layout1_dynamic_css($css)
{
	if (!empty($shortcode->atts['sterling_date_typo'])) {
		\aheto_add_props($css['global']['%1$s .post-date'], $shortcode->parse_typography($shortcode->atts['sterling_date_typo']));
	}

	if (!empty($shortcode->atts['post_title_typo'])) {
		\aheto_add_props($css['global']['%1$s .post-title'], $shortcode->parse_typography($shortcode->atts['post_title_typo']));
	}

	if (!empty($shortcode->atts['hovercolor'])) {
		$css['global']['%1$s ul li a:hover']['color'] = Sanitize::color($shortcode->atts['hovercolor']);
	}
	return apply_filters("aheto_recent_posts_dynamic_css", $css, $shortcode);
}