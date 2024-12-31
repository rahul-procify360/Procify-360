<?php

use Aheto\Helper;

/**
 * The List Shortcode.
 */

extract($atts);

$lists = $this->parse_group($sterling_table_lists);
if (empty($lists)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-list aheto-list--sterling-table-links');


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/list/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-list-5', $sc_dir . 'assets/css/sterling_layout5.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php if (!empty($sterling_first_column) || !empty($sterling_second_column) || !empty($sterling_third_column)) {

		$sterling_first_column = !empty($sterling_first_column) ? $sterling_first_column : '';
		$sterling_second_column = !empty($sterling_second_column) ? $sterling_second_column : '';
		$sterling_third_column = !empty($sterling_third_column) ? $sterling_third_column : '';
		?>
		<div class="aheto-list--main-row">
			<div class="aheto-list--column">
				<?php echo wp_kses($sterling_first_column, 'post'); ?>
			</div>
			<div class="aheto-list--column">
				<?php echo wp_kses($sterling_second_column, 'post'); ?>
			</div>
			<div class="aheto-list--column">
				<?php echo wp_kses($sterling_third_column, 'post'); ?>
			</div>
		</div>
	<?php } ?>

	<?php foreach ($lists as $item) { ?>
		<div class="aheto-list--row">
			<div class="aheto-list--column">
				<h5 class="aheto-list--column-heading"><?php echo wp_kses($sterling_first_column, 'post'); ?></h5>
				<h5><?php echo wp_kses($item['sterling_first_item'], 'post'); ?></h5>
			</div>
			<div class="aheto-list--column">
				<h5 class="aheto-list--column-heading"><?php echo wp_kses($sterling_second_column, 'post'); ?></h5>
				<p><?php echo wp_kses($item['sterling_second_item'], 'post'); ?></p>
			</div>
			<div class="aheto-list--column">
				<h5 class="aheto-list--column-heading"><?php echo wp_kses($sterling_third_column, 'post'); ?></h5>
				<p><?php echo wp_kses($item['sterling_third_item'], 'post'); ?></p>
			</div>
			<div class="aheto-list--column">
				<?php if ($item['sterling_main_add_button']) { ?>
					<div class="aheto-list__links">
						<?php echo Aheto\Helper::get_button($this, $item, 'sterling_main_'); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</div>
