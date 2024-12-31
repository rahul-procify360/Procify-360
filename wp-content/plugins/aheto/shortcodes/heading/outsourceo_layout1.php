<?php
/**
 * The Heading Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading--outsourceo__simple' );
$this->add_render_attribute( 'wrapper', 'class', $alignment );
$this->add_render_attribute( 'wrapper', 'class', 'align-tablet-' . $outsourceo_align_tablet );
$this->add_render_attribute( 'wrapper', 'class', 'align-mob-' . $outsourceo_align_mobile );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$outsourceo_use_dot = isset( $outsourceo_use_dot ) && ! empty( $outsourceo_use_dot ) ? 'outsourceo-dot' : '';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-heading-layout1', $shortcode_dir . 'assets/css/outsourceo_layout1.css', null, null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	// Heading.
	$heading = $this->get_heading();

	if ( ! empty( $outsourceo_subtitle ) ) {
		echo '<' . $outsourceo_subtitle_tag . ' class="aheto-heading__subtitle">' . esc_html( $outsourceo_subtitle ) . '</' . $outsourceo_subtitle_tag . '>';
	}

	if ( ! empty( $heading ) ) {

		$heading = $this->highlight_text( $heading );

		if ( $outsourceo_use_dot ) {

			$heading = str_replace( '{{.}}', '<span class="outsourceo-dot dot-primary"></span>', $heading );

			$words = explode( " ", $heading );

			if ( count( $words ) > 0 ) {
				$last_word = $words[ count( $words ) - 1 ];

				$last_space_position = strrpos( $heading, ' ' );
				$start_string        = substr( $heading, 0, $last_space_position );

				$heading = wp_kses( $start_string, 'post' ) . ' <span class="outsourceo-dot dot-primary">' . wp_kses( $last_word, 'post' ) . '</span>';
			} else {
				$heading = '<span class="outsourceo-dot dot-primary">' . wp_kses( $heading, 'post' ) . '</span>';
			}

		} else {
			$heading = wp_kses( $heading, 'post' );
		}

		echo '<' . $text_tag . ' class="aheto-heading__title">' . $heading . '</' . $text_tag . '>';
	} ?>

</div>
