<?php
/**
 * The Call To Action Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cta' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cta--modern' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$sc_dir     = aheto()->plugin_url() . 'shortcodes/call-to-action/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'call-to-action-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="aheto-cta__wrap">
		<?php if ( ! empty( $heading ) ) { ?>
			<div class="aheto-cta__text">
				<?php echo '<' . $text_tag . ' class="aheto-cta__title">' . wp_kses_post( $heading ) . '</' . $text_tag . '>'; ?>
			</div>
		<?php }

		if ( $main_add_button || $additional_add_button ) { ?>
			<div class="aheto-cta__links">
				<?php if ( $main_add_button ) {
					echo Helper::get_button( $this, $atts, 'main_' );
				}

				if ( $additional_add_button ) {
					echo Helper::get_button( $this, $atts, 'additional_' );
				} ?>
			</div>
		<?php }
		?>
	</div>
</div>

