<?php
/**
 * The Features Shortcode.
 */

use Aheto\Helper;

extract($atts);

$sliders = $this->parse_group($karma_travel_slider);
if ( empty($sliders) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-features-slider--karma-travel3');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'karma_travel_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-slider/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_travel-features-single-layout3', $shortcode_dir . 'assets/css/karma_travel_layout3.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $sliders as $index => $item ) : ?>
					<div class="swiper-slide">
						<div class="aheto-features-slider aheto-features-slider--slider ">
							<?php if ( !empty($item['karma_travel_image']) ) :
								$background_image = Helper::get_background_attachment($item['karma_travel_image'], 'medium_large', $atts);
								?>
								<div class="aheto-features-slider__image" <?php echo esc_attr($background_image); ?>>
									<div class="aheto-features-slider__content">

										<?php if ( !empty($item['karma_travel_label']) ) { ?>
											<span class="aheto-features-slider__label"
												  style="background:
												  <?php if ( empty($item['karma_travel_label_color1']) || empty($item['karma_travel_label_color2']) ) { ?>
													  <?php echo esc_attr($item['karma_travel_label_color1'] . $item['karma_travel_label_color2']); ?>
												  <?php } else { ?>
														  linear-gradient(200deg, <?php echo esc_attr($item['karma_travel_label_color1'])?> 0%, <?php echo esc_attr($item['karma_travel_label_color2'])?> )
												  <?php } ?>"><?php echo wp_kses($item['karma_travel_label'], 'post'); ?></span>
										<?php } ?>
										<?php if ( !empty($item['karma_travel_price']) ) : ?>
											<h4 class="aheto-features-slider__price"><?php echo wp_kses_post($item['karma_travel_price']); ?></h4>
										<?php endif; ?>

										<?php if ( !empty($item['karma_travel_heading']) && !empty($item['karma_travel_link']) ) : ?>
											<h4 class="aheto-features-slider__title">
												<a href="<?php echo esc_url($item['karma_travel_link']); ?>"><?php echo wp_kses_post($item['karma_travel_heading']); ?></a>
											</h4>
										<?php endif; ?>
										<?php if ( !empty($item['karma_travel_desc']) ) : ?>
											<p class="aheto-features-slider__desc"><?php echo wp_kses_post($item['karma_travel_desc']); ?></p>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php $this->swiper_arrow('karma_travel_'); ?>
	</div>
</div>
