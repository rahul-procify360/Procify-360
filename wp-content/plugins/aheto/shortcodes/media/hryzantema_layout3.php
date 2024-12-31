<?php
/**
 * The HR Consult Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if ( empty($hryzantema_image) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-single-gallery-img--hr');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-media-layout3', $shortcode_dir . 'assets/css/hryzantema_layout3.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('hryzantema-media-layout3-js', $shortcode_dir . 'assets/js/hryzantema_layout3.js', array('jquery'), null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php $gallery_img = !empty($hryzantema_image) ? \Aheto\Helper::get_background_attachment($hryzantema_image, $hryzantema_image_size, $atts, 'hryzantema_') : ''; ?>

	<div class="aheto-single-gallery-img" <?php echo esc_attr($gallery_img) ?>></div>

	<div class="aheto-single-gallery-popup">
		<?php if ( !empty($hryzantema_image) && isset($hryzantema_image) ) : ?>
			<?php echo \Aheto\Helper::get_attachment($hryzantema_image, ['class' => ''], $hryzantema_image_size, $atts, 'hryzantema_'); ?>
		<?php endif; ?>
		<span class='close'>&times;</span>
	</div>

</div>
