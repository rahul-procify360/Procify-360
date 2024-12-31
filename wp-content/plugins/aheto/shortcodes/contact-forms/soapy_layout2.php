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

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', ' widget_aheto__cf--soapy-line-form');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-forms/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-contact-forms-layout2', $shortcode_dir . 'assets/css/soapy_layout2.css', null, null);
} ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="widget_aheto__form aheto-btn--primary">

		<?php if ( !empty($contact_form) ) : ?>

			<div class="<?php echo Helper::get_button($this, $atts, 'form_', true); ?>">
				<?php echo do_shortcode('[contact-form-7 id="' . esc_attr($contact_form) . '"]'); ?>
			</div>

		<?php endif; ?>

	</div>

</div>
