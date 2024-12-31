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

$contacts = $this->parse_group($djo_contacts_group);

if ( empty($contacts) ) {
    return '';
}

$djo_dark_version = isset($djo_dark_version) && $djo_dark_version ? 'dark-version' : '';

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--djo-modern' );
$this->add_render_attribute( 'wrapper', 'class', $djo_dark_version );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 1000,
    'arrows' => true
]; // will use when not chosen option 'Change slider params' 

$carousel_params = Helper::get_carousel_params($atts, 'djo_contacts_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('swiper');
	wp_enqueue_style('djo-contacts-layout1', $shortcode_dir . 'assets/css/djo_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
            <div class="swiper-wrapper">
                <?php foreach ( $contacts  as $contact ) :
                    $contact = wp_parse_args($contact, [
                        'djo_heading_tag'         => '',
                        'djo_heading'         => '',
                        'djo_address'         => '',
                        'djo_phone'         => '',
                        'djo_email'          => '',
                    ]);
                    extract($contact);

                    ?>
                    <div class="swiper-slide">
                        <?php if ( ! empty( $contact['djo_heading'] ) ){ ?>
                            <h4 class="aheto-contact__title"><?php echo wp_kses_post( $contact['djo_heading'] ); ?></h4>
                        <?php } ?>

                        <?php if ( ! empty( $contact['djo_address'] ) ) : ?>
                            <div class="aheto-contact__info">
                                <i class="fa fa-map-marker"></i>
                                <p><?php echo wp_kses_post( $contact['djo_address'] ); ?></p>
                            </div>
						<?php endif; ?>

						<?php if ( ! empty( $contact['djo_phone'] ) ) : ?>
                            <div class="aheto-contact__info">
                                <i class="fa fa-phone"></i>

                                <p><a class="aheto-contact__link" href="tel:<?php echo esc_attr( str_replace(" ","", $contact['djo_phone']) ); ?>"><?php echo esc_html( $contact['djo_phone'] ); ?></a></p>
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $contact['djo_email'] ) ) :
                            ?>
                            <div class="aheto-contact__info">
                                <i class="fa fa-envelope"></i>
                                <p><a class="aheto-contact__link" href="mailto:<?php echo esc_attr( $contact['djo_email'] ); ?>"><?php echo esc_html( $contact['djo_email']); ?></a></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="aheto-contact__arrows-wrap">
	        <?php $this->swiper_arrow('djo_contacts_'); ?>
        </div>
    </div>
</div>
