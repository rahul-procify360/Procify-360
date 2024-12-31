<?php
/**
 * The Banner Slider Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if ( empty($prego_images) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--prego');

$carousel_default_params = [
    'speed'     => 500,
]; // will use when not chosen option 'Change slider params'



$carousel_params = Helper::get_carousel_params( $atts, 'prego_swiper_', $carousel_default_params );

/**
 * Set dependent style
 */

$sc_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('prego-banner-slider-layout1', $sc_dir . 'assets/css/prego_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('prego-banner-slider-layout1-js', $sc_dir . 'assets/js/prego_layout1.min.js', array('jquery'), null, true);
} ?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto-banner-slider__content">
        <?php if(!empty($prego_main_subtitle)){ ?>
           <div class="aheto-banner-slider__subtitle">
               <?php echo esc_html($prego_main_subtitle); ?>
           </div>
        <?php } ?>
        <?php if(!empty($prego_main_title)){ ?>
            <div class="aheto-banner-slider__title">
                <?php echo esc_html($prego_main_title); ?>
            </div>
        <?php }

        if ( $prego_add_button ) { ?>
            <div class="aheto-banner-slider__btn">
                <?php echo Helper::get_button( $this, $atts, 'prego_' ); ?>
            </div>
        <?php } ?>
    </div>

    <div class="aheto-banner-slider__slider">
        <?php if(is_array($prego_images) && count($prego_images)){ ?>
            <div class="swiper">
                <div class="swiper-container swiper-pagination--numeric" data-spaces="15" data-slides="auto" data-loop="1" <?php echo esc_attr( $carousel_params ); ?>>
                    <div class="swiper-wrapper">
                        <?php foreach ($prego_images as $image){ ?>
                            <div class="swiper-slide">
                                <div class="aheto-banner-slider__item" style="background-image: url(<?php echo wp_get_attachment_image_url($image['id'], 'large'); ?>);"></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php $this->swiper_pagination('prego_swiper_'); ?>
                <?php
                if (!empty($this->atts['prego_swiper_arrows'])) { ?>
                    <div class="swiper-buttons">
                        <span class="swiper-button-prev"><?php esc_html_e('PREV', 'prego'); ?></span>
                        <span> | </span>
                        <span class="swiper-button-next"><?php esc_html_e('NEXT', 'prego'); ?></span>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

</div>
