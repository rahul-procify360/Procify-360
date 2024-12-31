<?php

use Aheto\Helper;

extract( $atts );

$atts['layout'] = '3d';

// Query.
$the_query = $this->get_wp_query();

if ( ! $the_query->have_posts() ) {
	return;
}

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

$carousel_params = Helper::get_carousel_params( $atts, 'kunst_swiper_', $carousel_default_params );

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--kunst__3d' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$tag = isset($title_tag) && ! empty( $title_tag) ? $title_tag : 'h4';

$img_class = 'js-bg';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'kunst-custom-post-types-layout10', $shortcode_dir . 'assets/css/kunst_layout10.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script( 'anime' );
	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'kunst-custom-post-types-layout10-js', $shortcode_dir . 'assets/js/kunst_layout10.js', array( 'jquery' ), null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="swiper">

        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>

            <div class="swiper-wrapper">

                <div class="exhibition-wrap">

                    <div class="container-wrap aheto-full-page-height-js">

						<div class="scroller">

						<?php
							$counter = 0;

							$this->add_excerpt_filter();

							while ( $the_query->have_posts() ) :
	                            $the_query->the_post();

								$gallery_list = get_post_meta( get_the_ID(), 'aheto_post_gallery', true );

								if ( isset( $gallery_list ) && ! empty( $gallery_list ) ) {

									if ( count($gallery_list) >= 8 ) {
	                                    $class = $counter == 0 ? 'room--current' : '';
                                    ?>

	                                <div class="room <?php echo esc_attr($class); ?>">

	                                    <?php if ( ! empty( $gallery_list ) && count( $gallery_list ) >= 8 ) {
	                                        $images = array_slice($gallery_list, 0, 9); ?>

											<div class="room__side room__side--back">
												<a href="<?php echo esc_url(get_permalink());?>">
	                                                <img class="room__img" src="<?php echo esc_url($images[0]); ?>" alt="..."/>
	                                            </a>
	                                            <a href="<?php echo esc_url(get_permalink());?>">
	                                                <img class="room__img" src="<?php echo esc_url($images[1]); ?>" alt="..."/>
	                                            </a>
	                                        </div>

	                                        <div class="room__side room__side--left">
	                                            <a href="<?php echo esc_url(get_permalink());?>">
	                                                <img class="room__img" src="<?php echo esc_url($images[2]); ?>" alt="..."/>
	                                            </a>
	                                            <a href="<?php echo esc_url(get_permalink());?>">
	                                                <img class="room__img" src="<?php echo esc_url($images[3]); ?>" alt="..."/>
	                                            </a>
	                                            <a href="<?php echo esc_url(get_permalink());?>">
	                                                <img class="room__img" src="<?php echo esc_url($images[4]); ?>" alt="..."/>
	                                            </a>
	                                        </div>

	                                        <div class="room__side room__side--right">
	                                            <a href="<?php echo esc_url(get_permalink());?>">
	                                                <img class="room__img" src="<?php echo esc_url($images[5]); ?>" alt="..."/>
	                                            </a>
	                                            <a href="<?php echo esc_url(get_permalink());?>">
	                                                <img class="room__img" src="<?php echo esc_url($images[6]); ?>" alt="..."/>
	                                            </a>
	                                            <a href="<?php echo esc_url(get_permalink());?>">
	                                                <img class="room__img" src="<?php echo esc_url($images[7]); ?>" alt="..."/>
	                                            </a>
	                                        </div>

										<?php } ?>

	                                    <div class="room__side room__side--bottom"></div>

									</div>

								<?php   $counter ++;
									}
								}

	                        endwhile;

	                        $this->remove_excerpt_filter();

	                        wp_reset_query();

						?>

					</div>

				</div>

				<div class="content">

                    <div class="swiper-slide slides">

	                    <?php
	                        $this->add_excerpt_filter();

	                        while ( $the_query->have_posts() ) :
	                            $the_query->the_post();
						?>

	                        <div class="slide">
		                        <span class="cat">
		                            <?php the_excerpt(); ?>
	                            </span>
		                        <a href="<?php echo esc_url(get_permalink());?>" class="slide__name aheto-cpt--info-title aheto-cpt-article__title">
		                            <?php echo the_title(); ?>
		                        </a>
		                        <h3 class="slide__title"></h3>
		                        <p class="slide__date"></p>
		                    </div>

	                    <?php
	                        endwhile;
	                        $this->remove_excerpt_filter();
	                        wp_reset_query();
	                    ?>

                    </div>

                    <nav class="nav">
                        <button class="btn btn--nav btn--nav-left"></button>
                        <button class="btn btn--nav btn--nav-right"></button>
                    </nav>

                </div>

                <div class="overlay overlay--loader overlay--active">

                    <div class="loader">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>

                </div>

			</div>

        </div>

	</div>

</div>
