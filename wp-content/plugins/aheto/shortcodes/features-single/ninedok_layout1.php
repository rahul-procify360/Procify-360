<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

extract ( $atts );

use Aheto\Helper;

$this -> generate_css ();

// Wrapper.
$this -> add_render_attribute ( 'wrapper', 'id', $element_id );
$this -> add_render_attribute ( 'wrapper', 'class', $this -> the_custom_classes () );

// Block Wrapper.
$this -> add_render_attribute ( 'block_wrapper', 'class', 'aheto-content--ninedok-minimal' );

// Button.
$button = $this -> get_button_attributes ( 'link' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style ( 'ninedok-features-single-layout1', $shortcode_dir . 'assets/css/ninedok_layout1.css', null, null );
}
?>
<div <?php $this -> render_attribute_string ( 'wrapper' ); ?>>

    <div <?php $this -> render_attribute_string ( 'block_wrapper' ); ?>>
        <div class="aheto-content-block__wrap">

			<?php if ( !empty( $s_image )) : ?>
                <div class="aheto-content-block__image-wrap">
                    <div class="aheto-content-block__image">
						<?php echo \Aheto\Helper ::get_attachment ( $s_image, array (), $ninedok_image_size, $atts, 'ninedok_' ); ?>
                    </div>
                </div>
			<?php endif; ?>

            <div class="aheto-content-block__info">
				<?php if ( !empty( $s_heading )) : ?>
                    <h5 class="aheto-content-block__title"><?php echo esc_html ( $s_heading ); ?></h5>
				<?php endif; ?>

				<?php if ( !empty( $s_description )) : ?>
                    <p class="aheto-content-block__info-text">
						<?php echo wp_kses ( $s_description, 'post' ); ?>
                    </p>
				<?php endif; ?>
            </div>

        </div>

    </div>

</div>
