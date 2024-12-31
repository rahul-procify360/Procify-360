<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-content-block' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-content-block--modern-with-img' );
$this->add_render_attribute( 'wrapper', 'class', 't-center' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'features-single-style-7', $sc_dir . 'assets/css/layout7.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $s_image ) ) : ?>
        <div class="aheto-content-block__image">
			<?php echo Helper::get_attachment( $s_image, [], $image_size, $atts ); ?>
        </div>
	<?php endif; ?>

	<?php if ( ! empty( $s_heading ) ) : ?>
        <h5 class="aheto-content-block__title"><?php echo $this->highlight_text( $s_heading ); ?></h5>
	<?php endif; ?>

	<?php if ( ! empty( $s_description ) ) : ?>
        <p class="aheto-content-block__info-text">
			<?php echo wp_kses_post( $s_description ); ?>
        </p>
	<?php endif; ?>

</div>
