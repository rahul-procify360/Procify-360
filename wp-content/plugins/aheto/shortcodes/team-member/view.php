<?php
/**
 * The Team Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-team-member' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-team-member--chess' );
$this->add_render_attribute( 'wrapper', 'class', 'left' !== $position ? 'aheto-team-member--chess-reversed' : '' );
$this->add_render_attribute( 'wrapper', 'class', 't-left' );

// parse networks
$networks = $this->parse_group( $networks );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/team-member/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'team-member-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<?php if ( $image ) : ?>
		<div class="aheto-team-member__img-holder">
			<?php echo Helper::get_attachment( $image, [ 'class' => 'aheto-team-member__img' ], $image_size, $atts ); ?>
		</div>
	<?php endif; ?>

	<div class="aheto-team-member__text">
		<?php
		// Name.
		if ( $name ) {
			echo '<h3 class="aheto-team-member__name">' . wp_kses_post( $name ) . '</h3>';
		}

		// Designation.
		if ( $designation ) {
			echo '<p class="aheto-team-member__position">' . esc_html( $designation ) . '</p>';
		}

		// Description.
		if ( $description ) {
			echo '<p class="aheto-team-member__desc">' . wp_kses_post( $description ) . '</p>';
		}

		// Field Values Decode.
		if ( $networks ) { ?>
			<div class="aheto-team-member__contact">
				<?php echo Helper::get_social_networks( $networks, '<a class="aheto-team-member__link" href="%1$s"><i class="ion-social-%2$s"></i></a>' ); ?>
			</div>
		<?php } ?>
	</div>
</div>
