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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--karma-political__slider' );
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

$carousel_params = Helper::get_carousel_params( $atts, 'karma_political_swiper_', $carousel_default_params );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'karma-political-custom-post-types-layout1', $shortcode_dir . 'assets/css/karma_political_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">

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

					wp_reset_query();
				?>

            </div>

        </div>

        <?php if ( !empty( $this->atts[ 'karma_political_swiper_pagination' ] ) ) { ?>

		    <?php $this->swiper_pagination( 'karma_political_swiper_' ); ?>

        <?php } ?>

        <?php if ( ! empty( $this->atts[ 'karma_political_swiper_arrows' ] ) ) { ?>

    		<?php $this->swiper_arrow( 'karma_political_swiper_' ); ?>

        <?php } ?>

    </div>

	<?php if ( ! empty( $karma_political_small_image ) ) : ?>
        <div class="aheto-cpt__small-image">
			<?php echo Helper::get_attachment( $karma_political_small_image, array(), 'medium' ); ?>
        </div>
	<?php endif; ?>

</div>
