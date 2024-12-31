<?php
/**
 * The Heading Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();
wp_enqueue_script('typed');


// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading--acacio__simple-font' );
$this->add_render_attribute( 'wrapper', 'class', $alignment );
$this->add_render_attribute( 'wrapper', 'class', 'align-mob-' . $acacio_align_mobile );

$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$animation = isset( $title_animation ) && !empty( $title_animation );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'acacio-heading-layout2', $shortcode_dir . 'assets/css/acacio_layout2.css', null, null );
}


?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <?php
        if(!empty($acacio_image)) { ?>
            <div class="aheto-heading__img">
                <?php echo \Aheto\Helper::get_attachment( $acacio_image, ['class' => ''], $acacio_image_size, $atts, 'acacio_' ); ?>
            </div>
        <?php }
    ?>

	<?php
	// Heading.
	$heading = $this->get_heading();

	$disable_color = $acacio_highlighted_text ? 'color-none' : '';

	if ( !empty($acacio_title) ) {
		echo '<' . $acacio_title_tag . ' class="aheto-heading__subtitle">' . esc_html( $acacio_title ) . '</' . $acacio_title_tag . '>';
	}

	if ( !empty($heading) ) {
		echo '<' . $text_tag . ' class="aheto-heading__title ' . esc_attr( $disable_color ) . '">' . $this->highlight_text( $heading, $animation ) . '</' . $text_tag . '>';
	}

    if ( !empty($acacio_description) ) {
        echo '<p class="aheto-heading__desc">' . wp_kses_post( $acacio_description ) . '</p>';
    }
	?>

</div>
