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

$contacts = $this->parse_group( $outsourceo_contacts_group );

if ( empty( $contacts ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact--outsourceo-classic' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'  => 1000,
	'arrows' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'outsourceo_contacts_', $carousel_default_params );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('swiper');
	wp_enqueue_style( 'outsourceo-contacts-layout2', $shortcode_dir . 'assets/css/outsourceo_layout2.css', null, null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>
            <div class="swiper-wrapper">
				<?php foreach ( $contacts as $contact ) :
					$contact = wp_parse_args( $contact, [
						'outsourceo_heading_tag' => '',
						'outsourceo_heading'     => '',
						'outsourceo_address'     => '',
						'outsourceo_phone'       => '',
						'outsourceo_email'       => '',
					] );
					extract( $contact );

					?>
                    <div class="swiper-slide">
						<?php if ( ! empty( $contact['outsourceo_heading'] ) ) :
							echo '<' . $contact['outsourceo_heading_tag'] . ' class="aheto-contact__title">' . wp_kses( $contact['outsourceo_heading'], 'post' ) . '</' . $contact['outsourceo_heading_tag'] . '>';
						endif; ?>

						<?php if ( ! empty( $contact['outsourceo_address'] ) ) : ?>
                            <div class="aheto-contact__info">
                                <i class="widget_aheto__icon el icon_pin_alt "></i>
                                <p class="aheto-contact__info"><?php echo wp_kses( $contact['outsourceo_address'], 'post' ); ?></p>
                            </div>
						<?php endif; ?>

						<?php if ( ! empty( $contact['outsourceo_email'] ) ) :
							?>
                            <div class="aheto-contact__info">
                                <i class="widget_aheto__icon el icon_mail_alt "></i>
                                <a class="aheto-contact__link"
                                   href="mailto:<?php echo esc_attr( $contact['outsourceo_email'] ); ?>"><?php echo esc_html( $contact['outsourceo_email'] ); ?></a>
                            </div>
						<?php endif; ?>

						<?php if ( ! empty( $contact['outsourceo_phone'] ) ) : ?>
                            <div class="aheto-contact__info">
                                <i class="widget_aheto__icon el icon_phone "></i>
                                <a class="aheto-contact__link"
                                   href="tel:<?php echo esc_attr( $contact['outsourceo_phone'] ); ?>"><?php echo esc_html( $contact['outsourceo_phone'] ); ?></a>
                            </div>
						<?php endif; ?>
                    </div>
				<?php endforeach; ?>
            </div>
			<?php $this->swiper_pagination( 'outsourceo_contacts_' ); ?>
        </div>
		<?php $this->swiper_arrow( 'outsourceo_contacts_' ); ?>
    </div>
</div>
