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

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('acacio-skin-6', $shortcode_dir . 'assets/css/acacio_skin-6.css', null, null);
} ?>


<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<div class="aheto-cpt-article__inner">
        <?php if ( has_post_thumbnail() ) :
            $post_image = Helper::get_background_attachment( get_post_thumbnail_id() );
        endif;

        ?>
        <div class="aheto-cpt-article__img" <?php echo esc_attr($post_image); ?>>

		<a href="<?php the_permalink(); ?>" class="aheto-cpt-article__link"></a>

		<div class="aheto-cpt-article__content">

            <?php if ( !empty($terms_list) ) : ?>

                <p class="aheto-cpt-article__terms"><?php echo esc_html($terms_list[0]->name); ?></p>
            <?php endif; ?>

            <h5 class="aheto-cpt-article__title">
                <?php the_title(); ?>
            </h5>
		</div>
	</div>
</article>

