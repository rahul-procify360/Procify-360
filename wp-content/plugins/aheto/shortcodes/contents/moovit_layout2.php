<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$slides = $this->parse_group( $moovit_creative_items );

if ( empty( $slides ) ) {
	return '';
}

$moovit_creative_version = isset( $moovit_creative_version ) && $moovit_creative_version ? 'creative-version' : '';

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--moovit-creative-slider' );
$this->add_render_attribute( 'wrapper', 'class', $moovit_creative_version );


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
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-contents-layout2', $shortcode_dir . 'assets/css/moovit_layout2.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-contents--shape"></div>
    <div class="swiper">
        <div class="swiper-container aheto-contents-swiper-left" <?php echo esc_attr( $carousel_params ); ?>>
            <div class="swiper-wrapper">
				<?php foreach ( $slides as $slide_left ) :
					$slide_left = wp_parse_args( $slide_left, [
						'moovit_item_image' => '',
					] );
					extract( $slide_left );

					if ( ! $moovit_item_image ) {
						continue;
					}

					$swiper_lazy_class = $moovit_swiper_lazy ? ' swiper-lazy' : '';
					$background_image  = Helper::get_background_attachment( $moovit_item_image, $moovit_image_size, $atts, 'moovit_', $moovit_swiper_lazy ); ?>
                    <div class="swiper-slide">
                        <div class="aheto-contents-slider-wrap<?php echo esc_attr( $swiper_lazy_class ); ?>" <?php echo esc_attr( $background_image ); ?>></div>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
        <div class="swiper-container aheto-contents-swiper-right" <?php echo esc_attr( $carousel_params ); ?>
             data-thumbs="1">
            <div class="swiper-wrapper">
				<?php foreach ( $slides as $slide_right ) :
					$slide_right = wp_parse_args( $slide_right, [
						'moovit_item_title'         => '',
						'moovit_item_desc'          => '',
						'moovit_item_btn_direction' => ''
					] );
					extract( $slide_right );
					?>
                    <div class="swiper-slide">
                        <div class="aheto-contents-slider-wrap">

                            <div class="aheto-contents-slider__content">
								<?php if ( ! empty( $moovit_item_title ) ) {

									if ( $moovit_item_use_dot ) {

										$moovit_item_title = str_replace( '{{.}}', '<span class="moovit-dot dot-' . esc_attr( $moovit_item_dot_color ) . '"></span>', $moovit_item_title );

										$words = explode( " ", $moovit_item_title );

										if ( count( $words ) > 0 ) {
											$last_word = $words[ count( $words ) - 1 ];

											$last_space_position = strrpos( $moovit_item_title, ' ' );
											$start_string        = substr( $moovit_item_title, 0, $last_space_position );

											$moovit_item_title =  wp_kses( $start_string, 'post' ) . ' <span class="moovit-dot dot-' . esc_attr( $moovit_item_dot_color ) . '">' . wp_kses( $last_word, 'post' ) . '</span>';
										} else {
											$moovit_item_title =  '<span class="moovit-dot dot-' . esc_attr( $moovit_item_dot_color ) . '">' . wp_kses( $moovit_item_title, 'post' ) . '</span>';
										}

									} else {
										$moovit_item_title = wp_kses( $moovit_item_title, 'post' );
									} ?>

                                    <h2 class="aheto-contents__title"><?php echo $moovit_item_title; ?></h2>
								<?php }

								if ( ! empty( $moovit_item_desc ) ) { ?>
                                    <p class="aheto-contents__desc"><?php echo wp_kses( $moovit_item_desc, 'post' ); ?></p>
								<?php }

								if ( $moovit_main_add_button || $moovit_add_add_button ) { ?>
                                    <div class="aheto-contents__links">
										<?php
										echo Helper::get_button( $this, $slide_right, 'moovit_main_' );

										if ( $moovit_item_btn_direction ) { ?>
                                            <br>
										<?php }


										echo Helper::get_button( $this, $slide_right, 'moovit_add_' ); ?>
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
