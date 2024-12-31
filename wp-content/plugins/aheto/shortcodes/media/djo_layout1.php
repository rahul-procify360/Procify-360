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

if (empty($djo_items)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-gallery--djo-gallery');
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
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('djo-media-layout1', $shortcode_dir . 'assets/css/djo_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('djo-media-layout1-js', $shortcode_dir . 'assets/js/djo_layout1.js', array('jquery', 'magnific'), null);
}
$counter = 1;

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-gallery__box <?php echo esc_attr($popup_parent); ?>">
		<?php foreach ($djo_items

		as $index => $item) :
		$image = $item['djo_image'];
		$title = $item['djo_title'];
		$subtitle = $item['djo_subtitle'];

		$preview_img = Helper::get_attachment($image, $atts);

		$counter = ($counter > 8) ? 1 : $counter;
		$itemClass = 'aheto-gallery-item--' . $counter;
		?>

		<?php if (($index > 0) && ($index % 8) == 0) { ?>
	</div>
	<div class="aheto-gallery__box js-gallery-wrap <?php echo esc_attr($popup_parent); ?>">
		<?php } ?>

		<a href="<?php echo esc_url($image['url']); ?>"
		   class="aheto-gallery-item js-gallery-item js-popup-gallery-link s-back-switch <?php echo esc_attr($itemClass); ?>"
		   data-effect="mfp-zoom-in">
			<?php echo wp_kses_post($preview_img); ?>
			<?php if (!empty($title) || !empty($subtitle)) { ?>
				<div class="aheto-gallery-item__hidden">
					<div class="aheto-gallery-item__content">
						<?php if (!empty($title)) { ?>
							<h4 class="aheto-gallery-item__title"><?php echo esc_html($title); ?></h4>
						<?php } ?>
						<?php if (!empty($subtitle)) { ?>
							<p class="aheto-gallery-item__subtitle"><?php echo esc_html($subtitle); ?></p>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		</a>

		<?php
		$counter++;
		endforeach;
		?>
	</div>
</div>
