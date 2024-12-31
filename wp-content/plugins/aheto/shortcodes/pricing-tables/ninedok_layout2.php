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

$ninedok_active = isset($ninedok_active) && ninedok_active ? 'active' : '';
$ninedok_dark_version = isset($ninedok_dark_version) && $ninedok_dark_version ? 'dark-version' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--ninedok-isotope');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', $ninedok_active);
$ninedok_box_shadow = isset($ninedok_box_shadow) && $ninedok_box_shadow ? 'box-shadow' : '';


/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('ninedok-pricing-tables-layout2', $shortcode_dir . 'assets/css/ninedok_layout2.css', null, null);
}

if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('ninedok-pricing-tables-layout2-js', $shortcode_dir . 'assets/js/ninedok_layout2.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-pricing__head">
		<ul class="aheto-pricing__list ">

			<?php

			$all_filters = array();

			foreach ($ninedok_pricings as $index => $item) :

				$item['ninedok_pricings_heading'] = !empty($item['ninedok_pricings_heading']) ? $item['ninedok_pricings_heading'] : '';

				$filter_heading = str_replace(' ', '_', $item['ninedok_pricings_heading']);
				$filter_heading = strtolower($filter_heading);

				if (!in_array($item['ninedok_pricings_heading'], $all_filters)) {

					$all_filters[] = $item['ninedok_pricings_heading'];

					$heading_tag = isset($item['heading_tag']) && !empty($item['heading_tag']) ? $item['heading_tag'] : 'h3';
					$active = $index > 0 ? '' : 'active'; ?>

					<li class="aheto-pricing__list-item <?php echo esc_attr($active); ?>">

						<a href="javascript:void(0);" data-pricing-filter="<?php echo esc_html($filter_heading); ?>"
						   class="aheto-pricing__list-link js-tab-list">
							<?php if (!empty($item['ninedok_pricings_heading'])) :

								echo esc_html($item['ninedok_pricings_heading']);

							endif; ?>
						</a>
					</li>
					<?php
				}
			endforeach; ?>

		</ul>
	</div>


	<div class="aheto-pricing__content">
		<?php foreach ($ninedok_pricings as $index => $item) :

			$title_tag = isset($item['ninedok_pricing_heading_tag']) && !empty($item['ninedok_pricing_heading_tag']) ? $item['ninedok_pricing_heading_tag'] : 'h4';
			$active = $index > 0 ? '' : 'active';

			$filter_heading = str_replace(' ', '_', $item['ninedok_pricings_heading']);
			$filter_heading = strtolower($filter_heading);

			$is_label = !empty($item['ninedok_pricings_label']) && isset($item['ninedok_pricings_label']) ? 'is-label' : '';
			?>

			<div
				class="aheto-pricing__box js-isotope-box <?php echo esc_attr($ninedok_box_shadow); ?>  <?php echo esc_attr($active); ?> <?php echo esc_attr($filter_heading); ?> <?php echo esc_attr($is_label); ?>">
				<div class="aheto-pricing__box-inner">
					<div class="aheto-pricing__box-header">
						<?php if (!empty($item['ninedok_pricings_title'])) : ?>
							<h5 class="aheto-pricing__box-title">
								<?php echo wp_kses($item['ninedok_pricings_title'], 'post'); ?>

								<span>
                                    <?php
									if (!empty($item['ninedok_pricings_label'])) {
										echo wp_kses($item['ninedok_pricings_label'], 'post');
									}
									?>
                                </span>

							</h5>
						<?php endif; ?>
						<?php if (!empty($item['ninedok_pricings_price'])): ?>
							<h5 class="aheto-pricing__box-price">
								<?php echo wp_kses($item['ninedok_pricings_price'], 'post'); ?>
							</h5>
						<?php endif; ?>
					</div>
					<div class="aheto-pricing__box-content">
						<?php if (!empty($item['ninedok_pricings_descr'])): ?>
							<p class="aheto-pricing__box-descr">
								<?php echo wp_kses($item['ninedok_pricings_descr'], 'post'); ?>
							</p>
						<?php endif; ?>

					</div>

				</div>
			</div>

		<?php endforeach; ?>

	</div>


</div>
