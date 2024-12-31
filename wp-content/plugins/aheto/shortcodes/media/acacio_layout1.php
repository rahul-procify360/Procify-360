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
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_script('acacio-media-layout1-js', $shortcode_dir . 'assets/js/acacio_layout1.js', array('jquery'), null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="aheto-single-img" data-width='<?php echo esc_attr($acacio_max_width_hide['size']) ?>'>
        <?php if (isset($acacio_image) && !empty($acacio_image)) : ?>
            <?php echo \Aheto\Helper::get_attachment( $acacio_image, ['class' => 'aheto-single-img__img'], $acacio_image_size, $atts, 'acacio_' ); ?>
        <?php endif; ?>
	</div>

</div>
