<?php
/**
 * The Blockquote Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */
use Aheto\Helper;

extract( $atts );

if ( empty( $soapy_quote ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'blockqoute', 'class', 'aheto-quote--soapy-simple' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/blockquote/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-blockquote-layout1', $shortcode_dir . 'assets/css/soapy_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<blockquote <?php $this->render_attribute_string( 'blockqoute' ); ?>>
		<?php
		// Qoute.
		$qoute_tag = isset($qoute_tag) && !empty($qoute_tag) ? $qoute_tag : 'h1';
		echo '<' . $qoute_tag . ' class="aheto-quote__quote">' . wp_kses( $soapy_quote, 'post' ) . '</' . $qoute_tag . '>';
		// Author.
		if ( !empty( $soapy_author ) ) {
			echo '<h5 class="aheto-quote__author">' . wp_kses( $soapy_author, 'post' ) . '</h5>';
		}
		// Position.
		if ( !empty( $soapy_position ) ) {
			echo '<h4 class="aheto-quote__position">' . wp_kses( $soapy_position, 'post' ) . '</h4>';
		}
		?>
	</blockquote>
</div>
