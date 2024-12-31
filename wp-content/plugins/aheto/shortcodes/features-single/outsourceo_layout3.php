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

$outsourceo_light_style = isset( $outsourceo_light_style ) && ! empty( $outsourceo_light_style ) ? 'light-style' : '';
$outsourceo_use_dot     = isset( $outsourceo_use_dot ) && ! empty( $outsourceo_use_dot ) ? 'outsourceo-dot' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Block Wrapper.
$this->add_render_attribute( 'block_wrapper', 'class', 'aheto-content--outsourceo-with-image' );
$this->add_render_attribute( 'block_wrapper', 'class', $outsourceo_light_style );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-features-single-layout3', $shortcode_dir . 'assets/css/outsourceo_layout3.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div <?php $this->render_attribute_string( 'block_wrapper' ); ?>>
        <div class="aheto-content-block__wrap">
            <div class="aheto-content-block__shape"></div>
			<?php if ( ! empty( $s_image ) ) : ?>
                <div class="aheto-content-block__image">
					<?php echo \Aheto\Helper::get_attachment( $s_image, [], $outsourceo_image_size, $atts, 'outsourceo_' ); ?>
                </div>
			<?php endif; ?>

            <div class="aheto-content-block__inner">

                <div class="aheto-content-block__content">

					<?php if ( ! empty( $s_heading ) ) : ?>
                        <h5 class="aheto-content-block__title">
							<?php

							if ( $outsourceo_use_dot ) {

								$s_heading = str_replace( '{{.}}', '<span class="outsourceo-dot dot-primary"></span>', $s_heading );

								$words = explode( " ", $s_heading );

								if ( count( $words ) > 0 ) {
									$last_word = $words[ count( $words ) - 1 ];

									$last_space_position = strrpos( $s_heading, ' ' );
									$start_string        = substr( $s_heading, 0, $last_space_position );

									$s_heading = wp_kses( $start_string, 'post' ) . ' <span class="outsourceo-dot dot-primary">' . wp_kses( $last_word, 'post' ) . '</span>';
								} else {
									$s_heading = '<span class="outsourceo-dot dot-primary">' . wp_kses( $s_heading, 'post' ) . '</span>';
								}

							} else {
								$s_heading = wp_kses( $s_heading, 'post' );
							}

							echo $s_heading; ?>
                        </h5>
					<?php endif; ?>

                    <div class="aheto-content-block__info">
						<?php if ( ! empty( $s_description ) ) : ?>
                            <p class="aheto-content-block__info-text ">
								<?php echo wp_kses( $s_description, 'post' ); ?>
                            </p>
						<?php endif; ?>
                    </div>

                </div>

                <div class="aheto-content-block__link">
					<?php if ( ! empty( $outsourceo_link_text ) && ! empty( $outsourceo_link_url ) ) : ?>
                        <a href="<?php echo esc_url( $outsourceo_link_url ); ?>">
                            <span></span>
							<?php echo esc_html( $outsourceo_link_text ); ?>
                        </a>
					<?php endif; ?>
                </div>

            </div>

        </div>

    </div>

</div>
