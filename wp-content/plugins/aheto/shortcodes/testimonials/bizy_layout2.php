<?php
/**
 * The Testimonials Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-tm--bizy-single' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'bizy-testimonials-layout2', $shortcode_dir . 'assets/css/bizy_layout2.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<img src="<?php echo esc_url($shortcode_dir . 'assets/images/quote.png'); ?>" alt="quote" width="57px" height="55px" class="aheto-quote--bizy-simple__quote">

	<?php if ( isset( $bizy_t ) && ! empty( $bizy_t ) ) {
		echo '<p class="aheto-tm__text">' . wp_kses( $bizy_t, 'post' ) . '</p>';
	} ?>

	<div class="aheto-tm__info">
		<?php
		// Name.
		if ( isset( $bizy_n ) && ! empty( $bizy_n ) ) {
			echo '<h5 class="aheto-tm__name">' . wp_kses( $bizy_n, 'post' ) . '</h5>';
		}

		// Company.
		if ( isset( $bizy_c ) && ! empty( $bizy_c ) ) {
			echo '<h6 class="aheto-tm__position">' . wp_kses( $bizy_c, 'post' ) . '</h6>';
		} ?>
	</div>

</div>
