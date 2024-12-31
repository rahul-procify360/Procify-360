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
extract( $atts );
$this->generate_css();

//Active
$mooseoom_active = $mooseoom_active ? 'aheto-pricing__active' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing--mooseoom-classic' );
$this->add_render_attribute( 'wrapper', 'class', $mooseoom_active );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


// Button Link.
$link = $this->get_button_attributes( 'link' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('mooseoom-pricing-tables-layout1', $shortcode_dir . 'assets/css/mooseoom_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="aheto-pricing__header">

		<?php
		// Heading.
		if ( !empty($mooseoom_heading )) {
			echo '<p class="aheto-pricing__title">' . wp_kses_post( $mooseoom_heading ) . '</p>';
		}
		?>

		<div class="aheto-pricing__cost">
			<?php
			// Price.
			if ( !empty($price )) {
				echo '<h5 class="aheto-pricing__cost-value">' . esc_html( $price ) . '</h5>';
			}
			?>
		</div>

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
		if ( !empty($mooseoom_add_button )) { ?>
			<div class="aheto-pricing__link">
				<?php echo \Aheto\Helper::get_button($this, $atts, 'mooseoom_'); ?>
			</div>
		<?php }
		?>

	</div>

</div>
