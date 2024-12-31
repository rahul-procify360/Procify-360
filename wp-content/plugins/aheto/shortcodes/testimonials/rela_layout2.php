<?php
/**
 * The Testimonials Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$testimonials = $this->parse_group($rela_testimonials_minimal);
if (empty($testimonials)) {
    return '';
}


$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--rela-minimal');


/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 1000,
    'autoplay' => false,
    'spaces' => 30,
    'slides' => 3,
    'pagination' => true,
    'arrows' => false
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'rela_swiper_min_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('rela-testimonials-layout2', $shortcode_dir . 'assets/css/rela_layout2.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
            <div class="swiper-wrapper">
                <?php foreach ($rela_testimonials_minimal as $item) : ?>
                    <div class="swiper-slide">
                        <div class="aheto-tm aheto-tm__minimal">
                            <div class="aheto-tm__content">
                                <?php
                                // Testimonial.
                                if (!empty($item['rela_testimonial'])) {
                                    echo '<h3 class="aheto-tm__text">' . wp_kses($item['rela_testimonial'], 'post') . '</h3>';
                                }
                                ?>
                            </div>
                            <div class="aheto-tm__author">
                                <div class="aheto-tm__info">
                                    <?php
                                    // Name.
                                    if (!empty($item['rela_name'])) {
                                        echo '<h5 class="aheto-tm__name">' . wp_kses($item['rela_name'], 'post') . '</h5>';
                                    }

                                    // Company.
                                    if (!empty($item['rela_company'])) {
                                        echo '<h6 class="aheto-tm__position">' . wp_kses($item['rela_company'], 'post') . '</h6>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php $this->swiper_pagination('rela_swiper_min_'); ?>
        </div>
        <?php $this->swiper_arrow('rela_swiper_min_'); ?>
    </div>
</div>
