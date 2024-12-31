<?php

/**
 * The Testimonials Shortcode.
 */

use Aheto\Helper;

extract($atts);

$karma_marketing_testimonials = $this->parse_group($karma_marketing_testimonials);

if ( empty($karma_marketing_testimonials) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--karma-marketing-layout1');


$carousel_params = Helper::get_carousel_params($atts, 'karma_marketing_tm_swiper_');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma-marketing-testimonials-layout1', $shortcode_dir . 'assets/css/karma_marketing_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?> data-slides="3" data-slides_md="1" >
			<div class="swiper-wrapper">
				<?php foreach ( $karma_marketing_testimonials as $item ) : ?>
					<div class="swiper-slide">
						<div class="aheto-tm__slide-wrap">
							<?php if ( $item['karma_marketing_image'] ) : $background_image = Helper::get_background_attachment($item['karma_marketing_image'], 'thumbnail', $atts); ?>
								<div class="aheto-tm__avatar" <?php echo esc_attr($background_image); ?>></div>
							<?php endif; ?>

							<?php if ( isset($item['karma_marketing_name']) && !empty($item['karma_marketing_name']) ) {
								echo '<h5 class="aheto-tm__name">' . wp_kses($item['karma_marketing_name'], 'post') . '</h5>';
							}
							if ( isset($item['karma_marketing_company']) && !empty($item['karma_marketing_company']) ) {
								echo '<h6 class="aheto-tm__position">' . wp_kses($item['karma_marketing_company'], 'post') . '</h6>';
							} ?>

							<?php if ( isset($item['karma_marketing_testimonial']) && !empty($item['karma_marketing_testimonial']) ) {
								echo '<p class="aheto-tm__text">' . wp_kses($item['karma_marketing_testimonial'], 'post') . '</p>';
							} ?>

							<?php if ( isset($item['karma_marketing_rating']) && !empty($item['karma_marketing_rating']) ) {
								echo '<p class="aheto-tm__stars">';

								for ( $i = 1; $i <= $item['karma_marketing_rating']; $i++ ) {
									echo '<i class="ion ion-ios-star"></i>';
								}

								if ( $item['karma_marketing_rating'] != floor($item['karma_marketing_rating']) ) {
									echo '<i class="ion ion ion-ios-star-half"></i>';
								}

								for ( $i = $item['karma_marketing_rating'] + 1; $i <= 5; $i++ ) {
									echo '<i class="ion ion-ios-star-outline"></i>';
								}
								echo '</p>';
							} ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<?php $this->swiper_arrow('karma_marketing_tm_swiper_'); ?>

	</div>
</div>
