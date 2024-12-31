<?php
/**
 * The Acacio Features Slider Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$acacio_features_slider = $this->parse_group($acacio_features_slider);

if ( empty($acacio_features_slider) ) {
	return '';
}

if ( !$acacio_custom_options ) {
    $speed  = 1000;
    $effect = 'slide';
    $loop   = true;
}

$this->generate_css();

$acacio_hide_pagination = isset($acacio_hide_pagination) && $acacio_hide_pagination ? 'hide-pagination' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-features-slider--acacio-modern' );
$this->add_render_attribute( 'wrapper', 'class', $acacio_hide_pagination );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set carousel params
 */
$carousel_default_params = [
    'arrows' => true,
    'speed' => 1000,
    'simulate_touch' => true,
    'loop' => true

]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'acacio_', $carousel_default_params);



/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-slider/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'acacio-features-slider-layout1', $shortcode_dir . 'assets/css/acacio_layout1.css', null, null );
}


?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-features-slider-add-image">
        <?php echo \Aheto\Helper::get_attachment( $acacio_add_image, ['class' => ''], $acacio_image_size, $atts, 'acacio_' ); ?>
    </div>
    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>

            <div class="swiper-wrapper">
                <?php foreach ( $acacio_features_slider as $acacio_feature ) :
                    $acacio_feature = wp_parse_args($acacio_feature, [
                        'acacio_image'         => '',
                        'acacio_add_image'  => '',
                        'title'         => '',
                        'desc'          => '',
                        'align'         => '',
                        'btn_direction' => '',
                        'main_add_button' => ''
                    ]);

                    extract($acacio_feature);

                    $wrap_bg = Helper::get_background_attachment($acacio_bg_image, 'full');
                    $slide_bg = Helper::get_background_attachment($acacio_image, 'full');

                    if ( !isset($acacio_image) && empty($acacio_image) ) {
                        continue;
                    } ?>
                    <div class="swiper-slide">
                        <div class="aheto-features-slider-wrap">

                            <div class="aheto-features-slider-image-wrap" <?php echo esc_attr($wrap_bg); ?>></div>

                            <div class="aheto-features-slider__img" <?php echo esc_attr($slide_bg); ?>></div>

                            <div class="aheto-features-slider__content">
                                <?php
                                if (isset($acacio_title) && !empty($acacio_title)  ) { ?>
                                    <h2 class="aheto-features-slider__title">
                                        <?php echo wp_kses_post($acacio_title) ?>
                                    </h2>
                                <?php }

                                if (isset($acacio_desc) && !empty($acacio_desc) ) { ?>
                                    <p class="aheto-features-slider__info-text"><?php echo wp_kses_post($acacio_desc); ?></p>
                                <?php } ?>


                                <?php if ( $acacio_button_add_button ) { ?>
                                    <div class="aheto-features-slider__links">
                                        <?php echo \Aheto\Helper::get_button($this, $acacio_feature, 'acacio_button_'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
            <?php $this->swiper_pagination('acacio_'); ?>
        </div>
        <?php $this->swiper_arrow('acacio_'); ?>
    </div>

</div>
