<?php

use Aheto\Helper;

$ID = get_the_ID();

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);

if ( isset($terms_list) && !empty($terms_list) ) {
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}

$tag = isset($atts['title_tag']) && !empty($atts['title_tag']) ? $atts['title_tag'] : 'h5';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma-construction-skin-2', $shortcode_dir . 'assets/css/karma_construction_skin-2.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<div class="aheto-cpt-article__inner">
		<?php $isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_'); ?>
		<div class="aheto-cpt-article__content">
			<?php $this->getDate(); ?>
			<?php echo '<' . $tag . ' class="aheto-cpt-article__title">'; ?>
			<a href="<?php the_permalink(); ?>">
				<?php $title = get_the_title();
				echo $title; ?>
			</a>
			<?php echo '</' . $tag . '>'; ?>
		</div>
	</div>
</article>
