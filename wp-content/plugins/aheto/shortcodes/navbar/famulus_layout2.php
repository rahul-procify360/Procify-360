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

$famulus_fixed_menu = isset($famulus_fixed_menu) && $famulus_fixed_menu ? 'fixed-additional' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-navbar--famulus-additional-row');
$this->add_render_attribute('wrapper', 'class', $famulus_fixed_menu);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navbar/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-navbar-layout2', $shortcode_dir . 'assets/css/famulus_layout2.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('famulus-navbar-layout2-js', $shortcode_dir . 'assets/js/famulus_layout2.js', array('jquery'), null);
} ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-navbar--inner">

		<?php if (!empty($famulus_title)): ?>
			<h5 class="aheto-navbar__title">
				<?php echo esc_html($famulus_title); ?>
			</h5>
		<?php endif; ?>
		<?php wp_nav_menu([
			'container' => 'div',
			'items_wrap' => '<ul id="%1$s" class="%2$s widget-nav-menu__menu">%3$s</ul>',
			'container_class' => 'aheto-navbar--famulus-menu-additional ',
			'menu_class' => 'menu',
			'menu' => $famulus_menus,
		]); ?>

	</div>
</div>

