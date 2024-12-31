<?php
/**
 * About default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $token ) ) {
	return;
}

$this->generate_css();

$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-instagram--funero-list');
$this->add_render_attribute('instagram', 'data-token', $token);
$this->add_render_attribute('instagram', 'data-id', $atts['_id']);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/instagram/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-instagram-layout1', $shortcode_dir . 'assets/css/funero_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('spectragram');
	wp_enqueue_script('funero-instagram-js-layout1', $shortcode_dir . 'assets/js/funero_layout1.min.js', null, null);
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<ul class="aheto-instagram__list js-instagram"
		data-token="<?php echo esc_attr($token); ?>" data-id="<?php echo esc_attr($atts['_id']); ?>"></ul>
	<span class="aheto-instagram__text">.</span>
</div>
