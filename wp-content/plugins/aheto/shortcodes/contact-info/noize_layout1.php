<?php
/**
 * Contact Info Noize templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */


use Aheto\Helper;

extract( $atts );

$contacts = $this->parse_group($noize_contact_info);

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );

$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact-info--noize-lay1' );

$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'noize-contact-info-layout1', $shortcode_dir . 'assets/css/noize_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <?php foreach ( $contacts as $contact ) :
        $contact = wp_parse_args($contact, [
            'noize_image'            => '',
            'noize_title'            => '',
            'noize_info_text_first'  => '',
            'noize_info_text_second' => '',
        ]);

        extract($contact);
    ?>

    <div class="aheto-contact-info__item">
        <div class="aheto-contact-info__block-image">
            <?php if ( $contact['noize_image'] ) { ?>
                <?php echo Helper::get_attachment($contact['noize_image'], ['class' => 'aheto-contact-info--noize-lay1__img'], null, $atts, 'noize_'); ?>
            <?php } ?>
        </div>
        <div class="aheto-contact-info__info">
            <?php if ( ! empty( $contact['noize_title'] ) ) { ?>
                <h5 class="aheto-contact-info__title"><?php echo wp_kses_post( $contact['noize_title'] ); ?></h5>
            <?php } ?>
            <?php if ( ! empty( $contact['noize_info_address'] ) ) { ?>
                <span class="aheto-contact-info__address"><?php echo wp_kses_post( $contact['noize_info_address'] ); ?></span>
            <?php } ?>
            <?php if ( ! empty( $noize_info_telephone ) ) :
                $noize_tel_phone = str_replace( " ", "", $noize_info_telephone );
            ?>
                <a class="aheto-contact-info__telephone" href="tel:<?php echo esc_attr( $noize_tel_phone ); ?>"><?php echo wp_kses_post( $contact['noize_info_telephone'] ); ?></a>
            <?php endif; ?>
            <?php if ( ! empty( $contact['noize_info_hour'] ) ) { ?>
                <span class="aheto-contact-info__hour"><?php echo wp_kses_post( $contact['noize_info_hour'] ); ?></span>
            <?php } ?>
            <?php if ( ! empty( $contact['noize_info_email'] ) ) { ?>
                <a class="aheto-contact-info__email" href="mailto:<?php echo esc_attr( $noize_info_email); ?>"><?php echo wp_kses_post( $contact['noize_info_email'] ); ?></a>
            <?php } ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
