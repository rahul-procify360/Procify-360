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

$banners = $this->parse_group($famulus_banners);

if ( empty($banners) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-wrap--famulus-style-1');


if ( isset($famulus_change_arrow_position) && $famulus_change_arrow_position == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-banner-wrap--arrow-position');
}
if ( isset($famulus_arrow_square) && $famulus_arrow_square == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-banner-wrap--arrow-square');
}
/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'famulus_swiper_simple_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-banner-slider-layout2', $shortcode_dir . 'assets/css/famulus_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ($banners as $banner) :

				$banner = wp_parse_args($banner, [
					'image'         => '',
					'video_class'   => 'aheto-banner__video-btn',
					'title'         => '',
					'title_tag'     => '',
					'desc_tag'      => '',
					'desc'          => '',
					'align'         => '',
					'btn_direction' => '',
					'overlay'       => '',
					'famulus_video' => '',
					'video_title'   => '',
					'video_link'    => '',
					'video_style'   => '',
				]);
				extract($banner);

				if ( empty($image) ) {
					continue;
				}

				$lazy_class       = $famulus_swiper_simple_lazy ? ' swiper-lazy' : '';
				$background_image = Helper::get_background_attachment($image, 'full', $atts, '', $famulus_swiper_simple_lazy);

				?>
				<div class="swiper-slide">
					<div class="aheto-banner-wrapper aheto-full-min-height-js <?php echo esc_attr($align) . ' tablet-' . esc_attr($tablet_align) . esc_attr($lazy_class); ?>" <?php echo esc_attr($background_image); ?>>
						<?php if ( $overlay == true ): ?>
							<div class="aheto-banner__dark-overlay"></div>
						<?php endif; ?>

						<div class="aheto-banner__content <?php if ( $famulus_overlay_img == true ) echo 'aheto-banner__content-to-top' ?>">
							<?php
							if (!empty($title)) {
							$famulus_title = str_replace(']]', '</span>', $title);
							$famulus_title = str_replace('[[', '<span>', $famulus_title);
							?>
							<<?php echo esc_attr($title_tag); ?>
							class="aheto-banner__title"><?php echo wp_kses($famulus_title, 'post'); ?></<?php echo esc_attr($title_tag); ?>>
					<?php }

					if (!empty($desc) && isset($desc_tag)) { ?>
						<<?php echo esc_attr($desc_tag); ?>
						class="aheto-banner__desc"><?php echo wp_kses($desc, 'post'); ?>
					</<?php echo esc_attr($desc_tag); ?>>
					<?php }

					if ( $main_add_button == true || $add_add_button == true || $famulus_video == true ) { ?>
						<div class="aheto-banner__links <?php echo esc_attr($btn_direction) ? 'aheto-banner__links-col' : ''; ?>">
							<?php
							if ( !empty($famulus_video_link) ) { ?>
								<a href="<?php echo esc_url($famulus_video_link); ?>"
								   class="js-video-btn aheto-banner__video <?php echo esc_attr($famulus_video_style); ?>">
									<i></i>
									<?php if ( !empty($famulus_video_title) ): ?>
										<?php echo esc_html($famulus_video_title); ?>
										<span></span>
									<?php endif; ?>
								</a>
							<?php }
							echo Helper::get_button($this, $banner, 'main_');
							echo esc_attr($btn_direction) ? '<br>' : '';
							echo Helper::get_button($this, $banner, 'add_'); ?>
						</div>
					<?php }
					?>

				</div>
				<?php if ( $famulus_overlay_img == true ): ?>
					<div class="aheto-banner__overlay-img">

						<?php if ($famulus_swiper_simple_lazy) :
							echo Helper::get_attachment_for_swiper($famulus_image_overlay, ['class' => 'js-bg-swiper swiper-lazy']);
						else :
							echo Helper::get_attachment($famulus_image_overlay, ['class' => 'js-bg']);
						endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>

<?php $this->swiper_arrow('famulus_swiper_simple_'); ?>
</div>
</div>
