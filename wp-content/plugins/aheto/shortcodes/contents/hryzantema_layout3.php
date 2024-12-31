<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

extract( $atts );

wp_enqueue_script('typed');

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--hr-modern' );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-contents-layout3', $shortcode_dir . 'assets/css/hryzantema_layout3.css', null, null);
}?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <?php if ( $hryzantema_add_video_button == true && !empty($hryzantema_video_image ) ) {
        $background_video_image = \Aheto\Helper::get_background_attachment($hryzantema_video_image, 'full');
        ?>

        <div class="aheto-contents__media" <?php echo esc_attr($background_video_image );?>>

            <?php echo \Aheto\Helper::get_video_button( $atts, 'hryzantema_' ); ?>

        </div>

    <?php } ?>

    <?php  $background_image = !empty($hryzantema_bg_image) ? \Aheto\Helper::get_background_attachment($hryzantema_bg_image, 'full') : ''; ?>
    <div class="aheto-contents__wrapper" <?php echo esc_attr($background_image );?>>

        <div class="aheto-contents__inner_wrapper">

            <?php if ( ! empty( $hryzantema_title ) ) {

                $hryzantema_title = str_replace( ']]', '</span>', $hryzantema_title );
                $hryzantema_title = str_replace( '[[', '<span>', $hryzantema_title );

                echo '<' . $hryzantema_title_tag . ' class="aheto-contents__title">' . wp_kses_post( $hryzantema_title ) . '</' . $hryzantema_title_tag . '>';

            }

            if ( ! empty( $hryzantema_text ) ) {
                echo "<$hryzantema_text_tag class='aheto-contents__text'>" . wp_kses_post( $hryzantema_text ) . "</$hryzantema_text_tag>";
            }

            if ( $hryzantema_link_add_button == true ) { ?>
                <div class="aheto-contents__link">
                    <?php echo \Aheto\Helper::get_button( $this, $atts, 'hryzantema_link_' ); ?>
                </div>
                <?php

            } ?>
        </div>

    </div>

</div>
