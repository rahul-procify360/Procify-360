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



$banners = $this->parse_group($aira_modern_banners);

if ( empty($banners) ) {
	return '';
}

$left_arrows_position = isset($aira_arrrows_position) && $aira_arrrows_position ? 'arrows_left' : '';
$dark_arrows = isset($aira_dark_arrows) && $aira_dark_arrows ? 'dark_arrows' : '';

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', $left_arrows_position);
$this->add_render_attribute('wrapper', 'class', $dark_arrows);
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--aira-modern');

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
];

$carousel_params = Helper::get_carousel_params($atts, 'aira_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-banner-slider-modern', $sc_dir . 'assets/css/aira_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
            <div class="swiper-wrapper">
                <?php foreach ($banners as $banner) :
                    $banner = wp_parse_args($banner, [
                        'aira_image' => '',
                        'aira_add_image' => '',
                        'aira_title' => '',
                        'aira_desc' => '',
                        'btn_direction' => ''
                    ]);
                    extract($banner);

                    if (!$aira_image) {
                        continue;
                    }
                    $swiper_lazy_class = $aira_swiper_lazy ? ' swiper-lazy' : '';
                    $background_image = Helper::get_background_attachment($aira_image, 'full', $atts, '', $aira_swiper_lazy);
                    ?>
                    <div class="swiper-slide">
                        <div class="swiper-slide-overlay"></div>
                        <div class="aheto-banner-slider-wrap aheto-full-min-height-js <?php echo esc_attr($aira_align . $swiper_lazy_class); ?>" <?php echo esc_attr($background_image); ?>>
                            <div class="aheto-banner-slider__content">
	                            <?php if (is_array($aira_add_image) && !empty($aira_add_image[0]) || !is_array($aira_add_image) && $aira_add_image){

	                                if ($aira_swiper_lazy) :
		                                echo Helper::get_attachment_for_swiper($aira_add_image, ['class' => 'aheto-banner-slider__add-image swiper-lazy']);
                                    else :
                                        echo Helper::get_attachment($aira_add_image, ['class' => 'aheto-banner-slider__add-image'], $aira_add_image_size, $atts, 'aira_add_');
                                    endif;
	                            }

                                if (!empty($aira_title)) {
                                    $aira_title = str_replace(']]', '</span>', $aira_title);
                                    $aira_title = str_replace('[[', '<span>', $aira_title);
                                ?>
                                    <h2 class="aheto-banner__title"><?php echo wp_kses($aira_title, 'post'); ?></h2>
                                <?php }

                                if (!empty($aira_desc)) { ?>
                                    <p class="aheto-banner-slider__desc"><?php echo esc_html($aira_desc); ?></p>
                                <?php }

                                if ($aira_main_add_button || $aira_add_add_button) { ?>
                                    <div class="aheto-banner-slider__links">
                                        <?php
                                        echo Helper::get_button($this, $banner, 'aira_main_');

                                        if ($aira_btn_direction) { ?>
                                            <br>
                                        <?php }

                                        echo Helper::get_button($this, $banner, 'aira_add_'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php $this->swiper_arrow('aira_swiper_'); ?>
    </div>
</div>

