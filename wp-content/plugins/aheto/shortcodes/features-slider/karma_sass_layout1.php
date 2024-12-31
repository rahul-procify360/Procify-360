<?php
/**
 * The Features Shortcode.
 */

use Aheto\Helper;

extract($atts);

$sliders = $this->parse_group($karma_sass_slider);
if ( empty($sliders) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-features-slider--karma-sass1');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'karma_sass_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-slider/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_sass-features-single-layout1', $shortcode_dir . 'assets/css/karma_sass_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $sliders as $index => $item ) : ?>
					<div class="swiper-slide">
							<?php if ( !empty($item['karma_sass_image']) ) : ?>
								<div class="aheto-features-slider__image">
									<?php echo Helper::get_attachment($item['karma_sass_image'], ['class' => ''], 'medium_large'); ?>
									<?php if ( !empty($karma_sass_image_slide_active) ): ?>
										<div class="aheto-features-slider__img-before">
											<?php echo Helper::get_attachment($karma_sass_image_slide_active, ['class' => ''], 'medium_large'); ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php if ( !empty($this->atts['karma_sass_pagination']) ) { ?>
			<?php $this->swiper_pagination('karma_sass_'); ?>
		<?php } ?>
	</div>
</div>
