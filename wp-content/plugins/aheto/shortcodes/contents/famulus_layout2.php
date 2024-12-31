<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

$this->generate_css();

extract($atts);

$slides = $this->parse_group($famulus_creative_items);

if ( empty($slides) ) {
	return '';
}

if ( !$famulus_swiper_custom_options ) {
	$speed  = 1000;
	$effect = 'fade';
	$loop   = false;
}


$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contents--famulus-creative-slider');


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = \Aheto\Helper::get_carousel_params($atts, 'famulus_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-contents-layout2', $shortcode_dir . 'assets/css/famulus_layout2.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('famulus-contents-layout2-js', $shortcode_dir . 'assets/js/famulus_layout2.min.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-contents--shape"></div>
	<div class="swiper">

		<div class="swiper-container aheto-contents-swiper-left" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $slides as $slide_left ) :
					$slide_left = wp_parse_args($slide_left, [
						'famulus_item_image'      => '',
						'famulus_item_image_size' => '',
					]);
					extract($slide_left);

					$lazy_class       = $famulus_swiper_lazy ? ' swiper-lazy' : '';
					$background_image = \Aheto\Helper::get_background_attachment($famulus_item_image, $famulus_content_imgimage_size, $atts, 'famulus_content_img', $famulus_swiper_lazy);
					?>
					<div class="swiper-slide">
						<div class="aheto-contents-slider-wrap " <?php echo esc_attr($background_image); ?>>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="swiper-container aheto-contents-swiper-right" <?php echo esc_attr($carousel_params); ?>
			 data-thumbs="1">
			<div class="swiper-wrapper">
				<?php foreach ( $slides as $slide_right ) :
					$slide_right = wp_parse_args($slide_right, [
						'famulus_item_title'         => '',
						'famulus_item_desc'          => '',
						'famulus_item_btn_direction' => ''
					]);
					extract($slide_right);
					?>
					<div class="swiper-slide">
						<div class="aheto-contents-slider-wrap">

							<div class="aheto-contents-slider__content">
								<div class="aheto-contents-slider__content-bg">
									<?php if ( !empty($famulus_item_title) ) {
										$famulus_item_title = str_replace(']]', '</span>', $famulus_item_title);
										$famulus_item_title = str_replace('[[', '<span>', $famulus_item_title);
										?>
										<h2 class="aheto-contents__title"><?php echo wp_kses($famulus_item_title, 'post'); ?></h2>
									<?php }

									if ( !empty($famulus_item_desc) ) { ?>
										<p class="aheto-contents__desc"><?php echo wp_kses($famulus_item_desc, 'post'); ?></p>
									<?php }

									if ( $famulus_main_add_button == true || $famulus_add_add_button == true ) { ?>
										<div class="aheto-contents__links  <?php echo esc_attr($famulus_item_btn_direction) == 'space_between' ? 'space_between' : ''; ?>">
											<?php
											echo \Aheto\Helper::get_button($this, $slide_right, 'famulus_main_');
											echo esc_attr($famulus_item_btn_direction) == 'is-vertical' ? '<br>' : '';
											echo \Aheto\Helper::get_button($this, $slide_right, 'famulus_add_'); ?>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php $this->swiper_arrow('famulus_swiper_'); ?>
	</div>

</div>
