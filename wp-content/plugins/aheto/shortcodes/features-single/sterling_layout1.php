<?php

/**
 * The Features Shortcode.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 't-center');
$this->add_render_attribute('wrapper', 'class', 'aheto-features--sterling-1');

/**
 * Set dependent style
 */

$sc_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-features-single-layout1', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
$background_image = Helper::get_background_attachment($s_image, $image_size, $atts);
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <div class="aheto-features-block__image-box">
    <?php if (!empty($s_image)) : ?>
      <div class="aheto-features-block__image" <?php echo esc_attr($background_image); ?>></div>
    <?php endif; ?>
  </div>
  <?php if (!empty($s_heading)) : ?>
    <h4 class="aheto-content-block__title">
      <?php echo esc_html($s_heading); ?>
    </h4>
  <?php endif; ?>
  <?php if (!empty($s_description)) : ?>
    <p class="aheto-content-block__info-text">
      <?php echo esc_html($s_description); ?>
    </p>
  <?php endif; ?>
  <?php if (!empty($sterling_main_add_button)) { ?>
    <div class="aheto--custom-links">
      <?php echo Helper::get_button($this, $atts, 'sterling_main_'); ?>
    </div>
  <?php } ?>
</div>
