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

extract( $atts );


$this->generate_css();

$aira_active = isset($aira_active) ? 'active' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing--aira-isotope' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', $aira_active );

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-pricing-tables-isotope', $sc_dir . 'assets/css/aira_layout2.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('aira-pricing-tables-isotope-js', $sc_dir . 'assets/js/aira_layout2.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="aheto-pricing__head">
        <?php
        $background_image = \Aheto\Helper::get_background_attachment($aira_head_back_image, $aira_image_size, $atts, 'aira_');
        ?>
        <ul class="aheto-pricing__list" <?php echo esc_attr($background_image); ?>>

            <?php

            $all_filters = array();

            foreach ($aira_pricings as $index => $item) :

                $item['aira_pricings_heading'] = !empty($item['aira_pricings_heading']) ? $item['aira_pricings_heading'] : '';

                $filter_heading = str_replace(' ', '_', $item['aira_pricings_heading']);
                $filter_heading = strtolower($filter_heading);

                if (!in_array($item['aira_pricings_heading'], $all_filters)) {

                    $all_filters[] = $item['aira_pricings_heading'];

                    $heading_tag = isset($item['heading_tag']) && !empty($item['heading_tag']) ? $item['heading_tag'] : 'h1';
                    $active = $index > 0 ? '' : 'active'; ?>

                    <li class="aheto-pricing__list-item <?php echo esc_attr($active); ?>">

                        <a href="#" data-pricing-filter="<?php echo esc_html($filter_heading); ?>"
                           class="aheto-pricing__list-link js-tab-list">
                            <?php if (!empty($item['aira_pricings_heading'])) :

                                echo esc_html($item['aira_pricings_heading']);

                            endif; ?>
                        </a>
                    </li>
                    <?php
                }
            endforeach; ?>

        </ul>
    </div>


    <div class="aheto-pricing__content">
        <?php foreach ($aira_pricings as $index => $item) :

            $filter_heading = str_replace(' ', '_', $item['aira_pricings_heading']);
            $filter_heading = strtolower($filter_heading);

            $is_label = !empty($item['aira_pricings_label']) && isset($item['aira_pricings_label']) ? 'is-label' : '';
            ?>

            <div class="aheto-pricing__box js-isotope-box <?php echo esc_attr($filter_heading); ?> <?php echo esc_attr($is_label); ?>">
                <div class="aheto-pricing__box-inner">
                    <div class="aheto-pricing__box-header">
                        <?php if (!empty($item['aira_pricings_title'])) : ?>
                            <h5 class="aheto-pricing__box-title">
                                <?php echo wp_kses($item['aira_pricings_title'], 'post'); ?>

                                <span>
                                    <?php
                                    if (!empty($item['aira_pricings_label'])) {
                                        echo wp_kses($item['aira_pricings_label'], 'post');
                                    }
                                    ?>
                                </span>

                            </h5>
                        <?php endif; ?>
                        <?php if (!empty($item['aira_pricings_price'])): ?>
                            <h5 class="aheto-pricing__box-price">
                                <?php echo wp_kses($item['aira_pricings_price'], 'post'); ?>
                            </h5>
                        <?php endif; ?>
                    </div>
                    <div class="aheto-pricing__box-content">
                        <?php if (!empty($item['aira_pricings_descr'])): ?>
                            <p class="aheto-pricing__box-descr">
                                <?php echo wp_kses($item['aira_pricings_descr'], 'post'); ?>
                            </p>
                        <?php endif; ?>

                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    </div>


</div>
