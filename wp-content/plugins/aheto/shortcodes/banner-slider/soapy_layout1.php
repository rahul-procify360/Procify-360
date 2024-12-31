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

$banners = $this->parse_group($soapy_simple_banners);

if ( empty($banners) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--soapy-simple');

/**
 * Set carousel params
 */
$carousel_params = Helper::get_carousel_params($atts, 'soapy_swiper_simple_');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-banner-slider-layout1', $shortcode_dir . 'assets/css/soapy_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ($banners

				as $banner):
				$banner = wp_parse_args($banner, [
					'soapy_image_bg'       => '',
					'soapy_image'          => '',
					'soapy_title'          => '',
					'soapy_title_tag'      => '',
					'soapy_content_border' => '',
					'soapy_image_subtitle' => '',
					'soapy_subtitle'       => '',
					'soapy_subtitle_spaces'       => '',
					'soapy_align'          => '',
					'soapy_border'         => '',
					'soapy_b_top'          => '',
					'soapy_b_bottom'       => '',
					'soapy_overlay'        => '',
				]);
				extract($banner); ?>
				<?php if ( !empty($soapy_image_bg )):
					$lazy_class       = $lazy ? ' swiper-lazy' : '';
					$background_image = Helper::get_background_attachment($soapy_image_bg, 'full', $atts, '', $lazy);

				endif; ?>
				<div class="swiper-slide">
					<?php
					if ( $soapy_border == true ) {
						if ( !empty($soapy_b_top) ) { ?>
							<div class="swiper-slide-border-top"
								 style=" background-image: url('<?php echo esc_url($soapy_b_top['url']) ?>');"></div>
						<?php }

					} ?>
					<div class="aheto-banner-slider-wrap <?php echo esc_attr($soapy_align); ?>" <?php echo esc_html($background_image); ?>>
						<?php if ( $soapy_overlay != '' ): ?>
							<div class="aheto-banner-slider__overlay aheto-banner-slider__overlay-<?php echo esc_html($soapy_overlay) ?>"></div>
						<?php endif; ?>
						<div class="aheto-banner-slider__content <?php if ( !empty($soapy_content_border['url']) ) {
							echo 'aheto-banner-slider__content-bordered';
						} ?>"
							<?php if ( !empty($soapy_content_border['url']) ) {
								echo 'style="border-image-source: url(' . $soapy_content_border['url'] . ') "';
							} ?>>
							<?php if ( !empty($soapy_image) ) { ?>
								<div class="aheto-banner-slider__image-wrap">
									<?php echo Helper::get_attachment($soapy_image, ['class' => 'aheto-banner-slider__image']); ?>
								</div>
							<?php } ?>
							<?php if ( !empty($soapy_subtitle) ) { ?>
								<?php !empty($soapy_subtitle_spaces) ? $subtitle_space = 'style= margin-bottom:0px;' : $subtitle_space = '';
?>
								<h6 class="aheto-banner-slider__subtitle <?php if ( !empty($soapy_image_subtitle['url']) ) {
									echo 'aheto-banner-slider__subtitle-bordered';
								} ?>"
									<?php
									echo esc_attr($subtitle_space);
									if ( !empty($soapy_image_subtitle['url']) ) {
										echo 'style="border-image-source: url(' . $soapy_image_subtitle['url'] . ') "';
									} ?>>
									<?php echo wp_kses($soapy_subtitle, 'post'); ?></h6>
							<?php }

							if (!empty($soapy_title)) { ?>
							<<?php echo esc_attr($soapy_title_tag); ?>
							class="aheto-banner-slider__title"><?php echo wp_kses($soapy_title, 'post'); ?>
						</<?php echo esc_attr($soapy_title_tag); ?>>
					<?php }

					if ( $soapy_main_add_button == true ) { ?>
						<div class="aheto-banner-slider__links">
							<?php echo Helper::get_button($this, $banner, 'soapy_main_'); ?>
						</div>
					<?php } ?>

					</div>
				</div>
				<?php
				if ( $soapy_border == true ) {
					if ( !empty($soapy_b_bottom) ) { ?>
						<div class="swiper-slide-border-bottom"
							 style=" background-image: url('<?php echo esc_url($soapy_b_bottom['url'] )?>');"></div>
					<?php }
				} ?>
			</div>
			<?php endforeach; ?>
		</div>
		<?php $this->swiper_arrow('soapy_swiper_simple_'); ?>
	</div>
</div>
</div>
