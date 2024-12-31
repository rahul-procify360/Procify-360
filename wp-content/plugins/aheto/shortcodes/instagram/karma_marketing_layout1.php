<?php
/**
 * About default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */

use Aheto\Helper;

extract($atts);

if ( empty($token) || empty ($username) ) {
	return;
}

$this->generate_css();

$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-instagram--karma-marketing-layout1');

$this->add_render_attribute('instagram', 'class', 'aheto-instagram__list');
$this->add_render_attribute('instagram', 'class', 'js-instagram');
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
    wp_enqueue_style( 'karma_marketing-instagram-layout1', $shortcode_dir . 'assets/css/karma_marketing_layout1.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('karma_marketing-instagram-layout1-js', $shortcode_dir . 'assets/js/karma_marketing_layout1.js', array('jquery'), null);
}
?>


<div <?php $this->render_attribute_string('wrapper'); ?>>

	<ul <?php $this->render_attribute_string('instagram'); ?>></ul>

    <?php if ( !empty( $username ) ) { ?>
        <div class="aheto-instagram__username">Instagram: <a href="<?php echo esc_url('https://www.instagram.com/'.$username); ?>" target="_blank" rel="noreferrer noopener"><?php echo esc_html($username); ?></a></div>
    <?php } ?>

</div>
