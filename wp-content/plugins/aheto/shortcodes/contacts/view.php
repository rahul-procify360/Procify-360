<?php
/**
 * The Contacts Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact aheto-contact--author-bio' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'contacts-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $s_heading ) ) : ?>
		<h2 class="aheto-contact__title t-light"><?php echo wp_kses_post( $s_heading ); ?></h2>
	<?php endif; ?>

	<?php if ( ! empty( $email ) ) : ?>
		<a class="aheto-contact__mail"
		   href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
	<?php endif; ?>

	<?php if ( ! empty( $phone ) ) :
		$tel_phone = str_replace( " ", "", $phone ); ?>
		<a class="aheto-contact__tel"
		   href="tel:<?php echo esc_attr( $tel_phone ); ?>"><?php echo esc_html( $phone ); ?></a>
	<?php endif; ?>

</div>
