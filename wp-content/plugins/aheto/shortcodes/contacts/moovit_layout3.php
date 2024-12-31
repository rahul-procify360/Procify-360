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

if ( ! $moovit_contacts_custom_options ) {
	$speed  = 1000;
	$effect = 'fade';
	$loop   = true;
}

$moovit_light_version = isset( $moovit_light_version ) && $moovit_light_version ? 'light-version' : '';


$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--moovit-modern' );
$this->add_render_attribute( 'wrapper', 'class', $moovit_light_version );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'  => 1000,
	'arrows' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'moovit_contacts_', $carousel_default_params );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('swiper');
	wp_enqueue_style( 'moovit-contacts-layout3', $shortcode_dir . 'assets/css/moovit_layout3.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>
            <div class="swiper-wrapper">
				<?php foreach ( $contacts as $contact ) :
					$contact = wp_parse_args( $contact, [
						'moovit_heading_tag' => '',
						'moovit_heading'     => '',
						'moovit_address'     => '',
						'moovit_phone'       => '',
						'moovit_email'       => '',
					] );
					extract( $contact );

					?>
                    <div class="swiper-slide">
						<?php if ( ! empty( $contact['moovit_heading'] ) ) { ?>
                            <h4 class="aheto-contact__title"><?php echo wp_kses( $contact['moovit_heading'], 'post' ); ?></h4>
						<?php } ?>

						<?php if ( ! empty( $contact['moovit_address'] ) ) : ?>
                            <div class="aheto-contact__info">
                                <i class="widget_aheto__icon el icon_pin_alt "></i>
                                <p class="aheto-contact__info"><?php echo wp_kses( $contact['moovit_address'], 'post' ); ?></p>
                            </div>
						<?php endif; ?>

						<?php if ( ! empty( $contact['moovit_email'] ) ) : ?>
                            <div class="aheto-contact__info">
                                <i class="widget_aheto__icon el icon_mail_alt "></i>
                                <a class="aheto-contact__link"
                                   href="mailto:<?php echo esc_attr( $contact['moovit_email'] ); ?>"><?php echo esc_html( $contact['moovit_email'] ); ?></a>
                            </div>
						<?php endif; ?>

						<?php if ( ! empty( $contact['moovit_phone'] ) ) :

							$tel_phone = str_replace( " ", "", $contact['moovit_phone'] ); ?>

                            <div class="aheto-contact__info">
                                <i class="widget_aheto__icon el icon_phone "></i>
                                <a class="aheto-contact__link"
                                   href="tel:<?php echo esc_attr( $tel_phone ); ?>"><?php echo esc_html( $contact['moovit_phone'] ); ?></a>
                            </div>

						<?php endif; ?>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
        <div class="aheto-contact__arrows-wrap">
			<?php $this->swiper_arrow( 'moovit_contacts_' ); ?>
        </div>
    </div>


</div>
