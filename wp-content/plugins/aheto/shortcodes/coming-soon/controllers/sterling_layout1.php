<?php

use Aheto\Helper;

add_action('aheto_before_aheto_coming-soon_register', 'sterling_coming_soon_layout1');

/**
 *  Coming soon
 */

function sterling_coming_soon_layout1($shortcode)
{
  $dir = '//assets.aheto.co/coming-soon/previews/';
  $shortcode->add_layout('sterling_layout1', [
    'title' => esc_html__('Sterling Simple', 'sterling'),
    'image' => $dir . 'sterling_layout1.jpg',
  ]);

	aheto_demos_add_dependency('days_desktop', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('days_mobile', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('hours_desktop', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('hours_mobile', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('mins_desktop', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('mins_mobile', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('secs_desktop', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('secs_mobile', ['sterling_layout1'], $shortcode);

	aheto_demos_add_dependency('use_typo_numbers', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('typo_numbers', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('use_typo_caption', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('typo_caption', ['sterling_layout1'], $shortcode);


  $shortcode->add_dependecy('sterling_time_out', 'template', 'sterling_layout1');
  $shortcode->add_dependecy('sterling_use_dots_typo', 'template', 'sterling_layout1');
  $shortcode->add_dependecy('sterling_dots_typo', 'template', 'sterling_layout1');
  $shortcode->add_dependecy('sterling_dots_typo', 'sterling_use_dots_typo', 'true');

  $shortcode->add_params([
    'sterling_time_out' => [
			'type'    => 'date_time',
			'heading' => esc_html__('Time', 'sterling'),
			'grid'    => 6,
			'default' => esc_html__('2021-10-18 15:51', 'sterling'),
		],
    'sterling_use_dots_typo' => [
      'type' => 'switch',
      'heading' => esc_html__('Use custom font for dots?', 'sterling'),
      'grid' => 12,
      'default' => '',
    ],

    'sterling_dots_typo' => [
      'type' => 'typography',
      'group' => 'Dots Typography',
      'settings' => [
        'text_align' => false,
        'tag'        => false,
      ],
      'selector' => '{{WRAPPER}} .aheto-coming-soon__dots',
    ],
  ]);
}

function sterling_coming_soon_layout1_dynamic_css($css, $shortcode)
{
  if (!empty($shortcode->atts['sterling_use_dots_typo']) && !empty($shortcode->atts['sterling_dots_typo'])) {
    \aheto_add_props($css['global']['%1$s .aheto-coming-soon__dots'], $shortcode->parse_typography($shortcode->atts['sterling_dots_typo']));
  }
  return $css;
}