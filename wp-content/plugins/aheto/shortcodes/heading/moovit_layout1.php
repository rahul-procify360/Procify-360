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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading--moovit__simple' );
$this->add_render_attribute( 'wrapper', 'class', $alignment );
$this->add_render_attribute( 'wrapper', 'class', 'align-mob-' . $moovit_align_mobile );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-heading-layout1', $shortcode_dir . 'assets/css/moovit_layout1.css', null, null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	// Heading.
	$heading = $this->get_heading();

	if ( ! empty( $moovit_subtitle ) ) {
		echo '<' . $moovit_subtitle_tag . ' class="aheto-heading__subtitle">' . esc_html( $moovit_subtitle ) . '</' . $moovit_subtitle_tag . '>';
	}

	if ( ! empty( $heading ) ) {

		$heading = $this->highlight_text( $heading );

		if ( $moovit_use_dot ) {

			$heading = str_replace( '{{.}}', '<span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '"></span>', $heading );

			$words = explode( " ", $heading );

			if ( count( $words ) > 0 ) {
				$last_word = $words[ count( $words ) - 1 ];

				$last_space_position = strrpos( $heading, ' ' );
				$start_string        = substr( $heading, 0, $last_space_position );

				$heading =  wp_kses( $start_string, 'post' ) . ' <span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '">' . wp_kses( $last_word, 'post' ) . '</span>';
			} else {
				$heading = '<span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '">' . wp_kses( $heading, 'post' ) . '</span>';
			}

		} else {
			$heading = wp_kses( $heading, 'post' );
		}

		echo '<' . $text_tag . ' class="aheto-heading__title">' . $heading . '</' . $text_tag . '>';

	} ?>

</div>
