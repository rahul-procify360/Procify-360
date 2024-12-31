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

$outsourceo_testimonial_item = $this->parse_group( $outsourceo_testimonial_item );
if ( empty( $outsourceo_testimonial_item ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-tm-wrapper--modern' );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'      => 1500,
	'autoplay'   => false,
	'spaces'     => 25,
	'slides'     => 3,
	'pagination' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'outsourceo_swiper_', $carousel_default_params );

$atts['outsourceo_image_height'] = 70;
$atts['outsourceo_image_width']  = 70;
$atts['outsourceo_image_crop']   = true;

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-testimonials-layout1', $shortcode_dir . 'assets/css/outsourceo_layout1.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">

        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>

            <div class="swiper-wrapper">

				<?php foreach ( $outsourceo_testimonial_item as $item ) : ?>

                    <div class="swiper-slide">

                        <div class="aheto-tm aheto-tm__modern">


                            <div class="aheto-tm__content">

								<?php
								// Testimonial.
								if ( isset( $item['g_blockquote'] ) && ! empty( $item['g_blockquote'] ) ) {
									echo '<h5 class="aheto-tm__blockquote">' . wp_kses( $item['g_blockquote'], 'post' ) . '</h5>';
								} ?>

								<?php
								// Testimonial.
								if ( isset( $item['g_testimonial'] ) && ! empty( $item['g_testimonial'] ) ) {
									echo '<p class="aheto-tm__text">' . wp_kses( $item['g_testimonial'], 'post' ) . '</p>';
								} ?>

                            </div>

                            <div class="aheto-tm__author">

								<?php if ( ! empty( $item['g_image'] ) ) : ?>
                                    <div class="aheto-tm__avatar">
										<?php echo Helper::get_attachment( $item['g_image'], [], 'custom', $atts, 'outsourceo_' ); ?>
                                    </div>
								<?php endif; ?>

                                <div class="aheto-tm__info">
									<?php
									// Name.
									if ( isset( $item['g_name'] ) && ! empty( $item['g_name'] ) ) {
										echo '<h5 class="aheto-tm__name">' . wp_kses( $item['g_name'], 'post' ) . '</h5>';
									}

									// Company.
									if ( isset( $item['g_company'] ) && ! empty( $item['g_company'] ) ) {
										echo '<p class="aheto-tm__position">' . wp_kses( $item['g_company'], 'post' ) . '</p>';
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

		<?php $this->swiper_arrow( 'outsourceo_swiper_' ); ?>

    </div>

</div>
