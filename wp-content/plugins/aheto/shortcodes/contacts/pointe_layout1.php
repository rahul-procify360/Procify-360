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

$contacts = $this->parse_group($pointe_contacts_group);

if ( empty($contacts) ) {
    return '';
}


$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--pointe-classic' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 1000,
    'arrows' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'pointe_contacts_', $carousel_default_params);

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('swiper');
	wp_enqueue_style('pointe-contacts-layout1', $sc_dir . 'assets/css/pointe_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
            <div class="swiper-wrapper">
                <?php foreach ( $contacts  as $contact ) :
                    $contact = wp_parse_args($contact, [
                        'pointe_heading_tag'         => '',
                        'pointe_heading'         => '',
                        'pointe_address'         => '',
                        'pointe_phone'         => '',
                        'pointe_email'          => '',
                    ]);
                    extract($contact);

                    ?>
                    <div class="swiper-slide">
                        <?php if ( !empty($contact['pointe_heading']) && isset($contact['pointe_heading']) ) :
                            echo '<' . $contact['pointe_heading_tag'] . ' class="aheto-contact__title">' . wp_kses_post( $contact['pointe_heading'] ) . '</' . $contact['pointe_heading_tag'] . '>';
                        endif; ?>

                        <?php if ( !empty($contact['pointe_address']) && isset($contact['pointe_address']) ) : ?>
                            <div class="aheto-contact__info">
                                <?php $address_icon = $this->get_icon_for('pointe_address');
                                echo wp_kses($address_icon, 'post'); ?>
                                <p class="aheto-contact__info"><?php echo wp_kses_post( $contact['pointe_address'] ); ?></p>
                            </div>
                        <?php endif; ?>

						<?php if ( !empty($contact['pointe_phone']) && isset($contact['pointe_phone'])) : ?>
							<div class="aheto-contact__info">
                                <?php $phone_icon = $this->get_icon_for('pointe_phone');
                                echo wp_kses($phone_icon, 'post'); ?>
								<a class="aheto-contact__link aheto-contact__tel" href="tel:<?php echo esc_attr( str_replace(" ","", $contact['pointe_phone'])  ); ?>"><?php echo esc_html( $contact['pointe_phone'] ); ?></a>
							</div>
						<?php endif; ?>

                        <?php if ( !empty($contact['pointe_email']) && isset($contact['pointe_email']) ) :
                            ?>
                            <div class="aheto-contact__info">
                                <?php $email_icon = $this->get_icon_for('pointe_email');
                                echo wp_kses($email_icon, 'post'); ?>
                                <a class="aheto-contact__link aheto-contact__mail" href="mailto:<?php echo esc_attr( $contact['pointe_email'] ); ?>"><?php echo esc_html( $contact['pointe_email']); ?></a>
                            </div>
                        <?php endif; ?>
                        <div class="aheto-contact__link">
                            <?php echo Aheto\Helper::get_button($this, $contact, 'pointe_main_'); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php $this->swiper_pagination('pointe_contacts_'); ?>
        </div>
        <?php $this->swiper_arrow('pointe_contacts_'); ?>
    </div>



</div>
