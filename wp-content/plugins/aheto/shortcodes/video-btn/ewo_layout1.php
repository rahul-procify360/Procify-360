<?php

/**
 * The Button Shortcode.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $this->atts['element_id']);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/video-btn/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
  wp_enqueue_style('ewo-video-btn-layout1', $shortcode_dir . 'assets/css/ewo_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <div class="aheto-video-container--ewo <?php echo esc_attr($this->atts['align']); ?>">
    <?php if (!empty($ewo_video_image)) : ?>
      <div class="aheto-video-container__image">
        <?php echo Helper::get_attachment($ewo_video_image, ['class' => 'js-bg']); ?>
        <?php echo Helper::get_video_button($atts); ?>
      </div>
    <?php endif; ?>
  </div>
</div>
