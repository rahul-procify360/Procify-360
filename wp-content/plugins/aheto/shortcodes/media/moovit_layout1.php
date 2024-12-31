<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$slides = $this->parse_group( $moovit_modern_items );

if ( empty( $slides ) ) {
	return '';
}

if ( ! $moovit_swiper_custom_options ) {
	$speed  = 1000;
	$effect = 'fade';
	$loop   = false;
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-media--moovit-modern' );


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1500,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'moovit_swiper_', $carousel_default_params );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-media-layout1', $shortcode_dir . 'assets/css/moovit_layout1.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>


	<?php if ( ! empty( $moovit_left_small_image ) ) : ?>

        <div class="aheto-media__left-image">
			<?php echo Helper::get_attachment( $moovit_left_small_image ); ?>
        </div>

	<?php endif; ?>

    <div class="swiper">

		<?php $background_shape = $moovit_background_type == 'image' && ! empty( $moovit_image ) ? Helper::get_background_attachment( $moovit_image, 'full' ) : ''; ?>

        <div class="moovit-shape" <?php echo esc_attr( $background_shape ); ?>></div>

        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>
            <div class="swiper-wrapper">
				<?php foreach ( $slides as $slide ) :
					$slide = wp_parse_args( $slide, [
						'moovit_item_video_image' => '',
						'moovit_add_video_button' => '',
					] );
					extract( $slide );

					if ( ! $moovit_item_video_image ) {
						continue;
					}

					$swiper_lazy_class = $moovit_swiper_lazy ? ' swiper-lazy' : '';
					$background_image  = Helper::get_background_attachment( $moovit_item_video_image, $moovit_image_size, $atts, 'moovit_', $moovit_swiper_lazy ); ?>
                    <div class="swiper-slide">
                        <div class="aheto-media-slider-wrap<?php echo esc_attr( $swiper_lazy_class ); ?>" <?php echo esc_attr( $background_image ); ?>>
							<?php if ( $moovit_add_video_button ) {

								echo Helper::get_video_button( $slide, 'moovit_' );

							} ?>
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

	<?php if ( ! empty( $moovit_right_small_image ) ) : ?>

        <div class="aheto-media__right-image">

			<?php echo Helper::get_attachment( $moovit_right_small_image ); ?>

        </div>

	<?php endif; ?>


</div>
