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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading--djo__simple' );
$this->add_render_attribute( 'wrapper', 'class', $alignment );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$djo_title_shadow = $djo_title_shadow ? ' aheto-heading__title--shadow' : '';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('djo-heading-layout1', $shortcode_dir . 'assets/css/djo_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
		// Heading.
		$heading = $this->get_heading();

		if ( ! empty( $djo_subtitle ) ) {
			echo '<' . $djo_subtitle_tag . ' class="aheto-heading__subtitle">' . esc_html( $djo_subtitle ) . '</' . $djo_subtitle_tag . '>';
		}

		if ( ! empty( $heading ) ) {
			echo '<' . $text_tag . ' class="aheto-heading__title' . $djo_title_shadow . '">' . $this->highlight_text( $heading ) . '</' . $text_tag . '>';
		}

		if ( ! empty( $description ) ) {
			echo '<p class="aheto-heading__desc">' . wp_kses_post( $description ) . '</p>';
		}
	?>

</div>
