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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-content-block aheto-content-block--list-icon t-center' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Icon.
$icon = $this->get_icon_attributes( '', true, true );
if ( ! empty( $icon ) ) {
	$this->add_render_attribute( 'icon', 'class', 'aheto-content-block__ico aheto-content-block__ico--lg icon' );
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
	wp_enqueue_style( 'features-single-style-6', $sc_dir . 'assets/css/layout6.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-content-block__desc">

		<?php
		// Icon.
		if ( ! empty( $icon ) ) {
			echo '<i ' . $this->get_render_attribute_string( 'icon' ) . '></i>';
		}

		if ( ! empty( $s_heading ) ) : ?>
            <h5 class="aheto-content-block__title"><?php echo $this->highlight_text( $s_heading ); ?></h5>
		<?php endif; ?>

		<?php if ( ! empty( $s_description ) ) : ?>
            <p class="aheto-content-block__info">
				<?php echo wp_kses_post( $s_description ); ?>
            </p>
		<?php endif; ?>

    </div>

</div>
