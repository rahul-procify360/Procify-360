<?php

/**
 * The Testimonials Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Kunst <info@kunst.com>
 */

use Aheto\Helper;

extract($atts);

$kunst_testimonials = $this->parse_group($kunst_testimonials);

if ( empty($kunst_testimonials) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-tm-wrapper--kunst__modern' );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'    => 1000,
	'autoplay' => false,
	'spaces'   => 30,
	'slides'   => 3,
	'arrows'    => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'kunst_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'kunst-testimonials-layout1', $shortcode_dir . 'assets/css/kunst_layout1.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script( 'kunst-testimonials-layout1-js', $shortcode_dir . 'assets/js/kunst_layout1.min.js', array( 'jquery' ), null );
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper  <?php echo esc_attr($kunst_style); ?>">
		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $kunst_testimonials as $item ) : ?>
					<div class="swiper-slide">
						<div class="aheto-tm__slide-wrap">
							<div class="aheto-tm__content">
								<?php
									// Testimonial.
									if ( isset( $item['kunst_testimonial'] ) && !empty( $item['kunst_testimonial'] ) ) {
										echo '<h2 class="aheto-tm__text">' . wp_kses($item['kunst_testimonial'], 'post') . '</h2>';
									}
								?>
                                <div class="aheto-tm__author">
                                    <div class="aheto-tm__info">
                                        <?php
											// Name.
											if ( isset( $item['kunst_name'] ) && !empty( $item['kunst_name'] ) ) {
												echo '<h6 class="aheto-tm__name">' . wp_kses($item['kunst_name'], 'post') . '</h6>';
											}
											// Company.
											if ( isset( $item['kunst_position'] ) && !empty( $item['kunst_position'] ) ) {
												echo '<h6 class="aheto-tm__position">' . wp_kses($item['kunst_position'], 'post') . '</h6>';
											}
                                        ?>
                                    </div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
            <?php $this->swiper_pagination('kunst_swiper_'); ?>
		</div>
	</div>
</div>
