<?php

/**
 * Time Schedule default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--karma-political__simple' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$networks = $this->parse_group( $networks );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'karma-political-contacts-style-1', $shortcode_dir . 'assets/css/karma_political_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="aheto-contact--item">

        <?php if ( ! empty( $address ) ) : ?>
            <h3 class="aheto-contact__info t-light"><?php echo wp_kses_post( $address ); ?></h3>
        <?php endif; ?>

         <?php if ( ! empty( $phone ) ) :
            $tel_phone = str_replace( " ", "", $phone ); ?>

            <a class="aheto-contact__link aheto-contact__tel t-light"
               href="tel:<?php echo esc_attr( $tel_phone ); ?>"><?php echo esc_html( $phone ); ?>
            </a>
         <?php endif; ?>

        <?php if ( ! empty( $email ) ) : ?>
            <a class="aheto-contact__link aheto-contact__mail t-light"
               href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?>
            </a>
        <?php endif; ?>

        <?php if ( !empty( $networks ) ) { ?>
            <div class="aheto-contact__socials">

                <?php echo Helper::get_social_networks( $networks, '<a class="aht-socials__link" href="%1$s"><i class="aht-socials__icon icon ion-social-%2$s"></i></a>' ); ?>

            </div>
        <?php } ?>

    </div>
</div>
