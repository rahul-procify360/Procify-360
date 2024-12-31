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

$banners = $this->parse_group( $moovit_creative_banners );

if ( empty( $banners ) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-banner-slider--moovit-creative' );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'moovit_swiper_', $carousel_default_params );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-banner-slider-layout2', $shortcode_dir . 'assets/css/moovit_layout2.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>
            <div class="swiper-wrapper">
				<?php foreach ( $banners as $banner ) :
					$banner = wp_parse_args( $banner, [
						'moovit_image'         => '',
						'moovit_add_image'     => '',
						'moovit_title'         => '',
						'moovit_use_dot'       => '',
						'align'         => '',
						'moovit_btn_direction' => ''
					] );
					extract( $banner );

					$swiper_lazy_class = $moovit_swiper_lazy ? ' swiper-lazy' : '';
					$background_image  = ! empty( $moovit_image ) ? Helper::get_background_attachment( $moovit_image, 'full', $atts, '', $moovit_swiper_lazy ) : ''; ?>
                    <div class="swiper-slide aheto-full-min-height-js">
                        <div class="aheto-banner-slider-wrap <?php echo esc_attr( $align . $swiper_lazy_class ); ?>" <?php echo esc_attr( $background_image ); ?>>

                            <div class="aheto-banner-slider__content">

	                            <?php if (is_array($moovit_add_image) && !empty($moovit_add_image[0]) || !is_array($moovit_add_image) && $moovit_add_image) :
		                            if ($moovit_swiper_lazy) :
			                            echo Helper::get_attachment_for_swiper($moovit_add_image, ['class' => 'aheto-banner-slider__add-image swiper-lazy'], $moovit_image_size);
		                            else :
			                            echo Helper::get_attachment($moovit_add_image, ['class' => 'aheto-banner-slider__add-image'], $moovit_image_size, $atts, 'moovit_');
		                            endif;
	                            endif;

								if ( ! empty( $moovit_title ) ) {


									if ( $moovit_use_dot ) {

										$moovit_title = str_replace( '{{.}}', '<span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '"></span>', $moovit_title );

										$words = explode( " ", $moovit_title );

										if ( count( $words ) > 0 ) {
											$last_word = $words[ count( $words ) - 1 ];

											$last_space_position = strrpos( $moovit_title, ' ' );
											$start_string        = substr( $moovit_title, 0, $last_space_position );

											$moovit_title = wp_kses( $start_string, 'post' ) . ' <span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '">' . wp_kses( $last_word, 'post' ) . '</span>';
										} else {
											$moovit_title = '<span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '">' . wp_kses( $moovit_title, 'post' ) . '</span>';
										}

									} else {
										$moovit_title = wp_kses( $moovit_title, 'post' );
									} ?>
                                    <h1 class="aheto-banner__title"><?php echo $moovit_title; ?></h1>
								<?php }

								if ( $moovit_main_add_button ) { ?>
                                    <div class="aheto-banner-slider__links">
										<?php echo Helper::get_button( $this, $banner, 'moovit_main_' ); ?>
                                    </div>
								<?php } ?>
                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
        <h6 class="moovit-swiper-arrows-wrap">
		    <?php if ( !empty( $this->atts[ 'moovit_swiper_arrows' ] ) && isset( $this->atts[ 'moovit_swiper_arrows_style' ] ) && $this->atts[ 'moovit_swiper_arrows_style' ] === 'number' ) {
			    $span_prev  = '<span class="swiper-slides-prev"></span> ';
			    $span_total = '<span class="swiper-slides-total"></span>';
			    $span_next  = '<span class="swiper-slides-next"></span> ';

			    echo '<span class="swiper-button-prev swiper-button-prev--number">' . $span_prev . $span_total . '</span><span class="swiper-button-next swiper-button-next--number">' . $span_next . $span_total . '</span>';
		    }elseif( !empty( $this->atts[ 'moovit_swiper_arrows' ] ) && isset( $this->atts[ 'moovit_swiper_arrows_style' ] ) && $this->atts[ 'moovit_swiper_arrows_style' ] === 'number_zero' ){
			    $span_prev  = '<span class="swiper-slides-prev"></span> ';
			    $span_total = '<span class="swiper-slides-total"></span>';
			    $span_next  = '<span class="swiper-slides-next"></span> ';

			    echo '<span class="swiper-button-prev swiper-button-prev--number-zero">' . $span_prev . $span_total . '</span><span class="swiper-button-next swiper-button-next--number-zero">' . $span_next . $span_total . '</span>';

		    }elseif(!empty( $this->atts[ 'moovit_swiper_arrows' ] )){
			    echo '<span class="swiper-button-prev"></span><span class="swiper-button-next"></span>';
		    } ?>
        </h6>
    </div>
</div>
