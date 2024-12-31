<?php
/**
 * The Bg Text Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading--djo__bg' );
$this->add_render_attribute( 'wrapper', 'class', $alignment );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('djo-heading-layout2', $shortcode_dir . 'assets/css/djo_layout2.css', null, null);
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <?php if ( ! empty( $djo_text ) ) {
            echo '<' . $text_tag . ' class="aheto-heading__bg-title">' . $djo_text . '</' . $text_tag . '>';
        } ?>

</div>
