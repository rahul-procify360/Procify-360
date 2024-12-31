<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'sterling_custom_post_types_layout1');

/**
 * Contents Shortcode
 */

function sterling_custom_post_types_layout1($shortcode)
{

  $theme_dir = '//assets.aheto.co/custom-post-types/previews/';

  $shortcode->add_layout('sterling_layout1', [
    'title' => esc_html__('Sterling Slider', 'sterling'),
    'image' => $theme_dir . 'sterling_layout1.jpg',
  ]);

	aheto_demos_add_dependency('skin', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('image_height', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('use_heading', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('t_heading', ['sterling_layout1'], $shortcode);

  \Aheto\Params::add_carousel_params($shortcode, [
    'custom_options' => true,
    'prefix'         => 'sterling_swiper_',
    'include'        => ['arrows', 'arrows_color', 'arrows_size', 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch'],
    'dependency'     => ['template', ['sterling_layout1']]
  ]);
}

function sterling_cpt_layout1_dynamic_css($css, $shortcode)
{
  if (!empty($shortcode->atts['sterling_swiper_arrows_color'])) {
    $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['sterling_swiper_arrows_color']);
  }
  if (!empty($shortcode->atts['sterling_swiper_arrows_size'])) {
    $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size($shortcode->atts['sterling_swiper_arrows_size']);
  }
  return $css;
}
add_filter('aheto_cpt_dynamic_css', 'sterling_cpt_layout1_dynamic_css', 10, 2);
