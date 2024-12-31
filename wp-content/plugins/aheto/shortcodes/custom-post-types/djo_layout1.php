<?php
/**
 * The custom post type shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$atts['layout'] = 'slider';

// Query.
$the_query = $this->get_wp_query();

if ( ! $the_query->have_posts() ) {
	return;
}

$skin = isset($skin) && !empty($skin) ? $skin : 'djo_skin-2';

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--slider djo-cpt--slider' );
$this->add_render_attribute('wrapper', 'class', $skin ? 'js-popup-gallery' : '');
$this->add_render_attribute('wrapper', 'class', $djo_align ? $djo_align : '');
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'     	=> 1000,
	'slides'    	=> 1,
	'slides_md' 	=> 1,
	'slides_xs' 	=> 1,
	'spaces'     	=> 30,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'djo_swiper_', $carousel_default_params );

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('djo-custom-post-type-layout1', $shortcode_dir . 'assets/css/djo_layout-1.css', null, null);
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
					<div class="swiper-slide d-flex align-items-center">
						<?php $this->get_skin_part($skin, $atts); ?>
					</div>
				<?php
				endwhile;

				$this->remove_excerpt_filter();

				wp_reset_postdata();
				?>

			</div>

			<?php $this->swiper_pagination('djo_swiper_'); ?>

		</div>
		<?php if ( ! empty( $this->atts[ 'djo_swiper_arrows' ] ) ) {
			$num = rand(5, 55); ?>
			<div class="swiper-button-prev">
				<svg xmlns="http://www.w3.org/2000/svg" width="34" height="37" viewBox="0 0 34 37">
					<defs>
						<mask id="lbn0b<?php echo esc_attr($num);?>" width="2.05" height="2.04" x="-1.02" y="-1.02">
							<path fill="var(--c-light)" d="M3.4 3.4h26.2v30.2H3.4z" />
							<path d="M4 18.5l25 14.503V3.996z" />
						</mask>
						<filter id="lbn0a<?php echo esc_attr($num);?>" width="57" height="61" x="-12" y="-12" filterUnits="userSpaceOnUse">
							<feOffset in="SourceGraphic" result="FeOffset1023Out" />
							<feGaussianBlur in="FeOffset1023Out" result="FeGaussianBlur1024Out" stdDeviation="2.16 2.16" />
						</filter>
						<clipPath id="lbn0c<?php echo esc_attr($num);?>">
							<path fill="var(--c-light)" d="M4 18.5l25 14.503V3.996z" />
						</clipPath>
					</defs>
					<g>
						<g>
							<g filter="url(#lbn0a)<?php echo esc_attr($num);?>">
								<path fill="none" stroke="var(--c-active)" stroke-opacity=".25" stroke-width="1.2" d="M4 18.5v0l25 14.503v0V3.996v0z" mask="url(&quot;#lbn0b<?php echo esc_attr($num);?>&quot;)" />
								<!-- <path fill="var(--c-active)" fill-opacity=".25" d="M4 18.5l25 14.503V3.996z" /> -->
							</g>
							<path class="path" fill="none" stroke="var(--c-active)" stroke-miterlimit="50" stroke-width="4" d="M4 18.5v0l25 14.503v0V3.996v0z" clip-path="url(&quot;#lbn0c<?php echo esc_attr($num);?>&quot;)" />
						</g>
					</g>
				</svg>
			</div>
			<div class="swiper-button-next">
				<svg xmlns="http://www.w3.org/2000/svg" width="35" height="38" viewBox="0 0 35 38">
					<defs>
						<mask id="uok9b<?php echo esc_attr($num);?>" width="2.05" height="2.04" x="-1.02" y="-1.02">
							<path fill="var(--c-light)" d="M4.4 3.4h27.2v31.2H4.4z" />
							<path d="M31 19L5.5 33.722V4.277z" />
						</mask>
						<filter id="uok9a<?php echo esc_attr($num);?>" width="58" height="62" x="-11" y="-12" filterUnits="userSpaceOnUse">
							<feOffset in="SourceGraphic" result="FeOffset1051Out" />
							<feGaussianBlur in="FeOffset1051Out" result="FeGaussianBlur1052Out" stdDeviation="2.16 2.16" />
						</filter>
						<clipPath id="uok9c<?php echo esc_attr($num);?>">
							<path fill="var(--c-light)" d="M31 19L5.5 33.722V4.277z" />
						</clipPath>
					</defs>
					<g>
						<g>
							<g filter="url(#uok9a<?php echo esc_attr($num);?>)">
								<path fill="none" stroke="var(--c-active)" stroke-opacity=".25" stroke-width="1.2" d="M31 19v0L5.5 33.722v0V4.277v0z" mask="url(&quot;#uok9b<?php echo esc_attr($num);?>&quot;)" />
								<!-- <path fill="var(--c-active)" fill-opacity=".25" d="M31 19L5.5 33.722V4.277z" /> -->
							</g>
							<path class="path" fill="none" stroke="var(--c-active)" stroke-miterlimit="50" stroke-width="4" d="M31 19v0L5.5 33.722v0V4.277v0z" clip-path="url(&quot;#uok9c<?php echo esc_attr($num);?>&quot;)" />
						</g>
					</g>
				</svg>
			</div>
		<?php } ?>
	</div>

</div>
