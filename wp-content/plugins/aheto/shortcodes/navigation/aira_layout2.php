<?php
/**
 * Header Aira Menu.
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
$this->add_render_attribute( 'wrapper', 'class', 'main-header' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header--aira-second' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header-js' );
$this->add_render_attribute( 'wrapper', 'class', $transparent );

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-navigation-second', $sc_dir . 'assets/css/aira_layout2.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('aira-navigation-second-js', $sc_dir . 'assets/js/aira_layout2.min.js', array('jquery'), null);
}

$type_logo = isset( $type_logo ) && !empty( $type_logo ) ? $type_logo : 'image';
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
                ?>
            </a>
            <?php if (!empty($label_logo)) { ?>
                <h4 class="main-header__logo-label">
                    <?php echo esc_html($label_logo); ?>
                </h4>
            <?php } ?>
        </div>

        <div class="main-header__menu-box">

            <?php if (!empty($aira_mob_menu_title)) { ?>
                <div class="main-header__mob_menu_title">
                    <?php echo wp_kses($aira_mob_menu_title, 'post'); ?>
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

                <?php if ($search) : ?>

                    <a class="main-header__widget-box--search search-btn js-open-search" href="#">
                        <i class="icon ion-ios-search-strong" aria-hidden="true"></i>
                    </a>

                <?php endif; ?>

                <?php if ($aira_main_mob_add_button) { ?>
                    <?php echo Helper::get_button($this, $atts, 'aira_main_mob_'); ?>
                <?php } ?>
            </div>
        </div>

        <div class="main-header__widget-box">

            <div class="main-header__widget-box-desktop">
                <?php if ($search) : ?>

                    <a class="main-header__widget-box--search search-btn js-open-search" href="#">
                        <i class="icon ion-ios-search-strong" aria-hidden="true"></i>
                    </a>

                <?php endif; ?>

                <?php
                if ($aira_main_add_button) { ?>
                    <div class="aheto-btn--nonscrolled">
                        <?php echo Helper::get_button($this, $atts, 'aira_main_'); ?>
                    </div>
                <?php }

                if ($aira_scroll_main_add_button) { ?>
                    <div class="aheto-btn--scrolled">
                        <?php echo Helper::get_button($this, $atts, 'aira_scroll_main_'); ?>
                    </div>
                <?php } ?>


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

                            <?php if (!empty($aira_desk_menu_title)) { ?>
                                <div class="desk-menu__menu_title">
                                    <?php echo wp_kses($aira_desk_menu_title, 'post'); ?>
                                </div>
                            <?php } ?>

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
                                'menu' => $aira_desk_menu,
                                'depth' => '1'
                            ]);
                            ?>
                        </div>


                        <?php if ($search) : ?>
                        <div class="desk-menu__search-wrap">
                            <!-- SEARCH -->
                            <form role="search" class="w-800" method="get" id="searchform"
                                  action="<?php echo esc_url(home_url('/')); ?>">
                                <label class="screen-reader-text" for="s">Search: </label>
                                <input type="text" value="" name="s" id="s"
                                       placeholder="Enter Keyword"/>

                                <button type="submit" id="searchsubmit" class="search-subm">
                                    <i class="icon ion-ios-search-strong" aria-hidden="true"></i>
                                </button>
                            </form>
                            <div class="desk-menu__search_descr"><?php esc_html_e("Input your search keywords and press Enter.", 'aira');?></div>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
