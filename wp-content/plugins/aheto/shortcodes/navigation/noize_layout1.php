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
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', $transparent );
$this->add_render_attribute( 'wrapper', 'class', 'main-header' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header--noize-modern' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header-js' );
$this->add_render_attribute( 'wrapper', 'data-mobile-menu', $mobile_menu_width );

$type_logo = isset($type_logo) && !empty($type_logo) ? $type_logo : 'image';

if ( $type_logo == 'image' && is_array( $scroll_logo ) && is_array( $scroll_mob_logo ) ) {

    $scroll_logo     = ! empty( $scroll_logo['id'] ) ? $scroll_logo : $logo;
    $scroll_mob_logo = ! empty( $scroll_mob_logo['id'] ) ? $scroll_mob_logo : $mob_logo;

} elseif ( $type_logo == 'image' && ! is_array( $scroll_logo ) && ! is_array( $scroll_mob_logo ) ) {

    $scroll_logo     = isset( $scroll_logo ) && ! empty( $scroll_logo ) ? $scroll_logo : $logo;
    $scroll_mob_logo = isset( $scroll_mob_logo ) && ! empty( $scroll_mob_logo ) ? $scroll_mob_logo : $mob_logo;

}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'noize-navigation-layout1', $shortcode_dir . 'assets/css/noize_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="main-header__main-line">
        <div class="aheto-logo main-header__logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php if ( ! empty( $noize_logo ) && $type_logo == 'image' ) {
                    echo Helper::get_attachment( $noize_logo, [ 'class' => 'aheto-logo__image' ] );
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

            <?php if ( ! empty( $noize_menu_title) ) { ?>
                <h6 class="main-header__menu-title"><?php echo wp_kses($noize_menu_title, 'post') ?></h6>
            <?php } ?>

            <?php
                wp_nav_menu([
                    'container'       => 'nav',
                    'container_class' => 'menu-home-page-container',
                    'menu_class'      => 'main-menu main-menu--inline',
                    'menu'            => $menus,
                ]);
            ?>

            <?php $networks = $this->parse_group( $networks );

            if ( ! empty( $networks ) ) { ?>
                <div class="main-header__menu-social-mob">
                    <?php echo Helper::get_social_networks( $networks, '<a class="main-header__social-icon" href="%1$s"><i class="ion-social-%2$s"></i></a>' ); ?>
                </div>
            <?php } ?>

        </div>
        <div class="main-header__widget-box">

            <?php $networks = $this->parse_group( $networks );
                if ( ! empty( $networks ) ) {
                    echo Helper::get_social_networks( $networks, '<a class="main-header__icon" href="%1$s"><i class="ion-social-%2$s"></i></a>' );
                }
            ?>

            <button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>

        </div>
    </div>
</div>
