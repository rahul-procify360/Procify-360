<?php

/**
 * The sterling Media Shortcode.
 */

use Aheto\Helper;

extract($atts);

if (empty($sterling_image)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-sterling-gallery');

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('magnific');
	wp_enqueue_style('sterling-media-layout2', $sc_dir . 'assets/css/sterling_layout2.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('magnific');
	wp_enqueue_script('isotope');
	wp_enqueue_script('sterling-media-layout2-js', $sc_dir . 'assets/js/sterling_layout2.min.js', array('jquery'), null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <?php
    $show_all = $sterling_all_item ? '' : 'hide-item';
    ?>
    <div class="aheto-sterling-gallery-img">
        <div class="grid-sizer"></div>
        <?php
        $counter = 1;

        foreach ($sterling_image as $image) {
            $image_id = is_array($image) && !empty($image['id']) ? $image['id'] : $image;
            $image_url = wp_get_attachment_image_url($image_id, 'full');
        ?>
            <figure data-mfp-src="<?php echo esc_url($image_url) ?>" class="grid-item <?php echo esc_attr($show_all); ?>">
                <span>
                    <?php echo Helper::get_attachment($image, ['class' => 'js-bg'], $sterling_image_size, $atts, 'sterling_'); ?>
                </span>
            </figure>
        <?php
        } ?>
    </div>
</div>
