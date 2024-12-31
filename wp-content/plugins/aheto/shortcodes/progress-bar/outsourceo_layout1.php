<?php
/**
 * The Progress Bar Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', $outsourceo_align );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-counter' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-counter--outsourceo-simple-number' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$outsourceo_use_dot = isset( $outsourceo_use_dot ) && ! empty( $outsourceo_use_dot ) ? 'outsourceo-dot' : '';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-progress-bar-layout1', $shortcode_dir . 'assets/css/outsourceo_layout1.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-counter__number-wrap">
		<?php

		if ( isset( $outsourceo_current ) && ! empty( $outsourceo_current ) ) { ?>
            <h2 class="aheto-counter__current"><?php echo esc_html( $outsourceo_current ); ?></h2>
		<?php }

		// Percentage.
		if ( ! empty( $percentage ) ) {
			echo '<h2 class="aheto-counter__number js-counter ' . esc_attr( $outsourceo_use_dot ) . '">' . absint( $percentage ) . '</h2>';
		}

		if ( isset( $outsourceo_current ) && ! empty( $outsourceo_symbol ) ) { ?>
            <h2 class="aheto-counter__symbol"><?php echo esc_html( $outsourceo_symbol ); ?></h2>
		<?php } ?>
    </div>

	<?php
	// Description.
	if ( ! empty( $description ) ) {
		echo '<h6 class="aheto-counter__desc">' . wp_kses( $description, 'post' ) . '</h6>';
	}
	?>

</div>
