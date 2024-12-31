<?php
/**
 * Portfolio navigation templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'moovit--portfolio-nav-wrap' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$prev_post = get_previous_post( false, '', 'aheto-portfolio-category' );
$next_post = get_next_post( false, '', 'aheto-portfolio-category' );

$prev_post_class = empty( $prev_post ) ? 'empty-prev ' : '';
$next_post_class = empty( $next_post ) ? 'empty-next' : '';

$atts['moovit_image_height'] = 120;
$atts['moovit_image_width']  = 120;


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/portfolio-nav/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-portfolio-nav-layout1', $shortcode_dir . 'assets/css/moovit_layout1.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="moovit--portfolio-nav <?php echo esc_attr( $prev_post_class . $next_post_class ) ?>">

		<?php

		if ( ! empty( $prev_post ) ) {
			$prev_post_image_ID    = get_post_thumbnail_id( $prev_post->ID );
			$prev_post_image       = array();
			$prev_post_image['id'] = $prev_post_image_ID;
			$prev_background_image = Helper::get_background_attachment( $prev_post_image, 'custom', $atts, 'moovit_' ); ?>

            <div class="moovit--portfolio-nav__dir moovit--portfolio-nav__dir--prev">
                <div class="moovit--portfolio-nav__link">
                    <div class="moovit--portfolio-nav__dir-image" <?php echo esc_attr( $prev_background_image ); ?>></div>
                    <h5 class="moovit--portfolio-nav__dir-title">
                        <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"><?php echo wp_kses( $prev_post->post_title, 'post' ); ?></a>
                        <p><?php esc_html_e( 'Prev', 'moovit' ); ?></p>
                    </h5>
                </div>
            </div>


		<?php } ?>

        <div class="moovit--portfolio-nav__list">
            <i class="moovit--portfolio-nav__list-icon icon ion-ios-keypad"></i>
        </div>

		<?php

		if ( ! empty( $next_post ) ) {
			$next_post_image_ID    = get_post_thumbnail_id( $next_post->ID );
			$next_post_image       = array();
			$next_post_image['id'] = $next_post_image_ID;
			$next_background_image = Helper::get_background_attachment( $next_post_image, 'custom', $atts, 'moovit_' ); ?>

            <div class="moovit--portfolio-nav__dir moovit--portfolio-nav__dir--next">
                <div class="moovit--portfolio-nav__link">
                    <div class="moovit--portfolio-nav__dir-image" <?php echo esc_attr( $next_background_image ); ?>></div>
                    <h5 class="moovit--portfolio-nav__dir-title">
                        <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php echo wp_kses( $next_post->post_title, 'post' ); ?></a>
                        <p><?php esc_html_e( 'Next', 'moovit' ); ?></p>
                    </h5>
                </div>
            </div>

		<?php } ?>

    </div>

</div>
