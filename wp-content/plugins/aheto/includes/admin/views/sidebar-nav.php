<?php
/**
 * Sidebar navigation.
 *
 * @package Aheto
 */

use Aheto\Helper;

$current            = str_replace( 'aheto-', '', Helper::param_get( 'page', 'aheto-setting-up' ) );
$check_setup_wizard = false;
$check_setup_wizard = apply_filters( "aheto_wizard", $check_setup_wizard );
$theme_tabs         = array();
$theme_tabs         = apply_filters( "aheto_theme_options", $theme_tabs );


$navigation = aheto()->plugin_dashboard_pages();

if ( empty( $theme_tabs ) ) {
	unset( $navigation["theme-options"] );
}

if ( !$check_setup_wizard || 'visual-composer' === Helper::get_settings( 'general.builder' ) ) {
	unset( $navigation["setup"] );
}

if ( 'visual-composer' === Helper::get_settings( 'general.builder' ) ) {
	unset( $navigation["templates"] );
}

// Get aheto option.
$options = get_option( 'aheto-general-settings' ); ?>

<div class="aheto-preloader">
    <div class="aheto-preloader__wraper">
        <img src="<?php echo aheto()->plugin_url(); ?>assets/admin/img/sidebar-icon/regenerate.png" id="loader_generating"/>
    </div>
</div>
<div class="aheto-option-sidebar">
    <div class="aheto-logo">
        <img src="<?php echo esc_url( aheto()->plugin_dashboard_desktop_logo() ); ?>"
             alt="<?php aheto()->plugin_name(); ?>"
             class="full-version">
        <img src="<?php echo esc_url( aheto()->plugin_dashboard_mobile_logo() ); ?>"
             alt="<?php aheto()->plugin_name(); ?>"
             class="mob-version">
    </div>

    <nav class="aheto-option-sidebar-nav">

		<?php
		$active_skin    = Helper::get_active_skin();
		$img            = aheto()->assets() . 'admin/img/sidebar-icon/';

		foreach ( $navigation as $id => $label ) :
			$label_title = isset( $label[0] ) && ! empty( $label[0] ) ? $label[0] : '';
			$label_icon = isset( $label[1] ) && ! empty( $label[1] ) ? $label[1] : '';
			$args       = ( $id === 'skin-generator' ) ? [ 'aheto-edit-skin' => $active_skin ] : [];
			?>
            <a<?php echo $id === $current ? ' class="nav-active"' : ''; ?>
                    href="<?php echo esc_url( Helper::get_admin_url( $id, $args ) ); ?>"
                    title="<?php echo esc_attr( $label_title ); ?>">
				<?php echo $label_icon ?>
                <span><?php echo esc_attr( $label_title ); ?></span>
            </a>
		<?php endforeach; ?>

    </nav>
    <div class="aheto-regenerate-button-wrap">
        <a class="regenerating_css_js"><img
                    src="<?php echo aheto()->plugin_url(); ?>assets/admin/img/sidebar-icon/regenerate.png"
                    id="loader_generating"/></a>
        <span class="result"></span>
    </div>

</div>
