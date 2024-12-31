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
if ( $terms_list ) {
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-skin-2', $shortcode_dir . 'assets/css/famulus_skin-2.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

	<div class="aheto-cpt-article__inner">

		<?php
		if ( has_post_thumbnail($ID) ) {
			$isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_');
		}
		?>

		<div class="aheto-cpt-article__content">
			<?php
			$terms_class = !has_post_thumbnail($ID) ? 'aheto-cpt-article__terms--static' : '';
			?>

			<div class="aheto-cpt-article__date">
				<?php the_time(get_option('date_format')); ?><?php esc_html_e(' in World', 'famulus'); ?>
			</div>
			<?php
			$this->getTitle();
			?>
			<div class="aheto-cpt-article__excerpt">
				<?php echo wp_trim_words(get_the_excerpt(), 15); ?>
			</div>
			<div class="aheto-cpt-article__author">

				<?php
				$author_id = get_the_author_meta('ID');
				$name      = esc_html__('user', 'famulus');

				echo get_avatar($author_id, 30, array('alt' => $name), $name);
				echo esc_html__('by ', 'famulus') . esc_html(get_the_author()); ?>
			</div>
		</div>
	</div>
</article>

