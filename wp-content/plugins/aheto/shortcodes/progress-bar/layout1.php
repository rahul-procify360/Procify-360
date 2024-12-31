<?php
/**
 * The Progress Bar Shortcode.
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

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;


if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'progress-bar-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}


$def = 100 - absint( $percentage ); ?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-progress aheto-progress--chart t-center">

        <div class="aheto-progress__chart-holder">

            <svg class="aheto-progress__chart" viewbox="0 0 33.83098862 33.83098862" xmlns="http://www.w3.org/2000/svg">
                <circle class="aheto-progress__chart-bg" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431"/>
                <circle class="aheto-progress__chart-circle js-chart-circle"
                        stroke-dasharray="<?php echo absint( $percentage ); ?>, <?php echo absint( $def ); ?>"
                        fill="none"
                        cx="16.91549431"
                        cy="16.91549431" r="15.91549431"/>
            </svg>

			<?php $this->the_icon(); ?>

        </div>

		<?php
		// Heading.
		if ( ! empty( $heading ) ) {
			echo '<h5 class="aheto-progress__title">' . esc_html( $heading ) . '</h5>';
		}

		// Description.
		if ( ! empty( $description ) ) {
			echo '<p class="aheto-progress__desc">' . wp_kses_post( $description ) . '</p>';
		}
		?>

    </div>

</div>
