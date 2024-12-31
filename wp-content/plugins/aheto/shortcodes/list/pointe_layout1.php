<?php

/**
 * The List Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;


extract($atts);

$lists = $this->parse_group($pointe_table_lists);
if (empty($lists)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-list');
$this->add_render_attribute('wrapper', 'class', 'aheto-list--pointe-table-links');


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/list/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('pointe-list-layout1', $sc_dir . 'assets/css/pointe_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('pointe-list-layout1-js', $sc_dir . 'assets/js/pointe_layout1.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto-list--pointe-table-links-items">
        <?php

        $counter = 1;

        foreach ($lists as $item) {
            $hide_item = $counter < 4 ? '' : 'hide-item'; ?>

            <div class="aheto-list--row <?php echo esc_attr($hide_item); ?>">
                <div class="aheto-list--column">
                    <div class="aheto-list--box-date item-align-<?php echo esc_attr($item['pointe_align_item']); ?>">
                        <h3><?php echo esc_html($item['pointe_first_item'], 'post'); ?></h3>
                        <p><?php echo esc_html($item['pointe_first_month'], 'post'); ?></p>
                    </div>
                </div>
                <div class="aheto-list--column">
                    <div class="aheto-list--second">
                        <?php
                        if (!empty($item['pointe_image'])) {
                            echo Helper::get_attachment($item['pointe_image']);
                        }
                        ?>
                        <div class="aheto-list--second-text">
                            <h6><?php echo esc_html($item['pointe_second_item'], 'post'); ?></h6>
                            <p class="pointe_second_item__dec"><?php echo wp_kses_post($item['pointe_first_loc'], 'post'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="aheto-list--column">
                    <h6><?php echo esc_html($item['pointe_third_item'], 'post'); ?></h6>
                    <p><?php echo wp_kses_post($item['pointe_third_time'], 'post'); ?></p>
                </div>
                <div class="aheto-list--column">
                    <h6><?php echo esc_html($item['pointe_third_fourth'], 'post'); ?></h6>
                    <p><?php echo wp_kses_post($item['pointe_third_val'], 'post'); ?></p>
                </div>
                <div class="aheto-list--column">
                    <div class="aheto-list--box-no-bg">
                        <?php if ($item['pointe_main_add_button']) { ?>
                            <div class="aheto-list__links">
                                <?php

                                echo Aheto\Helper::get_button($this, $item, 'pointe_main_');
                                echo Aheto\Helper::get_button($this, $item, 'pointe_add_');

                                ?>

                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

        <?php
            $counter++;
        } ?>
    </div>

    <div class="aheto-list--pointe-table-links-button <?php echo esc_attr($this->atts['pointe_align']); ?>">
        <a href="#" class="aheto-link aheto-btn--dark aheto-btn--no-underline" target="_self"><i class="fa fa-circle aheto-btn__icon--left"></i>VIEW MORE</a>
    </div>


</div>
