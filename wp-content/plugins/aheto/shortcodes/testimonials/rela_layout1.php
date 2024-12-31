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

$testimonials = $this->parse_group($rela_testimonials);
if (empty($testimonials)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--rela-modern');

$dark_version = isset($dark_version) && $dark_version ? 'dark-version' : '';
$this->add_render_attribute('wrapper', 'class', $dark_version);

// Swiper.
if (!$custom_options) {
    $speed = 500;
    $space = 30;
    $slides = 3;
    $large = 3;
    $medium = 2;
    $small = 1;
}

/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 1000,
    'autoplay' => false,
    'spaces' => 30,
    'slides' => 3,
    'arrows' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'rela_swiper_', $carousel_default_params);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('rela-testimonials-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('rela-testimonials-layout1-js', $shortcode_dir . 'assets/js/rela_layout1.min.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <?php if (!empty($rela_bg_text)) { ?>
        <div class="aheto-tm__bg-text"><?php echo esc_html($rela_bg_text); ?></div>
    <?php } ?>

    <div class="swiper">

        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?> >

            <div class="swiper-wrapper">

                <?php foreach ($rela_testimonials as $item) : ?>

                    <div class="swiper-slide">

                        <div class="aheto-tm__slide-wrap">

                            <div class="aheto-tm__content">
                                <?php
                                // Testimonial.
                                if (!empty($item['rela_testimonial'])) {
                                    echo '<h4 class="aheto-tm__text">' . wp_kses($item['rela_testimonial'], 'post') . '</h4>';
                                } ?>
                            </div>

                            <div class="aheto-tm__author">
                                <?php if (!empty($item['rela_image'])) : ?>
                                    <?php
                                    $background_image = Helper::get_background_attachment($item['rela_image'], $rela_image_size, $atts, 'rela_');
                                    ?>
                                    <div class="aheto-tm__avatar" <?php echo esc_attr($background_image) ?>>
                                    </div>
                                <?php endif; ?>

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

        </div>

    </div>

</div>
