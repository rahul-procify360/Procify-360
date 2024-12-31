<?php

/**
 * Sterling Media Shortcode.
 */

use Aheto\Helper;

extract($atts);

if (!is_array($sterling_image)) {
  $sterling_image = explode(',', $sterling_image);
}

if (empty($sterling_image)) {
  return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-media--sterling1');

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-media-gallery', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <?php foreach ($sterling_image as $item) : ?>
    <div class="item">
      <?php echo Helper::get_attachment($item, [], $sterling_image_size, $atts, 'sterling_'); ?>
    </div>
  <?php endforeach; ?>
</div>
