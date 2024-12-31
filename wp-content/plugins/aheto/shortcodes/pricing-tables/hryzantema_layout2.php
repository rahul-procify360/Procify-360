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

$hryzantema_active = isset($hryzantema_active) && $hryzantema_active ? 'active' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', ' aheto-pricing--hr-isotope');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', $hryzantema_active);


$hryzantema_heading = str_replace(']]', '</span>', $hryzantema_heading);
$hryzantema_heading = str_replace('[[', '<span>', $hryzantema_heading);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-pricing-tables-layout2', $shortcode_dir . 'assets/css/hryzantema_layout2.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('hryzantema-pricing-tables-layout2-js', $shortcode_dir . 'assets/js/hryzantema_layout2.js', array('jquery'), null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-pricing__head">
		<ul class="aheto-pricing__list ">

			<?php

			$all_filters = array();

			foreach ( $hryzantema_pricings as $index => $item ) :

				$item['hryzantema_pricings_heading'] = !empty($item['hryzantema_pricings_heading']) ? $item['hryzantema_pricings_heading'] : '';

				$filter_heading = str_replace(' ', '_', $item['hryzantema_pricings_heading']);
				$filter_heading = strtolower($filter_heading);

				if ( !in_array($item['hryzantema_pricings_heading'], $all_filters) ) {

					$all_filters[] = $item['hryzantema_pricings_heading'];

					$heading_tag = isset($item['heading_tag']) && !empty($item['heading_tag']) ? $item['heading_tag'] : 'h1';
					$active      = $index > 0 ? '' : 'active'; ?>
					<?php if ( !empty($item['hryzantema_pricings_heading']) ) : ?>

						<li class="aheto-pricing__list-item <?php echo esc_attr($active); ?>">

							<a href="#" data-pricing-filter="<?php echo esc_html($filter_heading); ?>"
							   class="aheto-pricing__list-link js-tab-list">

								<?php echo esc_html($item['hryzantema_pricings_heading']); ?>

							</a>
						</li>
					<?php endif; ?>

					<?php
				}
			endforeach; ?>

		</ul>
	</div>

	<div class="aheto-pricing__content">
		<?php foreach ($hryzantema_pricings

		as $index => $item) :

		$title_tag = isset($item['hryzantema_pricing_heading_tag']) && !empty($item['hryzantema_pricing_heading_tag']) ? $item['hryzantema_pricing_heading_tag'] : 'h4';
		$active    = $index > 0 ? '' : 'active';

		$filter_heading = str_replace(' ', '_', $item['hryzantema_pricings_heading']);
		$filter_heading = strtolower($filter_heading);

		$is_label = !empty($item['hryzantema_pricings_label']) && isset($item['hryzantema_pricings_label']) ? 'is-label' : '';
		?>

		<div class="aheto-pricing__box js-isotope-box <?php echo esc_attr($active); ?> <?php echo esc_attr($filter_heading); ?> <?php echo esc_attr($is_label); ?>">
			<div class="aheto-pricing__box-inner">
				<div class="aheto-pricing__box-header">
					<?php if (!empty($item['hryzantema_pricings_title'])) : ?>
					<<?php echo esc_attr($item['hryzantema_pricing_heading_tag']); ?> class="aheto-pricing__box-title">
					<?php echo wp_kses_post($item['hryzantema_pricings_title']); ?>
					<?php if ( !empty($item['hryzantema_pricings_label']) ) { ?>
						<span>
                                            <?php echo wp_kses_post($item['hryzantema_pricings_label']); ?>
                                </span>
					<?php } ?>

				</<?php echo esc_attr($item['hryzantema_pricing_heading_tag']); ?>>
				<?php endif; ?>
				<?php if ( !empty($item['hryzantema_pricings_price']) ): ?>
					<h5 class="aheto-pricing__box-price">
						<?php echo wp_kses_post($item['hryzantema_pricings_price']); ?>
					</h5>
				<?php endif; ?>
			</div>
			<div class="aheto-pricing__box-content">
				<?php if ( !empty($item['hryzantema_pricings_descr']) ): ?>
					<p class="aheto-pricing__box-descr">
						<?php echo wp_kses_post($item['hryzantema_pricings_descr']); ?>
					</p>
				<?php endif; ?>

			</div>

		</div>
	</div>

	<?php endforeach; ?>

</div>
</div>
