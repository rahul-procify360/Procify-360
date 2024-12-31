<?php

/**
 * The Testimonials Shortcode.
 */

use Aheto\Helper;

extract($atts);

$karma_travel_testimonials = $this->parse_group($karma_travel_testimonials);
if ( empty($karma_travel_testimonials) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--karma-travel-classic');

$atts['karma_travel_image_height'] = 170;
$atts['karma_travel_image_width']  = 170;
$atts['karma_travel_image_crop']   = true;

$carousel_params = Helper::get_carousel_params($atts, 'karma_travel_swiper_');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_travel-testimonials-layout2', $shortcode_dir . 'assets/css/karma_travel_layout2.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $karma_travel_testimonials as $item ) : ?>
					<div class="swiper-slide">
						<div class="aheto-tm__slide-wrap">
							<?php if ( $item['karma_travel_image'] ) : $background_image = Helper::get_background_attachment($item['karma_travel_image'], 'custom', $atts, 'karma_travel_'); ?>
								<div class="aheto-tm__avatar" <?php echo esc_attr($background_image); ?>></div>
							<?php endif; ?>
							<div class="aheto-tm__content">
								<?php
								// Name.
								if ( isset($item['karma_travel_name']) && !empty($item['karma_travel_name']) ) {
									echo '<h5 class="aheto-tm__name">' . wp_kses($item['karma_travel_name'], 'post') . '</h5>';
								}
								// Company.
								if ( isset($item['karma_travel_company']) && !empty($item['karma_travel_company']) ) {
									echo '<h6 class="aheto-tm__position">' . wp_kses($item['karma_travel_company'], 'post') . '</h6>';
								}
								if ( isset($item['karma_travel_testimonial']) && !empty($item['karma_travel_testimonial']) ) {
									echo '<p class="aheto-tm__text">' . wp_kses($item['karma_travel_testimonial'], 'post') . '</p>';
								}
								echo Helper::get_social_networks_list('<a class="aheto-tm__link" href="%1$s" target="_blank" rel="noreferrer noopener"><i class="ion-social-%2$s"></i></a>', 'karma_travel_', $item);
								?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $this->swiper_pagination('karma_travel_swiper_'); ?>
		</div>
	</div>
</div>
