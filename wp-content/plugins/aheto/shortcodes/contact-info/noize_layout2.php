<?php
/**
 * Contact Info default templates.
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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact-info--noize-lay2' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$underline   = isset( $underline ) && $underline ? 'underline' : '';
$title_space = isset( $title_space ) && $title_space ? 'smaller-space' : '';

$this->add_render_attribute( 'title', 'class', 'noize__title' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'noize-contact-info-layout2', $shortcode_dir . 'assets/css/noize_layout2.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-contact-info--content">

        <?php if ( ! empty( $noize_address ) ) : ?>
            <div class="aheto-contact-info--address">
                <p class="aheto-contact-info--link-address"><?php echo wp_kses_post( $noize_address ); ?></p>
            </div>
        <?php endif;

        if ( ! empty( $noize_phone ) ) :
            $noize_tel_phone = str_replace( " ", "", $noize_phone ); ?>

            <div class="aheto-contact-info--tel">
                <a class="aheto-contact-info--link-tel" href="tel:<?php echo esc_attr( $noize_tel_phone ); ?>">
                    <?php echo esc_html( $noize_phone ); ?>
                </a>
                <span>|</span>
            </div>
        <?php endif;

        if ( ! empty( $noize_email ) ) : ?>
            <div class="aheto-contact-info--mail">
                <span><?php esc_html_e('M: ', 'noize'); ?></span>
                <a class="aheto-contact-info--link-email" href="mailto:<?php echo esc_attr( $noize_email ); ?>">
                    <?php echo esc_html( $noize_email ); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>

</div>
