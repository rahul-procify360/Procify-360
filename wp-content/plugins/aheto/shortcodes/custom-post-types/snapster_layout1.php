<?php

use Aheto\Helper;

extract($atts);

$atts['layout'] = 'slider';

// Query.
$the_query = $this->get_wp_query();
if (!$the_query->have_posts()) {
    return;
}

// Wrapper.
$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-cpt');
$this->add_render_attribute('wrapper', 'class', 'aheto-cpt--snapster-slider-thumb');
$this->add_render_attribute('wrapper', 'class', 'snapster-full-min-height-js');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 500,
    'autoplay' => 0,
    'spaces' => 0,
    'slides' => 5,
    'arrows' => 1,
    'loop' => 0,
    'slidesPerView' => 5,
    'slidesPerView_lg' => 4,
    'slidesPerView_md' => 3,
    'slidesPerView_sm' => 2,
    'slidesPerView_xs' => 1,
];

$carousel_params = Helper::get_carousel_params($atts, 'snapster_swiper_', $carousel_default_params);

$snapster_swiper_autoplay = isset($snapster_swiper_autoplay) && !empty($snapster_swiper_autoplay) ? $snapster_swiper_autoplay : 0;

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('snapster-custom-post-types-layout1', $shortcode_dir . 'assets/css/snapster_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('snapster-custom-post-types-layout1-js', $shortcode_dir . 'assets/js/snapster_layout1.js', array('jquery'), null);
} ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="swiper swiper-bottom">
        <div class="thumbs_switcher_wrap">
            <h2><i class="icon ion-android-apps js-thumbs-switcher" aria-hidden="true"></i></h2>
        </div>
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?> data-centeredSlides="1"
             data-simulate_touch="1" data-loop="1">
            <div class="swiper-wrapper">
                <?php $this->add_excerpt_filter();

                while ($the_query->have_posts()) :
                    $the_query->the_post();

                    $has_thumb = has_post_thumbnail();
                    $post_image_id = get_post_thumbnail_id();
                    $image = array();
                    $image['id'] = $post_image_id;

                    $background_image = $has_thumb && !empty($image['id']) ? Helper::get_background_attachment($image, 'large', $atts, '') : ''; ?>

                    <div class="swiper-slide" <?php echo esc_attr($background_image); ?>>
                        <div class="aheto-cpt--slider-content"></div>
                    </div>
                <?php endwhile;

                $this->remove_excerpt_filter();

                wp_reset_query(); ?>

            </div>
        </div>
        <?php $this->swiper_arrow('snapster_swiper_'); ?>
    </div>

    <div class="swiper swiper-top">
        <div class="swiper-container" data-thumbs="1" data-slides="1" data-effect="fade" data-autoplay="<?php echo esc_attr($snapster_swiper_autoplay); ?>>">
            <div class="swiper-wrapper">


                <?php $this->add_excerpt_filter();

                while ($the_query->have_posts()) :
                    $the_query->the_post();

                    $has_thumb = has_post_thumbnail();
                    $post_image_id = get_post_thumbnail_id();
                    $image = array();
                    $image['id'] = $post_image_id;

                    $background_image = $has_thumb && !empty($image['id']) ? Helper::get_background_attachment($image, 'full', $atts, '') : ''; ?>

                    <div class="swiper-slide" <?php echo esc_attr($background_image); ?>>
                        <div class="aheto-cpt--slider-content">
                            <div class="aheto-cpt--slider-content__text">
                                <?php $this->getTerms($atts['terms'], '', ', '); ?>
                                <?php $this->getTitle(); ?>
                            </div>
                            <div class="aheto-cpt--slider-content__link">
                                <?php if (isset($snapster_view_more_btn) && !empty($snapster_view_more_btn)) { ?>
                                    <a href="<?php the_permalink(); ?>" class="aheto-cpt--btn" target="_self"><?php echo esc_html($snapster_view_more_btn); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile;

                $this->remove_excerpt_filter();

                wp_reset_query(); ?>

            </div>
        </div>
    </div>

</div>
