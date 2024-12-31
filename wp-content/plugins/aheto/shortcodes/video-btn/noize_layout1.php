<?php
/**
 * The Button Shortcode.
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
$this->add_render_attribute( 'wrapper', 'id', $this->atts['element_id'] );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-video-btn--noize' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('magnific');
	wp_enqueue_style('magnific');
}
$btn_size = !empty($atts['video_size']) ? str_replace("btn-video", "btn", $atts['video_size'] ) : '';

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <?php if ( !empty($noize_btn_title) ) :?>
        <div class="<?php echo esc_attr( $atts['align'] );?>">
            <a href="<?php echo esc_url( $atts['video_link'] ); ?>"
                class="aheto-btn js-video-btn  <?php echo esc_attr( $atts['video_style'] .' '. $btn_size ); ?>">
                <?php echo esc_html($noize_btn_title); ?>
            </a>
        </div>
    <?php endif; ?>
</div>
