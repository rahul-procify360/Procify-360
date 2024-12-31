<?php
/**
 * The Features Shortcode.
 */

use Aheto\Helper;

extract($atts);

$sliders = $this->parse_group($karma_travel_slider2);
if ( empty($sliders) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-features-slider--karma-travel2');
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
	wp_enqueue_style('karma_travel-features-single-layout2', $shortcode_dir . 'assets/css/karma_travel_layout2.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $sliders as $index => $item ) :?>
					<div class="swiper-slide">
						<div class="aheto-features-slider aheto-features-slider--slider ">
							<div class="aheto-features-slider__content">
								<?php if ( !empty($item['karma_travel_image']) ) :
									$background_image = Helper::get_background_attachment($item['karma_travel_image'], 'medium_large', $atts);
									?>
									<div class="aheto-features-slider__image" <?php echo esc_attr($background_image); ?>>
										<?php if ( !empty($item['karma_travel_heading']) ) : ?>
											<h4 class="aheto-features-slider__title"><?php echo wp_kses_post($item['karma_travel_heading']); ?></h4>
										<?php endif; ?>
										<?php if($item['karma_travel_hide_rating'] == false):?>
										<div class="aheto-features-slider__rating-wrap">
											<?php
											// Rating.
											if ( isset($item['karma_travel_rating']) && !empty($item['karma_travel_rating']) ) {
												echo '<p class="aheto-features-slider__stars">';
												for ( $i = 1; $i <= $item['karma_travel_rating']; $i++ ) {
													echo '<i class="ion ion-ios-star"></i>';
												}
												if ( $item['karma_travel_rating'] != floor($item['karma_travel_rating']) ) {
													echo '<i class="ion ion ion-ios-star-half"></i>';
												}
												for ( $i = $item['karma_travel_rating'] + 1; $i <= 5; $i++ ) {
													echo '<i class="ion ion-ios-star-outline"></i>';
												}
												echo '</p>';
											}
											?>
											<?php if ( !empty($item['karma_travel_rating_text']) ) : ?>
												<span class="aheto-features-slider__rating-text"><?php echo wp_kses_post($item['karma_travel_rating_text']); ?></span>
											<?php endif; ?>
										</div>
										<?php endif;?>
									</div>
								<?php endif; ?>
								<div class="aheto-features-slider__top-info">
									<?php if ( !empty($item['karma_travel_days']) ) : ?>
										<div class="aheto-features-slider__labels">
											<i class="ion-android-calendar"></i>
											<?php echo wp_kses_post($item['karma_travel_days']); ?>
										</div>
									<?php endif; ?>
									<?php if ( !empty($item['karma_travel_cat']) ) : ?>
										<div class="aheto-features-slider__labels">
											<?php if(($item['add_icon']) == true):
												$class = $item['icon_font'];
												$class = $item["icon_$class"];
												echo '<i class="'.esc_attr($class).'"></i>';?>
											<?php endif;?>
											<?php echo wp_kses_post($item['karma_travel_cat']); ?>
										</div>
									<?php endif; ?>
									<?php if ( !empty($item['karma_travel_age']) ) : ?>
										<div class="aheto-features-slider__labels">
											<i class="ion-android-people"></i>
											<?php echo wp_kses_post($item['karma_travel_age']); ?>
										</div>
									<?php endif; ?>
								</div>
								<div class="aheto-features-slider__price-wrap">
									<?php if ( !empty($item['karma_travel_price_before']) ) : ?>
										<p class="aheto-features-slider__price-label"><?php echo wp_kses_post($item['karma_travel_price_before']); ?></p>
									<?php endif; ?>
									<?php if ( !empty($item['karma_travel_price']) ) : ?>
										<p class="aheto-features-slider__price"><?php echo wp_kses_post($item['karma_travel_price']); ?></p>
									<?php endif; ?>
									<?php if ( !empty($item['karma_travel_price_label']) ) : ?>
										<p class="aheto-features-slider__price-label"><?php echo wp_kses_post($item['karma_travel_price_label']); ?></p>
									<?php endif; ?>
								</div>
								<?php if ( !empty($item['karma_travel_desc']) ) : ?>
									<p class="aheto-features-slider__desc"><?php echo wp_kses_post($item['karma_travel_desc']); ?></p>
								<?php endif; ?>
								<?php if ( $item['karma_travel_main_add_button'] ) { ?>
									<div class="aheto-features-slider__links">
										<?php echo Helper::get_button($this, $item, 'karma_travel_main_'); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php $this->swiper_pagination('karma_travel_'); ?>
	</div>
</div>
