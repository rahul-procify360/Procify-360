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

/**
 * Set dependent script
 */

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-heading');
$this->add_render_attribute('wrapper', 'class', 'aheto-heading--w-icon');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

$text_tag = isset($text_tag) && !empty($text_tag) ? $text_tag : 'h1';
$animation = isset($title_animation) && !empty($title_animation);


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/heading/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('heading-style-2', $sc_dir . 'assets/css/layout2.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('typed');
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php if ($image) : ?>
		<div class="aheto-heading__img"><?php echo Helper::get_attachment($image); ?></div>
	<?php endif; ?>

	<div class="aheto-heading__wrap">
		<?php
		// Heading.
		$heading = $this->get_heading();
		if ($heading) {
			echo '<' . $text_tag . ' class="aheto-heading__title">' . $this->highlight_text($heading, $animation) . '</' . $text_tag . '>';
		}

		// Description.
		if ($description) {
			echo '<p class="aheto-heading__desc">' . wp_kses_post($description) . '</p>';
		}
		?>
	</div>

</div>
