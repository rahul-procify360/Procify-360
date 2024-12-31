<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'soapy_heading_layout1');


/**
 * Heading
 */
function soapy_heading_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Heading 19', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);

	aheto_demos_add_dependency(['use_typo', 'text_typo'], ['soapy_layout1'], $shortcode);

	$shortcode->add_dependecy('soapy_link', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_link_title', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_link_title', 'soapy_link', 'true');
	$shortcode->add_dependecy('soapy_link_url', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_link_url', 'soapy_link', 'true');
	$shortcode->add_dependecy('soapy_add_subtitle_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_add_subtitle_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_add_subtitle_typo', 'soapy_add_subtitle_use_typo', 'true');
	$shortcode->add_dependecy('soapy_add_desc_use_typo', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_add_desc_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_add_desc_typo', 'soapy_add_desc_use_typo', 'true');
	$shortcode->add_dependecy('soapy_subtitle', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_subtitle_space', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_title', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_title_tag', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_use_title_space', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_title_space', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_title_space', 'soapy_use_title_space', 'true');
	$shortcode->add_dependecy('soapy_desc', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_i_left', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_i_right', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_align', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_remove_arrow', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_add_link_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_add_link_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_add_link_typo', 'soapy_add_link_use_typo', 'true');
	$shortcode->add_params([
		'soapy_subtitle'        => [
			'type'    => 'text',
			'heading' => esc_html__('Subtitle', 'soapy'),
			'grid'    => 12,
		],
		'soapy_subtitle_space'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Remove Space Under Subtitle?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_i_left'          => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image Before Subtitle', 'soapy'),
		],
		'soapy_i_right'         => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image After Subtitle', 'soapy'),
		],
		'soapy_title'           => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'soapy'),
			'grid'    => 12,
		],
		'soapy_title_tag'       => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for Title', 'soapy'),
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
			'default' => 'h2',
			'grid'    => 5,
		],
		'soapy_use_title_space' => [
			'type'    => 'switch',
			'heading' => esc_html__('Change space under the title?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_title_space'     => [
			'type'        => 'text',
			'heading'     => esc_html__('Space Title', 'soapy'),
			'grid'        => 12,
			'description' => esc_html__('Write only the number (value will be in px)', 'soapy'),

		],
		'soapy_desc'            => [
			'type'    => 'textarea',
			'heading' => esc_html__('Description', 'soapy'),
			'grid'    => 12,
		],

		'soapy_link'              => [
			'type'    => 'switch',
			'heading' => esc_html__('Add Link?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_link_title'        => [
			'type'    => 'text',
			'heading' => esc_html__('Link Title', 'soapy'),
			'grid'    => 3,
		],
		'soapy_link_url'          => [
			'type'    => 'link',
			'heading' => esc_html__('Link URL', 'soapy'),
			'grid'    => 3,
		],
		'soapy_add_desc_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_add_desc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__desc',
		],

		'soapy_add_subtitle_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_add_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],

		'soapy_align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'soapy'),
			'options' => \Aheto\Helper::choices_alignment(),
		],

		'soapy_add_link_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Link?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_add_link_typo'     => [
			'type'     => 'typography',
			'group'    => 'Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__link',
		],
		'soapy_remove_arrow' => [
			'type'    => 'switch',
			'heading' => esc_html__('Remove Arrow?', 'soapy'),
			'grid'    => 3,
		],
	]);
}


function soapy_heading_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['soapy_add_link_use_typo']) && $shortcode->atts['soapy_add_link_use_typo'] && isset($shortcode->atts['soapy_add_link_typo']) && !empty($shortcode->atts['soapy_add_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__link'], $shortcode->parse_typography($shortcode->atts['soapy_add_link_typo']));
	}
	if ( isset($shortcode->atts['soapy_add_subtitle_use_typo']) && $shortcode->atts['soapy_add_subtitle_use_typo'] && isset($shortcode->atts['soapy_add_subtitle_typo']) && !empty($shortcode->atts['soapy_add_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['soapy_add_subtitle_typo']));
	}
	if ( isset($shortcode->atts['soapy_add_desc_use_typo']) && $shortcode->atts['soapy_add_desc_use_typo'] && isset($shortcode->atts['soapy_add_desc_typo'])  && !empty($shortcode->atts['soapy_add_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__desc'], $shortcode->parse_typography($shortcode->atts['soapy_add_desc_typo']));
	}

	return $css;
}

add_filter('aheto_heading_dynamic_css', 'soapy_heading_layout1_dynamic_css', 10, 2);

