<?php

/**
 * Header Classic Kunst Menu.
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
$this->add_render_attribute( 'wrapper', 'class', 'main-header--kunst__classic' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header-js' );

/**
* Set dependent style
*/
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'kunst-navigation-layout1', $shortcode_dir . 'assets/css/kunst_layout1.css', null, '1.0.1' );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script( 'kunst-navigation-layout1-js', $shortcode_dir . 'assets/js/kunst_layout1.min.js', array( 'jquery' ), '1.0.1' );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="main-header__main-line">
        <div class="main-header__menu">
            <button class="main-header__menu-btn"></button>
            <span class="main-header__menu-btn-line"></span>
		</div>
		<?php if ( !empty( $kunst_textlogo ) ) :?>
			<div class="aheto-logo main-header__text-logo">
				<h2 class="main-header__text-logo-wrap"><?php echo esc_html( $kunst_textlogo ); ?></h2>
			</div>
		<?php endif; ?>
		<div class="main-header__menu-box">
			<?php
				wp_nav_menu([
					'container'       => 'nav',
					'container_class' => 'menu-home-page-container',
					'menu_class'      => 'main-menu main-menu--inline',
					'menu'            => $menus,
				]);
			?>
			<div class="main-header__widget-box">
				<?php $networks = $this->parse_group( $networks );
					if ( ! empty( $networks ) ) {
						echo Helper::get_social_networks( $networks, '<a class="main-header__icon" href="%1$s"><i class="ion-social-%2$s"></i></a>' );
					}
				?>
			</div>
			<?php if ( ! empty( $kunst_mob_menu_title ) ) { ?>
				<span class="main-header__menu-mob">
					<?php echo esc_html( $kunst_mob_menu_title ); ?>
				</span>
			<?php } ?>
        </div>
		<button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
		</button>
	</div>
</div>
