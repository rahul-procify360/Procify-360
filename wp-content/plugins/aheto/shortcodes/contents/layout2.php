<?php
/**
 * The Contents Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', $alignment );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--text-with-icon' );


// Icon.
$icon = $this->get_icon_attributes( '', true, true );
if ( ! empty( $icon ) ) {
	$this->add_render_attribute( 'icon', 'class', 'icon' );
	$this->add_render_attribute( 'icon', 'class', $icon['icon'] );
	if ( ! empty( $icon['color'] ) ) {
		$this->add_render_attribute( 'icon', 'style', 'color:' . $icon['color'] );
	}
}


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'contents-style-2', $sc_dir . 'assets/css/layout2.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	// Icon.
	if ( ! empty( $icon ) ) { ?>
        <div class="aheto-contents__icon">
			<?php echo '<i ' . $this->get_render_attribute_string( 'icon' ) . '></i>'; ?>
        </div>
	<?php }

	if ( $text ) {
		echo '<div class="aheto-contents__text">' . wp_kses_post( $text ) . '</div>';
	}
	?>


</div>
