<?php

/**
* Kunst Contact Forms default templates.
*/

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'widget_aheto__cf--kunst__subscribe-single' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-forms/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'kunst-subscribe-single-layout1', $shortcode_dir . 'assets/css/kunst_layout1.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script( 'kunst-subscribe-single-layout1-js', $shortcode_dir . 'assets/js/kunst_layout1.min.js', array( 'jquery' ), null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="widget_aheto__form">
		<?php if ( !empty( $contact_form ) ) : ?>
            <div class="<?php echo Helper::get_button($this, $atts, 'form_', true); ?>">
				<?php echo do_shortcode( '[contact-form-7 id="' . esc_attr( $contact_form ) . '"]' ); ?>
            </div>
		<?php endif; ?>
	</div>
</div>
