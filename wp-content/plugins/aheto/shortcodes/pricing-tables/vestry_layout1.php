<?php

/**
 * The Pricing Tables Shortcode.
 */

use Aheto\Helper;

extract($atts);
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Button Link.
$link = $this->get_button_attributes('link');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('vestry-pricing-tables-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-pricing aheto-pricing--vestry-default <?php echo esc_attr(isset($vestry_active) && $vestry_active ? 'active' : ''); ?>" style="background-color:<?php echo esc_attr($vestry_background); ?>">
		<?php
		// Heading.
		if (!empty($heading)) {
			echo '<div class="aheto-pricing__header"><h5 class="aheto-pricing__title">' . esc_html($heading) . '</h5></div>';
		}
		?>
		<div class="aheto-pricing__content">
			<div class="aheto-pricing__cost">
				<?php
				// Price.
				if (!empty($price)) {
					echo '<span class="aheto-pricing__cost-value">' . esc_html($price) . '</span>';
				}
				// Per Time.
				if (!empty($description)) {
					echo '<span class="aheto-pricing__cost-time">' . '/' . esc_html($description) . '</span>';
				}
				?>
			</div>
			<?php
			$vestry_features = $this->parse_group($vestry_features);
			if (!empty($vestry_features)) {
				echo '<div class="aheto-pricing__description"><ul>';
				foreach ($vestry_features as $item) {
					// Include option
					$vestry_use_include  = isset($item['vestry_use_include']) && $item['vestry_use_include']  ? 'disable' : '';
					echo '<li class="' .  esc_attr($vestry_use_include) . '">';
					if (isset($item['vestry_feature'])) {
						echo esc_html($item['vestry_feature']);
					} else {
						echo '&nbsp;';
					}
					echo '</li>';
				}
				echo '</ul></div>';
			}
			// Button Link.
			if (!empty($vestry_add_button)) { ?>
				<div class="aheto-pricing__link">
					<?php echo \Aheto\Helper::get_button($this, $atts, 'vestry_'); ?>
				</div>
			<?php }
			?>
		</div>
	</div>
</div>
