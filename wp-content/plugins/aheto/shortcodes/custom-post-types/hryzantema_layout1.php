<?php

use Aheto\Helper;

extract( $atts );

$atts['layout'] = 'slider';

// Query.
$the_query = $this->get_wp_query();
if ( ! $the_query->have_posts() ) {
	return;
}

$hryzantema_hide_pagination = isset($hryzantema_hide_pagination) && $hryzantema_hide_pagination ? 'hide-pagination' : '';

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--hr-modern' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', $hryzantema_hide_pagination );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'     => 500,
	'slides'    => 3,
	'slides_md' => 2,
	'slides_xs' => 1,
	'space'     => 30
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'hryzantema_swiper_', $carousel_default_params );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-custom-post-types-layout1', $shortcode_dir . 'assets/css/hryzantema_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="swiper">

		<div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>

			<div class="swiper-wrapper">

				<?php
				$this->add_excerpt_filter();

				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					?>
					<div class="swiper-slide">

						<?php $this->get_skin_part($skin, $atts); ?>

					</div>
				<?php
				endwhile;

				$this->remove_excerpt_filter();

				wp_reset_query();
				?>

			</div>
			<?php $this->swiper_pagination('hryzantema_swiper_'); ?>
		</div>

		<?php $this->swiper_arrow('hryzantema_swiper_'); ?>

	</div>

</div>
