<?php
/**
 * The media Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$points = $this->parse_group( $bizy_creative_items );
$bizy_breakpoint = isset($bizy_breakpoint['size']) && !empty($bizy_breakpoint['size']) ? $bizy_breakpoint['size'] : 767;

if ( empty( $points ) ) {
	return '';
}


$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-media--bizy-creative' );
$this->add_render_attribute( 'wrapper', 'data-breakpoint', $bizy_breakpoint );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
$random        = substr( md5( rand() ), 0, 7 );
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'bizy-media-layout3', $shortcode_dir . 'assets/css/bizy_layout3.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('bizy-media-layout3-js', $shortcode_dir . 'assets/js/bizy_layout3.js', array('jquery'), null);
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="aheto-media__wrapper" id="aheto<?php echo esc_attr( $random  ); ?>" >


		<?php echo Aheto\Helper::get_attachment( $bizy_image_size,  $atts, 'bizy_' ); ?>


		<?php foreach ( $points as $point ) :

			$point = wp_parse_args( $point, [
				'bizy_item_image' =>'',
				'bizy_z_index' => '',
				'bizy_depth' => '',
			] );
			extract( $point );

			if ( ! $bizy_item_image ) {
				continue;
			}

			$data_depth = '';
			$data_depth .= 'data-depth= ' ;
			$data_depth .= !empty( $bizy_depth ) ?  $bizy_depth . '' : '0';


			?>

			<div class="aheto-media__wrapper-point elementor-repeater-item-<?php echo esc_attr( $point['_id'] ); ?>" <?php echo esc_attr( $data_depth ); ?>>
                <div class="img-wrapper">
				<?php if ( ! empty( $bizy_item_image ) ) :
					echo Aheto\Helper::get_attachment(  $bizy_item_image, [],$bizy_image_size, 'full' );
				endif;
				 ?>
				</div>


			</div>
		<?php endforeach; ?>

	</div>

</div>
