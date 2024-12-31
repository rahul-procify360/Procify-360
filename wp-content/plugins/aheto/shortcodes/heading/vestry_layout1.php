<?php

/**
 * The Heading Shortcode.
 */


use Aheto\Helper;

extract($atts);

$this->generate_css();

$vestry_use_grey_border  = isset($vestry_use_grey_border) && $vestry_use_grey_border  ? 'border-gr' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-heading--vestry__simple');
$this->add_render_attribute('wrapper', 'class', $alignment);
$this->add_render_attribute('wrapper', 'class', 'align-mob-' . $vestry_align_mobile);
$this->add_render_attribute('wrapper', 'class', $vestry_use_grey_border);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('vestry-heading-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php
		if (!empty($vestry_subtitle)) {
			echo '<' . $vestry_subtitle_tag . ' class="aheto-heading__subtitle">' . esc_html($vestry_subtitle) . '</' . $vestry_subtitle_tag . '>';
		}
		if (!empty($heading)) {
			$heading = $this->highlight_text($heading);
			echo '<' . $text_tag . ' class="aheto-heading__title">' . $this->highlight_text($heading) . '</' . $text_tag . '>';
		}
	?>
</div>
