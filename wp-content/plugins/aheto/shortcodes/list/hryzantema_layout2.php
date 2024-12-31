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

$lists = $this->parse_group($hryzantema_table_lists);
if ( empty($lists) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-list--hr-table-links');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/list/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-list-layout2', $shortcode_dir . 'assets/css/hryzantema_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php
	$hryzantema_first_column = !empty($hryzantema_first_column) ? $hryzantema_first_column : '';
	$hryzantema_second_column = !empty($hryzantema_second_column) ? $hryzantema_second_column : '';
	$hryzantema_third_column = !empty($hryzantema_third_column) ? $hryzantema_third_column : '';
	?>
	<div class="aheto-list--main-row">
		<div class="aheto-list--column">
			<?php echo wp_kses_post($hryzantema_first_column); ?>
		</div>
		<div class="aheto-list--column">
			<?php echo wp_kses_post($hryzantema_second_column); ?>
		</div>
		<div class="aheto-list--column">
			<?php echo wp_kses_post($hryzantema_third_column); ?>
		</div>
	</div>

	<?php foreach ( $lists as $item ) { ?>
	<div class="aheto-list--row">
		<div class="aheto-list--column">
			<h5 class="aheto-list--column-heading"><?php echo wp_kses_post($hryzantema_first_column); ?></h5>
			<?php if (!empty($item['hryzantema_first_item'])): ?>
			<h5><?php echo wp_kses_post($item['hryzantema_first_item']); ?></h5>
			<?php endif; ?>
		</div>
		<div class="aheto-list--column">
			<h5 class="aheto-list--column-heading"><?php echo wp_kses_post($hryzantema_second_column); ?></h5>
			<?php if (!empty($item['hryzantema_second_item'])): ?>
			<p><?php echo wp_kses_post($item['hryzantema_second_item']); ?></p>
			<?php endif; ?>
		</div>
		<div class="aheto-list--column">
			<h5 class="aheto-list--column-heading"><?php echo wp_kses_post($hryzantema_third_column); ?></h5>
			<?php if (!empty($item['hryzantema_third_item'])): ?>
			<p><?php echo wp_kses_post($item['hryzantema_third_item']); ?></p>
			<?php endif; ?>
		</div>
		<div class="aheto-list--column">
			<?php if ($item['hryzantema_main_add_button']) { ?>
			<div class="aheto-banner-slider__links">
				<?php echo Aheto\Helper::get_button($this, $item, 'hryzantema_main_'); ?>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>

</div>
