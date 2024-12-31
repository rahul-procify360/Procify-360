<?php
/**
 * Contact Forms default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'widget widget_aheto__cf--subscribe-modern' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$underline   = isset( $underline ) && $underline ? 'underline' : '';
$title_space = isset( $title_space ) && $title_space ? 'smaller-space' : '';

$this->add_render_attribute( 'title', 'class', 'widget_aheto__title' );
$this->add_render_attribute( 'title', 'class', $underline );
$this->add_render_attribute( 'title', 'class', $title_space );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/contact-forms/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'contact-forms-style-2', $sc_dir . 'assets/css/layout2.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('contact-forms-2-js', $sc_dir . 'assets/js/layout2.min.js', array('jquery'), null);
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $title ) ) : ?>
        <h5 <?php $this->render_attribute_string( 'title' ); ?>>
			<?php echo wp_kses_post( $title ); ?>
        </h5>
	<?php endif; ?>

    <div class="widget_aheto__form">

		<?php if ( ! empty( $contact_form ) ) :

			echo do_shortcode( '[contact-form-7 id="' . esc_attr( $contact_form ) . '"]' );

		endif; ?>

    </div>

	<?php if ( ! empty( $description ) ) : ?>
        <p class="widget_aheto__desc">
			<?php echo wp_kses_post( $description ); ?>
        </p>
	<?php endif; ?>

</div>
