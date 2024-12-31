<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'famulus_heading_layout1');


/**
 * Heading
 */
function famulus_heading_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Heading 5', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);
	$shortcode->add_dependecy('famulus_add_desc_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_desc_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_desc_typo', 'famulus_add_desc_use_typo', 'true');
	$shortcode->add_dependecy('famulus_subtitle', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_subtitle_tag', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_subtitle_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_subtitle_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_subtitle_typo', 'famulus_add_subtitle_use_typo', 'true');
	$shortcode->add_dependecy('famulus_link_title', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_link_url', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_link_arrow', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_white_text', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_white_add_text', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_socials_links', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_link_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_link_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_link_typo', 'famulus_add_link_use_typo', 'true');
	$shortcode->add_dependecy('famulus_soc_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_soc_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_soc_typo', 'famulus_soc_use_typo', 'true');

	aheto_demos_add_dependency(['title_animation', 'heading', 'alignment', 'source','text_tag', 'text_typo', 'use_typo', 'use_typo_hightlight', 'text_typo_hightlight', 'description' ], ['famulus_layout1'], $shortcode);

	$shortcode->add_params([
		'famulus_subtitle'          => [
			'type'    => 'text',
			'heading' => esc_html__('Subtitle', 'famulus'),
			'grid'    => 12,
		],
		'famulus_subtitle_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for Subtitle', 'famulus'),
			'options' => [
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h3'  => 'h3',
				'h4'  => 'h4',
				'h5'  => 'h5',
				'h6'  => 'h6',
				'p'   => 'p',
				'div' => 'div',
			],
			'default' => 'p',
			'grid'    => 5,
		],
		'famulus_add_subtitle_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_add_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],
		'famulus_add_desc_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_add_desc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__desc',
		],
		'famulus_add_link_use_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Link?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_add_link_typo'         => [
			'type'     => 'typography',
			'group'    => 'Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__link',
		],
		'famulus_white_text'        => [
			'type'        => 'switch',
			'heading'     => esc_html__('White Text', 'famulus'),
			'grid'        => 3,
			'description' => esc_html__('It will work if not used custom options. It will colorize all the content in the shortcode except Highlight ', 'famulus'),

		],
		'famulus_white_add_text'    => [
			'type'        => 'switch',
			'heading'     => esc_html__('White Highlight Text', 'famulus'),
			'grid'        => 3,
			'description' => esc_html__('It will work if not used custom options', 'famulus'),
		],
		'famulus_link_title'        => [
			'type'    => 'text',
			'heading' => esc_html__('Link Title', 'famulus'),
			'grid'    => 12,
		],
		'famulus_link_url'          => [
			'type'    => 'text',
			'heading' => esc_html__('Link Url', 'famulus'),
			'grid'    => 12,
		],
		'famulus_link_arrow'        => [
			'type'    => 'switch',
			'heading' => esc_html__('Add arrow to link?', 'famulus'),
			'grid'    => 3,
		],

		'famulus_socials_links' => [
			'type'    => 'group',
			'heading' => esc_html__('Choose social links', 'famulus'),
			'params'  => [
				'famulus_socials' => [
					'type'    => 'switch',
					'heading' => esc_html__('Add social links?', 'famulus'),
					'grid'    => 3,
				],
			]
		],
		'famulus_soc_use_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Socials?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_soc_typo'         => [
			'type'     => 'typography',
			'group'    => 'Socials Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__soc-link',
		],
	]);

	\Aheto\Params::add_networks_params($shortcode, [
		'prefix'     => 'famulus_soc_link',
		'dependency' => ['famulus_socials', 'true']
	], 'famulus_socials_links');


}


function famulus_heading_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_add_subtitle_use_typo']) && $shortcode->atts['famulus_add_subtitle_use_typo'] && isset($shortcode->atts['famulus_add_subtitle_typo']) && !empty($shortcode->atts['famulus_add_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['famulus_add_subtitle_typo']));
	}
	if ( isset($shortcode->atts['use_typo_hightlight']) && $shortcode->atts['use_typo_hightlight'] && isset($shortcode->atts['text_typo_hightlight']) && !empty($shortcode->atts['text_typo_hightlight']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__title span'], $shortcode->parse_typography($shortcode->atts['text_typo_hightlight']));
	}
	if ( isset($shortcode->atts['famulus_add_desc_use_typo']) && $shortcode->atts['famulus_add_desc_use_typo'] && isset($shortcode->atts['famulus_add_desc_typo']) && !empty($shortcode->atts['famulus_add_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__desc'], $shortcode->parse_typography($shortcode->atts['famulus_add_desc_typo']));
	}
	if ( isset($shortcode->atts['famulus_add_link_use_typo']) && $shortcode->atts['famulus_add_link_use_typo'] && isset($shortcode->atts['famulus_add_link_typo']) && !empty($shortcode->atts['famulus_add_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__link'], $shortcode->parse_typography($shortcode->atts['famulus_add_link_typo']));
	}
	if ( isset($shortcode->atts['famulus_soc_use_typo']) && $shortcode->atts['famulus_soc_use_typo'] && isset($shortcode->atts['famulus_soc_typo']) && !empty($shortcode->atts['famulus_soc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__soc-link'], $shortcode->parse_typography($shortcode->atts['famulus_soc_typo']));
	}
	return $css;
}

add_filter('aheto_heading_dynamic_css', 'famulus_heading_layout1_dynamic_css', 10, 2);

