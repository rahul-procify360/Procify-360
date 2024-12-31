<?php
/**
 * Contact Forms default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract ( $atts );

$this -> generate_css ();

$full_width_button = isset( $full_width_button ) && $full_width_button ? 'full_width_button' : '';

// Wrapper.
$this -> add_render_attribute ( 'wrapper', 'id', $element_id );
$this -> add_render_attribute ( 'wrapper', 'class', 'widget_aheto__cf--ninedok-classic-form' );
$this -> add_render_attribute ( 'wrapper', 'class', $this -> the_custom_classes () );
$this -> add_render_attribute ( 'wrapper', 'class', $full_width_button );

$this -> add_render_attribute ( 'form', 'class', 'widget_aheto__form text-' . $button_align . ' count-' . $ninedok_count_input );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-forms/';
$custom_css = Helper ::get_settings ( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && !empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style ( 'ninedok-contact-forms-layout1', $shortcode_dir . 'assets/css/ninedok_layout1.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('ninedok-contact-forms-layout1-js', $shortcode_dir . 'assets/js/ninedok_layout1.min.js', array('jquery'), null);
} ?>


<div <?php $this -> render_attribute_string ( 'wrapper' ); ?>>
	<?php if ( !empty( $title )) :

		echo '<' . $ninedok_title_tag . ' class="widget_aheto__title">' . wp_kses ( $title, 'post' ) . '</' . $ninedok_title_tag . '>';

	endif; ?>

    <div <?php $this -> render_attribute_string ( 'form' ); ?>>

		<?php if ( !empty( $contact_form )) : ?>
            <div class="<?php echo Helper ::get_button ( $this, $atts, 'form_', true ); ?>">
				<?php echo do_shortcode ( '[contact-form-7 id="' . esc_attr ( $contact_form ) . '"]' ); ?>
            </div>
		<?php endif; ?>

    </div>

</div>
