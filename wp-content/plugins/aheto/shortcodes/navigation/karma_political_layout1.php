<?php
/**
 * Time Schedule default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $menus ) || empty( $karma_political_menus_second ) ) {
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

// Nav.
$this->add_render_attribute( 'nav', 'class', 'main-header');
$this->add_render_attribute( 'nav', 'data-mobile-menu', $mobile_menu_width );
$this->add_render_attribute( 'nav', 'class', 'main-header--karma-political__menu' );
$this->add_render_attribute( 'title', 'class', 'main-header__title' );

$type_logo = isset( $type_logo ) && ! empty( $type_logo ) ? $type_logo : 'image';


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'karma-political-navigation-layout1', $shortcode_dir . 'assets/css/karma_political_layout1.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('karma-navigation-js', $shortcode_dir . 'assets/js/karma_layout1.min.js', array('jquery'), null);
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div <?php $this->render_attribute_string( 'nav' ); ?>>

		<div class="aheto-logo main-header__moblogo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="main-header__logo-wrap">
                <?php
                    if ( ! empty( $logo ) && $type_logo == 'image' ) {
                        echo Helper::get_attachment( $logo, [ 'class' => 'aheto-logo__image-mob' ] );
                    }

                    if ( ! empty( $mob_logo ) && $type_logo == 'image' ) {
                        echo Helper::get_attachment( $mob_logo, [ 'class' => 'aheto-logo__image-mob mob-logo' ] );
                    }
                ?>
            </a>

            <?php if ( ! empty( $label_logo ) ) { ?>
                <span class="main-header__logo-mob-label">
                    <?php echo esc_html( $label_logo ); ?>
                </span>
            <?php } ?>
        </div>

		<?php
			$networks = $this->parse_group( $networks );

			if ( ! empty( $networks ) ) {
		?>
			<div class="main-header__soc">
				<?php echo Helper::get_social_networks( $networks, '<a class="main-header__icon" href="%1$s"><i class="ion-social-%2$s"></i></a>' ); ?>
			</div>
		<?php } ?>

		<div class="main-header__menu-box">
            <span class="mobile-menu-title"><?php esc_html_e( 'Menu', 'aheto' ); ?></span>
		    <div class="main-header__menu-overflow">
		        <div class="main-header__menu-scrollbar">

                    <?php wp_nav_menu([
                        'container'       => 'div',
                        'items_wrap'      => '<ul id="%1$s" class="%2$s main-header__menu">%3$s</ul>',
                        'container_class' => 'menu-main-container menu-home-page-container',
                        'menu_class'      => 'main-menu main-menu--inline menu',
                        'menu'            => $menus,
                    ]); ?>

                    <div class="aheto-logo main-header__logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="main-header__logo-wrap">
                            <?php
                                if ( ! empty( $logo ) && $type_logo == 'image' ) {
                                    echo Helper::get_attachment( $logo, [ 'class' => 'aheto-logo__image' ] );
                                }

                                if ( ! empty( $mob_logo ) && $type_logo == 'image' ) {
                                    echo Helper::get_attachment( $mob_logo, [ 'class' => 'aheto-logo__image mob-logo mob-logo' ] );
                                }
                            ?>
                        </a>

                        <?php if ( ! empty( $label_logo ) ) { ?>
                            <span class="main-header__logo-label">
                                <?php echo esc_html( $label_logo ); ?>
                            </span>
                        <?php } ?>
                    </div>

                    <?php wp_nav_menu([
                        'container'       => 'div',
                        'items_wrap'      => '<ul id="%1$s" class="%2$s main-header__menu">%3$s</ul>',
                        'container_class' => 'menu-main-container',
                        'menu_class'      => 'menu',
                        'menu'            => $karma_political_menus_second,
                    ]); ?>

                </div>
            </div>

            <?php wp_nav_menu([
                'container'       => 'div',
                'items_wrap'      => '<ul id="%1$s" class="%2$s main-header__menu">%3$s</ul>',
                'container_class' => 'menu-main-container mob-menu',
                'menu_class'      => 'menu main-menu main-menu--inline',
                'menu'            => $menus,
            ]); ?>


            <?php wp_nav_menu([
                'container'       => 'div',
                'items_wrap'      => '<ul id="%1$s" class="%2$s main-header__menu">%3$s</ul>',
                'container_class' => 'menu-main-container mob-menu',
                'menu_class'      => 'menu main-menu main-menu--inline',
                'menu'            => $karma_political_menus_second,
            ]); ?>

        </div>

        <div class="main-header__box">
            <?php $this->the_wpml_lang_switcher(); ?>

            <ul class="icons-widget main-header__icons">
                <?php if ( $karma_political_shop_account && ! is_admin() && function_exists( 'WC' ) ) : ?>
                    <li class="icons-widget__item">
                        <a class="icons-widget__link" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
                            <i class="icon ion-android-person" aria-hidden="true"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ( $search ) : ?>
                    <li class="icons-widget__item">
                        <a class="icons-widget__link search-btn js-open-search" href="#">
                            <i class="icon ion-ios-search-strong" aria-hidden="true"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ( $mini_cart && ! is_admin() && function_exists( 'WC' ) ) : ?>
                    <?php $cart = wc_get_cart_url(); ?>
                    <li class="icons-widget__item">
                        <a class="icons-widget__link" href="<?php echo esc_url( $cart ); ?>">
                            <i class="icon ion-bag" aria-hidden="true"></i>
                            <span class="button-number"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
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
