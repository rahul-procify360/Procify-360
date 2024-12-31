<?php
/**
 * The Noize Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto_media--karma-political-simple' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('magnific');
    wp_enqueue_style( 'karma-political-media-style-1', $shortcode_dir . 'assets/css/karma_political_layout1.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('magnific');
	wp_enqueue_script('karma-political-media-layout1-js', $shortcode_dir . 'assets/js/karma_political_layout1.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto_media--img">
        <div class="grid-sizer"></div>

        <?php
            foreach ($karma_political_image as $image) {
                $image_id = is_array( $image ) && ! empty( $image['id'] ) ? $image['id'] : $image;
                $image_url = wp_get_attachment_image_url( $image_id, 'full' );
                $background_image = Helper::get_background_attachment($image, $karma_political_image_size, $atts, 'karma_political_');
        ?>

            <a href="<?php echo esc_url($image_url) ?>" class="grid-item">
                <span <?php echo esc_attr($background_image); ?>></span>
            </a>

        <?php } ?>

    </div>

</div>
