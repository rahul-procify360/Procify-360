<?php

/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     KARMA <info@karma.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-features-single--karma-business' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'karma-business-features-single-layout1', $shortcode_dir . 'assets/css/karma_business_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-features-single__info">

        <div class="aheto-features-single__info-wrap">

			<?php
                $title_tag = isset($karma_business_title_tag) && !empty($karma_business_title_tag) ? $karma_business_title_tag : 'h2';

                if ( ! empty( $s_heading ) ) :
				    echo '<' . $title_tag . ' class="aheto-features-single__title">' . $this->highlight_text( $s_heading ) . '</' . $title_tag . '>';
			    endif;
            ?>

            <?php if ( $karma_business_main_add_button ) {

				echo \Aheto\Helper::get_button( $this, $atts, 'karma_business_main_' );

			} ?>

        </div>
    </div>
</div>
