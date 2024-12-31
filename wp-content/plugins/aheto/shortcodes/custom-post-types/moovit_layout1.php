<?php

use Aheto\Helper;

extract( $atts );

$atts['layout'] = 'slider';

// Query.
$the_query = $this->get_wp_query();

if ( ! $the_query->have_posts() ) {
	return;
}

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--moovit-modern' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'     => 500,
	'slides'    => 3,
	'slides_md' => 2,
	'slides_xs' => 1,
	'space'     => 30
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'moovit_swiper_', $carousel_default_params );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-custom-post-types-layout1', $shortcode_dir . 'assets/css/moovit_layout1.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">

        <div class="moovit-shape">
			<?php if ( $moovit_background_type == 'image' && ! empty( $moovit_image ) ) :
				echo Helper::get_attachment( $moovit_image, [ 'class' => 'js-bg' ] );
			endif; ?>
        </div>

        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>

            <div class="swiper-wrapper">

				<?php
				$this->add_excerpt_filter();

				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					?>
                    <div class="swiper-slide">

						<?php $this->get_skin_part( $skin, $atts ); ?>

                    </div>
				<?php
				endwhile;

				$this->remove_excerpt_filter();

				wp_reset_query(); ?>

            </div>

        </div>

		<h6><?php if ( !empty( $this->atts[ 'moovit_swiper_arrows' ] ) && isset( $this->atts[ 'moovit_swiper_arrows_style' ] ) && $this->atts[ 'moovit_swiper_arrows_style' ] === 'number' ) {
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

	<?php if ( ! empty( $moovit_small_image ) ) : ?>
        <div class="aheto-cpt__small-image">
			<?php echo Helper::get_attachment( $moovit_small_image, array(), 'medium' ); ?>
        </div>
	<?php endif; ?>

</div>
