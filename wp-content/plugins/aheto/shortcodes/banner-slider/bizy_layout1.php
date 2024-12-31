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

$banners = $this->parse_group($bizy_modern_banners);

if ( empty($banners) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--bizy-modern');

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'  => 1000,
	'arrows' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'bizy_swiper_banner_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('bizy-banner-slider-layout1', $shortcode_dir . 'assets/css/bizy_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $banners as $banner ) :
					$banner = wp_parse_args($banner, [
						'bizy_image'         => '',
						'bizy_title'         => '',
						'bizy_desc'          => '',
						'bizy_align'         => '',
						'bizy_btn_direction' => '',
						'bizy_heading_tag'   => '',
					]);
					extract($banner);

					$swiper_lazy_class = $bizy_swiper_banner_lazy ? ' swiper-lazy' : '';
					$background_image  = Helper::get_background_attachment($bizy_image, 'full', $atts, '', $bizy_swiper_banner_lazy);

					if ( empty($bizy_image) ) {
						continue;
					} ?>
					<div class="swiper-slide">
						<div class="aheto-banner-slider-wrap aheto-full-min-height-js <?php echo esc_attr($bizy_align . $swiper_lazy_class); ?>" <?php echo esc_attr($background_image); ?>>

							<div class="aheto-banner-slider__content">
								<?php

								if (  !empty($bizy_subtitle) ) { ?>
									<p class="aheto-banner-slider__subtitle">
										<?php echo wp_kses_post($bizy_subtitle); ?>
									</p>
								<?php }

								if ( !empty($bizy_title) ) { ?>
									<h1 class="aheto-banner__title">
										<?php
										$bizy_title = str_replace(']]', '</span>', $bizy_title);
										$bizy_title = str_replace('[[', '<span>', $bizy_title);

										echo wp_kses_post($bizy_title); ?>
									</h1>
								<?php }

								if (  !empty($bizy_desc) ) { ?>
									<h5 class="aheto-banner-slider__desc"><?php echo wp_kses_post($bizy_desc); ?></h5>
								<?php }

								if ( $bizy_main_add_button == true || $bizy_add_add_button == true ) { ?>
									<div class="aheto-banner-slider__links">
										<?php
										echo Helper::get_button($this, $banner, 'bizy_main_');
										echo wp_kses_post($bizy_btn_direction ? '<br>' : '');
										echo Helper::get_button($this, $banner, 'bizy_add_'); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $this->swiper_pagination('bizy_swiper_banner_'); ?>
		</div>
		<?php $this->swiper_arrow('bizy_swiper_banner_'); ?>
	</div>
</div>
