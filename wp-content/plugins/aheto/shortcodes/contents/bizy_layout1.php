<?php
/**
 * The Contents Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--bizy-creative' );
$this->add_render_attribute( 'wrapper', 'data-breakpoint', $bizy_breakpoint );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'bizy-contents-layout1', $shortcode_dir . 'assets/css/bizy_layout1.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('bizy-contents-layout1-js', $shortcode_dir . 'assets/js/bizy_layout1.js', array('jquery'), null);
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="aheto-contents__wrapper">


		<?php if ( ! empty( $bizy_image ) ) :
			echo Aheto\Helper::get_attachment( $bizy_image, ['class'=> 'aheto-contents__wrapper-main-img'], $bizy_image_size, $atts, 'bizy_' );
		endif; ?>


		<?php foreach ( $points as $point ) :
			$point = wp_parse_args( $point, [
				'bizy_item_desc' => '',
				'bizy_top' => '',
				'bizy_left' => '',
				'bizy_item_location' => '',
			] );
			extract( $point );

			if ( ! $bizy_item_image ) {
				continue;
			}

			$style = '';


			if(!empty($bizy_top) || !empty($bizy_left)){
				$style .= 'style=';
				$style .= !empty($bizy_top) ? 'top:' . $bizy_top['size'] . '%;' : '';
				$style .= !empty($bizy_left) ? 'left:' . $bizy_left['size'] . '%;' : '';

			} ?>

			<div class="aheto-contents__wrapper-point" <?php echo esc_attr($style); ?>>

				<?php if ( ! empty( $bizy_item_image ) ) :
					echo Aheto\Helper::get_attachment( $bizy_item_image, [], 'thumbnail');
				endif;

				if ( ! empty( $bizy_item_desc ) ) : ?>
					<div class="aheto-contents__wrapper-text">
                        <?php if(!empty($bizy_item_location)){ ?>
                            <h5 class="aheto-contents__wrapper-location"><?php echo esc_html($bizy_item_location); ?></h5>
                        <?php }

                        echo esc_html($bizy_item_desc); ?>
					</div>
				<?php endif; ?>

			</div>
		<?php endforeach; ?>

	</div>

</div>
