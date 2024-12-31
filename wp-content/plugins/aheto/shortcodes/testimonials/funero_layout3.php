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

$funero_testimonials_grid = $this->parse_group($funero_testimonials_grid);
if ( empty($funero_testimonials_grid) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--funero-grid');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-testimonials-layout3', $shortcode_dir . 'assets/css/funero_layout3.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php foreach ( $funero_testimonials_grid as $item ) : ?>
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
				echo '<h6 class="aheto-tm__blockquote">' . esc_html($item['funero_testimonial']) . '</h6>';
			}
			if ( !empty($item['funero_name']) ) {
				echo '<p class="aheto-tm__name">' . esc_html($item['funero_name']) . '</p>';
			}
			if ( !empty($item['funero_date']) ) {
				echo '<p class="aheto-tm__date">' . esc_html($item['funero_date']) . '</p>';
			} ?>
		</div>
	<?php endforeach; ?>
</div>
