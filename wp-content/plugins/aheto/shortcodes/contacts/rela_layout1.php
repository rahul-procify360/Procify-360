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

extract($atts);

//Light arrows
$rela_light_arrows = $rela_light_arrows ? 'aheto-contact__light_arrows' : '';

$contacts = $this->parse_group($rela_contacts_group);

if (empty($contacts)) {
    return '';
}

if (!$rela_contacts_custom_options) {
    $speed = 1000;
    $loop = false;
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-contact--rela-slider');
$this->add_render_attribute('wrapper', 'class', $rela_light_arrows);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 1000,
    'arrows' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'rela_contacts_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('swiper');
	wp_enqueue_style('rela-contacts-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
            <div class="swiper-wrapper">
                <?php foreach ($contacts as $contact) :
                    $contact = wp_parse_args($contact, [
                        'rela_heading_tag' => '',
                        'rela_heading' => '',
                        'rela_address' => '',
                        'rela_phone' => '',
                        'rela_email' => '',
                    ]);
                    extract($contact);

                    ?>
                    <div class="swiper-slide">
                        <?php if (!empty($contact['rela_heading'])) :
                            echo '<' . $contact['rela_heading_tag'] . ' class="aheto-contact__title">' . wp_kses($contact['rela_heading'], 'post') . '</' . $contact['rela_heading_tag'] . '>';
                        endif; ?>

                        <?php if (!empty($contact['rela_address'])) : ?>
                            <div class="aheto-contact__info">
                                <?php $address_icon = $this->get_icon_for('rela_address');
                                echo wp_kses($address_icon, 'post'); ?>
                                <p class="aheto-contact__info"><?php echo wp_kses($contact['rela_address'], 'post'); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contact['rela_phone'])) : ?>
                            <div class="aheto-contact__info">
                                <?php $phone_icon = $this->get_icon_for('rela_phone');
                                echo wp_kses($phone_icon, 'post'); ?>
                                <a class="aheto-contact__link"
                                   href="tel:<?php echo str_replace(" ", "", $contact['rela_phone']); ?>"><?php echo esc_html($contact['rela_phone']); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contact['rela_email'])) :
                            ?>
                            <div class="aheto-contact__info">
                                <?php $email_icon = $this->get_icon_for('rela_email');
                                echo wp_kses($email_icon, 'post'); ?>
                                <a class="aheto-contact__link"
                                   href="mailto:<?php echo esc_attr($contact['rela_email']); ?>"><?php echo esc_html($contact['rela_email']); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php $this->swiper_pagination('rela_contacts_'); ?>
        </div>
        <?php $this->swiper_arrow('rela_contacts_'); ?>
    </div>


</div>
