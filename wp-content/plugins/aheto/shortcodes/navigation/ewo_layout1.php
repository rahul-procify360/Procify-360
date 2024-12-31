<?php

/**
 * Header Modern Menu.
 */

use Aheto\Helper;

extract($atts);

if (empty($menus)) {
	return;
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'main-header--simple-ewo');
$this->add_render_attribute('wrapper', 'class', 'main-header-js');
$this->add_render_attribute('wrapper', 'class', $transparent);

/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('ewo-navigation-layout1', $shortcode_dir . 'assets/css/ewo_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="main-header__main-line">
		<div class="main-header__menu-box">
			<?php
			wp_nav_menu([
				'container' => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class' => 'main-menu main-menu--inline',
				'menu' => $menus,
			]);
			?>
		</div>
	</div>
</div>
