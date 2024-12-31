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

$moovit_fixed_menu = isset($moovit_fixed_menu) && $moovit_fixed_menu ? 'fixed-additional' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-navbar');
$this->add_render_attribute('wrapper', 'class', 'aheto-navbar--moovit-additional');
$this->add_render_attribute('wrapper', 'class', $moovit_fixed_menu);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navbar/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('moovit-navbar-layout2', $shortcode_dir . 'assets/css/moovit_layout2.css', null, null);
}

if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('moovit-navbar-layout2-js', $shortcode_dir . 'assets/js/moovit_layout2.min.js', array('jquery'), null);
} ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-navbar--inner">

		<?php wp_nav_menu([
			'container' => 'div',
			'items_wrap' => '<ul id="%1$s" class="%2$s widget-nav-menu__menu">%3$s</ul>',
			'container_class' => 'aheto-navbar--moovit-menu-additional ' . $moovit_transparent,
			'menu_class' => 'menu',
			'menu' => $moovit_menus,
		]); ?>

	</div>
</div>

