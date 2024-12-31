<?php
use Aheto\Helper;
/**
 * The List Shortcode.
 */

extract($atts);

$lists = $this->parse_group($lists);
if (empty($lists)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'sterling-list-1');

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/list/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-list-1', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php
		if (!empty($heading)) {
			echo '<' . $text_tag . ' class="sterling-list__title">' . esc_html($heading) . '</' . $text_tag . '>';
		}
	?>
	<ul>
		<?php
			foreach ($lists as $item) {
				echo '<li>' . wp_kses($item['list'], 'post') . '</li>';
			}
		?>
	</ul>
</div>
