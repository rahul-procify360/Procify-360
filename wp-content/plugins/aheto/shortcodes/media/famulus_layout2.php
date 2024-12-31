<?php
/**
 * The Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if ( empty($famulus_image_video) ) {

	return '';
}
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-media-video');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
if ( $famulus_high_video == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-media-video-higher');

}
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('magnific');
	wp_enqueue_style('famulus-media_layout2', $shortcode_dir . 'assets/css/famulus_layout2.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('magnific');
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if ( !empty($famulus_image_video) ):
		$background_image = Helper::get_background_attachment($famulus_image_video, $famulus_image_size, $atts);
		?>
		<div class="aheto-media-video__container" <?php echo esc_attr($background_image); ?>>
			<?php if ( !empty($famulus_video_link) ) { ?>
				<a href="<?php echo esc_url($famulus_video_link); ?>"
				   class="js-video-btn aheto-media-video__link ">
					<i></i>
				</a>
			<?php } ?>
		</div>
	<?php endif; ?>
</div>
