<?php
/**
 * The Pricing Tables Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;
use Aheto\Shortcode;

extract( $atts );
$this->generate_css();

//Active
$mooseoom_active = $mooseoom_active ? 'aheto-pricing__active' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing--mooseoom-modern' );
$this->add_render_attribute( 'wrapper', 'class', $mooseoom_active );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


// Button Link.
$link = $this->get_button_attributes( 'link' );

// Icon.
$icon = $this->get_icon_attributes( 'mooseoom_', true, $atts );
if ( ! empty( $icon ) ) {
	$this->add_render_attribute( 'mooseoom_icon', 'class', 'aheto-pricing__ico' );
	$this->add_render_attribute( 'mooseoom_icon', 'class', $icon['icon'] );
	if ( ! empty( $icon['color'] ) ) {
		$this->add_render_attribute( 'mooseoom_icon', 'style', 'color:' . $icon['color'] . ';');
	}

	if ( ! empty( $icon['font_size'] ) ) {
		$this->add_render_attribute( 'mooseoom_icon', 'style', 'font-size:' . $icon['font_size'] );
	}
}


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('mooseoom-pricing-tables-layout2', $shortcode_dir . 'assets/css/mooseoom_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="aheto-pricing__header">

		<?php
		// Icon.
		if ( ! empty($icon) ) {
			echo '<i ' . $this->get_render_attribute_string( 'mooseoom_icon' ) . '></i>';

		}
		?>

		<div class="aheto-pricing__line"></div>

		<?php
		// Heading.
		if ( ! empty($mooseoom_heading) ) {
			echo '<h5 class="aheto-pricing__title">' . wp_kses_post( $mooseoom_heading ) . '</h5>';
		}
		?>

	</div>

<div class="aheto-pricing__content">

	<?php
	$features = $this->parse_group( $features );
	if ( ! empty( $features ) ) { ?>

		<div class="aheto-pricing__list">

			<?php foreach ( $features as $item ) { ?>

				<div class="aheto-pricing__list-item"><?php echo wp_kses_post( $item['feature'] ); ?></div>

			<?php } ?>

		</div>
	<?php }

	// Button Link.
	if ( $mooseoom_add_button ) { ?>
		<div class="aheto-pricing__link">
			<?php echo \Aheto\Helper::get_button($this, $atts, 'mooseoom_'); ?>
		</div>
	<?php }
	?>

</div>

</div>
