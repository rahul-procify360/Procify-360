<?php
/**
 * Contact Forms default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

$full_width_button = isset($full_width_button) && $full_width_button ? 'full_width_button' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'widget_aheto__cf--pointe-center-form');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', $full_width_button);

$this->add_render_attribute('form', 'class', 'widget_aheto__form text-' . $button_align . ' count-' . $count_input);

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/contact-forms/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('pointe-cf-classic-form', $sc_dir . 'assets/css/pointe_layout5.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('pointe-cf-classic-form-js', $sc_dir . 'assets/js/pointe_layout5.min.js', array('jquery'), null);
} ?>


<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php if (!empty($title)) :

		echo '<' . $pointe_title_tag . ' class="widget_aheto__title">' . wp_kses_post($title) . '</' . $pointe_title_tag . '>';

	endif; ?>

	<div <?php $this->render_attribute_string('form'); ?>>

		<?php if (!empty($contact_form)) : ?>
			<div class="<?php echo Helper::get_button($this, $atts, 'form_', true); ?>">
				<?php echo do_shortcode('[contact-form-7 id="' . esc_attr($contact_form) . '"]'); ?>
			</div>
		<?php endif; ?>

	</div>

</div>
