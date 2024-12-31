<?php
/**
 * The Pricing Tables Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
$this->generate_css();

//Active
$ninedok_active = $ninedok_active ? 'aheto-pricing__active' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--ninedok-narrow');
$this->add_render_attribute('wrapper', 'class', $ninedok_active);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


$ninedok_heading = str_replace(']]', '</span>', $ninedok_heading);
$ninedok_heading = str_replace('[[', '<span>', $ninedok_heading);


// Button Link.
$link = $this->get_button_attributes('link');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('ninedok-pricing-tables-layout3', $shortcode_dir . 'assets/css/ninedok_layout3.css', null, null);
} ?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-pricing__header">

		<?php
		// Heading.
		if (!empty($ninedok_heading)) {
			echo '<h5 class="aheto-pricing__title">' . wp_kses($ninedok_heading, 'post') . '</h5>';
		}
		?>
	</div>

	<div class="aheto-pricing__cost">
		<?php
		// Price.
		if (!empty($price)) {
			echo '<div class="aheto-pricing__cost-value">' . esc_html($price) . '</div>';
		}

		if (!empty($description)) {
			echo '<h5 class="aheto-pricing__cost-time">' . '' . wp_kses($description, 'post') . '</h5>';
		}
		?>
	</div>

	<div class="aheto-pricing__content">

		<?php
		$ninedok_features = $this->parse_group($ninedok_features);
		if (!empty($ninedok_features)) { ?>

			<div class="aheto-pricing__list">

				<?php foreach ($ninedok_features as $item) {
					$item['mark'] = isset($item['mark']) ? $item['mark'] : ''; ?>
					<div class="aheto-pricing__list-item-wrap">
						<h6 class="aheto-pricing__list-item <?php echo esc_html($item['mark']); ?>"><?php echo wp_kses_post($item['ninedok_feature']); ?></h6>
					</div>
				<?php } ?>

			</div>
		<?php }

		// Button Link.
		if ($ninedok_narrow_add_button) { ?>
			<div class="aheto-pricing__link">
				<?php echo \Aheto\Helper::get_button($this, $atts, 'ninedok_narrow_'); ?>
			</div>
		<?php }
		?>

	</div>

</div>
