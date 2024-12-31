<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$aira_corner  = isset( $aira_corner ) && ! empty( $aira_corner ) ? 'show_corner' : '';

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--aira-text-block' );
$this->add_render_attribute( 'wrapper', 'class', $aira_corner );

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-contents-text-block', $sc_dir . 'assets/css/aira_layout2.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto-contents__wrapper">

        <div class="aheto-contents__inner_wrapper">
            <?php if (!empty($aira_title)) {
                $aira_title = str_replace(']]', '</span>', $aira_title);
                $aira_title = str_replace('[[', '<span>', $aira_title);
                echo '<' . $aira_title_tag . ' class="aheto-contents__title">' . wp_kses($aira_title, 'post') . '</' . $aira_title_tag . '>';
            }

            if (!empty($aira_text)) {
                echo '<p class="aheto-contents__text">' . wp_kses($aira_text, 'post') . '</p>';
            }

            if (isset($aira_link_add_button) && $aira_link_add_button) { ?>
                <div class="aheto-contents__link">
                    <?php echo \Aheto\Helper::get_button($this, $atts, 'aira_link_'); ?>
                </div>
                <?php
            } ?>
        </div>

    </div>

</div>
