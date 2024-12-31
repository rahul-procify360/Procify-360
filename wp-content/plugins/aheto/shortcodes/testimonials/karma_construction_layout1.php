<?php

/**
 * The Testimonials Shortcode.
 */

use Aheto\Helper;

extract($atts);

$karma_construction_testimonials = $this->parse_group($karma_construction_testimonials);
if (empty($karma_construction_testimonials)) {
  return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--karma-construction-classic');

$atts['karma_construction_image_height'] = 70;
$atts['karma_construction_image_width'] = 70;
$atts['karma_construction_image_crop'] = true;

$carousel_params = Helper::get_carousel_params($atts, 'karma_construction_swiper_');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
  wp_enqueue_style('karma_construction-testimonials-layout1', $shortcode_dir . 'assets/css/karma_construction_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <div class="swiper">
    <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
      <div class="swiper-wrapper">
        <?php foreach ($karma_construction_testimonials as $item) : ?>
          <div class="swiper-slide">
            <div class="aheto-tm__slide-wrap">
              <div class="aheto-tm__title-wrap">
                <?php
                // Rating.
                if (isset($item['karma_construction_rating']) && !empty($item['karma_construction_rating'])) {
                  echo '<p class="aheto-tm__stars">';
                  for ($i = 1; $i <= $item['karma_construction_rating']; $i++) {
                    echo '<i class="ion ion-ios-star"></i>';
                  }
                  if ($item['karma_construction_rating'] != floor($item['karma_construction_rating'])) {
                    echo '<i class="ion ion ion-ios-star-half"></i>';
                  }
                  for ($i = $item['karma_construction_rating'] + 1; $i <= 5; $i++) {
                    echo '<i class="ion ion-ios-star-outline"></i>';
                  }
                  echo '</p>';
                }
                ?>
              </div>
              <div class="aheto-tm__content">
                <?php
                // Testimonial.
                if (isset($item['karma_construction_testimonial']) && !empty($item['karma_construction_testimonial'])) {
                  echo '<p class="aheto-tm__text">' . wp_kses($item['karma_construction_testimonial'], 'post') . '</p>';
                } ?>
              </div>
              <div class="aheto-tm__author">
                <?php if ($item['karma_construction_image']) : $background_image = Helper::get_background_attachment($item['karma_construction_image'], 'custom', $atts, 'karma_construction_'); ?>
                  <div class="aheto-tm__avatar" <?php echo esc_attr($background_image); ?>></div>
                <?php endif; ?>
                <div class="aheto-tm__info">
                  <?php
                  // Name.
                  if (isset($item['karma_construction_name']) && !empty($item['karma_construction_name'])) {
                    echo '<h5 class="aheto-tm__name">' . wp_kses($item['karma_construction_name'], 'post') . '</h5>';
                  }
                  // Company.
                  if (isset($item['karma_construction_company']) && !empty($item['karma_construction_company'])) {
                    echo '<h6 class="aheto-tm__position">' . wp_kses($item['karma_construction_company'], 'post') . '</h6>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php $this->swiper_pagination('karma_construction_swiper_'); ?>
    </div>
    <?php $this->swiper_arrow('karma_construction_swiper_'); ?>
  </div>
</div>
