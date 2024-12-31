<?php
/**
 * The Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$funero_gallery = $this->parse_group( $funero_gallery );

if ( empty( $funero_gallery ) ) {

	return '';
}
$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-media-gallery' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-funero-gallery' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'funero-media-layout1', $shortcode_dir . 'assets/css/funero_layout1.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-funero-gallery__container">
		<?php foreach ( $funero_gallery as $index => $item ) :
			if ( ! empty( $item['funero_image'] ) ) :
				$background_image = \Aheto\Helper::get_background_attachment( $item['funero_image'], $atts['funero_media_image_size'], $atts, 'funero_media_' );
				$class_img = $funero_smaller_block == true ? 'aheto-funero-gallery__image-small' : ''; ?>
                <div class="aheto-funero-gallery__image <?php echo esc_attr( $class_img ); ?>" <?php echo esc_attr( $background_image ); ?>>
					<?php
					if ( ! empty( $item['funero_link']['url'] ) ):

						$button = $this->get_link_attributes( $item['funero_link'] );
						$this->add_render_attribute( 'button-' . $index, $button );
						$this->add_render_attribute( 'button-' . $index, 'class', 'aheto-funero-gallery__name-wrap' );

						if ( ! empty( $item['funero_name'] ) ): ?>
                            <a <?php $this->render_attribute_string( 'button-' . $index ); ?>>
                                <h5 class="aheto-funero-gallery__name"><?php echo esc_html( $item['funero_name'] ); ?></h5>
                            </a>
						<?php endif;
					else: ?>
						<?php if ( ! empty( $item['funero_name'] ) ): ?>
                            <h5 class="aheto-funero-gallery__name"><?php echo esc_html( $item['funero_name'] ); ?></h5>
						<?php endif;

					endif; ?>
					<?php if ( ! empty( $item['funero_date'] ) ): ?>
                        <p class="aheto-funero-gallery__date"><?php echo esc_html( $item['funero_date'] ); ?></p>
					<?php endif; ?>
                </div>
			<?php endif;

		endforeach; ?>
    </div>
</div>
