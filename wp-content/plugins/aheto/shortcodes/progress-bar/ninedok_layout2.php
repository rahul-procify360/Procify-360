<?php
/**
 * The Progress Bar Shortcode.
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
$this -> add_render_attribute ( 'wrapper', 'class', 'aheto-progress' );
$this -> add_render_attribute ( 'wrapper', 'class', 'aheto-progress--ninedok-modern' );
$this -> add_render_attribute ( 'wrapper', 'class', $this -> the_custom_classes () );


/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style ( 'ninedok-progress-bar-layout2', $shortcode_dir . 'assets/css/ninedok_layout2.css', null, null );
} ?>

<div <?php $this -> render_attribute_string ( 'wrapper' ); ?>>

    <div class="aheto-progress aheto-progress--bar">

		<?php if ( !empty( $ninedok_s_image )) : ?>
            <div class="aheto-progress__image-wrap">
                <div class="aheto-progress__image">
					<?php echo \Aheto\Helper ::get_attachment ( $ninedok_s_image, array (), $ninedok_image_size, $atts, 'ninedok_' ); ?>
                </div>
            </div>
		<?php endif; ?>


		<?php
		// Percentage.
		if ( !empty( $percentage )) {
			echo '<h6 class="aheto-counter__number js-counter">' . absint ( $percentage ) . '</h6>';
		}

		// Heading.
		if ( !empty( $heading )) {
			echo '<' . $ninedok_heading_tag . ' class="aheto-counter__heading">' . wp_kses ( $heading, 'post' ) . '</' . $ninedok_heading_tag . '>';
		}
		?>


    </div>

</div>
