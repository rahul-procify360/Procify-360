<?php

/**
 * About default templates.
 */

use Aheto\Helper;

extract($atts);
$atts['layout'] = 'slider';

// Query.
$the_query = $this->get_wp_query();
if (!$the_query->have_posts()) {
  return;
}

$skin = isset($skin) && !empty($skin) ? $skin : 'sterling_skin-1';

// Wrapper.
$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'sterling-cpt--slider');


$carousel_params = Helper::get_carousel_params($atts, 'sterling_swiper_');


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-custom-post-types', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <div class="swiper">
    <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
      <div class="swiper-wrapper">
        <?php
          while ($the_query->have_posts()) :
            $the_query->the_post();
          ?>
          <div class="swiper-slide">
            <?php $this->get_skin_part($skin, $atts); ?>
          </div>
        <?php
        endwhile;
        ?>
      </div>
      <?php $this->swiper_pagination('sterling_swiper_'); ?>
    </div>
    <?php $this->swiper_arrow('sterling_swiper_'); ?>
  </div>
</div>
