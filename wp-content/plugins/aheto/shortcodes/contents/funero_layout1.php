<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

$this->generate_css();

extract($atts);

$slides = $this->parse_group($funero_creative_items);

if ( empty($slides) ) {
	return '';
}

if ( !$funero_swiper_custom_options ) {
	$speed  = 500;
	$effect = 'fade';
	$loop   = true;
}


$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contents--funero-creative-slider');


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'  => 1000,
	'effect' => 'fade'
]; // will use when not chosen option 'Change slider params'

$carousel_params = \Aheto\Helper::get_carousel_params($atts, 'funero_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-contents-layout1', $shortcode_dir . 'assets/css/funero_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('funero-contents-js-layout1', $shortcode_dir . 'assets/js/funero_layout1.min.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-contents--shape"></div>
	<div class="swiper">

		<div class="swiper-container aheto-contents-swiper-left"
			 data-effect="fade" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $slides as $slide_left ) :
					$slide_left = wp_parse_args($slide_left, [
						'funero_item_image'      => '',
						'funero_item_image_size' => '',
						'funero_image_overlay'   => '',
					]);
					extract($slide_left);

					if ( !$funero_item_image ) {
						continue;
					}
					$background_image = "";
					if ( !empty($funero_item_image) ) {
						$lazy_class       = $funero_swiper_lazy ? ' swiper-lazy' : '';
						$background_image = \Aheto\Helper::get_background_attachment($funero_item_image, $funero_content_imgimage_size, $atts, 'funero_content_img', $funero_swiper_lazy);
					} ?>
					<div class="swiper-slide">
						<?php $funero_overlay = isset($funero_image_overlay) && $funero_image_overlay == true ? 'aheto-contents-slider-wrap-overlay' : ''; ?>
						<div class="aheto-contents-slider-wrap <?php echo esc_attr($funero_overlay); ?>" <?php echo esc_attr($background_image); ?>>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $this->swiper_arrow('funero_swiper_'); ?>
		</div>
		<div class="swiper-container aheto-contents-swiper-right"
			 data-effect="fade" <?php echo esc_attr($carousel_params); ?> data-thumbs="1">
			<div class="swiper-wrapper">
				<?php foreach ( $slides as $slide_right ) :
					$slide_right = wp_parse_args($slide_right, [
						'funero_item_subtitle'      => '',
						'funero_item_title'         => '',
						'funero_item_desc'          => '',
						'funero_item_btn_direction' => ''
					]);
					extract($slide_right);
					?>
					<div class="swiper-slide">
						<div class="aheto-contents-slider-wrap">

							<div class="aheto-contents-slider__content">
								<?php if ( !empty($funero_item_subtitle) ) { ?>
									<p class="aheto-contents__subtitle"><?php echo esc_html($funero_item_subtitle); ?></p>
								<?php }
								if ( !empty($funero_item_title) ) {
									$funero_item_title = str_replace(']]', '</span>', $funero_item_title);
									$funero_item_title = str_replace('[[', '<span>', $funero_item_title);
									?>
									<h4 class="aheto-contents__title"><?php echo wp_kses($funero_item_title, 'post'); ?></h4>
								<?php }

								if ( !empty($funero_item_desc) ) { ?>
									<p class="aheto-contents__desc"><?php echo wp_kses($funero_item_desc, 'post'); ?></p>
								<?php }

								if ( $funero_main_add_button == true ) { ?>
									<div class="aheto-contents__links  <?php echo esc_attr($funero_item_btn_direction) == 'space_between' ? 'space_between' : ''; ?>">
										<?php
										echo \Aheto\Helper::get_button($this, $slide_right, 'funero_main_');
										echo esc_attr($funero_item_btn_direction) == 'is-vertical' ? '<br>' : '';
										echo \Aheto\Helper::get_button($this, $slide_right, 'funero_add_'); ?>
									</div>
								<?php } ?>

								<?php if ( !empty($funero_item_image_left) ) { ?>
									<div class="aheto-contents__img-wrap">
										<?php echo Helper::get_attachment($funero_item_image_left, ['class' => 'aheto-contents__image']); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

</div>
