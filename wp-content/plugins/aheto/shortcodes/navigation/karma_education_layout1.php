<?php

/**
 * Header Modern Menu.
 */

use Aheto\Helper;

extract($atts);

if ( empty($menus) ) {
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
$this->add_render_attribute('wrapper', 'class', 'main-header main-header--karma-education1');
$this->add_render_attribute( 'wrapper', 'data-mobile-menu', $mobile_menu_width );

$type_logo = isset($type_logo) && !empty($type_logo) ? $type_logo : 'image';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_education-navigation-layout1', $shortcode_dir . 'assets/css/karma_education_layout1.css', null, null);
}


?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="main-header__main-line">
		<div class="main-header__bottom-line  main-header-js">
		<div class="main-header__bottom-line-left">
			<div class="main-header__logo-on-scroll">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="aheto-logo main-header__logo">
					<?php if ( !empty($logo) && $type_logo == 'image' ) {
						echo Helper::get_attachment($logo, ['class' => 'aheto-logo__image']);
					}

					if ( !empty($text_logo) && $type_logo == 'text' ) { ?>
						<span><?php echo esc_html($text_logo); ?></span>
					<?php } ?>
				</a>
			</div>
			<div class="main-header__menu-box">
				<span class="mobile-menu-title"><?php esc_html_e('Menu', 'karma'); ?></span>

				<?php
				wp_nav_menu([
					'container'       => 'nav',
					'container_class' => 'menu-home-page-container',
					'menu_class'      => 'main-menu main-menu--inline',
					'menu'            => $menus,
				]);
				?>
				<div class="main-header__widget-box main-header__widget-box-mobile">
					<ul class="icons-widget main-header__icons">
						<?php if ( $search ) : ?>
							<li class="icons-widget__item">
								<form role="search" class="w-800" method="get" id="searchform"
									  action="<?php echo home_url('/'); ?>">
									<input type="text" value="" name="s" id="s"
										   placeholder="<?php echo esc_html__('Search...', 'karma'); ?>"/>
									<div class="submit-wrap ion-android-search">
										<input class="not-value" type="submit" id="searchsubmit" value=""/>
									</div>
								</form>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			</div>
			<button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
			</button>
			<div class="main-header__widget-on-scroll">
				<ul class="icons-widget main-header__icons">
					<?php if ( $search ) : ?>
						<li class="icons-widget__item">
							<form role="search" class="w-800" method="get" id="searchform"
								  action="<?php echo home_url('/'); ?>">
								<input type="text" value="" name="s" id="s"
									   placeholder="<?php echo esc_html__('Search...', 'karma'); ?>"/>
									<div class="submit-wrap ion-android-search">
										<input class="not-value" type="submit" id="searchsubmit" value=""/>
									</div>
							</form>
						</li>
					<?php endif; ?>
				</ul>
				<div class="main-header__contact">
					<?php
					echo Helper::get_social_networks_list('<a class="main-header__link" href="%1$s" target="_blank" rel="noreferrer noopener"><i class="ion-social-%2$s"></i></a>', 'karma_education_', $atts);
					?>
				</div>
			</div>
		</div>
	</div>
</div>
