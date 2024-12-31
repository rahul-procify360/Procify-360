<?php

/**
 * Vestry Banner Slider Shortcode.
 */

use Aheto\Helper;

extract($atts);

$banners = $this->parse_group($vestry_modern_banners);

if (empty($banners)) {
	return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--vestry-modern');

$carousel_params = Helper::get_carousel_params($atts, 'vestry_swiper_');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('vestry-banner-slider-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container vestry--swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ($banners as $banner) :
					$banner = wp_parse_args($banner, [
						'vestry_image'         => '',
						'vestry_add_image'     => '',
						'vestry_overlay_color' => '',
						'vestry_overlay'       => '',
						'vestry_title'         => '',
						'vestry_desc'          => '',
						'vestry_banner_theme'  => '',
					]);
					extract($banner);

					$vestry_overlay = isset($vestry_overlay) && !empty($vestry_overlay) ? 'overlay-on' : '';

					if (!$vestry_image) {
						continue;
					} ?>
					<div class="swiper-slide">
						<div class="aheto-banner-slider-wrap vestry-full-min-height-js <?php echo esc_attr(' ' . $vestry_overlay); ?>">
							<?php if (!empty($vestry_image)) :
								if ($vestry_swiper_lazy) :
									echo Helper::get_attachment_for_swiper($vestry_image, ['class' => 'js-bg-swiper swiper-lazy']);
								else :
									echo Helper::get_attachment($vestry_image, ['class' => 'js-bg']);
								endif;
							endif; ?>

							<?php if ($vestry_overlay) : ?>
								<span class="aheto-banner-slider__overlay" style="background-color: <?php echo esc_attr($vestry_overlay_color); ?>;"></span>
							<?php endif; ?>

							<div class="aheto-banner-slider__content">
								<?php if ($vestry_add_image) { ?>
									<?php echo Helper::get_attachment($vestry_add_image,  ['class' => 'aheto-banner-slider__add-image']); ?>
								<?php }

								if (!empty($vestry_video_add_video_button)) {
									echo \Aheto\Helper::get_video_button($banner, 'vestry_video_');
								}

								if (!empty($vestry_sub_title)) { ?>
									<p class="aheto-banner-slider__sub-title"><?php echo esc_html($vestry_sub_title); ?></p>
								<?php }

								if (!empty($vestry_title)) { ?>
									<h2 class="aheto-banner-slider__title aheto-banner__title"><?php echo wp_kses($vestry_title, 'post'); ?></h2>
								<?php }

								if (!empty($vestry_desc)) { ?>
									<p class="aheto-banner-slider__descr"><?php echo esc_html($vestry_desc); ?></p>
								<?php }

								if (!empty($vestry_main_add_button) || !empty($vestry_add_add_button)) { ?>
									<div class="aheto-banner-slider__links">
										<?php echo Helper::get_button($this, $banner, 'vestry_main_'); ?>
										<br>
										<?php echo Helper::get_button($this, $banner, 'vestry_add_'); ?>
									</div>
								<?php }
								?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $this->swiper_pagination('vestry_swiper_'); ?>
		</div>
	</div>
</div>
