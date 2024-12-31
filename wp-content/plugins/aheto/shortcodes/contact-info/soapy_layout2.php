<?php
/**
 * Contact Info default templates.
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
$this->add_render_attribute('wrapper', 'class', $soapy_align);
$this->add_render_attribute('wrapper', 'class', ' widget_aheto__contact_info--soapy-image');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('title', 'class', 'widget_aheto__title');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-contact-info-layout2', $shortcode_dir . 'assets/css/soapy_layout2.css', null, null);
} ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if ( !empty($soapy_image) ): ?>
		<div class="widget_aheto__img-wrap">
			<?php echo Helper::get_attachment($soapy_image, ['class' => 'widget_aheto__img'], $image_size, $atts); ?>
		</div>
	<?php endif; ?>
	<div class="widget_aheto__infos">
		<?php if ( !empty($title) ) : ?>
			<h5 <?php $this->render_attribute_string('title'); ?>>
				<?php echo esc_html($title); ?>
			</h5>
		<?php endif; ?>
		<?php if ( !empty($soapy_text) ) : ?>
			<p><?php echo wp_kses($soapy_text, 'post'); ?></p>
		<?php endif; ?>
	</div>

</div>
