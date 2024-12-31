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
$azyn_link_url = isset($azyn_link_url) && !empty($azyn_link_url) ? $azyn_link_url : '#';
// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-features--azyn-modern');
$this->add_render_attribute('wrapper', 'href', $azyn_link_url);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('azyn-features-single-layout1', $shortcode_dir . 'assets/css/azyn_layout1.css', null, null);
}
?>
<a <?php $this->render_attribute_string('wrapper'); ?>>

	<?php if (!empty($azyn_images)) : ?>

		<div class="aheto-features-block__image-wrap">
			<?php foreach ($azyn_images as $image){

				$background_image = Helper::get_background_attachment($image, $azyn_image_size, $atts, 'azyn_'); ?>
				<div class="aheto-features-block__image" <?php echo esc_attr($background_image); ?>></div>
			<?php } ?>
		</div>

	<?php endif; ?>

	<?php if (!empty($s_heading)) : ?>
		<h4 class="aheto-content-block__title"><?php echo esc_html($s_heading); ?></h4>
	<?php endif; ?>

</a>
