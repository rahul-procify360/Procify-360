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
$this->add_render_attribute('wrapper', 'class', 'aheto-features--bizy-modern');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('bizy-features-single-layout1', $shortcode_dir . 'assets/css/bizy_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <?php if (!empty($s_image)) : ?>
        <div class="aheto-features-block__image">
            <?php echo \Aheto\Helper::get_attachment($s_image, [], $bizy_image_size, $atts, 'bizy_'); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($bizy_subtitle)) : ?>
        <h6 class="aheto-features-block__subtitle"><?php echo esc_html($bizy_subtitle); ?></h6>
    <?php endif; ?>

    <?php if (!empty($s_heading)) : ?>
        <h4 class="aheto-features-block__title"><?php echo esc_html($s_heading); ?></h4>
    <?php endif; ?>

    <div class="aheto-features-block__info">
        <?php if (!empty($s_description)) : ?>
            <p class="aheto-features-block__info-text">
                <?php echo wp_kses($s_description, 'post'); ?>
            </p>
        <?php endif; ?>
    </div>

    <?php if ($bizy_add_button) { ?>
        <div class="aheto-features-block__link">
            <?php echo \Aheto\Helper::get_button($this, $atts, 'bizy_'); ?>
        </div>
    <?php } ?>
</div>
