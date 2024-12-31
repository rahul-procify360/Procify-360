<?php
/**
 * Contact Info default templates.
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
$this->add_render_attribute( 'wrapper', 'class', $soapy_align );
$this->add_render_attribute( 'wrapper', 'class', ' widget_aheto__contact_info--soapy-two-rows' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'title', 'class', 'widget_aheto__title' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-contact-info-layout3', $shortcode_dir . 'assets/css/soapy_layout3.css', null, null);
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>


	<div class="widget_aheto__infos">

		<?php if ( !empty( $address ) ) : ?>
				<p><?php echo wp_kses( $address , 'post'); ?></p>
		<?php endif;?>
		<div class="widget_aheto__tel-mail">

		<?php if ( !empty( $phone ) ) : ?>
				<?php $tel_phone = str_replace( " ", "", $phone ); ?>
				<a class="widget_aheto__link" href="tel:<?php echo esc_attr( $tel_phone ); ?>">
					<?php echo esc_html( $phone ); ?>
				</a>
		<?php endif;
		if ( !empty( $email ) ) : ?>
				<a class="widget_aheto__link" href="mailto:<?php echo esc_attr( $email ); ?>">
					<?php echo esc_html( $email ); ?>
				</a>
		<?php endif; ?>
		</div>
	</div>

</div>
