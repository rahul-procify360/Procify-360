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

if ( isset( $mobile_menu_width ) && is_array( $mobile_menu_width ) && ! empty( $mobile_menu_width['size'] ) ) {
	$mobile_menu_width = $mobile_menu_width['size'];
} elseif ( ! isset( $mobile_menu_width ) || ! is_array( $mobile_menu_width ) || empty( $mobile_menu_width['size'] ) ) {
	$mobile_menu_width = 1199;
}

$type_logo = isset($type_logo) && !empty($type_logo) ? $type_logo : 'image';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'main-header');
$this->add_render_attribute('wrapper', 'class', 'main-header--third');
$this->add_render_attribute('wrapper', 'class', 'main-header-js');
$this->add_render_attribute('wrapper', 'class', $transparent);
$this->add_render_attribute( 'wrapper', 'data-mobile-menu', $mobile_menu_width );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('rela-navigation-layout4', $shortcode_dir . 'assets/css/rela_layout4.css', null, null);
}
$button = $this->get_button_attributes('main');

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="main-header__main-line">

        <?php if ($search) : ?>
            <div class="main-header__widget-box--search-wrap">
                <a class="main-header__widget-box--search search-btn js-open-search" href="#">
                    <i class="icon el icon_search" aria-hidden="true"></i>
                </a>
            </div>
        <?php endif; ?>

        <div class="aheto-logo main-header__logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <?php if (!empty($logo) && $type_logo == 'image') {
                    echo Helper::get_attachment($logo, ['class' => 'aheto-logo__image']);
                }

                if (!empty($mob_logo) && $type_logo == 'image') {
                    echo Helper::get_attachment($mob_logo, ['class' => 'aheto-logo__image mob-logo']);
                }

                if (!empty($text_logo) && $type_logo == 'text') { ?>
                    <span><?php echo esc_html($text_logo); ?></span>
                <?php } ?>
            </a>
            <?php if (!empty($label_logo)) { ?>
                <h4 class="main-header__logo-label">
                    <?php echo esc_html($label_logo); ?>
                </h4>
            <?php } ?>
        </div>
        <div class="main-header__menu-box">

            <?php if (!empty($rela_mob_menu_title)) { ?>
                <div class="main-header__mob_menu_title">
                    <?php echo wp_kses($rela_mob_menu_title, 'post'); ?>
                </div>
            <?php } ?>

            <?php
            wp_nav_menu([
                'container' => 'nav',
                'container_class' => 'menu-home-page-container',
                'menu_class' => 'main-menu main-menu--inline',
                'menu' => $menus,
            ]);
            ?>

            <div class="main-header__widget-box-mobile">
                <?php if ($rela_main_mob_add_button) { ?>
                    <?php echo Helper::get_button($this, $atts, 'rela_main_mob_'); ?>
                <?php } ?>
            </div>
        </div>
        <div class="main-header__widget-box">

            <div class="main-header__widget-box-desktop">
                <?php if ($rela_main_add_button) { ?>
                    <?php echo Helper::get_button($this, $atts, 'rela_main_'); ?>
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
