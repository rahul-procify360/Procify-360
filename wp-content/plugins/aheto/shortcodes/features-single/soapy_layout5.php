<?php
/**
 * The Features Shortcode.
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
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content-block--soapy-year');
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-features-single-layout5', $shortcode_dir . 'assets/css/soapy_layout5.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<div class="aheto-content-block__info-year">
			<?php if ( !empty($soapy_year) ) : ?>
				<h4 class="aheto-content-block__year "><?php echo esc_html($soapy_year); ?></h4>
			<?php endif; ?>
			<?php if ( !empty($soapy_year_desc) ) : ?>
				<p class="aheto-content-block__year-desc ">
					<?php echo esc_html($soapy_year_desc); ?>
				</p>
			<?php endif; ?>
		</div>
		<div class="aheto-content-block__info">
			<?php if ( !empty($soapy_title) ) : ?>
				<h4 class="aheto-content-block__title "><?php echo esc_html($soapy_title); ?></h4>
			<?php endif; ?>
			<?php if ( !empty($soapy_desc) ) : ?>
				<p class="aheto-content-block__info-text ">
					<?php echo esc_html($soapy_desc); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
