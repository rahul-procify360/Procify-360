<?php

/**
 * The List Shortcode.
 */

use Aheto\Helper;

extract($atts);

$lists = $this->parse_group($vestry_table_lists);
if (empty($lists)) {
	return '';
}

$lists_ts = $this->parse_group($vestry_table_lists_ts);
if (empty($lists_ts)) {
	return '';
}

$lists_w = $this->parse_group($vestry_table_lists_w);
if (empty($lists_w)) {
	return '';
}

$lists_th = $this->parse_group($vestry_table_lists_th);
if (empty($lists_th)) {
	return '';
}

$lists_f = $this->parse_group($vestry_table_lists_f);
if (empty($lists_f)) {
	return '';
}

$lists_st = $this->parse_group($vestry_table_lists_st);
if (empty($lists_st)) {
	return '';
}

$lists_sn = $this->parse_group($vestry_table_lists_sn);
if (empty($lists_sn)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-list--vestry-table-links');


/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/list/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'vestry-list-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('vestry-list-layout1-js', $shortcode_dir . 'assets/js/vestry_layout1.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-list__header">
		<button class="aheto-list__header-item tablink active" onclick="openDay(event, 'Monday')">Monday</button>
		<button class="aheto-list__header-item tablink" onclick="openDay(event, 'Tuesday')">Tuesday</button>
		<button class="aheto-list__header-item tablink" onclick="openDay(event, 'Wednesday')">Wednesday</button>
		<button class="aheto-list__header-item tablink" onclick="openDay(event, 'Thursday')">Thursday</button>
		<button class="aheto-list__header-item tablink" onclick="openDay(event, 'Friday')">Friday</button>
		<button class="aheto-list__header-item tablink" onclick="openDay(event, 'Saturday')">Saturday</button>
		<button class="aheto-list__header-item tablink" onclick="openDay(event, 'Sunday')">Sunday</button>
	</div>

	<div id="Monday" class="aheto-list__content event-day" style="display:table">
		<?php if (!empty($vestry_first_column) || !empty($vestry_second_column) || !empty($vestry_third_column)) {
			$vestry_first_column = !empty($vestry_first_column) ? $vestry_first_column : '';
			$vestry_second_column = !empty($vestry_second_column) ? $vestry_second_column : '';
			$vestry_third_column = !empty($vestry_third_column) ? $vestry_third_column : '';
			$vestry_fourth_column = !empty($vestry_fourth_column) ? $vestry_fourth_column : '';
		?>
			<div class="aheto-list--main-row">
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_first_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_second_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_third_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_fourth_column); ?>
				</div>
			</div>
		<?php } ?>

		<?php foreach ($lists as $item) { ?>
			<div class="aheto-list--row">
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_first_column); ?></h6>
					<?php echo esc_html($item['vestry_first_item']); ?>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_second_column); ?></h6>
					<h5><?php echo esc_html($item['vestry_second_item']); ?></h5>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_third_column); ?></h6>
					<?php echo esc_html($item['vestry_third_item']); ?>
				</div>
				<div class="aheto-list--column">
					<?php if ($item['vestry_main_add_button']) { ?>
						<div class="aheto-banner-slider__links">
							<?php echo Aheto\Helper::get_button($this, $item, 'vestry_main_'); ?>
						</div>
					<?php } ?>
				</div>
			</div>

		<?php } ?>
	</div>

	<div id="Tuesday" class="aheto-list__content event-day" style="display:none">
		<?php if (!empty($vestry_first_column) || !empty($vestry_second_column) || !empty($vestry_third_column)) {
			$vestry_first_column = !empty($vestry_first_column) ? $vestry_first_column : '';
			$vestry_second_column = !empty($vestry_second_column) ? $vestry_second_column : '';
			$vestry_third_column = !empty($vestry_third_column) ? $vestry_third_column : '';
			$vestry_fourth_column = !empty($vestry_fourth_column) ? $vestry_fourth_column : '';
		?>
			<div class="aheto-list--main-row">
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_first_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_second_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_third_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_fourth_column); ?>
				</div>
			</div>
		<?php } ?>

		<?php foreach ($lists_ts as $item) { ?>
			<div class="aheto-list--row">
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_first_column); ?></h6>
					<?php echo esc_html($item['vestry_first_item_ts']); ?>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_second_column); ?></h6>
					<h5><?php echo esc_html($item['vestry_second_item_ts']); ?></h5>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_third_column); ?></h6>
					<?php echo esc_html($item['vestry_third_item_ts']); ?>
				</div>
				<div class="aheto-list--column">
					<?php if ($item['vestry_main_add_button']) { ?>
						<div class="aheto-banner-slider__links">
							<?php echo Aheto\Helper::get_button($this, $item, 'vestry_main_ts_'); ?>
						</div>
					<?php } ?>
				</div>
			</div>

		<?php } ?>
	</div>

	<div id="Wednesday" class="aheto-list__content event-day" style="display:none">
		<?php if (!empty($vestry_first_column) || !empty($vestry_second_column) || !empty($vestry_third_column)) {
			$vestry_first_column = !empty($vestry_first_column) ? $vestry_first_column : '';
			$vestry_second_column = !empty($vestry_second_column) ? $vestry_second_column : '';
			$vestry_third_column = !empty($vestry_third_column) ? $vestry_third_column : '';
			$vestry_fourth_column = !empty($vestry_fourth_column) ? $vestry_fourth_column : '';
		?>
			<div class="aheto-list--main-row">
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_first_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_second_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_third_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_fourth_column); ?>
				</div>
			</div>
		<?php } ?>

		<?php foreach ($lists_w as $item) { ?>
			<div class="aheto-list--row">
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_first_column); ?></h6>
					<?php echo esc_html($item['vestry_first_item_w']); ?>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_second_column); ?></h6>
					<h5><?php echo esc_html($item['vestry_second_item_w']); ?></h5>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_third_column); ?></h6>
					<?php echo esc_html($item['vestry_third_item_w']); ?>
				</div>
				<div class="aheto-list--column">
					<?php if ($item['vestry_main_add_button']) { ?>
						<div class="aheto-banner-slider__links">
							<?php echo Aheto\Helper::get_button($this, $item, 'vestry_main_w_'); ?>
						</div>
					<?php } ?>
				</div>
			</div>

		<?php } ?>
	</div>

	<div id="Thursday" class="aheto-list__content event-day" style="display:none">
		<?php if (!empty($vestry_first_column) || !empty($vestry_second_column) || !empty($vestry_third_column)) {
			$vestry_first_column = !empty($vestry_first_column) ? $vestry_first_column : '';
			$vestry_second_column = !empty($vestry_second_column) ? $vestry_second_column : '';
			$vestry_third_column = !empty($vestry_third_column) ? $vestry_third_column : '';
			$vestry_fourth_column = !empty($vestry_fourth_column) ? $vestry_fourth_column : '';
		?>
			<div class="aheto-list--main-row">
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_first_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_second_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_third_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_fourth_column); ?>
				</div>
			</div>
		<?php } ?>

		<?php foreach ($lists_th as $item) { ?>
			<div class="aheto-list--row">
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_first_column); ?></h6>
					<?php echo esc_html($item['vestry_first_item_th']); ?>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_second_column); ?></h6>
					<h5><?php echo esc_html($item['vestry_second_item_th']); ?></h5>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_third_column); ?></h6>
					<?php echo esc_html($item['vestry_third_item_th']); ?>
				</div>
				<div class="aheto-list--column">
					<?php if ($item['vestry_main_add_button']) { ?>
						<div class="aheto-banner-slider__links">
							<?php echo Aheto\Helper::get_button($this, $item, 'vestry_main_th_'); ?>
						</div>
					<?php } ?>
				</div>
			</div>

		<?php } ?>
	</div>

	<div id="Friday" class="aheto-list__content event-day" style="display:none">
		<?php if (!empty($vestry_first_column) || !empty($vestry_second_column) || !empty($vestry_third_column)) {
			$vestry_first_column = !empty($vestry_first_column) ? $vestry_first_column : '';
			$vestry_second_column = !empty($vestry_second_column) ? $vestry_second_column : '';
			$vestry_third_column = !empty($vestry_third_column) ? $vestry_third_column : '';
			$vestry_fourth_column = !empty($vestry_fourth_column) ? $vestry_fourth_column : '';
		?>
			<div class="aheto-list--main-row">
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_first_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_second_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_third_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_fourth_column); ?>
				</div>
			</div>
		<?php } ?>

		<?php foreach ($lists_f as $item) { ?>
			<div class="aheto-list--row">
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_first_column); ?></h6>
					<?php echo esc_html($item['vestry_first_item_f']); ?>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_second_column); ?></h6>
					<h5><?php echo esc_html($item['vestry_second_item_f']); ?></h5>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_third_column); ?></h6>
					<?php echo esc_html($item['vestry_third_item_f']); ?>
				</div>
				<div class="aheto-list--column">
					<?php if ($item['vestry_main_add_button']) { ?>
						<div class="aheto-banner-slider__links">
							<?php echo Aheto\Helper::get_button($this, $item, 'vestry_main_f_'); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>

	<div id="Saturday" class="aheto-list__content event-day" style="display:none">
		<?php if (!empty($vestry_first_column) || !empty($vestry_second_column) || !empty($vestry_third_column)) {
			$vestry_first_column = !empty($vestry_first_column) ? $vestry_first_column : '';
			$vestry_second_column = !empty($vestry_second_column) ? $vestry_second_column : '';
			$vestry_third_column = !empty($vestry_third_column) ? $vestry_third_column : '';
			$vestry_fourth_column = !empty($vestry_fourth_column) ? $vestry_fourth_column : '';
		?>
			<div class="aheto-list--main-row">
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_first_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_second_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_third_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_fourth_column); ?>
				</div>
			</div>
		<?php } ?>

		<?php foreach ($lists_st as $item) { ?>
			<div class="aheto-list--row">
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_first_column); ?></h6>
					<?php echo esc_html($item['vestry_first_item_st']); ?>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_second_column); ?></h6>
					<h5><?php echo esc_html($item['vestry_second_item_st']); ?></h5>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_third_column); ?></h6>
					<?php echo esc_html($item['vestry_third_item_st']); ?>
				</div>
				<div class="aheto-list--column">
					<?php if ($item['vestry_main_add_button']) { ?>
						<div class="aheto-banner-slider__links">
							<?php echo Aheto\Helper::get_button($this, $item, 'vestry_main_st_'); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>

	<div id="Sunday" class="aheto-list__content event-day" style="display:none">
		<?php if (!empty($vestry_first_column) || !empty($vestry_second_column) || !empty($vestry_third_column)) {

			$vestry_first_column = !empty($vestry_first_column) ? $vestry_first_column : '';
			$vestry_second_column = !empty($vestry_second_column) ? $vestry_second_column : '';
			$vestry_third_column = !empty($vestry_third_column) ? $vestry_third_column : '';
			$vestry_fourth_column = !empty($vestry_fourth_column) ? $vestry_fourth_column : '';
		?>
			<div class="aheto-list--main-row">
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_first_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_second_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_third_column); ?>
				</div>
				<div class="aheto-list--column">
					<?php echo esc_html($vestry_fourth_column); ?>
				</div>
			</div>
		<?php } ?>

		<?php foreach ($lists_sn as $item) { ?>
			<div class="aheto-list--row">
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_first_column); ?></h6>
					<?php echo esc_html($item['vestry_first_item_sn']); ?>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_second_column); ?></h6>
					<h5><?php echo esc_html($item['vestry_second_item_sn']); ?></h5>
				</div>
				<div class="aheto-list--column">
					<h6><?php echo esc_html($vestry_third_column); ?></h6>
					<?php echo esc_html($item['vestry_third_item_sn']); ?>
				</div>
				<div class="aheto-list--column">
					<?php if ($item['vestry_main_add_button']) { ?>
						<div class="aheto-banner-slider__links">
							<?php echo Aheto\Helper::get_button($this, $item, 'vestry_main_sn_'); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
