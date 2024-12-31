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

$bizy_dark = isset($bizy_dark) && !empty($bizy_dark) ? 'dark-style' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading--bizy__simple' );
$this->add_render_attribute( 'wrapper', 'class', $alignment );
$this->add_render_attribute( 'wrapper', 'class', 'align-mob-' . $bizy_align_mobile );
$this->add_render_attribute( 'wrapper', 'class', $bizy_dark );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'bizy-heading-layout1', $shortcode_dir . 'assets/css/bizy_layout1.css', null, null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	// Heading.
	$heading = $this->get_heading();

	if ( ! empty( $bizy_subtitle ) ) { ?>
		<div class="aheto-heading__subtitle"><?php echo esc_html( $bizy_subtitle ); ?></div>
        <h6 class="aheto-heading__subtitle-mob"><?php echo esc_html( $bizy_subtitle ); ?></h6>
	<?php }

	if ( ! empty( $heading ) ) {

		$heading = $this->highlight_text( $heading );

		echo '<' . $text_tag . ' class="aheto-heading__title">' . wp_kses( $heading, 'post' ) . '</' . $text_tag . '>';

	} ?>

</div>
