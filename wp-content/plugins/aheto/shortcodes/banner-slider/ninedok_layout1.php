<?php
/**
 * The Banner Slider Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$banners = $this->parse_group($ninedok_modern_banners);

if (empty($banners)) {
	return '';
}


$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--ninedok-modern');

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'ninedok_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('ninedok-banner-slider-layout1', $shortcode_dir . 'assets/css/ninedok_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('ninedok-banner-slider-layout1-js', $shortcode_dir . 'assets/js/ninedok_layout1.min.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?> data-progress-move="1">
			<div class="swiper-wrapper">
				<?php foreach ($banners as $banner) :
					$banner = wp_parse_args($banner, [
						'ninedok_image' => '',
						'ninedok_add_image' => '',
						'ninedok_title' => '',
						'ninedok_desc' => '',
						'ninedok_align' => '',
						'ninedok_text_tag' => 'div'
					]);
					extract($banner);

					if (!$ninedok_image) {
						continue;
					}
					$swiper_lazy_class = $ninedok_swiper_lazy ? ' swiper-lazy' : '';
					$background_image = Helper::get_background_attachment($ninedok_image, 'full', $atts, '', $ninedok_swiper_lazy); ?>

					<div class="swiper-slide">
						<div
							class="aheto-banner-slider-wrap <?php echo esc_attr($ninedok_align . $swiper_lazy_class); ?>" <?php echo esc_attr($background_image); ?>>

							<div class="aheto-banner-slider__overlay"></div>
							<div class="aheto-banner-slider__content">
								<?php if (is_array($ninedok_add_image) && !empty($ninedok_add_image[0]) || !is_array($ninedok_add_image) && $ninedok_add_image) :
									if ($ninedok_swiper_lazy) :
										echo Helper::get_attachment_for_swiper($ninedok_add_image, ['class' => 'aheto-banner-slider__add-image swiper-lazy'], $ninedok_image_size);
									else :
										echo Helper::get_attachment($ninedok_add_image, ['class' => 'aheto-banner-slider__add-image'], $ninedok_image_size, $atts, 'ninedok_');
									endif;
								endif;
								if (!empty($ninedok_subtitle)) { ?>
									<p class="aheto-banner__subtitle"><?php echo wp_kses($ninedok_subtitle, 'post'); ?></p>
								<?php }
								if (!empty($ninedok_title)) {
									echo '<' . $ninedok_text_tag . ' class="aheto-banner__title">' . wp_kses($ninedok_title, 'post') . '</' . $ninedok_text_tag . '>';
								}

								if (!empty($ninedok_desc)) { ?>
									<h5 class="aheto-banner-slider__desc"><?php echo wp_kses($ninedok_desc, 'post'); ?></h5>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php $this->swiper_arrow('ninedok_swiper_'); ?>
	</div>
</div>
