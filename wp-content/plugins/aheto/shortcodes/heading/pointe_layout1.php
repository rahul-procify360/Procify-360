<?php

/**
 * The Heading Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */
use Aheto\Helper;

extract($atts);

$this->generate_css();


// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-heading--awards-pointe');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */

$sc_dir = aheto()->plugin_url() . 'shortcodes/heading/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('heading-layout1', $sc_dir . 'assets/css/pointe_layout1.css', null, null);
}

if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('typed');
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if (!empty($pointe_heading)) { ?>
		<h1 class="aheto-heading__title"><?php echo wp_kses_post($pointe_heading); ?></h1>
	<?php } ?>

</div>
