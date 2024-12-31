<?php
/**
 * The Heading Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */

use Aheto\Helper;

extract ( $atts );

$this -> generate_css ();

// Wrapper.
$this -> add_render_attribute ( 'wrapper', 'id', $element_id );
$this -> add_render_attribute ( 'wrapper', 'class', 'aheto-heading--karma_marketing__layout1' );
$this -> add_render_attribute ( 'wrapper', 'class', $alignment );
$this -> add_render_attribute ( 'wrapper', 'class', 'align-mob-' . $align_mobile );
$this -> add_render_attribute ( 'wrapper', 'class', 'align-tab-' . $align_tablet );
$this -> add_render_attribute ( 'wrapper', 'class', $this -> the_custom_classes () );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';

$custom_css = Helper ::get_settings ( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && !empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style ( 'karma_marketing-heading-layout1', $shortcode_dir . 'assets/css/karma_marketing_layout1.css', null, null );
}

$smaller_line  = $karma_marketing_smaller_line == true ? 'aheto-heading__title-line-smaller' : ''; ?>

<div <?php $this -> render_attribute_string ( 'wrapper' ); ?>>

	<?php
        // Heading.

        if ( !empty( $karma_marketing_title ) ) {
            echo '<' . $text_tag . ' class="aheto-heading__title '. $smaller_line .'">' . wp_kses ( $karma_marketing_title, 'post' ) . '</' . $text_tag . '>';
        }

        if ( !empty( $karma_marketing_description )) {
            echo '<p class="aheto-heading__description">' . wp_kses ( $karma_marketing_description, 'post' ) . '</p>';
        }

	?>

</div>
