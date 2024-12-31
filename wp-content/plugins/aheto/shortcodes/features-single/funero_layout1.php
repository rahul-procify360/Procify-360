<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content-block--funero-simple');
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-features-single-layout1', $shortcode_dir . 'assets/css/funero_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>>

		<?php
		$background_image = '';
		if ( !empty($funero_image_bg) ) {
			$background_image = Helper::get_background_attachment($funero_image_bg, $image_size, $atts);
		} ?>
		<div class="aheto-content-block__wrap" <?php echo esc_attr($background_image); ?>>
			<div class="aheto-content-block__shape">
				<?php if ( !empty($funero_text_bg) ) : ?>
					<h2 class="aheto-content-block__text-bg "><?php echo esc_html($funero_text_bg); ?></h2>
				<?php endif; ?>
			</div>
			<?php if ( !empty($funero_subtitle) ) : ?>
				<h5 class="aheto-content-block__subtitle "><?php echo esc_html($funero_subtitle); ?></h5>
			<?php endif; ?>

			<?php if ( !empty($funero_title) ) : ?>
				<h4 class="aheto-content-block__title "><?php echo esc_html($funero_title); ?></h4>
			<?php endif; ?>
		</div>
	</div>
</div>
