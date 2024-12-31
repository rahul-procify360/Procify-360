<?php

/**
 * The Contents Shortcode.
 */

extract($atts);

use Aheto\Helper;

$faqs = $this->parse_group($faqs);

if (empty($faqs)) {
	return '';
}
$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contents--vestry-faqarr');
$this->add_render_attribute('wrapper', 'class', 'js-accordion-parent');

if (isset($multi_active) && !empty($multi_active)) {
	$this->add_render_attribute('wrapper', 'data-multiple', '1');
}

/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('vestry-contents-layout2', $shortcode_dir . 'assets/css/vestry_layout2.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if ($vestry_add_video_button) {
		$background_image = \Aheto\Helper::get_background_attachment($vestry_video_image, $vestry_image_size, $atts, 'vestry_');  ?>
		<div class="aheto-contents__video-block" <?php echo esc_attr($background_image); ?>>
			<?php echo \Aheto\Helper::get_video_button($atts, 'vestry_'); ?>
		</div>
	<?php } ?>
	<?php $text_background_image = \Aheto\Helper::get_background_attachment($vestry_content_image, 'full');  ?>
	<div class="aheto-contents__faqs-block" <?php echo esc_attr($text_background_image); ?>>
		<?php
		if (!empty($vestry_subtitle)) {
			echo '<' . $vestry_subtitle_tag . ' class="aheto-heading__subtitle">' . esc_html($vestry_subtitle) . '</' . $vestry_subtitle_tag . '>';
		}
		if (!empty($vestry_title)) {
			echo '<' . $vestry_title_tag . ' class="aheto-heading__title">' . esc_html($vestry_title) . '</' . $vestry_title_tag . '>';
		}
		?>
		<?php
		foreach ($faqs as $key => $item) :
			$class_active = $key === 0 && $first_is_opened ? 'is-open' : '';
			$active_display = $key === 0 && $first_is_opened ? 'block' : 'none';
			if (empty($item['title']) && empty($item['description'])) {
				continue;
			}
		?>
			<div class="aheto-contents__item <?php echo esc_attr($class_active); ?>">
				<?php if (!empty($item['title'])) : ?>
					<h5 class="aheto-contents__title js-accordion"><?php echo esc_html($item['title'], 'post'); ?></h5>
				<?php endif; ?>
				<?php if (!empty($item['description'])) : ?>
					<div class="aheto-contents__panel js-accordion-text" style="display: <?php echo esc_attr($active_display); ?>">
						<div class="aheto-contents__desc">
							<?php echo wpautop($item['description']); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
