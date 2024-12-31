<?php
/**
 * The Testimonials Shortcode.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper');
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--aira-single');



/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-testimonials-single', $sc_dir . 'assets/css/aira_layout4.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto-tm__content">
        <div class="aheto-tm__content-add"></div>
        <?php
        // Testimonial.
        if (isset($aira_testimonial_single)) {
            echo '<p class="aheto-tm__text">' . esc_html($aira_testimonial_single) . '</p>';
        } ?>
    </div>

    <div class="aheto-tm__author">

        <?php if (!empty($aira_single_image)) : ?>
            <div class="aheto-tm__avatar">
                <?php echo Helper::get_attachment($aira_single_image, ['class' => 'js-bg'], array(63, 63)); ?>
            </div>
        <?php endif; ?>

        <div class="aheto-tm__info">
            <?php
            // Name.
            if (isset($aira_single_name)) {
                echo '<h5 class="aheto-tm__name">' . esc_html($aira_single_name) . '</h5>';
            }

            // Company.
            if (isset($aira_position)) {
                echo '<h6 class="aheto-tm__position">' . esc_html($aira_position) . '</h6>';
            }
            ?>
        </div>
    </div>
</div>
