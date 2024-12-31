<?php
/**
 * The Noize Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if (empty($noize_image)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto_media--noize');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';

$popup_parent = '';
if ($image_popup == 'magnific') {
	$popup_parent = 'js-popup-gallery';
	if (!Helper::is_Elementor_Live()) {
		wp_enqueue_script('magnific');
		wp_enqueue_style('magnific');
	}
} elseif ($image_popup == 'lightgallery') {
	if (!Helper::is_Elementor_Live()) {
		wp_enqueue_script('lightgallery');
		wp_enqueue_style('lightgallery');
	}
	$popup_parent = 'js-aheto-lg';
}

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('noize-media-layout1', $shortcode_dir . 'assets/css/noize_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('noize-media-layout1-js', $shortcode_dir . 'assets/js/noize_layout1.js', array('jquery'), null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto_media--noize-img <?php echo esc_attr($popup_parent); ?>">
		<div class="grid-sizer"></div>
		<?php
		$counter = 1;

		foreach ($noize_image as $image) {
			$hide_item = $counter > 6 && $noize_load_add_button ? 'hide-item' : '';
			$image_id = is_array($image) && !empty($image['id']) ? $image['id'] : $image;
			$image_url = wp_get_attachment_image_url($image_id, 'full');
			$background_image = Helper::get_background_attachment($image, $noize_image_size, $atts, 'noize_');
			?>
			<a href="<?php echo esc_url($image_url) ?>"
			   class="grid-item js-popup-gallery-link <?php echo esc_attr($hide_item); ?>">
				<span <?php echo esc_attr($background_image); ?>></span>
			</a>
			<?php
			$counter++;
		} ?>
	</div>

	<?php if ($noize_load_add_button) { ?>
		<div class="aheto_media--noize-btn <?php echo esc_attr($this->atts['noize_align']); ?>">
			<?php echo \Aheto\Helper::get_button($this, $atts, 'noize_load_'); ?>
		</div>
	<?php } ?>

</div>
