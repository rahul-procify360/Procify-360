<?php

/**
 * The Testimonials Shortcode.
 */

use Aheto\Helper;

extract($atts);

$prego_testimonials = $this->parse_group($prego_testimonials);
if (empty($prego_testimonials)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm--prego-simple');


$carousel_params = Helper::get_carousel_params($atts, 'prego_tm_swiper_');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('prego-testimonials-layout2', $shortcode_dir . 'assets/css/prego_layout2.css', null, '');
} ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>
             data-slides="3" data-slides_md="3" data-slides_sm="2" data-slides_xs="1" data-spaces="30">
            <div class="swiper-wrapper">
                <?php foreach ($prego_testimonials as $item) : ?>
                    <div class="swiper-slide">
                        <div class="aheto-tm__author">
                            <?php if ($item['prego_image']) : $background_image = Helper::get_background_attachment($item['prego_image'], 'thumbnail', $atts); ?>
                                <div class="aheto-tm__avatar" <?php echo esc_attr($background_image); ?>></div>
                            <?php endif; ?>
                        </div>
                        <div class="aheto-tm__content">
                            <?php if (isset($item['prego_name']) && !empty($item['prego_name'])) {
                                echo '<h4 class="aheto-tm__name">' . wp_kses($item['prego_name'], 'post') . '</h4>';
                            }
                            if (isset($item['prego_testimonial']) && !empty($item['prego_testimonial'])) {
                                echo '<p class="aheto-tm__text">' . wp_kses($item['prego_testimonial'], 'post') . '</p>';
                            } ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
