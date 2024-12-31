<?php
/**
 * The Features Shortcode.
 */

use Aheto\Helper;

extract($atts);

$sliders = $this->parse_group($karma_sass_slider);
if ( empty($sliders) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-team--karma-sass1');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'karma_sass_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/team/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_sass-team-layout1', $shortcode_dir . 'assets/css/karma_sass_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="swiper">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $sliders as $index => $item ) : ?>
					<div class="swiper-slide">
							<?php if ( !empty($item['karma_sass_image']) ) :
								$background_image = Helper::get_background_attachment($item['karma_sass_image'], 'medium', $atts, '');
								?>
								<div class="aheto-team__image" <?php echo esc_attr($background_image);?>>
									<?php
									echo Helper::get_social_networks_list('<a class="aheto-team__link" href="%1$s" target="_blank" rel="noreferrer noopener"><i class="ion-social-%2$s"></i></a>', 'karma_sass_', $item);
									?>
								</div>
							<?php endif; ?>
						<?php if ( !empty($item['karma_sass_name']) ) : ?>
							<div class="aheto-team__name">
								<?php echo esc_html($item['karma_sass_name']);?>
							</div>
						<?php endif; ?>
						<?php if ( !empty($item['karma_sass_position']) ) : ?>
							<div class="aheto-team__position">
								<?php echo esc_html($item['karma_sass_position']);?>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
			<?php $this->swiper_arrow('karma_sass_'); ?>
	</div>
</div>
