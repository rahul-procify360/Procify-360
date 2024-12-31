<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$slides = $this->parse_group( $aira_creative_items );

if ( empty( $slides ) ) {
	return '';
}

$aira_creative_version = isset($aira_creative_version) && $aira_creative_version ? 'creative-version' : '';
$dark_arrows = isset($aira_dark_arrows) && $aira_dark_arrows ? 'dark_arrows' : '';

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--aira-creative-slider' );
$this->add_render_attribute( 'wrapper', 'class', $aira_creative_version );
$this->add_render_attribute( 'wrapper', 'class', $dark_arrows);


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'aira_swiper_', $carousel_default_params );

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-contents-creative-slider', $sc_dir . 'assets/css/aira_layout3.css', null, null);
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-contents--shape"></div>
    <div class="swiper">
        <div class="swiper-container aheto-contents-swiper-left" <?php echo esc_attr( $carousel_params ); ?> data-allow_touch=true>
            <div class="swiper-wrapper">
				<?php foreach ( $slides as $slide_left ) :
					$slide_left = wp_parse_args($slide_left, [
						'aira_item_image'         => '',
					]);
					extract($slide_left);

					if ( !$aira_item_image ) {
						continue;
					}

					$swiper_lazy_class = $aira_swiper_lazy ? ' swiper-lazy' : '';
					$background_image = Helper::get_background_attachment($aira_item_image, $aira_image_size, $atts, 'aira_', $aira_swiper_lazy); ?>
                    <div class="swiper-slide">
                        <div class="aheto-contents-slider-wrap<?php echo esc_attr($swiper_lazy_class); ?>" <?php echo esc_attr($background_image); ?>></div>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
        <div class="swiper-container aheto-contents-swiper-right" <?php echo esc_attr( $carousel_params ); ?> data-thumbs="1">
            <div class="swiper-wrapper">
				<?php foreach ( $slides as $slide_right ) :
					$slide_right = wp_parse_args($slide_right, [
						'aira_item_title'         => '',
						'aira_item_desc'          => '',
						'aira_item_btn_direction' => ''
					]);
					extract($slide_right);
					?>
                    <div class="swiper-slide">
                        <div class="aheto-contents-slider-wrap">

                            <div class="aheto-contents-slider__content">
								<?php if ( !empty($aira_item_title) ) {
                                    $aira_item_title = str_replace(']]', '</span>', $aira_item_title);
                                    $aira_item_title = str_replace('[[', '<span>', $aira_item_title);
								    ?>
                                    <h2 class="aheto-contents__title"><?php echo wp_kses( $aira_item_title, 'post' ); ?></h2>
								<?php }

								if ( !empty($aira_item_desc) ) { ?>
                                    <p class="aheto-contents__desc"><?php echo wp_kses( $aira_item_desc, 'post' ); ?></p>
								<?php }

								if ( $aira_main_add_button || $aira_add_add_button ) { ?>
                                    <div class="aheto-contents__links">
										<?php
										echo Helper::get_button( $this, $slide_right, 'aira_main_' );

										if($aira_item_btn_direction){ ?>
                                            <br>
										<?php }


										echo Helper::get_button( $this, $slide_right, 'aira_add_' ); ?>
                                    </div>
								<?php } ?>
                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
		<?php $this->swiper_arrow( 'aira_swiper_' ); ?>
    </div>

</div>
