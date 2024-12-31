<?php

/**
 * The Progress Bar Shortcode.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-counter--vestry-modern');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'vestry-progress-bar-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-counter__wrap">
		<?php
		// Percentage
		if (!empty($vestry_number)) { ?>
			<div class="aheto-counter__number-wrap">
				<h2 class="aheto-counter__number js-counter"><?php echo esc_html($vestry_number); ?></h2>
			</div>
		<?php }
		// Heading
		if (!empty($heading)) {
			echo '<' . $vestry_title_tag . ' class="aheto-progress__title">' . esc_html($heading, 'post') . '</' . $vestry_title_tag . '>';
		}
		// Description
		if (!empty($description)) { ?>
			<p class="aheto-counter__desc"><?php echo esc_html($description, 'post'); ?></p>
		<?php } ?>
	</div>
</div>
