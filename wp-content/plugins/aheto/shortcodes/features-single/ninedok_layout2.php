<?php
/**
 * The Features Modern with hover Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract ( $atts );

$this -> generate_css ();

// Wrapper.
$this -> add_render_attribute ( 'wrapper', 'id', $element_id );
$this -> add_render_attribute ( 'wrapper', 'class', $this -> the_custom_classes () );

// Button.
$button = $this -> get_button_attributes ( 'link' );
// Icon.
$icon = $this -> get_icon_attributes ( '', true, true );
if ( !empty( $icon )) {
	$this -> add_render_attribute ( 'icon', 'class', 'aheto-content-block__ico aheto-content-block__ico--lg icon' );
	$this -> add_render_attribute ( 'icon', 'class', $icon['icon'] );
	$this -> add_render_attribute ( 'icon', 'class', $icon['align'] );
	if ( !empty( $icon['color'] )) {
		$this -> add_render_attribute ( 'icon', 'style', 'color:' . $icon['color'] );
	}
}
$background_image = Helper ::get_background_attachment ( $s_image, $ninedok_image_size, $atts, 'ninedok_' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style ( 'ninedok-features-single-layout2', $shortcode_dir . 'assets/css/ninedok_layout2.css', null, null );
} ?>
<div <?php $this -> render_attribute_string ( 'wrapper' ); ?>>

    <div class="t-center aheto-content-block--light aheto-content-block--modern" <?php echo esc_attr ( $background_image ); ?>>
        <div class="aheto-content-block__overlay"></div>

        <div class="aheto-content-block__descr">

			<?php
			if ( !empty( $s_heading )) :
				// Icon.
				if ( !empty( $icon )) {
					echo '<i ' . $this -> get_render_attribute_string ( 'icon' ) . '></i>';
				}
				?>
                <h4 class="aheto-content-block__title t-light"><?php echo esc_html ( $s_heading ); ?></h4>
			<?php endif; ?>

            <div class="aheto-content-block__info">

				<?php if ( !empty( $s_description )) : ?>
                    <p class="aheto-content-block__info-text">
						<?php echo wp_kses ( $s_description, 'post' ); ?>
                    </p>
				<?php endif; ?>


            </div>
			<?php if ($ninedok_add_button) { ?>
                <div class="aheto-pricing__link">
					<?php echo \Aheto\Helper ::get_button ( $this, $atts, 'ninedok_' ); ?>
                </div>
			<?php } ?>

        </div>

    </div>

</div>
