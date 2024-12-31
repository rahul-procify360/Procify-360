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

$hryzantema_active = isset($hryzantema_active) && $hryzantema_active ? 'active' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing--hr-classic' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', $hryzantema_active );


$hryzantema_heading = str_replace( ']]', '</span>', $hryzantema_heading );
$hryzantema_heading = str_replace( '[[', '<span>', $hryzantema_heading );


// Button Link.
$link = $this->get_button_attributes( 'link' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-pricing-tables-layout1', $shortcode_dir . 'assets/css/hryzantema_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="aheto-pricing__header">

		<?php
		// Heading.
		if (!empty($hryzantema_heading) ) {
			echo '<h5 class="aheto-pricing__title">' . wp_kses_post( $hryzantema_heading ) . '</h5>';
		}
		?>

		<div class="aheto-pricing__cost">
			<?php
			// Price.
			if ( !empty($price) ) {
				echo '<div class="aheto-pricing__cost-value">' . esc_html( $price ) . '</div>';
			}
			// Description.
			if ( !empty($description) ) {
				echo '<h5 class="aheto-pricing__cost-time">' . wp_kses_post( $description ) . '</h5>';
			}
			?>
		</div>

	</div>

	<div class="aheto-pricing__content">

		<?php
		$features = $this->parse_group( $hryzantema_features );
		if ( ! empty( $features ) ) { ?>

			<ul class="aheto-pricing__description">

				<?php foreach ( $features as $item ) {
				    $crossed = $item['hryzantema_crossed'] ? 'crossed': '';
				    if(!empty($item['hryzantema_feature'])):?>
					<li class="aheto-pricing__description-item <?php echo esc_attr($crossed); ?>"><?php echo wp_kses_post( $item['hryzantema_feature'] ); ?></li>
				<?php endif;
				} ?>

			</ul>
		<?php }

		// Button Link.
		if ( $hryzantema_add_button ) { ?>
			<div class="aheto-pricing__link">
				<?php echo \Aheto\Helper::get_button($this, $atts, 'hryzantema_'); ?>
			</div>
		<?php }
		?>

	</div>

</div>
