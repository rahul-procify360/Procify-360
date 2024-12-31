<?php

/**
 * The Progress Bar Shortcode.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-counter--mooseoom-classic');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('mooseoom-progress-bar-layout1', $shortcode_dir . 'assets/css/mooseoom_layout1.css', null, null);
}  ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php

	// Percentage
	if (!empty($mooseoom_number)) { ?>
		<div class="aheto-counter__number-wrap">

			<?php echo '<' . $mooseoom_number_tag . ' class="aheto-counter__number js-counter">' . wp_kses_post($mooseoom_number) . '</' . $mooseoom_number_tag . '>'; ?>
		</div>

	<?php }

	// Heading.
	if (!empty($heading)) {

		echo '<' . $mooseoom_text_tag . ' class="aheto-progress__dec">' . wp_kses_post($heading) . '</' . $mooseoom_text_tag . '>';
	?>
	<?php } ?>
</div>
