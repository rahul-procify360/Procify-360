<?php

/**
 * Sterling news skin 2.
 */
use Aheto\Helper;
$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if (isset($terms_list) && !empty($terms_list)) {
	foreach ($terms_list as $term) {
		$classes[] = 'filter-' . $term->slug;
	}
}

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-skin-2', $sc_dir . 'assets/css/sterling_skin-2.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">
	<div class="aheto-cpt-article__inner">
		<div class="aheto-cpt-article__content-top">
			<?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_'); ?>
			<?php if (!empty($atts['sterling_link_text'])) { ?>
				<div class="aheto-cpt-article__link">
					<a href="<?php the_permalink(); ?>" class="aheto-btn aheto-btn--light">
						<?php echo esc_html($atts['sterling_link_text']); ?>
					</a>
				</div>
			<?php } ?>
		</div>

		<div class="aheto-cpt-article__content">
			<div class="aheto-cpt-article__date">
				<span><?php the_time('d'); ?></span>
				<p><?php the_time('M'); ?></p>
			</div>
			<div class="post-content--right">
				<?php $this->get_template_part('footer'); ?>
				<?php $this->getTitle(); ?>
			</div>
		</div>
	</div>
</article>
