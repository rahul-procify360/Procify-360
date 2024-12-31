<?php
use Aheto\Helper;
/**
 * The Progress Bar Shortcode.
 */

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-counter--sterling');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-progress-bar-layout1', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
} ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-counter__wrap">
		<?php
		if (!empty($sterling_number)) { ?>
			<div class="aheto-counter__number-wrap">
				<h2 class="aheto-counter__number js-counter"><?php echo esc_html($sterling_number); ?></h2>
				<?php if ( ! empty( $sterling_symbol ) ) { ?>
					<h2 class="aheto-counter__symbol"><?php echo esc_html( $sterling_symbol ); ?></h2>
				<?php } ?>
			</div>
		<?php }
		if (!empty($sterling_title)) {
			echo '<' . $sterling_title_tag . ' class="aheto-progress__title">' . wp_kses($sterling_title, 'post') . '</' . $sterling_title_tag . '>';
		}
		?>
	</div>
</div>
