<?php
use Aheto\Helper;

/**
 * Skin 1.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

$ID = get_the_ID();

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);

if( ! empty( $terms_list ) ) {
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('djo-skin-2', $shortcode_dir . 'assets/css/djo_skin-2.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

	<div class="container">
		<div class="aheto-cpt-article__inner">

			<div class="aheto-cpt-article__left">
				<?php
					if( has_post_thumbnail( $ID ) ) {
						$isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_');
					}
					$this->getTitle();
				?>
			</div>

			<div class="aheto-cpt-article__right">
				<div class="aheto-cpt-article__content">
					<?php
						$terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : '';
						?>

						<div class="aheto-cpt-article__date">
							<?php the_time('j F'); ?>
						</div>
						<?php

						$this->getExcerpt();
						$this->getTerms($atts['terms'], $terms_class);
					?>
					<a href="<?php the_permalink(get_the_ID()); ?>" class="cs-btn aheto-btn--light cs_layout1 aheto-cpt-article__btn">
						<?php _e( 'Show Details', 'djo' ); ?>
					</a>
				</div>
			</div>

		</div>
	</div>

</article>

