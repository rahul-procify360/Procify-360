<?php
/**
 * The Banner Slider Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);


$banners = $this->parse_group($azyn_modern_banners);

if ( empty($banners) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-full-page-height-js');
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--azyn-modern');

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('azyn-banner-slider-layout1', $sc_dir . 'assets/css/azyn_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('barba');
	wp_enqueue_script('tweenmax-all');
	wp_enqueue_script('azyn-banner-slider-layout1-js', $sc_dir . 'assets/js/azyn_layout1.min.js', array('jquery', 'tweenmax-all'), null, true);
} ?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<svg style="display: none" xmlns="http://www.w3.org/2000/svg">

		<!-- arrow left -->
		<symbol viewBox="0 0 14 26" id="icn_arrow_left">
			<path d="M13,26c-0.256,0-0.512-0.098-0.707-0.293l-12-12c-0.391-0.391-0.391-1.023,0-1.414l12-12c0.391-0.391,1.023-0.391,1.414,0s0.391,1.023,0,1.414L2.414,13l11.293,11.293c0.391,0.391,0.391,1.023,0,1.414C13.512,25.902,13.256,26,13,26z"/>
		</symbol>

		<!-- arrow right -->
		<symbol viewBox="0 0 14 26" id="icn_arrow_right">
			<path d="M1,0c0.256,0,0.512,0.098,0.707,0.293l12,12c0.391,0.391,0.391,1.023,0,1.414l-12,12c-0.391,0.391-1.023,0.391-1.414,0s-0.391-1.023,0-1.414L11.586,13L0.293,1.707c-0.391-0.391-0.391-1.023,0-1.414C0.488,0.098,0.744,0,1,0z"/>
		</symbol>

	</svg>

	<div id="barba-wrapper">
		<div class="barba-container">

			<div class="aheto_smooth">

				<div id="q_slide" data-animate='stagTop' data-autoplay='8000' data-mousefollow data-parallax=".25" data-opacity=".3" class="aheto-full-min-height-js">
					<div class="q_slide-inner">
						<div class="slides">

							<?php

							$counter = 1;

							$pagination = '';

							foreach ($banners as $banner) :
							$banner = wp_parse_args($banner, [
								'azyn_image' => '',
								'azyn_subtitle' => '',
								'azyn_title' => '',
								'azyn_heading_tag' => '',
							]);
							extract($banner);

							if (!$azyn_image) {
								continue;
							}

							$active = $counter === 1 ? 'q_current' : '';
							?>

							<div class="slide <?php echo esc_attr($active); ?>">
								<div class="slide-content">
									<div class="caption">
										<?php if(!empty($azyn_subtitle)){ ?>
											<div class="q_split">
												<h6 class="q_split_wrap">
													<?php echo esc_html($azyn_subtitle); ?>
												</h6>
											</div>
										<?php }

										if(!empty($azyn_title)){ ?>
											<div class="q_split">
												<<?php echo esc_attr($azyn_heading_tag);?> class="q_split_wrap slide-title">
												<?php echo esc_html($azyn_title); ?>
												</<?php echo esc_attr($azyn_heading_tag);?>>
											</div>
										<?php
										}

										if(!empty($azyn_title_second)){ ?>
											<div class="q_split">
												<<?php echo esc_attr($azyn_heading_tag);?> class="q_split_wrap slide-title">
												<?php echo esc_html($azyn_title_second); ?>
												</<?php echo esc_attr($azyn_heading_tag);?>>
											</div>
										<?php
										} ?>

									</div>
								</div>
								<div class="image-container">
							<div class="image-wrapper">
								<div class="kenburns">
									<?php echo Helper::get_attachment($azyn_image, ['class' => 'image']); ?>
								</div>
							</div>
						</div>
							</div>

					<?php

					$num = $counter < 10 ? '0' . $counter : $counter;
					$pagination .= '<div class="item hover-target '. esc_attr($active) .'"><span><strong>'. esc_html($num) .'</strong></span></div>';

					$counter++;

					endforeach; ?>

				</div>

				<div class="pagination">
					<?php echo $pagination; ?>
				</div>
				<div class="arrows">
					<a class="arrow next aheto_magnet">
                                <span class="svg svg-arrow-right">
                                    <svg width="8px" height="21px">
                                        <use xlink:href="#icn_arrow_right"></use>
                                    </svg>
                                    <span class="alt sr-only"></span>
                                </span>
					</a>
					<a class="arrow prev aheto_magnet">
                                <span class="svg svg-arrow-left">
                                    <svg width="8px" height="21px">
                                        <use xlink:href="#icn_arrow_left"></use>
                                    </svg>
                                    <span class="alt sr-only"></span>
                                </span>
					</a>
				</div>
				<div class="progress">
					<div id="bar" class="bar"></div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
