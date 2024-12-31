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

$videos = $this->parse_group($karma_education_video_slider);

if ( empty($videos) ) {
	return '';
}

$karma_education_hide_pagination = isset($karma_education_hide_pagination) && $karma_education_hide_pagination ? 'hide-pagination' : '';

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-media--karma_education-video');
$this->add_render_attribute('wrapper', 'class', $karma_education_hide_pagination);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_education-media-layout1', $shortcode_dir . 'assets/css/karma_education_layout1.css', null, null);
}

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1500,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Aheto\Helper::get_carousel_params($atts, 'karma_education_swiper_', $carousel_default_params);

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">

		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?> data-centeredSlides="1">
			<div class="swiper-wrapper">

				<?php foreach ( $videos as $slide ) : ?>
					<?php $slide = wp_parse_args($slide, [
						'karma_education_video_image'      => '',
						'karma_education_add_video_button' => '',
					]);

					extract($slide);

					if ( empty($karma_education_video_image) ) {
						continue;
					} else {
						$karma_education_video_bg = \Aheto\Helper::get_background_attachment($karma_education_video_image, $karma_education_image_size, $atts, 'karma_education_');
					}
                ?>

					<div class="swiper-slide" <?php echo esc_attr($karma_education_video_bg); ?>>
						<?php
                            if ( $karma_education_add_video_button ) {
                                echo \Aheto\Helper::get_video_button($slide, 'karma_education_');
                            }
						?>
					</div>

				<?php endforeach; ?>

			</div>

            <?php if ( !empty( $this->atts[ 'karma_education_swiper_arrows' ] ) ) { ?>
			    <?php $this->swiper_pagination('karma_education_swiper_'); ?>
            <?php } ?>

		</div>

        <?php if ( !empty( $this->atts[ 'karma_education_swiper_arrows' ] ) ) { ?>
    		<?php $this->swiper_arrow('karma_education_swiper_'); ?>
        <?php } ?>

	</div>
</div>
