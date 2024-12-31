<?php
/**
 * The Pricing Tables Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('pricing-tables-style-4', $sc_dir . 'assets/css/layout4.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-pricing aheto-pricing--tableHead js-pricing-height">

		<div class="aheto-pricing__header js-pricing-height" data-height-key="header">

			<?php
			// Heading.
			if ($heading) {
				echo '<h3 class="aheto-pricing__title">' . str_replace('[br]', '<br>', wp_kses_post($heading)) . '</h3>';
			}
			?>

		</div>

		<div class="aheto-pricing__content">

			<?php
			$features = $this->parse_group($features);
			if (!empty($features)) {

				echo '<div class="aheto-pricing__list">';

				foreach ($features as $key => $item) {
					echo '<div class="aheto-pricing__list-item js-pricing-items" data-height-key="key-' . esc_attr($key) . '">';
					if (isset($item['feature'])) {
						echo '<p>' . wp_kses_post($item['feature']) . '</p>';
					}
					echo '</div>';
				}

				echo '</div>';
			}
			?>

		</div>

	</div>

</div>
