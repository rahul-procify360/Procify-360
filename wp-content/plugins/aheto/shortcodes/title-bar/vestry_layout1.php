<?php

/**
 * Title bar templates.
 */

use Aheto\Helper;

extract($atts);
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'vestry-breadcrumbs--only');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/title-bar/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('vestry-title-bar-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<ul class="aht-breadcrumbs">
		<li class="aht-breadcrumbs__item">
			<a href="<?php echo esc_url(get_home_url()); ?>"><?php esc_html_e('Home', 'vestry'); ?></a>
		</li>
		<li class="aht-breadcrumbs__item current"><?php echo get_the_title(); ?></li>
	</ul>
</div>
