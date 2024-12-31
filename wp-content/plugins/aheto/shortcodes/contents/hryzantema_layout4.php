<?php
/**
 * The Contents Shortcode.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-content-block--hr-text-with-icon');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Icon.
$icon = $this->get_icon_attributes('hryzantema_', true, true);
if ( !empty($icon) ) {
    $this->add_render_attribute('hryzantema_icon', 'class', 'aheto-content-block__ico icon');
    $this->add_render_attribute('hryzantema_icon', 'class', $icon['icon']);
    if ( !empty($icon['color']) ) {
        $this->add_render_attribute('hryzantema_icon', 'style', 'color:' . $icon['color'] . ';');
    }
    if ( !empty($icon['font_size']) ) {
        $this->add_render_attribute('hryzantema_icon', 'style', 'font-size:' . $icon['font_size'] . ';');
    }
}

$flex_align = !empty($hryzantema_flex_align) ? $hryzantema_flex_align : 'center';


/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-contents-layout4', $shortcode_dir . 'assets/css/hryzantema_layout4.css', null, null);
} ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="aheto-content-block__info">

        <div class="aheto-content-block__info-wrap" style="justify-content: <?php echo esc_attr($flex_align); ?>">

            <?php

            if ( $icon == true ) {
                echo '<i ' . $this->get_render_attribute_string('hryzantema_icon') . '></i>';
            }

            if ( !empty($hryzantema_text) ) :
            if ( isset($hryzantema_link) && !empty($hryzantema_link) ) :
                echo '<' . $hryzantema_text_tag . ' class="aheto-content-block__title"><a href="'.esc_url($hryzantema_link).'">'. esc_html($hryzantema_text). '</a></' . $hryzantema_text_tag . '>';
           else:
			   echo '<' . $hryzantema_text_tag . ' class="aheto-content-block__title">'. esc_html($hryzantema_text). '</' . $hryzantema_text_tag . '>';

			endif;
            endif; ?>


        </div>
    </div>
</div>
