<?php
/**
 * Time Schedule default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

$outsourceo_fixed_menu = isset($outsourceo_fixed_menu) && $outsourceo_fixed_menu ? 'fixed-additional' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-navbar--outsourceo-additional');
$this->add_render_attribute('wrapper', 'class', $outsourceo_fixed_menu);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navbar/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('outsourceo-navbar-layout2', $shortcode_dir . 'assets/css/outsourceo_layout2.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('outsourceo-navbar-layout2-js', $shortcode_dir . 'assets/js/outsourceo_layout2.js', array('jquery'), null);
} ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-navbar--inner">

		<?php wp_nav_menu([
			'container' => 'div',
			'items_wrap' => '<ul id="%1$s" class="%2$s widget-nav-menu__menu">%3$s</ul>',
			'container_class' => 'aheto-navbar--outsourceo-menu-additional ' . $outsourceo_transparent,
			'menu_class' => 'menu',
			'menu' => $outsourceo_menus,
		]); ?>

	</div>
</div>

