<?php
/**
 * The Contents Shortcode.
 */

//use Aheto\Helper;

use Aheto\Helper;

extract( $atts );

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--aira-modern' );

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-contents-modern', $sc_dir . 'assets/css/aira_layout1.css', null, null);
}

$background_image = isset($aira_back_image) && !empty($aira_back_image) && isset($aira_image_size) ? \Aheto\Helper::get_background_attachment($aira_back_image, $aira_image_size, $atts, 'aira_') : '';
?>

<div <?php $this->render_attribute_string('wrapper'); echo " " . esc_attr($background_image); ?>>

    <?php if (isset($aira_add_video_button) && $aira_add_video_button) { ?>
        <?php
        $video_background_image = \Aheto\Helper::get_background_attachment($aira_video_image, $aira_main_image_size, $atts, 'aira_main_');
        ?>
        <div class="aheto-contents__media" <?php echo esc_attr($video_background_image); ?>>
            <?php echo \Aheto\Helper::get_video_button($atts, 'aira_'); ?>
        </div>
    <?php } ?>

</div>
