<?php
/**
 * The Contents Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$slides = $this->parse_group( $azyn_interactive_items );

if ( empty( $slides ) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-page-height-js' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--azyn-interactive-links' );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'owl' );
	wp_enqueue_style( 'azyn-contents-layout4', $sc_dir . 'assets/css/azyn_layout4.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script( 'mousewheel' );
	wp_enqueue_script( 'owl' );
	wp_enqueue_script('azyn-contents-layout4-js', $sc_dir . 'assets/js/azyn_layout4.min.js', array(
		'jquery',
		'mousewheel',
		'owl'
	), null);
}

$random = substr( md5( rand() ), 0, 7 ); ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="aheto-contents--owl-images aheto-page-height-js"></div>
	<div class="aheto-contents--owl owl-carousel">
		<?php

		$count = 1;

		foreach ( $slides as $slide ) :

			$slide = wp_parse_args( $slide, [
				'azyn_interactive_title' => '',
			] );
			extract( $slide );

			if ( empty( $azyn_interactive_title ) ) {
				continue;
			}

			$image = isset( $slide['azyn_interactive_image'] ) && is_array( $slide['azyn_interactive_image'] ) && isset( $slide['azyn_interactive_image']['url'] ) && ! empty( $slide['azyn_interactive_image']['url'] ) ? $slide['azyn_interactive_image']['url'] : $slide['azyn_interactive_image']; ?>

			<div class="aheto-contents__slide" data-image="<?php echo esc_url( $image ); ?>" data-eq="<?php echo esc_attr($count); ?>">
				<?php $item_link = $this->get_link_attributes( $slide['azyn_interactive_url'] );
				$this->add_render_attribute( 'link', $item_link );
				if ( ! empty( $item_link['href'] ) ) : ?>
					<a <?php $this->render_attribute_string( 'link' ); ?>><?php echo esc_html( $azyn_interactive_title ); ?></a>
					<?php
					$count++;

				endif; ?>
			</div>

		<?php endforeach; ?>
	</div>

</div>
