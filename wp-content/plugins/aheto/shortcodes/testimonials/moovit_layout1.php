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

$moovit_testimonials = $this->parse_group( $moovit_testimonials );
if ( empty( $moovit_testimonials ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-tm-wrapper--moovit-modern' );

$moovit_dark_version = isset( $moovit_dark_version ) && $moovit_dark_version ? 'dark-version' : '';
$this->add_render_attribute( 'wrapper', 'class', $moovit_dark_version );

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

$carousel_params             = Helper::get_carousel_params( $atts, 'moovit_swiper_', $carousel_default_params );
$atts['moovit_image_height'] = 63;
$atts['moovit_image_width']  = 63;
$atts['moovit_image_crop']   = true;

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-testimonials-layout1', $shortcode_dir . 'assets/css/moovit_layout1.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('moovit-testimonials-layout1-js', $shortcode_dir . 'assets/js/moovit_layout1.min.js', array('jquery'), null);
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $moovit_bg_text ) ) { ?>
        <div class="aheto-tm__bg-text"><?php echo esc_html( $moovit_bg_text ); ?></div>
	<?php } ?>

    <div class="swiper">

        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>

            <div class="swiper-wrapper">

				<?php foreach ( $moovit_testimonials as $item ) : ?>

                    <div class="swiper-slide">

                        <div class="aheto-tm__slide-wrap">

                            <div class="aheto-tm__content">
								<?php
								// Testimonial.
								if ( isset( $item['moovit_testimonial'] ) && ! empty( $item['moovit_testimonial'] ) ) {
									echo '<h4 class="aheto-tm__text">' . wp_kses( $item['moovit_testimonial'], 'post' ) . '</h4>';
								} ?>
                            </div>

                            <div class="aheto-tm__author">

								<?php if ( ! empty( $item['moovit_image'] ) ) :

									$background_image = Helper::get_background_attachment( $item['moovit_image'], 'custom', $atts, 'moovit_' ); ?>

                                    <div class="aheto-tm__avatar" <?php echo esc_attr( $background_image ); ?>></div>
								<?php endif; ?>

                                <div class="aheto-tm__info">
									<?php
									// Name.
									if ( isset( $item['moovit_name'] ) && ! empty( $item['moovit_name'] ) ) {

                                        if ( isset($moovit_use_dot) && $moovit_use_dot ) {

                                            $item['moovit_name'] = str_replace( '{{.}}', '<span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '"></span>', $item['moovit_name'] );

                                            $words = explode( " ", $item['moovit_name'] );

                                            if ( count( $words ) > 0 ) {
                                                $last_word = $words[ count( $words ) - 1 ];

                                                $last_space_position = strrpos( $item['moovit_name'], ' ' );
                                                $start_string        = substr( $item['moovit_name'], 0, $last_space_position );

                                                $item['moovit_name'] =  wp_kses( $start_string, 'post' ) . ' <span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '">' . wp_kses( $last_word, 'post' ) . '</span>';
                                            } else {
                                                $item['moovit_name'] = '<span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '">' . wp_kses( $item['moovit_name'], 'post' ) . '</span>';
                                            }

                                        } else {
                                            $item['moovit_name'] = wp_kses( $item['moovit_name'], 'post' );
                                        }

										echo '<h5 class="aheto-tm__name">' . wp_kses( $item['moovit_name'], 'post' ) . '</h5>';
									}

									// Company.
									if ( isset( $item['moovit_company'] ) && ! empty( $item['moovit_company'] ) ) {
										echo '<h6 class="aheto-tm__position">' . wp_kses( $item['moovit_company'], 'post' ) . '</h6>';
									} ?>
                                </div>

                            </div>

                        </div>

                    </div>

				<?php endforeach; ?>

            </div>

        </div>

    </div>

</div>
