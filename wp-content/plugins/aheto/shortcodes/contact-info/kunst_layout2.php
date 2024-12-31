<?php
/**
 * Kunst Contact Info default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Kunst <info@kunst.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'widget_kunst--info__modern' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$underline   = isset( $underline ) && $underline ? 'underline' : '';
$title_space = isset( $title_space ) && $title_space ? 'smaller-space' : '';

$this->add_render_attribute( 'title', 'class', 'widget_kunst__title' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style( 'kunst-contact-info-layout2', $shortcode_dir . 'assets/css/kunst_layout2.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="widget_kunst--info__modern--content">

        <?php if ( ! empty( $kunst_address ) ) : ?>
            <div class="widget_kunst--info__modern--address">
                <p class="widget_kunst--info__modern--link-address"><?php echo wp_kses( $kunst_address, 'post' ); ?></p>
            </div>
        <?php endif;

        if ( ! empty( $kunst_phone ) ) :
            $kunst_tel_phone = str_replace( " ", "", $kunst_phone ); ?>
            <div class="widget_kunst--info__modern--tel">
                <a class="widget_kunst--info__modern--link-tel" href="tel:<?php echo esc_attr( $kunst_tel_phone ); ?>">
                    <?php echo esc_html( $kunst_phone ); ?>
                </a>
                <span>|</span>
            </div>
        <?php endif;

        if ( ! empty( $kunst_email ) ) : ?>
            <div class="widget_kunst--info__modern--mail">
                <span>M: </span>
                <a class="widget_kunst--info__modern--link-email" href="mailto:<?php echo esc_attr( $kunst_email ); ?>">
                    <?php echo esc_html( $kunst_email ); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>

</div>
