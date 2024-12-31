<?php

/**
 * The Testimonials Shortcode.
 */

use Aheto\Helper;

extract($atts);

$sterling_testimonials = $this->parse_group($sterling_testimonials);
if (empty($sterling_testimonials)) {
  return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--sterling');

$atts['sterling_image_height'] = 70;
$atts['sterling_image_width'] = 70;
$atts['sterling_image_crop'] = true;

$carousel_params = Helper::get_carousel_params($atts, 'sterling_swiper_');


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-testimonials-layout1', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <div class="swiper">
    <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
      <div class="swiper-wrapper">
        <?php foreach ($sterling_testimonials as $item) : ?>
          <div class="swiper-slide">
            <div class="aheto-tm__slide-wrap">
              <div class="aheto-tm__title-wrap">
                <?php
                // Rating.
                if (isset($item['sterling_rating'])) {
                  echo '<p class="aheto-tm__stars">';
                  for ($i = 1; $i <= $item['sterling_rating']; $i++) {
                    echo '<i class="ion ion-ios-star"></i>';
                  }
                  if ($item['sterling_rating'] != floor($item['sterling_rating'])) {
                    echo '<i class="ion ion ion-ios-star-half"></i>';
                  }
                  for ($i = $item['sterling_rating'] + 1; $i <= 5; $i++) {
                    echo '<i class="ion ion-ios-star-outline"></i>';
                  }
                  echo '</p>';
                }
                // Title
                if (isset($item['sterling_title'])) {
                  echo '<h4 class="aheto-tm__title">' . wp_kses($item['sterling_title'], 'post') . '</h4>';
                }
                ?>
              </div>
              <div class="aheto-tm__content">
                <?php
                // Testimonial.
                if (isset($item['sterling_testimonial']) && !empty($item['sterling_testimonial'])) {
                  echo '<p class="aheto-tm__text">' . wp_kses($item['sterling_testimonial'], 'post') . '</p>';
                } ?>
              </div>
              <div class="aheto-tm__author">
                <?php if ($item['sterling_image']) : $background_image = Helper::get_background_attachment($item['sterling_image'], 'custom', $atts, 'sterling_'); ?>
                  <div class="aheto-tm__avatar" <?php echo esc_attr($background_image); ?>></div>
                <?php endif; ?>
                <div class="aheto-tm__info">
                  <?php
                  // Name.
                  if (isset($item['sterling_name']) && !empty($item['sterling_name'])) {
                    echo '<h5 class="aheto-tm__name">' . wp_kses($item['sterling_name'], 'post') . '</h5>';
                  }
                  // Company.
                  if (isset($item['sterling_company']) && !empty($item['sterling_company'])) {
                    echo '<h6 class="aheto-tm__position">' . wp_kses($item['sterling_company'], 'post') . '</h6>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php $this->swiper_pagination('sterling_swiper_'); ?>
    </div>
    <?php $this->swiper_arrow('sterling_swiper_'); ?>
  </div>
</div>
