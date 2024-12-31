<?php

/**
 * The Features Shortcode.
 */

use Aheto\Helper;

extract($atts);

$sliders = $this->parse_group($karma_education_slider);

if ( empty($sliders) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-features-slider--karma-education1');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'karma_education_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-slider/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_education-features-single-layout1', $shortcode_dir . 'assets/css/karma_education_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $sliders as $index => $item ) : ?>
					<div class="swiper-slide">
						<div class="aheto-features-slider aheto-features-slider--slider ">
							<?php if ( !empty($item['karma_education_image']) || isset($item['karma_education_image']) ) :
								$background_image = Helper::get_background_attachment($item['karma_education_image'], 'medium_large', $atts);
								?>
								<div class="aheto-features-slider__image" <?php echo esc_attr($background_image); ?>>
								</div>
							<?php endif; ?>
							<div class="aheto-features-slider__content">
								<div class="aheto-features-slider__descr">
									<?php if ( !empty($item['karma_education_number']) ) : ?>
										<div class="aheto-features-slider__number"><?php echo wp_kses_post($item['karma_education_number']); ?></div>
									<?php endif; ?>
									<?php if ( !empty($item['karma_education_date']) ) : ?>
										<div class="aheto-features-slider__info">
											<p class="aheto-features-slider__info-text"><?php echo wp_kses_post($item['karma_education_date']); ?></p>
										</div>
									<?php endif; ?>
								</div>
								<?php if ( !empty($item['karma_education_heading']) ) : ?>
									<h4 class="aheto-features-slider__title"><?php echo wp_kses_post($item['karma_education_heading']); ?></h4>
								<?php endif; ?>
								<div class="aheto-features-slider__bottom-text">
									<?php if ( !empty($item['karma_education_time']) ) : ?>
										<div class="aheto-features-slider__info-text-bottom">
											<i class="ion ion ion-ios-clock-outline"></i>
											<?php echo wp_kses_post($item['karma_education_time']); ?></div>
									<?php endif; ?>

									<?php if ( !empty($item['karma_education_place']) ) : ?>
										<div class="aheto-features-slider__info-text-bottom">
											<i class="ion ion ion-android-map"></i>
											<?php echo wp_kses_post($item['karma_education_place']); ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

        <?php if ( ! empty( $this->atts[ 'karma_education_pagination' ] ) ) { ?>

	    	<?php $this->swiper_pagination('karma_education_'); ?>

	    <?php } ?>

	</div>
</div>
