<?php

/**
 * CPT Slider LAYOUT
 */

use Aheto\Helper;

extract($atts);
$atts['layout'] = 'slider';

// Query.
$the_query = $this->get_wp_query();
if (!$the_query->have_posts()) {
  return;
}

$skin = isset($skin) && !empty($skin) ? $skin : 'vestry_skin-4';
$vestry_use_arrow_top  = isset($vestry_use_arrow_top) && $vestry_use_arrow_top  ? 'arrow-top' : '';
$vestry_use_square  = isset($vestry_use_square) && $vestry_use_square  ? 'square-img' : '';

// Wrapper.
$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt' );
$this->add_render_attribute('wrapper', 'class', 'aheto-cpt--vestry-shop');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', $vestry_use_arrow_top);
$this->add_render_attribute('wrapper', 'class', $vestry_use_square);

/**
 * Set carousel params
 */

$carousel_default_params = [
  'speed'     => 1500,
  'slides'    => 4,
  'slides_md' => 2,
  'slides_xs' => 1,
  'spaces'     => 30
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'vestry_swiper_', $carousel_default_params);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
  wp_enqueue_style('vestry-custom-post-types-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <div class="swiper">

    <div class="swiper-top">
      <?php if (!empty($vestry_subtitle)) : ?>
        <p class="aheto-features__subtitle">
          <?php echo esc_html($vestry_subtitle); ?>
        </p>
      <?php endif;
      if (!empty($vestry_title)) : ?>
        <h2 class="aheto-features__title">
          <?php echo esc_html($vestry_title); ?>
        </h2>
      <?php endif; ?>
      <?php $this->swiper_arrow('vestry_swiper_'); ?>
    </div>

    <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
      <div class="swiper-wrapper">
        <?php
        $this->add_excerpt_filter();
        while ($the_query->have_posts()) :
          $the_query->the_post();
        ?>
          <div class="swiper-slide">
            <?php $this->get_skin_part($skin, $atts); ?>
          </div>
        <?php
        endwhile;
        $this->remove_excerpt_filter();
        wp_reset_postdata();
        ?>
      </div>
      <?php $this->swiper_pagination('vestry_swiper_'); ?>
    </div>
    <?php $this->swiper_arrow('vestry_swiper_'); ?>
  </div>
</div>
