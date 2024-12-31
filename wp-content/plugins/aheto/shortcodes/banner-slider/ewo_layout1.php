<?php

/**
 * The Banner Slider Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$banners = $this->parse_group( $ewo_modern_banners );


if ( empty( $banners ) ) {
	return '';
}

$ewo_use_glitch = isset( $ewo_use_glitch ) && $ewo_use_glitch ? 'glitch' : '';

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-banner-slider--ewo-modern' );
$this->add_render_attribute( 'wrapper', 'class', $ewo_use_glitch );

/**
 * Set carousel params
 */
$carousel_params = Helper::get_carousel_params( $atts, 'ewo_swiper_' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'ewo-banner-slider-layout1', $shortcode_dir . 'assets/css/ewo_layout1.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>
            <div class="swiper-wrapper">
				<?php foreach ( $banners as $banner ) :
					$banner = wp_parse_args( $banner, [
						'ewo_image'         => '',
						'ewo_overlay_color' => '',
						'ewo_overlay'       => '',
						'ewo_title'         => '',
						'ewo_desc'          => ''
					] );
					extract( $banner );
					$ewo_overlay = isset( $ewo_overlay ) && ! empty( $ewo_overlay ) ? 'overlay-on' : '';
					if ( ! $ewo_image ) {
						continue;
					} ?>
                    <div class="swiper-slide">
                        <div class="aheto-banner-slider-wrap aheto-full-min-height-js <?php echo esc_attr( $ewo_overlay ); ?>">
                            <?php if (is_array($ewo_image) && !empty($ewo_image[0]) || !is_array($ewo_image) && $ewo_image) :
								if ( $ewo_swiper_lazy ) :
									echo Helper::get_attachment_for_swiper( $ewo_image, [ 'class' => 'js-bg-swiper swiper-lazy' ] );
								else :
									echo Helper::get_attachment( $ewo_image, [ 'class' => 'js-bg' ] );
								endif;
							endif; ?>

							<?php if ( $ewo_overlay ) : ?>
                                <span class="aheto-banner-slider__overlay"
                                      style="background-color: <?php echo esc_attr( $ewo_overlay_color ); ?>"></span>
							<?php endif; ?>

                            <div class="aheto-banner-slider__content">
								<?php

								if ( $ewo_add_video_button ) { ?>
                                    <div class="aheto-banner__video-bg">
										<?php if ( $ewo_swiper_lazy ) :
											echo Helper::get_attachment_for_swiper( $ewo_video_bg, [ 'class' => 'js-bg-swiper swiper-lazy' ] );
										else :
											echo Helper::get_attachment( $ewo_video_bg, [ 'class' => 'js-bg' ] );
										endif; ?>
										<?php echo Helper::get_video_button( $banner, 'ewo_' ); ?>
                                    </div>
								<?php }
								if ( ! empty( $ewo_title ) ) { ?>
                                    <h2 class="aheto-banner__title glitch"
                                        data-trick="<?php echo wp_kses_post( $ewo_title ); ?>"><?php echo esc_html( $ewo_title ); ?></h2>
								<?php }
								if ( ! empty( $ewo_desc ) ) { ?>
                                    <h6 class="aheto-banner-slider__desc"><?php echo esc_html( $ewo_desc ); ?></h6>
								<?php }
								if ( $ewo_main_add_button || $ewo_add_add_button ) { ?>
                                    <div class="aheto-banner-slider__links">
										<?php
										echo Helper::get_button( $this, $banner, 'ewo_main_' );
										echo Helper::get_button( $this, $banner, 'ewo_add_' ); ?>
                                    </div>
								<?php } ?>
                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
		<?php $this->swiper_arrow( 'ewo_swiper_' ); ?>
    </div>
</div>
