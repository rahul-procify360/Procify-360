<?php
/**
 * The Heading Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

extract( $atts );
use Aheto\Helper;

$this->generate_css();


// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading--noize' );
$this->add_render_attribute( 'wrapper', 'class', $noize_align );
$this->add_render_attribute( 'wrapper', 'class', 'align-tab-' . $noize_align_tablet );
$this->add_render_attribute( 'wrapper', 'class', 'align-mob-' . $noize_align_mobile );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'noize-heading-layout1', $shortcode_dir . 'assets/css/noize_layout1.css', null, null );
}


?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <?php if ( !empty( $image['id'] ) ) :?>
		<div class="aheto-heading--noize__img"><?php echo Helper::get_attachment( $image ); ?></div>
	<?php endif; ?>

	<?php
        //Heading.
        if ( 'post_title' === $source ) {
            $noize_heading = get_the_title();
        }

        if ( !empty($noize_heading) ) {
            echo '<' . $text_tag . ' class="aheto-heading--noize__title aheto-heading__title">' . wp_kses_post($noize_heading) . '</' . $text_tag . '>';
        }

        if ( !empty($noize_subtitle) ) {
            echo '<' . $noize_subtitle_tag . ' class="aheto-heading--noize__subtitle aheto-heading__subtitle">' . esc_html($noize_subtitle) . '</' . $noize_subtitle_tag . '>';
        }
	?>

</div>
