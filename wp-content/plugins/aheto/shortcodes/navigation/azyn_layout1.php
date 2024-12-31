<?php
/**
 * Header azyn Menu.
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
$this->add_render_attribute('wrapper', 'class', 'main-header');
$this->add_render_attribute('wrapper', 'class', 'main-header--azyn-main');
$this->add_render_attribute('wrapper', 'class', 'main-header-js');
$this->add_render_attribute('wrapper', 'class', $transparent);
$this->add_render_attribute('wrapper', 'data-mobile-menu', $mobile_menu_width);
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('azyn-navigation-layout1', $shortcode_dir . 'assets/css/azyn_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('azyn-navigation-js-layout1', $shortcode_dir . 'assets/js/azyn_layout1.min.js', array('jquery'), null);
}
$type_logo = isset($type_logo) && !empty($type_logo) ? $type_logo : 'image';

$menu_right = isset($azyn_menu_right) && $azyn_menu_right == true ? 'main-header__menu-right' : '';

$button = $this->get_button_attributes('main');

$azyn_second_menu = isset($azyn_second_menu) ? $azyn_second_menu : false;
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="main-header__main-line">

		<button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
		</button>

		<div class="aheto-logo main-header__logo">
			<a href="<?php echo esc_url(home_url('/')); ?>">
				<?php if (!empty($logo) && $type_logo == 'image') {
					echo Helper::get_attachment($logo, ['class' => 'aheto-logo__image']);
				}
				if (!empty($scroll_logo) && $type_logo == 'image') {
					echo Helper::get_attachment($scroll_logo, ['class' => 'aheto-logo__image aheto-logo__image-scroll']);
				}
				if (!empty($mob_logo) && $type_logo == 'image') {
					echo Helper::get_attachment($mob_logo, ['class' => 'aheto-logo__image mob-logo']);
				}
				if (!empty($scroll_mob_logo) && $type_logo == 'image') {
					echo Helper::get_attachment($scroll_mob_logo, ['class' => 'aheto-logo__image mob-logo aheto-logo__image-mob-scroll']);
				}

				if (!empty($text_logo) && $type_logo == 'text') { ?>
					<span><?php echo esc_html($text_logo); ?></span>
				<?php } ?>
			</a>

		</div>

		<div class="main-header__menu-box  <?php echo esc_attr($menu_right); ?>"
			 data-back="<?php esc_attr_e('Back', 'deva'); ?>">
			<span class="mobile-menu-title"><?php esc_html_e('Menu', 'azyn'); ?></span>

			<?php
			wp_nav_menu([
				'container' => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class' => 'main-menu main-menu--inline',
				'menu' => $menus,
			]);
			?>
		</div>
		<?php if (!$azyn_second_menu) { ?>
			<div class="main-header__widget-box main-header__widget-box-d">

				<div class="main-header__widget-box-desktop">

					<button class="hamburger main-header__desk-hamburger js-toggle-desk-menu" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
					</button>

					<div class="main-header__desk-menu-wrapper">
						<span class="desk-menu__overlay"></span>
						<!-- MENU ICON -->

						<div class="desk-menu__inner-wrap">
							<div class="desk-menu__close-wrap">

								<div class="desk-menu__close">
									<span class="line"></span>
									<span class="line"></span>
								</div>
							</div>
							<?php if (isset($azyn_logo_desk_image) && $azyn_logo_desk_image) { ?>
								<div class="desk-menu__logo">
									<?php echo Helper::get_attachment($azyn_logo_desk_image, [], 'medium'); ?>
								</div>
							<?php } ?>
							<?php if (isset($azyn_desk_add_image) && $azyn_desk_add_image) { ?>
								<div class="desk-menu__main-image">
									<?php echo Helper::get_attachment($azyn_desk_add_image, [], 'medium'); ?>
								</div>
							<?php } ?>
							<div class="desk-menu">
								<?php
								wp_nav_menu([
									'container' => 'nav',
									'container_class' => 'desk-menu__container',
									'menu' => $azyn_desk_menu,
									'depth' => '1'
								]);
								?>
							</div>
							<?php if (isset($azyn_networks) && !empty($azyn_networks) || isset($azyn_networks_title) && !empty($azyn_networks_title)) { ?>
								<div class="desk-menu__socials">
									<?php if (!empty($azyn_networks_title)) { ?>
										<div class="desk-menu__socials-title">
											<?php echo esc_html($azyn_networks_title); ?>
										</div>
									<?php } ?>
									<?php if (!empty($azyn_networks)) { ?>
										<div class="desk-menu__socials-links">
											<?php echo Helper::get_social_networks($azyn_networks, '<a class="desk-menu__icon" href="%1$s" target="_blank"><i class="ion-social-%2$s"></i></a>'); ?>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
