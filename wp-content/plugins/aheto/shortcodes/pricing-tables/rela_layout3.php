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

//Active
$rela_active = $rela_active ? 'aheto-pricing__active' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--rela-minimal');
$this->add_render_attribute('wrapper', 'class', $rela_active);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


// Button Link.
$link = $this->get_button_attributes('link');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('rela-pricing-tables-layout3', $shortcode_dir . 'assets/css/rela_layout3.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <?php foreach ($rela_min_price as $item) { ?>
        <div class="aheto-pricing__item">
            <div class="aheto-pricing__main">
                <?php
                if (!empty($item['rela_time'])) {
                    echo '<h5 class="aheto-pricing__time">' . wp_kses($item['rela_time'], 'post') . '</h5>';
                }
                if (!empty($item['rela_special'])) {
                    echo '<p class="aheto-pricing__special">' . wp_kses($item['rela_special'], 'post') . '</p>';
                }
                ?>
            </div>
            <div class="aheto-pricing__cost">
                <?php
                if (!empty($item['rela_price'])) {
                    echo '<h5 class="aheto-pricing__cost-value">' . esc_html($item['rela_price']) . '</h5>';
                }
                ?>
            </div>
        </div>
    <?php } ?>
</div>
