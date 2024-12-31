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

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Block Wrapper.
$this->add_render_attribute( 'block_wrapper', 'class', 'aheto-features--outsourceo-creative' );

$outsourceo_overlay  = isset( $outsourceo_overlay ) && ! empty( $outsourceo_overlay ) ? 'overlay-show' : '';
$outsourceo_link_url = isset( $outsourceo_link_url ) && ! empty( $outsourceo_link_url ) ? $outsourceo_link_url : '#';


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-features-single-layout2', $shortcode_dir . 'assets/css/outsourceo_layout2.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div <?php $this->render_attribute_string( 'block_wrapper' ); ?>>

        <a href="<?php echo esc_url( $outsourceo_link_url ); ?>">

			<?php $background_image = \Aheto\Helper::get_background_attachment( $s_image, $outsourceo_image_size, $atts, 'outsourceo_' ); ?>

            <div class="aheto-features-block__wrap s-back-switch <?php echo esc_attr( $outsourceo_overlay ); ?>" <?php echo esc_attr( $background_image ); ?>>
				<?php if ( $outsourceo_overlay ) : ?>
                    <span class="aheto-features-block__overlay"
                          style="background-color: <?php echo esc_attr( $outsourceo_overlay_color ); ?>;"></span>
				<?php endif; ?>

				<?php if ( ! empty( $s_heading ) || ! empty( $s_description ) || ! empty( $outsourceo_logo_image ) ) : ?>
                    <div class="aheto-features-block__info">
						<?php if ( ! empty( $outsourceo_logo_image ) ) : ?>
                            <div class="aheto-features-block__image-logo">
								<?php echo \Aheto\Helper::get_attachment( $outsourceo_logo_image, [], $outsourceo_logo_image_size, $atts, 'outsourceo_logo_' ); ?>
                            </div>
						<?php endif; ?>

						<?php if ( ! empty( $s_description ) ) : ?>
                            <h6 class="aheto-features-block__text">
								<?php echo wp_kses( $s_description, 'post' ); ?>
                            </h6>
						<?php endif;

						if ( ! empty( $s_heading ) ) : ?>
                            <h6 class="aheto-features-block__title"><?php echo esc_html( $s_heading ); ?></h6>
						<?php endif; ?>
                    </div>
				<?php endif; ?>

            </div>
        </a>

    </div>

</div>
