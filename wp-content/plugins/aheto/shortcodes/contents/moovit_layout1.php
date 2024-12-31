<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--moovit-modern' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-contents-layout1', $shortcode_dir . 'assets/css/moovit_layout1.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( $moovit_add_video_button ) {

		$background_image = Helper::get_background_attachment($moovit_video_image, $moovit_image_size, $atts, 'moovit_');  ?>

        <div class="aheto-contents__media" <?php echo esc_attr($background_image); ?>>

			<?php echo Helper::get_video_button( $atts, 'moovit_' ); ?>

        </div>

	<?php } ?>


    <div class="aheto-contents__wrapper">

        <div class="aheto-contents__inner_wrapper">
	        <?php if ( ! empty( $moovit_title ) ) {

		        echo '<' . $moovit_title_tag . ' class="aheto-contents__title">' . wp_kses( $moovit_title, 'post' ) . '</' . $moovit_title_tag . '>';

	        }

	        if ( ! empty( $moovit_text ) ) {
		        echo '<h5 class="aheto-contents__text">' . wp_kses( $moovit_text, 'post' ) . '</h5>';
	        }

	        if ( $moovit_link_add_button ) { ?>
                    <div class="aheto-contents__link">
				        <?php echo Helper::get_button( $this, $atts, 'moovit_link_' ); ?>
                    </div>
		        <?php

	        } ?>
        </div>

    </div>

</div>
