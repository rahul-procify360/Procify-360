<?php
/**
 * Header Rela Menu.
 */

use Aheto\Helper;

extract($atts);

if (empty($menus)) {
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
$this->add_render_attribute('wrapper', 'class', 'main-header--rela-main');
$this->add_render_attribute('wrapper', 'class', 'main-header-js');
$this->add_render_attribute('wrapper', 'class', $transparent);
$this->add_render_attribute( 'wrapper', 'data-mobile-menu', $mobile_menu_width );

$type_logo = isset($type_logo) && !empty($type_logo) ? $type_logo : 'image';

$button = $this->get_button_attributes('main');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('rela-navigation-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('rela-navigation-layout1-js', $shortcode_dir . 'assets/js/rela_layout1.min.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="main-header__main-line">
        <?php
        if (!empty($scroll_logo) && $type_logo == 'image') {
            echo Helper::get_attachment($scroll_logo, ['class' => 'aheto-logo__image aheto-logo__image-scroll']);
        } ?>
        <div class="main-header__menu-box">

            <?php if (!empty($rela_mob_menu_title)) { ?>
                <div class="main-header__mob_menu_title">
                    <?php echo wp_kses($rela_mob_menu_title, 'post'); ?>
                </div>
            <?php } ?>

            <div class="main-header__widget-box-mobile">
                <?php if ($rela_main_mob_add_button) { ?>
                    <?php echo Helper::get_button($this, $atts, 'rela_main_mob_'); ?>
                <?php } ?>
            </div>

            <?php
            wp_nav_menu([
                'container' => 'nav',
                'container_class' => 'menu-home-page-container',
                'menu_class' => 'main-menu main-menu--inline',
                'menu' => $menus,
            ]);
            ?>
        </div>

        <div class="main-header__widget-box">

            <div class="main-header__widget-box-desktop">
                <?php if ($search) : ?>
                    <div class="main-header__widget-box--search-wrap">
                        <a class="main-header__widget-box--search search-btn js-open-search" href="#">
                            <i class="icon ion-ios-search" aria-hidden="true"></i>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="aheto-logo main-header__logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php
                        if (!empty($logo) && $type_logo == 'image') {
                            echo Helper::get_attachment($logo, ['class' => 'aheto-logo__image']);
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

                <div class="main-header__button-wrap">
                    <?php if ($rela_main_add_button) { ?>
                        <div class="aheto-btn--nonscrolled">
                            <?php echo Helper::get_button($this, $atts, 'rela_main_'); ?>
                        </div>
                    <?php } ?>
                </div>

                <button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>

        <?php if ($rela_scroll_main_add_button) { ?>
            <div class="aheto-btn--scrolled">
                <?php echo Helper::get_button($this, $atts, 'rela_scroll_main_'); ?>
            </div>
        <?php } ?>
    </div>
</div>
