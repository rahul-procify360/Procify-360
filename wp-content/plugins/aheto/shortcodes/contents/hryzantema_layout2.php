<?php
/**
 * The Contents Shortcode.
 */
use Aheto\Helper;

extract( $atts );

$slides = $this->parse_group( $hryzantema_creative_items );

if ( empty( $slides ) ) {
	return '';
}

if ( ! $hryzantema_swiper_custom_options ) {
	$speed  = 1000;
	$effect = 'fade';
	$loop   = false;
}

$hryzantema_creative_version = isset($hryzantema_creative_version) && $hryzantema_creative_version ? 'creative-version' : '';


$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--hr-creative-slider' );
$this->add_render_attribute( 'wrapper', 'class', $hryzantema_creative_version );


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = \Aheto\Helper::get_carousel_params( $atts, 'hryzantema_swiper_', $carousel_default_params );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-contents-layout2', $shortcode_dir . 'assets/css/hryzantema_layout2.css', null, null);
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-contents--shape"></div>
    <div class="swiper">
        <div class="swiper-container aheto-contents-swiper-left" <?php echo esc_attr( $carousel_params ); ?>>
            <div class="swiper-wrapper">
                <?php foreach ( $slides as $slide_left ) :
                    $slide_left = wp_parse_args($slide_left, [
                        'hryzantema_item_image'         => '',
                    ]);
                    extract($slide_left);

                    $swiper_lazy_class = $hryzantema_swiper_lazy ? 'swiper-lazy': '';
                    $background_image = \Aheto\Helper::get_background_attachment($hryzantema_item_image, 'full', $atts, '', $swiper_lazy_class);

                    if ( !isset($hryzantema_item_image) || empty($hryzantema_item_image) ) {
                        continue;
                    } ?>
                    <div class="swiper-slide">
                        <div class="aheto-contents-slider-wrap" <?php echo esc_attr($background_image );?>></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="swiper-container aheto-contents-swiper-right" <?php echo esc_attr( $carousel_params ); ?> data-thumbs="1">
            <div class="swiper-wrapper">
                <?php foreach ( $slides as $slide_right ) :
                    $slide_right = wp_parse_args($slide_right, [
                        'hryzantema_item_title'         => '',
                        'hryzantema_item_desc'          => '',
                        'hryzantema_item_btn_direction' => ''
                    ]);
                    extract($slide_right);
                    ?>
                    <div class="swiper-slide">
                        <div class="aheto-contents-slider-wrap">

                            <div class="aheto-contents-slider__content">
                                <?php if ( !empty($hryzantema_item_title)  ) { ?>
                                    <h2 class="aheto-contents__title"><?php echo wp_kses_post( $hryzantema_item_title ); ?></h2>
                                <?php }

                                if ( !empty($hryzantema_item_desc)  ) { ?>
                                    <p class="aheto-contents__desc"><?php echo wp_kses_post( $hryzantema_item_desc ); ?></p>
                                <?php }

                                if ( $hryzantema_main_add_button == true || $hryzantema_add_add_button == true ) { ?>
                                    <div class="aheto-contents__links">
                                        <?php
                                        echo \Aheto\Helper::get_button( $this, $slide_right, 'hryzantema_main_' );
                                        echo wp_kses_post($hryzantema_item_btn_direction ? '<br>' : '');
                                        echo \Aheto\Helper::get_button( $this, $slide_right, 'hryzantema_add_' ); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php $this->swiper_arrow( 'hryzantema_swiper_' ); ?>
    </div>

</div>
