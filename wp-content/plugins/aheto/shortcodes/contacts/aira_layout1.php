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

//Light arrows
$aira_light_arrows = $aira_light_arrows ? 'light_arrows' : '';

$contacts = $this->parse_group($aira_contacts_group);

if ( empty($contacts) ) {
    return '';
}

if ( !$aira_contacts_custom_options ) {
    $speed  = 1000;
    $loop   = false;
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--aira-slider' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 1000,
    'arrows' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'aira_contacts_', $carousel_default_params);

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;


if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('swiper');
	wp_enqueue_style('aira-contacts-slider', $sc_dir . 'assets/css/aira_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper <?php echo esc_attr($aira_light_arrows); ?>">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
            <div class="swiper-wrapper">
                <?php foreach ( $contacts  as $contact ) :
                    $contact = wp_parse_args($contact, [
                        'aira_heading_tag'         => '',
                        'aira_heading'         => '',
                        'aira_address'         => '',
                        'aira_phone'         => '',
                        'aira_email'          => '',
                    ]);
                    extract($contact);

                    ?>
                    <div class="swiper-slide">
                        <?php if ( !empty($contact['aira_heading']) ) :
                            echo '<' . $contact['aira_heading_tag'] . ' class="aheto-contact__title">' . wp_kses( $contact['aira_heading'], 'post'  ) . '</' . $contact['aira_heading_tag'] . '>';
                        endif; ?>

                        <?php if ( !empty($contact['aira_address']) ) : ?>
                            <div class="aheto-contact__info">
                                <?php $address_icon = $this->get_icon_for( 'aira_address' );
                                echo wp_kses($address_icon, 'post'); ?>
                                <p class="aheto-contact__address"><?php echo wp_kses( $contact['aira_address'], 'post'  ); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ( !empty($contact['aira_phone'])) : ?>
                            <div class="aheto-contact__info">
                                <?php $phone_icon = $this->get_icon_for( 'aira_phone' );
                                echo wp_kses($phone_icon, 'post'); ?>
                                <a class="aheto-contact__link"
                                   href="<?php echo esc_url('tel:' . str_replace(" ", "", $contact['aira_phone'])); ?>" ><?php echo esc_html( $contact['aira_phone'] ); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if ( !empty($contact['aira_email']) ) :
                            ?>
                            <div class="aheto-contact__info">
                                <?php $email_icon = $this->get_icon_for( 'aira_email' );
                                echo wp_kses($email_icon, 'post'); ?>
                                <a class="aheto-contact__link" href="<?php echo esc_url('mailto:' . $contact['aira_email']); ?>"><?php echo esc_html( $contact['aira_email']); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php $this->swiper_pagination('aira_contacts_'); ?>
        </div>
        <?php $this->swiper_arrow('aira_contacts_'); ?>
    </div>

</div>
