<?php

/**
 * Contact Info default templates.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

$vestry_use_reverse  = isset($vestry_use_reverse) && $vestry_use_reverse  ? 'reverse-mod' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'widget_aheto__event--vestry');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', $vestry_use_reverse);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('vestry-contact-info-layout3', $shortcode_dir . 'assets/css/vestry_layout3.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if (!empty($text_day) || ($text_month)) { ?>
		<div class="widget_aheto__date-circle">
			<p><?php echo esc_html($text_day); ?></p>
			<p><?php echo esc_html($text_month); ?></p>
		</div>
	<?php }
	?>
	<?php if (!empty($vestry_title)) : ?>
		<div class="widget_aheto__title-wrapper">
			<h3 class="widget_aheto__title" <?php $this->render_attribute_string('title'); ?>>
				<?php echo esc_html($vestry_title); ?>
			</h3>
		</div>

	<?php endif;
	?>
	<div class="widget_aheto__infos">
		<?php if (!empty($vestry_date)) : ?>
			<div class="widget_aheto__info widget_aheto__info--date">
				<?php echo wp_kses($this->get_icon_for('date'), 'post'); ?>
				<div>
					<p><?php echo esc_html($vestry_date); ?></p>
					<p><?php echo esc_html($vestry_dateEnd); ?></p>
				</div>
			</div>
		<?php endif;
		if (!empty($vestry_address)) : ?>
			<div class="widget_aheto__info widget_aheto__info--address">
				<?php echo wp_kses($this->get_icon_for('address'), 'post'); ?>
				<p><?php echo esc_html($vestry_address); ?></p>
			</div>
		<?php endif;
		?>
	</div>
	<?php if (!empty($vestry_main_add_button)) { ?>
		<div class="widget_aheto__button">
			<div class="aheto--custom-links">
				<?php echo Helper::get_button($this, $atts, 'vestry_main_'); ?>
			</div>
		</div>
	<?php } ?>
</div>
