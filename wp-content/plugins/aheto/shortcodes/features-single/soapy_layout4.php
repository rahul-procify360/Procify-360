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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content-block--soapy-rounded');
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-features-single-layout4', $shortcode_dir . 'assets/css/soapy_layout4.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<div class="aheto-content-block__img-wrap">
			<?php if ( !empty($soapy_image_bg) ) {
				echo Helper::get_attachment($soapy_image_bg, ['class' => 'aheto-content-block__image']);
			} ?>
			<?php if(!empty($soapy_image_num) && !empty($soapy_number)):
				$background_image = Helper::get_background_attachment($soapy_image_num, $soapy_image_size, $atts, '');?>
				<div class="aheto-content-block__number" <?php echo esc_html($background_image);?>>
					<?php echo esc_html($soapy_number);?>
				</div>
			<?php endif;?>
		</div>
		<div class="aheto-content-block__info">
			<?php if ( !empty($soapy_title) ) : ?>
				<h5 class="aheto-content-block__title "><?php echo wp_kses($soapy_title, 'post'); ?></h5>
			<?php endif; ?>
		</div>
	</div>
</div>
