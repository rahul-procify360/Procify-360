<?php
/**
 * The Features Shortcode.
 */

use Aheto\Helper;

extract($atts);

$sliders = $this->parse_group($karma_shop_slider);
if ( empty($sliders) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-features-slider--karma-shop1');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'karma_shop_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-slider/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_shop-features-single-layout1', $shortcode_dir . 'assets/css/karma_shop_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $sliders as $index => $item ) : ?>
					<div class="swiper-slide">
						<?php if ( !empty($item['karma_shop_image']) ) :
							$background_image = Helper::get_background_attachment($item['karma_shop_image'], 'medium_large', $atts);
							?>
							<div class="aheto-features-slider aheto-features-slider--slider " <?php echo esc_attr($background_image); ?>>
								<div class="aheto-features-slider__content">
									<?php if ( !empty($item['karma_shop_heading']) && !empty($item['karma_shop_link_url']) ) : ?>
										<a href="<?php echo esc_url($item['karma_shop_link_url']); ?>">
											<h4 class="aheto-features-slider__title"><?php echo wp_kses_post($item['karma_shop_heading']); ?></h4>
										</a>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php $this->swiper_arrow('karma_shop_'); ?>
	</div>
</div>
