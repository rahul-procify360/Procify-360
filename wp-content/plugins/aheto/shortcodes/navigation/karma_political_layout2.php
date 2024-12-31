<?php

/**
 * Time Schedule default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     KARMA <info@karma.com>
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

// Nav.
$this->add_render_attribute( 'nav', 'class', 'aheto-nav-columns--karma-political' );
$this->add_render_attribute( 'nav', 'class', $karma_political_columns . '-columns' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navigation/';

$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'karma-political-navigation-column', $shortcode_dir . 'assets/css/karma_political_layout2.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div <?php $this->render_attribute_string( 'nav' ); ?>>

		<?php wp_nav_menu( [
			'container'       => 'div',
			'items_wrap'      => '<ul id="%1$s" class="%2$s widget-nav-menu__menu aheto-nav-columns__menu">%3$s</ul>',
			'container_class' => 'menu-main-container',
			'menu_class'      => 'menu',
			'menu'            => $menus,
		] ); ?>

    </div>

</div>
