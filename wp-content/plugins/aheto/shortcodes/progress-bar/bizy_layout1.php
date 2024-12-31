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
$this->add_render_attribute( 'wrapper', 'class', $bizy_align );
$this->add_render_attribute( 'wrapper', 'class', 'tablet-' . $bizy_t_align );
$this->add_render_attribute( 'wrapper', 'class', 'mobile-' . $bizy_m_align );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-counter' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-counter--bizy-simple-number' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'bizy-progress-bar-layout1', $shortcode_dir . 'assets/css/bizy_layout1.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>


        <?php if ( ! empty( $percentage ) ) {
            echo '<div class="aheto-counter__number-bg js-counter">' . absint( $percentage ) . '</div>';
        } ?>


    <div class="aheto-counter__number-wrap">
        <?php if ( ! empty( $percentage ) ) {
            echo '<h2 class="aheto-counter__number js-counter">' . absint( $percentage ) . '</h2>';
        } ?>
    </div>

    <?php if ( ! empty( $description ) ) {
        echo '<h4 class="aheto-counter__desc">' . wp_kses( $description, 'post' ) . '</h4>';
    } ?>

</div>
