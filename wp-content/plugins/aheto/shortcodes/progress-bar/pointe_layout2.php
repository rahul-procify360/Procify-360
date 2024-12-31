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
$this->add_render_attribute('wrapper', 'class', 'aheto-counter--pointe-classic');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/progress-bar/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('pointe-progress-bar-layout2', $sc_dir . 'assets/css/pointe_layout2.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php

	// Percentage
	if (!empty($pointe_number)) { ?>
		<div class="aheto-counter__number-wrap">

			<?php echo '<' . $pointe_number_tag . ' class="aheto-counter__number js-counter">' . wp_kses_post($pointe_number) . '</' . $pointe_number_tag . '>'; ?>
			<?php if (!empty($pointe_symbol)) {
				echo wp_kses_post('<span>' . ($pointe_symbol) . '</span>')
			?>
			<?php } ?>


		</div>

	<?php }

	// Heading.
	if (!empty($heading)) {

		echo '<' . $pointe_text_tag . ' class="aheto-progress__title">' . wp_kses_post($heading) . '</' . $pointe_text_tag . '>';
	?>
	<?php } ?>
</div>
