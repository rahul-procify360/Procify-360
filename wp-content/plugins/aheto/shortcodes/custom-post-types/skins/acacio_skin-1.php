<?php

use Aheto\Helper;

$ID = get_the_ID();


$classes = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $atts['layout'] === 'grid' ? 'aheto-cpt-article--static' : '';
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);

if (isset($terms_list) && !empty($terms_list)) {
	foreach ($terms_list as $term) {
		$classes[] = 'filter-' . $term->slug;
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('acacio-skin-1', $shortcode_dir . 'assets/css/acacio_skin-1.css', null, null);
} ?>


<article class="aheto-cpt-article__post <?php echo esc_attr(implode(' ', $classes)); ?>">

	<?php $post_image = !empty(has_post_thumbnail()) ? Helper::get_background_attachment(get_post_thumbnail_id()) : ''; ?>

	<div class="aheto-cpt-article__img" <?php echo esc_attr($post_image); ?>>
	</div>


	<div class="aheto-cpt-article__content">

		<h4 class="aheto-cpt-article__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h4>
		<p class="aheto-cpt-article__date">
			<?php the_time(get_option('date_format'));
			esc_html_e('in World', 'acacio') ?>
		</p>
		<div class="aheto-cpt-article__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<div class="aheto-cpt-article__author-meta">

			<?php echo get_avatar(get_the_author_meta('ID'), 35); ?>
			<span><?php the_author(); ?></span>

		</div>

	</div>

</article>

