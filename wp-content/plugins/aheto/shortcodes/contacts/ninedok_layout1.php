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

extract ( $atts );

$contacts = $this -> parse_group ( $ninedok_contacts_group );

if (empty( $contacts )) {
	return '';
}

$this -> generate_css ();

// Wrapper.
$this -> add_render_attribute ( 'wrapper', 'id', $element_id );
$this -> add_render_attribute ( 'wrapper', 'class', 'aheto-contact--ninedok-slider' );
$this -> add_render_attribute ( 'wrapper', 'class', $this -> the_custom_classes () );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
	'autoplay' => 0,
	'arrows' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper ::get_carousel_params ( $atts, 'ninedok_contacts_', $carousel_default_params );

/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css = Helper ::get_settings ( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && !empty( $custom_css ) ) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('swiper');
	wp_enqueue_style ( 'ninedok-contacts-layout1', $shortcode_dir . 'assets/css/ninedok_layout1.css', null, null );
}
?>

<div <?php $this -> render_attribute_string ( 'wrapper' ); ?>>

    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr ( $carousel_params ); ?>>
            <div class="swiper-wrapper">
				<?php foreach ($contacts as $contact) :
					$contact = wp_parse_args ( $contact, [
						'ninedok_heading_tag' => '',
						'ninedok_heading' => '',
						'ninedok_address' => '',
						'ninedok_phone' => '',
						'ninedok_email' => '',
					] );
					extract ( $contact );

					?>
                    <div class="swiper-slide">
						<?php if ( !empty( $contact['ninedok_heading'] )) :
							echo '<' . $contact['ninedok_heading_tag'] . ' class="aheto-contact__title">' . wp_kses ( $contact['ninedok_heading'], 'post' ) . '</' . $contact['ninedok_heading_tag'] . '>';
						endif; ?>

						<?php if ( !empty( $contact['ninedok_address'] )) : ?>
                            <div class="aheto-contact__info">
                                <i class="widget_aheto__icon el icon_pin_alt "></i>
                                <p class="aheto-contact__info"><?php echo wp_kses ( $contact['ninedok_address'], 'post' ); ?></p>
                            </div>
						<?php endif; ?>

						<?php if ( !empty( $contact['ninedok_phone'] )) : ?>
                            <div class="aheto-contact__info">
                                <i class="widget_aheto__icon el icon_phone "></i>
                                <a class="aheto-contact__link"
                                   href="tel:<?php echo esc_attr ( str_replace ( " ", "", $contact['ninedok_phone'] ) ); ?>"><?php echo esc_html ( $contact['ninedok_phone'] ); ?></a>
                            </div>
						<?php endif; ?>


						<?php if ( !empty( $contact['ninedok_email'] )) :
							?>
                            <div class="aheto-contact__info">
                                <i class="widget_aheto__icon el icon_mail_alt "></i>
                                <a class="aheto-contact__link"
                                   href="mailto:<?php echo esc_attr ( $contact['ninedok_email'] ); ?>"><?php echo esc_html ( $contact['ninedok_email'] ); ?></a>
                            </div>
						<?php endif; ?>
                    </div>
				<?php endforeach; ?>
            </div>
			<?php $this -> swiper_pagination ( 'ninedok_contacts_' ); ?>
        </div>
		<?php $this -> swiper_arrow ( 'ninedok_contacts_' ); ?>
    </div>


</div>
