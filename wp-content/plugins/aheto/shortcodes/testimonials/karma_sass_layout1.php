<?php

/**
 * The Testimonials Shortcode.
 */

use Aheto\Helper;

extract($atts);

$karma_sass_testimonials = $this->parse_group($karma_sass_testimonials);
if ( empty($karma_sass_testimonials) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--karma-sass-layout1');


$carousel_params = Helper::get_carousel_params($atts, 'karma_sass_tm_swiper_');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma-sass-testimonials-layout1', $shortcode_dir . 'assets/css/karma_sass_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $karma_sass_testimonials as $item ) : ?>
					<div class="swiper-slide">
						<?php if ( isset($item['karma_sass_subtitle']) && !empty($item['karma_sass_subtitle']) ) {
							$blockquote_image = !empty($item['karma_sass_bg_image']) ? Helper::get_background_attachment($item['karma_sass_bg_image'], 'thumbnail', $atts) : '';
							echo '<h6 class="aheto-tm__subtitle" '.esc_attr($blockquote_image).'>' . wp_kses($item['karma_sass_subtitle'], 'post') . '</h6>';
						} ?>

						<?php if ( isset($item['karma_sass_testimonial']) && !empty($item['karma_sass_testimonial']) ) {
							echo '<p class="aheto-tm__text">' . wp_kses($item['karma_sass_testimonial'], 'post') . '</p>';
						} ?>
						<?php if ( $item['karma_sass_image'] ) : $background_image = Helper::get_background_attachment($item['karma_sass_image'], 'thumbnail', $atts); ?>
							<div class="aheto-tm__avatar" <?php echo esc_attr($background_image); ?>></div>
						<?php endif; ?>
						<?php if ( isset($item['karma_sass_name']) && !empty($item['karma_sass_name']) ) {
							echo '<h5 class="aheto-tm__name">' . wp_kses($item['karma_sass_name'], 'post') . '</h5>';
						} ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<?php $this->swiper_arrow('karma_sass_tm_swiper_'); ?>
	</div>
</div>
