<?php
/**
 * The Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
if (!is_array($image)) {
	$image = explode(',', $image);
}
if (empty($image)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-media');
$this->add_render_attribute('wrapper', 'class', 'aheto-media--grid');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

$popup_parent = '';

if ($image_popup == 'magnific') {
	$popup_parent = 'js-popup-gallery';
	if (!Helper::is_Elementor_Live()) {
		wp_enqueue_script('magnific');
		wp_enqueue_style('magnific');
	}
} elseif ($image_popup == 'lightgallery') {
	$popup_parent = 'js-aheto-lg';
	if (!Helper::is_Elementor_Live()) {
		wp_enqueue_script('lightgallery');
		wp_enqueue_style('lightgallery');
	}
}


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('media-style-3', $sc_dir . 'assets/css/layout3.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-media__list js-isotope <?php echo esc_attr($popup_parent); ?>">
		<?php foreach ($image as $item) :
			$url = isset($item['url']) && !empty($item['url']) ? $item['url'] : '';
			$url = isset($item['id']) ? wp_get_attachment_image_url($item['id'], 'full') : $url;
			$id = attachment_url_to_postid($url);
			$image_alt = get_post_meta($id, '_wp_attachment_image_alt', true);
			$image_caption = wp_get_attachment_caption($id);
			$caption_class = isset($image_caption) && !empty($image_caption) ? ' item-caption' : '';
			$background_image = Helper::get_background_attachment($item, $image_size, $atts); ?>
			<div class="aheto-media__item aheto-cpt-article--size">
				<a href="<?php echo esc_url($url); ?>"
				   class="aheto-media__link js-popup-gallery-link <?php echo esc_attr($image_hover . $caption_class); ?>"
				   data-title="<?php echo esc_attr($image_alt); ?>"
				   data-sub-html="<?php echo esc_attr($image_caption); ?>">
					<span class="aheto-media__bg" <?php echo esc_attr($background_image); ?>></span>
					<?php if (!empty($image_caption)) { ?>
						<span
							class="aheto-media__caption"><span><?php echo wp_kses($image_caption, 'post'); ?></span></span>
					<?php } ?>
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</div>
