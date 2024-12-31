<?php

/**
 * The Testimonials Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$members = $this->parse_group($pointe_slider);
if (empty($members)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-team-member--wrapper--pointe');

// parse networks
$networks = $this->parse_group($networks);

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'    => 1000,
	'autoplay' => false,
	'spaces'   => 30,
	'slides'   => 6,
	'arrows'    => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'pointe_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/team-member/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('pointe-team-member-layout2', $sc_dir . 'assets/css/pointe_layout2.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="d-flex flex-direction-column flex-column-reverse">
		<div class="swiper swiper-bottom">
			<div class="swiper-container" <?php echo esc_attr($carousel_params); ?> >
				<div class="swiper-wrapper">
					<?php foreach ($pointe_slider as $slide) :

						$image = $slide['pointe_image_slide'];

						$background_image = Helper::get_background_attachment($image, 'full', $atts);
					?>
						<div class="swiper-slide" <?php echo esc_attr($background_image); ?>>

							<div class="aheto-team-member-content">


							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php $this->swiper_arrow('pointe_swiper_'); ?>
		</div>
		<div class="swiper swiper-top">
			<div class="swiper-container" data-thumbs="1" data-slides="1" data-effect="fade" data-simulate_touch="1" data-autoplay="3000">
				<div class="swiper-wrapper">
					<?php foreach ($pointe_slider as $slide) :
						$image = $slide['pointe_image'];

						$background_image = Helper::get_background_attachment($image, 'full', $atts);
					?>
						<div class="swiper-slide" <?php echo esc_attr($background_image); ?>>
							<div class="aheto-team-member-content">
								<div class="aheto-team-member-text">
									<?php
									// Subtitle
									if (!empty($slide['pointe_subtitle'])) {
										echo '<h4 class="aheto-team-member-content-text__subtitle">' . wp_kses_post($slide['pointe_subtitle']) . '</h4>';
									}
									// Name
									if (!empty($slide['pointe_name'])) {
										echo '<h2 class="aheto-team-member-content-text__title">' . wp_kses_post($slide['pointe_name']) . '</h2>';
									}
									// Description
									if (!empty($slide['pointe_dec'])) {
										echo '<p class="aheto-team-member-content-text__description">' . wp_kses_post($slide['pointe_dec']) . '</p>';
									}
									?>

								</div>

								<div class="aheto-team-member-content__social">
									<?php
									// Social Networks
									$slide['font_icon'] = isset( $slide['font_icon'] ) && ! empty( $slide['font_icon'] ) ? $slide['font_icon'] : 'elegant';
									$font_icon         = $slide['font_icon'] == 'elegant' ? 'ion-social-' : 'el social_';

									echo Helper::get_social_networks_list( '<a class="aheto-team-member-content__social--link icon" href="%1$s"><i class="' . $font_icon . '%2$s"></i></a>', 'pointe_slider_', $slide );

									?>

								</div>
								<div class="aheto-team-member__signature">
									<?php if (!empty($slide['pointe_signature'])) {
										echo Helper::get_attachment($slide['pointe_signature'], $image_size);
									}
									?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
