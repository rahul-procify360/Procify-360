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

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-tm-wrapper--oursourceo-single' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-testimonials-layout3', $shortcode_dir . 'assets/css/outsourceo_layout3.css', null, null );
}

$atts['outsourceo_image_height'] = 63;
$atts['outsourceo_image_width']  = 63;
$atts['outsourceo_image_crop']   = true;

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>


    <div class="aheto-tm__main-wrap">

        <div class="aheto-tm__content">
			<?php
			// Testimonial.
			if ( isset( $outsourceo_single_testimonial ) ) {
				echo '<p class="aheto-tm__text">' . wp_kses( $outsourceo_single_testimonial, 'post' ) . '</p>';
			} ?>
        </div>

        <div class="aheto-tm__author">

			<?php if ( ! empty( $outsourceo_single_image ) ) :

				$background_image = Helper::get_background_attachment( $outsourceo_single_image, 'custom', $atts, 'outsourceo_' ); ?>

                <div class="aheto-tm__avatar" <?php echo esc_attr( $background_image ); ?>></div>
			<?php endif; ?>

            <div class="aheto-tm__info">
				<?php
				// Name.
				if ( isset( $outsourceo_single_name ) && ! empty( $outsourceo_single_name ) ) {
					echo '<h6 class="aheto-tm__name">' . wp_kses( $outsourceo_single_name, 'post' ) . '</h6>';
				}

				// Company.
				if ( isset( $outsourceo_single_company ) && ! empty( $outsourceo_single_name ) ) {
					echo '<p class="aheto-tm__position">' . wp_kses( $outsourceo_single_company, 'post' ) . '</p>';
				}
				?>
            </div>

        </div>

    </div>


</div>
