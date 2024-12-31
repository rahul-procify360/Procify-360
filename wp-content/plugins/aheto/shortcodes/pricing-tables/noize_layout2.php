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

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing-tables--noize-lay2' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'noize-pricing-tables-layout2', $shortcode_dir . 'assets/css/noize_layout2.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('noize-pricing-tables-layout2-js', $shortcode_dir . 'assets/js/noize_layout2.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-pricing-tables--noize-lay2-items">

        <?php
            $counter = 1;

            foreach ($noize_load_items as $index => $item) {
                $hide_item = $counter < 4 ? '' : 'hide-item';?>

                <div class="aheto-pricing-tables--noize-lay2-item <?php echo esc_attr($hide_item); ?>">

                    <?php if ( !empty( $item['noize_load_image'] ) ) :?>
                        <div class="aheto-pricing-tables--noize-lay2__img "><?php echo Helper::get_attachment( $item['noize_load_image'] ); ?></div>
                    <?php endif; ?>

                    <?php if ( !empty($item['noize_load_price'] ) ): ?>
                        <h5 class="aheto-pricing-tables--noize-lay2__price">
                            <?php echo wp_kses_post( $item['noize_load_price'] ); ?>
                        </h5>
                    <?php endif; ?>

                </div>
            <?php
                $counter++;

            } ?>

    </div>

    <?php if ( $noize_add_button ) { ?>
        <div class="aheto-pricing-tables--noize-lay2__button">
            <?php echo \Aheto\Helper::get_button($this, $atts, 'noize_'); ?>
        </div>
    <?php } ?>

</div>

