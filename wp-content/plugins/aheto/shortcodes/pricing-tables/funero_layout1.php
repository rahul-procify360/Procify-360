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
	wp_enqueue_style('funero-pricing-tables-layout1', $shortcode_dir . 'assets/css/funero_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
<?php
$funero_active =  $funero_active ? 'active' : '';
$funero_bg =  !empty($funero_background) ? 'style=background-color: '.$funero_background.';' : ''
?>
	<div class="aheto-pricing aheto-pricing--funero-default <?php echo esc_attr($funero_active); ?>" <?php echo esc_attr($funero_bg); ?>>

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
			$funero_features = $this->parse_group($funero_features);
			if (!empty($funero_features)) {

				echo '<div class="aheto-pricing__description"><ul>';

				foreach ($funero_features as $item) {
					// Include option
					echo '<li>';
					if (!empty($item['funero_feature'])) {
						echo esc_html($item['funero_feature']);
					} else {
						echo '&nbsp;';
					}
					echo '</li>';
				}

				echo '</ul></div>';
			}

			// Button Link.
			if ($funero_add_button == true) { ?>
				<div class="aheto-pricing__link">
					<?php echo \Aheto\Helper::get_button($this, $atts, 'funero_'); ?>
				</div>
			<?php }
			?>

		</div>

	</div>

</div>
