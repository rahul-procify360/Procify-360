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

$hryzantema_testimonials = $this->parse_group($hryzantema_testimonials);
if ( empty($hryzantema_testimonials) ) {
	return '';
}
$hryzantema_hide_pagination = isset($hryzantema_hide_pagination) && $hryzantema_hide_pagination ? 'hide-pagination' : '';
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--hr-modern');
$this->add_render_attribute( 'wrapper', 'class', $hryzantema_hide_pagination );

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

$carousel_params = Helper::get_carousel_params($atts, 'hryzantema_swiper_', $carousel_default_params);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-testimonials-layout1', $shortcode_dir . 'assets/css/hryzantema_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php if(!empty($hryzantema_bg_text)){ ?>
		<div class="aheto-tm__bg-text"><?php echo esc_html($hryzantema_bg_text); ?></div>
	<?php } ?>

	<div class="swiper">

		<div class="swiper-container" <?php echo esc_attr($carousel_params); ?> data-centeredSlides="1">

			<div class="swiper-wrapper">

				<?php foreach ( $hryzantema_testimonials as $item ) : ?>

					<div class="swiper-slide">

						<div class="aheto-tm__slide-wrap">

							<div class="aheto-tm__content">
                                <div class="aheto-tm__rating">
                                    <?php
                                        if(!empty($item['g_rating']) ) {
                                            for($i=0;$i<$item['g_rating'];$i++) { ?>
                                                <i class="fa fa-star"></i> <?php
                                            }
                                            for($i=$item['g_rating']; $i<5;$i++) { ?>
                                                <i class="fa fa-star-o"></i> <?php
                                            }
                                        }
                                    ?>
                                </div>
								<?php
								// Testimonial.
								if ( !empty($item['g_testimonial']) ) {
									echo '<h4 class="aheto-tm__text">' . wp_kses_post($item['g_testimonial']) . '</h4>';
								} ?>
							</div>

							<div class="aheto-tm__author">

                                <?php if ( !empty($item['g_image']) ) : ?>
                                    <?php
                                        $hryzantema_avatar =  \Aheto\Helper::get_background_attachment( $item['g_image'], $hryzantema_image_size, $atts, 'hryzantema_' );
                                    ?>
                                    <div class="aheto-tm__avatar" <?php echo esc_attr($hryzantema_avatar); ?>></div>
                                <?php endif; ?>

								<div class="aheto-tm__info">
									<?php
									// Name.
									if ( !empty($item['g_name']) ) {
										echo '<h5 class="aheto-tm__name">' . wp_kses_post($item['g_name']) . '</h5>';
									}

									// Company.
									if ( !empty($item['g_company']) ) {
										echo '<p class="aheto-tm__position">' . wp_kses_post($item['g_company']) . '</p>';
									}
									?>
								</div>

							</div>

						</div>

					</div>

				<?php endforeach; ?>

			</div>
            <?php $this->swiper_pagination('hryzantema_swiper_'); ?>
		</div>

	</div>

</div>
