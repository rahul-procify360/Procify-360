<?php
/**
 * The Pricing Tables Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$pricing_items = $this->parse_group( $snapster_simple_list );

if ( empty( $pricing_items ) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing-tables--snapster' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing-tables--snapster-simple_list' );

$random = substr( md5( rand() ), 0, 7 );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'snapster-pricing-tables-layout7', $shortcode_dir . 'assets/css/snapster_layout7.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('snapster-pricing-tables-layout7-js', $shortcode_dir . 'assets/js/snapster_layout7.min.js', array('jquery'), null);
}

if ( ! function_exists( 'snapster_pricing_tables_total' ) ) {
	add_action( 'wp_body_open', 'snapster_pricing_tables_total' );
	function snapster_pricing_tables_total() { ?>
		<h5 class="aheto-pricing-tables__pricelist-total" style="display: none;"><?php esc_html_e( 'Total: ', 'snapster' ); ?>
			<span class="aheto-pricing-tables__currency"></span>
			<span class="aheto-pricing-tables__price"></span>
		</h5>
		<?php
	}
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-pricing-tables__top-wrap">

        <div class="aheto-pricing-tables__cell-1"><?php esc_html_e( 'NAME', 'snapster' ); ?></div>
        <div class="aheto-pricing-tables__cell-2"><?php esc_html_e( 'PRICE', 'snapster' ); ?></div>
        <div class="aheto-pricing-tables__cell-3"><?php esc_html_e( 'ADD', 'snapster' ); ?></div>

    </div>
    <div class="aheto-pricing-tables__top-wrap">

        <div class="aheto-pricing-tables__cell-1"><?php esc_html_e( 'NAME', 'snapster' ); ?></div>
        <div class="aheto-pricing-tables__cell-2"><?php esc_html_e( 'PRICE', 'snapster' ); ?></div>
        <div class="aheto-pricing-tables__cell-3"><?php esc_html_e( 'ADD', 'snapster' ); ?></div>

    </div>

    <div class="aheto-pricing-tables__table-price-wrap">

		<?php foreach ( $pricing_items as $item ) { ?>

            <div class="aheto-pricing-tables__wrap">

				<?php if ( ! empty( $item['snapster_title'] ) ) { ?>
                    <div class="aheto-pricing-tables__cell-1">
                        <div class="aheto-pricing-tables__title">
							<?php echo esc_html( $item['snapster_title'] ); ?>
                        </div>
                    </div>
				<?php }

				if ( ! empty( $item['snapster_price'] ) ) { ?>

                    <div class="aheto-pricing-tables__price-wrap">
                        <div class="aheto-pricing-tables__price aheto-pricing-tables__cell-2">
							<?php if ( ! empty( $item['snapster_currency'] ) ) { ?>
                                <span class="aheto-pricing-tables__currency"><?php echo esc_html( $item['snapster_currency'] ); ?></span>
							<?php }
							echo esc_html( $item['snapster_price'] ); ?>
                        </div>
                        <div class="aheto-pricing-tables__input-check-wrap aheto-pricing-tables__cell-3">
                            <input type="radio"
                                   name="<?php echo esc_attr( $random ); ?>simple_list"
                                   value="<?php echo esc_attr( $item['snapster_price'] ); ?>"
                                   class="aheto-pricing-tables__pricelist-value"
                                   data-price-title="<?php echo esc_attr( $item['snapster_title'] ); ?>"
                                   data-price-value="<?php echo esc_attr( $item['snapster_currency'] . $item['snapster_price'] ); ?>">
                            <span></span>
                        </div>
                    </div>

				<?php } ?>

            </div>
		<?php } ?>
    </div>
</div>
