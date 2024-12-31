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

$type_logo = isset($type_logo) && !empty($type_logo) ? $type_logo : 'image';

if (isset($mobile_menu_width) && is_array($mobile_menu_width) && !empty($mobile_menu_width['size'])) {
    $mobile_menu_width = $mobile_menu_width['size'];
} elseif (!isset($mobile_menu_width) || !is_array($mobile_menu_width) || empty($mobile_menu_width['size'])) {
    $mobile_menu_width = 1199;
}


// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'main-header');
$this->add_render_attribute('wrapper', 'class', 'main-header--bizy_simple');
$this->add_render_attribute('wrapper', 'class', 'main-header-js');
$this->add_render_attribute('wrapper', 'data-mobile-menu', $mobile_menu_width);
$this->add_render_attribute('wrapper', 'class', $transparent);


if ($type_logo == 'image' && is_array($scroll_logo) && is_array($scroll_mob_logo)) {

    $scroll_logo = !empty($scroll_logo['id']) ? $scroll_logo : $logo;
    $scroll_mob_logo = !empty($scroll_mob_logo['id']) ? $scroll_mob_logo : $mob_logo;

} elseif ($type_logo == 'image' && !is_array($scroll_logo) && !is_array($scroll_mob_logo)) {

    $scroll_logo = isset($scroll_logo) && !empty($scroll_logo) ? $scroll_logo : $logo;
    $scroll_mob_logo = isset($scroll_mob_logo) && !empty($scroll_mob_logo) ? $scroll_mob_logo : $mob_logo;

}

$button = $this->get_button_attributes('main');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('bizy-navigation-layout2', $shortcode_dir . 'assets/css/bizy_layout2.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('bizy-navigation-js-layout2', $shortcode_dir . 'assets/js/bizy_layout2.min.js', array('jquery'), null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="main-header__main-line">
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

            <div class="main-header__widget-box-mobile">
                <?php if ($bizy_mob_add_button) { ?>
                    <?php echo Helper::get_button($this, $atts, 'bizy_mob_'); ?>
                <?php } ?>
            </div>
        </div>
        <div class="main-header__widget-box">

            <div class="main-header__widget-box-desktop">
                <?php if ($bizy_add_button) { ?>
                    <div class="main-header__static-button">
                        <?php echo Helper::get_button($this, $atts, 'bizy_'); ?>
                    </div>
                <?php }

                if ($bizy_scroll_add_button) { ?>
                    <div class="main-header__scroll-button">
                        <?php echo Helper::get_button($this, $atts, 'bizy_scroll_'); ?>
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
</div>
