<?php
/**
 * The Banner Slider Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$banners = $this->parse_group( $azyn_animate_banners );

if ( empty( $banners ) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-full-max-height-js' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-banner-slider--azyn-animated' );

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';

$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'azyn-banner-slider-layout3', $sc_dir . 'assets/css/azyn_layout3.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('imagesloaded');
	wp_enqueue_script('anime');
	wp_enqueue_script('azyn-banner-slider-layout3-js', $sc_dir . 'assets/js/azyn_layout3.js', array('jquery', 'imagesloaded', 'aheto-main', 'anime'), null, true);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="slides">
		<?php

		$counter = 1;

		foreach ( $banners as $banner ) :
		$banner = wp_parse_args( $banner, [
			'azyn_anim_image'        => '',
			'azyn_anim_text'  => '',
			'azyn_anim_heading_tag'  => 'h2',
		] );
		extract( $banner );

		if ( ! $azyn_anim_image ) {
			continue;
		}

		$active = $counter === 1 ? 'slide--current' : '';
		$num = $counter < 10 ? '0' . $counter : $counter;
		$background_image  = Helper::get_background_attachment( $azyn_anim_image ); ?>
		<div class="slide <?php echo esc_attr($active); ?>">
			<div class="slide__img" <?php echo esc_attr($background_image); ?>></div>

			<<?php echo esc_attr($azyn_anim_heading_tag); ?> class="slide__title">
			<?php if(!empty($azyn_anim_text)){ ?>
				<?php echo esc_html($azyn_anim_text); ?>
			<?php } ?>
		</<?php echo esc_attr($azyn_anim_heading_tag); ?>>

		<div class="slide__link">
			<?php if ( $azyn_anim_add_button ) {
				echo Helper::get_button( $this, $banner, 'azyn_anim_' );
			} ?>
		</div>
	</div>
	<?php
	$counter ++;

	endforeach; ?>
</div>
<nav class="slidenav">
	<button class="slidenav__item slidenav__item--prev"><?php esc_html_e('Previous', 'aheto'); ?></button>
	<span>/</span>
	<button class="slidenav__item slidenav__item--next"><?php esc_html_e('Next', 'aheto'); ?></button>
</nav>
</div>
