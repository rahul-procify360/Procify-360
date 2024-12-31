<?php
use Aheto\Helper;
/**
 * Menu list.
 */

extract($atts);

if (empty($menus)) {
	return;
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'list-menu--sterling');
$this->add_render_attribute('nav', 'class', 'widget-footer-menu');

/**
 * Set dependent style
 */

$sc_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-navigation-footer', $sc_dir . 'assets/css/sterling_layout3.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('nav'); ?>>
		<?php wp_nav_menu([
			'container' => 'div',
			'items_wrap' => '<ul id="%1$s" class="%2$s widget-footer-menu__menu">%3$s</ul>',
			'container_class' => 'menu-footer-container',
			'menu_class' => 'main-menu',
			'menu' => $menus,
		]); ?>
	</div>
</div>
