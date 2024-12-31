<?php

/**
 * The Heading Shortcode.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-heading--sterling__simple');
$this->add_render_attribute('wrapper', 'class', $alignment);
$this->add_render_attribute('wrapper', 'class', 'align-mob-' . $sterling_align_mobile);
// $this->add_render_attribute( 'wrapper', 'class', 'align-tab-' . $$sterling_align_tablet );


/**
 * Set dependent style
 */
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
$sc_dir     = aheto()->plugin_url() . 'shortcodes/heading/';

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-heading-simple', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php
	if (!empty($sterling_subtitle)) {
		echo '<' . $sterling_subtitle_tag . ' class="aheto-heading__subtitle">' . esc_html($sterling_subtitle) . '</' . $sterling_subtitle_tag . '>';
	}
	if (!empty($sterling_title)) {
		echo '<' . $sterling_title_tag . ' class="aheto-heading__title">' . wp_kses($sterling_title, 'post') . '</' . $sterling_title_tag . '>';
	} ?>
</div>
