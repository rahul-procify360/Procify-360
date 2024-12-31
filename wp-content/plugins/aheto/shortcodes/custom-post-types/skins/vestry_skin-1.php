<?php

/**
 * Skin 1.
 *
 */

$ID = get_the_ID();

use Aheto\Helper;

$classes   = [];
$classes[] = 'aheto-cpt-article aheto-cpt-article__vestry-1';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];

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
	wp_enqueue_style('vestry-skin-1', $shortcode_dir . 'assets/css/vestry_skin-1.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

	<div class="aheto-cpt-article__inner">

		<div class="aheto-cpt-article__content">
			<div class="aheto-cpt-article__date">
				<span><?php the_time('M j'); ?></span>
			</div>
			<?php
			$this->getTitle();
			$this->getExcerpt();
			?>
			<?php if (!empty($atts['vestry_link_text'])) { ?>
				<div class="aheto-cpt-article__link">
					<a href="<?php the_permalink(); ?>" class="aheto-link aheto-btn--primary aheto-btn--no-underline">
						<?php echo esc_html($atts['vestry_link_text']); ?>
					</a>
				</div>
			<?php } ?>
		</div>

	</div>

</article>
