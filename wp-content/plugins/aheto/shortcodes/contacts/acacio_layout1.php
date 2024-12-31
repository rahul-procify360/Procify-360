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
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--acacio-simple' );

$networks = $this->parse_group( $networks );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('acacio-contacts-layout1', $shortcode_dir . 'assets/css/acacio_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?> >
    <div class="aheto-contact aheto-contact--acacio-modern">
        <?php if (isset($s_heading) && !empty($s_heading ) ) { ?>
            <h4 class="aheto-contact__type t-uppercase t-medium">
                <?php echo wp_kses_post( $s_heading ); ?>
            </h4>
        <?php } ?>

        <?php if (isset($address) && !empty($address ) ) { ?>
            <p class="aheto-contact__info t-light"><?php echo wp_kses_post( $address ); ?></p>
        <?php } ?>

        <?php if ( isset($email) && !empty($email ) ) {?>
            <a class="aheto-contact__link aheto-contact__mail t-light"
               href="mailto:<?php echo esc_attr( $email ); ?>">
                <?php echo esc_html( $email ); ?>
            </a>
        <?php } ?>

        <?php if ( isset($phone) && !empty($phone )) { ?>
            <?php $phone = str_replace(" ","", $phone) ?>
            <a class="aheto-contact__link aheto-contact__tel t-light"
               href="tel:<?php echo esc_attr( $phone ); ?>">
                <?php echo esc_html( $phone ); ?>
            </a>
        <?php } ?>

        <div class="aheto-contact__link-holder">
            <?php echo \Aheto\Helper::get_button( $this, $atts, 'acacio_main_' ); ?>
        </div>

        <?php if ( !empty( $networks ) ) { ?>
            <div class="aht-socials">
                <?php echo Helper::get_social_networks( $networks, '<a class="aht-socials__link aheto-contact__socials-link" href="%1$s"><i class="aht-socials__icon icon ion-social-%2$s"></i></a>' ); ?>
            </div>
        <?php } ?>
    </div>

</div>
