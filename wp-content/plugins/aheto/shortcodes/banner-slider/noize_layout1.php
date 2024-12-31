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

$banners = $this->parse_group($noize_creative_banners);

if (empty($banners)) {
	return '';
}

if (!$noize_swiper_custom_options) {
	$speed = 1000;
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--noize');

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'noize_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';;

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('noize-banner-slider-layout1', $shortcode_dir . 'assets/css/noize_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('noize-banner-slider-layout1-js', $shortcode_dir . 'assets/js/noize_layout1.min.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ($banners as $banner) :
					$banner = wp_parse_args($banner, [
						'noize_image' => '',
						'noize_add_left_image' => '',
						'noize_add_right_image' => '',
						'noize_title' => '',
						'noize_subtitle' => '',
						'noize_use_dot' => ''
					]);

					extract($banner);

					if (!$noize_image) {
						continue;
					}

					$swiper_lazy_class = $noize_swiper_lazy ? ' swiper-lazy' : '';

					$background_image = Helper::get_background_attachment($noize_image, 'full', $atts, '', $noize_swiper_lazy);
					?>
					<div class="swiper-slide noize-full-min-height-js">
						<div
							class="aheto-banner-slider--noize-wrap <?php echo esc_attr($align . $swiper_lazy_class); ?>" <?php echo esc_attr($background_image); ?>>
							<div class="aheto-banner-slider--noize__content">
								<div class="aheto-banner-slider--noize__content-line-top"></div>
								<?php if ($noize_add_left_image) { ?>
									<div class="aheto-banner-slider--noize__content-left">
										<?php echo Helper::get_attachment($noize_add_left_image, ['class' => 'aheto-banner-slider--noize__add-left-image'], $noize_image_size, $atts, 'noize_'); ?>
									</div>
								<?php } ?>
								<div class="aheto-banner-slider--noize__content-right">
									<?php if ($noize_add_right_image) { ?>
										<?php echo Helper::get_attachment($noize_add_right_image, ['class' => 'aheto-banner-slider--noize__add-right-image'], $noize_image_size, $atts, 'noize_'); ?>
									<?php } ?>

									<?php if (!empty($noize_title)) { ?>
										<h2 class="aheto-banner__title"><?php echo esc_html($noize_title); ?></h2>
									<?php } ?>

									<?php if (!empty($noize_subtitle)) { ?>
										<h6 class="aheto-banner__subtitle"><?php echo esc_html($noize_subtitle); ?></h6>
									<?php } ?>
								</div>
								<div class="aheto-banner-slider--noize__content-line-bottom"></div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<?php if (!empty($this->atts['noize_swiper_arrows'])) { ?>
			<?php $this->swiper_arrow('noize_swiper_'); ?>
		<?php } ?>

	</div>
</div>
