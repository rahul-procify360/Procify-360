<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$slides = $this->parse_group( $outsourceo_creative_items );

if ( empty( $slides ) ) {
	return '';
}

$outsourceo_creative_version = isset( $outsourceo_creative_version ) && $outsourceo_creative_version ? 'creative-version' : '';
$outsourceo_br_buttons = isset( $outsourceo_br_buttons ) && $outsourceo_br_buttons ? 'remove-br' : '';


$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--outsourceo-creative-slider' );
$this->add_render_attribute( 'wrapper', 'class', $outsourceo_creative_version );


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = \Aheto\Helper::get_carousel_params( $atts, 'outsourceo_swiper_', $carousel_default_params );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-contents-layout2', $shortcode_dir . 'assets/css/outsourceo_layout2.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-contents--shape"></div>
    <div class="swiper">
        <div class="swiper-container aheto-contents-swiper-left" <?php echo esc_attr( $carousel_params ); ?>>
            <div class="swiper-wrapper">
				<?php foreach ( $slides as $slide_left ) :
					$slide_left = wp_parse_args( $slide_left, [
						'outsourceo_item_image' => '',
					] );
					extract( $slide_left );

					if ( ! $outsourceo_item_image ) {
						continue;
					}

					$swiper_lazy_class = $outsourceo_swiper_lazy ? ' swiper-lazy' : '';
					$background_image  = Aheto\Helper::get_background_attachment( $outsourceo_item_image, $outsourceo_image_size, $atts, 'outsourceo_', $outsourceo_swiper_lazy ); ?>


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
						'outsourceo_item_title'         => '',
						'outsourceo_item_desc'          => '',
						'outsourceo_item_btn_direction' => ''
					] );
					extract( $slide_right );
					?>
                    <div class="swiper-slide">
                        <div class="aheto-contents-slider-wrap">

                            <div class="aheto-contents-slider__content">
								<?php if ( ! empty( $outsourceo_item_title ) ) { ?>
                                    <h2 class="aheto-contents__title"><?php

										if ( $outsourceo_item_use_dot ) {

											$outsourceo_item_title = str_replace( '{{.}}', '<span class="outsourceo-dot dot-' . esc_attr( $outsourceo_item_dot_color ) . '"></span>', $outsourceo_item_title );

											$words = explode( " ", $outsourceo_item_title );

											if ( count( $words ) > 0 ) {
												$last_word = $words[ count( $words ) - 1 ];

												$last_space_position = strrpos( $outsourceo_item_title, ' ' );
												$start_string        = substr( $outsourceo_item_title, 0, $last_space_position );

												$outsourceo_item_title = wp_kses( $start_string, 'post' ) . ' <span class="outsourceo-dot dot-' . esc_attr( $outsourceo_item_dot_color ) . '">' . wp_kses( $last_word, 'post' ) . '</span>';
											} else {
												$outsourceo_item_title = '<span class="outsourceo-dot dot-' . esc_attr( $outsourceo_item_dot_color ) . '">' . wp_kses( $outsourceo_item_title, 'post' ) . '</span>';
											}

										} else {
											$outsourceo_item_title = wp_kses( $outsourceo_item_title, 'post' );
										}

										echo $outsourceo_item_title; ?></h2>
								<?php }

								if ( ! empty( $outsourceo_item_desc ) ) { ?>
                                    <p class="aheto-contents__desc"><?php echo wp_kses( $outsourceo_item_desc, 'post' ); ?></p>
								<?php }

								if ( $outsourceo_main_add_button || $outsourceo_add_add_button ) { ?>
                                    <div class="aheto-contents__links">
										<?php
										echo \Aheto\Helper::get_button( $this, $slide_right, 'outsourceo_main_' );
										if ( $outsourceo_item_btn_direction ) { ?>
                                            <br>
										<?php }
										echo \Aheto\Helper::get_button( $this, $slide_right, 'outsourceo_add_' ); ?>
                                    </div>
								<?php } ?>
                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
	    <?php

	    if ( ! empty( $outsourceo_creative_version ) ) { ?>
            <h6 class="arrow-wrap <?php echo esc_attr($outsourceo_br_buttons); ?>">
				<?php if ( !empty( $this->atts[ 'outsourceo_swiper_arrows' ] ) && isset( $this->atts[ 'outsourceo_swiper_arrows_style' ] ) && $this->atts[ 'outsourceo_swiper_arrows_style' ] === 'number' ) {
                $span_prev  = '<span class="swiper-slides-prev"></span> ';
                $span_total = '<span class="swiper-slides-total"></span>';
                $span_next  = '<span class="swiper-slides-next"></span> ';

                echo '<span class="swiper-button-prev swiper-button-prev--number">' . $span_prev . $span_total . '</span><span class="swiper-button-next swiper-button-next--number">' . $span_next . $span_total . '</span>';
            }elseif( !empty( $this->atts[ 'outsourceo_swiper_arrows' ] ) && isset( $this->atts[ 'outsourceo_swiper_arrows_style' ] ) && $this->atts[ 'outsourceo_swiper_arrows_style' ] === 'number_zero' ){
                $span_prev  = '<span class="swiper-slides-prev"></span> ';
                $span_total = '<span class="swiper-slides-total"></span>';
                $span_next  = '<span class="swiper-slides-next"></span> ';

                echo '<span class="swiper-button-prev swiper-button-prev--number-zero">' . $span_prev . $span_total . '</span><span class="swiper-button-next swiper-button-next--number-zero">' . $span_next . $span_total . '</span>';

            }elseif(!empty( $this->atts[ 'outsourceo_swiper_arrows' ] )){
                echo '<span class="swiper-button-prev"></span><span class="swiper-button-next"></span>';
            } ?></h6>
	    <?php } else {
		    $this->swiper_arrow( 'outsourceo_swiper_' );
	    } ?>
    </div>

</div>
