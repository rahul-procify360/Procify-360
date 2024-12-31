<?php
/**
 * The Banner Slider Shortcode.
 */

use Aheto\Helper;

extract($atts);

$banners = $this->parse_group($karma_travel_banner);

if ( empty($banners) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--karma-travel');

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
];

$carousel_params = Helper::get_carousel_params($atts, 'karma_travel_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';;
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma-travel-banner-slider-layout1', $shortcode_dir . 'assets/css/karma_travel_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $banners as $banner ) :
					$banner = wp_parse_args($banner, [
						'karma_travel_image'        => '',
						'karma_travel_label'        => '',
						'karma_travel_title'        => '',
						'karma_travel_subtitle'     => '',
						'karma_travel_label_color1' => '',
						'karma_travel_label_color2' => '',
					]);
					extract($banner);

					if ( !$karma_travel_image ) {
						continue;
					}
					$lazy_class       = $karma_travel_lazy ? ' swiper-lazy' : '';
					$background_image = Helper::get_background_attachment($karma_travel_image, 'full', $atts, '', $karma_travel_lazy);
					?>
					<div class="swiper-slide ">
						<div class="aheto-banner-slider-wrap aheto-full-min-height-js <?php echo esc_attr($lazy_class); ?>" <?php echo esc_attr($background_image); ?>>
							<div class="aheto-banner-slider__content">
								<?php if ( !empty($karma_travel_subtitle) ) { ?>
									<p class="aheto-banner-slider__subtitle"><?php echo wp_kses($karma_travel_subtitle, 'post'); ?>
										<?php if ( !empty($karma_travel_label) ) { ?>
											<span class="aheto-banner-slider__label"
												  style="background:
												  <?php if ( empty($karma_travel_label_color1) || empty($karma_travel_label_color2) ) { ?>
													  <?php echo esc_attr($karma_travel_label_color1 . $karma_travel_label_color2); ?>
												  <?php } else { ?>
														  linear-gradient(200deg, <?php echo esc_attr($karma_travel_label_color1)?> 0%, <?php echo esc_attr($karma_travel_label_color2)?> )
												  <?php } ?>"><?php echo wp_kses($karma_travel_label, 'post'); ?></span>
										<?php } ?>
									</p>
								<?php }
								if ( !empty($karma_travel_title) ) { ?>
									<h1 class="aheto-banner-slider__title"><?php echo wp_kses($karma_travel_title, 'post'); ?></h1>
								<?php }


								if ( $karma_travel_main_add_button ) { ?>
									<div class="aheto-banner-slider__links">
										<?php
										echo Helper::get_button($this, $banner, 'karma_travel_main_'); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
