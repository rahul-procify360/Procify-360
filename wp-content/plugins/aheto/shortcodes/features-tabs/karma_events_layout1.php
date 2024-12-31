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
$this->add_render_attribute('wrapper', 'class', 'aheto-tabs--karma_events-isotope');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', $karma_events_active);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-tabs/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_events-features-tabs-layout1', $shortcode_dir . 'assets/css/karma_events_layout1.css', null, null);
}

if (  !Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('karma_events-features-tabs-layout1-js', $shortcode_dir . 'assets/js/karma_events_layout1.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-tabs__head">
		<ul class="aheto-tabs__list ">
			<?php
			$all_filters        = array();
			$num                = 0;
			foreach ( $karma_events_pricings as $index => $item ) :
				$item['karma_events_pricings_heading'] = !empty($item['karma_events_pricings_heading']) ? $item['karma_events_pricings_heading'] : '';
				$filter_heading = str_replace(' ', '_', $item['karma_events_pricings_heading']);
				$filter_heading = strtolower($filter_heading);
				if ( !in_array($item['karma_events_pricings_heading'], $all_filters) ) {
					$num++;
					$all_filters[] = $item['karma_events_pricings_heading'];
					$heading_tag   = isset($item['heading_tag']) && !empty($item['heading_tag']) ? $item['heading_tag'] : 'h1';
					$active        = $index > 0 ? '' : 'active'; ?>

					<li class="aheto-tabs__list-item <?php echo esc_attr($active); ?>">
						<?php if ( !empty($filter_heading) && !empty($item['karma_events_pricings_heading']) ): ?>
							<a href="#" data-pricing-filter=".<?php echo esc_html($filter_heading); ?>"
							   class="aheto-tabs__list-link js-tab-list">
								<span><?php echo esc_html_e('Day ', 'soapy') . ' 0' . $num; ?></span>
								<?php echo esc_html($item['karma_events_pricings_heading']); ?>
							</a>
						<?php endif; ?>
					</li>
					<?php
				}
			endforeach; ?>
		</ul>
	</div>
	<?php if ( !empty($karma_events_main_title) ): ?>
		<h4 class="aheto-tabs__box-main-title"><?php echo esc_html($karma_events_main_title); ?></h4>
	<?php endif; ?>
	<div class="aheto-tabs__box-top">
		<p class="aheto-tabs__box-num">
			#
		</p>
		<p class="aheto-tabs__box-title">
			session
		</p>
		<p class="aheto-tabs__box-label">
			speaker(s)
		</p>
		<p class="aheto-tabs__box-price">
			time
		</p>
		<p class="aheto-tabs__box-descr">
			venue
		</p>
	</div>
	<div class="aheto-tabs__content">

		<?php
		$all_filters = array();
		$num         = 1;
		$num1        = 0;
		foreach ( $karma_events_pricings as $index => $item ) :
			if ( !in_array($item['karma_events_pricings_heading'], $all_filters) ) {
				$num           = 1;
				$all_filters[] = $item['karma_events_pricings_heading'];

			} else {
				$num++;
			}
			$num1++;
			if ( $num1 % 2 != 0 ) {
				$class_item = 'aheto-tabs__box-bg';
			} else {
				$class_item = '';
			}
			$filter_heading = str_replace(' ', '_', $item['karma_events_pricings_heading']);
			$filter_heading = strtolower($filter_heading);
			$is_label       = !empty($item['karma_events_pricings_label']) && isset($item['karma_events_pricings_label']) ? 'is-label' : '';
			?>

			<div class="aheto-tabs__box js-isotope-box <?php echo esc_attr($class_item); ?> <?php echo esc_attr($filter_heading); ?> <?php echo esc_attr($is_label); ?>">
				<div class="aheto-tabs__box-inner">
					<p class="aheto-tabs__box-num">
						<?php echo esc_html($num); ?>
					</p>
					<h5 class="aheto-tabs__box-title">
						<?php if ( !empty($item['karma_events_pricings_title']) ) : ?>
							<?php echo wp_kses($item['karma_events_pricings_title'], 'post'); ?>
						<?php endif; ?>
					</h5>
					<p class="aheto-tabs__box-label">
						<?php
						if ( !empty($item['karma_events_pricings_label']) ) {
							echo wp_kses($item['karma_events_pricings_label'], 'post');
						} ?>
					</p>
					<p class="aheto-tabs__box-price">
						<?php if ( !empty($item['karma_events_pricings_price']) ): ?>
							<?php echo wp_kses($item['karma_events_pricings_price'], 'post'); ?>
						<?php endif; ?>
					</p>
					<p class="aheto-tabs__box-descr">
						<?php if ( !empty($item['karma_events_pricings_descr']) ): ?>
							<?php echo wp_kses($item['karma_events_pricings_descr'], 'post'); ?>
						<?php endif; ?>
					</p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
