<?php
/**
 * Header Classic Mooseoom Menu.
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
$this->add_render_attribute( 'wrapper', 'class', 'main-header--classic--mooseoom' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header-js' );
$this->add_render_attribute( 'wrapper', 'class', $mooseoom_style );
$this->add_render_attribute( 'wrapper', 'data-mobile-menu', $mobile_menu_width );

$background_image = isset($mooseoom_bg_image) && !empty($mooseoom_bg_image) ? Helper::get_background_attachment( $mooseoom_bg_image, 'full', $atts ) : '';

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('mooseoom-navigation-layout1', $shortcode_dir . 'assets/css/mooseoom_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('mooseoom-navigation-layout1-js', $shortcode_dir . 'assets/js/mooseoom_layout1.min.js', array('jquery'), null);
}
$type_logo = isset( $type_logo ) && ! empty( $type_logo ) ? $type_logo : 'image';
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="main-header__main-line" <?php echo esc_attr( $background_image ); ?>>
        <div class="aheto-logo main-header__logo">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="main-header__logo-wrap">
				<?php if ( ! empty( $logo ) && $type_logo == 'image' ) {
					echo Helper::get_attachment( $logo, [ 'class' => 'aheto-logo__image' ] );
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

			<?php if ( ! empty( $label_logo ) ) { ?>
				<span class="main-header__logo-label">
			        <?php echo esc_html( $label_logo ); ?>
                </span>
			<?php } ?>
        </div>
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

				if(isset($mooseoom_copyright) && !empty($mooseoom_copyright)){ ?>
				    <div class="main-header__widget-box-copy">
                        <?php echo wp_kses($mooseoom_copyright, 'post'); ?>
                    </div>
				<?php }?>
			</div>
        </div>
		<button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
		</button>
	</div>
</div>

