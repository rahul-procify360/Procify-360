<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();


// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-content-block--moovit-simple' );
$this->add_render_attribute( 'wrapper', 'class', 'align-mob-' . $moovit_align_mobile );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$s_heading = $this->highlight_text( $s_heading );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-features-single-layout2', $shortcode_dir . 'assets/css/moovit_layout2.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-content-block__info">
		<?php if ( ! empty( $s_image ) ) : ?>
            <div class="aheto-content-block__image">
				<?php echo \Aheto\Helper::get_attachment( $s_image, [], $moovit_image_size, $atts, 'moovit_' ); ?>
            </div>
		<?php endif; ?>

        <div class="aheto-content-block__info-wrap">
			<?php

            $title_tag = isset($moovit_title_tag) && !empty($moovit_title_tag) ? $moovit_title_tag : 'h5';

            if ( ! empty( $s_heading ) ) :

                if ( $moovit_use_dot ) {

                    $s_heading = str_replace( '{{.}}', '<span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '"></span>', $s_heading );

                    $words = explode( " ", $s_heading );

                    if ( count( $words ) > 0 ) {
                        $last_word = $words[ count( $words ) - 1 ];

                        $last_space_position = strrpos( $s_heading, ' ' );
                        $start_string        = substr( $s_heading, 0, $last_space_position );

                        $s_heading = wp_kses( $start_string, 'post' ) . ' <span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '">' . wp_kses( $last_word, 'post' ) . '</span>';
                    } else {
                        $s_heading = '<span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '">' . wp_kses( $s_heading, 'post' ) . '</span>';
                    }

                } else {
                    $s_heading = wp_kses( $s_heading, 'post' );
                }

                echo '<' . $title_tag . ' class="aheto-content-block__title">' . $s_heading . '</' . $title_tag . '>';

            endif; ?>

			<?php if ( ! empty( $s_description ) ) : ?>
                <p class="aheto-content-block__info-text">
					<?php echo wp_kses( $s_description, 'post' ); ?>
                </p>
			<?php endif; ?>

        </div>
    </div>
</div>
