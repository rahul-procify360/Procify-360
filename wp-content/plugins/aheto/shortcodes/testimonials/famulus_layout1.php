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

$famulus_testimonials_simple_item = $this->parse_group($famulus_testimonials_simple_item);
if ( empty($famulus_testimonials_simple_item) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
if ( $famulus_white_text == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--white-text');
}
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--modern');

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
	'speed'          => 1500,
	'autoplay'       => 1,
	'simulate_touch' => 1,
	'loop'           => 1,
	'initial_slide'  => 0,
	'spaces'         => 25,
	'slides'         => 3,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'famulus_swiper_', $carousel_default_params);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-testimonials-layout1', $shortcode_dir . 'assets/css/famulus_layout1.css', null, null);
}


?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $famulus_testimonials_simple_item as $item ) : ?>
					<div class="swiper-slide">
						<div class="aheto-tm aheto-tm__modern">
							<div class="aheto-tm__content">
								<?php
								// Testimonial.
								if ( !empty($item['famulus_testimonial']) ) {
									echo '<p class="aheto-tm__blockquote">' . wp_kses($item['famulus_testimonial'], 'post') . '</p>';
								} ?>
							</div>
							<div class="aheto-tm__author">
								<?php if ( !empty($item['famulus_image']) ) :
									$background_image = Helper::get_background_attachment($item['famulus_image'], 'thumbnail', $atts);
									?>
									<div class="aheto-tm__avatar" <?php echo esc_attr($background_image); ?>>
									</div>
								<?php endif; ?>
								<div class="aheto-tm__info">
									<?php
									// Name.
									if ( !empty($item['famulus_name']) ) {
										echo '<h5 class="aheto-tm__name">' . wp_kses($item['famulus_name'], 'post') . '</h5>';
									}
									// Company.
									if ( !empty($item['famulus_company']) ) {
										echo '<h6 class="aheto-tm__position">' . wp_kses($item['famulus_company'], 'post') . '</h6>';
									}
									?>
								</div>

							</div>

						</div>

					</div>

				<?php endforeach; ?>

			</div>

			<?php $this->swiper_pagination('famulus_swiper_'); ?>

		</div>

		<?php $this->swiper_arrow('famulus_swiper_'); ?>

	</div>

</div>
