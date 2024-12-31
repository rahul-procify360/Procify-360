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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-content-block aheto-content-block--classic' );
$this->add_render_attribute( 'wrapper', 'class', 'item-align-' . $align_item );
$this->add_render_attribute( 'wrapper', 'class', 'tablet-item-align-' . $tablet_align_item );
$this->add_render_attribute( 'wrapper', 'class', 'mobile-item-align-' . $mobile_align_item );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Button.
$button = $this->get_button_attributes( 'link' );

// Icon.
$icon = $this->get_icon_attributes( '', true, true );
if ( ! empty( $icon ) ) {
	$this->add_render_attribute( 'icon', 'class', 'aheto-content-block__ico icon' );
	$this->add_render_attribute( 'icon', 'class', $icon['icon'] );
	if ( ! empty( $icon['color'] ) ) {
		$this->add_render_attribute( 'icon', 'style', 'color:' . $icon['color'] );
	}
}


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'features-single-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<?php if ( ! empty( $s_image ) ) : ?>
        <div class="aheto-content-block__image">
			<?php echo Helper::get_attachment( $s_image, [], $image_size, $atts ); ?>
        </div>
	<?php endif; ?>

    <div class="aheto-content-block__info">

        <div class="aheto-content-block__icon-wrap">
			<?php
			// Icon.
			if ( ! empty( $icon ) ) {
				echo '<i ' . $this->get_render_attribute_string( 'icon' ) . '></i>';
			}
			?>

			<?php if ( ! empty( $s_heading ) ) : ?>
                <h5 class="aheto-content-block__title"><?php echo $this->highlight_text( $s_heading ); ?></h5>
			<?php endif; ?>
        </div>

		<?php if ( ! empty( $s_description ) ) : ?>
            <p class="aheto-content-block__info-text">
				<?php echo wp_kses_post( $s_description ); ?>
            </p>
		<?php endif; ?>

		<?php
		if ( isset( $button['href'] ) && ! empty( $button['href'] ) ) :
			$this->add_render_attribute( 'button', $button );
			$this->add_render_attribute( 'button', 'class', 'aheto-link aheto-btn--primary' );
			?>
            <div class="aheto-btn-container">
                <a <?php $this->render_attribute_string( 'button' ); ?>><?php echo esc_html( $button['title'] ); ?></a>
            </div>
		<?php endif; ?>
    </div>

</div>
