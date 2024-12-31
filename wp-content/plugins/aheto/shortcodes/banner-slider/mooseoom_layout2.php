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

$banners = $this->parse_group($mooseoom_modern_banners);

if ( empty($banners) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--mooseoom-creative');

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'mooseoom_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';;
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('mooseoom-banner-slider-layout2', $shortcode_dir . 'assets/css/mooseoom_layout2.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper <?php echo esc_attr($mooseoom_banner_theme); ?>">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $banners as $banner ) :
					$banner = wp_parse_args($banner, [
						'mooseoom_image'         => '',
						'mooseoom_add_image'         => '',
						'mooseoom_title'         => '',
						'mooseoom_desc'          => '',
						'mooseoom_align'         => '',
						'mooseoom_banner_theme'          => '',
					]);
					extract($banner);

					if ( !$mooseoom_image ) {
						continue;
					} ?>
					<div class="swiper-slide">
						<div class="aheto-banner-slider-wrap aheto-full-min-height-js <?php echo esc_attr($mooseoom_align); ?>">
							<?php if(is_array($mooseoom_image) && !empty($mooseoom_image[0]) || !is_array($mooseoom_image) && $mooseoom_image) :
								if ($mooseoom_swiper_lazy) :

									echo Helper::get_attachment_for_swiper($mooseoom_image, ['class' => 'js-bg-swiper swiper-lazy']);

								else :

									echo Helper::get_attachment($mooseoom_image, ['class' => 'js-bg']);

								endif;
							endif; ?>

							<div class="aheto-banner-slider__content">
								<?php if ( $mooseoom_add_image ) {

									if ($mooseoom_swiper_lazy) :
										echo Helper::get_attachment_for_swiper($mooseoom_image, ['class' => 'aheto-banner-slider__add-image swiper-lazy'], $mooseoom_image_size);
									else :

								        echo Helper::get_attachment( $mooseoom_add_image,  ['class' => 'aheto-banner-slider__add-image'], $mooseoom_image_size, $atts, 'mooseoom_' );

									endif;
								}

								if ( !empty($mooseoom_sub_title )) { ?>
									<p class="aheto-banner-slider__sub-title"><?php echo wp_kses_post($mooseoom_sub_title); ?></p>
								<?php }

								if ( !empty($mooseoom_title )) { ?>
									<h2 class="aheto-banner__title"><?php echo wp_kses_post($mooseoom_title); ?></h2>
								<?php }

								if ( !empty($mooseoom_desc )) { ?>
									<p class="aheto-banner-slider__desc"><?php echo wp_kses_post($mooseoom_desc); ?></p>
								<?php }

								if ( $mooseoom_main_add_button || $mooseoom_add_add_button ) { ?>
									<div class="aheto-banner-slider__links">
										<?php
										echo Helper::get_button($this, $banner, 'mooseoom_main_');
										echo Helper::get_button($this, $banner, 'mooseoom_add_'); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="swiper-button-prev"><span><?php esc_html_e('Prev', 'aheto');?></span></div>
		<div class="swiper-button-next"><span><?php esc_html_e('Next', 'aheto');?></span></div>
	</div>
</div>
