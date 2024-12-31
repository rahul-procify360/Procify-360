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

$djo_testimonials_creative_item = $this->parse_group($djo_testimonials_creative_item);
if ( empty($djo_testimonials_creative_item) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--djo-creative');
$this->add_render_attribute('wrapper', 'class', 'js-creative-testimonials');

$djo_dark_version = isset($djo_dark_version) && $djo_dark_version ? 'light-version' : '';
$this->add_render_attribute('wrapper', 'class', $djo_dark_version);

// Swiper.
if ( !$custom_options ) {
	$speed  = 1000;
	$space  = 30;
	$slides = 1.8;
	$large  = 1.8;
	$medium = 1;
	$small  = 1;
}

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'    => 1000,
	'autoplay' => 2000,
	'spaces'   => 30,
	'slides'   => 1.8
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'djo_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('djo-testimonials-layout2', $shortcode_dir . 'assets/css/djo_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="swiper">

		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?> data-centeredSlides="<?php echo esc_attr($djo_centered); ?>">

			<div class="swiper-wrapper">

				<?php foreach ( $djo_testimonials_creative_item as $item ) : ?>

					<div class="swiper-slide">

						<div class="aheto-tm__slide-wrap">

							<div class="aheto-tm__content">
								<?php if( ! empty( $item['djo_title'] ) ) { ?>
									<p class="aheto-tm__title">
										<?php echo esc_html( $item['djo_title'] ); ?>
									</p>
								<?php } ?>
								<?php if ( ! empty( $item['djo_testimonial'] ) ) {
									echo '<blockquote><p class="aheto-tm__text">' . wp_kses_post($item['djo_testimonial']) . '</blockquote>';
								} ?>
							</div>

							<div class="aheto-tm__author">

								<?php if ( !empty($item['djo_image'] )) :
									$atts['djo_image_height'] = 70;
									$atts['djo_image_width'] = 70;
									$preview_img = Helper::get_background_attachment($item['djo_image'], 'custom', $atts, 'djo_');
								?>
									<div class="aheto-tm__avatar" <?php echo wp_kses_post($preview_img); ?>></div>
								<?php endif; ?>

								<div class="aheto-tm__info">
									<?php
									// Name.
									if ( ! empty( $item['djo_name'] ) ) {
										echo '<h5 class="aheto-tm__name">' . wp_kses_post($item['djo_name']) . '</h5>';
									}
									// Company.
									if ( ! empty( $item['djo_company'] ) ) {
										echo '<p class="aheto-tm__position">' . wp_kses_post($item['djo_company']) . '</p>';
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
