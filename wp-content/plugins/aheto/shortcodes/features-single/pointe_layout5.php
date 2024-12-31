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

$items = $this->parse_group($pointe_features_single);
if (empty($items)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'widget widget_aheto');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--pointe-img-vertical');


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('pointe-features-single-img_3', $sc_dir . 'assets/css/pointe_layout5.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div <?php $this->render_attribute_string('block_wrapper'); ?>>

        <?php
        foreach ($items as $item) : ?>

            <?php $target = isset($pointe_link['is_external']) ? $pointe_link['is_external'] : '_self';
            $rel = isset($pointe_link['nofollow']) && !empty($pointe_link['nofollow']) ? "rel='" . esc_attr($pointe_link['nofollow'])  . "'" : ''; ?>
            <?php $button = $this->get_link_attributes($item['pointe_link']); ?>
            <a href="<?php echo esc_url($button['href']); ?>" target="<?php echo esc_attr($target); ?>" <?php echo esc_attr($rel); ?>>
                <?php if (!empty($item['pointe_image'])) : ?>
                    <div class="aheto-features--holder">
                        <?php echo Helper::get_attachment($item['pointe_image'], ['class' => 'aheto-features--img', 'class' => 'js-bg'], $image_size); ?>
                    </div>
                <?php endif; ?>

                <div class="aheto-features__text">

                    <?php
                    // Title
                    if (!empty($item['pointe_title'])) : ?>
                        <h3 class="aheto-features-block__title"><?php echo esc_html($item['pointe_title']); ?></h3>
                    <?php endif; ?>

                    <?php
                    // Description
                    if (!empty($item['pointe_dec'])) : ?>
                        <p class="aheto-features-block__dec"><?php echo wp_kses_post($item['pointe_dec']); ?></p>
                    <?php endif; ?>

                </div>
            </a>
        <?php endforeach; ?>
    </div>

</div>
