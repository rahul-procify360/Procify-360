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

$banners = $this->parse_group($rela_modern_banners);

if (empty($banners)) {
    return '';
}

if (!$rela_swiper_custom_options) {
    $speed = 1000;
    $effect = 'fade';
    $loop = false;
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--rela-modern');

/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 1000,
];

$carousel_params = Helper::get_carousel_params($atts, 'rela_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('rela-banner-slider-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('rela-banner-slider-layout1-js', $shortcode_dir . 'assets/js/rela_layout1.min.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
            <div class="swiper-wrapper">
                <?php foreach ($banners as $banner) :
                    $banner = wp_parse_args($banner, [
                        'rela_image' => '',
                        'rela_add_image' => '',
                        'rela_title' => '',
                        'title_tag' => '',
                        'rela_desc' => '',
                        'rela_align' => '',
                        'rela_btn_direction' => ''
                    ]);
                    extract($banner);

                    if (!$rela_image) {
                        continue;
                    }
                    $swiper_lazy_class = $rela_swiper_lazy ? ' swiper-lazy' : '';
                    $background_image = Helper::get_background_attachment($rela_image, 'full', $atts, '', $rela_swiper_lazy);
                    ?>
                    <div class="swiper-slide">
                        <div class="swiper-slide-overlay"></div>
                        <div class="aheto-banner-slider-wrap rela-full-min-height-js <?php echo esc_attr($rela_align . $swiper_lazy_class); ?>" <?php echo esc_attr($background_image); ?>>
                            <div class="aheto-banner-slider__content">
                                <?php if ($rela_add_image) { ?>
                                    <?php echo Helper::get_attachment($rela_add_image, ['class' => 'aheto-banner-slider__add-image'], $rela_add_image_size, $atts, 'rela_add_'); ?>
                                <?php }

                                if (!empty($rela_title)) { ?>
                                    <<?php echo esc_attr($title_tag); ?> class="aheto-banner__title"><?php echo wp_kses($rela_title, 'post'); ?></<?php echo esc_attr($title_tag); ?>>
                                <?php }

                                if (!empty($rela_desc)) { ?>
                                    <p class="aheto-banner-slider__desc"><?php echo wp_kses($rela_desc, 'post'); ?></p>
                                <?php }

                                if ($rela_main_add_button || $rela_add_add_button) { ?>
                                    <div class="aheto-banner-slider__links">
                                        <?php
                                        echo Helper::get_button($this, $banner, 'rela_main_');

                                        if ($rela_btn_direction) { ?>
                                            <br>
                                        <?php }

                                        echo Helper::get_button($this, $banner, 'rela_add_'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php $this->swiper_pagination('rela_swiper_'); ?>
        </div>
        <?php $this->swiper_arrow('rela_swiper_'); ?>
    </div>
</div>

