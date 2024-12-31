<?php

/**
 * Banner Slider Shortcode.
 *
 */

use Aheto\Helper;

extract($atts);

$banners = $this->parse_group($sterling_modern_banners);

if (empty($banners)) {
	return '';
}

if (!$sterling_swiper_custom_options) {
	$speed  = 1500;
	$effect = 'slide';
	$loop   = false;
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--sterling');


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1500,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'sterling_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-banner-slider-layout1', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container sterling--swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ($banners as $banner) :
					$banner = wp_parse_args($banner, [
						'sterling_image'         => '',
						'sterling_add_image'     => '',
						'sterling_overlay_color' => '',
						'sterling_overlay'       => '',
						'sterling_title'         => '',
						'sterling_desc'          => '',
						'align'            => '',
						'sterling_banner_theme'  => '',
					]);
					extract($banner);

					$sterling_overlay = isset($sterling_overlay) && !empty($sterling_overlay) ? 'overlay-on' : '';

					if (!$sterling_image) {
						continue;
					} ?>
					<div class="swiper-slide">
						<div class="aheto-banner-slider-wrap <?php echo esc_attr($align . ' ' . $sterling_overlay); ?>">
							<?php if (!empty($sterling_image)) :
								if ($sterling_swiper_lazy) :
									echo Helper::get_attachment_for_swiper($sterling_image, ['class' => 'js-bg-swiper swiper-lazy']);
								else :
									echo Helper::get_attachment($sterling_image, ['class' => 'js-bg']);
								endif;
							endif; ?>

							<?php if ($sterling_overlay == true) : ?>
								<span class="aheto-banner-slider__overlay" style="background-color: <?php echo esc_attr($sterling_overlay_color); ?>;"></span>
							<?php endif; ?>

							<div class="aheto-banner-slider__content">
								<?php if ($sterling_add_image) { ?>
									<?php echo Helper::get_attachment($sterling_add_image,  ['class' => 'aheto-banner-slider__add-image']); ?>
								<?php }

								if (!empty($sterling_sub_title)) { ?>
									<p class="aheto-banner-slider__sub-title"><?php echo esc_html($sterling_sub_title); ?></p>
								<?php }

								if (!empty($sterling_title)) { ?>
									<h2 class="aheto-banner-slider__title aheto-banner__title"><?php echo wp_kses($sterling_title, 'post'); ?></h2>
								<?php }

								if (!empty($sterling_video_add_video_button)) {
									echo \Aheto\Helper::get_video_button($banner, 'sterling_video_');
								}

								if (!empty($sterling_desc)) { ?>
									<p class="aheto-banner-slider__descr"><?php echo wp_kses($sterling_desc, 'post'); ?></p>
								<?php }

								if (!empty($sterling_main_add_button) || !empty($sterling_add_add_button)) { ?>
									<div class="aheto-banner-slider__links">
										<?php echo Helper::get_button($this, $banner, 'sterling_main_'); ?>
										<br>
										<?php echo Helper::get_button($this, $banner, 'sterling_add_'); ?>
									</div>
								<?php }
								?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
