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

$contacts = $this->parse_group($mooseoom_contacts_group);

if (empty($contacts)) {
    return '';
}


$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-contact--mooseoom-classic');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

if (!empty($mooseoom_dark_style)) {
    $this->add_render_attribute('wrapper', 'class', 'aheto-contact--mooseoom-dark');
}
/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 1000,
    'arrows' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'mooseoom_contacts_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;


if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('swiper');
	wp_enqueue_style('mooseoom-contacts-layout1', $shortcode_dir . 'assets/css/mooseoom_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
            <div class="swiper-wrapper">
                <?php foreach ($contacts  as $contact) :
                    $contact = wp_parse_args($contact, [
                        'mooseoom_heading_tag'         => '',
                        'mooseoom_heading'         => '',
                        'mooseoom_address'         => '',
                        'mooseoom_phone'         => '',
                        'mooseoom_email'          => '',
                    ]);
                    extract($contact);

                ?>
                    <div class="swiper-slide">
                        <?php if (isset($contact['mooseoom_heading']) && !empty($contact['mooseoom_heading'])) :
                            echo '<' . $contact['mooseoom_heading_tag'] . ' class="aheto-contact__title">' . wp_kses_post($contact['mooseoom_heading']) . '</' . $contact['mooseoom_heading_tag'] . '>';
                        endif; ?>

                        <?php if (  isset($contact['mooseoom_address']) && !empty($contact['mooseoom_address']) ) : ?>
                            <div class="aheto-contact__info">
                            <?php $address_icon = $this->get_icon_for('mooseoom_address');
                                echo wp_kses($address_icon, 'post'); ?>
                                <p class="aheto-contact__info"><?php echo wp_kses_post($contact['mooseoom_address']); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ( isset($contact['mooseoom_phone']) && !empty($contact['mooseoom_phone'])  ) : ?>
                            <div class="aheto-contact__info">
                            <?php $phone_icon = $this->get_icon_for('mooseoom_phone');
                                echo wp_kses($phone_icon, 'post'); ?>
                                <a class="aheto-contact__link" href="tel:<?php echo esc_attr(str_replace(" ", "", $contact['mooseoom_phone'])); ?>"><?php echo esc_html($contact['mooseoom_phone']); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if ( isset($contact['mooseoom_email']) && !empty($contact['mooseoom_email'])  ) :
                        ?>
                            <div class="aheto-contact__info">
                            <?php $email_icon = $this->get_icon_for('mooseoom_email');
                                echo wp_kses($email_icon, 'post'); ?>
                                <a class="aheto-contact__link" href="mailto:<?php echo esc_attr($contact['mooseoom_email']); ?>"><?php echo esc_html($contact['mooseoom_email']); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <?php $this->swiper_arrow('mooseoom_contacts_'); ?>
    </div>
</div>
