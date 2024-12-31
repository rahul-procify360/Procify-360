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
$this->add_render_attribute('wrapper', 'id', 'sterling-header');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'main-header');
$this->add_render_attribute('wrapper', 'class', 'main-header--sterling');
$this->add_render_attribute('wrapper', 'class', 'main-header-js');
$this->add_render_attribute('wrapper', 'class', $transparent);

$type_logo = isset($type_logo) && !empty($type_logo) ? $type_logo : 'image';

if ($type_logo == 'image' && is_array($scroll_logo)) {

	$scroll_logo     = !empty($scroll_logo['id']) ? $scroll_logo : $logo;
} elseif ($type_logo == 'image' && !is_array($scroll_logo)) {
	$scroll_logo     = isset($scroll_logo) && !empty($scroll_logo) ? $scroll_logo : $logo;
}

$button = $this->get_button_attributes('main');
$add_button = $this->get_button_attributes('add');

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-navigation', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('sterling-navigation-js', $sc_dir . 'assets/js/sterling_layout1.min.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="main-header__main-line">
		<div class="main-header__widget-box">
			<?php if (!empty($networks)) {
				echo Helper::get_social_networks($networks, '<a class="main-header__icon" href="%1$s"><i class="ion-social-%2$s"></i></a>');
			} ?>
		</div>
		<div class="main-header__menu-box">
			<?php
			wp_nav_menu([
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline',
				'menu'            => $menus,
			]);
			?>
		</div>
		<div class="aheto-logo main-header__logo">
			<a href="<?php echo esc_url(home_url('/')); ?>">
				<?php if (!empty($logo) && $type_logo == 'image') {
					echo Helper::get_attachment($logo, ['class' => 'aheto-logo__image']);
				}
				if (!empty($scroll_logo) && $type_logo == 'image') {
					echo Helper::get_attachment($scroll_logo, ['class' => 'aheto-logo__image aheto-logo__image-scroll']);
				}
				if (!empty($text_logo) && $type_logo == 'text') { ?>
					<span><?php echo esc_html($text_logo); ?></span>
				<?php } ?>
			</a>
		</div>
		<div class="main-header__menu-box">
			<?php
			wp_nav_menu([
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline main-menu--right',
				'menu'            => $sterling_menus_right,
			]);
			?>
		</div>
		<div class="main-header__widget-box">
			<ul class="icons-widget main-header__icons">
				<?php if ($search == true) : ?>
					<li class="icons-widget__item main-header__widget-box-desktop">
						<a class="icons-widget__link search-btn js-open-search" href="javascript:void(0);">
							<i class="icon ion-ios-search-strong" aria-hidden="true"></i>
						</a>
					</li>
				<?php endif; ?>
				<?php if ($mini_cart && !is_admin() && function_exists('WC')) : ?>
					<li class="icons-widget__item main-header__widget-box-desktop">
						<a class="icons-widget__link" href="<?php echo esc_url(wc_get_cart_url()); ?>">
							<i class="icon ion-ios-cart" aria-hidden="true"></i>
							<!-- <span class="button-number"><?php echo WC()->cart->get_cart_contents_count(); ?></span> -->
						</a>
					</li>
				<?php elseif ($mini_cart &&  is_admin() && function_exists('WC')) : ?>
					<li class="icons-widget__item main-header__widget-box-desktop">
						<a class="icons-widget__link" href="javascript:void(0);">
							<i class="icon ion-ios-cart" aria-hidden="true"></i>
							<!-- <span class="button-number">5</span> -->
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>
