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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-tm-wrapper--moovit-classic' );

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
	wp_enqueue_style( 'moovit-testimonials-layout2', $shortcode_dir . 'assets/css/moovit_layout2.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>


	<?php foreach ( $moovit_testimonials as $item ) : ?>


        <div class="aheto-tm__slide-wrap">

            <div class="aheto-tm__content">
				<?php
				// Testimonial.
				if ( isset( $item['moovit_testimonial'] ) && ! empty( $item['moovit_testimonial'] ) ) {
					echo '<p class="aheto-tm__text">' . wp_kses( $item['moovit_testimonial'], 'post' ) . '</p>';
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
						echo '<h5 class="aheto-tm__name">' . wp_kses( $item['moovit_name'], 'post' ) . '</h5>';
					}

					// Company.
					if ( isset( $item['moovit_company'] ) && ! empty( $item['moovit_company'] ) ) {
						echo '<h6 class="aheto-tm__position">' . wp_kses( $item['moovit_company'], 'post' ) . '</h6>';
					} ?>
                </div>
            </div>
        </div>

	<?php endforeach; ?>

</div>
