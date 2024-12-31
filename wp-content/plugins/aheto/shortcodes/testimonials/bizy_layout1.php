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

extract( $atts );

$bizy_testimonials = $this->parse_group( $bizy_testimonials );
if ( empty( $bizy_testimonials ) ) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-tm-wrapper--bizy-modern' );

/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed'    => 1000,
    'autoplay' => false,
    'spaces'   => 30,
    'slides'   => 3,
    'arrows'   => true
]; // will use when not chosen option 'Change slider params'

$carousel_params             = Helper::get_carousel_params( $atts, 'bizy_swiper_', $carousel_default_params );
$atts['bizy_image_height'] = 63;
$atts['bizy_image_width']  = 63;
$atts['bizy_image_crop']   = true;

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'bizy-testimonials-layout1', $shortcode_dir . 'assets/css/bizy_layout1.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">

        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>

            <div class="swiper-wrapper">

                <?php foreach ( $bizy_testimonials as $item ) : ?>

                    <div class="swiper-slide">

                        <div class="aheto-tm__slide-wrap">

                            <div class="aheto-tm__content">
                                <?php
                                // Testimonial.
                                if ( isset( $item['bizy_testimonial'] ) && ! empty( $item['bizy_testimonial'] ) ) {
                                    echo '<p class="aheto-tm__text">' . wp_kses( $item['bizy_testimonial'], 'post' ) . '</p>';
                                } ?>
                                <div class="aheto-tm__author">

                                    <?php


                                    if ( ! empty( $item['bizy_image'] ) ) :

                                        $background_image = Helper::get_background_attachment( $item['bizy_image'], 'custom', $atts, 'bizy_' ); ?>

                                        <div class="aheto-tm__avatar" <?php echo esc_attr( $background_image ); ?>></div>
                                    <?php endif; ?>

                                    <div class="aheto-tm__info">
                                        <?php
                                        // Name.
                                        if ( isset( $item['bizy_name'] ) && ! empty( $item['bizy_name'] ) ) {
                                            echo '<h4 class="aheto-tm__name">' . wp_kses( $item['bizy_name'], 'post' ) . '</h4>';
                                        }

                                        // Company.
                                        if ( isset( $item['bizy_company'] ) && ! empty( $item['bizy_company'] ) ) {
                                            echo '<h6 class="aheto-tm__position">' . wp_kses( $item['bizy_company'], 'post' ) . '</h6>';
                                        } ?>
                                    </div>

                                </div>
                                <div class="aheto-tm__quote">"</div>
                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>
        <?php $this->swiper_arrow( 'bizy_swiper_' ); ?>
        <div class="swiper-hr"></div>
    </div>

</div>
