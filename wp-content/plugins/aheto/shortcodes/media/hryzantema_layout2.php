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

$videos = $this->parse_group($hryzantema_video_slider);

if ( empty($videos) ) {
	return '';
}


$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-media--video');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-media-layout2', $shortcode_dir . 'assets/css/hryzantema_layout2.css', null, null);
}
/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed'     => 1500,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Aheto\Helper::get_carousel_params( $atts, 'hryzantema_swiper_', $carousel_default_params );

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="swiper-container"  <?php echo esc_attr($carousel_params); ?> data-centeredSlides="1" >
        <div class="swiper-wrapper">

            <?php foreach ( $videos as $slide ) : ?>
                <?php $slide = wp_parse_args($slide, [
                    'hryzantema_video_image'         => '',
                    'hryzantema_add_video_button'         => '',
                ]);
                extract($slide);


                if ( empty($hryzantema_video_image) ) {
                    continue;
                } else {
                    $hryzantema_video_bg =  \Aheto\Helper::get_background_attachment( $hryzantema_video_image, $hryzantema_image_size, $atts, 'hryzantema_' );
                } ?>
                <div class="swiper-slide" <?php echo esc_attr($hryzantema_video_bg); ?>>
                        <?php if ( $hryzantema_add_video_button == true ) {
                                echo \Aheto\Helper::get_video_button( $slide, 'hryzantema_' );
                        } ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

</div>
