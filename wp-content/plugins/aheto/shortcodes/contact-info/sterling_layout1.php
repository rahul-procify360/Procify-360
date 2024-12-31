<?php

/**
 * Contact Info 1.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto__contact_info--sterling');

/**
 * Set dependent style
 */

$sc_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-contacts-1', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
$background_image = Helper::get_background_attachment($sterling_image, $sterling_image_size, $atts, 'sterling_');

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if (!empty($sterling_image)) : ?>
		<div class="widget_aheto__icon"
			<?php echo esc_attr($background_image); ?>>
		</div>
	<?php endif; ?>

	<div class="widget_aheto__infos">
		<?php if (!empty($sterling_description)) : ?>
			<p class="widget_aheto__desc">
				<?php echo esc_html($sterling_description); ?>
			</p>
		<?php endif; ?>
		<?php if (!empty($sterling_phone)) : $sterling_tel_phone = str_replace(" ", "", $sterling_phone) ?>
			<a class="widget_aheto__info-item" href="tel:<?php echo esc_attr($sterling_tel_phone); ?>">
				<?php echo esc_html($sterling_phone); ?>
			</a>
		<?php endif; ?>
		<?php if (!empty($sterling_phone2)) : $sterling_tel_phone2 = str_replace(" ", "", $sterling_phone2) ?>
			<a class="widget_aheto__info-item" href="tel:<?php echo esc_attr($sterling_tel_phone2); ?>">
				- <?php echo esc_html($sterling_phone2); ?>
			</a>
		<?php endif; ?>
	</div>
</div>
