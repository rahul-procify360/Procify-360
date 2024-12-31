<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

extract($atts);

$slides = $this->parse_group($azyn_modern_items);

if (empty($slides)) {
	return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contents--azyn-modern-slider');


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'azyn_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('azyn-contents-layout3', $shortcode_dir . 'assets/css/azyn_layout3.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('azyn-contents-layout3-js', $shortcode_dir . 'assets/js/azyn_layout3.min.js', array('jquery'), null);
} ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container aheto-page-height-js swiper-pagination--numeric" data-effect="fade"
			 data-destroy="992" data-speed="1000" data-direction="vertical"
			 data-mousewheel="1" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ($slides as $slide) :
					$slide = wp_parse_args($slide, [
						'azyn_modern_slide_style' => 'type_progress_counts',
						'azyn_modern_subtitle' => '',
						'azyn_modern_title' => '',
						'azyn_modern_desc' => '',
						'azyn_modern_images' => '',
						'azyn_number_1' => '',
						'azyn_symbol_1' => '',
						'azyn_title_1' => '',
						'azyn_number_2' => '',
						'azyn_symbol_2' => '',
						'azyn_title_2' => '',
						'azyn_procent_1' => '',
						'azyn_procent_2' => '',
						'azyn_procent_3' => '',
						'azyn_title_3' => '',
						'azyn_modern_f_image_1' => '',
						'azyn_modern_f_title_1' => '',
						'azyn_modern_f_desc_1' => '',
						'azyn_modern_f_image_2' => '',
						'azyn_modern_f_title_2' => '',
						'azyn_modern_f_desc_2' => '',
						'azyn_modern_f_image_3' => '',
						'azyn_modern_f_title_3' => '',
						'azyn_modern_f_desc_3' => '',
						'azyn_modern_f_image_4' => '',
						'azyn_modern_f_title_4' => '',
						'azyn_modern_f_desc_4' => '',
						'azyn_modern_bg_image' => '',
						'azyn_modern_phone_icon' => '',
						'azyn_modern_phone' => '',
						'azyn_modern_email_icon' => '',
						'azyn_modern_email' => '',
						'azyn_modern_address_icon' => '',
						'azyn_modern_address' => '',
						'azyn_contact_form' => '',
					]);

					$background_slide_image = count($slide['azyn_modern_bg_image']) ? Helper::get_background_attachment($slide['azyn_modern_bg_image'], 'full') : '';

					extract($slide); ?>
					<div class="swiper-slide aheto-page-height-js">
						<div
							class="aheto-contents__slide <?php echo esc_attr($azyn_modern_slide_style); ?> elementor-repeater-item-<?php echo esc_attr($slide['_id']); ?>">
							<?php if (is_array($azyn_modern_images) && count($azyn_modern_images)) { ?>
								<div class="aheto-contents__slide-wrap">
									<div class="swiper">
										<div class="swiper-container" data-destroy="992">
											<div class="swiper-wrapper">

												<?php foreach ($azyn_modern_images as $image) {
													$background_image = Helper::get_background_attachment($image, 'full'); ?>
													<div class="swiper-slide aheto-page-height-js">
														<div
															class="aheto-contents__gallery-item" <?php echo esc_attr($background_image); ?>></div>
													</div>
												<?php } ?>

											</div>
											<div class="swiper-pagination"></div>
										</div>
									</div>
								</div>
							<?php } ?>


							<div class="aheto-contents__slide-wrap" <?php echo esc_attr($background_slide_image); ?>>

								<div class="aheto-contents__heading">
									<?php if (!empty($azyn_modern_subtitle)) { ?>
										<h6 class="aheto-contents__subtitle"><?php echo esc_html($azyn_modern_subtitle); ?></h6>
									<?php } ?>
									<?php if (!empty($azyn_modern_title)) {
										$azyn_modern_title = str_replace(']]', '</span>', $azyn_modern_title);
										$azyn_modern_title = str_replace('[[', '<span>', $azyn_modern_title); ?>
										<h4 class="aheto-contents__title"><?php echo wp_kses_post($azyn_modern_title); ?></h4>
									<?php } ?>
									<?php if (!empty($azyn_modern_desc) && $azyn_modern_slide_style === 'type_progress_counts') { ?>
										<div
											class="aheto-contents__desc"><?php echo esc_html($azyn_modern_desc); ?></div>
									<?php } ?>
								</div>

								<?php if ($azyn_modern_slide_style === 'type_progress_counts') { ?>
									<div class="aheto-contents__counters">
										<?php if (!empty($azyn_number_1) && is_numeric($azyn_number_1)) { ?>
											<div class="aheto-contents__counters-wrap">
												<div class="aheto-contents__counters-top">
													<div
														class="aheto-contents__counters-number js-counter"><?php echo esc_html($azyn_number_1); ?></div>
													<?php if (!empty($azyn_symbol_1)) { ?>
														<div
															class="aheto-contents__counters-symbol"><?php echo esc_html($azyn_symbol_1); ?></div>
													<?php } ?>
												</div>
												<?php if (!empty($azyn_title_1)) { ?>
													<h6 class="aheto-contents__counters-title"><?php echo esc_html($azyn_title_1); ?></h6>
												<?php } ?>
											</div>
										<?php } ?>
										<?php if (!empty($azyn_number_2) && is_numeric($azyn_number_2)) { ?>
											<div class="aheto-contents__counters-wrap">
												<div class="aheto-contents__counters-top">
													<div
														class="aheto-contents__counters-number js-counter"><?php echo esc_html($azyn_number_2); ?></div>
													<?php if (!empty($azyn_symbol_2)) { ?>
														<div
															class="aheto-contents__counters-symbol"><?php echo esc_html($azyn_symbol_2); ?></div>
													<?php } ?>
												</div>
												<?php if (!empty($azyn_title_2)) { ?>
													<h6 class="aheto-contents__counters-title"><?php echo esc_html($azyn_title_2); ?></h6>
												<?php } ?>
											</div>
										<?php } ?>
									</div>
								<?php } ?>

								<?php if ($azyn_modern_slide_style === 'type_progress_lines') { ?>
									<div class="aheto-contents__progress">

										<?php if (is_array($azyn_procent_1) && isset($azyn_procent_1['size']) && !empty($azyn_procent_1['size'])) { ?>
											<div class="aheto-contents__progress-wrap">
												<?php if (!empty($azyn_title_1)) { ?>
													<h6 class="aheto-contents__progress-title"><?php echo esc_html($azyn_title_1); ?></h6>
												<?php } ?>
												<div class="prog-bar">
													<div class="prog-bar-hldr">
														<span
															class="prog-bar-perc"><?php echo absint($azyn_procent_1['size']); ?></span>
													</div>
													<div class="prog-bar-val"></div>
												</div>
											</div>
										<?php } ?>

										<?php if (is_array($azyn_procent_2) && isset($azyn_procent_2['size']) && !empty($azyn_procent_2['size'])) { ?>
											<div class="aheto-contents__progress-wrap">
												<?php if (!empty($azyn_title_2)) { ?>
													<h6 class="aheto-contents__progress-title"><?php echo esc_html($azyn_title_2); ?></h6>
												<?php } ?>
												<div class="prog-bar">
													<div class="prog-bar-hldr">
														<span
															class="prog-bar-perc"><?php echo absint($azyn_procent_2['size']); ?></span>
													</div>
													<div class="prog-bar-val"></div>
												</div>
											</div>
										<?php } ?>

										<?php if (is_array($azyn_procent_3) && isset($azyn_procent_3['size']) && !empty($azyn_procent_3['size'])) { ?>
											<div class="aheto-contents__progress-wrap">
												<?php if (!empty($azyn_title_3)) { ?>
													<h6 class="aheto-contents__progress-title"><?php echo esc_html($azyn_title_3); ?></h6>
												<?php } ?>
												<div class="prog-bar">
													<div class="prog-bar-hldr">
														<span
															class="prog-bar-perc"><?php echo absint($azyn_procent_3['size']); ?></span>
													</div>
													<div class="prog-bar-val"></div>
												</div>
											</div>
										<?php } ?>

									</div>
								<?php } ?>

								<?php if ($azyn_modern_slide_style === 'type_features') { ?>
									<div class="aheto-contents__features">

										<?php if (!empty($azyn_modern_f_image_1) || !empty($azyn_modern_f_title_1) || !empty($azyn_modern_f_desc_1)) { ?>
											<div class="aheto-contents__features-wrap">
												<?php if ($azyn_modern_f_image_1) { ?>
													<div class="aheto-contents__features-icon">
														<?php echo Helper::get_attachment($azyn_modern_f_image_1); ?>
													</div>
												<?php } ?>
												<?php if (!empty($azyn_modern_f_title_1)) { ?>
													<h5 class="aheto-contents__features-title"><?php echo esc_html($azyn_modern_f_title_1); ?></h5>
												<?php } ?>
												<?php if (!empty($azyn_modern_f_desc_1)) { ?>
													<div class="aheto-contents__features-desc">
														<?php echo esc_html($azyn_modern_f_desc_1); ?>
													</div>
												<?php } ?>
											</div>
										<?php } ?>

										<?php if (!empty($azyn_modern_f_image_2) || !empty($azyn_modern_f_title_2) || !empty($azyn_modern_f_desc_2)) { ?>
											<div class="aheto-contents__features-wrap">
												<?php if ($azyn_modern_f_image_2) { ?>
													<div class="aheto-contents__features-icon">
														<?php echo Helper::get_attachment($azyn_modern_f_image_2); ?>
													</div>
												<?php } ?>
												<?php if (!empty($azyn_modern_f_title_2)) { ?>
													<h5 class="aheto-contents__features-title"><?php echo esc_html($azyn_modern_f_title_2); ?></h5>
												<?php } ?>
												<?php if (!empty($azyn_modern_f_desc_2)) { ?>
													<div class="aheto-contents__features-desc">
														<?php echo esc_html($azyn_modern_f_desc_2); ?>
													</div>
												<?php } ?>
											</div>
										<?php } ?>

										<?php if (!empty($azyn_modern_f_image_3) || !empty($azyn_modern_f_title_3) || !empty($azyn_modern_f_desc_3)) { ?>
											<div class="aheto-contents__features-wrap">
												<?php if ($azyn_modern_f_image_3) { ?>
													<div class="aheto-contents__features-icon">
														<?php echo Helper::get_attachment($azyn_modern_f_image_3); ?>
													</div>
												<?php } ?>
												<?php if (!empty($azyn_modern_f_title_3)) { ?>
													<h5 class="aheto-contents__features-title"><?php echo esc_html($azyn_modern_f_title_3); ?></h5>
												<?php } ?>
												<?php if (!empty($azyn_modern_f_desc_3)) { ?>
													<div class="aheto-contents__features-desc">
														<?php echo esc_html($azyn_modern_f_desc_3); ?>
													</div>
												<?php } ?>
											</div>
										<?php } ?>

										<?php if (!empty($azyn_modern_f_image_4) || !empty($azyn_modern_f_title_4) || !empty($azyn_modern_f_desc_4)) { ?>
											<div class="aheto-contents__features-wrap">
												<?php if ($azyn_modern_f_image_4) { ?>
													<div class="aheto-contents__features-icon">
														<?php echo Helper::get_attachment($azyn_modern_f_image_4); ?>
													</div>
												<?php } ?>
												<?php if (!empty($azyn_modern_f_title_4)) { ?>
													<h5 class="aheto-contents__features-title"><?php echo esc_html($azyn_modern_f_title_4); ?></h5>
												<?php } ?>
												<?php if (!empty($azyn_modern_f_desc_4)) { ?>
													<div class="aheto-contents__features-desc">
														<?php echo esc_html($azyn_modern_f_desc_4); ?>
													</div>
												<?php } ?>
											</div>
										<?php } ?>

									</div>
								<?php } ?>

								<?php if ($azyn_modern_slide_style === 'type_contacts') { ?>
									<div class="aheto-contents__contacts">

										<?php if (!empty($azyn_modern_phone) || !empty($azyn_modern_phone_icon)) { ?>
											<div class="aheto-contents__contacts-wrap">
												<?php if ($azyn_modern_phone_icon) { ?>
													<div class="aheto-contents__contacts-icon">
														<?php echo Helper::get_attachment($azyn_modern_phone_icon); ?>
													</div>
												<?php } ?>
												<?php if (!empty($azyn_modern_phone)) { ?>
													<a href="tel:<?php echo esc_attr(str_replace(" ", "", $azyn_modern_phone)); ?>"
													   class="aheto-contents__contacts-link"><?php echo esc_html($azyn_modern_phone); ?></a>
												<?php } ?>
											</div>
										<?php } ?>

										<?php if (!empty($azyn_modern_email) || !empty($azyn_modern_email_icon)) { ?>
											<div class="aheto-contents__contacts-wrap">
												<?php if ($azyn_modern_email_icon) { ?>
													<div class="aheto-contents__contacts-icon">
														<?php echo Helper::get_attachment($azyn_modern_email_icon); ?>
													</div>
												<?php } ?>
												<?php if (!empty($azyn_modern_email)) { ?>
													<a href="mailto:<?php echo esc_attr($azyn_modern_email); ?>"
													   class="aheto-contents__contacts-link"><?php echo esc_html($azyn_modern_email); ?></a>
												<?php } ?>
											</div>
										<?php } ?>

										<?php if (!empty($azyn_modern_address) || !empty($azyn_modern_address_icon)) { ?>
											<div class="aheto-contents__contacts-wrap">
												<?php if ($azyn_modern_address_icon) { ?>
													<div class="aheto-contents__contacts-icon">
														<?php echo Helper::get_attachment($azyn_modern_address_icon); ?>
													</div>
												<?php } ?>
												<?php if (!empty($azyn_modern_address)) { ?>
													<div
														class="aheto-contents__contacts-text"><?php echo esc_html($azyn_modern_address); ?></div>
												<?php } ?>
											</div>
										<?php } ?>

										<?php if (!empty($azyn_contact_form)) { ?>
											<div class="aheto-contents__contacts-wrap">
												<div
													class="<?php echo Helper::get_button($slide, $atts, 'azyn_form_', true); ?>">
													<?php echo do_shortcode('[contact-form-7 id="' . esc_attr($azyn_contact_form) . '"]'); ?>
												</div>
											</div>
										<?php } ?>

									</div>
								<?php } ?>
							</div>

						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $this->swiper_pagination('azyn_swiper_'); ?>
		</div>
	</div>

</div>
