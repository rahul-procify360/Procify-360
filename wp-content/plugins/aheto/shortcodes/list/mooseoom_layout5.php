<?php

/**
 * The List Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */
use Aheto\Helper;
extract($atts);

$lists = $this->parse_group($mooseoom_table_lists);
if (empty($lists)) {
	return '';
}
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-list--mooseoom-noborder-links');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/list/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('mooseoom-list-layout5', $shortcode_dir . 'assets/css/mooseoom_layout5.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php if (!empty($mooseoom_first_column) || !empty($mooseoom_second_column) || !empty($mooseoom_third_column)) {

		$mooseoom_first_column = !empty($mooseoom_first_column) ? $mooseoom_first_column : '';
		$mooseoom_second_column = !empty($mooseoom_second_column) ? $mooseoom_second_column : '';
		$mooseoom_third_column = !empty($mooseoom_third_column) ? $mooseoom_third_column : '';
	?>
		<div class="aheto-list--main-row">
			<div class="aheto-list--column">
				<?php echo wp_kses_post($mooseoom_first_column); ?>
			</div>
			<div class="aheto-list--column">
				<?php echo wp_kses_post($mooseoom_second_column); ?>
			</div>
			<div class="aheto-list--column">
				<?php echo wp_kses_post($mooseoom_third_column); ?>
			</div>
		</div>
	<?php } ?>

	<?php foreach ($lists as $item) { ?>
		<div class="aheto-list--row">
			<div class="aheto-list--column">
				<h6 class="aheto-list--column-heading"><?php echo wp_kses_post($mooseoom_first_column); ?></h6>
				<h5><?php echo wp_kses_post($item['mooseoom_first_item']); ?></h5>
			</div>
			<div class="aheto-list--column">
				<h6 class="aheto-list--column-heading"><?php echo wp_kses_post($mooseoom_second_column); ?></h6>
				<p><?php echo wp_kses_post($item['mooseoom_second_item']); ?></p>
			</div>
			<div class="aheto-list--column">
				<h6 class="aheto-list--column-heading"><?php echo wp_kses_post($mooseoom_third_column); ?></h6>
				<p><?php echo wp_kses_post($item['mooseoom_third_item']); ?></p>
			</div>
			<div class="aheto-list--column">
				<?php if ($item['mooseoom_main_add_button']) { ?>
					<div class="aheto-banner-slider__links">
						<?php echo Aheto\Helper::get_button($this, $item, 'mooseoom_main_'); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</div>
