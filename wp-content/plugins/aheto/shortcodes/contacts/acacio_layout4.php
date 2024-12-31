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

$contacts = $this->parse_group( $acacio_contacts_group );

if ( empty( $contacts ) ) {
	return '';
}

$acacio_light_version = isset( $acacio_light_version ) && $acacio_light_version ? 'light-version' : '';


$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );

$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--acacio-classic-2' );
$this->add_render_attribute( 'wrapper', 'class', $acacio_light_version );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'acacio-contacts-layout4', $shortcode_dir . 'assets/css/acacio_layout4.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php foreach ( $contacts as $contact ) :
		$contact = wp_parse_args( $contact, [
			'acacio_heading' => '',
			'acacio_address' => '',
			'acacio_phone'   => '',
			'acacio_email'   => '',
		] );
		extract( $contact );

		?>
        <div class="aheto-contact__item">
			<?php if (isset($contact['acacio_heading']) && !empty($contact['acacio_heading'])  ) { ?>
                <<?php echo esc_attr($contact['acacio_heading_tag']); ?> class="aheto-contact__title"><?php echo wp_kses_post( $contact['acacio_heading'] ); ?></<?php echo esc_attr($contact['acacio_heading_tag']); ?>>
			<?php } ?>

			<?php if (isset($contact['acacio_address']) && !empty($contact['acacio_address'])  ) : ?>
                <p class="aheto-contact__info"><?php echo wp_kses_post( $contact['acacio_address'] ); ?></p>
			<?php endif; ?>

			<?php if (isset($contact['acacio_email']) && !empty($contact['acacio_email'])  ) : ?>
                <a class="aheto-contact__link"
                   href="mailto:<?php echo esc_attr( $contact['acacio_email'] ); ?>"><?php echo esc_html( $contact['acacio_email'] ); ?></a>
			<?php endif; ?>

			<?php if (isset($contact['acacio_phone']) && !empty($contact['acacio_phone']) ) : ?>
                <a class="aheto-contact__link"
                   href="tel:<?php echo esc_attr( str_replace(" ","", $contact['acacio_phone']) ); ?>"><?php echo esc_html( $contact['acacio_phone'] ); ?></a>
			<?php endif; ?>
        </div>
	<?php endforeach; ?>

</div>
