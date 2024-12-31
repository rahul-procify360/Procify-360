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
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--famulus-simple');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
if ( $famulus_active == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--famulus-active');
}
if ( isset($famulus_hover) && $famulus_hover == true  ) {
	$this->add_render_attribute('wrapper', 'class', 'remove-hover');
}
// Button Link.
$link = $this->get_button_attributes('link');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-pricing-tables-layout1', $shortcode_dir . 'assets/css/famulus_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-pricing aheto-pricing--tableColumn js-pricing-height">
		<div class="aheto-pricing__header js-pricing-items" data-height-key="header">

			<?php
			// Heading.
			if ( !empty($heading) ) {
				$heading = str_replace(']]', '</span>', $heading);
				$heading = str_replace('[[', '<span>', $heading);
				echo '<h5 class="aheto-pricing__title">' . wp_kses_post($heading) . '</h5>';
			}
			?>

			<div class="aheto-pricing__cost">
				<?php
				// Price.
				if ( !empty($price) ) {
					echo esc_html($price);
				}
				?>
			</div>

		</div>

		<div class="aheto-pricing__content">
			<?php if ( !empty($famulus_subtitle) ) { ?>
				<div class="aheto-pricing__subtitle"><?php echo esc_html($famulus_subtitle); ?></div>
			<?php } ?>
			<?php
			$features = $this->parse_group($features);
			if ( !empty($features) ) {

				echo '<div class="aheto-pricing__list">';

				foreach ( $features as $key => $item ) {
					$classes = empty($item['feature']) ? 'is-empty' : '';
//					js-pricing-items ------ class ↓
					echo '<div class="aheto-pricing__list-item  ' . $classes . '" data-height-key="key-' . esc_attr($key) . '">';
					echo '<p>';
					echo '[ok]' === $item['feature'] ? '<i class="ion-checkmark aheto-pricing__list-ico-ok"></i>' : wp_kses_post($item['feature']);
					echo '</p>';
					echo '</div>';
				}

				echo '</div>';
			}

			// Button Link.
			if ( isset($link['href']) && !empty($link['title']) ) {
				$this->add_render_attribute('button', $link);
				$this->add_render_attribute('button', 'class', 'aheto-btn aheto-pricing__btn aheto-btn--small');
				printf(
					'<a %s>%s</a>',
					$this->get_render_attribute_string('button'),
					esc_html($link['title'])
				);
			}
			?>

		</div>
	</div>

</div>
