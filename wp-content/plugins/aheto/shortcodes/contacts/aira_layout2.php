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


$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--aira-light' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-contacts-light', $sc_dir . 'assets/css/aira_layout2.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
        <?php if (!empty($s_heading)) : ?>
            <h4 class="aheto-contact__title">
                <?php echo esc_html($s_heading); ?>
            </h4>
        <?php endif;

        if (!empty($address)) : ?>
            <div class="aheto-contact__info">
                <?php $address_icon = $this->get_icon_for('aira_address');
                echo wp_kses($address_icon, 'post'); ?>
                <p class="aheto-contact__address"><?php echo esc_html($address); ?></p>
            </div>
        <?php endif;

        if (!empty($phone)) : ?>
            <div class="aheto-contact__info">
                <?php $phone_icon = $this->get_icon_for('aira_phone');
                echo wp_kses($phone_icon, 'post'); ?>
                <a class="aheto-contact__tel"
                   href="<?php echo esc_url('tel:' . str_replace(" ", "", $phone)); ?>"><?php echo esc_html($phone); ?></a>
            </div>
        <?php endif;


        if (!empty($aira_add_phone)) : ?>
            <div class="aheto-contact__info">
                <?php $aira_add_phone_icon = $this->get_icon_for('aira_add_phone');
                echo wp_kses($aira_add_phone_icon, 'post'); ?>
                <a class="aheto-contact__tel"
                   href="<?php echo esc_url('tel:' . str_replace(" ", "", $aira_add_phone)); ?>"><?php echo esc_html($aira_add_phone); ?></a>
            </div>
        <?php endif;

        if (!empty($email)) : ?>
            <div class="aheto-contact__info">
                <?php $email_icon = $this->get_icon_for('aira_email');
                echo wp_kses($email_icon, 'post'); ?>
                <a class="aheto-contact__mail"
                   href="<?php echo esc_url('mailto:' . $email); ?>"><?php echo esc_html($email); ?></a>
            </div>
        <?php endif; ?>
</div>
