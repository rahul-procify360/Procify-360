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

extract( $atts );

$banners = $this->parse_group( $outsourceo_modern_banners );

if ( empty( $banners ) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-banner-slider--outsourceo-modern' );


/**
 * Set carousel params
 */
$carousel_params = Helper::get_carousel_params( $atts, 'outsourceo_swiper_' );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-banner-slider-layout1', $shortcode_dir . 'assets/css/outsourceo_layout1.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>
            <div class="swiper-wrapper">
				<?php foreach ( $banners as $banner ) :
					$banner = wp_parse_args( $banner, [
						'image'         => '',
						'overlay_color' => '',
						'overlay'       => '',
						'title'         => '',
						'use_dot'       => '',
						'desc'          => '',
						'align'         => '',
						'btn_direction' => ''
					] );
					extract( $banner );

					$use_dot = isset( $use_dot ) && ! empty( $use_dot ) ? 'outsourceo-dot' : '';
					$overlay = isset( $overlay ) && ! empty( $overlay ) ? 'overlay-on' : '';

					if ( ! $image ) {
						continue;
					}

					$add_image_size = isset($add_image_size) ? $add_image_size : 'full';
					$swiper_lazy_class = $lazy ? ' swiper-lazy' : '';
					$background_image  = Helper::get_background_attachment( $image, $image_size, $atts, 'outsourceo_', $lazy ); ?>

                    <div class="swiper-slide">
                        <div class="aheto-banner-slider-wrap s-back-switch <?php echo esc_attr( $align . ' ' . $overlay . $swiper_lazy_class ); ?>" <?php echo esc_attr( $background_image ); ?>>

							<?php if ( $overlay ) : ?>
                                <span class="aheto-banner-slider__overlay"
                                      style="background-color: <?php echo esc_attr( $overlay_color ); ?>;"></span>
							<?php endif; ?>

                            <div class="aheto-banner-slider__content">
								<?php if ( ! empty( $add_image ) ) { ?>
									<?php echo Helper::get_attachment( $add_image, [ 'class' => 'aheto-banner-slider__add-image' ], $add_image_size, $atts, 'outsourceo_add_' ); ?>
								<?php }

								if ( ! empty( $title ) ) { ?>
                                    <h1 class="aheto-banner__title"><?php

										if ( $use_dot ) {

											$title = str_replace( '{{.}}', '<span class="outsourceo-dot dot-primary"></span>', $title );

											$words = explode( " ", $title );

											if ( count( $words ) > 0 ) {
												$last_word = $words[ count( $words ) - 1 ];

												$last_space_position = strrpos( $title, ' ' );
												$start_string        = substr( $title, 0, $last_space_position );

												$title = wp_kses( $start_string, 'post' ) . ' <span class="outsourceo-dot dot-primary">' . wp_kses( $last_word, 'post' ) . '</span>';
											} else {
												$title = '<span class="outsourceo-dot dot-primary">' . wp_kses( $title, 'post' ) . '</span>';
											}

										} else {
											$title = wp_kses( $title, 'post' );
										}

										echo $title; ?></h1>
								<?php }

								if ( ! empty( $desc ) ) { ?>
                                    <h5 class="aheto-banner-slider__desc"><?php echo wp_kses( $desc, 'post' ); ?></h5>
								<?php }

								if ( isset($main_add_button) && $main_add_button ) { ?>
                                    <div class="aheto-banner-slider__links">
										<?php echo Helper::get_button( $this, $banner, 'outsourceo_main_' ); ?>
                                    </div>
								<?php } ?>

                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
			<?php $this->swiper_pagination( 'outsourceo_swiper_' ); ?>
        </div>
		<h6><?php $this->swiper_arrow( 'outsourceo_swiper_' ); ?></h6>
    </div>

</div>
