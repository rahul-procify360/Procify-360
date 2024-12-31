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

$contacts = $this->parse_group( $hryzantema_contacts_group );

if ( empty( $contacts ) ) {
	return '';
}

$hryzantema_light_version = isset( $hryzantema_light_version ) && $hryzantema_light_version == true ? 'light-version' : '';


$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--hr-classic-2' );
$this->add_render_attribute( 'wrapper', 'class', $hryzantema_light_version );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-contacts-layout2', $shortcode_dir . 'assets/css/hryzantema_layout2.css', null, null);
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php foreach ( $contacts as $contact ) :
		$contact = wp_parse_args( $contact, [
			'hryzantema_heading' => '',
			'hryzantema_address' => '',
			'hryzantema_phone'   => '',
			'hryzantema_email'   => '',
		] );
		extract( $contact );

		?>
    <div class="aheto-contact__item">
        <?php if ( !empty($contact['hryzantema_heading'])  ) { ?>
        <<?php echo esc_attr($contact['hryzantema_heading_tag']); ?> class="aheto-contact__title"><?php echo wp_kses_post( $contact['hryzantema_heading'] ); ?></<?php echo esc_attr($contact['hryzantema_heading_tag']); ?>>
        <?php } ?>

        <?php if ( !empty($contact['hryzantema_address']) ) : ?>
            <p class="aheto-contact__info"><?php echo wp_kses_post( $contact['hryzantema_address'] ); ?></p>
        <?php endif; ?>

        <?php if ( !empty($contact['hryzantema_email']) ) : ?>
            <a class="aheto-contact__link"
               href="mailto:<?php echo esc_attr( $contact['hryzantema_email'] ); ?>"><?php echo esc_html( $contact['hryzantema_email'] ); ?></a>
        <?php endif; ?>

        <?php if ( !empty($contact['hryzantema_phone']) ) :
			$tel = str_replace(" ","", $contact['hryzantema_phone']);
			?>
            <a class="aheto-contact__link"
               href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( $contact['hryzantema_phone'] ); ?></a>
        <?php endif; ?>
    </div>
	<?php endforeach; ?>

</div>
