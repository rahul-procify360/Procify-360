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

$noize_active = isset($noize_active) && $noize_active ? 'active' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing-tables--noize-lay1' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', $noize_active );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'noize-pricing-tables-layout1', $shortcode_dir . 'assets/css/noize_layout1.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script( 'noize-pricing-tables-layout1-js', $shortcode_dir . 'assets/js/noize_layout1.js', array( 'jquery' ), null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-pricing-tables--noize-lay1__head">
        <ul class="aheto-pricing-tables--noize-lay1__list ">

            <li class="aheto-pricing-tables--noize-lay1__list-item active">
                <a href="#" data-pricing-filter="*" class="aheto-pricing-tables--noize-lay1__list-link aheto-pricing-tables--noize-lay1-item--category js-tab-list">
                    <?php esc_html_e('All', 'noize'); ?>
                </a>
            </li>

            <?php
                $all_filters = array();

                foreach ( $noize_pricings as $index => $item ) :

                    $item['noize_pricings_heading'] = !empty($item['noize_pricings_heading']) ? $item['noize_pricings_heading'] : '';

                    $filter_heading = str_replace( ' ', '_', $item['noize_pricings_heading'] );
                    $filter_heading = strtolower($filter_heading);

                    if (!in_array($item['noize_pricings_heading'], $all_filters)) {

                        $all_filters[] = $item['noize_pricings_heading'];

                        $heading_tag = isset( $item['heading_tag'] ) && ! empty( $item['heading_tag'] ) ? $item['heading_tag'] : 'h1';
                        $active = $index > 0 ? '' : 'active';
                    ?>
                        <li class="aheto-pricing-tables--noize-lay1__list-item ">
                            <a href="#" data-pricing-filter=".<?php echo esc_html( $filter_heading ); ?>" class="aheto-pricing-tables--noize-lay1__list-link aheto-pricing-tables--noize-lay1-item--category js-tab-list">
                                <?php if ( !empty( $item['noize_pricings_heading'] ) ) :

                                    echo esc_html( $item['noize_pricings_heading'] );

                                endif; ?>
                            </a>
                        </li>
                        <?php
                    }
                endforeach;
            ?>

        </ul>
    </div>

    <div class="aheto-pricing-tables--noize-lay1__content">
        <?php foreach ( $noize_pricings as $index => $item ) :

            $title_tag = isset( $item['noize_pricing_heading_tag'] ) && ! empty( $item['noize_pricing_heading_tag'] ) ? $item['noize_pricing_heading_tag'] : 'h4';
            $active = $index > 0 ? '' : 'active';

            $filter_heading = str_replace( ' ', '_', $item['noize_pricings_heading'] );
            $filter_heading = strtolower($filter_heading);

        ?>
            <div class="aheto-pricing-tables--noize-lay1__box js-isotope-box <?php echo esc_attr( $active ); ?> <?php echo esc_attr( $filter_heading ); ?>">
                <div class="aheto-pricing-tables--noize-lay1__box-inner">
                    <div class="aheto-pricing-tables--noize-lay1__box-header">
                        <?php if ( !empty($item['noize_pricings_title'] ) ) : ?>
                            <h5 class="aheto-pricing-tables--noize-lay1__box-title">
                                <?php echo wp_kses_post( $item['noize_pricings_title'] ); ?>
                            </h5>
                        <?php endif; ?>
                        <?php if ( !empty($item['noize_pricings_price'] ) ): ?>
                            <h5 class="aheto-pricing-tables--noize-lay1__box-price">
                                <?php echo wp_kses_post( $item['noize_pricings_price'] ); ?>
                            </h5>
                        <?php endif; ?>
                    </div>
                    <?php if ( !empty($item['noize_pricings_descr'] ) ): ?>
                        <div class="aheto-pricing-tables--noize-lay1__box-content">
                            <p class="aheto-pricing-tables--noize-lay1__box-descr">
                                <?php echo wp_kses_post( $item['noize_pricings_descr'] ); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
