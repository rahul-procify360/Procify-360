<?php
/**
 * The Pricing Tables Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Button Link.
$link = $this->get_button_attributes( 'link' );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'pricing-tables-style-3', $sc_dir . 'assets/css/layout3.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-pricing aheto-pricing--tableColumn js-pricing-height">
        <div class="aheto-pricing__header js-pricing-height" data-height-key="header">

			<?php
			// Heading.
			if ( ! empty( $heading ) ) {
				echo '<h6 class="aheto-pricing__title">' . wp_kses_post( $heading ) . '</h6>';
			}
			?>

            <div class="aheto-pricing__cost">
				<?php
				// Price.
				if ( ! empty( $price ) ) {
					echo esc_html( $price );
				}
				?>
            </div>

        </div>

        <div class="aheto-pricing__content">

			<?php
			$features = $this->parse_group( $features_with_name );
			if ( ! empty( $features ) ) {

				echo '<div class="aheto-pricing__list">';

				foreach ( $features as $key => $item ) {
					$classes = empty( $item['feature'] ) ? 'is-empty' : '';

					echo '<div class="aheto-pricing__list-item js-pricing-items ' . $classes . '" data-height-key="key-' . esc_attr( $key ) . '">';
					echo '<h6>' . $item['feature_name'] . '</h6>';;
					echo '<p>';
					echo '[ok]' === $item['feature'] ? '<i class="ion-checkmark aheto-pricing__list-ico-ok"></i>' : wp_kses_post( $item['feature'] );
					echo '</p>';
					echo '</div>';
				}

				echo '</div>';
			}

			// Button Link.
			if ( isset( $link['href'] ) && ! empty( $link['title'] ) ) {
				$this->add_render_attribute( 'button', $link );
				$this->add_render_attribute( 'button', 'class', 'aheto-btn aheto-pricing__btn aheto-btn--small' );
				printf(
					'<a %s>%s</a>',
					$this->get_render_attribute_string( 'button' ),
					esc_html( $link['title'] )
				);
			}
			?>

        </div>
    </div>

</div>
