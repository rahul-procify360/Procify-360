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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading--mooseoom__simple' );
$this->add_render_attribute( 'wrapper', 'class', $alignment );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	// Heading.
	$heading = $this->get_heading();

	if ( !empty($mooseoom_subtitle) ) {
		echo '<' . $mooseoom_subtitle_tag . ' class="aheto-heading__subtitle">' . wp_kses_post( $mooseoom_subtitle ) . '</' . $mooseoom_subtitle_tag . '>';
	}

	if ( !empty($heading) ) {

	    $heading = $this->highlight_text( $heading );

		echo '<' . $text_tag . ' class="aheto-heading__title">' . wp_kses_post($heading) . '</' . $text_tag . '>';

	}

	?>

</div>
