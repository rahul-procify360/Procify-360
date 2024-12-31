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
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--aira-minimal');


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-testimonials-minimal', $sc_dir . 'assets/css/aira_layout3.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="aheto-tm__content">
        <?php
        // Name.
        if (!empty($aira_single_name)) {
            echo '<h5 class="aheto-tm__name">' . wp_kses($aira_single_name, 'post') . '</h5>';
        }

        // Company.
        if (!empty($aira_position)) {
            echo '<h6 class="aheto-tm__position">' . wp_kses($aira_position, 'post') . '</h6>';
        }

        if (!empty($aira_testimonial_single)) {
            echo '<h4 class="aheto-tm__text">' . wp_kses($aira_testimonial_single, 'post') . '</h4>';
        }
        ?>
    </div>
</div>
