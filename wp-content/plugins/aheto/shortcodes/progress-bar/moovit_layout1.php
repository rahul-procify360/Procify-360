<?php
/**
 * The Progress Bar Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-counter' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-counter--moovit-modern' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-progress-bar-layout1', $shortcode_dir . 'assets/css/moovit_layout1.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	// Image
	if ( ! empty( $moovit_image ) ) :
		echo Helper::get_attachment( $moovit_image, [ 'class' => 'aheto-counter__image' ], $moovit_image_size, $atts, 'moovit_' );

	endif;

	// Percentage
	if ( ! empty( $moovit_number ) ) { ?>
        <div class="aheto-counter__number-wrap">
			<?php if ( isset( $moovit_current ) && ! empty( $moovit_current ) ) { ?>
                <h2 class="aheto-counter__current"><?php echo esc_html( $moovit_current ); ?></h2>
			<?php } ?>
            <h2 class="aheto-counter__number js-counter"><?php echo esc_html( $moovit_number ); ?></h2>
			<?php if ( ! empty( $moovit_symbol ) ) { ?>
                <h5 class="aheto-counter__symbol"><?php echo esc_html( $moovit_symbol ); ?></h5>
			<?php } ?>
        </div>
	<?php }

	// Heading
	if ( ! empty( $heading ) ) {


		if ( $moovit_use_dot ) {

			$heading = str_replace( '{{.}}', '<span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '"></span>', $heading );

			$words = explode( " ", $heading );

			if ( count( $words ) > 0 ) {
				$last_word = $words[ count( $words ) - 1 ];

				$last_space_position = strrpos( $heading, ' ' );
				$start_string        = substr( $heading, 0, $last_space_position );

				$heading = wp_kses( $start_string, 'post' ) . ' <span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '">' . wp_kses( $last_word, 'post' ) . '</span>';
			} else {
				$heading = '<span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '">' . wp_kses( $heading, 'post' ) . '</span>';
			}

		} else {
			$heading = wp_kses( $heading, 'post' );
		}


		echo '<' . $moovit_title_tag . ' class="aheto-progress__title">' . $heading . '</' . $moovit_title_tag . '>';
	}

	// Description
	if ( ! empty( $description ) ) { ?>
        <p class="aheto-counter__desc"><?php echo wp_kses( $description, 'post' ); ?></p>
	<?php } ?>
</div>
