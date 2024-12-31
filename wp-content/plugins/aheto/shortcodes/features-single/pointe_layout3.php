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

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--pointe-img');


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('pointe-features-layout3', $sc_dir . 'assets/css/pointe_layout3.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div <?php $this->render_attribute_string('block_wrapper'); ?>>
        <?php $target = isset($pointe_link_url['is_external']) ? $pointe_link_url['is_external'] : '_self';
        $rel = isset($pointe_link_url['nofollow']) && !empty($pointe_link_url['nofollow']) ? "rel='" . esc_attr($pointe_link_url['nofollow'])  . "'" : ''; ?>

        <a href="<?php echo esc_url($pointe_link_url['url']); ?>" target="<?php echo esc_attr($target); ?>" <?php echo esc_attr($rel); ?>>
            <?php if (!empty($cs_image)) : ?>
                <div class="aheto-features--holder">
                    <?php echo Helper::get_attachment($cs_image, ['class' => 'aheto-features--img'], $image_size); ?>
                </div>
            <?php endif; ?>

            <div class="aheto-features__text">

                <?php
                // Title
                if (!empty($s_heading)) : ?>
                    <h4 class="aheto-features-block__title"><?php echo esc_html($s_heading); ?></h4>
                <?php endif; ?>

            </div>
        </a>

    </div>

</div>
