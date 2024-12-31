<?php

/**
 * The Testimonials Shortcode.
 */

use Aheto\Helper;

extract($atts);

$vestry_testimonials = $this->parse_group($vestry_testimonials);
if (empty($vestry_testimonials)) {
  return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--vestry-classic');

$atts['vestry_image_height'] = 70;
$atts['vestry_image_width'] = 70;
$atts['vestry_image_crop'] = true;

$carousel_params = Helper::get_carousel_params($atts, 'vestry_swiper_');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
  wp_enqueue_style('vestry-testimonials-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <div class="swiper">
    <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
      <div class="swiper-wrapper">
        <?php foreach ($vestry_testimonials as $item) : ?>
          <div class="swiper-slide">
            <div class="aheto-tm__slide-wrap">
              <div class="aheto-tm__title-wrap">
                <?php
                // Rating.
                if (isset($item['vestry_rating']) && !empty($item['vestry_rating'])) {
                  echo '<p class="aheto-tm__stars">';
                  for ($i = 1; $i <= $item['vestry_rating']; $i++) {
                    echo '<i class="ion ion-ios-star"></i>';
                  }
                  if ($item['vestry_rating'] != floor($item['vestry_rating'])) {
                    echo '<i class="ion ion ion-ios-star-half"></i>';
                  }
                  for ($i = $item['vestry_rating'] + 1; $i <= 5; $i++) {
                    echo '<i class="ion ion-ios-star-outline"></i>';
                  }
                  echo '</p>';
                }
                // Title
                if (isset($item['vestry_title']) && !empty($item['vestry_title'])) {
                  echo '<h4 class="aheto-tm__title">' . wp_kses($item['vestry_title'], 'post') . '</h4>';
                }
                ?>
              </div>
              <div class="aheto-tm__content">
                <?php
                // Testimonial.
                if (isset($item['vestry_testimonial']) && !empty($item['vestry_testimonial'])) {
                  echo '<p class="aheto-tm__text">' . wp_kses($item['vestry_testimonial'], 'post') . '</p>';
                } ?>
              </div>
              <div class="aheto-tm__author">
                <?php if ($item['vestry_image']) : $background_image = Helper::get_background_attachment($item['vestry_image'], 'custom', $atts, 'vestry_'); ?>
                  <div class="aheto-tm__avatar" <?php echo esc_attr($background_image); ?>></div>
                <?php endif; ?>
                <div class="aheto-tm__info">
                  <?php
                  // Name.
                  if (isset($item['vestry_name']) && !empty($item['vestry_name'])) {
                    echo '<h5 class="aheto-tm__name">' . wp_kses($item['vestry_name'], 'post') . '</h5>';
                  }
                  // Company.
                  if (isset($item['vestry_company']) && !empty($item['vestry_company'])) {
                    echo '<h6 class="aheto-tm__position">' . wp_kses($item['vestry_company'], 'post') . '</h6>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php $this->swiper_pagination('vestry_swiper_'); ?>
    </div>
    <?php $this->swiper_arrow('vestry_swiper_'); ?>
  </div>
</div>
