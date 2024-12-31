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
$this->add_render_attribute( 'wrapper', 'class', 'widget_aheto' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Block Wrapper.
$this->add_render_attribute( 'block_wrapper', 'class', 'aheto-features--moovit-modern' );
$this->add_render_attribute( 'block_wrapper', 'href', $moovit_link );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-features-single-layout1', $shortcode_dir . 'assets/css/moovit_layout1.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <a <?php $this->render_attribute_string( 'block_wrapper' ); ?>>
        <div class="aheto-features-block__shape"></div>
        <div class="aheto-features-block__wrap">

			<?php if ( ! empty( $s_image ) ) : ?>
                <div class="aheto-features-block__image">
					<?php echo \Aheto\Helper::get_attachment( $s_image, [], $moovit_image_size, $atts, 'moovit_' ); ?>
                </div>
			<?php endif; ?>

			<?php if ( ! empty( $s_heading ) ) : ?>
                <h4 class="aheto-features-block__title"><?php echo esc_html( $s_heading ); ?></h4>
			<?php endif; ?>

            <div class="aheto-features-block__info">
				<?php if ( ! empty( $s_description ) ) : ?>
                    <p class="aheto-features-block__info-text ">
						<?php echo wp_kses( $s_description, 'post' ); ?>
                    </p>
				<?php endif; ?>
            </div>

        </div>

    </a>

</div>
