<?php
/**
 * The Contents Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--azyn-link' );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'azyn-contents-layout1', $sc_dir . 'assets/css/azyn_layout1.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<?php $item_link = $this->get_link_attributes( $azyn_url );
	$this->add_render_attribute( 'link', $item_link );
	if ( ! empty( $azyn_text ) && ! empty( $item_link['href'] ) ) : ?>
		<div class="aheto-contents--azyn-link-wrap">
			<a <?php $this->render_attribute_string( 'link' ); ?>><?php echo esc_html( $azyn_text ); ?></a>
		</div>
	<?php endif; ?>
</div>
