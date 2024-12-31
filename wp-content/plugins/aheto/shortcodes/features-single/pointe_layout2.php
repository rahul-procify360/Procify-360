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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--pointe-house');


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('pointe-features-single-layout2', $sc_dir . 'assets/css/pointe_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div <?php $this->render_attribute_string('block_wrapper'); ?>>

            <?php if ( ! empty($pointe_image) ) : ?>
                <div class="aheto-features--holder">
                    <?php echo Helper::get_attachment($pointe_image, ['class' => 'aheto-features--img'], $image_size); ?>
                </div>
            <?php endif; ?>

            <div class="aheto-features__text">

                <?php
                // Title
                 if (!empty($s_heading)) : ?>
                    <h4 class="aheto-content-block__title"><span><?php echo esc_html($s_heading); ?></span></h4>
                <?php endif; ?>

            </div>

    </div>

</div>
