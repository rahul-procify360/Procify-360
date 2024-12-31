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

$acacio_testimonials = $this->parse_group($acacio_testimonials);
if ( empty($acacio_testimonials) ) {
	return '';
}
$acacio_hide_pagination = isset($acacio_hide_pagination) && $acacio_hide_pagination ? 'hide-pagination' : '';
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--acacio-modern');
$this->add_render_attribute( 'wrapper', 'class', $acacio_hide_pagination );

// Swiper.
if ( !$custom_options ) {
	$speed  = 500;
	$space  = 30;
	$slides = 1;
	$large  = 1;
	$medium = 1;
	$small  = 1;
}

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'    => 1000,
	'spaces'   => 27,
	'slides'   => 2,
	'arrows'    => true,
	'overflow' => false,
	'slides_sm' => 1,
	'slides_lg' => 2,
	'slides_md' => 1
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'acacio_swiper_', $carousel_default_params);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('acacio-testimonials-layout1', $shortcode_dir . 'assets/css/acacio_layout1.css', null, null);

}


?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php if(!empty($acacio_bg_text)){ ?>
		<div class="aheto-tm__bg-text"><?php echo esc_html($acacio_bg_text); ?></div>
	<?php } ?>

	<div class="swiper">

		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?> data-centeredSlides="1">

			<div class="swiper-wrapper">

				<?php foreach ( $acacio_testimonials as $item ) : ?>

					<div class="swiper-slide">

						<div class="aheto-tm__slide-wrap">

							<div class="aheto-tm__content">
								<?php
								// Testimonial.
								if ( isset($item['g_testimonial']) && !empty($item['g_testimonial']) ) {
									echo '<h4 class="aheto-tm__text">' . wp_kses_post($item['g_testimonial']) . '</h4>';
								} ?>
							</div>

							<div class="aheto-tm__author">

								<?php if ( !empty($item['g_image']) ) : ?>
									<?php
									$acacio_avatar =  \Aheto\Helper::get_background_attachment( $item['g_image'], $acacio_image_size, $atts, 'acacio_' );
									?>
                                    <div class="aheto-tm__avatar" <?php echo esc_attr($acacio_avatar); ?>></div>
								<?php endif; ?>

								<div class="aheto-tm__info">
									<?php
									// Name.
									if ( isset($item['g_name']) && !empty($item['g_image']) ) {
										echo '<h5 class="aheto-tm__name">' . wp_kses_post($item['g_name']) . '</h5>';
									}

									// Company.
									if ( isset($item['g_company']) && !empty($item['g_company']) ) {
										echo '<p class="aheto-tm__position">' . wp_kses_post($item['g_company']) . '</p>';
									}
									?>
								</div>

							</div>

						</div>

					</div>

				<?php endforeach; ?>

			</div>
            <?php $this->swiper_pagination('acacio_swiper_'); ?>
		</div>

	</div>

</div>
