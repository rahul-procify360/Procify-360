<?php
/**
 * Created by PhpStorm.
 * User: yurii_oliiarnyk
 * Date: 20.08.19
 * Time: 15:21
 */
use Aheto\Helper;
$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--skin-7';
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if ( isset( $terms_list ) && ! empty( $terms_list ) ) {
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
	wp_enqueue_style('cpt-7', $sc_dir . 'assets/css/skin-7.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

	<div class="aheto-cpt-article__inner">

		<?php $this->getImage($img_class, '', $atts['cpt_image_size'], false, true, $atts, 'cpt_'); ?>

		<div class="aheto-cpt-article__content">

			<?php

			$this->getTitle();
			$this->getTerms($atts['terms'], '', ', ');

			?>

		</div>

	</div>

</article>
