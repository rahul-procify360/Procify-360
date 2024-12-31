<?php
/**
 * The Banner Slider Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$banners = $this->parse_group( $banners );

if ( empty( $banners ) ) {
	return '';
}

$additional_class = isset( $this->atts[ 'pagination' ] ) && !empty( $this->atts[ 'pagination' ] ) ? 'banner-pagination' : '';

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-banner-wrap--style-1' );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'effect'   => 'slide',
	'loop'     => 0,
	'autoplay' => 0,
	'arrows'   => true,
	'lazy'     => 0,
	'speed'    => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, '', $carousel_default_params );
$custom_css      = Helper::get_settings( 'general.custom_css_including' );
$custom_css      = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'banner-slider-style-1', $shortcode_dir . 'assets/css/layout1.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="swiper <?php echo esc_attr( $additional_class ); ?>">
        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>
            <div class="swiper-wrapper">

				<?php foreach ( $banners as $banner ) :
					$banner = wp_parse_args( $banner, [
						'image'         => '',
						'video_class'   => 'aheto-banner__video-btn',
						'title'         => '',
						'desc'          => '',
						'align'         => '',
						'btn_direction' => ''
					] );
					extract( $banner );

					$lazy_class       = $lazy ? ' swiper-lazy' : '';
					$background_image = Helper::get_background_attachment( $image, $image_size, $atts, '', $lazy ); ?>

                    <div class="swiper-slide">
                        <div class="banner-slide aheto-full-min-height-js <?php echo esc_attr( $align . ' ' . $lazy_class ); ?>" <?php echo esc_attr( $background_image ); ?>>

                            <div class="aheto-banner__content">
								<?php

                                if ( isset($add_video_button) && $add_video_button ) {

								    echo Helper::get_video_button( $banner );
								}

								if ( ! empty( $title ) ) { ?>
                                    <h2 class="aheto-banner__title"><?php echo wp_kses_post( $title ); ?></h2>
								<?php }

								if ( ! empty( $desc ) ) { ?>
                                    <h5 class="aheto-banner__desc"><?php echo wp_kses_post( $desc ); ?></h5>
								<?php }

								if ( $main_add_button || $add_add_button ) { ?>
                                    <div class="aheto-banner__links">
										<?php
										echo Helper::get_button( $this, $banner, 'main_' );
										echo $btn_direction ? '<br>' : '';
										echo Helper::get_button( $this, $banner, 'add_' ); ?>
                                    </div>
								<?php } ?>
                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
			<?php $this->swiper_pagination(); ?>
        </div>
		<?php $this->swiper_arrow(); ?>
    </div>
</div>
