<?php
/**
 * The Button Shortcode.
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
$this->add_render_attribute('wrapper', 'id', $this->atts['element_id']);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto_video-btn---rela');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/video-btn/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('rela-video-btn-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}
$text_position ='';
$text_position = isset($rela_text_position) && $rela_text_position ? 'style=flex-direction:row-reverse;justify-content:flex-end;' : '';
$text_position_class = isset($rela_text_position) && $rela_text_position ? 'video-container-flex' : '';
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="aheto-video-container <?php echo esc_attr($this->atts['align'] .''. $text_position_class); ?>" <?php echo esc_attr( $text_position ); ?>>
        <?php if (!empty($rela_text)) {
            echo '<h2 class="aheto-btn-video__text">' . wp_kses($rela_text, 'post') . '</h2>';
        } ?>
        <?php echo Helper::get_video_button($atts); ?>
    </div>
</div>
