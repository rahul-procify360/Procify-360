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

extract( $atts );


$banners = $this->parse_group( $azyn_creative_banners );

if ( empty( $banners ) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-full-min-height-js' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-banner-slider--azyn-creative' );

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';

$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'azyn-banner-slider-layout2', $sc_dir . 'assets/css/azyn_layout2.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('tweenmax-all');
	wp_enqueue_script('barba');
	wp_enqueue_script('azyn-banner-slider-layout2-js', $sc_dir . 'assets/js/azyn_layout2.js', array('jquery', 'tweenmax-all', 'barba'), null, true);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div id="barba-wrapper">
		<div class="barba-container">

			<div class="aheto_smooth">

				<div id="q_slide" data-parallax=".15" data-opacity=".1" class="aheto-full-min-height-js">
					<div class="q_slide-inner">
						<div class="slides">

							<?php

							$counter = 1;

							$pagination = '';

							foreach ( $banners

							as $banner ) :
							$banner = wp_parse_args( $banner, [
								'azyn_image'        => '',
								'azyn_subtitle'     => '',
								'azyn_first_title'  => '',
								'azyn_second_title' => '',
								'azyn_heading_tag'  => '',
							] );
							extract( $banner );

							if ( ! $azyn_image ) {
								continue;
							}

							$active = $counter === 1 ? 'q_current' : '';
							$num = $counter < 10 ? '0' . $counter : $counter;
							?>

							<div class="slide <?php echo esc_attr( $active ); ?>">
								<div class="slide-content">
									<div class="caption">
										<div class="number q_split_wrap">/<?php echo esc_html($num); ?></div>
										<?php if ( ! empty( $azyn_first_title ) ){ ?>
										<div class="q_split">
											<<?php echo esc_attr( $azyn_heading_tag ); ?> class="q_split_wrap slide-title">
											<?php echo esc_html( $azyn_first_title ); ?>
										</<?php echo esc_attr( $azyn_heading_tag ); ?>>
									</div>
									<?php }

									if ( ! empty( $azyn_second_title ) ){ ?>
									<div class="q_split">
										<<?php echo esc_attr( $azyn_heading_tag ); ?> class="q_split_wrap slide-title">
										<?php echo esc_html( $azyn_second_title ); ?>
									</<?php echo esc_attr( $azyn_heading_tag ); ?>>
								</div>
								<?php
								}

								if ( $azyn_add_button ) { ?>
									<div class="q_split button-wrap">
										<div class="q_split_wrap">
											<?php echo Helper::get_button( $this, $banner, 'azyn_btn_' ); ?>
										</div>
									</div>
								<?php } ?>
							</div>
							<?php if ( ! empty( $azyn_subtitle ) ) { ?>
								<div class="q_split subtitle">
									<h6 class="q_split_wrap">
										<?php echo esc_html( $azyn_subtitle ); ?>
									</h6>
								</div>
							<?php } ?>
						</div>
						<div class="image-container">
							<div class="image-wrapper">
								<div class="kenburns">
									<?php echo Helper::get_attachment( $azyn_image, [ 'class' => 'image' ] ); ?>
								</div>
							</div>
						</div>
					</div>

					<?php
					$counter ++;

					endforeach; ?>

				</div>

				<div class="arrows-wrap">
					<div class="arrows">
						<a class="arrow prev aheto_magnet"><i class="ion-chevron-up"></i></a>
						<span class="arrow-line"></span>
						<a class="arrow next aheto_magnet"><i class="ion-chevron-down"></i></a>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
</div>
</div>
