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

$banners = $this->parse_group($hr_modern_banners);

if ( empty($banners) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--hr-modern');

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'  => 1000,
	'arrows' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'hryzantema_swiper_banner_', $carousel_default_params);

/**
 * Highlight Text
 *
 * @param  string $text Text to highlight.
 * @param  boolean $type TYpe.
 * @return string
 */
function hryzantema_highlight_slider_text($text, $type = false) {
	$text = str_replace(']]', '</span>', $text);
	$text = str_replace('[[', $type ? '<span class="js-typed">' : '<span>', $text);

	return wp_kses_post($text);
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';;

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-banner-slider-layout1', $shortcode_dir . 'assets/css/hryzantema_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $banners as $banner ) :
					$banner = wp_parse_args($banner, [
						'hryzantema_image'         => '',
						'hryzantema_title'         => '',
						'hryzantema_desc'          => '',
						'hryzantema_align'         => '',
						'hryzantema_btn_direction' => '',
						'hryzantema_heading_tag'   => '',
					]);
					extract($banner);

					$swiper_lazy_class = $hryzantema_swiper_banner_lazy ? ' swiper-lazy' : '';
					$background_image  = Helper::get_background_attachment($hryzantema_image, 'full', $atts, '', $hryzantema_swiper_banner_lazy);

					if ( empty($hryzantema_image) ) {
						continue;
					} ?>
					<div class="swiper-slide">
						<div class="aheto-banner-slider-wrap aheto-full-min-height-js <?php echo esc_attr($hryzantema_align . $swiper_lazy_class); ?>" <?php echo esc_attr($background_image); ?>>

							<div class="aheto-banner-slider__content">
								<?php

								if (  !empty($hryzantema_subtitle) ) { ?>
									<p class="aheto-banner-slider__subtitle">
										<?php echo wp_kses_post($hryzantema_subtitle); ?>
									</p>
								<?php }

								if ( !empty($hryzantema_title) ) { ?>
									<h1 class="aheto-banner__title">
										<?php echo hryzantema_highlight_slider_text($hryzantema_title) ?>
									</h1>
								<?php }

								if (  !empty($hryzantema_desc) ) { ?>
									<h5 class="aheto-banner-slider__desc"><?php echo wp_kses_post($hryzantema_desc); ?></h5>
								<?php }

								if ( $hryzantema_main_add_button == true || $hryzantema_add_add_button == true ) { ?>
									<div class="aheto-banner-slider__links">
										<?php
										echo Helper::get_button($this, $banner, 'hryzantema_main_');
										echo wp_kses_post($hryzantema_btn_direction ? '<br>' : '');
										echo Helper::get_button($this, $banner, 'hryzantema_add_'); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $this->swiper_pagination('hryzantema_swiper_banner_'); ?>
		</div>
		<?php $this->swiper_arrow('hryzantema_swiper_banner_'); ?>
	</div>
</div>
