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
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
$post_type  = $atts['post_type'];
if ( isset( $terms_list ) && ! empty( $terms_list ) ) {
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-skin-5', $shortcode_dir . 'assets/css/famulus_skin-5.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<div class="aheto-cpt-article__inner">
		<?php if ( has_post_thumbnail($ID) ) {
			$isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts,  'cpt_');
		} ?>
		<?php
		$terms_class = !has_post_thumbnail($ID) ? 'aheto-cpt-article__terms--static' : '';
		?>
		<a href="<?php echo esc_url(get_permalink()) ?>" class="aheto-cpt-article__title-wrap">
			<h5 class="aheto-cpt-article__title">
				<?php echo esc_html(get_the_title()); ?>
			</h5>
		</a>

		<?php
		$taxonomies = get_object_taxonomies($post_type, 'objects');
		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
			if ( $taxonomy_slug != 'post_tag' && $taxonomy_slug != 'post_format' && $taxonomy_slug != 'aheto-portfolio-tag' ) {
				$terms = get_the_terms($ID, $taxonomy_slug);
				if ( !empty($terms) ) {
					echo '<div class="aheto-cpt-article__terms">';
					foreach ( $terms as $term ) { ?>
						<h6 class="aheto-cpt-article__term">
							<?php echo strtolower($term->name); ?>
						</h6>
					<?php }
					echo '</div>';
				}
			}
		} ?>
	</div>
</article>

