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
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--rela-modern');
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
    wp_enqueue_style('rela-pricing-tables-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto-pricing__header">

        <?php
        // Heading.
        if (!empty($rela_heading)) {
            echo '<h5 class="aheto-pricing__title">' . wp_kses($rela_heading, 'post') . '</h5>';
        }
        ?>

        <div class="aheto-pricing__cost">
            <?php
            // Price.
            if (!empty($price)) {
                echo '<div class="aheto-pricing__cost-value">' . esc_html($price) . '</div>';
            }

            if (!empty($description)) {
                echo '<p class="aheto-pricing__cost-time">' . wp_kses($description, 'post') . '</p>';
            }
            ?>
        </div>

    </div>

    <div class="aheto-pricing__content">

        <?php
        $rela_features = $this->parse_group($rela_features);
        if ($rela_features) { ?>

            <div class="aheto-pricing__list">

                <?php foreach ($rela_features as $item) { ?>

                    <div class="aheto-pricing__list-item <?php echo esc_html($item['rela_mark']); ?>">
                        <?php echo wp_kses($item['rela_feature'], 'post'); ?>
                    </div>
                    <?php if (!empty($item['rela_resp_descr'])) {
                        echo '<p class="aheto-pricing__resp-descr">' . esc_html($item['rela_resp_descr']) . '</p>';
                    } ?>

                <?php } ?>

            </div>
        <?php }

        // Button Link.
        if ($rela_add_button) { ?>
            <div class="aheto-pricing__link">
                <?php echo \Aheto\Helper::get_button($this, $atts, 'rela_'); ?>
            </div>
        <?php }
        ?>

    </div>

</div>
