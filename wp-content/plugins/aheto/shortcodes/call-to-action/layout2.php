<?php
/**
 * The Call To Action Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cta' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cta--classic' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$icon = $this->get_icon_attributes( '', true, true );
if ( ! empty( $icon ) ) {
	$this->add_render_attribute( 'icon', 'class', 'icon' );
	$this->add_render_attribute( 'icon', 'class', $icon['icon'] );
	if ( ! empty( $icon['color'] ) ) {
		$this->add_render_attribute( 'icon', 'style', 'color:' . $icon['color'] );
	}
}

$sc_dir     = aheto()->plugin_url() . 'shortcodes/call-to-action/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'call-to-action-style-2', $sc_dir . 'assets/css/layout2.css', null, null );
}

?>


<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-cta__wrap">

		<?php if ( ! empty( $heading ) ) { ?>
            <div class="aheto-cta__text">

				<?php
				// Icon.
				if ( ! empty( $icon ) ) { ?>
                    <div class="aheto-cta__icon">
                        <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                    </div>
				<?php } ?>

				<?php echo '<' . $text_tag . ' class="aheto-cta__title">' . wp_kses_post( $heading ) . '</' . $text_tag . '>'; ?>
            </div>
		<?php }

		if ( $main_add_button || $additional_add_button ) { ?>
            <div class="aheto-cta__links">
				<?php if ( $main_add_button ) {
					echo Helper::get_button( $this, $atts, 'main_' );
				}

				if ( $additional_add_button ) {
					echo Helper::get_button( $this, $atts, 'additional_' );
				} ?>
            </div>
		<?php }
		?>
    </div>
</div>

