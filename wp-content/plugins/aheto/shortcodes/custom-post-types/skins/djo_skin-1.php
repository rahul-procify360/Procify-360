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
	wp_enqueue_style('djo-skin-1', $shortcode_dir . 'assets/css/djo_skin-1.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

	<div class="aheto-cpt-article__inner">

		<?php
			$isHasThumb = null;
			if( has_post_thumbnail( $ID ) ) {
				$isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_');
			}
		?>

		<div class="aheto-cpt-article__content">
			<?php
				$terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : '';
				?>

				<div class="aheto-cpt-article__date">
					<?php the_time(get_option('date_format')); ?> <?php _e('in World', 'djo'); ?>
				</div>
				<?php
				$this->getTitle();
				$this->getExcerpt();
			?>

			<div class="aheto-cpt-article__author">

				<?php
				$author_id = get_the_author_meta('ID');

				echo get_avatar($author_id, 30);
				echo esc_html__('by ', 'djo') . esc_html(get_the_author()); ?>
			</div>

		</div>

	</div>

</article>

