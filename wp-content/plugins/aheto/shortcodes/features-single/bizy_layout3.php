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
$this->add_render_attribute('wrapper', 'class', 'aheto-features--bizy-simple');

$item_link = $this->get_link_attributes( $bizy_link_url );
$this->add_render_attribute( 'button', $item_link );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('bizy-features-single-layout3', $shortcode_dir . 'assets/css/bizy_layout3.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <?php $background_image = Helper::get_background_attachment($bizy_image, $bizy_image_size, $atts); ?>

    <div class="aheto-features-block__wrap" <?php echo esc_attr($background_image); ?>>
        <?php if (!empty($bizy_text)) : ?>
            <h4 class="aheto-features-block__title">
                <?php if( ! empty( $item_link['href'] )){ ?>
                    <a <?php $this->render_attribute_string( 'button' ); ?>>
                <?php }

                echo esc_html($bizy_text);

                if( ! empty( $item_link['href'] )){ ?>
                    </a>
                <?php } ?>
            </h4>
        <?php endif; ?>
    </div>
</div>
