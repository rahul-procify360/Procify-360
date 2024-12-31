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

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--acacio-classic');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('acacio-testimonials-layout2', $shortcode_dir . 'assets/css/acacio_layout2.css', null, null);

}


?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto-tm__slide-wrap">

        <div class="aheto-tm__content">
            <?php
            // Testimonial.
            if ( isset($acacio_testimonials_text) && !empty($acacio_testimonials_text) ) {
                echo '<h4 class="aheto-tm__text">' . wp_kses_post($acacio_testimonials_text) . '</h4>';
            } ?>
        </div>

        <div class="aheto-tm__author">

            <?php if ( isset($acacio_testimonials_image) && !empty($acacio_testimonials_image) ) : ?>
                <?php
                    $acacio_avatar =  \Aheto\Helper::get_background_attachment( $acacio_testimonials_image, $acacio_image_size, $atts, 'acacio_' );
                ?>
                <div class="aheto-tm__avatar" <?php echo esc_attr($acacio_avatar); ?>></div>
            <?php endif; ?>

            <div class="aheto-tm__info">
                <?php
                // Name.
                if ( isset($acacio_testimonials_name) && !empty($acacio_testimonials_name) ) {
                    echo '<h5 class="aheto-tm__name">' . wp_kses_post($acacio_testimonials_name) . '</h5>';
                }

                // Company.
                if ( isset($acacio_testimonials_company) && !empty($acacio_testimonials_company)) {
                    echo '<p class="aheto-tm__position">' . wp_kses_post($acacio_testimonials_company) . '</p>';
                }
                ?>
            </div>

        </div>

    </div>

</div>
