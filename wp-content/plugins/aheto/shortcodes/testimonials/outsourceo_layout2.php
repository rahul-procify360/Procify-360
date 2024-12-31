<?php
/**
 * The Testimonials Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$outsourceo_testimonials_creative_item = $this->parse_group( $outsourceo_testimonials_creative_item );
if ( empty( $outsourceo_testimonials_creative_item ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-tm-wrapper--oursourceo-creative' );

$outsourceo_dark_version = isset( $outsourceo_dark_version ) && $outsourceo_dark_version ? 'dark-version' : '';
$this->add_render_attribute( 'wrapper', 'class', $outsourceo_dark_version );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'    => 1000,
	'autoplay' => false,
	'spaces'   => 30,
	'slides'   => 3,
	'arrows'   => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'outsourceo_swiper_', $carousel_default_params );

$atts['outsourceo_image_height'] = 63;
$atts['outsourceo_image_width']  = 63;
$atts['outsourceo_image_crop']   = true;

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-testimonials-layout2', $shortcode_dir . 'assets/css/outsourceo_layout2.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('outsourceo-testimonials-layout2-js', $shortcode_dir . 'assets/js/outsourceo_layout2.min.js', array('jquery'), null);
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $outsourceo_bg_text ) ) { ?>
        <div class="aheto-tm__bg-text"><?php echo esc_html( $outsourceo_bg_text ); ?></div>
	<?php } ?>

    <div class="swiper">

        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>

            <div class="swiper-wrapper">

				<?php foreach ( $outsourceo_testimonials_creative_item as $item ) : ?>

                    <div class="swiper-slide">

                        <div class="aheto-tm__slide-wrap">

                            <div class="aheto-tm__content">
								<?php
								// Testimonial.
								if ( isset( $item['outsourceo_testimonial'] ) && ! empty( $item['outsourceo_testimonial'] ) ) {
									echo '<h4 class="aheto-tm__text">' . wp_kses( $item['outsourceo_testimonial'], 'post') . '</h4>';
								} ?>
                            </div>

                            <div class="aheto-tm__author">

								<?php if ( ! empty( $item['outsourceo_image'] ) ) :

									$background_image = Helper::get_background_attachment( $item['outsourceo_image'], 'custom', $atts, 'outsourceo_' ); ?>

                                    <div class="aheto-tm__avatar" <?php echo esc_attr( $background_image ); ?>></div>

								<?php endif; ?>

                                <div class="aheto-tm__info">
									<?php
									// Name.
									if ( isset( $item['outsourceo_name'] ) && ! empty( $item['outsourceo_name'] ) ) {
										echo '<h5 class="aheto-tm__name">' . wp_kses( $item['outsourceo_name'], 'post' ) . '</h5>';
									}

									// Company.
									if ( isset( $item['outsourceo_company'] ) && ! empty( $item['outsourceo_company'] ) ) {
										echo '<p class="aheto-tm__position">' . wp_kses( $item['outsourceo_company'], 'post' ) . '</p>';
									}
									?>
                                </div>

                            </div>

                        </div>

                    </div>

				<?php endforeach; ?>

            </div>

	        <?php $this->swiper_pagination( 'outsourceo_swiper_' ); ?>

        </div>

    </div>

</div>
