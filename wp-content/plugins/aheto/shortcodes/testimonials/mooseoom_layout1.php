<?php
/**
 * The Testimonials Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$mooseoom_testimonials = $this->parse_group($mooseoom_testimonials);
if ( empty($mooseoom_testimonials) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--mooseoom-modern');

// Swiper.
if ( !$custom_options ) {
	$speed  = 500;
	$space  = 30;
	$slides = 3;
	$large  = 3;
	$medium = 2;
	$small  = 1;
}

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'    => 1000,
	'autoplay' => false,
	'spaces'   => 30,
	'slides'   => 3,
	'arrows'    => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'mooseoom_swiper_', $carousel_default_params);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('mooseoom-testimonials-layout1', $shortcode_dir . 'assets/css/mooseoom_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="swiper">

		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>

			<div class="swiper-wrapper">

				<?php foreach ( $mooseoom_testimonials as $item ) : ?>

					<div class="swiper-slide">

						<div class="aheto-tm__slide-wrap">

							<div class="aheto-tm__content">
								<?php
								// Testimonial.
								if ( isset($item['mooseoom_testimonial']) && !empty($item['mooseoom_testimonial']) ) {
									echo '<h6 class="aheto-tm__text">' . wp_kses_post($item['mooseoom_testimonial']) . '</h6>';
								} ?>
							</div>

							<div class="aheto-tm__author">

								<?php if ( isset($item['mooseoom_image']) && !empty($item['mooseoom_image'])) : ?>
									<div class="aheto-tm__avatar">
										<?php echo Helper::get_attachment($item['mooseoom_image'], ['class' => 'js-bg'], array(63, 63)); ?>
									</div>
								<?php endif; ?>

								<div class="aheto-tm__info">
									<?php
									// Name.
									if ( isset($item['mooseoom_name']) && !empty($item['mooseoom_name'])) {
										echo '<h5 class="aheto-tm__name">' . wp_kses_post($item['mooseoom_name']) . '</h5>';
									}

									// Company.
									if ( isset($item['mooseoom_company']) && !empty($item['mooseoom_company'])) {
										echo '<p class="aheto-tm__position">' . wp_kses_post($item['mooseoom_company']) . '</p>';
									}
									?>
								</div>

							</div>

						</div>

					</div>

				<?php endforeach; ?>

			</div>

		</div>

	</div>

</div>
