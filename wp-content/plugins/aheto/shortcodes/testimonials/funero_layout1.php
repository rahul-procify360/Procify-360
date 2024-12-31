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

$funero_testimonials_simple_item = $this->parse_group($funero_testimonials_simple_item);
if ( empty($funero_testimonials_simple_item) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--funero-simple');

if ( !$funero_swiper_custom_options ) {
	$speed    = 1000;
	$effect   = 'slide';
	$loop     = true;
	$arrows   = true;
	$autoplay = false;
}
/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'          => 1000,
	'simulate_touch' => 1,
	'initial_slide'  => 0,
	'spaces'         => 25,
	'slides'         => 1,
	'autoplay'       => 0,
	'loop'           => 1,
	'arrows'         => 1,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'funero_swiper_tm_single_', $carousel_default_params);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-testimonials-layout1', $shortcode_dir . 'assets/css/funero_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $funero_testimonials_simple_item as $item ) : ?>
					<div class="swiper-slide">
						<div class="aheto-tm__content">
							<?php if ( !empty($item['funero_image_bg']) ) :
								$background_image = Helper::get_background_attachment($item['funero_image_bg'], 'medium_large', $atts);
								?>
								<div class="aheto-tm__border aheto-tm__border-tl" <?php echo esc_attr($background_image); ?>></div>
								<div class="aheto-tm__border aheto-tm__border-tr" <?php echo esc_attr($background_image); ?>></div>
								<div class="aheto-tm__border aheto-tm__border-bl" <?php echo esc_attr($background_image); ?>></div>
								<div class="aheto-tm__border aheto-tm__border-br" <?php echo esc_attr($background_image); ?>></div>
							<?php endif; ?>
							<?php if ( !empty($item['funero_testimonial']) ) {
								echo '<h4 class="aheto-tm__blockquote">' . esc_html($item['funero_testimonial']) . '</h4>';
							}
							if ( !empty($item['funero_name']) ) {
								echo '<p class="aheto-tm__name">' . esc_html($item['funero_name']) . '</p>';
							}
							if ( !empty($item['funero_date']) ) {
								echo '<p class="aheto-tm__date">' . esc_html($item['funero_date']) . '</p>';
							} ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $this->swiper_arrow('funero_swiper_tm_single_'); ?>
			<?php $this->swiper_pagination('funero_swiper_tm_single_'); ?>
		</div>
	</div>
</div>
