<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

$this->generate_css();

extract($atts);

$funero_reverse_items = $this->parse_group($funero_reverse_items);

$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contents--funero-content-reverse');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-contents-layout2', $shortcode_dir . 'assets/css/funero_layout2.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php foreach ( $funero_reverse_items as $item ) :
		$item = wp_parse_args($item, [
			'funero_item_image'         => '',
			'funero_item_image_size'    => '',
			'funero_item_subtitle'      => '',
			'funero_item_title'         => '',
			'funero_item_title_bg'      => '',
			'funero_item_desc'          => '',
			'funero_item_btn_direction' => ''
		]);
		extract($item);

		if ( !$funero_item_image ) {
			continue;
		}
		$background_image = '';
		if ( $funero_item_image ) {
			$lazy_class       = $funero_swiper_lazy ? ' swiper-lazy' : '';
			$background_image = \Aheto\Helper::get_background_attachment($funero_item_image, $funero_content_imgimage_size, $atts, 'funero_content_img', $funero_swiper_lazy);
		} ?>
		<div class="aheto-contents__wrap">

			<div class="aheto-contents__img " <?php echo esc_attr($background_image); ?>>
			</div>
			<div class="aheto-contents__content">
				<?php if ( !empty($funero_item_title_bg) ) {
					echo '<div class="aheto-contents__title-bg">' . esc_html($funero_item_title_bg) . '</div>';
				}
				if ( !empty($funero_item_subtitle) ) { ?>
					<p class="aheto-contents__subtitle"><?php echo esc_html($funero_item_subtitle); ?></p>
				<?php }
				if ( !empty($funero_item_title) ) { ?>
					<h4 class="aheto-contents__title"><?php echo esc_html($funero_item_title); ?></h4>
				<?php }

				if ( !empty($funero_item_desc) ) { ?>
					<p class="aheto-contents__desc"><?php echo esc_html($funero_item_desc); ?></p>
				<?php }

				if ( $funero_main_r_add_button == true ) { ?>
					<div class="aheto-contents__links">
						<?php echo \Aheto\Helper::get_button($this, $item, 'funero_main_r_'); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
