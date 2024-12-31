<?php
/**
 * The Noize Blockquote Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-blockquote--noize' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'align-tab-' . $noize_align_tablet );
$this->add_render_attribute( 'wrapper', 'class', 'align-mob-' . $noize_align_mobile );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/blockquote/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'noize-blockquote-layout1', $shortcode_dir . 'assets/css/noize_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?> >
    <blockquote>
        <?php
            // Quote.
            if ( isset( $noize_quote ) && !empty( $noize_quote ) ) {
                echo '<p class="aheto-blockquote__quote">' . wp_kses_post( $noize_quote ) . '</p>';
            }
        ?>

        <div class="aheto-blockquote__footer">
            <?php
                // Cite.
                if ( isset( $noize_author ) && !empty( $noize_author ) ) {
                    echo '<h6 class="aheto-blockquote__author">' . wp_kses_post( $noize_author ) . '</h6>';
                }
                // Positions.
                if ( isset( $noize_position ) && !empty( $noize_position ) ) {
                    echo '<h6 class="aheto-blockquote__position">' . wp_kses_post( $noize_position ) . '</h6>';
                }
            ?>
        </div>
    </blockquote>
</div>
