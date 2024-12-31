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
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Block Wrapper.
$this->add_render_attribute( 'block_wrapper', 'class', 'aheto-content-block--funero-image-left' );
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'funero-features-single-layout3', $shortcode_dir . 'assets/css/funero_layout3.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div <?php $this->render_attribute_string( 'block_wrapper' ); ?>>
		<?php
		$background_image = '';
		if ( ! empty( $funero_image ) ):
			$background_image = Helper::get_background_attachment( $funero_image, $image_size, $atts );

		endif; ?>
        <div class="aheto-content-block__image-wrap " <?php echo esc_attr( $background_image ); ?>>
        </div>
        <div class="aheto-content-block__text-wrap">
			<?php if ( ! empty( $funero_subtitle ) ) : ?>
                <p class="aheto-content-block__subtitle "><?php echo esc_html( $funero_subtitle ); ?></p>
			<?php endif;

			if ( ! empty( $funero_title ) ) : ?>
                <h6 class="aheto-content-block__title "><?php echo esc_html( $funero_title ); ?></h6>
			<?php endif;

			if ( ! empty( $funero_desc ) ) : ?>
                <p class="aheto-content-block__desc "><?php echo esc_html( $funero_desc ); ?></p>
			<?php endif;

			if ( ! empty( $funero_link_title ) && ! empty( $funero_link_url['url'] ) ) :
				$button = $this->get_link_attributes( $funero_link_url );
				$this->add_render_attribute( 'button', $button );
				$this->add_render_attribute( 'button', 'class', 'aheto-content-block__link' ); ?>
                <a <?php $this->render_attribute_string( 'button' ); ?>><?php echo esc_html( $funero_link_title ); ?></a>
			<?php endif; ?>
        </div>
    </div>
</div>
