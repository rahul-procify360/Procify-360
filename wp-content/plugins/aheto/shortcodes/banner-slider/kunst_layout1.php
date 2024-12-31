<?php

/**
 * The Banner Slider Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Kunst <info@kunst.com>
 */

use Aheto\Helper;

extract($atts);

$banners = $this->parse_group($kunst_creative_banners);

if ( empty($banners) ) {
    return '';
}

if ( !$kunst_swiper_custom_options ) {
    $speed  = 1000;
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-banner-slider--kunst__creative' );

/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'kunst_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';

$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'kunst-banner-slider-layout1', $shortcode_dir . 'assets/css/kunst_layout1.css', null, null );
}

$add_styles = !empty($kunst_height) && !empty($kunst_height_size) ? 'style=min-height:' . $kunst_height . $kunst_height_size : '';

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="swiper">
        <?php
            if ( $kunst_banner_line_decoration == 'true' ) {
        ?>
            <div class="swiper-line-decoration"></div>
        <?php } ?>
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?> <?php echo esc_attr($add_styles); ?>>
            <div class="swiper-wrapper" <?php echo esc_attr($add_styles); ?>>
                <?php foreach ( $banners as $banner ) :
                    $banner = wp_parse_args($banner, [
                        'kunst_image'           => '',
                        'kunst_add_image'       => '',
                        'kunst_button_align'    => '',
                        'kunst_button_size'     => ''
                    ]);

                    extract($banner);

                    if ( !$kunst_image ) {
                        continue;
                    }

                    $swiper_lazy_class = $kunst_swiper_lazy ? ' swiper-lazy' : '';
                    $background_image = Helper::get_background_attachment($kunst_image, 'full', $atts, '', $kunst_swiper_lazy);
                ?>
                    <div class="swiper-slide">
                        <div class="aheto-banner-slider-wrap <?php echo esc_attr($swiper_lazy_class); ?>" <?php echo esc_attr($background_image); ?>>
                            <div class="swiper-slide-overlay"></div>
                            <?php
                                if ( !empty( $kunst_add_image['url'] ) ) {
                            ?>
                                <div class="aheto-banner-slider__content t-<?php echo esc_attr($kunst_align_add_image); ?>">
                                    <?php if ( !empty( $kunst_add_image ) ) { ?>
                                        <?php echo Helper::get_attachment($kunst_add_image, ['class' => 'aheto-banner-slider__add-image'], $kunst_image_size, $atts, 'kunst_'); ?>
                                    <?php } ?>

                                    <?php if ( !empty( $kunst_banner_text ) ) { ?>
                                        <?php
                                            echo '<h6 class="aheto-banner-slider__text">' . esc_html( $kunst_banner_text ) . '</h6>';
                                        ?>
                                    <?php } ?>

                                    <?php if ( $kunst_creative_main_add_button ) { ?>
                                        <div class="aheto-banner-slider__links <?php echo esc_attr( $kunst_button_align . ' ' . $kunst_button_size );?>">
                                            <?php
                                                echo Helper::get_button($this, $banner, 'kunst_creative_main_');
                                            ?>
                                        </div>
                                    <?php } ?>

                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ( !empty( $this->atts[ 'kunst_swiper_pagination' ] ) ) {
                $pag_reverse = $kunst_reverse != '' ? "kunst-swiper-cnt--pagination-reverse" : '';
                ?>
                <div class="kunst-swiper-cnt--pagination <?php echo esc_attr($pag_reverse); ?> ">
                    <?php $this->swiper_pagination('kunst_swiper_'); ?>
                </div>
            <?php } ?>
        </div>
        <?php if ( !empty( $this->atts[ 'kunst_swiper_arrows' ] ) ) {
            $arrow_pag = $kunst_reverse != '' ? "kunst-swiper-cnt--arrow-reverse" : ''; ?>
            <div class="kunst-swiper-cnt--arrow <?php echo esc_attr($arrow_pag); ?> ">
                <?php $this->swiper_arrow('kunst_swiper_'); ?>
            </div>
        <?php } ?>
    </div>
</div>
