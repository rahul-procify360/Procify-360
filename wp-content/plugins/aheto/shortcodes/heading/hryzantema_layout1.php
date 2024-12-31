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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading--hr__simple' );
$this->add_render_attribute( 'wrapper', 'class', $alignment );
$this->add_render_attribute( 'wrapper', 'class', 'align-mob-' . $hryzantema_align_mobile );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$animation = isset( $title_animation ) && !empty( $title_animation );
$hryzantema_use_dot = isset( $hryzantema_use_dot ) && ! empty( $hryzantema_use_dot ) ? 'hr-dot' : '';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-heading-layout1', $shortcode_dir . 'assets/css/hryzantema_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('typed');
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	// Heading.
	$heading = $this->get_heading();

	if ( !empty($hryzantema_subtitle )) {
		echo '<' . $hryzantema_subtitle_tag . ' class="aheto-heading__subtitle">' . esc_html( $hryzantema_subtitle ) . '</' . $hryzantema_subtitle_tag . '>';
	}

	if ( !empty($heading) ) {
		echo '<' . $text_tag . ' class="aheto-heading__title ' . esc_attr( $hryzantema_use_dot ) . '">' . $this->highlight_text( $heading, $animation ) . '</' . $text_tag . '>';
	}
	?>

</div>
