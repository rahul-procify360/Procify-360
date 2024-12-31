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


// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', 'vestry-header' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'main-header' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header--vestry' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header-js' );
$this->add_render_attribute( 'wrapper', 'class', $transparent );
$this->add_render_attribute( 'wrapper', 'data-mobile-menu', $mobile_menu_width );


$type_logo = isset( $type_logo ) && ! empty( $type_logo ) ? $type_logo : 'image';

if ( $type_logo == 'image' && is_array( $scroll_logo ) ) {

	$scroll_logo = ! empty( $scroll_logo['id'] ) ? $scroll_logo : $logo;
} elseif ( $type_logo == 'image' && ! is_array( $scroll_logo ) ) {
	$scroll_logo = isset( $scroll_logo ) && ! empty( $scroll_logo ) ? $scroll_logo : $logo;
}

$button     = $this->get_button_attributes( 'main' );
$add_button = $this->get_button_attributes( 'add' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'vestry-navigation-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('vestry-navigation-layout1-js', $shortcode_dir . 'assets/js/vestry_layout1.js', array('jquery'), null);
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="main-header__main-line">
        <div class="main-header__widget-box">
            <button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
            </button>
        </div>
        <div class="main-header__menu-box left-menu">
			<?php
			wp_nav_menu( [
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline main-menu-left',
				'menu'            => $menus,
			] );
			?>
        </div>
        <div class="aheto-logo main-header__logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( ! empty( $logo ) && $type_logo == 'image' ) {
					echo Helper::get_attachment( $logo, [ 'class' => 'aheto-logo__image' ] );
				}
				if ( ! empty( $scroll_logo ) && $type_logo == 'image' ) {
					echo Helper::get_attachment( $scroll_logo, [ 'class' => 'aheto-logo__image aheto-logo__image-scroll' ] );
				}
				if (!empty($mob_logo) && $type_logo == 'image') {
					echo Helper::get_attachment($mob_logo, ['class' => 'aheto-logo__image mob-logo']);
				}
				if (!empty($scroll_mob_logo) && $type_logo == 'image') {
					echo Helper::get_attachment($scroll_mob_logo, ['class' => 'aheto-logo__image mob-logo aheto-logo__image-mob-scroll']);
				}
				if ( ! empty( $text_logo ) && $type_logo == 'text' ) { ?>
                    <span><?php echo esc_html( $text_logo ); ?></span>
				<?php } ?>
            </a>
        </div>
        <div class="main-header__menu-box">
			<?php
			wp_nav_menu( [
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline',
				'menu'            => $vestry_menus_right,
			] );
			?>
        </div>
        <div class="main-header__menu-box mobile-menu">
            <span class="mobile-menu-title"><?php esc_html_e( 'Menu', 'aheto' ); ?></span>
            <div class="main-header__widget-box-mobile"></div>
			<?php
			wp_nav_menu( [
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline',
				'menu'            => $menus,
			] );

			wp_nav_menu( [
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline',
				'menu'            => $vestry_menus_right,
			] );

			?>
        </div>
    </div>
</div>
