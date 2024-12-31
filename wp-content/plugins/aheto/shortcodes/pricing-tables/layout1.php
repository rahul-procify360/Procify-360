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

// Button Link.
$link = $this->get_button_attributes('link');

// Icon.
$icon = $this->get_icon_attributes('', true, $atts);
if (!empty($icon)) {
	$this->add_render_attribute('icon', 'class', 'aheto-pricing__ico');
	$this->add_render_attribute('icon', 'class', $icon['icon']);
	$this->add_render_attribute('icon', 'class', $icon['align']);
	if (!empty($icon['color'])) {
		$this->add_render_attribute('icon', 'style', 'color:' . $icon['color']);
	}
}

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('pricing-tables-style-1', $sc_dir . 'assets/css/layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-pricing aheto-pricing--default">

		<div class="aheto-pricing__content">
			<?php
			// Heading.
			if ($heading) {
				echo '<h5 class="aheto-pricing__title">' . wp_kses_post($heading) . '</h5>';
			}

			// Price.
			echo '<div class="aheto-pricing__cost">' . esc_html($price) . '</div>';

			// Icon.
			if ($icon) {
				echo '<i ' . $this->get_render_attribute_string('icon') . '></i>';
			}

			// Description.
			if ($description) {
				echo '<div class="aheto-pricing__description"><p>' . wp_kses_post($description) . '</p></div>';
			}

			// Tag Line.
			if ($tag) {
				echo '<div class="aheto-pricing__options"><div class="aheto-pricing__options-item">' . esc_html($tag) . '</div></div>';
			}
			?>
		</div>

		<?php
		if (isset($link['href']) && !empty($link['title'])) {
			$this->add_render_attribute('button', $link);
			$this->add_render_attribute('button', 'class', 'aheto-btn aheto-pricing__btn');

			printf(
				'<div class="aheto-pricing__footer"><a %s>%s</a></div>',
				$this->get_render_attribute_string('button'),
				esc_html($link['title'])
			);
		}
		?>
	</div>

</div>
