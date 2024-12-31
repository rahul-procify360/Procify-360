<?php
/**
 * The Acacio Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if ( empty($acacio_image) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'acacio-media-layout3', $shortcode_dir . 'assets/css/acacio_layout3.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('acacio-media-layout3-js', $shortcode_dir . 'assets/js/acacio_layout3.js', array('jquery'), null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <?php if (isset($acacio_image) && !empty($acacio_image) ) : ?>
        <?php $gallery_img =  \Aheto\Helper::get_background_attachment( $acacio_image, $acacio_image_size, $atts, 'acacio_' ); ?>
    <?php endif; ?>

    <div class="aheto-single-gallery-img" <?php echo esc_attr($gallery_img) ?>></div>

    <div class="aheto-single-gallery-popup">
        <?php if (isset($acacio_image) && !empty($acacio_image) ) : ?>
            <?php echo \Aheto\Helper::get_attachment( $acacio_image, ['class' => ''], $acacio_image_size, $atts, 'acacio_' ); ?>
        <?php endif; ?>
        <h3 class='close'>&times;</h3>
    </div>

</div>
