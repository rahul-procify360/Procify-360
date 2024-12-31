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
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--karma_events-simple');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
if ( $karma_events_active == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--karma_events-active');
}
if ( $karma_events_add_boxshadow == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--karma_events-shadow');
}
// Button Link.
$link = $this->get_button_attributes('link');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_events-pricing-tables-layout1', $shortcode_dir . 'assets/css/karma_events_layout1.css', null, null);
}?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-pricing aheto-pricing--tableColumn ">
		<?php
		$background_image = '';
		if ( !empty($karma_events_image) ) {
			$background_image = Helper::get_background_attachment($karma_events_image, 'full', $atts);

		} ?>
		<div class="aheto-pricing__content " <?php echo esc_attr($background_image); ?>>
			<div class="aheto-pricing__content-header ">

				<?php
				// Heading.
				if ( !empty($heading) ) {
					echo '<h5 class="aheto-pricing__box-title">' . wp_kses($heading, 'post') . '</h5>';
				}
				?>
				<?php
				// Heading.
				if ( !empty($karma_events_subtitle) ) {
					echo '<p class="aheto-pricing__box-subtitle">' . wp_kses($karma_events_subtitle, 'post') . '</p>';
				}
				?>
			</div>
			<div class="aheto-pricing__box-price">
				<?php
				// Price.
				if ( !empty($price) ) {
					echo esc_html($price);
				}
				?>
			</div>

			<?php
			$features = $this->parse_group($features);
			if ( !empty($features) ) {

				echo '<div class="aheto-pricing__list">';

				foreach ( $features as $key => $item ) {
					$classes = empty($item['feature']) ? 'is-empty' : '';
					echo '<p class="aheto-pricing__box-descr  ' . $classes . '" data-height-key="key-' . esc_attr($key) . '">';
					echo '[ok]' === $item['feature'] ? '<i class="ion-checkmark aheto-pricing__list-ico-ok"></i>' : wp_kses($item['feature'], 'post');
					echo '</p>';
				}

				echo '</div>';
			} ?>
			<?php // Button Link.
			if ( $karma_events_add_button ) { ?>
				<div class="aheto-pricing__links">
					<?php echo Helper::get_button($this, $atts, 'karma_events_'); ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
