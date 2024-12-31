<?php

/**
 * The Pricing Tables Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--karma-marketing-isotope');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('karma-marketing-pricing-tables-layout1', $shortcode_dir . 'assets/css/karma_marketing_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('karma-marketing-pricing-tables-layout1-js', $shortcode_dir . 'assets/js/karma_marketing_layout1.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-pricing__head">
		<?php if ( !empty($karma_marketing_title) ): ?>
			<h2 class="aheto-pricing__main-title"><?php echo esc_html($karma_marketing_title); ?></h2>
		<?php endif; ?>
		<ul class="aheto-pricing__list ">
			<?php

			$all_filters = array();
			$num = 0;

			foreach ( $karma_marketing_pricings as $index => $item ) :
				$num ++;
				$item['karma_marketing_pricings_heading'] = !empty($item['karma_marketing_pricings_heading']) ? $item['karma_marketing_pricings_heading'] : '';
				$filter_heading = str_replace(' ', '_', $item['karma_marketing_pricings_heading']);
				$filter_heading = strtolower($filter_heading);
				if ( !in_array($item['karma_marketing_pricings_heading'], $all_filters) ) {

					$all_filters[] = $item['karma_marketing_pricings_heading'];
					$heading_tag   = isset($item['heading_tag']) && !empty($item['heading_tag']) ? $item['heading_tag'] : 'h1';
					$active        = $index > 0 ? '' : 'active'; ?>
					<?php $active_first = $num == 1 ?  'active' : ''?>

					<li class="aheto-pricing__list-item <?php echo esc_attr($active_first);?>">
						<a href="#" data-pricing-filter=".<?php echo esc_html($filter_heading); ?>"
						   class="aheto-pricing__list-link js-tab-list <?php echo esc_attr($active_first);?>">
							<?php if ( $item['karma_marketing_pricings_heading'] ) :

								echo esc_html($item['karma_marketing_pricings_heading']);

							endif; ?>
						</a>
					</li>
					<?php
				}
			endforeach; ?>
		</ul>
		<?php if ( !empty($karma_marketing_desc_main) ): ?>
			<p class="aheto-pricing__main-desc"><?php echo esc_html($karma_marketing_desc_main); ?></p>
		<?php endif; ?>
		<?php if ( !empty($karma_marketing_link_title) && !empty($karma_marketing_link_url)): ?>
			<a href="<?php echo esc_url($karma_marketing_link_url);?>" class="aheto-pricing__main-link"><?php echo esc_html($karma_marketing_link_title); ?></a>
		<?php endif; ?>
	</div>

	<div class="aheto-pricing__content">
		<?php foreach ( $karma_marketing_pricings as $index => $item ) :
			$filter_heading = str_replace(' ', '_', $item['karma_marketing_pricings_heading']);
			$filter_heading = strtolower($filter_heading);
			$active_item = $item['karma_marketing_active'] == true ? 'aheto-pricing__box-active' : '';
        ?>

			<div class="aheto-pricing__box js-isotope-box <?php echo esc_attr($filter_heading) . ' '. esc_attr($active_item); ?> ">
				<div class="aheto-pricing__box-inner">
					<div class="aheto-pricing__box-header">
						<?php if ( !empty($item['karma_marketing_pricings_title']) ) : ?>
							<div class="aheto-pricing__box-title-wrap">
								<h5 class="aheto-pricing__box-title">
									<?php echo wp_kses($item['karma_marketing_pricings_title'], 'post'); ?>
								</h5>
							</div>
						<?php endif; ?>
						<?php if ( !empty($item['karma_marketing_pricings_price']) ): ?>
							<h5 class="aheto-pricing__box-price">
								<?php echo wp_kses($item['karma_marketing_pricings_price'], 'post'); ?>
							</h5>
						<?php endif; ?>
					</div>
					<div class="aheto-pricing__box-content">
						<?php if ( !empty($item['karma_marketing_pricings_descr']) ): ?>
							<div class="aheto-pricing__box-descr">
								<?php echo wp_kses($item['karma_marketing_pricings_descr'], 'post'); ?>
							</div>
						<?php endif; ?>
						<?php if ( $item['karma_marketing_pricing_layout1_add_button'] == true ) { ?>
						<div class="aheto-pricing__box-btn">
							<?php echo Helper::get_button($this, $item, 'karma_marketing_pricing_layout1_');?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
