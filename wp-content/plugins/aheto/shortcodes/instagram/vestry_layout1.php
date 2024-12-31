<?php

/**
 * Instagram templates.
 *
 */

use Aheto\Helper;

extract($atts);

if (empty($token) || empty($username)) {
	return;
}

$this->generate_css();


$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-instagram');
$this->add_render_attribute('wrapper', 'class', 'aheto-instagram--vestry-list');

$this->add_render_attribute('instagram', 'class', 'aheto-instagram__list');
$this->add_render_attribute('instagram', 'class', 'vestry-instagram');
$this->add_render_attribute('instagram', 'data-token', $token);
$this->add_render_attribute('instagram', 'data-size', $size);
$this->add_render_attribute('instagram', 'data-max', $limit);
$this->add_render_attribute('instagram', 'data-id', $atts['_id']);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/instagram/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'vestry-instagram-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('vestry-instagram-layout1-js', $shortcode_dir . 'assets/js/vestry_layout1.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<ul <?php $this->render_attribute_string('instagram'); ?>></ul>
</div>
