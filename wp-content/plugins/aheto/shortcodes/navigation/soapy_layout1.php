<?php
/**
 * Header Modern Menu.
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $menus ) ) {
	return;
}

$this->generate_css();

if ( isset( $mobile_menu_width ) && is_array( $mobile_menu_width ) && ! empty( $mobile_menu_width['size'] ) ) {
	$mobile_menu_width = $mobile_menu_width['size'];
} elseif ( ! isset( $mobile_menu_width ) || ! is_array( $mobile_menu_width ) || empty( $mobile_menu_width['size'] ) ) {
	$mobile_menu_width = 1199;
}

$type_logo   = isset( $type_logo ) && ! empty( $type_logo ) ? $type_logo : 'image';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'main-header--soapy-classic' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header-js' );
$this->add_render_attribute( 'wrapper', 'data-mobile-menu', $mobile_menu_width );


if ( $type_logo == 'image' && is_array( $scroll_logo ) && is_array( $scroll_mob_logo ) ) {

	$scroll_logo     = ! empty( $scroll_logo['id'] ) ? $scroll_logo : $logo;
	$scroll_mob_logo = ! empty( $scroll_mob_logo['id'] ) ? $scroll_mob_logo : $mob_logo;

} elseif ( $type_logo == 'image' && ! is_array( $scroll_logo ) && ! is_array( $scroll_mob_logo ) ) {

	$scroll_logo     = isset( $scroll_logo ) && ! empty( $scroll_logo ) ? $scroll_logo : $logo;
	$scroll_mob_logo = isset( $scroll_mob_logo ) && ! empty( $scroll_mob_logo ) ? $scroll_mob_logo : $mob_logo;

}

$button = $this->get_button_attributes( 'main' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-navigation-layout1', $shortcode_dir . 'assets/css/soapy_layout1.css', null, null);
}


?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="main-header__main-line">
        <div class="aheto-logo main-header__logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( ! empty( $logo ) && $type_logo == 'image' ) {
					echo Helper::get_attachment( $logo, [ 'class' => 'aheto-logo__image' ] );
				}
				if ( ! empty( $scroll_logo ) && $type_logo == 'image' ) {
					echo Helper::get_attachment( $scroll_logo, [ 'class' => 'aheto-logo__image aheto-logo__image-scroll' ] );
				}

				if ( ! empty( $mob_logo ) && $type_logo == 'image' ) {
					echo Helper::get_attachment( $mob_logo, [ 'class' => 'aheto-logo__image mob-logo' ] );
				}

				if ( ! empty( $scroll_mob_logo ) && $type_logo == 'image' ) {
					echo Helper::get_attachment( $scroll_mob_logo, [ 'class' => 'aheto-logo__image mob-logo aheto-logo__image-mob-scroll' ] );
				}


				if ( ! empty( $text_logo ) && $type_logo == 'text' ) { ?>
                    <span><?php echo esc_html( $text_logo ); ?></span>
				<?php } ?>
            </a>
        </div>
        <div class="main-header__menu-box">

            <span class="mobile-menu-title"><?php esc_html_e('Menu', 'soapy'); ?></span>

			<?php

			wp_nav_menu( [
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline',
				'menu'            => $menus,
			] );
			?>

            <div class="main-header__widget-box-mobile">
				<?php if ( $mini_cart && ! is_admin() && function_exists( 'WC' ) ) : ?>
					<div class="icons-widget__item">
						<a class="icons-widget__link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
							<i class="icon ion-bag" aria-hidden="true"></i>
							<span class="button-number"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
						</a>
					</div>
				<?php endif;?>

				<?php if ( $search == true) : ?>
					<div class="icons-widget__item">
						<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>"
							  autocomplete="off">
							<div class="input-group">
								<input type="search" value="" name="s" class="search-field"
									   placeholder="<?php esc_attr_e( 'Enter Keyword', 'soapy' ); ?>" required="">
							</div>
						</form>
					</div>
				<?php endif; ?>

            </div>
        </div>
        <div class="main-header__widget-box">
			<ul class="icons-widget main-header__icons">
			<?php if ( $search == true ) : ?>
				<li class="icons-widget__item main-header__widget-box-desktop">
					<a class="icons-widget__link search-btn js-open-search" href="#">
						<i class="icon ion-ios-search-strong" aria-hidden="true"></i>
					</a>
				</li>
			<?php endif; ?>
			<?php if ( $mini_cart && ! is_admin() && function_exists( 'WC' ) ) : ?>
				<li class="icons-widget__item main-header__widget-box-desktop">
					<a class="icons-widget__link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
						<i class="icon ion-bag" aria-hidden="true"></i>
						<span class="button-number"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
					</a>
				</li>
			<?php elseif ( $mini_cart &&  is_admin() && function_exists( 'WC' )):?>
				<li class="icons-widget__item main-header__widget-box-desktop">
					<a class="icons-widget__link" href="#">
						<i class="icon ion-bag" aria-hidden="true"></i>
						<span class="button-number">5</span>
					</a>
				</li>
			<?php endif; ?>
			</ul>
            <button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
</div>
