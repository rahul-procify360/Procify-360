<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

extract($atts);
use Aheto\Helper;
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--rela-minimal');

// Button.
$button = $this->get_button_attributes('link');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('rela-features-single-layout2', $shortcode_dir . 'assets/css/rela_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div <?php $this->render_attribute_string('block_wrapper'); ?>>
        <div class="aheto-features-block__wrap">

            <?php if ($s_image) : ?>
                <div class="aheto-features-block__image-wrap">
                    <div class="aheto-features-block__image">
                        <?php echo \Aheto\Helper::get_attachment($s_image, [], $image_size, $atts); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="aheto-features-block__info">
                <?php if (!empty($s_heading)) : ?>
                    <?php $highlight_heading = $this->highlight_text($s_heading) ?>
                    <h5 class="aheto-features-block__title"><?php echo wp_kses($highlight_heading, 'post'); ?></h5>
                <?php endif; ?>

                <?php if (!empty($s_description)) : ?>
                    <p class="aheto-features-block__description ">
                        <?php echo wp_kses($s_description, 'post'); ?>
                    </p>
                <?php endif; ?>
            </div>

        </div>

    </div>

</div>
