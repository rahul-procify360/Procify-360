<?php
/**
 * The Contacts Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$contacts = $this->parse_group( $contacts );
if ( empty( $contacts ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'contact-single-wrap__contacts' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'contacts-style-3', $sc_dir . 'assets/css/layout3.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="row">
		<?php foreach ( $contacts as $item ) { ?>

            <div class="col-md-4">

                <div class="aheto-contact aheto-contact--simple aheto-contact--dvder t-center">
					<?php
					// Icon.
					if ( ! empty( $item['icon'] ) ) {
						echo '<i class="aheto-contact__icon icon ti-' . esc_attr( $item['icon'] ) . '"></i>';
					}

					// Heading.
					if ( ! empty( $item['heading'] ) ) {
						echo '<h6 class="aheto-contact__type t-uppercase t-medium">' . wp_kses_post( $item['heading'] ) . '</h6>';
					}

					// Content.
					if ( ! empty( $item['content'] ) ) {

						// Address.
						if ( 'address' == $item['contact'] ) {
							echo '<p class="aheto-contact__info">' . esc_html( $item['content'] ) . '</p>';
						}

						// Email.
						if ( 'email' == $item['contact'] ) {
							echo '<a class="aheto-contact__link aheto-contact__info" href="mailto:' . esc_attr( $item['content'] ) . '">' . esc_html( $item['content'] ) . '</a>';
						}

						// Phone.
						if ( 'phone' == $item['contact'] ) {
							$tel_phone = str_replace( " ", "", $item['content'] );
							echo '<a class="aheto-contact__link aheto-contact__info" href="tel:' . esc_attr( $tel_phone ) . '">' . esc_html( $item['content'] ) . '</a>';
						}
					}
					?>
                </div>

            </div>

		<?php } ?>

    </div>
</div>
