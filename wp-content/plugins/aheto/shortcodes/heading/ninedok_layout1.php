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

extract ( $atts );

$this -> generate_css ();


// Wrapper.
$this -> add_render_attribute ( 'wrapper', 'id', $element_id );
$this -> add_render_attribute ( 'wrapper', 'class', 'aheto-heading--ninedok__simple' );
$this -> add_render_attribute ( 'wrapper', 'class', $alignment );
$this -> add_render_attribute ( 'wrapper', 'class', 'align-mob-' . $align_mobile );
$this -> add_render_attribute ( 'wrapper', 'class', $this -> the_custom_classes () );

$animation = isset( $title_animation ) && !empty( $title_animation );

/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style ( 'ninedok-heading-layout1', $shortcode_dir . 'assets/css/ninedok_layout1.css', null, null );
} ?>

<div <?php $this -> render_attribute_string ( 'wrapper' ); ?>>

	<?php
	// Heading.
	$heading = $this -> get_heading ();

	if ( !empty( $ninedok_subtitle )) { ?>
        <p class="aheto-heading__subtitle"><?php echo wp_kses ( $ninedok_subtitle, 'post' ); ?></p>
	<?php }

	if (!empty($heading)) {
		echo '<' . $text_tag . ' class="aheto-heading__title">' . $this -> highlight_text ( $heading, $animation ) . '</' . $text_tag . '>';
	}

	if ( !empty( $ninedok_description )) {
		echo '<' . $ninedok_desk_tag . ' class="aheto-heading__description">' . wp_kses ( $ninedok_description, 'post' ) . '</' . $ninedok_desk_tag . '>';
	}


	?>

</div>
