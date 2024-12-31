<?php
/**
 * The Progress Bar Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'progress-bar-style-3', $sc_dir . 'assets/css/layout3.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-counter aheto-counter--classic">

		<?php
		$this->the_icon( 'aheto-counter__icon' );

		// Percentage.
		if ( ! empty( $percentage ) && is_numeric( $percentage ) ) {
			echo '<div class="aheto-counter__number js-counter">' . absint( $percentage ) . '</div>';
		}

		// Description.
		if ( ! empty( $description ) ) {
			echo '<p class="aheto-counter__desc">' . esc_html( $description ) . '</p>';
		}
		?>
    </div>

</div>
