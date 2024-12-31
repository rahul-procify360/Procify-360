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
$this->add_render_attribute('wrapper', 'class', 'widget_aheto__contact--mooseoom-horz');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

$underline   = isset($underline) && $underline ? 'underline' : '';
$title_space = isset($title_space) && $title_space ? 'smaller-space' : '';

$this->add_render_attribute('title', 'class', 'widget_aheto__title');
$this->add_render_attribute('title', 'class', $underline);
$this->add_render_attribute('title', 'class', $title_space);

// Icon.
$icon_adress = $this->get_icon_attributes('mooseoom_address_', true, true);
if (!empty($icon_adress)) {
	$this->add_render_attribute('mooseoom_address_icon', 'class', 'widget_aheto__icon');
	$this->add_render_attribute('mooseoom_address_icon', 'class', $icon_adress['icon']);
	if (!empty($icon_adress['color'])) {
		$this->add_render_attribute('mooseoom_address_icon', 'style', 'color:' . $icon_adress['color'] . ';');
	}
	if (!empty($icon_adress['font_size'])) {
		$this->add_render_attribute('mooseoom_address_icon', 'style', 'font-size:' . $icon_adress['font_size']);
	}
}
$icon_phone = $this->get_icon_attributes('mooseoom_phone_', true, true);
if (!empty($icon_phone)) {
	$this->add_render_attribute('mooseoom_phone_icon', 'class', 'widget_aheto__icon');
	$this->add_render_attribute('mooseoom_phone_icon', 'class', $icon_phone['icon']);
	if (!empty($icon_phone['color'])) {
		$this->add_render_attribute('mooseoom_phone_icon', 'style', 'color:' . $icon_phone['color'] . ';');
	}
	if (!empty($icon_phone['font_size'])) {
		$this->add_render_attribute('mooseoom_phone_icon', 'style', 'font-size:' . $icon_phone['font_size']);
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('mooseoom-contact-info-layout2', $shortcode_dir . 'assets/css/mooseoom_layout2.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php
	if (!empty($title)) : ?>
		<h4 <?php $this->render_attribute_string('title'); ?>>
			<?php echo wp_kses_post($title); ?>
		</h4>
	<?php endif;
	?>

	<div class="widget_aheto__infos">

		<?php if (!empty($address)) : ?>
			<div class="widget_aheto__info widget_aheto__info--address">
				<?php if (!empty($icon_adress)) {
					echo '<i ' . $this->get_render_attribute_string('mooseoom_address_icon') . '></i>';
				} ?>
				<p><?php echo wp_kses_post($address); ?></p>
			</div>
		<?php endif;

		if (!empty($phone)) :
			$tel_phone = str_replace(" ", "", $phone); ?>
			<div class="widget_aheto__info widget_aheto__info--tel">
				<?php if (!empty($icon_phone)) {
					echo '<i ' . $this->get_render_attribute_string('mooseoom_phone_icon') . '></i>';
				} ?>
				<p> <?php echo esc_html($phone); ?> </p>
			</div>
		<?php endif; ?>

	</div>

</div>
