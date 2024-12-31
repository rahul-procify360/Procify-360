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

$karma_events_banners = $this->parse_group( $karma_events_banners );

if ( empty( $karma_events_banners ) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-banner-wrap--karma_events-style-1' );


if ( isset( $karma_events_change_arrow_position ) && $karma_events_change_arrow_position == true ) {
	$this->add_render_attribute( 'wrapper', 'class', 'aheto-banner-wrap--arrow-position' );
}
/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'karma_events_swiper_simple_', $carousel_default_params );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';;
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'karma_events-banner-slider-layout1', $shortcode_dir . 'assets/css/karma_events_layout1.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>
            <div class="swiper-wrapper">
				<?php foreach ( $karma_events_banners as $banner ) :

				$banner = wp_parse_args( $banner, [
					'karma_events_image'         => '',
					'karma_events_title'         => '',
					'karma_events_title_tag'     => '',
					'karma_events_align'         => '',
					'karma_events_btn_direction' => '',
					'karma_events_date'          => '',
					'karma_events_place'         => '',
					'karma_events_social'        => '',
				] );
				extract( $banner );

				if ( empty( $karma_events_image ) ) {
					continue;
				}

				$lazy_class       = $karma_events_swiper_simple_lazy ? ' swiper-lazy' : '';
				$background_image = Helper::get_background_attachment( $karma_events_image, 'full', $atts, '', $karma_events_swiper_simple_lazy );

				?>
                <div class="swiper-slide">
                    <div class="aheto-banner-wrap aheto-full-min-height-js <?php echo esc_attr( $karma_events_align . $lazy_class ); ?>" <?php echo esc_attr( $background_image ); ?>>
                        <div class="aheto-banner__content">
                            <div class="aheto-banner__contact">
								<?php if ( ! empty( $karma_events_date ) ): ?>
                                    <h5 class="aheto-banner__contact-item aheto-banner__date"><?php echo esc_html( $karma_events_date ); ?></h5>
								<?php endif; ?>
								<?php if ( ! empty( $karma_events_place ) ): ?>
                                    <h5 class="aheto-banner__contact-item aheto-banner__place"><?php echo esc_html( $karma_events_place ); ?></h5>
								<?php endif; ?>
                            </div>
							<?php if ( ! empty( $karma_events_title ) ) { ?>
                            <<?php echo esc_attr( $karma_events_title_tag ); ?>
                            class="aheto-banner__title"><?php echo wp_kses( $karma_events_title, 'post' ); ?>
                        </<?php echo esc_attr( $karma_events_title_tag ); ?>>
						<?php }
						if ( $karma_events_main_add_button == true || $karma_events_add_add_button == true ) { ?>
                            <div class="aheto-banner__links <?php echo esc_attr( $karma_events_btn_direction ) ? 'aheto-banner__links-col' : ''; ?>">
								<?php
								echo Helper::get_button( $this, $banner, 'karma_events_main_' );
								echo esc_attr( $btn_direction ) ? '<br>' : '';
								echo Helper::get_button( $this, $banner, 'karma_events_add_' ); ?>
                            </div>
						<?php }
						?>
                    </div>
					<?php if ( $karma_events_social == true ) { ?>
                        <div class="aheto-banner__socials">
							<?php
							echo Helper::get_social_networks_list( '<a class="aheto-banner__social-items" href="%1$s" target="_blank" rel="noreferrer noopener"><i class="ion-social-%2$s"></i></a>', 'karma_events_', $banner );
							?>
                        </div>
					<?php } ?>
					<?php if ( $karma_events_overlay_img == true ): ?>
                        <div class="aheto-banner__overlay-img">

							<?php if ( $karma_events_swiper_simple_lazy ) :
								echo Helper::get_attachment_for_swiper( $karma_events_image_overlay, [ 'class' => 'js-bg-swiper swiper-lazy' ] );
							else :
								echo Helper::get_attachment( $karma_events_image_overlay, [ 'class' => 'js-bg' ] );
							endif; ?>
                        </div>
					<?php endif; ?>
                </div>
            </div>
			<?php endforeach; ?>
        </div>
    </div>
	<?php $this->swiper_arrow( 'karma_events_swiper_simple_' ); ?>
</div>
</div>
