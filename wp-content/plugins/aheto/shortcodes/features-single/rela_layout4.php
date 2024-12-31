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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--rela-packages');

// Button.
$button = $this->get_button_attributes('link');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('rela-features-single-layout4', $shortcode_dir . 'assets/css/rela_layout4.css', null, null);
}
if (  !Helper::is_Elementor_Live()) {
	wp_enqueue_script('rela-features-single-layout4-js', $shortcode_dir . 'assets/js/rela_layout4.min.js', array('jquery'), null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div <?php $this->render_attribute_string('block_wrapper'); ?>>
        <div class="aheto-features-block__wrap">
            <?php if ($s_image) : ?>
                <div class="aheto-features-block__image-wrap">

                    <?php
                    $background_image = Helper::get_background_attachment($s_image, $rela_image_size, $atts, 'rela_');
                    ?>
                    <div class="aheto-features-block__image" <?php echo esc_attr($background_image); ?>>

                        <?php if (!empty($rela_price)) : ?>
                            <div class="aheto-features-block__overlay">
                                <h2 class="aheto-features-block__price"><?php echo esc_html($rela_price); ?></h2>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($s_heading)) : ?>
                <?php $highlight_heading = $this->highlight_text($s_heading) ?>
                <h4 class="aheto-features-block__title"><?php echo wp_kses($highlight_heading, 'post'); ?></h4>
            <?php endif; ?>

            <?php if (!empty($s_description)) : ?>
                <p class="aheto-features-block__description ">
                    <?php echo wp_kses($s_description, 'post'); ?>
                </p>
            <?php endif;

            if ($rela_add_button) { ?>
                <div class="aheto-features-block__link">
                    <?php echo \Aheto\Helper::get_button($this, $atts, 'rela_'); ?>
                </div>
            <?php }

            if (isset($button['href']) && !empty($button['href'])) :
                $this->add_render_attribute('button', $button);
                $this->add_render_attribute('button', 'class', 'aheto-link aheto-btn--primary');
                ?>
                <div class="aheto-btn-container">
                    <a <?php $this->render_attribute_string('button'); ?>><?php echo esc_html($button['title']); ?></a>
                </div>
            <?php endif;
            ?>

        </div>

    </div>

</div>
