<?php
/**
 * The media Shortcode.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-media--azyn-creative');

$popup_parent = '';
if ($image_popup == 'magnific') {
	if (!Helper::is_Elementor_Live()) {
		wp_enqueue_script('magnific');
		wp_enqueue_style('magnific');
	}
	$popup_parent = 'js-popup-gallery';

} elseif ($image_popup == 'lightgallery') {
	if (!Helper::is_Elementor_Live()) {
		wp_enqueue_script('lightgallery');
		wp_enqueue_style('lightgallery');
	}
	$popup_parent = 'js-aheto-lg';
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('azyn-media-layout1', $shortcode_dir . 'assets/css/azyn_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-media__wrapper <?php echo esc_attr($popup_parent); ?>">
		<?php foreach ($azyn_images as $image) {

			$image_id = is_array($image) && isset($image['id']) ? $image['id'] : $image;
			$image_alt = is_numeric($image_id) ? wp_get_attachment_caption($image_id) : '';
			$image_url = is_numeric($image_id) ? wp_get_attachment_image_url($image_id, 'full') : '';

			?>

			<a href="<?php echo esc_url($image_url); ?>" class="aheto-media__item js-popup-gallery-link"
			   data-title="<?php echo esc_attr($image_alt); ?>">
				<div class="aheto-media__image">
					<?php

					echo Aheto\Helper::get_attachment($image, [], $azyn_image_size, $atts, 'azyn_'); ?>

					<div class="aheto-media__overlay">
						<?php if (!empty($image_alt)) { ?>
							<span>
							<?php echo esc_html($image_alt); ?>
						</span>
						<?php } ?>
					</div>
				</div>
			</a>

		<?php } ?>
	</div>

</div>
