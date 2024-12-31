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

if ( empty($saasworld_image_video) ) {

	return '';
}
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-media--saasworld');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
if ( $saasworld_hide_video == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-media--saasworld-hide-mobile');

}
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('saasworld-media_layout1', $shortcode_dir . 'assets/css/saasworld_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if ( !empty($saasworld_image_video) ): ?>
		<div class="aheto-media__container" <?php echo esc_attr($background_image); ?>>
			<?php if ( !empty($saasworld_video_link) ) { ?>
                <video id="videobcg" preload="auto" autoplay="true" loop="loop" muted="muted" volume="0">
                    <source src="<?php echo esc_url($saasworld_video_link); ?>" type="video/mp4">
                </video>
			<?php } ?>
			<?php echo Helper::get_attachment( $saasworld_image_video, [ 'class' => 'aheto-media__img' ], $saasworld_image_size, $atts, 'saasworld_' ); ?>
		</div>
	<?php endif; ?>
</div>
