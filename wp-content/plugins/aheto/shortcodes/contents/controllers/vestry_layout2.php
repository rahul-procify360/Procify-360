<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'vestry_contents_layout2');


/**
 * Contents
 */

function vestry_contents_layout2($shortcode)
{

  $preview_dir = '//assets.aheto.co/contents/previews/';

  $shortcode->add_layout('vestry_layout2', [
    'title' => esc_html__('Content 32', 'vestry'),
    'image' => $preview_dir . 'vestry_layout2.jpg',
  ]);

  aheto_demos_add_dependency(['faqs', 'first_is_opened', 'multi_active', 'title_typo', 'text_typo' ], ['vestry_layout2'], $shortcode);

  $shortcode->add_dependecy('vestry_subtitle', 'template', 'vestry_layout2');
  $shortcode->add_dependecy('vestry_subtitle_tag', 'template', 'vestry_layout2');
  $shortcode->add_dependecy('vestry_use_subtitle_typo', 'template', 'vestry_layout2');
  $shortcode->add_dependecy('vestry_subtitle_typo', 'template', 'vestry_layout2');
  $shortcode->add_dependecy('vestry_subtitle_typo', 'vestry_use_subtitle_typo', 'true');

  $shortcode->add_dependecy('vestry_title', 'template', 'vestry_layout2');
  $shortcode->add_dependecy('vestry_title_tag', 'template', 'vestry_layout2');
  $shortcode->add_dependecy('vestry_use_title_typo', 'template', 'vestry_layout2');
  $shortcode->add_dependecy('vestry_title_typo', 'template', 'vestry_layout2');
  $shortcode->add_dependecy('vestry_title_typo', 'vestry_use_title_typo', 'true');

  $shortcode->add_dependecy('vestry_video_image', 'vestry_add_video_button', 'true');
  $shortcode->add_dependecy('vestry_background', 'template', 'vestry_layout2');

  $shortcode->add_params([
    'vestry_subtitle'          => [
      'type'        => 'textarea',
      'heading'     => esc_html__('Subtitle', 'vestry'),
      'description' => esc_html__('Add some text for subtitle', 'vestry'),
      'admin_label' => true,
      'default'     => esc_html__('Add some text for subtitle', 'vestry'),
    ],
    'vestry_subtitle_tag'      => [
      'type'    => 'select',
      'heading' => esc_html__('Element tag for subtitle', 'vestry'),
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
    'vestry_use_subtitle_typo' => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for subtitle?', 'vestry'),
      'grid'    => 3,
    ],
    'vestry_subtitle_typo' => [
      'type'     => 'typography',
      'group'    => 'Vestry Subtitle Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => false,
      ],
      'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
    ],
    'vestry_title'          => [
      'type'        => 'textarea',
      'heading'     => esc_html__('Title', 'vestry'),
      'description' => esc_html__('Add some text for title', 'vestry'),
      'admin_label' => true,
      'default'     => esc_html__('Add some text for title', 'vestry'),
    ],
    'vestry_title_tag'      => [
      'type'    => 'select',
      'heading' => esc_html__('Element tag for title', 'vestry'),
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
    'vestry_use_title_typo' => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for title?', 'vestry'),
      'grid'    => 3,
    ],
    'vestry_title_typo' => [
      'type'     => 'typography',
      'group'    => 'Vestry Title Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => false,
      ],
      'selector' => '{{WRAPPER}} .aheto-heading__title',
    ],
    'vestry_video_image'      => [
      'type'    => 'attach_image',
      'heading' => esc_html__('Preview image for video', 'vestry'),
      'group'   => esc_html__('Video Content', 'vestry'),
    ],
    'vestry_content_image'      => [
      'type'    => 'attach_image',
      'heading' => esc_html__('Background image for content', 'vestry'),
      'group'   => esc_html__('Video Content', 'vestry'),
    ],
  ]);

  \Aheto\Params::add_video_button_params($shortcode, [
    'add_label'  => esc_html__('Add video?', 'vestry'),
    'prefix'     => 'vestry_',
    'group'      => esc_html__('Video Content', 'vestry'),
    'dependency' => ['template', 'vestry_layout2'],
  ]);

  \Aheto\Params::add_image_sizer_params($shortcode, [
    'prefix'     => 'vestry_',
    'dependency' => ['template', ['vestry_layout2']]
  ]);
}

function vestry_contents_layout2_dynamic_css($css, $shortcode)
{
  if (!empty($shortcode->atts['vestry_use_subtitle_typo']) && !empty($shortcode->atts['vestry_subtitle_typo'])) {
    \aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['vestry_subtitle_typo']));
  }
  if (!empty($shortcode->atts['vestry_use_title_typo']) && !empty($shortcode->atts['vestry_title_typo'])) {
    \aheto_add_props($css['global']['%1$s .aheto-heading__title'], $shortcode->parse_typography($shortcode->atts['vestry_title_typo']));
  }
  return $css;
}

add_filter('aheto_contents_dynamic_css', 'vestry_contents_layout2_dynamic_css', 10, 2);