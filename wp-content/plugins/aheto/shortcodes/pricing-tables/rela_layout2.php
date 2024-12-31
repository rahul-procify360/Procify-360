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
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--rela-short');
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
    wp_enqueue_style('rela-pricing-tables-layout2', $shortcode_dir . 'assets/css/rela_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto-pricing__header">
        <?php
        if (!empty($rela_heading)) {
            echo '<h2 class="aheto-pricing__title">' . wp_kses($rela_heading, 'post') . '</h2>';
        }
        ?>
        <div class="aheto-pricing__cost">
            <?php
            if (!empty($description)) {
                echo '<h4 class="aheto-pricing__description">' . wp_kses($description, 'post') . '</h4>';
            }
            if (!empty($price)) {
                echo '<h5 class="aheto-pricing__cost-value">' . esc_html($price) . '</h5>';
            }
            ?>
        </div>
    </div>
</div>
