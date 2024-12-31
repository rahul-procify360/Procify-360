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

$videos = $this->parse_group($acacio_video_slider);

if (empty($videos)) {
	return '';
}

$acacio_hide_pagination = isset($acacio_hide_pagination) && $acacio_hide_pagination ? 'hide-pagination' : '';
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-media--acacio-video');
$this->add_render_attribute('wrapper', 'class', $acacio_hide_pagination);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('acacio-media-layout2', $shortcode_dir . 'assets/css/acacio_layout2.css', null, null);
}


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1500,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Aheto\Helper::get_carousel_params($atts, 'acacio_swiper_', $carousel_default_params);

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="swiper-container" <?php echo esc_attr($carousel_params); ?> data-centeredSlides="1">
		<div class="swiper-wrapper">

			<?php foreach ($videos as $slide) : ?>
				<?php $slide = wp_parse_args($slide, [
					'acacio_video_image' => '',
					'acacio_add_video_button' => '',
				]);
				extract($slide);


				if (empty($acacio_video_image)) {
					continue;
				} else {
					$acacio_video_bg = \Aheto\Helper::get_background_attachment($acacio_video_image, $acacio_image_size, $atts, 'acacio_');
				} ?>
				<div class="swiper-slide" <?php echo esc_attr($acacio_video_bg); ?>>
					<?php
					if ($acacio_add_video_button) {
						echo \Aheto\Helper::get_video_button($slide, 'acacio_');
					} ?>


				</div>
			<?php endforeach; ?>

		</div>
		<?php $this->swiper_pagination('acacio_swiper_'); ?>
	</div>


</div>
