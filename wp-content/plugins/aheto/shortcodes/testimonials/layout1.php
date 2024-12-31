<?php
/**
 * The Testimonials Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$testimonials = $this->parse_group( $testimonials );
if ( empty( $testimonials ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-tm-wrapper' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-tm-wrapper--classic' );

// Swiper.
if ( ! $custom_options ) {
	$speed  = 500;
	$space  = 30;
	$slides = 3;
	$large  = 3;
	$medium = 2;
	$small  = 1;
}

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

$carousel_params = Helper::get_carousel_params( $atts, '', $carousel_default_params );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'testimonials-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">

        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>

            <div class="swiper-wrapper">

				<?php foreach ( $testimonials as $item ) : ?>

                    <div class="swiper-slide">

                        <div class="aheto-tm aheto-tm__classic">

                            <div class="aheto-tm__author">

								<?php if ( $item['g_image'] ) :
									$background_image = Helper::get_background_attachment( $item['g_image'], $image_size, $atts ); ?>
                                    <div class="aheto-tm__avatar" <?php echo esc_attr( $background_image ); ?>></div>
								<?php endif; ?>

                                <div class="aheto-tm__info">
									<?php
									// Name.
									if ( isset( $item['g_name'] ) ) {
										echo '<h6 class="aheto-tm__name">' . wp_kses_post( $item['g_name'] ) . '</h6>';
									}

									// Company.
									if ( isset( $item['g_company'] ) ) {
										echo '<p class="aheto-tm__position">' . wp_kses_post( $item['g_company'] ) . '</p>';
									}
									?>
                                </div>

                            </div>

                            <div class="aheto-tm__content">
								<?php
								// Testimonial.
								if ( isset( $item['g_testimonial'] ) ) {
									echo '<p class="aheto-tm__text">' . wp_kses_post( $item['g_testimonial'] ) . '</p>';
								}

								// Rating.
								if ( isset( $item['g_rating'] ) ) {
									echo '<p class="aheto-tm__stars">';
									for ( $i = 1; $i <= $item['g_rating']; $i ++ ) {
										echo '<i class="ion ion-ios-star"></i>';
									}
									if ( $item['g_rating'] != floor( $item['g_rating'] ) ) {
										echo '<i class="ion ion ion-ios-star-half"></i>';
									}
									for ( $i = $item['g_rating'] + 1; $i <= 5; $i ++ ) {
										echo '<i class="ion ion-ios-star-outline"></i>';
									}
									echo '</p>';
								}
								?>
                            </div>

                        </div>

                    </div>

				<?php endforeach; ?>

            </div>

			<?php $this->swiper_pagination(); ?>

        </div>

		<?php $this->swiper_arrow(); ?>

    </div>

</div>
