<?php

use Aheto\Helper;

$ID = get_the_ID();


$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $atts['layout'] === 'grid' ? 'aheto-cpt-article--static' : '';
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);

if(isset($terms_list) && !empty($terms_list)){
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}

$hide_thumb = $atts['hryzantema_hide_thumbnail'] ? 'hide-thumb' : '';
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-custom-post-types-skin-1', $shortcode_dir . 'assets/css/hryzantema_skin-1.css', null, null);
}
?>


<article class="aheto-cpt-article__post <?php echo esc_attr(implode(' ', $classes)); ?> <?php echo esc_attr($hide_thumb); ?>">
    <div class="aheto-cpt-article__inner">
        <?php $post_image =  has_post_thumbnail() ?  Helper::get_background_attachment( get_post_thumbnail_id() ) : ''; ?>
        <div class="aheto-cpt-article__img" <?php echo esc_attr($post_image); ?>></div>

        <div class="aheto-cpt-article__content">
            <p class="aheto-cpt-article__date">
                <i class="fa fa-clock-o"></i>
                <?php
				$date = get_option( 'date_format' ) ;
				the_time( $date );
                esc_html_e(' in World', 'hryzantema');
                ?>
            </p>

            <?php $this->getTitle('h4'); ?>

            <div class="aheto-cpt-article__excerpt">
                <?php the_excerpt(); ?>
            </div>

            <div class="aheto-cpt-article__author-meta">
                <?php
				$author_id = get_the_author_meta('ID');
				echo get_avatar($author_id, 35); ?>

                <?php   esc_html_e('by ', 'hryzantema'); echo get_the_author_meta( 'first_name') . ' ' . get_the_author_meta( 'last_name');  ?>
            </div>

        </div>
    </div>


</article>

