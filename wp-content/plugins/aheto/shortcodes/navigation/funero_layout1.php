<?php
/**
 * Header Funero Menu.
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
$this->add_render_attribute( 'wrapper', 'class', 'main-header' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header--funero-main' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header-js' );
$this->add_render_attribute( 'wrapper', 'class', $transparent );
$this->add_render_attribute( 'wrapper', 'data-mobile-menu', $mobile_menu_width );
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-navigation-layout1', $shortcode_dir . 'assets/css/funero_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('funero-navigation-js-layout1', $shortcode_dir . 'assets/js/funero_layout1.min.js', array('jquery'), null);
}

$type_logo = isset( $type_logo ) && !empty( $type_logo ) ? $type_logo : 'image';

$menu_right = isset( $funero_menu_right ) && $funero_menu_right == true ? 'main-header__menu-right' : '';

$button = $this->get_button_attributes( 'main' );


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

				if ( ! empty( $text_logo ) && $type_logo == 'text' ) { ?>
					<span><?php echo esc_html( $text_logo ); ?></span>
				<?php } ?>
            </a>

        </div>

        <div class="main-header__menu-box  <?php echo esc_attr($menu_right);?>">
			<span class="mobile-menu-title"><?php esc_html_e('Menu', 'funero'); ?></span>

            <?php
            wp_nav_menu([
                'container' => 'nav',
                'container_class' => 'menu-home-page-container',
                'menu_class' => 'main-menu main-menu--inline',
                'menu' => $menus,
            ]);
            ?>

            <div class="main-header__widget-box-mobile">
                <?php if ($search == true) : ?>
						<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>"
							  autocomplete="off">
							<div class="input-group">
								<input type="search" value="" name="s" class="search-field"
									   placeholder="<?php esc_attr_e( 'Enter Keyword', 'funero' ); ?>" required="">
							</div>
						</form>
                <?php endif; ?>

            </div>
        </div>

        <div class="main-header__widget-box main-header__widget-box-d">

            <div class="main-header__widget-box-desktop">
                <?php if ($search == true) : ?>

                    <a class="main-header__widget-box--search search-btn js-open-search" href="#">
                        <i class="icon ion-ios-search-strong" aria-hidden="true"></i>
                    </a>

                <?php endif; ?>

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

                        <div class="desk-menu">
                            <?php
                            wp_nav_menu([
                                'container' => 'nav',
                                'container_class' => 'desk-menu__container',
                                'menu' => $funero_desk_menu,
                                'depth' => '1'
                            ]);
                            ?>
                        </div>
                        <div class="desk-menu__search-wrap">
                            <!-- SEARCH -->
                            <form role="search" class="w-800" method="get" id="searchform"
                                  action="<?php echo home_url('/'); ?>">
                                <label class="screen-reader-text" for="s"><?php esc_attr_e( 'Search:', 'funero' ); ?> </label>
                                <input type="text" value="" name="s" id="s"
                                       placeholder="Enter Keyword"/>

                                <button type="submit" id="searchsubmit" class="search-subm">
                                    <i class="icon ion-ios-search-strong" aria-hidden="true"></i>
                                </button>
                            </form>
                            <div class="desk-menu__search_descr"><?php esc_attr_e( 'Input your search keywords and press Enter', 'funero' ); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
