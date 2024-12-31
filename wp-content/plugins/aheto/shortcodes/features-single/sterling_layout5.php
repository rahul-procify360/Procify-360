<?php

/**
 * The Features Shortcode.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-features--sterling-5');

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-features-single-modern-hover', $sc_dir . 'assets/css/sterling_layout5.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if (!empty($s_image) && isset($s_image)) : ?>
		<?php $feature_bg = \Aheto\Helper::get_background_attachment($s_image, $sterling_image_size, $atts, 'sterling_'); ?>
	<?php endif; ?>
	<div
		class="aheto-content-block t-center aheto-content-block--light aheto-content-block--bgImg" <?php echo esc_attr($feature_bg); ?>>
		<div class="aheto-content-block__descr">
			<?php if (!empty($s_heading)) : ?>
				<h4 class="aheto-content-block__title">
					<?php echo esc_html($s_heading); ?>
				</h4>
			<?php endif; ?>
			<div class="aheto-content-block__info">
				<?php if (!empty($s_description)) : ?>
					<p class="aheto-content-block__info-text">
						<?php echo esc_html($s_description); ?>
					</p>
				<?php endif; ?>
			</div>
			<?php if (!empty($sterling_main_add_button)) { ?>
				<div class="aheto-btn-container t-center">
					<?php echo Helper::get_button($this, $atts, 'sterling_main_'); ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
