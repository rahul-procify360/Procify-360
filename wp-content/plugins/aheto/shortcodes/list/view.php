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

$lists = $this->parse_group($lists);
if ( empty($lists) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-list');
$this->add_render_attribute('wrapper', 'class', 'aheto-list--bullets');

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/list/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'list-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<ul>
		<?php
		foreach ( $lists as $item ) {
			echo '<li>' . wp_kses_post($item['list']) . '</li>';
		}
		?>
	</ul>

</div>
