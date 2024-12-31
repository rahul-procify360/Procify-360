<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$sliders = $this->parse_group( $slider );
if ( empty( $sliders ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-features-slider--simple' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, '', $carousel_default_params );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/features-slider/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'features-slider-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>

            <div class="swiper-wrapper">

				<?php foreach ( $sliders as $index => $item ) : ?>

                    <div class="swiper-slide">

                        <div class="aheto-features-slider aheto-features-slider--slider t-center">

							<?php if ( $item['number'] ) : ?>
                                <div class="aheto-features-slider__number"><?php echo wp_kses_post( $item['number'] ); ?></div>
							<?php endif; ?>

                            <div class="aheto-features-slider__descr">

								<?php if ( $item['icon'] ) : ?>
                                    <i class="aheto-features-slider__ico aheto-features-slider__ico--lg icon ti-<?php echo $item['icon']; ?>"></i>
								<?php endif; ?>

								<?php if ( $item['heading'] ) : ?>
                                    <h4 class="aheto-features-slider__title"><?php echo wp_kses_post( $item['heading'] ); ?></h4>
								<?php endif; ?>

								<?php if ( $item['description'] ) : ?>
                                    <div class="aheto-features-slider__info">
                                        <p class="aheto-features-slider__info-text"><?php echo wp_kses_post( $item['description'] ); ?></p>
                                    </div>
								<?php endif; ?>

                            </div>

                        </div>

                    </div>

				<?php endforeach; ?>

            </div>

        </div>

		<?php $this->swiper_arrow(); ?>
    </div>

</div>
