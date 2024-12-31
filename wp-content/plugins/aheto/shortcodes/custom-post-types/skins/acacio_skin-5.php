<?php

use Aheto\Helper;

$ID = get_the_ID();


$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
foreach ( $terms_list as $term ) {
    $classes[] = 'filter-' . $term->slug;
}
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('acacio-skin-5', $shortcode_dir . 'assets/css/acacio_skin-5.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

    <div class="aheto-cpt-article__inner">

        <?php if ( has_post_thumbnail() ) { ?>

            <div class="aheto-cpt-article__img">
                <?php echo \Aheto\Helper::get_attachment( get_post_thumbnail_id(), ['class' => ''], $atts['cpt_image_size'], true, false, $atts, 'cpt_' ); ?>

                <?php
                    $thumb = get_post_thumbnail_id();
                    $attach = wp_get_attachment_image_src($thumb, 'full'); ?>

                <a class="aheto-cpt-article__link" href="<?php the_permalink(); ?>"></a>
                <a class="aheto-cpt-article__popup js-popup-gallery-link" data-title="<?php the_title(); ?>"
                   href="<?php echo esc_url($attach[0]); ?>">
                    <i class="icon ion-ios-search-strong" aria-hidden="true"></i>
                </a>
            </div>

        <?php } ?>

    </div>

</article>

