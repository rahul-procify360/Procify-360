<?php

/**
 * The Heading Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */

extract($atts);

use Aheto\Helper;

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-heading--karma-political__simple');
$this->add_render_attribute('wrapper', 'class', $alignment);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'karma-political-heading-layout1', $shortcode_dir . 'assets/css/karma_political_layout1.css', null, null );
}

if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('typed');
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <?php
        $heading = $this->get_heading();

        if ( ! empty( $heading ) ) {
            $heading = $this->highlight_text( $heading );

            echo '<' . $text_tag . ' class="aheto-heading__title">' . $heading . '</' . $text_tag . '>';
        }

        if ( ! empty($karma_political_subtitle) ) {
            echo '<' . $karma_political_subtitle_tag . ' class="aheto-heading__subtitle">' . esc_html($karma_political_subtitle) . '</' . $karma_political_subtitle_tag . '>';
        }
    ?>
</div>
