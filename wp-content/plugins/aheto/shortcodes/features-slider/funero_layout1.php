<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$funero_simple = $this->parse_group( $funero_simple );
$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-content-block--funero-slider-simple' );
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-slider/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'funero-features-slider-layout1', $shortcode_dir . 'assets/css/funero_layout1.css', null, null );
}
/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'          => 1000,
	'autoplay'       => 0,
	'simulate_touch' => 0,
	'loop'           => 1,
	'initial_slide'  => 0,
	'direction'      => 'vertical'
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'funero_swiper_fs_', $carousel_default_params );
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?> >
            <div class="swiper-wrapper">
				<?php foreach ( $funero_simple as $key => $item ): ?>
                    <div class="swiper-slide">
						<?php if ( ! empty( $item['funero_image'] ) ):
							$background_image = Helper::get_background_attachment( $item['funero_image'], $image_size, $atts );
						else:
							$background_image = '';
						endif; ?>
                        <div class="aheto-content-block__image-wrap " <?php echo esc_attr( $background_image ); ?>>
                        </div>
                        <div class="aheto-content-block__text-wrap">
							<?php if ( ! empty( $item['funero_subtitle'] ) ) : ?>
                                <p class="aheto-content-block__subtitle "><?php echo esc_html( $item['funero_subtitle'] ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $item['funero_title'] ) ) : ?>
                                <h6 class="aheto-content-block__title aheto-features-slider__title"><?php echo esc_html( $item['funero_title'] ); ?></h6>
							<?php endif; ?>
							<?php if ( ! empty( $item['funero_desc'] ) ) : ?>
                                <p class="aheto-content-block__desc "><?php echo esc_html( $item['funero_desc'] ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $item['funero_link_title'] ) && ! empty( $item['funero_link_url']['url'] ) ) :

								$button = $this->get_link_attributes( $item['funero_link_url'] );
								$this->add_render_attribute( 'button-' . $key , $button );
								$this->add_render_attribute( 'button-' . $key , 'class', 'aheto-content-block__link' ); ?>
                                <a <?php $this->render_attribute_string( 'button-' . $key ); ?>><?php echo esc_html( $item['funero_link_title'] ); ?></a>
							<?php endif; ?>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
		<?php $this->swiper_pagination( 'funero_swiper_fs_' ); ?>
    </div>
</div>


