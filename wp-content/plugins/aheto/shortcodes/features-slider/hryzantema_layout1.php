<?php
/**
 * The HR Consult Features Slider Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$hr_features_slider = $this->parse_group($hr_features_slider);

if ( empty($hr_features_slider) ) {
	return '';
}

if ( !$hryzantema_custom_options ) {
    $speed  = 1000;
    $effect = 'slide';
    $loop   = true;
}

$this->generate_css();

$hryzantema_hide_pagination = isset($hryzantema_hide_pagination) && $hryzantema_hide_pagination ? 'hide-pagination' : '';
// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-features-slider--hr-modern' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', $hryzantema_hide_pagination );


/**
 * Set carousel params
 */
$carousel_default_params = [
    'arrows' => true,
    'speed' => 1000,
    'simulate_touch' => true,
    'loop' => true

]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'hryzantema_', $carousel_default_params);

/**
 * Highlight Text
 *
 * @param  string  $text Text to highlight.
 * @param  boolean $type TYpe.
 * @return string
 */
function hryzantema_highlight_text( $text, $type = false ) {
    $text = str_replace( ']]', '</span>', $text );
    $text = str_replace( '[[', $type ? '<span class="js-typed">' : '<span>', $text );

    return wp_kses_post( $text );
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-slider/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-features-slider-layout1', $shortcode_dir . 'assets/css/hryzantema_layout1.css', null, null);
}?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>

            <div class="swiper-wrapper">
                <?php foreach ( $hr_features_slider as $hr_feature ) :
                    $hr_feature = wp_parse_args($hr_feature, [
                        'hryzantema_image'         => '',
                        'hryzantema_title'         => '',
                        'hryzantema_desc'          => '',
                        'align'         => '',
                        'btn_direction' => '',
                        'hryzantema_main_add_button' => '',
                        'hryzantema_add_add_button' => '',
                    ]);

                    extract($hr_feature);

                    $wrap_bg = Helper::get_background_attachment($hryzantema_bg_image, 'full');
                    $slide_bg = Helper::get_background_attachment($hryzantema_image, 'full');

                    if ( !isset($hryzantema_image) || empty($hryzantema_image) ) {
                        continue;
                    } ?>
                    <div class="swiper-slide">
                        <div class="aheto-features-slider-wrap <?php echo esc_attr($align); ?>">

                            <div class="aheto-features-slider-image-wrap" <?php echo esc_attr($wrap_bg); ?>></div>

                            <div class="aheto-features-slider__img" <?php echo esc_attr($slide_bg); ?>></div>

                            <div class="aheto-features-slider__content">
                                <?php
                                if ( !empty($hryzantema_title) ) { ?>
                                    <h2 class="aheto-features-slider__title">
                                        <?php echo hryzantema_highlight_text($hryzantema_title) ?>

                                    </h2>
                                <?php }

                                if ( !empty($hryzantema_desc) ) { ?>
                                    <p class="aheto-features-slider__info-text"><?php echo wp_kses_post($hryzantema_desc); ?></p>
                                <?php } ?>


                                <?php if ( $hryzantema_main_add_button == true || $hryzantema_add_add_button == true ) { ?>
                                    <div class="aheto-features-slider__links">
                                        <?php
                                        echo Helper::get_button($this, $hr_feature, 'hryzantema_main_');
                                        echo wp_kses_post($btn_direction ? '<br>' : '');
                                        echo Helper::get_button($this, $hr_feature, 'hryzantema_add_'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php $this->swiper_pagination('hryzantema_'); ?>
        </div>
        <?php $this->swiper_arrow('hryzantema_'); ?>
    </div>

</div>
