<?php
/**
 * Social network default templates.
 *
 */

use Aheto\Helper;

extract( $atts );
$networks = $this->parse_group( $networks );
if ( empty( $networks ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'sterling-socials-networks' );

//Container
if ( ! empty( $style ) ) {
	$this->add_render_attribute( 'container', 'class', 'aheto-socials--' . $style );
}
$this->add_render_attribute( 'container', 'class', $socials_align . '-align' );

// Template.
$this->add_render_attribute( 'link', 'href', '%1$s' );
$this->add_render_attribute( 'link', 'class', 'aheto-socials__link' );


$social_template = '<a ' . $this->get_render_attribute_string( 'link' ) . ' target="_blank"><i class="aheto-socials__icon icon ion-social-%2$s"></i></a>';

/**
 * Set dependent style
 */

$sc_dir = aheto()->plugin_url() . 'shortcodes/social-networks/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-sicials-simple', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div <?php $this->render_attribute_string( 'container' ); ?>>
		<?php echo Helper::get_social_networks( $networks, $social_template ); ?>
	</div>
</div>
