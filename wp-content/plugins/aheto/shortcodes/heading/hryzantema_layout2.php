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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading--hr__simple-font' );
$this->add_render_attribute( 'wrapper', 'class', $alignment );
$this->add_render_attribute( 'wrapper', 'class', 'align-mob-' . $hryzantema_align_mobile );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$use_dot = isset( $use_dot ) && ! empty( $use_dot ) ? 'hr-dot' : '';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-heading-layout2', $shortcode_dir . 'assets/css/hryzantema_layout2.css', null, null);
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	// Heading.
	$heading = $this->get_heading();

	$disable_color = $hryzantema_highlighted_text ? 'color-none' : '';

	if ( !empty($hryzantema_title) ) {
		echo '<' . $hryzantema_title_tag . ' class="aheto-heading__subtitle">' . esc_html( $hryzantema_title ) . '</' . $hryzantema_title_tag . '>';
	}

	if ( !empty($heading) ) {
		echo '<' . $text_tag . ' class="aheto-heading__title ' . esc_attr( $use_dot ) . esc_attr( $disable_color ) . '">' . $this->highlight_text( $heading) . '</' . $text_tag . '>';
	}

    if (   !empty($hryzantema_description) ) {
        echo '<p class="aheto-heading__desc">' . wp_kses_post( $hryzantema_description ) . '</p>';
    }
	?>

</div>
