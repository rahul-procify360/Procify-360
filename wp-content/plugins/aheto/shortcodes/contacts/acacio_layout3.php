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

$contacts = $this->parse_group($acacio_contacts_group);

if ( empty($contacts) ) {
    return '';
}


$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );

$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--acacio-classic' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

if ( ! empty( $acacio_dark_style ) ) {
    $this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--acacio-dark');
}
/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 1000,
    'arrows' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'acacio_contacts_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('swiper');
	wp_enqueue_style('acacio-contacts-layout3', $shortcode_dir . 'assets/css/acacio_layout3.css', null, null);
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
            <div class="swiper-wrapper">
                <?php foreach ( $contacts  as $contact ) :
                    $contact = wp_parse_args($contact, [
                        'acacio_heading_tag'         => '',
                        'acacio_heading'         => '',
                        'acacio_address'         => '',
                        'acacio_phone'         => '',
                        'acacio_email'          => '',
                    ]);
                    extract($contact);

                    ?>
                    <div class="swiper-slide">
                        <?php if (isset($contact['acacio_heading']) && !empty($contact['acacio_heading'])  ) :
                            echo '<' . $contact['acacio_heading_tag'] . ' class="aheto-contact__title">' . wp_kses_post( $contact['acacio_heading'] ) . '</' . $contact['acacio_heading_tag'] . '>';
                        endif; ?>

                        <?php if (isset($contact['acacio_address']) && !empty($contact['acacio_address'])  ) : ?>
                            <div class="aheto-contact__info">
                                <i class="widget_aheto__icon el icon_pin_alt "></i>
                                <p class="aheto-contact__info"><?php echo wp_kses_post( $contact['acacio_address'] ); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($contact['acacio_email']) && !empty($contact['acacio_email']) ) :
                            ?>
                            <div class="aheto-contact__info">
                                <i class="widget_aheto__icon el icon_mail_alt "></i>
                                <a class="aheto-contact__link" href="mailto:<?php echo esc_attr( $contact['acacio_email'] ); ?>"><?php echo esc_html( $contact['acacio_email']); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($contact['acacio_phone']) && !empty($contact['acacio_phone']) ) : ?>
                            <div class="aheto-contact__info">
                                <i class="widget_aheto__icon el icon_phone "></i>
                                <?php $phone = str_replace(" ","", $contact['acacio_phone']); ?>
                                <a class="aheto-contact__link" href="tel:<?php echo esc_attr( $phone ); ?>">
                                    <?php echo esc_html( $contact['acacio_phone'] ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php $this->swiper_pagination('acacio_contacts_'); ?>
        </div>
        <?php $this->swiper_arrow('acacio_contacts_'); ?>
    </div>



</div>
