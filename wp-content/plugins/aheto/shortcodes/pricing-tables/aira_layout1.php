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

//Active
$aira_active = $aira_active ? 'aheto-pricing__active' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing--aira-modern' );
$this->add_render_attribute( 'wrapper', 'class', $aira_active );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );



// Button Link.
$link = $this->get_button_attributes( 'link' );

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-pricing-tables-modern', $sc_dir . 'assets/css/aira_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto-pricing__header">

        <?php
        // Heading.
        if (!empty($heading)) {
            echo '<h5 class="aheto-pricing__title">' . wp_kses($heading, 'post') . '</h5>';
        }
        ?>

        <div class="aheto-pricing__cost">
            <?php
            // Price.
            if (!empty($price)) {
                echo '<div class="aheto-pricing__cost-value">' . esc_html($price) . '</div>';
            }
            ?>
        </div>

    </div>

    <div class="aheto-pricing__content">

        <?php
        $aira_features = $this->parse_group($aira_features);
        if ($aira_features) { ?>

            <div class="aheto-pricing__list">

                <?php foreach ($aira_features as $item) { ?>
                    <div class="aheto-pricing__list-item <?php echo esc_html($item['aira_mark']); ?>">
                        <?php echo wp_kses($item['aira_feature'], 'post'); ?>
                    </div>
                <?php } ?>

            </div>
        <?php }

        // Button Link.
        if ($aira_add_button) { ?>
            <div class="aheto-pricing__link">
                <?php echo \Aheto\Helper::get_button($this, $atts, 'aira_'); ?>
            </div>
        <?php }
        ?>

    </div>

</div>
