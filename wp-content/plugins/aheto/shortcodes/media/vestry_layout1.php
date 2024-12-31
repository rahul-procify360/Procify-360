<?php

/**
 * The Vestry Media Shortcode.
 */

use Aheto\Helper;

extract($atts);
if (!is_array($vestry_image)) {
    $image = explode(',', $vestry_image);
}
if (empty($vestry_image)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-media--par');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('vestry-media_layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null);
}

$count = count($vestry_image);

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <?php if (1 === $count) : ?>
        <?php echo Helper::get_attachment($vestry_image, ['class' => 'bb'], $vestry_image_size, $atts, 'vestry_size_'); ?>
    <?php else : ?>
        <div class="par-wrapper">
            <?php foreach ($vestry_image as $item) : ?>
                <div class="par-item">
                    <?php echo Helper::get_attachment($item, ['class' => 'bb'], $vestry_image_size, $atts, 'vestry_size_'); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
