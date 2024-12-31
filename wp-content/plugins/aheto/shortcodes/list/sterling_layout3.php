<?php

/**
 * The List Shortcode 3.
 */
use Aheto\Helper;
extract($atts);
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('inner', 'class', 'sterling-list-3 sterling-list--number');

if (isset($index) && !empty($index)) {
	$this->add_render_attribute('inner', 'data-index', $index);
}

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/list/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-list-3', $sc_dir . 'assets/css/sterling_layout3.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('inner'); ?>>
		<?php
		if (!empty($heading)) {
			echo '<' . $text_tag . ' class="sterling-list__title">' . esc_html($heading) . '</' . $text_tag . '>';
		}
		if (!empty($description)) {
			echo '<p class="sterling-list__text">' . esc_html($description) . '</p>';
		}
		?>
	</div>
</div>
