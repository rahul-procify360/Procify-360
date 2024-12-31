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

$soapy_testimonials_simple_item = $this->parse_group($soapy_testimonials_simple_item);
if ( empty($soapy_testimonials_simple_item) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--soapy-simple');

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'    => 1500,
	'autoplay' => 1,
	'simulate_touch' => 1,
	'loop'  => 1,
	'initial_slide' => 0,
	'spaces'   => 25,
	'slides'   => 3,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'soapy_swiper_', $carousel_default_params);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-testimonials-layout1', $shortcode_dir . 'assets/css/soapy_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $soapy_testimonials_simple_item as $item ) : ?>
					<div class="swiper-slide">
						<div class="aheto-tm aheto-tm__simple">
							<div class="aheto-tm__content">
								<?php if ( !empty($item['soapy_image']) ) :
									$background_image = Helper::get_background_attachment($item['soapy_image'], 'thumbnail', $atts);
									?>
									<div class="aheto-tm__avatar" <?php echo esc_attr($background_image); ?>>
									</div>
								<?php endif;
								if ( !empty($item['soapy_testimonial']) ) {
									echo '<p class="aheto-tm__blockquote">' . wp_kses($item['soapy_testimonial'], 'post') . '</p>';
								}
								if ( !empty($item['soapy_name']) ) {
									echo '<p class="aheto-tm__name">' . wp_kses($item['soapy_name'], 'post') . '</p>';
								}?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $this->swiper_pagination('soapy_swiper_'); ?>
		</div>
		<?php $this->swiper_arrow('soapy_swiper_'); ?>
	</div>
</div>
