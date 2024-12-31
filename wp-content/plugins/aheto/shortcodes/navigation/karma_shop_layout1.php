<?php
/**
 * Header Classic Mooseoom Menu.
 */

use Aheto\Helper;

extract($atts);

if ( empty($menus) ) {
	return;
}

$this->generate_css();
if ( isset( $mobile_menu_width ) && is_array( $mobile_menu_width ) && ! empty( $mobile_menu_width['size'] ) ) {
	$mobile_menu_width = $mobile_menu_width['size'];
} elseif ( ! isset( $mobile_menu_width ) || ! is_array( $mobile_menu_width ) || empty( $mobile_menu_width['size'] ) ) {
	$mobile_menu_width = 1199;
}
// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'main-header');
$this->add_render_attribute('wrapper', 'class', 'main-header--classic--karma_shop');
$this->add_render_attribute('wrapper', 'class', 'main-header-js');
$this->add_render_attribute( 'wrapper', 'data-mobile-menu', $mobile_menu_width );


$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_shop-navigation-layout1', $shortcode_dir . 'assets/css/karma_shop_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('karma_shop-navigation-layout1-js', $shortcode_dir . 'assets/js/karma_shop_layout1.min.js', array('jquery'), null);
}
$type_logo = isset($type_logo) && !empty($type_logo) ? $type_logo : 'image';
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="main-header__main-line">
		<div class="aheto-logo main-header__logo">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="main-header__logo-wrap">
				<?php if ( !empty($logo) && $type_logo == 'image' ) {
					echo Helper::get_attachment($logo, ['class' => 'aheto-logo__image']);
				}
				if ( !empty($scroll_logo) && $type_logo == 'image' ) {
					echo Helper::get_attachment($scroll_logo, ['class' => 'aheto-logo__image aheto-logo__image-scroll']);
				}

				if ( !empty($mob_logo) && $type_logo == 'image' ) {
					echo Helper::get_attachment($mob_logo, ['class' => 'aheto-logo__image mob-logo']);
				}

				if ( !empty($scroll_mob_logo) && $type_logo == 'image' ) {
					echo Helper::get_attachment($scroll_mob_logo, ['class' => 'aheto-logo__image mob-logo aheto-logo__image-mob-scroll']);
				}

				if ( !empty($text_logo) && $type_logo == 'text' ) { ?>
					<span><?php echo esc_html($text_logo); ?></span>
				<?php } ?>
			</a>
		</div>
		<button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
		</button>
		<div class="main-header__menu-box">
			<span class="btn-close"><i class="ion-android-close"></i></span>
			<?php if ( !empty($mob_logo) && $type_logo == 'image' ) {
				echo Helper::get_attachment($mob_logo, ['class' => 'aheto-logo__image ']);
			} ?>
			<div class="icons-widget__item">
				<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>"
					  autocomplete="off">
					<div class="input-group">
						<input type="search" value="" name="s" class="search-field"
							   placeholder="" required="">
						<input type="submit" value="" class="search-submit">
					</div>
				</form>
			</div>
			<span class="mobile-menu-title"><?php esc_html_e('Menu', 'karma'); ?></span>

			<?php
			wp_nav_menu([
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline',
				'menu'            => $menus,
			]);
			?>
			<?php if ( !is_admin() && function_exists('WC') ) : ?>
				<li class="icons-widget__item icons-widget__item-cart">
					<?php $cart = wc_get_cart_url();?>
					<a class="icons-widget__link" href="<?php echo esc_url($cart); ?>">
						<i class="icon ion-bag" aria-hidden="true"></i>
						<span class="button-number"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
					</a>
				</li>
			<?php endif; ?>
		</div>
		<?php if ( !is_admin() && function_exists('WC') ) : ?>
			<li class="icons-widget__item icons-widget__item-cart">
				<?php $cart = wc_get_cart_url();?>
				<a class="icons-widget__link" href="<?php echo esc_url($cart); ?>">
					<i class="icon ion-bag" aria-hidden="true"></i>
					<span class="button-number"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
				</a>
			</li>
		<?php endif; ?>

	</div>
</div>

