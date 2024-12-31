<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$slides = $this->parse_group( $azyn_split_items );

if ( empty( $slides ) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--azyn-split-slider' );


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'azyn_swiper_', $carousel_default_params );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'azyn-contents-layout2', $shortcode_dir . 'assets/css/azyn_layout2.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="swiper">
		<div class="swiper-container aheto-page-height-js" data-destroy="992" data-speed="1000" data-direction="vertical" data-mousewheel="1" <?php echo esc_attr( $carousel_params ); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $slides as $slide ) :
					$slide = wp_parse_args( $slide, [
						'azyn_split_slide_style' => 'simple',
						'azyn_split_number' => '',
						'azyn_split_subtitle' => '',
						'azyn_split_title' => '',
						'azyn_split_desc' => '',
						'azyn_split_image' => '',
						'azyn_split_f_image_1' => '',
						'azyn_split_f_title_1' => '',
						'azyn_split_f_image_2' => '',
						'azyn_split_f_title_2' => '',
						'azyn_split_f_image_3' => '',
						'azyn_split_f_title_3' => '',
						'azyn_split_f_image_4' => '',
						'azyn_split_f_title_4' => '',
						'azyn_split_f_image_5' => '',
						'azyn_split_f_title_5' => '',
						'azyn_split_f_image_6' => '',
						'azyn_split_f_title_6' => '',
						'azyn_split_f_image_7' => '',
						'azyn_split_f_title_7' => '',
						'azyn_split_f_image_8' => '',
						'azyn_split_f_title_8' => '',
						'azyn_split_number_2' => '',
						'azyn_split_subtitle_2' => '',
						'azyn_split_title_2' => '',
						'azyn_split_desc_2' => '',
						'azyn_split_image_2' => '',
					] );

					$background_image = is_array($slide['azyn_bg_image']) && count($slide['azyn_bg_image']) ? $slide['azyn_bg_image']['url'] : $slide['azyn_bg_image'];
					$background_image_mob = is_array($slide['azyn_bg_image_mob']) && count($slide['azyn_bg_image_mob']) ? $slide['azyn_bg_image_mob']['url'] : $slide['azyn_bg_image_mob'];

					if(!empty($background_image) || !empty($background_image_mob)){ ?>
						<style>
						<?php if(!empty($background_image)){ ?>
							.elementor-repeater-item-<?php echo esc_attr( $slide['_id'] ); ?> .aheto-contents__slide-wrap:first-of-type{
								background-image: url("<?php echo esc_url($background_image); ?>");
							}
						<?php }

						if(!empty($background_image_mob)){ ?>
							@media only screen and (max-width: 992px){
								.elementor-repeater-item-<?php echo esc_attr( $slide['_id'] ); ?> .aheto-contents__slide-wrap:first-of-type{
									background-image: url("<?php echo esc_url($background_image_mob); ?>");
								}
							}

						<?php } ?>
						</style>
					<?php
					}

					extract( $slide ); ?>
					<div class="swiper-slide aheto-page-height-js">
						<div class="aheto-contents__slide <?php echo esc_attr($azyn_split_slide_style); ?> elementor-repeater-item-<?php echo esc_attr( $slide['_id'] ); ?>">
							<div class="aheto-contents__slide-wrap ">
								<div class="aheto-contents__top">
									<?php if($azyn_split_slide_style !== 'features' && $azyn_split_slide_style !== 'simple_2col_modern' && !empty($azyn_split_number)){ ?>
										<div class="aheto-contents__number"><?php echo esc_html($azyn_split_number); ?></div>
									<?php } ?>
									<div class="aheto-contents__heading">
										<?php if($azyn_split_slide_style !== 'simple_2col_modern' && !empty($azyn_split_subtitle)){ ?>
											<h6 class="aheto-contents__subtitle"><?php echo esc_html($azyn_split_subtitle); ?></h6>
										<?php } ?>
										<?php if( !empty($azyn_split_title)){ ?>
											<h4 class="aheto-contents__title"><?php echo esc_html($azyn_split_title); ?></h4>
										<?php } ?>
										<?php if($azyn_split_slide_style === 'simple_2col_modern' && !empty($azyn_split_subtitle)){ ?>
											<h6 class="aheto-contents__subtitle"><?php echo esc_html($azyn_split_subtitle); ?></h6>
										<?php } ?>
										<?php if($azyn_split_slide_style !== 'simple_2col_modern' && !empty($azyn_split_desc)){ ?>
											<div class="aheto-contents__desc"><?php echo esc_html($azyn_split_desc); ?></div>
										<?php } ?>
									</div>
								</div>
								<div class="aheto-contents__middle">
									<?php

									if($azyn_split_slide_style !== 'features' && (is_array($azyn_split_image) && count($azyn_split_image) || !is_array($azyn_split_image) && $azyn_split_image)){
										echo Helper::get_attachment($azyn_split_image, [], $azyn_image_size, $atts, 'azyn_');
									}
									if($azyn_split_slide_style === 'features'){ ?>
										<div class="aheto-contents__features">

											<?php

											$is_icon_1 = is_array($azyn_split_f_image_1) && count($azyn_split_f_image_1) || !is_array($azyn_split_f_image_1) && $azyn_split_f_image_1 ? true : false;
											$is_icon_2 = is_array($azyn_split_f_image_2) && count($azyn_split_f_image_2) || !is_array($azyn_split_f_image_2) && $azyn_split_f_image_2 ? true : false;
											$is_icon_3 = is_array($azyn_split_f_image_3) && count($azyn_split_f_image_3) || !is_array($azyn_split_f_image_3) && $azyn_split_f_image_3 ? true : false;
											$is_icon_4 = is_array($azyn_split_f_image_4) && count($azyn_split_f_image_4) || !is_array($azyn_split_f_image_4) && $azyn_split_f_image_4 ? true : false;
											$is_icon_5 = is_array($azyn_split_f_image_5) && count($azyn_split_f_image_5) || !is_array($azyn_split_f_image_5) && $azyn_split_f_image_5 ? true : false;
											$is_icon_6 = is_array($azyn_split_f_image_6) && count($azyn_split_f_image_6) || !is_array($azyn_split_f_image_6) && $azyn_split_f_image_6 ? true : false;
											$is_icon_7 = is_array($azyn_split_f_image_7) && count($azyn_split_f_image_7) || !is_array($azyn_split_f_image_7) && $azyn_split_f_image_7 ? true : false;
											$is_icon_8 = is_array($azyn_split_f_image_8) && count($azyn_split_f_image_8) || !is_array($azyn_split_f_image_8) && $azyn_split_f_image_8 ? true : false;

											if( $is_icon_1 || !empty( $azyn_split_f_title_1 )){ ?>
												<div class="aheto-contents__item">
													<?php if( $is_icon_1 ){ ?>
													<div class="aheto-contents__icon">
														<?php echo Helper::get_attachment($azyn_split_f_image_1); ?>
													</div>
													<?php }

													if( !empty( $azyn_split_f_title_1 ) ){ ?>
														<h5 class="aheto-contents__item-title"><?php echo esc_html( $azyn_split_f_title_1 );?></h5>
													<?php } ?>
												</div>
											<?php }

											if( $is_icon_2 || !empty( $azyn_split_f_title_2 )){ ?>
												<div class="aheto-contents__item">
													<?php if( $is_icon_2 ){ ?>
														<div class="aheto-contents__icon">
															<?php echo Helper::get_attachment($azyn_split_f_image_2); ?>
														</div>
													<?php }

													if( !empty( $azyn_split_f_title_2 ) ){ ?>
														<h5 class="aheto-contents__item-title"><?php echo esc_html( $azyn_split_f_title_2 );?></h5>
													<?php } ?>
												</div>
											<?php }

											if( $is_icon_3 || !empty( $azyn_split_f_title_3 )){ ?>
												<div class="aheto-contents__item">
													<?php if( $is_icon_3 ){ ?>
														<div class="aheto-contents__icon">
															<?php echo Helper::get_attachment($azyn_split_f_image_3); ?>
														</div>
													<?php }

													if( !empty( $azyn_split_f_title_3 ) ){ ?>
														<h5 class="aheto-contents__item-title"><?php echo esc_html( $azyn_split_f_title_3 );?></h5>
													<?php } ?>
												</div>
											<?php }

											if( $is_icon_4 || !empty( $azyn_split_f_title_4 )){ ?>
												<div class="aheto-contents__item">
													<?php if( $is_icon_4 ){ ?>
														<div class="aheto-contents__icon">
															<?php echo Helper::get_attachment($azyn_split_f_image_4); ?>
														</div>
													<?php }

													if( !empty( $azyn_split_f_title_4 ) ){ ?>
														<h5 class="aheto-contents__item-title"><?php echo esc_html( $azyn_split_f_title_4 );?></h5>
													<?php } ?>
												</div>
											<?php }

											if( $is_icon_5 || !empty( $azyn_split_f_title_5 )){ ?>
												<div class="aheto-contents__item">
													<?php if( $is_icon_5 ){ ?>
														<div class="aheto-contents__icon">
															<?php echo Helper::get_attachment($azyn_split_f_image_5); ?>
														</div>
													<?php }

													if( !empty( $azyn_split_f_title_5 ) ){ ?>
														<h5 class="aheto-contents__item-title"><?php echo esc_html( $azyn_split_f_title_5 );?></h5>
													<?php } ?>
												</div>
											<?php }

											if( $is_icon_6 || !empty( $azyn_split_f_title_6 )){ ?>
												<div class="aheto-contents__item">
													<?php if( $is_icon_6 ){ ?>
														<div class="aheto-contents__icon">
															<?php echo Helper::get_attachment($azyn_split_f_image_6); ?>
														</div>
													<?php }

													if( !empty( $azyn_split_f_title_6 ) ){ ?>
														<h5 class="aheto-contents__item-title"><?php echo esc_html( $azyn_split_f_title_6 );?></h5>
													<?php } ?>
												</div>
											<?php }

											if( $is_icon_7 || !empty( $azyn_split_f_title_7 )){ ?>
												<div class="aheto-contents__item">
													<?php if( $is_icon_7 ){ ?>
														<div class="aheto-contents__icon">
															<?php echo Helper::get_attachment($azyn_split_f_image_7); ?>
														</div>
													<?php }

													if( !empty( $azyn_split_f_title_7 ) ){ ?>
														<h5 class="aheto-contents__item-title"><?php echo esc_html( $azyn_split_f_title_7 );?></h5>
													<?php } ?>
												</div>
											<?php }

											if( $is_icon_8 || !empty( $azyn_split_f_title_8 )){ ?>
												<div class="aheto-contents__item">
													<?php if( $is_icon_8 ){ ?>
														<div class="aheto-contents__icon">
															<?php echo Helper::get_attachment($azyn_split_f_image_8); ?>
														</div>
													<?php }

													if( !empty( $azyn_split_f_title_8 ) ){ ?>
														<h5 class="aheto-contents__item-title"><?php echo esc_html( $azyn_split_f_title_8 );?></h5>
													<?php } ?>
												</div>
											<?php } ?>

										</div>
									<?php } ?>
								</div>
								<?php if (  $azyn_main_add_button ) { ?>
									<div class="aheto-contents__bottom">
										<?php echo Helper::get_button( $this, $slide, 'azyn_main_' ); ?>
									</div>
								<?php } ?>
							</div>

							<?php if( $azyn_split_slide_style === 'simple_2col' || $azyn_split_slide_style === 'simple_2col_modern' ){
								$background_image_2 = is_array($slide['azyn_bg_image_2']) && count($slide['azyn_bg_image_2']) ? $slide['azyn_bg_image_2']['url'] : $slide['azyn_bg_image_2'];
								$background_image_2_mob = is_array($slide['azyn_bg_image_2_mob']) && count($slide['azyn_bg_image_2_mob']) ? $slide['azyn_bg_image_2_mob']['url'] : $slide['azyn_bg_image_2_mob'];

								if(!empty($background_image_2) || !empty($background_image_2_mob)){ ?>
									<style>
										<?php if(!empty($background_image_2)){ ?>
										.elementor-repeater-item-<?php echo esc_attr( $slide['_id'] ); ?>  .aheto-contents__slide-wrap:nth-of-type(2){
											background-image: url("<?php echo esc_url($background_image_2); ?>");
										}
										<?php }

										if(!empty($background_image_2_mob)){ ?>
										@media only screen and (max-width: 992px){
											.elementor-repeater-item-<?php echo esc_attr( $slide['_id'] ); ?> .aheto-contents__slide-wrap:nth-of-type(2){
												background-image: url("<?php echo esc_url($background_image_2_mob); ?>");
											}
										}

										<?php } ?>
									</style>
									<?php
								}  ?>

								<div class="aheto-contents__slide-wrap">
									<?php if( $azyn_split_slide_style !== 'simple_2col_modern' ){ ?>
										<div class="aheto-contents__top">
											<?php if( !empty($azyn_split_number_2) ){ ?>
												<div class="aheto-contents__number"><?php echo esc_html($azyn_split_number_2); ?></div>
											<?php } ?>
											<div class="aheto-contents__heading">
												<?php if( !empty($azyn_split_subtitle_2) ){ ?>
													<h6 class="aheto-contents__subtitle"><?php echo esc_html($azyn_split_subtitle_2); ?></h6>
												<?php } ?>
												<?php if( !empty($azyn_split_title_2) ){ ?>
													<h4 class="aheto-contents__title"><?php echo esc_html($azyn_split_title_2); ?></h4>
												<?php } ?>
												<?php if( !empty($azyn_split_desc_2) ){ ?>
													<div class="aheto-contents__desc"><?php echo esc_html($azyn_split_desc_2); ?></div>
												<?php } ?>
											</div>
										</div>
									<?php } ?>

									<div class="aheto-contents__middle">
										<?php if( is_array($azyn_split_image_2) && count($azyn_split_image_2) || !is_array($azyn_split_image_2) && $azyn_split_image_2){
												echo Helper::get_attachment($azyn_split_image_2, [], $azyn_image_size, $atts, 'azyn_');
										} ?>
									</div>

									<?php if ( $azyn_split_slide_style === 'simple_2col' && $azyn_add_add_button ) { ?>
										<div class="aheto-contents__bottom">
											<?php echo Helper::get_button( $this, $slide, 'azyn_add_' ); ?>
										</div>
									<?php } ?>

									<?php if ( $azyn_split_slide_style === 'simple_2col_modern' && $azyn_main_add_button ) { ?>
										<div class="aheto-contents__bottom mobile-hide">
											<?php echo Helper::get_button( $this, $slide, 'azyn_main_' ); ?>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $this->swiper_pagination('azyn_swiper_'); ?>
		</div>
	</div>

</div>
