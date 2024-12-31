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
if(empty($rela_pricings)){
   return '';
}

$this->generate_css();

$rela_active = isset($rela_active) && $rela_active ? 'active' : '';
$rela_remove_icons = isset($rela_remove_icons) && $rela_remove_icons ? ' remove-icon' : '';
$rela_list_title_bg = isset($rela_list_title_bg) && $rela_list_title_bg ? ' bg-active' : '';
$rela_list_title_bg_wrap = isset($rela_list_title_bg) && $rela_list_title_bg ? ' bg-active-wrap' : '';
$rela_remove_box_shadow = isset($rela_remove_box_shadow) && $rela_remove_box_shadow ? ' remove-shadow' : '';
$rela_add_border = isset($rela_add_border) && $rela_add_border ? ' item-border' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--rela-isotope');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', $rela_active);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('rela-pricing-tables-layout5', $shortcode_dir . 'assets/css/rela_layout5.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('rela-pricing-tables-layout5-js', $shortcode_dir . 'assets/js/rela_layout5.js', array('jquery'), null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="aheto-pricing__head">
        <ul class="aheto-pricing__list <?php echo esc_attr($rela_list_title_bg_wrap); ?>">

            <?php

            $all_filters = array();

            foreach ($rela_pricings as $index => $item) :

                $item['rela_pricings_heading'] = !empty($item['rela_pricings_heading']) ? $item['rela_pricings_heading'] : '';

                $filter_heading = str_replace(' ', '_', $item['rela_pricings_heading']);
                $filter_heading = strtolower($filter_heading);

                if (!in_array($item['rela_pricings_heading'], $all_filters)) {

                    $all_filters[] = $item['rela_pricings_heading'];

                    $heading_tag = isset($item['heading_tag']) && !empty($item['heading_tag']) ? $item['heading_tag'] : 'h1';
                    $active = $index > 0 ? '' : 'active'; ?>

                    <li class="aheto-pricing__list-item <?php echo esc_attr($active . $rela_remove_icons . $rela_list_title_bg); ?>">

                        <a href="#" data-pricing-filter="<?php echo esc_html($filter_heading); ?>"
                           class="aheto-pricing__list-link aheto-pricing--rela-isotope__list js-tab-list">
                            <?php if (!empty($item['rela_pricings_heading'])) :

                                echo esc_html($item['rela_pricings_heading']);

                            endif; ?>
                        </a>
                    </li>
                    <?php
                }
            endforeach; ?>

        </ul>
    </div>


    <div class="aheto-pricing__content">
        <?php foreach ($rela_pricings as $index => $item) :

            $filter_heading = str_replace(' ', '_', $item['rela_pricings_heading']);
            $filter_heading = strtolower($filter_heading);

            $is_label = !empty($item['rela_pricings_label']) && isset($item['rela_pricings_label']) ? 'is-label' : '';
            ?>

            <div class="aheto-pricing__box js-isotope-box <?php echo esc_attr($filter_heading); ?> <?php echo esc_attr($is_label . $rela_remove_box_shadow . $rela_add_border); ?>">
                <div class="aheto-pricing__box-inner">
                    <div class="aheto-pricing__box-header">
                        <?php if (!empty($item['rela_pricings_title'])) : ?>
                            <h5 class="aheto-pricing__box-title">
                                <?php echo wp_kses($item['rela_pricings_title'], 'post'); ?>

                                <span>
                                    <?php
                                    if (!empty($item['rela_pricings_label'])) {
                                        echo wp_kses($item['rela_pricings_label'], 'post');
                                    }
                                    ?>
                                </span>

                            </h5>
                        <?php endif; ?>
                        <?php if (!empty($item['rela_pricings_price'])): ?>
                            <h5 class="aheto-pricing__box-price">
                                <?php echo wp_kses($item['rela_pricings_price'], 'post'); ?>
                            </h5>
                        <?php endif; ?>
                    </div>
                    <div class="aheto-pricing__box-content">
                        <?php if (!empty($item['rela_pricings_descr'])): ?>
                            <p class="aheto-pricing__box-descr">
                                <?php echo wp_kses($item['rela_pricings_descr'], 'post'); ?>
                            </p>
                        <?php endif; ?>

                    </div>
	                <?php if ( isset($item['rela_pricing_add_button']) && $item['rela_pricing_add_button'] ) { ?>
                        <div class="aheto-pricing__button">
			                <?php echo Aheto\Helper::get_button($this, $item, 'rela_pricing_'); ?>
                        </div>
	                <?php } ?>

                </div>
            </div>

        <?php endforeach; ?>

    </div>


</div>
