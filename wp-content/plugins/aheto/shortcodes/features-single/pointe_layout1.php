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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--pointe-modern');


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('pointe-features-single-layout1', $sc_dir . 'assets/css/pointe_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div <?php $this->render_attribute_string('block_wrapper'); ?>>
        <?php
        $background_image = \Aheto\Helper::get_background_attachment($s_image, $pointe_image_size, $atts, 'pointe_');
        ?>
        <div class="aheto-features-block__wrap" <?php echo esc_attr($background_image); ?>>

			<?php if (!empty($s_heading)) : ?>
                <h4 class="aheto-content-block__title"><?php echo esc_html($s_heading); ?></h4>
			<?php endif; ?>

			<?php if (!empty($s_description)) : ?>
                <p class="aheto-content-block__info-text"><?php echo wp_kses($s_description, 'post'); ?></p>
			<?php endif; ?>

			<?php if (!empty($pointe_logo_title)) : ?>
                <h2 class="aheto-content-block__main-title"><?php echo wp_kses($pointe_logo_title, 'post'); ?></h2>
			<?php endif; ?>

        </div>

    </div>

</div>
