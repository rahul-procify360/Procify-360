<?php
/**
 * About default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$atts['layout'] = 'masonry';

// Query.
$the_query = $this->get_wp_query();

if ( ! $the_query->have_posts() ) {
	return;
}

$counter    = 1;
$post_count = $the_query->post_count;
$snapster_link = $this->get_link_attributes($snapster_link_url);
$snapster_link_item = isset($snapster_link['href']) && !empty($snapster_link['href']) ? $snapster_link['href'] : '';

$target = isset($snapster_link['target']) ? $snapster_link['target'] : '_self';
$rel = isset( $snapster_link['rel'] ) && !empty($snapster_link['rel']) ? "rel='" . esc_attr( $snapster_link['rel'] )  . "'" : '';

$tag           = isset( $this->atts['title_tag'] ) && ! empty( $this->atts['title_tag'] ) ? $this->atts['title_tag'] : 'h4';

$skin                  = isset( $skin ) && ! empty( $skin ) ? $skin : 'skin-1';
$snapster_remove_terms = isset( $snapster_remove_terms ) && $snapster_remove_terms ? 'remove-terms' : '';

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt__snapster-slider' );
$this->add_render_attribute( 'wrapper', 'class', $snapster_remove_terms );
$this->add_render_attribute( 'wrapper', 'class', $skin ? 'js-popup-gallery' : '' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'    => 500,
	'autoplay' => 0,
	'spaces'   => 0,
	'loop'   => 0,
];

$carousel_params = Helper::get_carousel_params( $atts, 'snapster_h_swiper_', $carousel_default_params );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'snapster-custom-post-types-layout2', $shortcode_dir . 'assets/css/snapster_layout2.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">

        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>
             data-slides="auto" data-mousewheel="1">

            <div class="swiper-wrapper">

				<?php
				$this->add_excerpt_filter();

				if ( ! empty( $snapster_main_image ) ) { ?>
                    <div class="swiper-slide aheto-cpt__snapster-slider--sticky">
                        <div class="swiper-slide-wrap">
                            <article
                                    class="aheto-cpt-article aheto-cpt-article--masonry aheto-cpt-article--<?php echo esc_attr( $atts['skin'] ); ?>">
                                <div class="aheto-cpt-article__inner">
                                    <div class="aheto-cpt-article__img">
										<?php echo Helper::get_attachment( $snapster_main_image, [], 'large', $atts, 'cpt_' );

										if(!empty($snapster_main_add_image)){
											echo Helper::get_attachment( $snapster_main_add_image, ['class'=>'aheto-cpt-article__add-img'], 'large', $atts, 'cpt_' );
                                        }

										if ( ! empty( $snapster_link_item ) ) { ?>
                                            <a href="<?php echo esc_url( $snapster_link_item ); ?>"
                                               class="aheto-cpt-article__img-link" target="<?php echo esc_attr($target); ?>" <?php echo  esc_attr($rel); ?>></a>
										<?php } ?>
                                    </div>

                                    <div class="aheto-cpt-article__content">
										<?php if ( ! empty( $snapster_subtitle ) ) { ?>
                                            <div class="aheto-cpt-article__terms">
												<?php echo esc_html( $snapster_subtitle ); ?>
                                            </div>
										<?php } ?>

										<?php if ( ! empty( $snapster_title ) ) { ?>
                                            <<?php echo esc_attr($tag); ?> class="aheto-cpt-article__title">
												<?php if ( ! empty( $snapster_link_item ) ) { ?>
                                                    <a href="<?php echo esc_url( $snapster_link_item ); ?>" target="<?php echo esc_attr($target); ?>" <?php echo esc_attr($rel); ?>><?php echo esc_html( $snapster_title ); ?></a>
												<?php } else {
													echo esc_html( $snapster_title );
												} ?>
                                            </<?php echo esc_attr($tag); ?>>
										<?php } ?>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
				<?php }

				while ( $the_query->have_posts() ) :
					$the_query->the_post();

					if ( $counter % 2 != 0 && $counter !== $post_count ) { ?>

                        <div class="swiper-slide">
                        <div class="swiper-slide-wrap">
						<?php $this->get_skin_part( $skin, $atts ); ?>

					<?php } else if ( $counter % 2 == 0 ) { ?>
                        <div class="aheto-cpt__snapster-slider--space"></div>
						<?php $this->get_skin_part( $skin, $atts ); ?>
                        </div>
                        </div>

					<?php } else { ?>

                        <div class="swiper-slide">
                            <div class="swiper-slide-wrap">
								<?php $this->get_skin_part( $skin, $atts ); ?>
                            </div>
                        </div>

					<?php }

					$counter ++;

				endwhile;

				$this->remove_excerpt_filter();

				wp_reset_query();
				?>

            </div>

        </div>

    </div>

</div>
