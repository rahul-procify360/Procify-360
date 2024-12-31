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
$classes[] = 'aheto-cpt-article--skin-8';
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if ( isset( $terms_list ) && ! empty( $terms_list ) ) {
	foreach ($terms_list as $term) {
		$classes[] = 'filter-' . $term->slug;
	}
}

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' || $atts['layout'] === 'mosaics' ? 'js-bg' : '';

$has_bg = strpos( $img_class, 'js-bg' ) !== false ? true : false;
$bg_class = $has_bg ? 's-back-switch' : '';


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('lightgallery');
	wp_enqueue_style('lightgallery');
	wp_enqueue_style('cpt-8', $sc_dir . 'assets/css/skin-8.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

	<div class="aheto-cpt-article__inner js-aheto-lg">

		<?php if ( has_post_thumbnail() ) {
			$post_image_id = get_post_thumbnail_id();
			$image = array();
			$image['id'] = $post_image_id;

			$background_image = $has_bg ? Helper::get_background_attachment($image, $atts['cpt_image_size'], $atts, 'cpt_') : ''; ?>

			<div class="aheto-cpt-article__img <?php echo esc_attr( $bg_class ); ?>" <?php echo esc_attr( $background_image ); ?>>
				<?php if(!$has_bg){
					echo Helper::get_attachment($image, ['class' => $img_class], $atts['cpt_image_size'], $atts, 'cpt_');
				}

				$attach = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
				<a class="aheto-cpt-article__link" href="<?php the_permalink(); ?>"></a>
				<a class="aheto-cpt-article__popup js-popup-gallery-link" data-title="<?php the_title(); ?>"
				   href="<?php echo esc_url($attach[0]); ?>">
					<i class="icon ion-ios-search-strong" aria-hidden="true"></i>
				</a>
			</div>

		<?php } ?>

		<div class="aheto-cpt-article__content">

			<?php

			$this->getTitle();
			$this->getTerms($atts['terms'], '', ', ');

			?>

		</div>

	</div>

</article>
