<?php
/**
 * The Heading Shortcode.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-heading');
$this->add_render_attribute('wrapper', 'class', 'aheto-heading--main');
$this->add_render_attribute('wrapper', 'class', $alignment);
$this->add_render_attribute('wrapper', 'class', 'align-tablet-' . $align_tablet);
$this->add_render_attribute('wrapper', 'class', 'align-mob-' . $align_mobile);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

$animation = isset($title_animation) && !empty($title_animation);


// Icon.
$icon = $this->get_icon_attributes('', true, true);
if (!empty($icon)) {
	$this->add_render_attribute('icon', 'class', 'aheto-content-block__ico icon');
	$this->add_render_attribute('icon', 'class', $icon['icon']);
	if (!empty($icon['color'])) {
		$this->add_render_attribute('icon', 'style', 'color:' . $icon['color']);
	}
}


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/heading/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('heading-style-1', $sc_dir . 'assets/css/layout1.css', null, null);
}

if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('typed');
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php
	// Icon.
	if (!empty($icon)) { ?>
		<div class="aheto-heading__icon">
			<?php echo '<i ' . $this->get_render_attribute_string('icon') . '></i>'; ?>
		</div>
	<?php }
	?>

	<?php
	// Heading.
	$heading = $this->get_heading();
	$text_indent = isset($text_indent) && $text_indent ? 'text-indent' : '';

	if (!empty($heading)) {
		echo '<' . $text_tag . ' class="aheto-heading__title ' . esc_attr($text_indent) . '">' . $this->highlight_text($heading, $animation) . '</' . $text_tag . '>';
	}

	// Description.
	if ($description) {
		echo '<p class="aheto-heading__desc">' . wp_kses_post($description) . '</p>';
	}
	?>

</div>
