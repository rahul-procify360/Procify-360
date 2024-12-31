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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--hr-modern');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-features-single-layout1', $shortcode_dir . 'assets/css/hryzantema_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<div class="aheto-features-block__shape"></div>
		<div class="aheto-features-block__wrap">

			<?php if (!empty($s_image)) : ?>
				<?php echo \Aheto\Helper::get_attachment($s_image, ['class' => 'aheto-features-block__image'], $hryzantema_image_size, $atts, 'hryzantema_'); ?>
			<?php endif; ?>

			<?php if (!empty($s_heading)) : ?>
				<h4 class="aheto-content-block__title"><?php echo esc_html($s_heading); ?></h4>
			<?php endif; ?>

			<div class="aheto-features-block__info">
				<?php if (!empty($s_description)) : ?>
					<p class="aheto-content-block__info-text ">
						<?php echo wp_kses_post($s_description); ?>
					</p>
				<?php endif; ?>
			</div>
			<?php if ($main_add_button == true || $additional_add_button == true) { ?>
				<div class="aheto-features__links">
					<?php if ($main_add_button) {
						echo \Aheto\Helper::get_button($this, $atts, 'hryzantema_main_');
					} ?>
				</div>
			<?php } ?>
		</div>

	</div>

</div>
