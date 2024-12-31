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

$contacts = $this->parse_group( $outsourceo_contacts_group );

if ( empty( $contacts ) ) {
	return '';
}

$outsourceo_light_version = isset( $outsourceo_light_version ) && $outsourceo_light_version ? 'light-version' : '';


$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--outsourceo-text' );
$this->add_render_attribute( 'wrapper', 'class', $outsourceo_light_version );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-contacts-layout3', $shortcode_dir . 'assets/css/outsourceo_layout3.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php foreach ( $contacts as $contact ) :
		$contact = wp_parse_args( $contact, [
			'outsourceo_heading' => '',
			'outsourceo_address' => '',
			'outsourceo_phone'   => '',
			'outsourceo_email'   => '',
		] );
		extract( $contact ); ?>

        <div class="aheto-contact__item">
			<?php if ( ! empty( $contact['outsourceo_heading'] ) ) { ?>
                <b class="aheto-contact__title"><?php echo wp_kses( $contact['outsourceo_heading'], 'post' ); ?></b>
			<?php } ?>

			<?php if ( ! empty( $contact['outsourceo_address'] ) ) : ?>
                <p class="aheto-contact__info"><?php echo wp_kses( $contact['outsourceo_address'], 'post' ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $contact['outsourceo_email'] ) ) : ?>
                <a class="aheto-contact__link"
                   href="mailto:<?php echo esc_attr( $contact['outsourceo_email'] ); ?>"><?php echo esc_html( $contact['outsourceo_email'] ); ?></a>
			<?php endif; ?>

			<?php if ( ! empty( $contact['outsourceo_phone'] ) ) : ?>
                <a class="aheto-contact__link"
                   href="tel:<?php echo esc_attr( $contact['outsourceo_phone'] ); ?>"><?php echo esc_html( $contact['outsourceo_phone'] ); ?></a>
			<?php endif; ?>
        </div>
	<?php endforeach; ?>

</div>
