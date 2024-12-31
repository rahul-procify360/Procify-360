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

// Button.
$button = $this->get_button_attributes( 'link' );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-features-single-layout4', $shortcode_dir . 'assets/css/outsourceo_layout4.css', null, null );
}
if (  !Helper::is_Elementor_Live()) {
	wp_enqueue_script('outsourceo-features-single-layout4-js', $shortcode_dir . 'assets/js/outsourceo_layout4.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php $background_image = ! empty( $s_image ) ? Helper::get_background_attachment( $s_image, $outsourceo_image_size, $atts, 'outsourceo_' ) : ''; ?>

    <div class="aheto-content-block t-center aheto-content-block--light aheto-content-block--outsourceo-bgImg aheto-content--outsourceo-with-background s-back-switch" <?php echo esc_attr( $background_image ); ?>>

        <div class="aheto-content-block__descr">

			<?php if ( ! empty( $s_heading ) ) : ?>
                <h4 class="aheto-content-block__title t-light"><?php echo wp_kses( $this->highlight_text( $s_heading ), 'post' ); ?></h4>
			<?php endif; ?>

            <div class="aheto-content-block__info">

				<?php if ( ! empty( $s_description ) ) : ?>
                    <p class="aheto-content-block__info-text">
						<?php echo wp_kses( $s_description, 'post' ); ?>
                    </p>
				<?php endif; ?>

            </div>

			<?php if ( ! empty( $outsourceo_link_url ) && ! empty( $outsourceo_link_text ) ) : ?>
                <div class="aheto-btn-container t-center">
                    <a href="<?php echo esc_url( $outsourceo_link_url ) ?>"
                       class="aheto-link aheto-btn--primary aheto-btn--no-underline">
                        <i class="ion-android-arrow-dropright aheto-btn__icon--left"></i>
						<?php echo esc_html( $outsourceo_link_text ); ?>
                    </a>
                </div>
			<?php endif; ?>

        </div>

    </div>

</div>

