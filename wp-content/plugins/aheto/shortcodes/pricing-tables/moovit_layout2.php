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

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing--moovin-classic' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


$moovit_heading = str_replace( ']]', '</span>', $moovit_heading );
$moovit_heading = str_replace( '[[', '<span>', $moovit_heading );


// Button Link.
$link = $this->get_button_attributes( 'link' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-pricing-tables-layout2', $shortcode_dir . 'assets/css/moovit_layout2.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-pricing__header">

		<?php
		// Heading.
		if ( ! empty( $moovit_heading ) ) {
			echo '<h5 class="aheto-pricing__title">' . wp_kses( $moovit_heading, 'post' ) . '</h5>';
		}
		?>

        <div class="aheto-pricing__cost">
			<?php
			// Price.
			if ( ! empty( $price ) ) {
				echo '<div class="aheto-pricing__cost-value">' . esc_html( $price ) . '</div>';
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

                    <div class="aheto-pricing__list-item"><?php echo wp_kses( $item['feature'], 'post' ); ?></div>

				<?php } ?>

            </div>
		<?php }

		// Button Link.
		if ( $moovit_add_button ) { ?>
            <div class="aheto-pricing__link">
				<?php echo \Aheto\Helper::get_button( $this, $atts, 'moovit_' ); ?>
            </div>
		<?php }
		?>

    </div>

</div>
