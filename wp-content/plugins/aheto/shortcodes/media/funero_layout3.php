<?php
/**
 * The Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
$funero_gallery_simple = $this->parse_group($funero_gallery_simple);

if (empty($funero_gallery_simple)) {

	return '';
}
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-funero-gallery');
$this->add_render_attribute('wrapper', 'class', 'aheto-funero-gallery-simple');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-media-layout3', $shortcode_dir . 'assets/css/funero_layout3.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if (!empty($funero_image_border)) :
		$background_image = Helper::get_background_attachment($funero_image_border, 'medium_large', $atts);
		?>
		<div
			class="aheto-funero-gallery__border aheto-funero-gallery__border-tl" <?php echo esc_attr($background_image); ?>></div>
		<div
			class="aheto-funero-gallery__border aheto-funero-gallery__border-tr" <?php echo esc_attr($background_image); ?>></div>
		<div
			class="aheto-funero-gallery__border aheto-funero-gallery__border-bl" <?php echo esc_attr($background_image); ?>></div>
		<div
			class="aheto-funero-gallery__border aheto-funero-gallery__border-br" <?php echo esc_attr($background_image); ?>></div>
	<?php endif; ?>
	<div class="aheto-funero-gallery__container">
		<?php foreach ($funero_gallery_simple as $index => $item) :
			if (!empty($item['funero_image'])) :
				$background_image = \Aheto\Helper::get_background_attachment($item['funero_image'], $atts['funero_media_image_size'], $atts, 'funero_media_');
				?>
				<div class="aheto-funero-gallery__image" <?php echo esc_attr($background_image); ?>></div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>
