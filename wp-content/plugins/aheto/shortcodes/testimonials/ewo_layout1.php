<?php

/**
 * The Testimonials Shortcode.
 */

use Aheto\Helper;

extract($atts);

$ewo_testimonials_creative_item = $this->parse_group($ewo_testimonials_creative_item);
if (empty($ewo_testimonials_creative_item)) {
  return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--ewo');

$carousel_params = Helper::get_carousel_params($atts, 'ewo_swiper_');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
  wp_enqueue_style( 'ewo-testimonials-layout1', $shortcode_dir . 'assets/css/ewo_layout1.css', null, null );
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <div class="swiper">
    <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
      <div class="swiper-wrapper">
        <?php foreach ($ewo_testimonials_creative_item as $item) : ?>
          <div class="swiper-slide">
            <div class="aheto-tm aheto-tm__modern">
              <div class="aheto-tm__content">
                <?php
                if (isset($item['ewo_testimonial']) && !empty($item['ewo_testimonial'])) {
                  echo '<p class="aheto-tm__text">' . esc_html($item['ewo_testimonial']) . '</p>';
                } ?>
              </div>
              <div class="aheto-tm__author">
                <?php if ($item['ewo_image']) : ?>
                  <div class="aheto-tm__avatar">
                    <?php echo Helper::get_attachment($item['ewo_image'], [], $ewo_image_size, $atts, 'ewo_'); ?>
                  </div>
                <?php endif; ?>
                <div class="aheto-tm__info">
                  <?php
                  if (isset($item['ewo_name']) && !empty($item['ewo_name'])) {
                    echo '<h6 class="aheto-tm__name">' . esc_html($item['ewo_name']) . '</h6>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php $this->swiper_pagination('ewo_swiper_'); ?>
    </div>
  </div>
</div>
