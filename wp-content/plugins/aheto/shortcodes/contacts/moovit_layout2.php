<?php
/**
 * The Contacts Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--moovit-classic' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-contacts-layout2', $shortcode_dir . 'assets/css/moovit_layout2.css', null, null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $s_heading ) ) :
		echo '<' . $moovit_heading_tag . ' class="aheto-contact__title">' . wp_kses( $s_heading, 'post' ) . '</' . $moovit_heading_tag . '>';
	endif; ?>

	<?php if ( ! empty( $address ) ) : ?>
        <div class="aheto-contact__info">
			<?php $address_icon = $this->get_icon_for( 'moovit_address' );

			echo wp_kses( $address_icon, 'post' ); ?>

            <p class="aheto-contact__info"><?php echo wp_kses( $address, 'post' ); ?></p>
        </div>
	<?php endif; ?>

	<?php if ( ! empty( $email ) ) : ?>
        <div class="aheto-contact__info">
			<?php $email_icon = $this->get_icon_for( 'moovit_email' );

			echo wp_kses( $email_icon, 'post' ); ?>

            <a class="aheto-contact__link"
               href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
        </div>
	<?php endif; ?>

	<?php if ( ! empty( $phone ) ) : ?>
        <div class="aheto-contact__info">
			<?php $phone_icon = $this->get_icon_for( 'moovit_phone' );

			echo wp_kses( $phone_icon, 'post' );

			$tel_phone = str_replace( " ", "", $phone ); ?>
            <a class="aheto-contact__link"
               href="tel:<?php echo esc_attr( $tel_phone ); ?>"><?php echo esc_html( $phone ); ?></a>
        </div>
	<?php endif; ?>

</div>
