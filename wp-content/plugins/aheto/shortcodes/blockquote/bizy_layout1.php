<?php
/**
 * The Blockquote Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

extract( $atts );

use Aheto\Helper;

if ( empty( $quote ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-quote--bizy-simple' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/blockquote/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'bizy-blockquote-layout1', $shortcode_dir . 'assets/css/bizy_layout1.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php echo Helper::get_attachment($bizy_image, [], $bizy_image_size, $atts, 'bizy_'); ?>

    <blockquote class="aheto-quote--bizy-simple__content">
        <img src="<?php echo esc_url($shortcode_dir . 'assets/images/quote.png'); ?>" alt="quote" width="57px" height="55px" class="aheto-quote--bizy-simple__quote">

		<?php
		// Qoute.
		$qoute_tag = isset( $qoute_tag ) && ! empty( $qoute_tag ) ? $qoute_tag : 'h1';
		echo '<' . $qoute_tag . '>' . wp_kses( $quote, 'post' ) . '</' . $qoute_tag . '>'; ?>

    </blockquote>
</div>
