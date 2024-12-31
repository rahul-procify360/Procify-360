<?php
/**
 * The Progress Bar Shortcode.
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


/**
 * Set dependent style
 */
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/progress-bar/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'acacio-progress-bar-layout2', $shortcode_dir . 'assets/css/acacio_layout2.css', null, null );

}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="aheto-counter aheto-counter--acacio-classic">

		<?php
		$this->the_icon( 'aheto-counter__icon' );

		// Percentage.
		if ( !empty($acacio_numbers) ) {
			echo '<h2 class="aheto-counter__number js-counter">' . absint( $acacio_numbers ) . '</h2>';
		}

		// Description.
		if ( !empty($heading) ) {
			echo '<'. $acacio_heading_tag .'  class="aheto-counter__heading">' . wp_kses_post( $heading ) . '</' . $acacio_heading_tag . '>';
		}
		?>
	</div>

</div>
