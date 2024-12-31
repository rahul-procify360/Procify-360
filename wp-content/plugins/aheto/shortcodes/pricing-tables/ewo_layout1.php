<?php

/**
 * The Pricing Tables Shortcode.
 */

use Aheto\Helper;

extract($atts);
$this->generate_css();

$ewo_use_bb_typo = isset($ewo_use_bb_typo) && $ewo_use_bb_typo ? 'bb' : '';
$ewo_active = isset($ewo_active) && $ewo_active ? 'active' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--ewo-isotope');
$this->add_render_attribute('wrapper', 'class', $ewo_active);
$this->add_render_attribute('wrapper', 'class', $ewo_use_bb_typo);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
  wp_enqueue_style( 'ewo-pricing-tables-layout1', $shortcode_dir . 'assets/css/ewo_layout1.css', null, null );
}

if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('ewo-pricing-tables-layout1-js', $shortcode_dir . 'assets/js/ewo_layout1.min.js', array('jquery'), null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <div class="aheto-pricing__head">
    <ul class="aheto-pricing__list ">
      <?php
      $all_filters = array();
      foreach ($ewo_pricings as $index => $item) :
        $item['ewo_pricings_heading'] = !empty($item['ewo_pricings_heading']) ? $item['ewo_pricings_heading'] : '';
        $filter_heading = str_replace(' ', '_', $item['ewo_pricings_heading']);
        $filter_heading = strtolower($filter_heading);
        if (!in_array($item['ewo_pricings_heading'], $all_filters)) {
          $all_filters[] = $item['ewo_pricings_heading'];
          $active = $index > 0 ? '' : 'active'; ?>
          <li class="aheto-pricing__list-item <?php echo esc_attr($active); ?>">
            <a href="javascript:void(0);" data-pricing-filter="<?php echo esc_html($filter_heading); ?>" class="aheto-pricing__list-link aheto-pricing--ewo-isotope__list js-tab-list">
              <?php if ($item['ewo_pricings_heading']) :
                echo esc_html($item['ewo_pricings_heading']);
              endif; ?>
            </a>
          </li>
      <?php
        }
      endforeach; ?>
    </ul>
  </div>


  <div class="aheto-pricing__content">
    <?php foreach ($ewo_pricings as $index => $item) :
      $title_tag = isset($item['ewo_pricing_heading_tag']) && !empty($item['ewo_pricing_heading_tag']) ? $item['ewo_pricing_heading_tag'] : 'h4';
      $active = $index > 0 ? '' : 'active';
      $filter_heading = str_replace(' ', '_', $item['ewo_pricings_heading']);
      $filter_heading = strtolower($filter_heading);
    ?>
      <div class="aheto-pricing__box js-isotope-box <?php echo esc_attr($active); ?> <?php echo esc_attr($filter_heading); ?>">
        <div class="aheto-pricing__box-inner">
          <div class="aheto-pricing__box-header">
            <?php if (!empty($item['ewo_pricings_title'])) : ?>
              <h5 class="aheto-pricing__box-title">
                <?php echo wp_kses_post($item['ewo_pricings_title']); ?>
              </h5>
            <?php endif; ?>
            <?php if (!empty($item['ewo_pricings_price'])) : ?>
              <h5 class="aheto-pricing__box-price">
                <?php echo wp_kses_post($item['ewo_pricings_price']); ?>
              </h5>
            <?php endif; ?>
          </div>
          <div class="aheto-pricing__box-content">
            <?php if (!empty($item['ewo_pricings_descr'])) : ?>
              <p class="aheto-pricing__box-descr">
                <?php echo wp_kses_post($item['ewo_pricings_descr']); ?>
              </p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
