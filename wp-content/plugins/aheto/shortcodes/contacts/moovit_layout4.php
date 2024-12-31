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

$contacts = $this->parse_group( $moovit_contacts_group );

if ( empty( $contacts ) ) {
	return '';
}

$moovit_light_version = isset( $moovit_light_version ) && $moovit_light_version ? 'light-version' : '';


$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--moovit-classic' );
$this->add_render_attribute( 'wrapper', 'class', $moovit_light_version );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-contacts-layout4', $shortcode_dir . 'assets/css/moovit_layout4.css', null, null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php foreach ( $contacts as $contact ) :
		$contact = wp_parse_args( $contact, [
			'moovit_heading' => '',
			'moovit_address' => '',
			'moovit_phone'   => '',
			'moovit_email'   => '',
		] );
		extract( $contact );

		?>
        <div class="aheto-contact__item">
			<?php if ( ! empty( $contact['moovit_heading'] ) ) { ?>
                <p class="aheto-contact__title"><?php echo wp_kses( $contact['moovit_heading'], 'post' ); ?></p>
			<?php } ?>

			<?php if ( ! empty( $contact['moovit_address'] ) ) : ?>
                <p class="aheto-contact__info"><?php echo wp_kses( $contact['moovit_address'], 'post' ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $contact['moovit_email'] ) ) : ?>
                <a class="aheto-contact__link"
                   href="mailto:<?php echo esc_attr( $contact['moovit_email'] ); ?>"><?php echo esc_html( $contact['moovit_email'] ); ?></a>
			<?php endif; ?>

			<?php if ( ! empty( $contact['moovit_phone'] ) ) :
				$tel_phone = str_replace( " ", "", $contact['moovit_phone'] ); ?>

                <a class="aheto-contact__link"
                   href="tel:<?php echo esc_attr( $tel_phone ); ?>"><?php echo esc_html( $contact['moovit_phone'] ); ?></a>
			<?php endif; ?>
        </div>
	<?php endforeach; ?>

</div>
