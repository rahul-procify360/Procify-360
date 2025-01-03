2<?php
/**
 * Header Modern Menu.
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $menus ) ) {
	return;
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'main-header main-header--karma_business' );

$type_logo = isset( $type_logo ) && ! empty( $type_logo ) ? $type_logo : 'image';
/**
 * Set dependent style
 */
$sc_dir = get_template_directory_uri() . '/aheto/navigation/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style('karma_business-navigation-layout1', $sc_dir . 'assets/css/karma_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="main-header__main-line">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="aheto-logo main-header__logo">
						<?php if ( ! empty( $logo ) && $type_logo == 'image' ) {
							echo Helper::get_attachment( $logo, [ 'class' => 'aheto-logo__image' ] );
						}

						if ( ! empty( $text_logo ) && $type_logo == 'text' ) { ?>
                            <span><?php echo esc_html( $text_logo ); ?></span>
						<?php } ?>
                    </a>
                </div>
                <div class="col-sm-9">
                    <div class="main-header__details">

						<?php if ( ! empty( $address ) ) : ?>
                            <div class="main-header__info">
								<?php echo $this->get_icon_for( 'address' ); ?>
                                <p><?php echo esc_html( $address ); ?></p>
                            </div>
						<?php endif;

						if ( ! empty( $time_schedule ) ) : ?>
                            <div class="main-header__info">
								<?php echo $this->get_icon_for( 'time_schedule' ); ?>
                                <p><?php echo esc_html( $time_schedule ); ?></p>
                            </div>
						<?php endif;

						if ( ! empty( $phone ) ) : ?>
                            <div class="main-header__info">
								<?php echo $this->get_icon_for( 'phone' );
								$tel_phone = str_replace( " ", "", $phone ); ?>
                                <a href="tel:<?php echo esc_attr( $tel_phone ); ?>"><?php echo esc_html( $phone ); ?></a>
                            </div>
						<?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="main-header__menu-box-wrapper container main-header-js">
            <div class="row">
                <div class="col-xl-9 offset-xl-3">
                    <button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                    <div class="main-header__menu-box">
						<?php
						wp_nav_menu( [
							'container'       => 'nav',
							'container_class' => 'menu-home-page-container',
							'menu_class'      => 'main-menu main-menu--inline',
							'menu'            => $menus,
						] );
						?>
                    </div>
                    <div class="main-header__widget-box">
						<?php $this->the_wpml_lang_switcher(); ?>
                        <ul class="icons-widget main-header__icons">
							<?php if ( $search ) : ?>
                                <li class="icons-widget__item">
                                    <a class="icons-widget__link search-btn js-open-search" href="#">
                                        <i class="icon ion-ios-search-strong" aria-hidden="true"></i>
                                    </a>
                                </li>
							<?php endif; ?>
							<?php if ( $mini_cart && ! is_admin() && function_exists( 'WC' ) ) : ?>
                                <li class="icons-widget__item">
                                    <a class="icons-widget__link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
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
    </div>
</div>
