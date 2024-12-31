<?php
/**
 * The Progress Bar Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

$aira_corners  = isset( $aira_corners ) && ! empty( $aira_corners ) ? 'show_corners' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-counter' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-counter--aira-creative' );
$this->add_render_attribute( 'wrapper', 'class', $aira_corners );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );



/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-progress-bar-creative', $sc_dir . 'assets/css/aira_layout3.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>


    <div class="aheto-counter__top-wrap">
        <?php
        // Image
        if (!empty($aira_image)) :
            echo Helper::get_attachment($aira_image, ['class' => 'aheto-counter__image'], $aira_image_size, $atts, 'aira_');

        endif;

        // Percentage
        if (!empty($aira_number)) { ?>
            <div class="aheto-counter__number-wrap">
                <?php if (isset($aira_current) && !empty($aira_current)) { ?>
                    <h2 class="aheto-counter__current"><?php echo esc_html($aira_current); ?></h2>
                <?php } ?>
                <h2 class="aheto-counter__number js-counter"><?php echo esc_html($aira_number); ?></h2>
                <?php if (!empty($aira_symbol)) { ?>
                    <h5 class="aheto-counter__symbol"><?php echo esc_html($aira_symbol); ?></h5>
                <?php } ?>
            </div>
        <?php }

        if (!empty($aira_image)) : ?>
            <div></div>
        <?php endif;

        ?>
    </div>

    <?php

    if ( !empty($heading )) {
        echo '<h4 class="aheto-counter__title aheto-progress__title">' . wp_kses($heading, 'post') . '</h4>';
    }

    if (!empty($description)) {
       echo '<p class="aheto-counter__desc">' . wp_kses($description, 'post') . '</p>';
     }

    ?>
</div>
