<?php
/**
 * Skin 1.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

$ID = get_the_ID();
global $product;

$karma_education_terms = [];
$classes               = [];
$classes[]             = 'aheto-cpt-article';
$classes[]             = 'aheto-cpt-article--' . $atts['layout'];
$classes[]             = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[]             = 'aheto-cpt-article--' . $atts['skin'];
$img_class             = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if ( $terms_list ) {
	foreach ( $terms_list as $term ) {
		$classes[]               = 'filter-' . $term->slug;
		$karma_education_terms[] = $term->name;
	}
}


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_education-skin-1', $shortcode_dir . 'assets/css/karma_education_skin-1.css', null, null);
}

$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<div class="aheto-cpt-article__inner">
		<div class="aheto-cpt-article__top">
			<?php if ( has_post_thumbnail($ID) ) {
				$isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_');
			} ?>
			<?php if ( !is_admin() && function_exists('WC') ) : ?>
				<div class="aheto-cpt-article__price"><?php wc_get_template('loop/price.php'); ?></div>
			<?php endif; ?>
			<div class="aheto-cpt-article__links">
				<a href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Buy Now', 'karma'); ?></a>
			</div>
		</div>

		<div class="aheto-cpt-article__content">
			<?php
			$this->getTitle(); ?>
			<div class="aheto-cpt-article__author">
				<?php the_author(); ?>
			</div>

			<div class="aheto-cpt-article__footer">
				<?php if ( !is_admin() && function_exists('WC') ) : ?>
					<div class="aheto-cpt-article__comment">
						<i class="icon ion-android-textsms"></i>
						<span><?php echo get_comments_number($ID); ?></span>
					</div>
				<?php endif; ?>

				<?php if ( !is_admin() && function_exists('WC') ) :

					if ( $average = $product->get_average_rating() ) : ?>
						<?php echo '<div class="star-rating" title="' . sprintf(esc_html__('Rated %s out of 5', 'woocommerce'), $average) . '"><span style="width:' . (($average / 5) * 100) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . esc_html__('out of 5', 'woocommerce') . '</span></div>'; ?>
					<?php endif; ?>
				<?php endif; ?>

			</div>
		</div>
	</div>
</article>

