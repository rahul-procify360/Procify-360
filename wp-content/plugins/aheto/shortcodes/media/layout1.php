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
$this->add_render_attribute('wrapper', 'class', 'aheto-media--simple');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
	'autoplay' => false,
	'arrows' => false
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, '', $carousel_default_params);


$count = count($image);

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('media-style-1', $sc_dir . 'assets/css/layout1.css', null, null);
}


?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php if (1 === $count) : ?>
		<div class="aheto-single-img t-center">
			<?php echo Helper::get_attachment($image[0], ['class' => 'aheto-single-img__img'], $image_size, $atts); ?>
		</div>
	<?php else : ?>
		<div class="swiper swiper--simple">

			<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>

				<div class="swiper-wrapper">

					<?php foreach ($image as $item) : ?>
						<div class="swiper-slide">
							<?php if (isset($show_image_descr) && $show_image_descr) { ?>
								<div class="image-wrap">
									<?php echo Helper::get_attachment($item, [], $image_size, $atts); ?>
									<div class="image-content">
										<?php $attachment_meta = isset($item['id']) ? get_post($item['id']) : '';
										if(!empty($attachment_meta)){
											echo $attachment_meta->post_content;
										} ?>
									</div>
								</div>
							<?php } else {
								echo Helper::get_attachment($item, [], $image_size, $atts);
							} ?>
						</div>
					<?php endforeach; ?>

				</div>

				<?php $this->swiper_pagination(); ?>

			</div>

			<?php $this->swiper_arrow(); ?>

		</div>
	<?php endif; ?>

</div>
