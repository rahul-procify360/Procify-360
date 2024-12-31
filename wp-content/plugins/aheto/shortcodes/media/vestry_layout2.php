<?php

/**
 * The Vestry Media Shortcode.
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $vestry_image ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto_media--vestry' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('magnific');
	wp_enqueue_style( 'vestry-media-layout2', $shortcode_dir . 'assets/css/vestry_layout2.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('magnific');
	wp_enqueue_script('isotope');
	wp_enqueue_script( 'vestry-media-layout2-js', $shortcode_dir . 'assets/js/vestry_layout2.js', array( 'jquery' ), null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<?php
	$show_all = $vestry_all_item ? '' : 'hide-item';
	?>
    <div class="aheto-vestry-gallery-img">
        <div class="grid-sizer"></div>
		<?php
		$counter = 1;

		foreach ( $vestry_image as $image ) {
			$image_id         = is_array( $image ) && ! empty( $image['id'] ) ? $image['id'] : $image;
			$image_url        = wp_get_attachment_image_url( $image_id, 'full' );
			$background_image = Helper::get_background_attachment( $image, $vestry_image_size, $atts, 'vestry_' ); ?>
            <figure data-mfp-src="<?php echo esc_url( $image_url ) ?>"
                    class="grid-item <?php echo esc_attr( $show_all ); ?>">
                <span <?php echo esc_attr( $background_image ); ?>></span>
            </figure>
			<?php
		} ?>
    </div>
</div>
