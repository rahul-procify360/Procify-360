<?php
/**
 * The Moovit Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $moovit_responsive_image ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $moovit_align );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-media--moovit-responsive' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_script( 'moovit-media-layout2', $shortcode_dir . 'assets/js/moovit_layout2.min.js', array( 'jquery' ), null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-single-img <?php echo esc_attr( $moovit_align ); ?>"
         data-width='<?php echo esc_attr( $moovit_max_width_hide['size'] ) ?>'>
		<?php echo Helper::get_attachment( $moovit_responsive_image, [ 'class' => 'aheto-single-img__img' ], $moovit_image_size, $atts, 'moovit_' ); ?>
    </div>

</div>
