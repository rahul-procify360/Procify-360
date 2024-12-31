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

$banners = $this->parse_group($prego_modern_banners);

if (empty($banners)) {
    return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--prego-modern');


/**
 * Set carousel params
 */
$carousel_params = Helper::get_carousel_params($atts, 'prego_swiper_');

/**
 * Set dependent style
 */
$shortcode_dir =  aheto()->plugin_url() . 'shortcodes/banner-slider/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('prego-banner-slider-layout2', $shortcode_dir . 'assets/css/prego_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper');?>>
	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ($banners as $banner):
					$banner = wp_parse_args($banner, [
						'prego_item_image' 			=> '',
						'prego_item_overlay' 		=> '',
						'prego_item_overlay_color'	=> '',
						'prego_item_title' 			=> '',
						'prego_item_desc' 			=> '',
						'prego_item_align' 			=> '',
						'prego_item_title_tag' 		=> ''
					]);
  					extract($banner);

					$prego_overlay = isset($prego_item_overlay) && $prego_item_overlay == true ? 'overlay-on' : '';
					$prego_title_tag = isset( $prego_item_title_tag ) && !empty( $prego_item_title_tag ) ? $prego_item_title_tag : 'h1';
					if (empty($prego_item_image)) {
						continue;
					}

					$swiper_lazy_class = $prego_swiper_lazy ? ' swiper-lazy' : '';
					$background_image = Helper::get_background_attachment($prego_item_image, 'full', $atts, '', $prego_swiper_lazy); ?>

					<div class="swiper-slide">
						<div class="aheto-banner-slider-wrap aheto-full-min-height-js s-back-switch <?php echo esc_attr($prego_align . $swiper_lazy_class); ?>" <?php echo esc_attr($background_image); ?>>

						<div class="aheto-banner-slider__content">

							<?php if ( ! empty( $prego_item_desc )) {?>
								<p class="aheto-banner-slider__desc"><?php echo wp_kses_post($prego_item_desc); ?></p>
							<?php }

							if ( ! empty ( $prego_item_title )) {?>
								<<?php echo esc_attr( $prego_item_title_tag ); ?> class="aheto-banner__title"><?php echo wp_kses_post($prego_item_title); ?></<?php echo esc_attr( $prego_item_title_tag ); ?>>
							<?php }

							if ($prego_btn_add_button == true) {?>
								<div class="aheto-banner-slider__links">
									<?php echo Helper::get_button($this, $banner, 'prego_btn_'); ?>
								</div>
							<?php }?>

							</div>
						</div>
					</div>
				<?php endforeach;?>
			</div>
		</div>
		<?php if ( ! empty( $this->atts[ 'prego_swiper_arrows' ] ) ) {  ?>
			<div class="swiper-button-prev">
                <svg width="48" height="44" viewBox="0 0 48 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="44" transform="matrix(-1 0 0 1 48 0)" fill="var(--c-light)"/>
                    <path d="M31.4285 21.9166H17.946L19.8319 19.9991C19.9395 19.8893 20 19.7405 20 19.5852C20 19.43 19.9395 19.2812 19.8319 19.1714C19.7243 19.0617 19.5783 19 19.4261 19C19.2739 19 19.128 19.0617 19.0204 19.1714L16.1629 22.0857C16.1109 22.1411 16.0701 22.2065 16.0429 22.278C15.9857 22.4199 15.9857 22.5791 16.0429 22.721C16.0701 22.7925 16.1109 22.8579 16.1629 22.9133L19.0204 25.8276C19.0735 25.8822 19.1367 25.9256 19.2063 25.9552C19.276 25.9848 19.3507 26 19.4261 26C19.5016 26 19.5763 25.9848 19.6459 25.9552C19.7156 25.9256 19.7788 25.8822 19.8319 25.8276C19.8855 25.7734 19.928 25.7089 19.957 25.6379C19.986 25.5669 20.0009 25.4907 20.0009 25.4138C20.0009 25.3368 19.986 25.2606 19.957 25.1896C19.928 25.1186 19.8855 25.0541 19.8319 24.9999L17.946 23.0824H31.4285C31.5801 23.0824 31.7254 23.0209 31.8326 22.9116C31.9398 22.8023 32 22.6541 32 22.4995C32 22.3449 31.9398 22.1967 31.8326 22.0874C31.7254 21.9781 31.5801 21.9166 31.4285 21.9166Z" fill="var(--c-active)"/>
                </svg>
            </div>
			<div class="swiper-button-next">
                <svg width="48" height="44" viewBox="0 0 48 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="44" fill="var(--c-light)"/>
                    <path d="M16.5715 21.9166H30.054L28.1681 19.9991C28.0605 19.8893 28 19.7405 28 19.5852C28 19.43 28.0605 19.2812 28.1681 19.1714C28.2757 19.0617 28.4217 19 28.5739 19C28.7261 19 28.872 19.0617 28.9796 19.1714L31.8371 22.0857C31.8891 22.1411 31.9299 22.2065 31.9571 22.278C32.0143 22.4199 32.0143 22.5791 31.9571 22.721C31.9299 22.7925 31.8891 22.8579 31.8371 22.9133L28.9796 25.8276C28.9265 25.8822 28.8633 25.9256 28.7937 25.9552C28.724 25.9848 28.6493 26 28.5739 26C28.4984 26 28.4237 25.9848 28.3541 25.9552C28.2844 25.9256 28.2212 25.8822 28.1681 25.8276C28.1145 25.7734 28.072 25.7089 28.043 25.6379C28.014 25.5669 27.9991 25.4907 27.9991 25.4138C27.9991 25.3368 28.014 25.2606 28.043 25.1896C28.072 25.1186 28.1145 25.0541 28.1681 24.9999L30.054 23.0824H16.5715C16.4199 23.0824 16.2746 23.0209 16.1674 22.9116C16.0602 22.8023 16 22.6541 16 22.4995C16 22.3449 16.0602 22.1967 16.1674 22.0874C16.2746 21.9781 16.4199 21.9166 16.5715 21.9166Z" fill="var(--c-active)"/>
                </svg>

            </div>
		<?php } ?>
	</div>
</div>
