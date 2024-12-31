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
$pointe_active = $pointe_active ? 'aheto-pricing__active' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing aheto-pricing--pointe-side');
$this->add_render_attribute('wrapper', 'class', $pointe_active);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Button Link.
$link = $this->get_button_attributes('link');

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('pointe-pricing-tables-side', $sc_dir . 'assets/css/pointe_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto-pricing__header">

        <?php
        // Heading.
        if (!empty($pointe_heading)) {
            echo '<h6 class="aheto-pricing__title">' . wp_kses($pointe_heading, 'post') . '</h6>';
        }
        ?>

        <div class="aheto-pricing__cost">
            <?php
            // Price.
            if (!empty($price)) {
                echo '<h3 class="aheto-pricing__cost-value">' . esc_html($price) . '</h3>';
            }

            if (!empty($description)) {
                echo '<h5 class="aheto-pricing__cost-time">' . '/' . wp_kses($description, 'post') . '</h5>';
            }
            ?>
        </div>
    </div>


    <div class="aheto-pricing__content">

        <?php
        $pointe_features = $this->parse_group($pointe_features);
        if ($pointe_features) { ?>

            <div class="aheto-pricing__list">

                <?php foreach ($pointe_features as $item) { ?>
                    <div class="aheto-pricing__list-item-wrap">
                        <div class="aheto-pricing__list-item <?php echo esc_html($item['pointe_mark']); ?>">
                            <?php
                            if (!empty($item['pointe_feature'])) {
                                echo wp_kses($item['pointe_feature'], 'post');
                            }
                            ?>
                            <?php
                            if (!empty($item['pointe_img'])) {
                                echo Helper::get_attachment($item['pointe_img']);
                            }
                            ?>

                        </div>
                    </div>
                <?php } ?>

            </div>
        <?php }

        // Button Link.
        if ($pointe_side_add_button) { ?>
            <div class="aheto-pricing__link">
                <?php echo \Aheto\Helper::get_button($this, $atts, 'pointe_side_'); ?>
            </div>
        <?php }
        ?>

    </div>

</div>
