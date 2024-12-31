<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();
$aira_active = $aira_active ? 'active' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'widget widget_aheto');
$this->add_render_attribute('block_wrapper', 'class', $aira_active );
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--aira-large');


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-features-single-large', $sc_dir . 'assets/css/aira_layout8.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div <?php $this->render_attribute_string('block_wrapper'); ?>>
            <?php

            if (!empty($s_image)) : ?>

                <?php $background_image = \Aheto\Helper::get_background_attachment( $s_image, $aira_image_size, $atts, 'aira_' ); ?>
                <div class="aheto-content-block__image" <?php echo esc_attr( $background_image ); ?>>

                </div>
            <?php endif; ?>

            <?php if (!empty($s_heading)) : ?>
                <h5 class="aheto-content-block__title"><?php echo wp_kses($this->highlight_text($s_heading), 'post'); ?></h5>
            <?php endif; ?>
            <?php if (!empty($s_description)) : ?>
                <p class="aheto-content-block__info-text"><?php echo wp_kses($s_description, 'post'); ?></p>
            <?php endif; ?>

    </div>

</div>
