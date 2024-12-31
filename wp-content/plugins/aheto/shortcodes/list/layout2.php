<?php
/**
 * The List Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('inner', 'class', 'aheto-list');
$this->add_render_attribute('inner', 'class', 'aheto-list--number');

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
	wp_enqueue_style('list-style-2', $sc_dir . 'assets/css/layout2.css', null, null);
}


?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('inner'); ?>>

		<?php
		// Heading.
		if ($heading) {
			echo '<' . $text_tag . ' class="aheto-list__title">' . wp_kses_post($heading) . '</' . $text_tag . '>';
		}

		// Description.
		if ($description) {
			echo '<p class="aheto-list__text">' . wp_kses_post($description) . '</p>';
		}
		?>

	</div>

</div>
