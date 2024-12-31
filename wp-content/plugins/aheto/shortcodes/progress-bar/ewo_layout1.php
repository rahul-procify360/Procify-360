<?php

/**
 * The Progress Bar Shortcode.
 */

extract($atts);
use Aheto\Helper;
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
  wp_enqueue_style( 'ewo-progress-bar-layout1', $shortcode_dir . 'assets/css/ewo_layout1.css', null, null );
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <div class="aheto-counter--ewo-number">
    <?php
    if (!empty($percentage)) {
      echo '<h2 class="aheto-counter__number js-counter">' . absint($percentage) . '</h2>';
    }
    if (!empty($description)) {
      echo '<p class="aheto-counter__desc">' . wp_kses_post($description) . '</p>';
    }
    ?>
  </div>
</div>
