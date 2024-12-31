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
$sc_dir         = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css     = Helper::get_settings( 'general.custom_css_including' );
$custom_css     = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
$features_align = isset( $features_align ) && ! empty( $features_align ) ? $features_align : 'left';

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'pricing-tables-style-2', $sc_dir . 'assets/css/layout2.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-pricing aheto-pricing--alternative">

		<?php
		// Heading.
		if ( $heading ) {
			echo '<div class="aheto-pricing__header"><h5 class="aheto-pricing__title">' . wp_kses_post( $heading ) . '</h5></div>';
		}
		?>

        <div class="aheto-pricing__content">

            <div class="aheto-pricing__cost">
				<?php
				// Price.
				echo '<div class="aheto-pricing__cost-value">' . esc_html( $price ) . '</div>';

				// Description.
				if ( $description ) {
					echo '<div class="aheto-pricing__cost-time">' . wp_kses_post( $description ) . '</div>';
				}
				?>
            </div>

			<?php
			$features = $this->parse_group( $features );
			if ( ! empty( $features ) ) {

				echo '<div class="aheto-pricing__description"><ul class="t-left mobile-' . esc_attr( $features_align ) . '">';

				foreach ( $features as $item ) {
					echo '<li>';
					if ( isset( $item['feature'] ) ) {
						echo wp_kses_post( $item['feature'] );
					} else {
						echo '&nbsp;';
					}
					echo '</li>';
				}

				echo '</ul></div>';
			}

			// Button Link.
			if ( isset( $link['href'] ) && ! empty( $link['title'] ) ) {
				$this->add_render_attribute( 'button', $link );
				$this->add_render_attribute( 'button', 'class', 'aheto-btn aheto-btn--small aheto-pricing__btn' );
				printf(
					'<a %s>%s</a>',
					$this->get_render_attribute_string( 'button' ),
					esc_html( $link['title'] )
				);
			} ?>
        </div>

    </div>

</div>
