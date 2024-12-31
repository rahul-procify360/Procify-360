<?php
/**
 * The Button Shortcode(Video-Inline ).
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $this->atts['element_id'] );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-video--djo-inline' );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/video-btn/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('djo-video-btn-layout2', $shortcode_dir . 'assets/css/djo_layout2.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('djo-video-btn-layout2-js', $shortcode_dir . 'assets/js/djo_layout2.min.js', array('jquery'), null);
}
/**
 * Get video ID
 */

if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $atts["video_link"], $match)) {
    $video_id = $match[1];
}

// SEO-title for image
$djo_title = ! empty($djo_title) ? $djo_title : 'video';

$image = !empty( $djo_image['url'] ) ? Helper::get_attachment($djo_image, [], 'large') : '<img src="https://i.ytimg.com/vi/' . $video_id . '/maxresdefault.jpg">';
?>

<?php if( ! empty( $atts["video_link"] ) ): ?>

	<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-video js-video" data-id="<?php echo esc_attr($video_id); ?>">
		<a class="aheto-video__link js-link s-back-switch" href="<?php echo 'https://youtu.be/' . $video_id; ?>">
			<?php echo wp_kses_post($image); ?>
		</a>
		<button class="aheto-video__button js-button" type="button" aria-label="<?php echo esc_html__( 'Play video' , 'djo' ); ?>"></button>
	</div>
	</div>

<?php endif; ?>
