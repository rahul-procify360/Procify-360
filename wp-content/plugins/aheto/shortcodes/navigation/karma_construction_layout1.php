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


if (isset($mobile_menu_width) && is_array($mobile_menu_width) && !empty($mobile_menu_width['size'])) {
	$mobile_menu_width = $mobile_menu_width['size'];
} elseif (!isset($mobile_menu_width) || !is_array($mobile_menu_width) || empty($mobile_menu_width['size'])) {
	$mobile_menu_width = 1199;
}


// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'main-header main-header--karma-construction1');
$this->add_render_attribute('wrapper', 'data-mobile-menu', $mobile_menu_width);

$type_logo = isset($type_logo) && !empty($type_logo) ? $type_logo : 'image';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_construction-navigation-layout1', $shortcode_dir . 'assets/css/karma_construction_layout1.css', null, null);
}

// Icon.
$icon_phone = $this->get_icon_attributes('karma_construction_phone_', true, true);
if (!empty($icon_phone)) {
	$this->add_render_attribute('karma_construction_phone_icon', 'class', 'aheto-content-block__ico icon');
	$this->add_render_attribute('karma_construction_phone_icon', 'class', $icon_phone['icon']);
	if (!empty($icon_phone['color'])) {
		$this->add_render_attribute('karma_construction_phone_icon', 'style', 'color:' . $icon_phone['color'] . ';');
	}
	if (!empty($icon_phone['font_size'])) {
		$this->add_render_attribute('karma_construction_phone_icon', 'style', 'font-size:' . $icon_phone['font_size'] . ';');
	}
}
$icon_address = $this->get_icon_attributes('karma_construction_address_', true, true);
if (!empty($icon_address)) {
	$this->add_render_attribute('karma_construction_address_icon', 'class', 'aheto-content-block__ico icon');
	$this->add_render_attribute('karma_construction_address_icon', 'class', $icon_address['icon']);
	if (!empty($icon_address['color'])) {
		$this->add_render_attribute('karma_construction_address_icon', 'style', 'color:' . $icon_address['color'] . ';');
	}
	if (!empty($icon_address['font_size'])) {
		$this->add_render_attribute('karma_construction_address_icon', 'style', 'font-size:' . $icon_address['font_size'] . ';');
	}
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="main-header__main-line">
		<div class="container">
			<div class="main-header__main-row">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="aheto-logo main-header__logo">
					<?php if (!empty($logo) && $type_logo == 'image') {
						echo Helper::get_attachment($logo, ['class' => 'aheto-logo__image']);
					}

					if (!empty($text_logo) && $type_logo == 'text') { ?>
						<span><?php echo esc_html($text_logo); ?></span>
					<?php } ?>
				</a>
				<div class="main-header__details">
					<div class="main-header__details-item">
						<?php if ($icon_phone == true) : ?>
							<?php echo '<i ' . $this->get_render_attribute_string('karma_construction_phone_icon') . ' ></i>'; ?>
						<?php endif; ?>
						<div class="main-header__details-text">

							<?php if (!empty($karma_construction_phone_title)) : ?>
								<div class="main-header__details-title">
									<?php echo esc_html($karma_construction_phone_title); ?>
								</div>
							<?php endif;
							if (!empty($karma_construction_phone)) : ?>
								<?php $tel_phone = str_replace(" ", "", $karma_construction_phone); ?>
								<a href="tel:<?php echo esc_attr($tel_phone); ?>"><?php echo esc_html($karma_construction_phone); ?></a>
							<?php endif; ?>
						</div>
					</div>
					<div class="main-header__details-item">
						<?php if ($icon_address == true) : ?>
							<?php echo '<i ' . $this->get_render_attribute_string('karma_construction_address_icon') . ' ></i>'; ?>
						<?php endif; ?>
						<div class="main-header__details-text">

							<?php if (!empty($karma_construction_address_title)) : ?>
								<div class="main-header__details-title">
									<?php echo esc_html($karma_construction_address_title); ?>
								</div>
							<?php endif;
							if (!empty($karma_construction_address)) : ?>
								<p href="tel:<?php echo esc_attr($tel_phone); ?>"><?php echo esc_html($karma_construction_address); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="main-header__widget-box">
					<?php $this->the_wpml_lang_switcher(); ?>
					<ul class="icons-widget main-header__icons">
						<?php if ($search) : ?>
							<li class="icons-widget__item">
								<a class="icons-widget__link search-btn js-open-search" href="#">
									<i class="icon ion-ios-search-strong" aria-hidden="true"></i>
								</a>
							</li>
						<?php endif; ?>
						<?php if ($mini_cart && !is_admin() && function_exists('WC')) : ?>
							<li class="icons-widget__item">
								<?php $cart = wc_get_cart_url() ?>
								<a class="icons-widget__link" href="<?php echo esc_url($cart); ?>">
									<i class="icon ion-ios-cart" aria-hidden="true"></i>
									<span
										class="button-number"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="main-header__bottom-line  main-header-js">
			<div class="main-header__logo-on-scroll">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="aheto-logo main-header__logo">
					<?php if (!empty($logo) && $type_logo == 'image') {
						echo Helper::get_attachment($logo, ['class' => 'aheto-logo__image']);
					}

					if (!empty($text_logo) && $type_logo == 'text') { ?>
						<span><?php echo esc_html($text_logo); ?></span>
					<?php } ?>
				</a>
			</div>
			<div class="main-header__menu-box">
				<span class="mobile-menu-title"><?php esc_html_e('Menu', 'aheto'); ?></span>

				<?php
				wp_nav_menu([
					'container' => 'nav',
					'container_class' => 'menu-home-page-container',
					'menu_class' => 'main-menu main-menu--inline',
					'menu' => $menus,
				]);
				?>

				<div class="main-header__details main-header__details-mobile">
					<div class="main-header__details-item">
						<?php if ($icon_phone == true) : ?>
							<?php echo '<i ' . $this->get_render_attribute_string('karma_construction_phone_icon') . ' ></i>'; ?>
						<?php endif; ?>
						<div class="main-header__details-text">

							<?php if (!empty($karma_construction_phone_title)) : ?>
								<div class="main-header__details-title">
									<?php echo esc_html($karma_construction_phone_title); ?>
								</div>
							<?php endif;
							if (!empty($karma_construction_phone)) : ?>
								<?php $tel_phone = str_replace(" ", "", $karma_construction_phone); ?>
								<a href="tel:<?php echo esc_attr($tel_phone); ?>"><?php echo esc_html($karma_construction_phone); ?></a>
							<?php endif; ?>
						</div>
					</div>
					<div class="main-header__details-item">
						<?php if ($icon_address == true) : ?>
							<?php echo '<i ' . $this->get_render_attribute_string('karma_construction_address_icon') . ' ></i>'; ?>
						<?php endif; ?>
						<div class="main-header__details-text">

							<?php if (!empty($karma_construction_address_title)) : ?>
								<div class="main-header__details-title">
									<?php echo esc_html($karma_construction_address_title); ?>
								</div>
							<?php endif;
							if (!empty($karma_construction_address)) : ?>
								<p href="tel:<?php echo esc_attr($tel_phone); ?>"><?php echo esc_html($karma_construction_address); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="main-header__widget-box main-header__widget-box-mobile">
					<?php $this->the_wpml_lang_switcher(); ?>
					<ul class="icons-widget main-header__icons">
						<?php if ($search) : ?>
							<li class="icons-widget__item">
								<a class="icons-widget__link search-btn js-open-search" href="#">
									<i class="icon ion-ios-search-strong" aria-hidden="true"></i>
								</a>
							</li>
						<?php endif; ?>
						<?php if ($mini_cart && !is_admin() && function_exists('WC')) : ?>
							<li class="icons-widget__item">
								<?php $cart = wc_get_cart_url(); ?>
								<a class="icons-widget__link" href="<?php echo esc_url($cart); ?>">
									<i class="icon ion-ios-cart" aria-hidden="true"></i>
									<span
										class="button-number"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
			</button>
			<div class="main-header__widget-on-scroll">
				<?php $this->the_wpml_lang_switcher(); ?>
				<ul class="icons-widget main-header__icons">
					<?php if ($search) : ?>
						<li class="icons-widget__item">
							<a class="icons-widget__link search-btn js-open-search" href="#">
								<i class="icon ion-ios-search-strong" aria-hidden="true"></i>
							</a>
						</li>
					<?php endif; ?>
					<?php if ($mini_cart && !is_admin() && function_exists('WC')) : ?>
						<li class="icons-widget__item">
							<?php $cart = wc_get_cart_url(); ?>
							<a class="icons-widget__link" href="<?php echo esc_url($cart); ?>">
								<i class="icon ion-ios-cart" aria-hidden="true"></i>
								<span class="button-number"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
