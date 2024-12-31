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
$features = $this->parse_group($bizy_features_creative);

if (empty($features)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-features--bizy-creative');
$this->add_render_attribute('wrapper', 'class', 'columns-' . $bizy_columns);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('bizy-features-single-layout2', $shortcode_dir . 'assets/css/bizy_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <?php foreach ($features as $key => $feature) :
        $feature = wp_parse_args($feature, [
            'bizy_item_image' => '',
            'bizy_hover_image' => '',
            'bizy_item_title' => '',
        ]);
        extract($feature); ?>

        <div class="aheto-features-block__wrap">

            <?php if (!empty($bizy_item_image)) { ?>
                <div class="aheto-features-block__image">
                    <?php echo \Aheto\Helper::get_attachment($bizy_item_image, ['class' => 'aheto-features-block__image_first'], $bizy_image_size, $atts, 'bizy_');

                    if (!empty($bizy_hover_image)) {
                        echo \Aheto\Helper::get_attachment($bizy_hover_image, ['class' => 'aheto-features-block__image_second'], $bizy_image_size, $atts, 'bizy_');
                    } ?>
                </div>
            <?php } ?>

            <div class="aheto-features-block__content">
                <?php if (!empty($bizy_item_title)) : ?>
                    <h4 class="aheto-features-block__title"><?php echo esc_html($bizy_item_title); ?></h4>
                <?php endif; ?>

                <?php if ( $bizy_btn_add_button ) { ?>
                    <div class="aheto-features-block__link">
                        <?php echo \Aheto\Helper::get_button($this, $feature, 'bizy_btn_'); ?>
                    </div>
                <?php } ?>

                <div class="aheto-features-block__inner">
                    <?php if (!empty($bizy_item_title)) : ?>
                        <h4 class="aheto-features-block__title">
                            <?php echo esc_html($bizy_item_title); ?>
                        </h4>
                    <?php endif; ?>

                    <?php if ( $bizy_btn_add_button ) { ?>
                        <div class="aheto-features-block__link">
                            <?php echo \Aheto\Helper::get_button($this, $feature, 'bizy_btn_'); ?>
                        </div>
                    <?php } ?>
                </div>


            </div>

        </div>

    <?php endforeach; ?>
</div>
